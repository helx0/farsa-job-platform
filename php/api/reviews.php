<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
configureCors();
require_once '../includes/functions.php';
require_once '../includes/reviews.php';

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;

$review = new Review();

switch ($action) {
    case 'add':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id'])) {
            Response::error('Unauthorized', null, 401);
        }

        $db = Database::getInstance()->getConnection();
        
        if ($_SESSION['user_type'] === 'job_seeker') {
            $reviewType = 'job_seeker';
            $stmt = $db->prepare("SELECT id FROM job_seekers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $seeker = $stmt->get_result()->fetch_assoc();
            if (!$seeker) {
                Response::error('Profile not found');
            }
            $reviewerId = $_SESSION['user_id'];
        } elseif ($_SESSION['user_type'] === 'employer') {
            $reviewType = 'employer';
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $employer = $stmt->get_result()->fetch_assoc();
            if (!$employer) {
                Response::error('Profile not found');
            }
            $reviewerId = $_SESSION['user_id'];
        } else {
            Response::error('Unauthorized', null, 403);
        }

        $reviewedCompanyId = isset($data['reviewed_company_id']) ? (int)$data['reviewed_company_id'] : null;
        $reviewedUserId = isset($data['reviewed_user_id']) ? (int)$data['reviewed_user_id'] : null;

        // Never trust the client to claim a review is verified. Derive verification from
        // an actual application relationship in the database.
        $verifiedApplicant = false;
        if ($reviewType === 'job_seeker' && $reviewedCompanyId) {
            $verify = $db->prepare("
                SELECT 1
                FROM job_applications ja
                INNER JOIN jobs j ON ja.job_id = j.id
                INNER JOIN job_seekers js ON ja.job_seeker_id = js.id
                WHERE js.user_id = ? AND j.employer_id = ?
                LIMIT 1
            ");
            $verify->bind_param('ii', $reviewerId, $reviewedCompanyId);
            $verify->execute();
            $verifiedApplicant = (bool)$verify->get_result()->fetch_assoc();
        } elseif ($reviewType === 'employer' && $reviewedUserId) {
            $verify = $db->prepare("
                SELECT 1
                FROM job_applications ja
                INNER JOIN job_seekers js ON ja.job_seeker_id = js.id
                WHERE js.user_id = ? AND ja.employer_id = ?
                LIMIT 1
            ");
            $verify->bind_param('ii', $reviewedUserId, $employer['id']);
            $verify->execute();
            $verifiedApplicant = (bool)$verify->get_result()->fetch_assoc();
        }

        $reviewData = [
            'reviewer_id' => $reviewerId,
            'reviewer_type' => $reviewType,
            'reviewed_company_id' => $reviewedCompanyId,
            'reviewed_user_id' => $reviewedUserId,
            'rating' => (int)$data['rating'],
            'review_title_ar' => Security::validateInput($data['review_title_ar'] ?? ''),
            'review_title_en' => Security::validateInput($data['review_title_en'] ?? ''),
            'review_text_ar' => $data['review_text_ar'] ?? '',
            'review_text_en' => $data['review_text_en'] ?? '',
            'pros' => $data['pros'] ?? '',
            'cons' => $data['cons'] ?? '',
            'would_recommend' => isset($data['would_recommend']) ? (bool)$data['would_recommend'] : false,
            'verified_applicant' => $verifiedApplicant
        ];

        $result = $review->addReview($reviewData);

        if ($result['success']) {
            Response::success($result['message'], $result);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'list':
        $page = (int)($_GET['page'] ?? 1);

        if (isset($_GET['company_id'])) {
            $companyId = (int)$_GET['company_id'];
            $reviews = $review->getCompanyReviews($companyId, $page);
            $stats = $review->getCompanyStats($companyId);
            Response::success('Reviews retrieved', ['reviews' => $reviews, 'stats' => $stats, 'page' => $page]);
        } elseif (isset($_GET['user_id'])) {
            $userId = (int)$_GET['user_id'];
            $reviews = $review->getUserReviews($userId, $page);
            Response::success('Reviews retrieved', ['reviews' => $reviews, 'page' => $page]);
        } else {
            Response::error('Company ID or User ID required');
        }
        break;

    case 'stats':
        if (!isset($_GET['company_id'])) {
            Response::error('Company ID required');
        }

        $companyId = (int)$_GET['company_id'];
        $stats = $review->getCompanyStats($companyId);
        $distribution = $review->getReviewDistribution($companyId);

        Response::success('Stats retrieved', [
            'overall' => $stats,
            'distribution' => $distribution
        ]);
        break;

    case 'pending':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            Response::error('Unauthorized', null, 403);
        }

        $page = (int)($_GET['page'] ?? 1);
        $pendingReviews = $review->getPendingReviews($page);

        Response::success('Pending reviews retrieved', ['reviews' => $pendingReviews, 'page' => $page]);
        break;

    case 'approve':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            Response::error('Unauthorized', null, 403);
        }

        if (!isset($data['review_id'])) {
            Response::error('Review ID required');
        }

        $result = $review->approveReview((int)$data['review_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'reject':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            Response::error('Unauthorized', null, 403);
        }

        if (!isset($data['review_id'])) {
            Response::error('Review ID required');
        }

        $result = $review->rejectReview((int)$data['review_id'], $data['reason'] ?? '');

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'delete':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id'])) {
            Response::error('Unauthorized', null, 401);
        }

        if (!isset($data['review_id'])) {
            Response::error('Review ID required');
        }

        $result = $review->deleteReview((int)$data['review_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
