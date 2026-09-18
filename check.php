<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'helxdb';

$response = [
    'php_version' => phpversion(),
    'mysql' => null,
    'database' => null,
    'tables' => null
];

// اختبر اتصال MySQL
$conn = @mysqli_connect($host, $user, $password);
if ($conn) {
    $response['mysql'] = 'connected';
    
    // اختبر وجود قاعدة البيانات
    $result = @mysqli_query($conn, "SELECT 1 FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$database'");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $response['database'] = 'exists';
        
        // عد الجداول
        @mysqli_select_db($conn, $database);
        $result = @mysqli_query($conn, "SHOW TABLES");
        $response['tables'] = $result ? mysqli_num_rows($result) : 0;
    } else {
        $response['database'] = 'not_found';
    }
    
    mysqli_close($conn);
} else {
    $response['mysql'] = 'failed';
    $response['error'] = mysqli_connect_error();
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
