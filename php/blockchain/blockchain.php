<?php
require_once '../config.php';

class SimpleBlockchain {
    private $blockchain = [];
    private $blockchainFile;

    public function __construct() {
        $this->blockchainFile = BLOCKCHAIN_FILE;
        $this->loadBlockchain();
    }

    private function loadBlockchain() {
        if (file_exists($this->blockchainFile)) {
            $content = file_get_contents($this->blockchainFile);
            $this->blockchain = json_decode($content, true) ?? [];
        }
    }

    private function saveBlockchain() {
        file_put_contents($this->blockchainFile, json_encode($this->blockchain, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function hashData($data) {
        return hash('sha256', json_encode($data));
    }

    public function addCertificateBlock($certificateData) {
        $blockId = count($this->blockchain) + 1;
        $previousHash = !empty($this->blockchain) ? end($this->blockchain)['currentHash'] : '0';

        $blockData = [
            'blockId' => $blockId,
            'certificateId' => $certificateData['certificate_id'],
            'userId' => $certificateData['user_id'],
            'certificateTitle' => $certificateData['certificate_title'],
            'issuer' => $certificateData['issuer'],
            'issueDate' => $certificateData['issue_date'],
            'timestamp' => date('Y-m-d H:i:s'),
            'metadata' => $certificateData['metadata'] ?? []
        ];

        $currentHash = $this->hashData($blockData);

        $block = [
            'blockId' => $blockId,
            'previousHash' => $previousHash,
            'currentHash' => $currentHash,
            'data' => $blockData,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        $this->blockchain[] = $block;
        $this->saveBlockchain();

        return [
            'blockId' => $blockId,
            'hash' => $currentHash,
            'verificationUrl' => SITE_URL . 'pages/verify-certificate.html?hash=' . $currentHash
        ];
    }

    public function verifyCertificateHash($certificateHash) {
        foreach ($this->blockchain as $block) {
            if ($block['currentHash'] === $certificateHash) {
                return [
                    'isValid' => true,
                    'block' => $block,
                    'chainValid' => $this->validateChain()
                ];
            }
        }

        return [
            'isValid' => false,
            'message' => 'الشهادة غير موجودة في السجل'
        ];
    }

    private function validateChain() {
        for ($i = 1; $i < count($this->blockchain); $i++) {
            $currentBlock = $this->blockchain[$i];
            $previousBlock = $this->blockchain[$i - 1];

            if ($currentBlock['previousHash'] !== $previousBlock['currentHash']) {
                return false;
            }

            $recalculatedHash = $this->hashData($currentBlock['data']);
            if ($recalculatedHash !== $currentBlock['currentHash']) {
                return false;
            }
        }

        return true;
    }

    public function getBlockchain() {
        return $this->blockchain;
    }

    public function getBlockCount() {
        return count($this->blockchain);
    }
}

class CertificateManager {
    private $db;
    private $blockchain;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->blockchain = new SimpleBlockchain();
    }

    public function uploadCertificate($userId, $certificateData, $filePath) {
        try {
            $this->db->begin_transaction();

            $verificationHash = $this->blockchain->hashData([
                'user_id' => $userId,
                'certificate_title' => $certificateData['certificate_title'],
                'issuer' => $certificateData['issuer'],
                'issue_date' => $certificateData['issue_date']
            ]);

            $stmt = $this->db->prepare("
                INSERT INTO certificates 
                (user_id, certificate_title_ar, certificate_title_en, issuer_ar, issuer_en, 
                 certificate_file, issue_date, expiry_date, verification_hash)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                'issssssss',
                $userId,
                $certificateData['certificate_title_ar'],
                $certificateData['certificate_title_en'],
                $certificateData['issuer_ar'],
                $certificateData['issuer_en'],
                $filePath,
                $certificateData['issue_date'],
                $certificateData['expiry_date'] ?? null,
                $verificationHash
            );

            if ($stmt->execute()) {
                $certificateId = $this->db->insert_id;

                $blockchainResult = $this->blockchain->addCertificateBlock([
                    'certificate_id' => $certificateId,
                    'user_id' => $userId,
                    'certificate_title' => $certificateData['certificate_title_ar'],
                    'issuer' => $certificateData['issuer_ar'],
                    'issue_date' => $certificateData['issue_date']
                ]);

                $stmt = $this->db->prepare("
                    UPDATE certificates 
                    SET blockchain_hash = ?, blockchain_block_id = ?, verification_url = ?
                    WHERE id = ?
                ");

                $stmt->bind_param(
                    'siss',
                    $blockchainResult['hash'],
                    $blockchainResult['blockId'],
                    $blockchainResult['verificationUrl'],
                    $certificateId
                );

                $stmt->execute();

                $this->db->commit();

                return [
                    'success' => true,
                    'message' => 'تم رفع الشهادة بنجاح',
                    'certificate_id' => $certificateId,
                    'verification_hash' => $verificationHash,
                    'verification_url' => $blockchainResult['verificationUrl']
                ];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function verifyCertificate($hash) {
        $verification = $this->blockchain->verifyCertificateHash($hash);

        if ($verification['isValid']) {
            $certData = $verification['block']['data'];

            $stmt = $this->db->prepare("
                UPDATE certificates 
                SET verification_status = 'verified', blockchain_verified = TRUE
                WHERE blockchain_hash = ?
            ");
            $stmt->bind_param('s', $hash);
            $stmt->execute();

            return [
                'isValid' => true,
                'data' => $certData,
                'chainValid' => $verification['chainValid']
            ];
        }

        return $verification;
    }

    public function getUserCertificates($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM certificates WHERE user_id = ? ORDER BY created_at DESC
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}

?>
