<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';

try {
    // اتصل بدون قاعدة بيانات
    $conn = new mysqli($host, $user, $password);
    
    if ($conn->connect_error) {
        die(json_encode([
            'status' => 'error',
            'message' => 'فشل الاتصال بـ MySQL: ' . $conn->connect_error,
            'step' => 'connection'
        ]));
    }
    
    $conn->set_charset('utf8mb4');
    
    // قراءة ملف قاعدة البيانات
    $sqlFile = __DIR__ . '/database.sql';
    
    if (!file_exists($sqlFile)) {
        die(json_encode([
            'status' => 'error',
            'message' => 'ملف database.sql غير موجود',
            'path' => $sqlFile
        ]));
    }
    
    $sql = file_get_contents($sqlFile);
    
    // تقسيم الاستعلامات
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $executed = 0;
    $errors = [];
    
    foreach ($statements as $statement) {
        if (empty($statement)) continue;
        
        if (!$conn->query($statement)) {
            $errors[] = 'خطأ: ' . $conn->error;
        } else {
            $executed++;
        }
    }
    
    if (!empty($errors)) {
        echo json_encode([
            'status' => 'warning',
            'message' => 'تم تنفيذ ' . $executed . ' استعلام',
            'executed' => $executed,
            'errors' => $errors
        ]);
    } else {
        // تحقق من وجود الجداول
        $result = $conn->query("SELECT COUNT(*) as count FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'helxdb'");
        $row = $result->fetch_assoc();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'تم استيراد قاعدة البيانات بنجاح',
            'tables_created' => $row['count'],
            'statements_executed' => $executed
        ]);
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'استثناء: ' . $e->getMessage()
    ]);
}
?>
