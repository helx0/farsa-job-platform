 <?php
require_once 'php/config.php';

$db = Database::getInstance();
$connection = $db->getConnection();

$result = $connection->query('SELECT id, username, email, user_type, status FROM users WHERE user_type="admin" LIMIT 1');

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo 'Admin user found: ' . json_encode($user, JSON_UNESCAPED_UNICODE) . "\n";
} else {
    echo 'No admin user found' . "\n";
}

// Check total users
$result2 = $connection->query('SELECT COUNT(*) as total FROM users');
if ($result2) {
    $count = $result2->fetch_assoc();
    echo 'Total users in database: ' . $count['total'] . "\n";
}

$db->close();
?>
