<?php
require_once __DIR__ . '/../config.php';

class EmailService {
    private $db;
    private $fromEmail;
    private $fromName;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->fromEmail = SMTP_FROM;
        $this->fromName = SITE_NAME;
    }

    public function sendApplicationConfirmation($userId, $jobTitle, $companyName) {
        $user = $this->getUserEmail($userId);
        if (!$user) return false;

        $subject = 'تم تقديم طلبك بنجاح';
        $html = $this->getTemplate('application-confirmation', [
            'job_title' => $jobTitle,
            'company_name' => $companyName,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    public function sendApplicationStatusUpdate($userId, $jobTitle, $status) {
        $user = $this->getUserEmail($userId);
        if (!$user) return false;

        $statusMessages = [
            'shortlisted' => 'تم اختيارك للمراحل التالية',
            'interview_scheduled' => 'موعد مقابلة معك',
            'offered' => 'عرض وظيفة من الشركة',
            'rejected' => 'تم رفض طلبك',
        ];

        $subject = $statusMessages[$status] ?? 'تحديث حالة الطلب';
        $html = $this->getTemplate('application-status', [
            'job_title' => $jobTitle,
            'status' => $status,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    public function sendNewJobNotification($userId, $jobTitle, $companyName, $jobUrl) {
        $user = $this->getUserEmail($userId);
        if (!$user) return false;

        $subject = 'وظيفة جديدة قد تهمك: ' . $jobTitle;
        $html = $this->getTemplate('new-job-match', [
            'job_title' => $jobTitle,
            'company_name' => $companyName,
            'job_url' => $jobUrl,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    public function sendInterviewReminder($userId, $jobTitle, $interviewDate) {
        $user = $this->getUserEmail($userId);
        if (!$user) return false;

        $subject = 'تذكير: مقابلة لوظيفة ' . $jobTitle;
        $html = $this->getTemplate('interview-reminder', [
            'job_title' => $jobTitle,
            'interview_date' => $interviewDate,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    public function sendWeeklyDigest($userId, $jobCount, $applicationCount) {
        $user = $this->getUserEmail($userId);
        if (!$user) return false;

        $subject = 'ملخص أسبوعي لنشاطك في منصة ' . SITE_NAME;
        $html = $this->getTemplate('weekly-digest', [
            'job_count' => $jobCount,
            'application_count' => $applicationCount,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    public function sendVerificationEmail($email, $token) {
        $verificationUrl = SITE_URL . 'pages/auth/verify.html?token=' . $token;

        $subject = 'تحقق من بريدك الإلكتروني';
        $html = $this->getTemplate('email-verification', [
            'verification_url' => $verificationUrl
        ]);

        return $this->send($email, $subject, $html);
    }

    public function sendPasswordReset($email, $token) {
        $resetUrl = SITE_URL . 'pages/auth/reset-password.html?token=' . $token;

        $subject = 'إعادة تعيين كلمة المرور';
        $html = $this->getTemplate('password-reset', [
            'reset_url' => $resetUrl
        ]);

        return $this->send($email, $subject, $html);
    }

    public function sendNewApplicationNotification($employerId, $candidateName, $jobTitle) {
        $user = $this->getUserEmail($employerId);
        if (!$user) return false;

        $subject = 'طلب توظيف جديد: ' . $jobTitle;
        $html = $this->getTemplate('new-application', [
            'candidate_name' => $candidateName,
            'job_title' => $jobTitle,
            'user_name' => $user['full_name']
        ]);

        return $this->send($user['email'], $subject, $html);
    }

    private function getTemplate($templateName, $variables = []) {
        $templateDir = __DIR__ . '/../email-templates/';
        $templateFile = $templateDir . $templateName . '.html';

        if (!file_exists($templateFile)) {
            return $this->getDefaultTemplate($templateName, $variables);
        }

        $html = file_get_contents($templateFile);

        foreach ($variables as $key => $value) {
            $html = str_replace('{{' . $key . '}}', $value, $html);
        }

        return $html;
    }

    private function getDefaultTemplate($templateName, $variables = []) {
        $baseHtml = '
        <html dir="rtl" lang="ar">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: "Arial", sans-serif; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 5px; }
                .content { padding: 20px; }
                .footer { text-align: center; padding: 20px; color: #999; font-size: 12px; }
                .button { background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>' . SITE_NAME . '</h2>
                </div>
                <div class="content">
                    ' . $this->getTemplateContent($templateName, $variables) . '
                </div>
                <div class="footer">
                    <p>تم إرسال هذا البريد من ' . SITE_NAME . '</p>
                    <p><a href="' . SITE_URL . '">زيارة الموقع</a></p>
                </div>
            </div>
        </body>
        </html>';

        return $baseHtml;
    }

    private function getTemplateContent($templateName, $variables = []) {
        $extract = extract($variables);

        switch ($templateName) {
            case 'application-confirmation':
                return "
                    <h3>مرحباً {$variables['user_name']}</h3>
                    <p>تم تقديم طلبك بنجاح على الوظيفة:</p>
                    <h4>{$variables['job_title']}</h4>
                    <p>في شركة: {$variables['company_name']}</p>
                    <p>سيتم التواصل معك قريباً بخصوص حالة طلبك.</p>
                ";

            case 'application-status':
                $statusText = $this->getStatusText($variables['status']);
                return "
                    <h3>تحديث حالة طلبك</h3>
                    <p>مرحباً {$variables['user_name']}</p>
                    <p>$statusText</p>
                    <h4>{$variables['job_title']}</h4>
                ";

            case 'new-job-match':
                return "
                    <h3>وظيفة جديدة قد تهمك</h3>
                    <p>مرحباً {$variables['user_name']}</p>
                    <p>وجدنا وظيفة قد تطابق ملفك الشخصي:</p>
                    <h4>{$variables['job_title']}</h4>
                    <p>الشركة: {$variables['company_name']}</p>
                    <a href=\"{$variables['job_url']}\" class=\"button\">عرض الوظيفة</a>
                ";

            case 'weekly-digest':
                return "
                    <h3>ملخص أسبوعيك</h3>
                    <p>مرحباً {$variables['user_name']}</p>
                    <ul>
                        <li>عدد الوظائف الجديدة: {$variables['job_count']}</li>
                        <li>عدد طلباتك: {$variables['application_count']}</li>
                    </ul>
                ";

            case 'email-verification':
                return "
                    <h3>تحقق من بريدك الإلكتروني</h3>
                    <p>للتحقق من بريدك، اضغط على الرابط أدناه:</p>
                    <a href=\"{$variables['verification_url']}\" class=\"button\">التحقق من البريد</a>
                    <p>الرابط صالح لمدة 24 ساعة</p>
                ";

            case 'password-reset':
                return "
                    <h3>إعادة تعيين كلمة المرور</h3>
                    <p>اضغط على الرابط أدناه لإعادة تعيين كلمة المرور:</p>
                    <a href=\"{$variables['reset_url']}\" class=\"button\">إعادة تعيين</a>
                ";

            case 'new-application':
                return "
                    <h3>طلب توظيف جديد</h3>
                    <p>مرحباً {$variables['user_name']}</p>
                    <p>تقدم مرشح جديد على الوظيفة:</p>
                    <h4>{$variables['job_title']}</h4>
                    <p>المرشح: {$variables['candidate_name']}</p>
                ";

            case 'interview-reminder':
                return "
                    <h3>تذكير بمقابلة وظيفة</h3>
                    <p>مرحباً {$variables['user_name']}</p>
                    <p>لديك مقابلة لوظيفة:</p>
                    <h4>{$variables['job_title']}</h4>
                    <p>الموعد: {$variables['interview_date']}</p>
                ";

            default:
                return "<p>البريد من " . SITE_NAME . "</p>";
        }
    }

    private function getStatusText($status) {
        $statusMap = [
            'shortlisted' => 'تم اختيارك للمراحل التالية من عملية التوظيف',
            'interview_scheduled' => 'تم جدولة مقابلة معك',
            'offered' => 'تم تقديم عرض وظيفة لك',
            'rejected' => 'تم رفض طلبك، نتمنى لك التوفيق في المرات القادمة'
        ];

        return $statusMap[$status] ?? 'تم تحديث حالة طلبك';
    }

    private function getUserEmail($userId) {
        try {
            $stmt = $this->db->prepare("SELECT id, email, full_name FROM users WHERE id = ?");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    private function send($to, $subject, $html) {
        try {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: " . $this->fromName . " <" . $this->fromEmail . ">\r\n";
            $headers .= "Reply-To: " . $this->fromEmail . "\r\n";

            return mail($to, $subject, $html, $headers);
        } catch (Exception $e) {
            error_log('Email send error: ' . $e->getMessage());
            return false;
        }
    }
}

?>
