<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config.php';
require_once '../includes/functions.php';
require_once '../includes/applications.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
if ($data === null) {
    $data = $_REQUEST;
}

if (!isset($_SESSION['user_id'])) {
    if ($action !== 'list' || $action !== 'count') {
        Response::error('Unauthorized', null, 401);
    }
}

$application = new Application();

switch ($action) {
    case 'apply':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if ($_SESSION['user_type'] !== 'job_seeker') {
            Response::error('Only job seekers can apply', null, 403);
        }

        if (!isset($data['job_id'])) {
            Response::error('Job ID required');
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM job_seekers WHERE user_id = ?");
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $seeker = $stmt->get_result()->fetch_assoc();

        if (!$seeker) {
            Response::error('Job seeker profile not found');
        }

        $result = $application->applyForJob(
            (int)$data['job_id'],
            $seeker['id'],
            $_SESSION['user_id'],
            Security::validateInput(isset($data['cover_letter']) ? $data['cover_letter'] : '')
        );

        if ($result['success']) {
            Response::success($result['message'], $result);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'list':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if ($_SESSION['user_type'] === 'job_seeker') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM job_seekers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $seeker = $stmt->get_result()->fetch_assoc();

            if (!$seeker) {
                Response::error('Job seeker profile not found');
            }

            $applications = $application->getApplicationsByJobSeeker($seeker['id'], $page);
        } elseif ($_SESSION['user_type'] === 'employer') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $employer = $stmt->get_result()->fetch_assoc();

            if (!$employer) {
                Response::error('Employer profile not found');
            }

            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
            $applications = $application->getApplicationsByEmployer($employer['id'], $page, $filter);
        } else {
            Response::error('Unauthorized', null, 403);
        }

        Response::success('Applications retrieved', ['applications' => $applications, 'page' => $page]);
        break;

    case 'get':
        if (!isset($_GET['id'])) {
            Response::error('Application ID required');
        }

        $appDetails = $application->getApplicationDetails((int)$_GET['id']);
        if ($appDetails) {
            Response::success('Application retrieved', $appDetails);
        } else {
            Response::error('Application not found', null, 404);
        }
        break;

    case 'update-status':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if ($_SESSION['user_type'] !== 'employer') {
            Response::error('Only employers can update application status', null, 403);
        }

        if (!isset($data['application_id']) || !isset($data['status'])) {
            Response::error('Application ID and status required');
        }

        $validStatuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'interview_scheduled', 'offered', 'accepted', 'declined'];
        if (!in_array($data['status'], $validStatuses)) {
            Response::error('Invalid status');
        }

        $result = $application->updateApplicationStatus(
            (int)$data['application_id'],
            $data['status'],
            Security::validateInput(isset($data['notes']) ? $data['notes'] : '')
        );

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'count':
        $count = 0;

        if ($_SESSION['user_type'] === 'job_seeker') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM job_seekers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $seeker = $stmt->get_result()->fetch_assoc();

            if ($seeker) {
                $count = $application->countApplications($seeker['id'], null);
            }
        } elseif ($_SESSION['user_type'] === 'employer') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $employer = $stmt->get_result()->fetch_assoc();

            if ($employer) {
                $count = $application->countApplications(null, $employer['id']);
            }
        }

        Response::success('Count retrieved', ['count' => $count]);
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
