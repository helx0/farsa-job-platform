<?php
/**
 * Farsa - Intelligent Job Matching Platform
 * Configuration File
 */

if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? null) == 443);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

$appEnv = getenv('APP_ENV') ?: 'development';
$displayErrors = filter_var(getenv('DISPLAY_ERRORS') ?: ($appEnv !== 'production' ? '1' : '0'), FILTER_VALIDATE_BOOLEAN);

// Database settings are read from the environment first, with safe local-development defaults.
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'helxdb');
define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));

define('SITE_URL', getenv('SITE_URL') ?: 'http://localhost:8080/');
define('SITE_NAME', 'فرصة');
define('SITE_NAME_EN', 'Farsa');

define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', SITE_URL . 'assets/uploads/');
define('DOCUMENT_DIR', __DIR__ . '/../assets/documents/');
define('CERTIFICATE_DIR', __DIR__ . '/../assets/certificates/');

define('MAX_FILE_SIZE', 5242880);
define('ALLOWED_EXTENSIONS', 'pdf,doc,docx,jpg,jpeg,png,gif');

define('ADMIN_EMAIL', 'admin@farsa.ye');
define('SUPPORT_EMAIL', 'support@farsa.ye');

$jwtSecret = getenv('JWT_SECRET') ?: '';
if ($appEnv === 'production' && $jwtSecret === '') {
    error_log('JWT_SECRET is not configured in production.');
    http_response_code(500);
    exit('Application configuration error.');
}
if ($jwtSecret === '') {
    $jwtSecret = 'development-only-change-this-secret';
}
define('JWT_SECRET', $jwtSecret);
define('SESSION_TIMEOUT', 3600);
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_REQUIRE_UPPERCASE', true);
define('PASSWORD_REQUIRE_NUMBERS', true);
define('PASSWORD_REQUIRE_SPECIAL', true);

$GLOBALS['YEMEN_CITIES'] = [
    'صنعاء',
    'عدن',
    'تعز',
    'إب',
    'الحديدة',
    'لحج',
    'ذمار',
    'أبين',
    'الضالع',
    'حجة',
    'مأرب',
    'شبوة',
    'سقطرى',
    'المهرة',
    'البيضاء'
];

$GLOBALS['EMPLOYMENT_TYPES'] = ['full_time', 'part_time', 'freelance', 'contract', 'internship'];
$GLOBALS['EDUCATION_LEVELS'] = ['high_school', 'diploma', 'bachelor', 'master', 'phd'];
$GLOBALS['USER_TYPES'] = ['job_seeker', 'employer', 'admin'];

$GLOBALS['SKILL_LEVELS'] = [
    'beginner' => 'مبتدئ',
    'intermediate' => 'متوسط',
    'advanced' => 'متقدم',
    'expert' => 'خبير'
];

$GLOBALS['DIFFICULTY_LEVELS'] = [
    'beginner' => 'للمبتدئين',
    'intermediate' => 'متوسط',
    'advanced' => 'متقدم'
];

$GLOBALS['COMPANY_SIZES'] = [
    'startup' => 'شركة ناشئة',
    'small' => 'صغيرة',
    'medium' => 'متوسطة',
    'large' => 'كبيرة',
    'enterprise' => 'مؤسسة'
];

$GLOBALS['SUBSCRIPTION_PLANS'] = [
    'free' => ['name' => 'مجاني', 'price' => 0, 'jobs' => 5],
    'basic' => ['name' => 'أساسي', 'price' => 99, 'jobs' => 20],
    'premium' => ['name' => 'احترافي', 'price' => 299, 'jobs' => 100],
    'enterprise' => ['name' => 'مؤسسي', 'price' => 999, 'jobs' => 'unlimited']
];

$GLOBALS['MATCHING_WEIGHTS'] = [
    'skills' => 0.4,
    'experience' => 0.25,
    'education' => 0.15,
    'location' => 0.1,
    'salary' => 0.1
];

define('BLOCKCHAIN_ENABLED', true);
define('BLOCKCHAIN_FILE', __DIR__ . '/../assets/blockchain.json');

define('ENABLE_TWO_FACTOR', true);
define('ENABLE_EMAIL_VERIFICATION', true);
define('ENABLE_PHONE_VERIFICATION', false);

define('SMS_GATEWAY', 'twilio');
define('TWILIO_ACCOUNT_SID', getenv('TWILIO_ACCOUNT_SID') ?: '');
define('TWILIO_AUTH_TOKEN', getenv('TWILIO_AUTH_TOKEN') ?: '');
define('TWILIO_PHONE_NUMBER', getenv('TWILIO_PHONE_NUMBER') ?: '');

define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', (int)(getenv('SMTP_PORT') ?: 587));
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD') ?: '');
define('SMTP_FROM', getenv('SMTP_FROM') ?: 'noreply@farsa.ye');

define('PAGINATION_LIMIT', 20);
define('SEARCH_LIMIT', 50);

define('DEFAULT_LANGUAGE', 'ar');
$GLOBALS['SUPPORTED_LANGUAGES'] = ['ar', 'en'];

class Response {
    public static function json($data, $statusCode = 200) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success($message, $data = null, $statusCode = 200) {
        self::json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message, $data = null, $statusCode = 400) {
        self::json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}

function requireAdminAccess() {
    if (!isset($_SESSION['user_id'], $_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        Response::error('Unauthorized', null, 401);
    }
}

class Database {
    private static $instance = null;
    private $connection = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            $this->connection = new mysqli(
                DB_HOST,
                DB_USER,
                DB_PASS,
                DB_NAME,
                DB_PORT
            );

            if ($this->connection->connect_error) {
                error_log('MySQL Connection Error: ' . $this->connection->connect_error);
                Response::error('خطأ في الاتصال بقاعدة البيانات', null, 500);
            }

            $this->connection->set_charset('utf8mb4');
        } catch (Exception $e) {
            error_log('Database Exception: ' . $e->getMessage());
            Response::error('خطأ في النظام', null, 500);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if ($this->connection->error) {
            error_log('Database Error: ' . $this->connection->error);
            return false;
        }
        return $result;
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function escape($string) {
        return $this->connection->real_escape_string($string);
    }

    public function lastId() {
        return $this->connection->insert_id;
    }

    public function affectedRows() {
        return $this->connection->affected_rows;
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function beginTransaction() {
        $this->connection->begin_transaction();
    }

    public function commit() {
        $this->connection->commit();
    }

    public function rollback() {
        $this->connection->rollback();
    }
}

class Security {
    public static function validateInput($input, $type = 'string') {
        if ($type === 'string') {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        } elseif ($type === 'email') {
            return filter_var($input, FILTER_VALIDATE_EMAIL);
        } elseif ($type === 'phone') {
            return preg_match('/^[0-9\-\+\(\)\.]{10,}$/', $input) ? $input : false;
        } elseif ($type === 'integer') {
            return filter_var($input, FILTER_VALIDATE_INT);
        } elseif ($type === 'float') {
            return filter_var($input, FILTER_VALIDATE_FLOAT);
        }
        return $input;
    }

    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token) {
        if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function validatePassword($password) {
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            return false;
        }

        if (PASSWORD_REQUIRE_UPPERCASE && !preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (PASSWORD_REQUIRE_NUMBERS && !preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (PASSWORD_REQUIRE_SPECIAL && !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return false;
        }

        return true;
    }

    public static function generateVerificationToken() {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes(32));
        }
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public static function generateRandomCode($length = 6) {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }

    public static function sanitizeSQL($input) {
        $db = Database::getInstance();
        return $db->escape($input);
    }
}

error_reporting(E_ALL);
ini_set('display_errors', $displayErrors ? '1' : '0');
ini_set('display_startup_errors', $displayErrors ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/error.log');

function configureCors() {
    $configuredOrigins = getenv('CORS_ORIGINS') ?: 'http://localhost:8080,http://localhost:3000';
    $allowedOrigins = array_values(array_filter(array_map('trim', explode(',', $configuredOrigins))));
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    if ($origin !== '' && in_array($origin, $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Vary: Origin');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit();
    }
}

configureCors();

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    return true;
});

date_default_timezone_set('Asia/Aden');

?>
