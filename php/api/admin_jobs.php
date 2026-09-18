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
        
        $where = "1=1";
        
        if (!empty($_GET['search'])) {
            $search = Security::sanitizeSQL($_GET['search']);
            $where .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
        }
        
        if (!empty($_GET['status'])) {
            $status = Security::sanitizeSQL($_GET['status']);
            $where .= " AND status = '$status'";
        }
        
        if (!empty($_GET['verification'])) {
            $verification = Security::sanitizeSQL($_GET['verification']);
            $where .= " AND is_verified = '$verification'";
        }
        
        $countResult = $conn->query("SELECT COUNT(*) as total FROM jobs WHERE $where");
        $countRow = $countResult->fetch_assoc();
        $total = $countRow['total'];
        $totalPages = ceil($total / $limit);
        
        $query = "SELECT j.id, j.title, j.description, j.salary_min, j.salary_max, 
                         j.location, j.employment_type, j.status, j.is_featured, 
                         j.is_verified, j.created_at, c.name as company_name
                  FROM jobs j
                  LEFT JOIN companies c ON j.company_id = c.id
                  WHERE $where 
                  ORDER BY j.created_at DESC 
                  LIMIT $offset, $limit";
        
        $result = $conn->query($query);
        $jobs = [];
        
        while ($row = $result->fetch_assoc()) {
            $jobs[] = $row;
        }
        
        Response::success('تم جلب الوظائف بنجاح', [
            'jobs' => $jobs,
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
                $jobId = isset($data['job_id']) ? (int)$data['job_id'] : null;
                if (!$jobId) {
                    Response::error('معرف الوظيفة مفقود', null, 400);
                }
                
                $query = "UPDATE jobs SET is_verified = 1, updated_at = NOW() WHERE id = $jobId";
                
                if ($conn->query($query)) {
                    logActivity('قبول نشر الوظيفة', $jobId, 'verify_job');
                    Response::success('تم قبول الوظيفة بنجاح');
                } else {
                    Response::error('خطأ في قبول الوظيفة', null, 500);
                }
            }
            
            else if ($data['action'] === 'reject') {
                $jobId = isset($data['job_id']) ? (int)$data['job_id'] : null;
                if (!$jobId) {
                    Response::error('معرف الوظيفة مفقود', null, 400);
                }
                
                $query = "UPDATE jobs SET is_verified = 0, updated_at = NOW() WHERE id = $jobId";
                
                if ($conn->query($query)) {
                    logActivity('رفض نشر الوظيفة', $jobId, 'reject_job');
                    Response::success('تم رفض الوظيفة بنجاح');
                } else {
                    Response::error('خطأ في رفض الوظيفة', null, 500);
                }
            }
            
            else if ($data['action'] === 'feature') {
                $jobId = isset($data['job_id']) ? (int)$data['job_id'] : null;
                if (!$jobId) {
                    Response::error('معرف الوظيفة مفقود', null, 400);
                }
                
                $featured = isset($data['featured']) ? (int)$data['featured'] : 1;
                $query = "UPDATE jobs SET is_featured = $featured, updated_at = NOW() WHERE id = $jobId";
                
                if ($conn->query($query)) {
                    $action = $featured ? 'تمييز' : 'إلغاء تمييز';
                    logActivity($action . ' الوظيفة', $jobId, 'feature_job');
                    Response::success('تم ' . $action . ' الوظيفة بنجاح');
                } else {
                    Response::error('خطأ في تمييز الوظيفة', null, 500);
                }
            }
            
            else if ($data['action'] === 'update') {
                $jobId = isset($data['job_id']) ? (int)$data['job_id'] : null;
                if (!$jobId) {
                    Response::error('معرف الوظيفة مفقود', null, 400);
                }
                
                $updates = [];
                
                if (isset($data['title'])) {
                    $title = Security::sanitizeSQL($data['title']);
                    $updates[] = "title = '$title'";
                }
                
                if (isset($data['status'])) {
                    $status = Security::sanitizeSQL($data['status']);
                    $updates[] = "status = '$status'";
                }
                
                if (isset($data['salary_min'])) {
                    $salaryMin = (int)$data['salary_min'];
                    $updates[] = "salary_min = $salaryMin";
                }
                
                if (isset($data['salary_max'])) {
                    $salaryMax = (int)$data['salary_max'];
                    $updates[] = "salary_max = $salaryMax";
                }
                
                if (empty($updates)) {
                    Response::error('لا توجد بيانات للتحديث', null, 400);
                }
                
                $updates[] = "updated_at = NOW()";
                $updateString = implode(', ', $updates);
                
                $query = "UPDATE jobs SET $updateString WHERE id = $jobId";
                if ($conn->query($query)) {
                    logActivity('تحديث بيانات الوظيفة', $jobId, 'update_job');
                    Response::success('تم تحديث الوظيفة بنجاح');
                } else {
                    Response::error('خطأ في تحديث الوظيفة', null, 500);
                }
            }
        } else {
            Response::error('إجراء غير محدد', null, 400);
        }
    }
    
    else if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $jobId = isset($data['job_id']) ? (int)$data['job_id'] : null;
        
        if (!$jobId) {
            Response::error('معرف الوظيفة مفقود', null, 400);
        }
        
        $query = "UPDATE jobs SET status = 'closed', updated_at = NOW() WHERE id = $jobId";
        
        if ($conn->query($query)) {
            logActivity('حذف الوظيفة', $jobId, 'delete_job');
            Response::success('تم حذف الوظيفة بنجاح');
        } else {
            Response::error('خطأ في حذف الوظيفة', null, 500);
        }
    }
    
    else {
        Response::error('طريقة الطلب غير مدعومة', null, 405);
    }
    
} catch (Exception $e) {
    error_log('Admin Jobs API Error: ' . $e->getMessage());
    Response::error('حدث خطأ في الخادم', null, 500);
}

function logActivity($action, $jobId, $type) {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    $actionEscaped = $conn->real_escape_string($action);
    $adminId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    $query = "INSERT INTO activity_logs (admin_id, action, type, job_id, created_at) 
              VALUES ($adminId, '$actionEscaped', '$type', $jobId, NOW())";
    $conn->query($query);
}

?>
