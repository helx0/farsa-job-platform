<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
configureCors();
require_once '../includes/functions.php';
require_once '../includes/messages.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
if ($data === null) {
    $data = $_REQUEST;
}

if (!isset($_SESSION['user_id'])) {
    Response::error('Unauthorized', null, 401);
}

$message = new Message();

switch ($action) {
    case 'send':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['recipient_id']) || !isset($data['message_body'])) {
            Response::error('Recipient ID and message body required');
        }

        $relatedJobId = isset($data['related_job_id']) ? (int)$data['related_job_id'] : null;
        $relatedAppId = isset($data['related_application_id']) ? (int)$data['related_application_id'] : null;

        // If sender is employer, restrict messaging to applicants of their own jobs only
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employer') {
            // must provide either related job or related application
            if (empty($relatedJobId) && empty($relatedAppId)) {
                Response::error('Employers can only message applicants for their own jobs', null, 403);
            }

            $db = Database::getInstance()->getConnection();
            // get employer id
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $emp = $stmt->get_result()->fetch_assoc();
            if (!$emp) {
                Response::error('Employer profile not found', null, 403);
            }
            $employerId = $emp['id'];

            if (!empty($relatedAppId)) {
                // verify application belongs to a job of this employer
                $stmt = $db->prepare("SELECT j.employer_id FROM job_applications a JOIN jobs j ON a.job_id = j.id WHERE a.id = ? LIMIT 1");
                $stmt->bind_param('i', $relatedAppId);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();
                if (!$row || $row['employer_id'] != $employerId) {
                    Response::error('Not authorized to message for this application', null, 403);
                }
            } elseif (!empty($relatedJobId)) {
                $stmt = $db->prepare("SELECT employer_id FROM jobs WHERE id = ? LIMIT 1");
                $stmt->bind_param('i', $relatedJobId);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();
                if (!$row || $row['employer_id'] != $employerId) {
                    Response::error('Not authorized to message for this job', null, 403);
                }
            }
        }

        $messageData = [
            'sender_id' => $_SESSION['user_id'],
            'recipient_id' => (int)$data['recipient_id'],
            'subject' => Security::validateInput(isset($data['subject']) ? $data['subject'] : ''),
            'message_body' => $data['message_body'],
            'related_job_id' => $relatedJobId,
            'related_application_id' => $relatedAppId
        ];

        $result = $message->sendMessage($messageData);

        if ($result['success']) {
            Response::success($result['message'], $result);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'conversation':
        if (!isset($_GET['user_id'])) {
            Response::error('User ID required');
        }

        $otherUserId = (int)$_GET['user_id'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $conversation = $message->getConversation($_SESSION['user_id'], $otherUserId, $page);

        Response::success('Conversation retrieved', ['messages' => $conversation, 'page' => $page]);
        break;

    case 'inbox':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $inbox = $message->getInbox($_SESSION['user_id'], $page);

        Response::success('Inbox retrieved', ['messages' => $inbox, 'page' => $page]);
        break;

    case 'sent':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $sent = $message->getSentMessages($_SESSION['user_id'], $page);

        Response::success('Sent messages retrieved', ['messages' => $sent, 'page' => $page]);
        break;

    case 'unread-count':
        $count = $message->getUnreadCount($_SESSION['user_id']);

        Response::success('Unread count retrieved', ['count' => $count]);
        break;

    case 'mark-read':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $message->markMessageAsRead((int)$data['message_id']);

        Response::success('Message marked as read');
        break;

    case 'delete':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $result = $message->deleteMessage((int)$data['message_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'search':
        if (!isset($_GET['q'])) {
            Response::error('Search query required');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $results = $message->searchMessages($_SESSION['user_id'], $_GET['q'], $page);

        Response::success('Search results', ['messages' => $results, 'page' => $page]);
        break;

    case 'pin':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $result = $message->pinMessage((int)$data['message_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'unpin':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $result = $message->unpinMessage((int)$data['message_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'archive':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $result = $message->archiveMessage((int)$data['message_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'mark-important':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['message_id'])) {
            Response::error('Message ID required');
        }

        $result = $message->markAsImportant((int)$data['message_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'archived':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $archived = $message->getArchivedMessages($_SESSION['user_id'], $page);

        Response::success('Archived messages retrieved', ['messages' => $archived, 'page' => $page]);
        break;

    case 'pinned':
        $pinned = $message->getPinnedMessages($_SESSION['user_id']);

        Response::success('Pinned messages retrieved', ['messages' => $pinned]);
        break;

    case 'important':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $important = $message->getImportantMessages($_SESSION['user_id'], $page);

        Response::success('Important messages retrieved', ['messages' => $important, 'page' => $page]);
        break;

    case 'job-related':
        if (!isset($_GET['job_id'])) {
            Response::error('Job ID required');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $jobId = isset($_GET['job_id']) ? (int)$_GET['job_id'] : 0;

        // If employer, verify ownership of the job
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employer') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $emp = $stmt->get_result()->fetch_assoc();
            if (!$emp) { Response::error('Employer profile not found', null, 403); }
            $stmt = $db->prepare("SELECT employer_id FROM jobs WHERE id = ? LIMIT 1");
            $stmt->bind_param('i', $jobId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row || $row['employer_id'] != $emp['id']) {
                Response::error('Not authorized to view messages for this job', null, 403);
            }
        }

        $jobMessages = $message->getJobRelatedMessages($_SESSION['user_id'], $jobId, $page);

        Response::success('Job related messages retrieved', ['messages' => $jobMessages, 'page' => $page]);
        break;

    case 'application-related':
        if (!isset($_GET['application_id'])) {
            Response::error('Application ID required');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $appId = isset($_GET['application_id']) ? (int)$_GET['application_id'] : 0;

        // If employer, verify ownership of the application/job
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'employer') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM employers WHERE user_id = ?");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $emp = $stmt->get_result()->fetch_assoc();
            if (!$emp) { Response::error('Employer profile not found', null, 403); }

            $stmt = $db->prepare("SELECT j.employer_id FROM job_applications a JOIN jobs j ON a.job_id = j.id WHERE a.id = ? LIMIT 1");
            $stmt->bind_param('i', $appId);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row || $row['employer_id'] != $emp['id']) {
                Response::error('Not authorized to view messages for this application', null, 403);
            }
        }

        $appMessages = $message->getApplicationRelatedMessages($_SESSION['user_id'], $appId, $page);

        Response::success('Application related messages retrieved', ['messages' => $appMessages, 'page' => $page]);
        break;

    case 'quick-replies':
        $quickReplies = $message->getQuickReplies($_SESSION['user_id']);
        Response::success('Quick replies retrieved', ['quick_replies' => $quickReplies]);
        break;

    case 'add-quick-reply':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['title']) || !isset($data['content'])) {
            Response::error('Title and content required');
        }

        $result = $message->addQuickReply($_SESSION['user_id'], $data['title'], $data['content']);

        if ($result['success']) {
            Response::success($result['message'], $result);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'delete-quick-reply':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['reply_id'])) {
            Response::error('Reply ID required');
        }

        $result = $message->deleteQuickReply((int)$data['reply_id'], $_SESSION['user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'stats':
        $stats = $message->getConversationStats($_SESSION['user_id']);

        if ($stats['success']) {
            Response::success('Conversation statistics retrieved', $stats);
        } else {
            Response::error('Failed to retrieve statistics', null, 500);
        }
        break;

    case 'block':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['blocked_user_id'])) {
            Response::error('Blocked user ID required');
        }

        $result = $message->blockUser($_SESSION['user_id'], (int)$data['blocked_user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    case 'unblock':
        if ($method !== 'POST') {
            Response::error('Method not allowed', null, 405);
        }

        if (!isset($data['blocked_user_id'])) {
            Response::error('Blocked user ID required');
        }

        $result = $message->unblockUser($_SESSION['user_id'], (int)$data['blocked_user_id']);

        if ($result['success']) {
            Response::success($result['message']);
        } else {
            Response::error($result['message'], null, 400);
        }
        break;

    default:
        Response::error('Invalid action', null, 404);
}

?>
