<?php
require_once 'php/config.php';

$db = Database::getInstance();
$connection = $db->getConnection();

$result = $connection->query("SELECT id, name, email, role FROM users LIMIT 20");

echo "<h2>قائمة المستخدمين</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>رقم</th><th>الاسم</th><th>البريد الإلكتروني</th><th>النوع</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . ($row['role'] === 'employer' ? 'صاحب عمل' : ($row['role'] === 'job_seeker' ? 'باحث وظيفة' : 'مسؤول')) . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
