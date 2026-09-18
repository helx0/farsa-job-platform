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

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;

$job = new Job();
$application = new Application();

if (!isset($_SESSION['user_id'])) {
    if ($action !== 'list' && $action !== 'get') {
        Response::error('Unauthorized', null, 401);
    }
}

switch ($action) {
    case 'create':
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            Response::error('Unauthorized', null, 401);
        }
        if ($_SESSION['user_type'] !== 'employer') {
            Response::error('Only employers can post jobs', null, 403);
        }

        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $employer = $stmt->get_result()->fetch_assoc();

        if (!$employer) {
            Response::error('Employer profile not found');
        }

        $result = $job->createJob([
            'employer_id' => $employer['id'],
            'job_title_ar' => Security::validateInput($data['job_title_ar']),
            'job_title_en' => Security::validateInput($data['job_title_en']),
            'job_description_ar' => $data['job_description_ar'],
            'job_description_en' => $data['job_description_en'],
            'category_id' => (int)$data['category_id'],
            'job_type' => Security::validateInput($data['job_type']),
            'salary_min' => (int)($data['salary_min'] ?? 0),
            'salary_max' => (int)($data['salary_max'] ?? 0),
            'salary_currency' => $data['salary_currency'] ?? 'YER',
            'experience_required' => (int)($data['experience_required'] ?? 0),
            'education_level' => $data['education_level'] ?? 'bachelor',
            'location_city' => Security::validateInput($data['location_city']),
            'remote_work' => (bool)($data['remote_work'] ?? false),
            'required_skills' => $data['required_skills'] ?? '',
            'benefits' => $data['benefits'] ?? '',
            'number_of_openings' => (int)($data['number_of_openings'] ?? 1),
            'deadline' => $data['deadline'] ?? date('Y-m-d', strtotime('+30 days'))
        ]);

        if ($result['success']) {
            Response::success($result['message'], $result);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'list':
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'search' => $_GET['search'] ?? '',
            'location' => $_GET['location'] ?? '',
            'job_type' => $_GET['job_type'] ?? '',
            'category_id' => $_GET['category_id'] ?? ''
        ];

        $jobs = $job->listJobs($filters, $page);
        Response::success('Jobs retrieved', $jobs);
        break;

    case 'get':
        if (!isset($_GET['id'])) {
            Response::error('Job ID required');
        }

        $jobData = $job->getJobById((int)$_GET['id']);
        if ($jobData) {
            Response::success('Job retrieved', $jobData);
        } else {
            Response::error('Job not found', null, 404);
        }
        break;

    case 'apply':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            Response::error('Unauthorized', null, 401);
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

        $result = $job->applyForJob(
            (int)$data['job_id'],
            $seeker['id'],
            Security::validateInput($data['cover_letter'] ?? '')
        );

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'save':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_SESSION['user_id'])) {
            Response::error('Unauthorized', null, 401);
        }

        if (!isset($data['job_id'])) {
            Response::error('Job ID required');
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO saved_jobs (user_id, job_id) VALUES (?, ?)
            ON DUPLICATE KEY UPDATE saved_date = NOW()
        ");
        $stmt->bind_param('ii', $_SESSION['user_id'], $data['job_id']);

        if ($stmt->execute()) {
            Response::success('Job saved');
        } else {
            Response::error('Failed to save job');
        }
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
