<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
configureCors();
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    Response::error('Unauthorized', null, 401);
}

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true) ?? $_REQUEST;

$notifications = new Notifications();

switch ($action) {
    case 'list':
        $limit = (int)($_GET['limit'] ?? 20);
        $notifs = $notifications->getNotifications($_SESSION['user_id'], $limit);
        Response::success('Notifications retrieved', $notifs);
        break;

    case 'read':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($_GET['id'])) {
            Response::error('Notification ID required');
        }

        $result = $notifications->markAsRead((int)$_GET['id']);
        if ($result) {
            Response::success('Notification marked as read');
        } else {
            Response::error('Failed to update notification');
        }
        break;

    case 'mark-all-read':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE notifications 
            SET read_status = TRUE, read_at = NOW() 
            WHERE recipient_user_id = ? AND read_status = FALSE
        ");
        $stmt->bind_param('i', $_SESSION['user_id']);

        if ($stmt->execute()) {
            Response::success('All notifications marked as read');
        } else {
            Response::error('Failed to update notifications');
        }
        break;

    case 'count-unread':
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT COUNT(*) as count 
            FROM notifications 
            WHERE recipient_user_id = ? AND read_status = FALSE
        ");
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        Response::success('Unread count retrieved', ['count' => $result['count']]);
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
