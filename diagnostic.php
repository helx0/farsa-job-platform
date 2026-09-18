<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تشخيص النظام</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .warning { background: #fff3cd; color: #856404; }
        table { border-collapse: collapse; width: 100%; }
        td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <h1>تشخيص النظام</h1>
    
    <h2>1. حالة PHP</h2>
    <div class="status success">
        ✓ PHP Version: <?php echo phpversion(); ?>
    </div>
    
    <h2>2. اتصال MySQL</h2>
    <?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    
    $conn = @mysqli_connect($host, $user, $password);
    
    if ($conn) {
        echo '<div class="status success">✓ MySQL متصل</div>';
        
        // تحقق من وجود قاعدة البيانات
        $result = @mysqli_query($conn, "SHOW DATABASES LIKE 'helxdb'");
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="status success">✓ قاعدة البيانات helxdb موجودة</div>';
            
            // تحقق من الجداول
            mysqli_select_db($conn, 'helxdb');
            $result = @mysqli_query($conn, "SHOW TABLES");
            $tables = mysqli_num_rows($result);
            
            echo '<div class="status success">✓ عدد الجداول: ' . $tables . '</div>';
            
            if ($tables > 0) {
                echo '<table><tr><th>جدول</th></tr>';
                while ($row = mysqli_fetch_row($result)) {
                    echo '<tr><td>' . $row[0] . '</td></tr>';
                }
                echo '</table>';
            }
        } else {
            echo '<div class="status error">✗ قاعدة البيانات helxdb غير موجودة</div>';
            echo '<p><a href="install.php">انقر هنا لإنشاء قاعدة البيانات</a></p>';
        }
        
        mysqli_close($conn);
    } else {
        echo '<div class="status error">✗ فشل الاتصال بـ MySQL</div>';
        echo '<p>خطأ: ' . mysqli_connect_error() . '</p>';
    }
    ?>
    
    <h2>4. صلاحيات المجلدات</h2>
    <?php
    $dirs = [
        'logs',
        'assets/uploads',
        'assets/documents'
    ];
    
    foreach ($dirs as $dir) {
        $path = __DIR__ . '/' . $dir;
        if (is_dir($path)) {
            $perms = substr(sprintf('%o', fileperms($path)), -4);
            echo '<div class="status success">✓ ' . $dir . ' (صلاحيات: ' . $perms . ')</div>';
        } else {
            echo '<div class="status warning">⚠ ' . $dir . ' غير موجود</div>';
        }
    }
?>
</body>
</html>
