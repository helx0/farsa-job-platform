<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'helxdb';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

if ($action === 'login' && $method === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['email'], $data['password'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'البريد وكلمة المرور مطلوبة'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $conn = @mysqli_connect($host, $user, $password, $database);
    
    if (!$conn) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'خطأ في الاتصال بقاعدة البيانات'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    mysqli_set_charset($conn, 'utf8mb4');
    
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = $data['password'];
    
    $query = "SELECT id, password, user_type FROM users WHERE email = '$email' LIMIT 1";
    $result = @mysqli_query($conn, $query);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'البريد أو كلمة المرور غير صحيحة'
        ], JSON_UNESCAPED_UNICODE);
        mysqli_close($conn);
        exit;
    }
    
    $user = mysqli_fetch_assoc($result);
    
    // التحقق من كلمة المرور
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'البريد أو كلمة المرور غير صحيحة'
        ], JSON_UNESCAPED_UNICODE);
        mysqli_close($conn);
        exit;
    }
    
    // تسجيل الدخول
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_type'] = $user['user_type'];
    
    // تحديث آخر تسجيل دخول
    @mysqli_query($conn, "UPDATE users SET last_login = NOW() WHERE id = {$user['id']}");
    
    mysqli_close($conn);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'تم تسجيل الدخول بنجاح',
        'data' => [
            'user_type' => $user['user_type']
        ]
    ], JSON_UNESCAPED_UNICODE);
    
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ], JSON_UNESCAPED_UNICODE);
}
?>
