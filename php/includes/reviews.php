<?php
require_once __DIR__ . '/../config.php';

class Review {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addReview($data) {
        try {
            if ($data['rating'] < 1 || $data['rating'] > 5) {
                return ['success' => false, 'message' => 'التقييم يجب أن يكون بين 1 و 5'];
            }

            $stmt = $this->db->prepare("
                INSERT INTO reviews (
                    reviewer_id, reviewer_type, reviewed_company_id, reviewed_user_id,
                    rating, review_title_ar, review_title_en, review_text_ar, review_text_en,
                    pros, cons, would_recommend, verified_applicant
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                'isiiisssssii',
                $data['reviewer_id'],
                $data['reviewer_type'],
                $data['reviewed_company_id'],
                $data['reviewed_user_id'],
                $data['rating'],
                $data['review_title_ar'],
                $data['review_title_en'],
                $data['review_text_ar'],
                $data['review_text_en'],
                $data['pros'],
                $data['cons'],
                $data['would_recommend'],
                $data['verified_applicant']
            );

            if ($stmt->execute()) {
                $reviewId = $this->db->insert_id;
                return ['success' => true, 'message' => 'تم إضافة التقييم بنجاح', 'review_id' => $reviewId];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getCompanyReviews($companyId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT r.*, u.full_name, u.profile_image
                FROM reviews r
                LEFT JOIN users u ON r.reviewer_id = u.id
                WHERE r.reviewed_company_id = ? AND r.status = 'approved'
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iii', $companyId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getCompanyStats($companyId) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    COUNT(*) as total_reviews,
                    ROUND(AVG(rating), 1) as average_rating,
                    SUM(CASE WHEN would_recommend = TRUE THEN 1 ELSE 0 END) as recommended_count,
                    SUM(CASE WHEN verified_applicant = TRUE THEN 1 ELSE 0 END) as verified_reviews
                FROM reviews
                WHERE reviewed_company_id = ? AND status = 'approved'
            ");
            $stmt->bind_param('i', $companyId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getUserReviews($userId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT r.*, u.full_name
                FROM reviews r
                LEFT JOIN users u ON r.reviewer_id = u.id
                WHERE r.reviewed_user_id = ? AND r.status = 'approved'
                ORDER BY r.created_at DESC
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

    public function approveReview($reviewId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE reviews SET status = 'approved' WHERE id = ?
            ");
            $stmt->bind_param('i', $reviewId);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم قبول التقييم'];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function rejectReview($reviewId, $reason = '') {
        try {
            $stmt = $this->db->prepare("
                UPDATE reviews SET status = 'rejected' WHERE id = ?
            ");
            $stmt->bind_param('i', $reviewId);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم رفض التقييم'];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getPendingReviews($page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT r.*, u.full_name, e.company_name
                FROM reviews r
                LEFT JOIN users u ON r.reviewer_id = u.id
                LEFT JOIN employers e ON r.reviewed_company_id = e.id
                WHERE r.status = 'pending'
                ORDER BY r.created_at ASC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('ii', $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function deleteReview($reviewId, $userId) {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM reviews WHERE id = ? AND reviewer_id = ?
            ");
            $stmt->bind_param('ii', $reviewId, $userId);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم حذف التقييم'];
            }

            return ['success' => false, 'message' => 'لا يمكنك حذف هذا التقييم'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getReviewDistribution($companyId) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    rating,
                    COUNT(*) as count,
                    ROUND(COUNT(*) * 100 / (SELECT COUNT(*) FROM reviews WHERE reviewed_company_id = ?), 1) as percentage
                FROM reviews
                WHERE reviewed_company_id = ? AND status = 'approved'
                GROUP BY rating
                ORDER BY rating DESC
            ");
            $stmt->bind_param('ii', $companyId, $companyId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}

?>
