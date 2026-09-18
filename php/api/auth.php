<?php
try {
    require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
configureCors();
    require_once '../includes/functions.php';
} catch (Exception $e) {
    http_response_code(500);
    error_log('Authentication API bootstrap error: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'خطأ في تهيئة النظام'
    ]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];
$json_input = file_get_contents('php://input');
$data = json_decode($json_input, true);
if (!$data) {
    $data = $_POST;
}

$user = new User();

switch ($action) {
    case 'register':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['username'], $data['email'], $data['password'], $data['user_type'])) {
            Response::error('Missing required fields');
        }

        $result = $user->register([
            'username' => Security::validateInput($data['username']),
            'email' => Security::validateInput($data['email'], 'email'),
            'password' => $data['password'],
            'phone' => isset($data['phone']) ? $data['phone'] : '',
            'full_name' => isset($data['full_name']) ? $data['full_name'] : '',
            'user_type' => $data['user_type'],
            'company_name' => isset($data['company_name']) ? $data['company_name'] : ''
        ]);

        if ($result['success']) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param('s', $data['email']);
            $stmt->execute();
            $userResult = $stmt->get_result();
            if ($userResult->num_rows > 0) {
                $newUser = $userResult->fetch_assoc();
                $_SESSION['user_id'] = $newUser['id'];
                $_SESSION['user_type'] = $data['user_type'];
            }
            Response::success($result['message'], ['user_type' => $data['user_type']]);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'login':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['email'], $data['password'])) {
            Response::error('Missing email or password');
        }

        $result = $user->login(
            Security::validateInput($data['email'], 'email'),
            $data['password']
        );

        if ($result['success']) {
            Response::success($result['message'], ['user_type' => $result['user_type']]);
        } else {
            Response::error($result['message'], null, 401);
        }
        break;

    case 'verify-email':
        if (!isset($_GET['token'])) {
            Response::error('Missing token');
        }

        $result = $user->verifyEmail($_GET['token']);
        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'logout':
        $result = $user->logout();
        Response::success($result['message']);
        break;

    case 'check-session':
        if ($user->isLoggedIn()) {
            Response::success('User logged in', ['user_id' => $_SESSION['user_id']]);
        } else {
            Response::error('Not logged in', null, 401);
        }
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
