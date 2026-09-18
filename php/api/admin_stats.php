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
        $stats = [];
        
        // إجمالي المستخدمين
        $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE user_type != 'admin'");
        $row = $result->fetch_assoc();
        $stats['total_users'] = $row['total'];
        
        // المستخدمين النشطين
        $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE status = 'active' AND user_type != 'admin'");
        $row = $result->fetch_assoc();
        $stats['active_users'] = $row['total'];
        
        // المستخدمين الجدد هذا الأسبوع
        $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND user_type != 'admin'");
        $row = $result->fetch_assoc();
        $stats['new_users_week'] = $row['total'];
        
        // إجمالي الشركات
        $result = $conn->query("SELECT COUNT(*) as total FROM companies WHERE is_active = 1");
        $row = $result->fetch_assoc();
        $stats['total_companies'] = $row['total'];
        
        // الشركات المتحققة
        $result = $conn->query("SELECT COUNT(*) as total FROM companies WHERE verification_status = 'verified'");
        $row = $result->fetch_assoc();
        $stats['verified_companies'] = $row['total'];
        
        // الشركات الجديدة
        $result = $conn->query("SELECT COUNT(*) as total FROM companies WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $row = $result->fetch_assoc();
        $stats['new_companies_week'] = $row['total'];
        
        // إجمالي الوظائف
        $result = $conn->query("SELECT COUNT(*) as total FROM jobs");
        $row = $result->fetch_assoc();
        $stats['total_jobs'] = $row['total'];
        
        // الوظائف المنشورة (النشطة)
        $result = $conn->query("SELECT COUNT(*) as total FROM jobs WHERE status = 'active'");
        $row = $result->fetch_assoc();
        $stats['active_jobs'] = $row['total'];
        
        // الوظائف المتحققة
        $result = $conn->query("SELECT COUNT(*) as total FROM jobs WHERE is_verified = 1");
        $row = $result->fetch_assoc();
        $stats['verified_jobs'] = $row['total'];
        
        // الوظائف المميزة
        $result = $conn->query("SELECT COUNT(*) as total FROM jobs WHERE is_featured = 1");
        $row = $result->fetch_assoc();
        $stats['featured_jobs'] = $row['total'];
        
        // الوظائف الجديدة هذا الأسبوع
        $result = $conn->query("SELECT COUNT(*) as total FROM jobs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $row = $result->fetch_assoc();
        $stats['new_jobs_week'] = $row['total'];
        
        // إجمالي الطلبات
        $result = $conn->query("SELECT COUNT(*) as total FROM applications");
        $row = $result->fetch_assoc();
        $stats['total_applications'] = $row['total'];
        
        // الطلبات المقبولة
        $result = $conn->query("SELECT COUNT(*) as total FROM applications WHERE status = 'accepted'");
        $row = $result->fetch_assoc();
        $stats['accepted_applications'] = $row['total'];
        
        // الطلبات المرفوضة
        $result = $conn->query("SELECT COUNT(*) as total FROM applications WHERE status = 'rejected'");
        $row = $result->fetch_assoc();
        $stats['rejected_applications'] = $row['total'];
        
        // معدل الطلبات (نسبة المقبولة من الكلي)
        $acceptanceRate = $stats['total_applications'] > 0 
            ? round(($stats['accepted_applications'] / $stats['total_applications']) * 100, 2) 
            : 0;
        $stats['acceptance_rate'] = $acceptanceRate;
        
        // متوسط الرواتب
        $result = $conn->query("SELECT AVG((salary_min + salary_max) / 2) as avg_salary FROM jobs WHERE salary_min > 0 AND salary_max > 0");
        $row = $result->fetch_assoc();
        $stats['average_salary'] = $row['avg_salary'] ? round($row['avg_salary'], 2) : 0;
        
        // التوزيع حسب نوع التوظيف
        $employmentTypes = [];
        $result = $conn->query("SELECT employment_type, COUNT(*) as count FROM jobs GROUP BY employment_type");
        while ($row = $result->fetch_assoc()) {
            $employmentTypes[$row['employment_type']] = $row['count'];
        }
        $stats['employment_types'] = $employmentTypes;
        
        // أكثر 5 مدن طلباً
        $topCities = [];
        $result = $conn->query("SELECT location, COUNT(*) as count FROM jobs WHERE location IS NOT NULL AND location != '' GROUP BY location ORDER BY count DESC LIMIT 5");
        while ($row = $result->fetch_assoc()) {
            $topCities[] = ['city' => $row['location'], 'count' => $row['count']];
        }
        $stats['top_cities'] = $topCities;
        
        // نسبة المستخدمين حسب النوع
        $userTypes = [];
        $result = $conn->query("SELECT user_type, COUNT(*) as count FROM users WHERE user_type != 'admin' GROUP BY user_type");
        while ($row = $result->fetch_assoc()) {
            $userTypes[$row['user_type']] = $row['count'];
        }
        $stats['user_types'] = $userTypes;
        
        // آخر 10 أنشطة
        $activities = [];
        $result = $conn->query("SELECT id, admin_id, action, type, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 10");
        while ($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
        $stats['recent_activities'] = $activities;
        
        Response::success('تم جلب الإحصائيات بنجاح', $stats);
    }
    
    else {
        Response::error('طريقة الطلب غير مدعومة', null, 405);
    }
    
} catch (Exception $e) {
    error_log('Admin Stats API Error: ' . $e->getMessage());
    Response::error('حدث خطأ في الخادم', null, 500);
}

?>
