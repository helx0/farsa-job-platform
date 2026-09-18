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

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($action) {
    case 'jobs':
        $jobs = searchJobs();
        Response::success('Jobs found', $jobs);
        break;

    case 'candidates':
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
            Response::error('Unauthorized', null, 401);
        }
        $candidates = searchCandidates();
        Response::success('Candidates found', $candidates);
        break;

    case 'companies':
        $companies = searchCompanies();
        Response::success('Companies found', $companies);
        break;

    case 'suggestions':
        if (!isset($_SESSION['user_id'])) {
            Response::error('Unauthorized', null, 401);
        }
        $suggestions = getSearchSuggestions($_GET['q'] ?? '');
        Response::success('Suggestions', $suggestions);
        break;

    default:
        Response::error('Invalid action', null, 404);
}

function searchJobs() {
    $db = Database::getInstance()->getConnection();
    
    $search = Security::validateInput($_GET['search'] ?? '');
    $location = Security::validateInput($_GET['location'] ?? '');
    $jobType = Security::validateInput($_GET['job_type'] ?? '');
    $experienceMin = (int)($_GET['experience_min'] ?? 0);
    $experienceMax = (int)($_GET['experience_max'] ?? 100);
    $salaryMin = (int)($_GET['salary_min'] ?? 0);
    $salaryMax = (int)($_GET['salary_max'] ?? 1000000);
    $remote = isset($_GET['remote']) ? (bool)$_GET['remote'] : null;
    $category = (int)($_GET['category'] ?? 0);
    $page = (int)($_GET['page'] ?? 1);
    $sortBy = Security::validateInput($_GET['sort'] ?? 'newest');

    $limit = PAGINATION_LIMIT;
    $offset = ($page - 1) * $limit;

    $query = "
        SELECT j.*, e.company_name, e.company_logo,
               COUNT(DISTINCT ja.id) as applications_count
        FROM jobs j
        LEFT JOIN employers e ON j.employer_id = e.id
        LEFT JOIN job_applications ja ON j.id = ja.job_id
        WHERE j.status = 'active' AND j.deadline > NOW()
    ";

    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $query .= " AND (j.job_title_ar LIKE ? OR j.job_description_ar LIKE ? 
                        OR j.job_title_en LIKE ? OR j.job_description_en LIKE ?)";
    }

    if (!empty($location)) {
        $query .= " AND j.location_city = ?";
    }

    if (!empty($jobType)) {
        $query .= " AND j.job_type = ?";
    }

    if ($category > 0) {
        $query .= " AND j.category_id = ?";
    }

    if ($experienceMin >= 0 || $experienceMax < 100) {
        $query .= " AND j.experience_required BETWEEN ? AND ?";
    }

    if ($salaryMin > 0 || $salaryMax < 1000000) {
        $query .= " AND (j.salary_max >= ? OR j.salary_hidden = TRUE)";
    }

    if ($remote !== null) {
        $query .= " AND j.remote_work = ?";
    }

    $orderBy = match($sortBy) {
        'salary_high' => 'j.salary_max DESC',
        'salary_low' => 'j.salary_min ASC',
        'most_applied' => 'applications_count DESC',
        default => 'j.posted_date DESC',
    };

    $query .= " GROUP BY j.id ORDER BY j.featured DESC, " . $orderBy . " LIMIT ? OFFSET ?";

    $stmt = $db->prepare($query);

    $paramTypes = '';
    $params = [];

    if (!empty($search)) {
        $paramTypes .= 'ssss';
        array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    }

    if (!empty($location)) {
        $paramTypes .= 's';
        array_push($params, $location);
    }

    if (!empty($jobType)) {
        $paramTypes .= 's';
        array_push($params, $jobType);
    }

    if ($category > 0) {
        $paramTypes .= 'i';
        array_push($params, $category);
    }

    if ($experienceMin >= 0 || $experienceMax < 100) {
        $paramTypes .= 'ii';
        array_push($params, $experienceMin, $experienceMax);
    }

    if ($salaryMin > 0 || $salaryMax < 1000000) {
        $paramTypes .= 'i';
        array_push($params, $salaryMin);
    }

    if ($remote !== null) {
        $paramTypes .= 'i';
        array_push($params, $remote ? 1 : 0);
    }

    $paramTypes .= 'ii';
    array_push($params, $limit, $offset);

    $stmt->bind_param($paramTypes, ...$params);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function searchCandidates() {
    $db = Database::getInstance()->getConnection();
    
    $search = Security::validateInput($_GET['search'] ?? '');
    $location = Security::validateInput($_GET['location'] ?? '');
    $experience = (int)($_GET['experience'] ?? 0);
    $education = Security::validateInput($_GET['education'] ?? '');
    $skills = $_GET['skills'] ?? '';
    $page = (int)($_GET['page'] ?? 1);

    $limit = PAGINATION_LIMIT;
    $offset = ($page - 1) * $limit;

    $query = "
        SELECT DISTINCT js.*, u.full_name, u.email, u.profile_image,
               GROUP_CONCAT(DISTINCT us.skill_name) as skills,
               COUNT(DISTINCT us.id) as skills_count
        FROM job_seekers js
        LEFT JOIN users u ON js.user_id = u.id
        LEFT JOIN user_skills us ON u.id = us.user_id
        WHERE u.status = 'active'
    ";

    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $query .= " AND (u.full_name LIKE ? OR js.headline LIKE ?)";
    }

    if (!empty($location)) {
        $query .= " AND (js.current_city = ? OR js.target_cities LIKE ?)";
    }

    if ($experience > 0) {
        $query .= " AND js.experience_years >= ?";
    }

    if (!empty($education)) {
        $query .= " AND js.education_level = ?";
    }

    if (!empty($skills)) {
        $skillsArray = explode(',', $skills);
        $skillsPlaceholders = implode(',', array_fill(0, count($skillsArray), '?'));
        $query .= " AND us.skill_name IN (" . $skillsPlaceholders . ")";
    }

    $query .= " GROUP BY js.id ORDER BY js.created_at DESC LIMIT ? OFFSET ?";

    $stmt = $db->prepare($query);

    $paramTypes = '';
    $params = [];

    if (!empty($search)) {
        $paramTypes .= 'ss';
        array_push($params, $searchTerm, $searchTerm);
    }

    if (!empty($location)) {
        $paramTypes .= 'ss';
        array_push($params, $location, '%' . $location . '%');
    }

    if ($experience > 0) {
        $paramTypes .= 'i';
        array_push($params, $experience);
    }

    if (!empty($education)) {
        $paramTypes .= 's';
        array_push($params, $education);
    }

    if (!empty($skills)) {
        $skillsArray = explode(',', $skills);
        $paramTypes .= str_repeat('s', count($skillsArray));
        array_push($params, ...$skillsArray);
    }

    $paramTypes .= 'ii';
    array_push($params, $limit, $offset);

    if (!empty($params)) {
        $stmt->bind_param($paramTypes, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function searchCompanies() {
    $db = Database::getInstance()->getConnection();
    
    $search = Security::validateInput($_GET['search'] ?? '');
    $industry = Security::validateInput($_GET['industry'] ?? '');
    $size = Security::validateInput($_GET['size'] ?? '');
    $page = (int)($_GET['page'] ?? 1);

    $limit = PAGINATION_LIMIT;
    $offset = ($page - 1) * $limit;

    $query = "
        SELECT e.*, u.full_name,
               COUNT(DISTINCT j.id) as active_jobs,
               ROUND(AVG(r.rating), 1) as average_rating,
               COUNT(DISTINCT r.id) as total_reviews
        FROM employers e
        LEFT JOIN users u ON e.user_id = u.id
        LEFT JOIN jobs j ON e.id = j.employer_id AND j.status = 'active'
        LEFT JOIN reviews r ON e.id = r.reviewed_company_id AND r.status = 'approved'
        WHERE e.verification_status = 'verified' AND u.status = 'active'
    ";

    if (!empty($search)) {
        $searchTerm = '%' . $search . '%';
        $query .= " AND (e.company_name LIKE ? OR e.company_description LIKE ?)";
    }

    if (!empty($industry)) {
        $query .= " AND e.industry = ?";
    }

    if (!empty($size)) {
        $query .= " AND e.company_size = ?";
    }

    $query .= " GROUP BY e.id ORDER BY average_rating DESC, total_reviews DESC LIMIT ? OFFSET ?";

    $stmt = $db->prepare($query);

    $paramTypes = '';
    $params = [];

    if (!empty($search)) {
        $paramTypes .= 'ss';
        array_push($params, $searchTerm, $searchTerm);
    }

    if (!empty($industry)) {
        $paramTypes .= 's';
        array_push($params, $industry);
    }

    if (!empty($size)) {
        $paramTypes .= 's';
        array_push($params, $size);
    }

    $paramTypes .= 'ii';
    array_push($params, $limit, $offset);

    if (!empty($params)) {
        $stmt->bind_param($paramTypes, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getSearchSuggestions($query) {
    $db = Database::getInstance()->getConnection();
    
    if (strlen($query) < 2) {
        return [];
    }

    $searchTerm = $query . '%';
    
    $stmt = $db->prepare("
        (SELECT DISTINCT job_title_ar as suggestion, 'job' as type FROM jobs WHERE job_title_ar LIKE ? LIMIT 5)
        UNION
        (SELECT DISTINCT job_title_en as suggestion, 'job' as type FROM jobs WHERE job_title_en LIKE ? LIMIT 5)
        UNION
        (SELECT DISTINCT company_name as suggestion, 'company' as type FROM employers WHERE company_name LIKE ? LIMIT 5)
        UNION
        (SELECT DISTINCT skill_name as suggestion, 'skill' as type FROM skills_master WHERE skill_name LIKE ? LIMIT 5)
    ");
    
    $stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>
