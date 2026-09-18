<?php
require_once __DIR__ . '/../config.php';

class User {
    private $db;
    private $id;
    private $user_type;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($data) {
        try {
            if (!Security::validatePassword($data['password'])) {
                return ['success' => false, 'message' => 'كلمة المرور ضعيفة'];
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'البريد الإلكتروني غير صحيح'];
            }

            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param('ss', $data['email'], $data['username']);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'message' => 'البريد أو اسم المستخدم موجود بالفعل'];
            }

            $passwordHash = Security::hashPassword($data['password']);
            $verificationToken = Security::generateVerificationToken();

            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password, phone, full_name, user_type, verification_token)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param('sssssss', $data['username'], $data['email'], $passwordHash, 
                            $data['phone'], $data['full_name'], $data['user_type'], $verificationToken);

            if ($stmt->execute()) {
                $userId = $this->db->insert_id;

                if ($data['user_type'] === 'job_seeker') {
                    $stmt = $this->db->prepare("INSERT INTO job_seekers (user_id) VALUES (?)");
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                } elseif ($data['user_type'] === 'employer') {
                    $stmt = $this->db->prepare("
                        INSERT INTO employers (user_id, company_name) VALUES (?, ?)
                    ");
                    $stmt->bind_param('is', $userId, $data['company_name']);
                    $stmt->execute();
                }

                $stmt = $this->db->prepare("
                    INSERT INTO notification_preferences (user_id) VALUES (?)
                ");
                $stmt->bind_param('i', $userId);
                $stmt->execute();

                $this->sendVerificationEmail($data['email'], $verificationToken);

                return ['success' => true, 'message' => 'تم التسجيل بنجاح، تحقق من بريدك الإلكتروني'];
            }

            return ['success' => false, 'message' => 'حدث خطأ أثناء التسجيل'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function login($email, $password) {
        try {
            $clientIp = Security::getClientIp();

            if (Security::isLoginRateLimited($email, $clientIp)) {
                return ['success' => false, 'message' => 'محاولات تسجيل الدخول كثيرة. حاول مرة أخرى بعد قليل'];
            }

            $stmt = $this->db->prepare("
                SELECT id, password, user_type, status, email_verified 
                FROM users WHERE email = ?
            ");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                Security::recordFailedLogin($email, $clientIp);
                return ['success' => false, 'message' => 'البريد أو كلمة المرور غير صحيحة'];
            }

            $user = $result->fetch_assoc();

            if (!Security::verifyPassword($password, $user['password'])) {
                Security::recordFailedLogin($email, $clientIp);
                return ['success' => false, 'message' => 'البريد أو كلمة المرور غير صحيحة'];
            }

            if ($user['status'] === 'suspended') {
                return ['success' => false, 'message' => 'حسابك معطل'];
            }

            if ($user['status'] === 'pending_verification' && !$user['email_verified']) {
                return ['success' => false, 'message' => 'يرجى التحقق من بريدك الإلكتروني أولاً'];
            }

            Security::clearLoginAttempts($email, $clientIp);

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];

            $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->bind_param('i', $user['id']);
            $stmt->execute();

            return ['success' => true, 'message' => 'تم تسجيل الدخول بنجاح', 'user_type' => $user['user_type']];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function verifyEmail($token) {
        try {
            $stmt = $this->db->prepare("
                SELECT id FROM users WHERE verification_token = ?
            ");
            $stmt->bind_param('s', $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                return ['success' => false, 'message' => 'الرابط غير صحيح أو منتهي الصلاحية'];
            }

            $user = $result->fetch_assoc();
            $stmt = $this->db->prepare("
                UPDATE users SET email_verified = TRUE, status = 'active', verification_token = NULL 
                WHERE id = ?
            ");
            $stmt->bind_param('i', $user['id']);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'تم التحقق من البريد بنجاح'];
            }

            return ['success' => false, 'message' => 'حدث خطأ أثناء التحقق'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function sendVerificationEmail($email, $token) {
        $verificationUrl = SITE_URL . "pages/auth/verify.html?token=" . $token;
        $subject = "تحقق من بريدك الإلكتروني - " . SITE_NAME;
        $message = "
            <html>
                <body dir='rtl'>
                    <h2>أهلاً بك في " . SITE_NAME . "</h2>
                    <p>يرجى الضغط على الرابط أدناه للتحقق من بريدك الإلكتروني:</p>
                    <a href='" . $verificationUrl . "'>تحقق من البريد</a>
                    <p>الرابط صالح لمدة 24 ساعة</p>
                </body>
            </html>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . SMTP_FROM . "\r\n";

        mail($email, $subject, $message, $headers);
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }
        session_destroy();
        return ['success' => true, 'message' => 'تم تسجيل الخروج بنجاح'];
    }

    public function getUserProfile($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, js.*, us.skill_name, COUNT(DISTINCT us.id) as skills_count
                FROM users u
                LEFT JOIN job_seekers js ON u.id = js.user_id
                LEFT JOIN user_skills us ON u.id = us.user_id
                WHERE u.id = ?
                GROUP BY u.id
            ");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $this->db->begin_transaction();

            $stmt = $this->db->prepare("
                UPDATE users SET full_name = ?, phone = ? WHERE id = ?
            ");
            $stmt->bind_param('ssi', $data['full_name'], $data['phone'], $userId);
            $stmt->execute();

            if (isset($data['headline'])) {
                $stmt = $this->db->prepare("
                    UPDATE job_seekers SET 
                    headline = ?, bio = ?, current_city = ?, experience_years = ?,
                    education_level = ?, employment_type = ?
                    WHERE user_id = ?
                ");
                $stmt->bind_param('sssissi', $data['headline'], $data['bio'], $data['current_city'],
                                $data['experience_years'], $data['education_level'], 
                                $data['employment_type'], $userId);
                $stmt->execute();
            }

            $this->db->commit();
            return ['success' => true, 'message' => 'تم تحديث الملف الشخصي'];
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'حدث خطأ'];
        }
    }

    public function addSkill($userId, $skillName, $proficiencyLevel) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO user_skills (user_id, skill_name, proficiency_level)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE proficiency_level = ?
            ");
            $stmt->bind_param('isss', $userId, $skillName, $proficiencyLevel, $proficiencyLevel);
            $stmt->execute();
            return ['success' => true, 'message' => 'تمت إضافة المهارة'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'حدث خطأ'];
        }
    }
}

class Job {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createJob($data) {
        try {
            $this->db->begin_transaction();

            $stmt = $this->db->prepare("
                INSERT INTO jobs (
                    employer_id, job_title_ar, job_title_en, job_description_ar, 
                    job_description_en, category_id, job_type, salary_min, salary_max,
                    salary_currency, experience_required, education_level, 
                    location_city, remote_work, required_skills, benefits, 
                    number_of_openings, deadline
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                'issssssiiisisibis',
                $data['employer_id'],
                $data['job_title_ar'],
                $data['job_title_en'],
                $data['job_description_ar'],
                $data['job_description_en'],
                $data['category_id'],
                $data['job_type'],
                $data['salary_min'],
                $data['salary_max'],
                $data['salary_currency'],
                $data['experience_required'],
                $data['education_level'],
                $data['location_city'],
                $data['remote_work'],
                $data['required_skills'],
                $data['benefits'],
                $data['number_of_openings'],
                $data['deadline']
            );

            if ($stmt->execute()) {
                $jobId = $this->db->insert_id;

                if (!empty($data['required_skills'])) {
                    $skills = explode(',', $data['required_skills']);
                    foreach ($skills as $skill) {
                        $skill = trim($skill);
                        $skillStmt = $this->db->prepare("
                            INSERT INTO job_required_skills (job_id, skill_name, is_mandatory)
                            VALUES (?, ?, TRUE)
                        ");
                        $skillStmt->bind_param('is', $jobId, $skill);
                        $skillStmt->execute();
                    }
                }

                $this->db->commit();
                return ['success' => true, 'message' => 'تم إنشاء الوظيفة', 'job_id' => $jobId];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
        }
    }

    public function getJobById($jobId) {
        try {
            $stmt = $this->db->prepare("
                SELECT j.*, e.company_name, e.company_logo,
                       COUNT(DISTINCT ja.id) as applications_count
                FROM jobs j
                LEFT JOIN employers e ON j.employer_id = e.id
                LEFT JOIN job_applications ja ON j.id = ja.job_id
                WHERE j.id = ?
                GROUP BY j.id
            ");
            $stmt->bind_param('i', $jobId);
            $stmt->execute();
            $job = $stmt->get_result()->fetch_assoc();

            if ($job) {
                $stmt = $this->db->prepare("
                    SELECT skill_name, skill_level, is_mandatory
                    FROM job_required_skills
                    WHERE job_id = ?
                ");
                $stmt->bind_param('i', $jobId);
                $stmt->execute();
                $job['required_skills_list'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }

            return $job;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function listJobs($filters = [], $page = 1) {
        try {
            $limit = PAGINATION_LIMIT;
            $offset = ($page - 1) * $limit;

            $query = "
                SELECT j.*, e.company_name, e.company_logo,
                       COUNT(DISTINCT ja.id) as applications_count
                FROM jobs j
                LEFT JOIN employers e ON j.employer_id = e.id
                LEFT JOIN job_applications ja ON j.id = ja.job_id
                WHERE j.status = 'active' AND j.deadline > NOW()
            ";

            if (!empty($filters['search'])) {
                $search = '%' . $this->db->real_escape_string($filters['search']) . '%';
                $query .= " AND (j.job_title_ar LIKE '$search' OR j.job_description_ar LIKE '$search')";
            }

            if (!empty($filters['location'])) {
                $query .= " AND j.location_city = '" . Security::sanitizeSQL($filters['location']) . "'";
            }

            if (!empty($filters['job_type'])) {
                $query .= " AND j.job_type = '" . Security::sanitizeSQL($filters['job_type']) . "'";
            }

            if (!empty($filters['category_id'])) {
                $query .= " AND j.category_id = " . (int)$filters['category_id'];
            }

            $query .= " GROUP BY j.id ORDER BY j.featured DESC, j.posted_date DESC LIMIT $offset, $limit";

            $result = $this->db->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function applyForJob($jobId, $jobSeekerId, $coverLetter) {
        try {
            $stmt = $this->db->prepare("
                SELECT employer_id FROM jobs WHERE id = ?
            ");
            $stmt->bind_param('i', $jobId);
            $stmt->execute();
            $job = $stmt->get_result()->fetch_assoc();

            $employerId = $job['employer_id'];

            $stmt = $this->db->prepare("
                INSERT INTO job_applications (job_id, job_seeker_id, employer_id, cover_letter)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param('iiis', $jobId, $jobSeekerId, $employerId, $coverLetter);

            if ($stmt->execute()) {
                $applicationId = $this->db->insert_id;
                $this->calculateMatchScore($applicationId);
                return ['success' => true, 'message' => 'تم تقديم الطلب بنجاح'];
            }

            return ['success' => false, 'message' => 'حدث خطأ'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'خطأ في النظام'];
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

            $job = $this->getJobById($app['job_id']);
            $jobSeeker = $this->getJobSeekerProfile($app['job_seeker_id']);

            $matcher = new JobMatcher();
            $matchScore = $matcher->calculateMatch($job, $jobSeeker);

            $stmt = $this->db->prepare("
                UPDATE job_applications SET match_score = ?, match_details = ? WHERE id = ?
            ");
            $details = json_encode($matchScore['details']);
            $score = $matchScore['score'];
            $stmt->bind_param('isi', $score, $details, $applicationId);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function getJobSeekerProfile($jobSeekerId) {
        try {
            $stmt = $this->db->prepare("
                SELECT js.*, u.full_name, u.email,
                       GROUP_CONCAT(DISTINCT us.skill_name) as skills,
                       GROUP_CONCAT(DISTINCT ue.job_title_ar) as job_titles
                FROM job_seekers js
                LEFT JOIN users u ON js.user_id = u.id
                LEFT JOIN user_skills us ON u.id = us.user_id
                LEFT JOIN user_experience ue ON u.id = ue.user_id
                WHERE js.id = ?
                GROUP BY js.id
            ");
            $stmt->bind_param('i', $jobSeekerId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}

class JobMatcher {
    public function calculateMatch($job, $jobSeeker) {
        if (!$job || !$jobSeeker) {
            return ['score' => 0, 'details' => [], 'explanation' => 'البيانات غير كاملة'];
        }

        $weights = MATCHING_WEIGHTS;
        $scores = [
            'skills' => $this->matchSkills($job, $jobSeeker),
            'experience' => $this->matchExperience($job, $jobSeeker),
            'education' => $this->matchEducation($job, $jobSeeker),
            'location' => $this->matchLocation($job, $jobSeeker),
            'salary' => $this->matchSalary($job, $jobSeeker)
        ];

        $finalScore = 0;
        foreach ($scores as $key => $value) {
            $finalScore += ($value * $weights[$key]);
        }

        $explanation = $this->generateExplanation($scores, $job, $jobSeeker);

        return [
            'score' => min(100, round($finalScore)),
            'details' => $scores,
            'match_percentage' => min(100, round($finalScore)),
            'explanation' => $explanation
        ];
    }

    private function matchSkills($job, $jobSeeker) {
        $requiredSkills = array_filter(array_map('trim', explode(',', $job['required_skills'])));
        $userSkills = $jobSeeker['skills'] ? array_map('trim', explode(',', $jobSeeker['skills'])) : [];

        if (empty($requiredSkills)) return 100;
        if (empty($userSkills)) return 0;

        $matchedSkills = count(array_intersect(array_map('strtolower', $requiredSkills), array_map('strtolower', $userSkills)));
        $score = ($matchedSkills / count($requiredSkills)) * 100;
        
        if ($matchedSkills > 0 && $score < 100) {
            $score += 15;
        }

        return min(100, $score);
    }

    private function matchExperience($job, $jobSeeker) {
        $required = (int)$job['experience_required'];
        $userExp = isset($jobSeeker['experience_years']) ? (int)$jobSeeker['experience_years'] : 0;

        if ($userExp >= $required) {
            return 100;
        }
        if ($required === 0) {
            return 100;
        }

        $score = ($userExp / $required) * 100;
        return max(30, $score);
    }

    private function matchEducation($job, $jobSeeker) {
        if ($job['education_level'] === 'any') {
            return 100;
        }

        $educationLevels = [
            'high_school' => 1,
            'diploma' => 2,
            'bachelor' => 3,
            'master' => 4,
            'phd' => 5
        ];

        $requiredLevel = isset($educationLevels[$job['education_level']]) ? $educationLevels[$job['education_level']] : 0;
        $userLevel = isset($educationLevels[$jobSeeker['education_level']]) ? $educationLevels[$jobSeeker['education_level']] : 0;

        if ($userLevel >= $requiredLevel) {
            return 100;
        }
        if ($requiredLevel === 0) {
            return 100;
        }

        $score = ($userLevel / $requiredLevel) * 100;
        return max(30, $score);
    }

    private function matchLocation($job, $jobSeeker) {
        if ($job['remote_work']) {
            return 100;
        }

        if (!empty($jobSeeker['current_city']) && $jobSeeker['current_city'] === $job['location_city']) {
            return 100;
        }

        $userCities = $jobSeeker['target_cities'] 
            ? array_filter(array_map('trim', explode(',', $jobSeeker['target_cities']))) 
            : [];
            
        if (in_array($job['location_city'], $userCities)) {
            return 100;
        }

        return 40;
    }

    private function matchSalary($job, $jobSeeker) {
        $userMin = (int)(isset($jobSeeker['salary_expectation_min']) ? $jobSeeker['salary_expectation_min'] : 0);
        $userMax = (int)(isset($jobSeeker['salary_expectation_max']) ? $jobSeeker['salary_expectation_max'] : 0);
        $jobMin = (int)(isset($job['salary_min']) ? $job['salary_min'] : 0);
        $jobMax = (int)(isset($job['salary_max']) ? $job['salary_max'] : 0);

        if ($job['salary_hidden']) {
            return 80;
        }
        if ($jobMin === 0 || $userMin === 0) {
            return 90;
        }

        if ($jobMax >= $userMin) {
            if ($jobMin >= $userMin && $jobMax >= $userMin) {
                return 100;
            }
            return 85;
        } elseif ($jobMax >= ($userMin * 0.85)) {
            return 75;
        } elseif ($jobMax >= ($userMin * 0.70)) {
            return 60;
        } else {
            return 40;
        }
    }

    private function generateExplanation($scores, $job, $jobSeeker) {
        $strengths = [];
        $weaknesses = [];

        if ($scores['skills'] >= 80) {
            $strengths[] = 'مهاراتك تطابق المتطلبات بشكل ممتاز';
        } elseif ($scores['skills'] < 40) {
            $weaknesses[] = 'هناك فجوة في المهارات المطلوبة';
        }

        if ($scores['experience'] >= 80) {
            $strengths[] = 'خبرتك كافية لهذه الوظيفة';
        } elseif ($scores['experience'] < 50) {
            $weaknesses[] = 'تحتاج خبرة أكثر في هذا المجال';
        }

        if ($scores['education'] >= 80) {
            $strengths[] = 'مؤهلاتك تفي بمتطلبات الوظيفة';
        }

        if ($scores['location'] >= 90) {
            $strengths[] = 'الموقع مناسب لك';
        } elseif ($scores['location'] < 50) {
            $weaknesses[] = 'قد يكون الموقع بعيداً عن تفضيلاتك';
        }

        if ($scores['salary'] >= 85) {
            $strengths[] = 'الراتب ضمن توقعاتك';
        } elseif ($scores['salary'] < 60) {
            $weaknesses[] = 'الراتب أقل من توقعاتك';
        }

        $explanation = [];
        if (!empty($strengths)) {
            $explanation[] = 'المميزات: ' . implode('، ', $strengths);
        }
        if (!empty($weaknesses)) {
            $explanation[] = 'النقاط: ' . implode('، ', $weaknesses);
        }

        return implode('. ', $explanation);
    }
}

class Notifications {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function sendNotification($userId, $type, $title_ar, $message_ar, $title_en = '', $message_en = '', $relatedJobId = null) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO notifications 
                (recipient_user_id, notification_type, title_ar, message_ar, title_en, message_en, related_job_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param('isssssi', $userId, $type, $title_ar, $message_ar, $title_en, $message_en, $relatedJobId);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getNotifications($userId, $limit = 20) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM notifications
                WHERE recipient_user_id = ?
                ORDER BY created_at DESC
                LIMIT ?
            ");
            $stmt->bind_param('ii', $userId, $limit);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function markAsRead($notificationId, $userId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE notifications
                SET read_status = TRUE, read_at = NOW()
                WHERE id = ? AND recipient_user_id = ?
            ");
            $stmt->bind_param('ii', $notificationId, $userId);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>
