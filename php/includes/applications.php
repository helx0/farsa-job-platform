<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/email-service.php';

class Application {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function applyForJob($jobId, $jobSeekerId, $coverLetter = '') {
        try {
            $stmt = $this->db->prepare("
                SELECT employer_id, status FROM jobs WHERE id = ? AND status = 'active'
            ");
            $stmt->bind_param('i', $jobId);
            $stmt->execute();
            $job = $stmt->get_result()->fetch_assoc();

            if (!$job) {
                return ['success' => false, 'message' => 'الوظيفة غير موجودة أو مغلقة'];
            }

            $stmt = $this->db->prepare("
                SELECT id FROM job_applications WHERE job_id = ? AND job_seeker_id = ?
            ");
            $stmt->bind_param('ii', $jobId, $jobSeekerId);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'message' => 'تم تقديم الطلب مسبقاً لهذه الوظيفة'];
            }

            $stmt = $this->db->prepare("
                INSERT INTO job_applications (job_id, job_seeker_id, employer_id, cover_letter, application_status)
                VALUES (?, ?, ?, ?, 'pending')
            ");
            $stmt->bind_param('iis', $jobId, $jobSeekerId, $job['employer_id'], $coverLetter);

            if ($stmt->execute()) {
                $applicationId = $this->db->insert_id;
                
                $this->updateApplicationsCount($jobId);
                $this->calculateMatchScore($applicationId);
                
                $notif = new Notifications();
                $notif->sendNotification(
                    $job['employer_id'],
                    'new_application',
                    'طلب توظيف جديد',
                    'استقبلت طلب توظيف جديد للوظيفة',
                    'New Application',
                    'You received a new job application'
                );

                return ['success' => true, 'message' => 'تم تقديم الطلب بنجاح', 'application_id' => $applicationId];
            }

            return ['success' => false, 'message' => 'حدث خطأ أثناء التقديم'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getApplicationsByJobSeeker($jobSeekerId, $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $stmt = $this->db->prepare("
                SELECT ja.*, j.job_title_ar, j.job_title_en, j.location_city,
                       e.company_name, e.company_logo
                FROM job_applications ja
                LEFT JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN employers e ON ja.employer_id = e.id
                WHERE ja.job_seeker_id = ?
                ORDER BY ja.applied_date DESC
                LIMIT ? OFFSET ?
            ");
            $stmt->bind_param('iii', $jobSeekerId, $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getApplicationsByEmployer($employerId, $page = 1, $filter = 'all') {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $query = "
                SELECT ja.*, j.job_title_ar, j.location_city,
                       u.full_name, u.email, js.current_city
                FROM job_applications ja
                LEFT JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN job_seekers js ON ja.job_seeker_id = js.id
                LEFT JOIN users u ON js.user_id = u.id
                WHERE ja.employer_id = ?
            ";

            if ($filter !== 'all') {
                $query .= " AND ja.application_status = ?";
            }

            $query .= " ORDER BY ja.applied_date DESC LIMIT ? OFFSET ?";

            $stmt = $this->db->prepare($query);
            
            if ($filter !== 'all') {
                $stmt->bind_param('isii', $employerId, $filter, $limit, $offset);
            } else {
                $stmt->bind_param('iii', $employerId, $limit, $offset);
            }

            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateApplicationStatus($applicationId, $status, $notes = '') {
        try {
            $stmt = $this->db->prepare("
                UPDATE job_applications 
                SET application_status = ?, reviewed_date = NOW(), notes = ?
                WHERE id = ?
            ");
            $stmt->bind_param('ssi', $status, $notes, $applicationId);

            if ($stmt->execute()) {
                $this->notifyApplicant($applicationId, $status);
                return ['success' => true, 'message' => 'تم تحديث حالة الطلب'];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    private function notifyApplicant($applicationId, $status) {
        try {
            $stmt = $this->db->prepare("
                SELECT ja.job_seeker_id, js.user_id, j.job_title_ar
                FROM job_applications ja
                LEFT JOIN job_seekers js ON ja.job_seeker_id = js.id
                LEFT JOIN jobs j ON ja.job_id = j.id
                WHERE ja.id = ?
            ");
            $stmt->bind_param('i', $applicationId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();

            if ($result) {
                $statusMessages = [
                    'shortlisted' => ['تم اختيارك', 'You have been shortlisted'],
                    'interview_scheduled' => ['موعد مقابلة', 'Interview scheduled'],
                    'offered' => ['عرض وظيفة', 'Job offer'],
                    'rejected' => ['تم رفض الطلب', 'Application rejected'],
                ];

                if (isset($statusMessages[$status])) {
                    $notif = new Notifications();
                    $notif->sendNotification(
                        $result['user_id'],
                        'application_status',
                        $statusMessages[$status][0],
                        'حالة طلبك للوظيفة: ' . $result['job_title_ar'],
                        $statusMessages[$status][1],
                        'Job application status updated'
                    );
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function calculateMatchScore($applicationId) {
        try {
            $stmt = $this->db->prepare("
                SELECT ja.job_id, ja.job_seeker_id FROM job_applications WHERE id = ?
            ");
            $stmt->bind_param('i', $applicationId);
            $stmt->execute();
            $app = $stmt->get_result()->fetch_assoc();

            $jobStmt = $this->db->prepare("
                SELECT * FROM jobs WHERE id = ?
            ");
            $jobStmt->bind_param('i', $app['job_id']);
            $jobStmt->execute();
            $job = $jobStmt->get_result()->fetch_assoc();

            $jobSeekerStmt = $this->db->prepare("
                SELECT js.*, u.full_name,
                       GROUP_CONCAT(DISTINCT us.skill_name) as skills,
                       GROUP_CONCAT(DISTINCT ue.job_title_ar) as job_titles
                FROM job_seekers js
                LEFT JOIN users u ON js.user_id = u.id
                LEFT JOIN user_skills us ON u.id = us.user_id
                LEFT JOIN user_experience ue ON u.id = ue.user_id
                WHERE js.id = ?
                GROUP BY js.id
            ");
            $jobSeekerStmt->bind_param('i', $app['job_seeker_id']);
            $jobSeekerStmt->execute();
            $jobSeeker = $jobSeekerStmt->get_result()->fetch_assoc();

            $matcher = new JobMatcher();
            $matchScore = $matcher->calculateMatch($job, $jobSeeker);

            $updateStmt = $this->db->prepare("
                UPDATE job_applications 
                SET match_score = ?, match_details = ?
                WHERE id = ?
            ");
            $details = json_encode($matchScore['details'], JSON_UNESCAPED_UNICODE);
            $score = $matchScore['score'];
            $updateStmt->bind_param('isi', $score, $details, $applicationId);
            $updateStmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function updateApplicationsCount($jobId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobs 
                SET applications_count = (SELECT COUNT(*) FROM job_applications WHERE job_id = ?)
                WHERE id = ?
            ");
            $stmt->bind_param('ii', $jobId, $jobId);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function getApplicationDetails($applicationId) {
        try {
            $stmt = $this->db->prepare("
                SELECT ja.*, j.job_title_ar, j.job_description_ar, j.required_skills,
                       u.full_name, u.email, u.phone,
                       js.current_city, js.experience_years, js.education_level,
                       GROUP_CONCAT(DISTINCT us.skill_name) as skills
                FROM job_applications ja
                LEFT JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN job_seekers js ON ja.job_seeker_id = js.id
                LEFT JOIN users u ON js.user_id = u.id
                LEFT JOIN user_skills us ON u.id = us.user_id
                WHERE ja.id = ?
                GROUP BY ja.id
            ");
            $stmt->bind_param('i', $applicationId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function countApplications($jobSeekerId = null, $employerId = null) {
        try {
            if ($jobSeekerId) {
                $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM job_applications WHERE job_seeker_id = ?");
                $stmt->bind_param('i', $jobSeekerId);
            } elseif ($employerId) {
                $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM job_applications WHERE employer_id = ?");
                $stmt->bind_param('i', $employerId);
            } else {
                return 0;
            }

            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
}

?>
