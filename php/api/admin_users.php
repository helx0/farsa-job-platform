<?php
include '../config.php';

header('Content-Type: application/json; charset=utf-8');
configureCors();
requireAdminAccess();

$method = $_SERVER['REQUEST_METHOD'];
$db = Database::getInstance();
$conn = $db->getConnection();

try {
    if ($method === 'GET') {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $filters = [];
        $where = "1=1";
        
        if (!empty($_GET['search'])) {
            $search = Security::sanitizeSQL($_GET['search']);
            $where .= " AND (full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
        }
        
        if (!empty($_GET['status'])) {
            $status = Security::sanitizeSQL($_GET['status']);
            $where .= " AND status = '$status'";
        }
        
        if (!empty($_GET['type'])) {
            $type = Security::sanitizeSQL($_GET['type']);
            $where .= " AND user_type = '$type'";
        }
        
        $countResult = $conn->query("SELECT COUNT(*) as total FROM users WHERE $where");
        $countRow = $countResult->fetch_assoc();
        $total = $countRow['total'];
        $totalPages = ceil($total / $limit);
        
        $query = "SELECT id, full_name, username, email, phone, user_type, status, created_at, updated_at 
                  FROM users 
                  WHERE $where 
                  ORDER BY created_at DESC 
                  LIMIT $offset, $limit";
        
        $result = $conn->query($query);
        $users = [];
        
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        Response::success('تم جلب المستخدمين بنجاح', [
            'users' => $users,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $totalPages
            ]
        ]);
    }
    
    else if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['action'])) {
            if ($data['action'] === 'update') {
                $userId = isset($data['user_id']) ? (int)$data['user_id'] : null;
                if (!$userId) {
                    Response::error('معرف المستخدم مفقود', null, 400);
                }
                
                $updates = [];
                $params = [];
                
                if (isset($data['full_name'])) {
                    $fullName = Security::sanitizeSQL($data['full_name']);
                    $updates[] = "full_name = '$fullName'";
                }
                
                if (isset($data['status'])) {
                    $status = Security::sanitizeSQL($data['status']);
                    $updates[] = "status = '$status'";
                }
                
                if (isset($data['email'])) {
                    $email = Security::sanitizeSQL($data['email']);
                    $updates[] = "email = '$email'";
                }
                
                if (isset($data['phone'])) {
                    $phone = Security::sanitizeSQL($data['phone']);
                    $updates[] = "phone = '$phone'";
                }
                
                if (empty($updates)) {
                    Response::error('لا توجد بيانات للتحديث', null, 400);
                }
                
                $updates[] = "updated_at = NOW()";
                $updateString = implode(', ', $updates);
                
                $query = "UPDATE users SET $updateString WHERE id = $userId";
                if ($conn->query($query)) {
                    logActivity("تحديث بيانات المستخدم", $userId, 'update_user');
                    Response::success('تم تحديث المستخدم بنجاح');
                } else {
                    Response::error('خطأ في تحديث المستخدم', null, 500);
                }
            }
            
            else if ($data['action'] === 'toggle_status') {
                $userId = isset($data['user_id']) ? (int)$data['user_id'] : null;
                if (!$userId) {
                    Response::error('معرف المستخدم مفقود', null, 400);
                }
                
                $newStatus = isset($data['status']) ? Security::sanitizeSQL($data['status']) : 'active';
                $query = "UPDATE users SET status = '$newStatus', updated_at = NOW() WHERE id = $userId";
                
                if ($conn->query($query)) {
                    $statusText = $newStatus === 'active' ? 'تفعيل' : 'تعطيل';
                    logActivity("$statusText المستخدم", $userId, 'toggle_user_status');
                    Response::success("تم $statusText المستخدم بنجاح");
                } else {
                    Response::error('خطأ في تغيير حالة المستخدم', null, 500);
                }
            }
        } else {
            Response::error('إجراء غير محدد', null, 400);
        }
    }
    
    else if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = isset($data['user_id']) ? (int)$data['user_id'] : null;
        
        if (!$userId) {
            Response::error('معرف المستخدم مفقود', null, 400);
        }
        
        $query = "UPDATE users SET status = 'suspended', updated_at = NOW() WHERE id = $userId";
        
        if ($conn->query($query)) {
            logActivity('حذف (تعليق) المستخدم', $userId, 'delete_user');
            Response::success('تم حذف المستخدم بنجاح');
        } else {
            Response::error('خطأ في حذف المستخدم', null, 500);
        }
    }
    
    else {
        Response::error('طريقة الطلب غير مدعومة', null, 405);
    }
    
} catch (Exception $e) {
    error_log('Admin Users API Error: ' . $e->getMessage());
    Response::error('حدث خطأ في الخادم: ' . $e->getMessage(), null, 500);
}

function logActivity($action, $userId, $type) {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $actionEscaped = $conn->real_escape_string($action);
    $adminId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    $query = "INSERT INTO activity_logs (admin_id, action, type, user_id, created_at) 
              VALUES ($adminId, '$actionEscaped', '$type', $userId, NOW())";
    $conn->query($query);
}

?>
