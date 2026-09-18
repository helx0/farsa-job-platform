<?php
include '../config.php';

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$db = Database::getInstance();
$conn = $db->getConnection();

try {
    if ($method === 'GET') {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $where = "1=1";
        
        if (!empty($_GET['search'])) {
            $search = Security::sanitizeSQL($_GET['search']);
            $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
        }
        
        if (!empty($_GET['status'])) {
            $status = Security::sanitizeSQL($_GET['status']);
            $where .= " AND verification_status = '$status'";
        }
        
        $countResult = $conn->query("SELECT COUNT(*) as total FROM companies WHERE $where");
        $countRow = $countResult->fetch_assoc();
        $total = $countRow['total'];
        $totalPages = ceil($total / $limit);
        
        $query = "SELECT id, name, email, phone, website, description, logo, 
                         company_size, location, verification_status, is_active, 
                         created_at, updated_at 
                  FROM companies 
                  WHERE $where 
                  ORDER BY created_at DESC 
                  LIMIT $offset, $limit";
        
        $result = $conn->query($query);
        $companies = [];
        
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }
        
        Response::success('تم جلب الشركات بنجاح', [
            'companies' => $companies,
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
            if ($data['action'] === 'verify') {
                $companyId = isset($data['company_id']) ? (int)$data['company_id'] : null;
                if (!$companyId) {
                    Response::error('معرف الشركة مفقود', null, 400);
                }
                
                $query = "UPDATE companies SET verification_status = 'verified', updated_at = NOW() WHERE id = $companyId";
                
                if ($conn->query($query)) {
                    logActivity('قبول تحقق الشركة', $companyId, 'verify_company');
                    Response::success('تم قبول الشركة بنجاح');
                } else {
                    Response::error('خطأ في قبول الشركة', null, 500);
                }
            }
            
            else if ($data['action'] === 'reject') {
                $companyId = isset($data['company_id']) ? (int)$data['company_id'] : null;
                if (!$companyId) {
                    Response::error('معرف الشركة مفقود', null, 400);
                }
                
                $query = "UPDATE companies SET verification_status = 'rejected', updated_at = NOW() WHERE id = $companyId";
                
                if ($conn->query($query)) {
                    logActivity('رفض تحقق الشركة', $companyId, 'reject_company');
                    Response::success('تم رفض الشركة بنجاح');
                } else {
                    Response::error('خطأ في رفض الشركة', null, 500);
                }
            }
            
            else if ($data['action'] === 'update') {
                $companyId = isset($data['company_id']) ? (int)$data['company_id'] : null;
                if (!$companyId) {
                    Response::error('معرف الشركة مفقود', null, 400);
                }
                
                $updates = [];
                
                if (isset($data['name'])) {
                    $name = Security::sanitizeSQL($data['name']);
                    $updates[] = "name = '$name'";
                }
                
                if (isset($data['email'])) {
                    $email = Security::sanitizeSQL($data['email']);
                    $updates[] = "email = '$email'";
                }
                
                if (isset($data['phone'])) {
                    $phone = Security::sanitizeSQL($data['phone']);
                    $updates[] = "phone = '$phone'";
                }
                
                if (isset($data['website'])) {
                    $website = Security::sanitizeSQL($data['website']);
                    $updates[] = "website = '$website'";
                }
                
                if (isset($data['is_active'])) {
                    $isActive = (int)$data['is_active'];
                    $updates[] = "is_active = $isActive";
                }
                
                if (empty($updates)) {
                    Response::error('لا توجد بيانات للتحديث', null, 400);
                }
                
                $updates[] = "updated_at = NOW()";
                $updateString = implode(', ', $updates);
                
                $query = "UPDATE companies SET $updateString WHERE id = $companyId";
                if ($conn->query($query)) {
                    logActivity('تحديث بيانات الشركة', $companyId, 'update_company');
                    Response::success('تم تحديث الشركة بنجاح');
                } else {
                    Response::error('خطأ في تحديث الشركة', null, 500);
                }
            }
            
            else if ($data['action'] === 'toggle_status') {
                $companyId = isset($data['company_id']) ? (int)$data['company_id'] : null;
                if (!$companyId) {
                    Response::error('معرف الشركة مفقود', null, 400);
                }
                
                $query = "UPDATE companies SET is_active = NOT is_active, updated_at = NOW() WHERE id = $companyId";
                
                if ($conn->query($query)) {
                    logActivity('تغيير حالة الشركة', $companyId, 'toggle_company_status');
                    Response::success('تم تغيير حالة الشركة بنجاح');
                } else {
                    Response::error('خطأ في تغيير حالة الشركة', null, 500);
                }
            }
        } else {
            Response::error('إجراء غير محدد', null, 400);
        }
    }
    
    else if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $companyId = isset($data['company_id']) ? (int)$data['company_id'] : null;
        
        if (!$companyId) {
            Response::error('معرف الشركة مفقود', null, 400);
        }
        
        $query = "UPDATE companies SET is_active = 0, updated_at = NOW() WHERE id = $companyId";
        
        if ($conn->query($query)) {
            logActivity('حذف الشركة', $companyId, 'delete_company');
            Response::success('تم حذف الشركة بنجاح');
        } else {
            Response::error('خطأ في حذف الشركة', null, 500);
        }
    }
    
    else {
        Response::error('طريقة الطلب غير مدعومة', null, 405);
    }
    
} catch (Exception $e) {
    error_log('Admin Companies API Error: ' . $e->getMessage());
    Response::error('حدث خطأ في الخادم', null, 500);
}

function logActivity($action, $companyId, $type) {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $actionEscaped = $conn->real_escape_string($action);
    $adminId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    $query = "INSERT INTO activity_logs (admin_id, action, type, company_id, created_at) 
              VALUES ($adminId, '$actionEscaped', '$type', $companyId, NOW())";
    $conn->query($query);
}

?>
