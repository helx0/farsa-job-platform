<?php
include '../config.php';

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$db = Database::getInstance();
$conn = $db->getConnection();

try {
    if ($method === 'GET') {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 50;
        $offset = ($page - 1) * $limit;
        
        $where = "1=1";
        
        if (!empty($_GET['type'])) {
            $type = Security::sanitizeSQL($_GET['type']);
            $where .= " AND type = '$type'";
        }
        
        if (!empty($_GET['admin_id'])) {
            $adminId = (int)$_GET['admin_id'];
            $where .= " AND admin_id = $adminId";
        }
        
        if (!empty($_GET['date_from'])) {
            $dateFrom = Security::sanitizeSQL($_GET['date_from']);
            $where .= " AND DATE(created_at) >= '$dateFrom'";
        }
        
        if (!empty($_GET['date_to'])) {
            $dateTo = Security::sanitizeSQL($_GET['date_to']);
            $where .= " AND DATE(created_at) <= '$dateTo'";
        }
        
        $countResult = $conn->query("SELECT COUNT(*) as total FROM activity_logs WHERE $where");
        $countRow = $countResult->fetch_assoc();
        $total = $countRow['total'];
        $totalPages = ceil($total / $limit);
        
        $query = "SELECT l.id, l.admin_id, l.action, l.type, l.user_id, l.company_id, l.job_id, 
                         l.created_at, u.full_name as admin_name
                  FROM activity_logs l
                  LEFT JOIN users u ON l.admin_id = u.id
                  WHERE $where 
                  ORDER BY l.created_at DESC 
                  LIMIT $offset, $limit";
        
        $result = $conn->query($query);
        $logs = [];
        
        while ($row = $result->fetch_assoc()) {
            $logs[] = $row;
        }
        
        Response::success('تم جلب السجلات بنجاح', [
            'logs' => $logs,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $totalPages
            ]
        ]);
    }
    
    else if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['action'])) {
            if ($data['action'] === 'clear_all') {
                $query = "DELETE FROM activity_logs";
                
                if ($conn->query($query)) {
                    Response::success('تم حذف جميع السجلات بنجاح');
                } else {
                    Response::error('خطأ في حذف السجلات', null, 500);
                }
            }
            
            else if ($data['action'] === 'clear_by_date') {
                $days = isset($data['days']) ? (int)$data['days'] : 30;
                $query = "DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL $days DAY)";
                
                if ($conn->query($query)) {
                    Response::success('تم حذف السجلات القديمة بنجاح');
                } else {
                    Response::error('خطأ في حذف السجلات', null, 500);
                }
            }
            
            else if ($data['action'] === 'delete_single') {
                $logId = isset($data['log_id']) ? (int)$data['log_id'] : null;
                if (!$logId) {
                    Response::error('معرف السجل مفقود', null, 400);
                }
                
                $query = "DELETE FROM activity_logs WHERE id = $logId";
                
                if ($conn->query($query)) {
                    Response::success('تم حذف السجل بنجاح');
                } else {
                    Response::error('خطأ في حذف السجل', null, 500);
                }
            }
        } else {
            Response::error('إجراء غير محدد', null, 400);
        }
    }
    
    else {
        Response::error('طريقة الطلب غير مدعومة', null, 405);
    }
    
} catch (Exception $e) {
    error_log('Admin Logs API Error: ' . $e->getMessage());
    Response::error('حدث خطأ في الخادم', null, 500);
}

?>
