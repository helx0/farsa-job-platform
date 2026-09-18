<?php
require_once __DIR__ . '/../config.php';

class Message {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function sendMessage($data) {
        try {
            if (empty($data['message_body'])) {
                return ['success' => false, 'message' => 'الرسالة فارغة'];
            }

            if ($data['sender_id'] === $data['recipient_id']) {
                return ['success' => false, 'message' => 'لا يمكنك إرسال رسالة لنفسك'];
            }

            $stmt = $this->db->prepare("
                INSERT INTO messages (
                    sender_id, recipient_id, subject, message_body, 
                    related_job_id, related_application_id, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                'iissii',
                $data['sender_id'],
                $data['recipient_id'],
                $data['subject'],
                $data['message_body'],
                $data['related_job_id'],
                $data['related_application_id']
            );

            if ($stmt->execute()) {
                $messageId = $this->db->insert_id;
                
                $notif = new Notifications();
                $senderName = $this->getUserName($data['sender_id']);
                $notif->sendNotification(
                    $data['recipient_id'],
                    'message',
                    'رسالة جديدة من ' . $senderName,
                    $data['message_body'],
                    'New message from ' . $senderName,
                    $data['message_body']
                );

                return ['success' => true, 'message' => 'تم إرسال الرسالة', 'message_id' => $messageId];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getConversation($userId, $otherUserId, $page = 1) {
        try {
            $limit = 50;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*, 
                       u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? AND m.recipient_id = ?) 
                   OR (m.sender_id = ? AND m.recipient_id = ?)
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiiiii', $userId, $otherUserId, $otherUserId, $userId, $limit, $offset);
            $stmt->execute();
            
            $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
            $this->markAsRead($userId, $otherUserId);
            
            return array_reverse($messages);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getInbox($userId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*,
                       u.full_name, u.profile_image,
                       (SELECT COUNT(*) FROM messages 
                        WHERE recipient_id = ? AND sender_id = m.sender_id AND is_read = FALSE) as unread_count
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE m.recipient_id = ?
                GROUP BY m.sender_id
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiii', $userId, $userId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getSentMessages($userId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*,
                       u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.recipient_id = u.id
                WHERE m.sender_id = ?
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iii', $userId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function markAsRead($userId, $senderId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_read = TRUE, read_at = NOW()
                WHERE recipient_id = ? AND sender_id = ? AND is_read = FALSE
            ");
            $stmt->bind_param('ii', $userId, $senderId);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function markMessageAsRead($messageId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_read = TRUE, read_at = NOW() WHERE id = ?
            ");
            $stmt->bind_param('i', $messageId);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function getUnreadCount($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count FROM messages 
                WHERE recipient_id = ? AND is_read = FALSE
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function deleteMessage($messageId, $userId) {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM messages 
                WHERE id = ? AND (sender_id = ? OR recipient_id = ?)
            ");
            $stmt->bind_param('iii', $messageId, $userId, $userId);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم حذف الرسالة'];
            }

            return ['success' => false, 'message' => 'لا يمكنك حذف هذه الرسالة'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    private function getUserName($userId) {
        try {
            $stmt = $this->db->prepare("SELECT full_name FROM users WHERE id = ?");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['full_name'] ?? 'المستخدم';
        } catch (Exception $e) {
            return 'المستخدم';
        }
    }

    public function searchMessages($userId, $query, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;
            $searchQuery = '%' . $query . '%';

            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.recipient_id = ? OR m.sender_id = ?)
                AND (m.subject LIKE ? OR m.message_body LIKE ?)
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iissii', $userId, $userId, $searchQuery, $searchQuery, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function pinMessage($messageId, $userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_pinned = TRUE 
                WHERE id = ? AND (sender_id = ? OR recipient_id = ?)
            ");
            $stmt->bind_param('iii', $messageId, $userId, $userId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم تثبيت الرسالة'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function unpinMessage($messageId, $userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_pinned = FALSE 
                WHERE id = ? AND (sender_id = ? OR recipient_id = ?)
            ");
            $stmt->bind_param('iii', $messageId, $userId, $userId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم إلغاء تثبيت الرسالة'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function archiveMessage($messageId, $userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_archived = TRUE 
                WHERE id = ? AND (sender_id = ? OR recipient_id = ?)
            ");
            $stmt->bind_param('iii', $messageId, $userId, $userId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم أرشفة الرسالة'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function markAsImportant($messageId, $userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages SET is_important = TRUE 
                WHERE id = ? AND (sender_id = ? OR recipient_id = ?)
            ");
            $stmt->bind_param('iii', $messageId, $userId, $userId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم وضع علامة مهم'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getArchivedMessages($userId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? OR m.recipient_id = ?)
                AND m.is_archived = TRUE
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiii', $userId, $userId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getPinnedMessages($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? OR m.recipient_id = ?)
                AND m.is_pinned = TRUE
                ORDER BY m.created_at DESC
            ");
            $stmt->bind_param('ii', $userId, $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getImportantMessages($userId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? OR m.recipient_id = ?)
                AND m.is_important = TRUE
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiii', $userId, $userId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getJobRelatedMessages($userId, $jobId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? OR m.recipient_id = ?)
                AND m.related_job_id = ?
                AND m.is_archived = FALSE
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiiii', $userId, $userId, $jobId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getApplicationRelatedMessages($userId, $applicationId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT m.*, u.full_name, u.profile_image
                FROM messages m
                LEFT JOIN users u ON m.sender_id = u.id
                WHERE (m.sender_id = ? OR m.recipient_id = ?)
                AND m.related_application_id = ?
                AND m.is_archived = FALSE
                ORDER BY m.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iiiii', $userId, $userId, $applicationId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function addQuickReply($userId, $title, $content) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO quick_replies (user_id, title, content)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param('iss', $userId, $title, $content);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم إضافة الرد السريع', 'id' => $this->db->insert_id];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getQuickReplies($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM quick_replies 
                WHERE user_id = ? AND is_active = TRUE
                ORDER BY usage_count DESC
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function deleteQuickReply($replyId, $userId) {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM quick_replies 
                WHERE id = ? AND user_id = ?
            ");
            $stmt->bind_param('ii', $replyId, $userId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم حذف الرد السريع'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getConversationStats($userId) {
        try {
            $totalUnread = $this->getUnreadCount($userId);
            
            $stmt = $this->db->prepare("
                SELECT COUNT(DISTINCT sender_id) as conversation_count
                FROM messages
                WHERE recipient_id = ?
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            
            return [
                'unread_count' => $totalUnread,
                'conversation_count' => $result['conversation_count'] ?? 0,
                'success' => true
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false];
        }
    }

    public function blockUser($userId, $blockedUserId) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO conversation_settings (user_id, other_user_id, is_blocked)
                VALUES (?, ?, TRUE)
                ON DUPLICATE KEY UPDATE is_blocked = TRUE
            ");
            $stmt->bind_param('ii', $userId, $blockedUserId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم حظر المستخدم'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function unblockUser($userId, $blockedUserId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE conversation_settings 
                SET is_blocked = FALSE
                WHERE user_id = ? AND other_user_id = ?
            ");
            $stmt->bind_param('ii', $userId, $blockedUserId);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم إلغاء حظر المستخدم'];
            }
            return ['success' => false, 'message' => 'خطأ في العملية'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function isUserBlocked($userId, $otherUserId) {
        try {
            $stmt = $this->db->prepare("
                SELECT is_blocked FROM conversation_settings
                WHERE (user_id = ? AND other_user_id = ?) 
                   OR (user_id = ? AND other_user_id = ?)
            ");
            $stmt->bind_param('iiii', $userId, $otherUserId, $otherUserId, $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result && $result['is_blocked'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>
