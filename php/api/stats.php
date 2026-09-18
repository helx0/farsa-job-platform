<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
configureCors();

$db = Database::getInstance()->getConnection();

$stats = [];

$result = $db->query("SELECT COUNT(*) as count FROM users WHERE status = 'active'");
$stats['total_users'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'job_seeker' AND status = 'active'");
$stats['total_job_seekers'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'employer' AND status = 'active'");
$stats['total_employers'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM jobs WHERE status = 'active' AND deadline > NOW()");
$stats['active_jobs'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM jobs");
$stats['total_jobs_posted'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM job_applications");
$stats['total_applications'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM courses WHERE status = 'active'");
$stats['total_courses'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM course_enrollments WHERE is_completed = TRUE");
$stats['completed_courses'] = $result->fetch_assoc()['count'];

$result = $db->query("SELECT COUNT(*) as count FROM certificates WHERE verification_status = 'verified'");
$stats['verified_certificates'] = $result->fetch_assoc()['count'];

Response::success('Statistics retrieved', $stats);

?>
