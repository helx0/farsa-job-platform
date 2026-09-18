-- Farsa Job Platform Database
-- Complete Database Schema for Intelligent Job Matching Platform in Yemen

CREATE DATABASE IF NOT EXISTS helxdb;
USE helxdb;

-- Disable foreign key checks for safe dropping
SET FOREIGN_KEY_CHECKS = 0;

-- Users Table (Base for all user types)
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) UNIQUE,
    full_name VARCHAR(255),
    profile_image VARCHAR(255),
    user_type ENUM('job_seeker', 'employer', 'admin') NOT NULL,
    status ENUM('active', 'inactive', 'suspended', 'pending_verification') DEFAULT 'pending_verification',
    email_verified BOOLEAN DEFAULT FALSE,
    phone_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(255),
    reset_token VARCHAR(255),
    reset_token_expires DATETIME,
    last_login DATETIME,
    two_factor_enabled BOOLEAN DEFAULT FALSE,
    two_factor_code VARCHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_user_type (user_type),
    INDEX idx_status (status)
);

-- Login throttling / brute-force protection
DROP TABLE IF EXISTS login_attempts;
CREATE TABLE login_attempts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempts INT NOT NULL DEFAULT 1,
    first_failed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    blocked_until DATETIME NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_login_attempt_email_ip (email, ip_address),
    INDEX idx_login_attempt_email (email),
    INDEX idx_login_attempt_ip (ip_address),
    INDEX idx_login_attempt_blocked (blocked_until)
);

-- Job Seekers Profile
DROP TABLE IF EXISTS job_seekers;
CREATE TABLE job_seekers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    headline VARCHAR(255),
    bio TEXT,
    current_city VARCHAR(100),
    target_cities TEXT,
    job_title VARCHAR(100),
    experience_years INT,
    education_level ENUM('high_school', 'diploma', 'bachelor', 'master', 'phd'),
    employment_type SET('full_time', 'part_time', 'freelance', 'contract', 'internship'),
    salary_expectation_min INT,
    salary_expectation_max INT,
    currency VARCHAR(3) DEFAULT 'YER',
    availability_status ENUM('actively_looking', 'open_to_opportunities', 'not_looking') DEFAULT 'actively_looking',
    resume_file VARCHAR(255),
    resume_content LONGTEXT,
    cv_summary TEXT,
    linkedin_url VARCHAR(255),
    github_url VARCHAR(255),
    portfolio_url VARCHAR(255),
    completed_courses INT DEFAULT 0,
    cv_score INT DEFAULT 0,
    profile_completeness INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_experience (experience_years),
    INDEX idx_availability (availability_status)
);

-- Employers/Companies Profile
DROP TABLE IF EXISTS employers;
CREATE TABLE employers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    company_name VARCHAR(255) NOT NULL,
    company_logo VARCHAR(255),
    company_description TEXT,
    industry VARCHAR(100),
    company_size ENUM('startup', 'small', 'medium', 'large', 'enterprise'),
    founded_year YEAR,
    headquarters_city VARCHAR(100),
    company_website VARCHAR(255),
    company_phone VARCHAR(20),
    company_email VARCHAR(100),
    verification_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    verification_document VARCHAR(255),
    subscription_status ENUM('free', 'basic', 'premium', 'enterprise') DEFAULT 'free',
    subscription_expires DATETIME,
    job_posts_limit INT DEFAULT 5,
    active_jobs INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_verification (verification_status)
);

-- Job Categories
DROP TABLE IF EXISTS job_categories;
CREATE TABLE job_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name_ar VARCHAR(255) NOT NULL,
    category_name_en VARCHAR(255) NOT NULL,
    description_ar TEXT,
    description_en TEXT,
    icon VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_category (category_name_ar, category_name_en)
);

-- Job Postings
DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employer_id INT NOT NULL,
    job_title_ar VARCHAR(255) NOT NULL,
    job_title_en VARCHAR(255) NOT NULL,
    job_description_ar LONGTEXT NOT NULL,
    job_description_en LONGTEXT NOT NULL,
    requirements_ar LONGTEXT,
    requirements_en LONGTEXT,
    category_id INT,
    job_type ENUM('full_time', 'part_time', 'freelance', 'contract', 'internship') NOT NULL,
    salary_min INT,
    salary_max INT,
    salary_currency VARCHAR(3) DEFAULT 'YER',
    salary_hidden BOOLEAN DEFAULT FALSE,
    experience_required INT,
    education_level ENUM('high_school', 'diploma', 'bachelor', 'master', 'phd', 'any'),
    location_city VARCHAR(100),
    remote_work BOOLEAN DEFAULT FALSE,
    required_skills TEXT,
    nice_to_have_skills TEXT,
    benefits TEXT,
    number_of_openings INT DEFAULT 1,
    status ENUM('draft', 'active', 'closed', 'archived') DEFAULT 'draft',
    featured BOOLEAN DEFAULT FALSE,
    views_count INT DEFAULT 0,
    applications_count INT DEFAULT 0,
    posted_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    deadline DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES job_categories(id),
    INDEX idx_status (status),
    INDEX idx_location (location_city),
    INDEX idx_posted_date (posted_date),
    FULLTEXT INDEX ft_search (job_title_ar, job_title_en, job_description_ar, job_description_en)
);

-- Job Skills (Required for matching)
DROP TABLE IF EXISTS job_required_skills;
CREATE TABLE job_required_skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    job_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    skill_level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'intermediate',
    is_mandatory BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    INDEX idx_job (job_id)
);

-- Skills Master List
DROP TABLE IF EXISTS skills_master;
CREATE TABLE skills_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) UNIQUE NOT NULL,
    skill_category VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User Skills
DROP TABLE IF EXISTS user_skills;
CREATE TABLE user_skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    proficiency_level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'intermediate',
    endorsements INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
);

-- Job Applications
DROP TABLE IF EXISTS job_applications;
CREATE TABLE job_applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    job_id INT NOT NULL,
    job_seeker_id INT NOT NULL,
    employer_id INT NOT NULL,
    cover_letter TEXT,
    cv_version VARCHAR(255),
    application_status ENUM('pending', 'reviewed', 'shortlisted', 'rejected', 'interview_scheduled', 'offered', 'accepted', 'declined') DEFAULT 'pending',
    match_score INT,
    match_details LONGTEXT,
    applied_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    reviewed_date DATETIME,
    response_date DATETIME,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (job_seeker_id) REFERENCES job_seekers(id) ON DELETE CASCADE,
    FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
    INDEX idx_status (application_status),
    INDEX idx_job_seeker (job_seeker_id),
    INDEX idx_employer (employer_id),
    UNIQUE KEY unique_application (job_id, job_seeker_id)
);

-- Saved/Bookmarked Jobs
DROP TABLE IF EXISTS saved_jobs;
CREATE TABLE saved_jobs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    saved_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_save (user_id, job_id),
    INDEX idx_user (user_id)
);

-- User Education/Qualifications
DROP TABLE IF EXISTS user_education;
CREATE TABLE user_education (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    institution_name_ar VARCHAR(255),
    institution_name_en VARCHAR(255),
    degree_ar VARCHAR(255),
    degree_en VARCHAR(255),
    field_of_study_ar VARCHAR(100),
    field_of_study_en VARCHAR(100),
    start_date DATE,
    end_date DATE,
    is_current BOOLEAN DEFAULT FALSE,
    gpa DECIMAL(3, 2),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
);

-- User Experience
DROP TABLE IF EXISTS user_experience;
CREATE TABLE user_experience (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    job_title_ar VARCHAR(255),
    job_title_en VARCHAR(255),
    company_name VARCHAR(255),
    employment_type ENUM('full_time', 'part_time', 'freelance', 'contract', 'internship'),
    start_date DATE,
    end_date DATE,
    is_current BOOLEAN DEFAULT FALSE,
    description TEXT,
    company_location VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
);

-- Certificates & Credentials
DROP TABLE IF EXISTS certificates;
CREATE TABLE certificates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    certificate_title_ar VARCHAR(255),
    certificate_title_en VARCHAR(255),
    issuer_ar VARCHAR(255),
    issuer_en VARCHAR(255),
    certificate_file VARCHAR(255),
    issue_date DATE,
    expiry_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    verification_hash VARCHAR(255),
    verification_status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    blockchain_hash VARCHAR(255),
    blockchain_block_id INT,
    blockchain_verified BOOLEAN DEFAULT FALSE,
    verification_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_verification (verification_hash)
);

-- Blockchain Records (Simple blockchain implementation)
DROP TABLE IF EXISTS blockchain_records;
CREATE TABLE blockchain_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    block_id INT UNIQUE NOT NULL,
    certificate_id INT,
    user_id INT,
    previous_hash VARCHAR(255),
    current_hash VARCHAR(255),
    data LONGTEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (certificate_id) REFERENCES certificates(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Courses
DROP TABLE IF EXISTS courses;
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_title_ar VARCHAR(255) NOT NULL,
    course_title_en VARCHAR(255) NOT NULL,
    description_ar LONGTEXT,
    description_en LONGTEXT,
    course_image VARCHAR(255),
    category_ar VARCHAR(100),
    category_en VARCHAR(100),
    instructor_name VARCHAR(255),
    instructor_bio TEXT,
    instructor_image VARCHAR(255),
    duration_hours INT,
    difficulty_level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    skills_covered TEXT,
    course_content LONGTEXT,
    video_url VARCHAR(255),
    course_file VARCHAR(255),
    price INT DEFAULT 0,
    currency VARCHAR(3) DEFAULT 'YER',
    status ENUM('draft', 'active', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- User Course Enrollment
DROP TABLE IF EXISTS course_enrollments;
CREATE TABLE course_enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    progress INT DEFAULT 0,
    completion_date DATETIME,
    is_completed BOOLEAN DEFAULT FALSE,
    certificate_issued BOOLEAN DEFAULT FALSE,
    certificate_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (certificate_id) REFERENCES certificates(id),
    UNIQUE KEY unique_enrollment (user_id, course_id),
    INDEX idx_user (user_id)
);

-- Notifications
DROP TABLE IF EXISTS notifications;
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipient_user_id INT NOT NULL,
    notification_type ENUM('new_job', 'application_status', 'profile_viewed', 'interview_request', 'message', 'course_recommendation', 'general') NOT NULL,
    title_ar VARCHAR(255),
    title_en VARCHAR(255),
    message_ar TEXT,
    message_en TEXT,
    related_job_id INT,
    related_application_id INT,
    related_course_id INT,
    action_url VARCHAR(255),
    read_status BOOLEAN DEFAULT FALSE,
    read_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipient_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (related_job_id) REFERENCES jobs(id) ON DELETE SET NULL,
    INDEX idx_recipient (recipient_user_id),
    INDEX idx_read_status (read_status)
);

-- Notification Preferences
DROP TABLE IF EXISTS notification_preferences;
CREATE TABLE notification_preferences (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    email_notifications BOOLEAN DEFAULT TRUE,
    sms_notifications BOOLEAN DEFAULT TRUE,
    push_notifications BOOLEAN DEFAULT TRUE,
    in_app_notifications BOOLEAN DEFAULT TRUE,
    new_job_match_email BOOLEAN DEFAULT TRUE,
    new_job_match_sms BOOLEAN DEFAULT TRUE,
    application_status_email BOOLEAN DEFAULT TRUE,
    application_status_sms BOOLEAN DEFAULT TRUE,
    profile_viewed_email BOOLEAN DEFAULT TRUE,
    interview_request_email BOOLEAN DEFAULT TRUE,
    interview_request_sms BOOLEAN DEFAULT TRUE,
    daily_digest BOOLEAN DEFAULT FALSE,
    weekly_digest BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Messages/Communications
DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    subject VARCHAR(255),
    message_body TEXT NOT NULL,
    related_job_id INT,
    related_application_id INT,
    is_read BOOLEAN DEFAULT FALSE,
    read_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_recipient (recipient_id),
    INDEX idx_is_read (is_read)
);

-- Referrals
DROP TABLE IF EXISTS referrals;
CREATE TABLE referrals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    referrer_id INT NOT NULL,
    referred_email VARCHAR(100),
    referred_user_id INT,
    referral_type ENUM('job_seeker', 'employer') NOT NULL,
    status ENUM('pending', 'registered', 'completed', 'failed') DEFAULT 'pending',
    referral_code VARCHAR(50) UNIQUE,
    reward_points INT DEFAULT 0,
    reward_claimed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at DATETIME,
    FOREIGN KEY (referrer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (referred_user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_referrer (referrer_id)
);

-- Reviews/Ratings
DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reviewer_id INT NOT NULL,
    reviewer_type ENUM('job_seeker', 'employer') NOT NULL,
    reviewed_company_id INT,
    reviewed_user_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    review_title_ar VARCHAR(255),
    review_title_en VARCHAR(255),
    review_text_ar TEXT,
    review_text_en TEXT,
    pros TEXT,
    cons TEXT,
    would_recommend BOOLEAN,
    verified_applicant BOOLEAN DEFAULT FALSE,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Admin Logs
DROP TABLE IF EXISTS admin_logs;
CREATE TABLE admin_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NULL,
    action_type VARCHAR(100),
    action_description TEXT,
    affected_user_id INT,
    affected_resource_type VARCHAR(100),
    affected_resource_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_action_type (action_type),
    INDEX idx_created_at (created_at)
);

-- Platform Statistics
DROP TABLE IF EXISTS platform_statistics;
CREATE TABLE platform_statistics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    stat_date DATE UNIQUE,
    total_users INT DEFAULT 0,
    total_job_seekers INT DEFAULT 0,
    total_employers INT DEFAULT 0,
    total_jobs_posted INT DEFAULT 0,
    active_jobs INT DEFAULT 0,
    total_applications INT DEFAULT 0,
    total_courses INT DEFAULT 0,
    users_enrolled_in_courses INT DEFAULT 0,
    matched_applications INT DEFAULT 0,
    hired_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subscriptions/Payments
DROP TABLE IF EXISTS subscriptions;
CREATE TABLE subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employer_id INT NOT NULL,
    plan_type ENUM('free', 'basic', 'premium', 'enterprise') NOT NULL,
    price_per_month INT,
    currency VARCHAR(3) DEFAULT 'YER',
    job_posts_limit INT,
    featured_jobs_limit INT,
    start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    end_date DATETIME,
    auto_renew BOOLEAN DEFAULT TRUE,
    payment_status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    transaction_id VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
    INDEX idx_plan_type (plan_type)
);

-- YEN Currency Exchange Rates (for future international support)
DROP TABLE IF EXISTS exchange_rates;
CREATE TABLE exchange_rates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    from_currency VARCHAR(3),
    to_currency VARCHAR(3),
    rate DECIMAL(10, 4),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create initial indexes for better performance
CREATE INDEX idx_users_created ON users(created_at);
CREATE INDEX idx_jobs_created ON jobs(created_at);
CREATE INDEX idx_applications_date ON job_applications(applied_date);
CREATE INDEX idx_notifications_created ON notifications(created_at);

-- Create Views for better query performance

-- View for Active Jobs with applicant count
DROP VIEW IF EXISTS active_jobs_view;
CREATE VIEW active_jobs_view AS
SELECT j.*, 
       COUNT(DISTINCT ja.id) as total_applications,
       COUNT(DISTINCT CASE WHEN ja.application_status IN ('shortlisted', 'interview_scheduled') THEN ja.id END) as shortlisted_count,
       e.company_name,
       e.company_logo
FROM jobs j
LEFT JOIN job_applications ja ON j.id = ja.job_id
LEFT JOIN employers e ON j.employer_id = e.id
WHERE j.status = 'active' AND j.deadline > NOW()
GROUP BY j.id;

-- View for Job Seeker Profile Completeness
DROP VIEW IF EXISTS job_seeker_profile_completeness_view;
CREATE VIEW job_seeker_profile_completeness_view AS
SELECT 
    js.user_id,
    u.full_name,
    u.email,
    ROUND((
        (CASE WHEN js.headline IS NOT NULL THEN 20 ELSE 0 END) +
        (CASE WHEN js.bio IS NOT NULL THEN 15 ELSE 0 END) +
        (CASE WHEN js.current_city IS NOT NULL THEN 10 ELSE 0 END) +
        (CASE WHEN js.experience_years IS NOT NULL THEN 15 ELSE 0 END) +
        (CASE WHEN js.education_level IS NOT NULL THEN 10 ELSE 0 END) +
        (CASE WHEN COUNT(DISTINCT us.id) > 0 THEN 10 ELSE 0 END) +
        (CASE WHEN COUNT(DISTINCT ue.id) > 0 THEN 10 ELSE 0 END)
    ) / 100 * 100, 0) as profile_completeness_percentage,
    COUNT(DISTINCT us.id) as skills_count,
    COUNT(DISTINCT ue.id) as experience_count
FROM job_seekers js
JOIN users u ON js.user_id = u.id
LEFT JOIN user_skills us ON u.id = us.user_id
LEFT JOIN user_experience ue ON u.id = ue.user_id
GROUP BY js.user_id;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Insert test data for demonstration

-- Admin user
INSERT INTO users (username, email, password, phone, full_name, user_type, status, email_verified, phone_verified, verification_token, created_at, updated_at) VALUES
('admin', 'admin@farsa.ye', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '777123456', 'مدير النظام', 'admin', 'active', TRUE, TRUE, NULL, NOW(), NOW());

-- Job Seeker user
INSERT INTO users (username, email, password, phone, full_name, user_type, status, email_verified, phone_verified, verification_token, created_at, updated_at) VALUES
('jobseeker', 'jobseeker@farsa.ye', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '777234567', 'الباحث عن عمل', 'job_seeker', 'active', TRUE, TRUE, NULL, NOW(), NOW());

INSERT INTO job_seekers (user_id, headline, bio, current_city, target_cities, job_title, experience_years, education_level, employment_type, salary_expectation_min, salary_expectation_max, currency, availability_status, resume_file, resume_content, cv_summary, linkedin_url, github_url, portfolio_url, completed_courses, cv_score, profile_completeness, created_at, updated_at) VALUES
(LAST_INSERT_ID(), 'مطور ويب ماهر', 'أنا مطور ويب ذو خبرة في PHP وJavaScript', 'صنعاء', 'صنعاء،عدن', 'مطور ويب', 3, 'bachelor', 'full_time,freelance', 50000, 80000, 'YER', 'actively_looking', NULL, 'محتوى السيرة الذاتية', 'ملخص السيرة', 'https://linkedin.com/in/jobseeker', 'https://github.com/jobseeker', 'https://portfolio.com', 2, 85, 90, NOW(), NOW());

-- Employer user
INSERT INTO users (username, email, password, phone, full_name, user_type, status, email_verified, phone_verified, verification_token, created_at, updated_at) VALUES
('employer', 'employer@farsa.ye', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '777345678', 'صاحب العمل', 'employer', 'active', TRUE, TRUE, NULL, NOW(), NOW());

INSERT INTO employers (user_id, company_name, company_logo, company_description, industry, company_size, founded_year, headquarters_city, company_website, company_phone, company_email, verification_status, verification_document, subscription_status, subscription_expires, job_posts_limit, active_jobs, created_at, updated_at) VALUES
(LAST_INSERT_ID(), 'شركة فورصة', NULL, 'منصة توظيف ذكية', 'Technology', 'small', 2023, 'صنعاء', 'https://farsa.ye', '777456789', 'hr@farsa.ye', 'verified', NULL, 'basic', DATE_ADD(NOW(), INTERVAL 1 YEAR), 20, 1, NOW(), NOW());

-- Insert a test job
INSERT INTO jobs (employer_id, job_title_ar, job_title_en, job_description_ar, job_description_en, requirements_ar, requirements_en, category_id, job_type, salary_min, salary_max, salary_currency, salary_hidden, experience_required, education_level, location_city, remote_work, required_skills, nice_to_have_skills, benefits, number_of_openings, status, featured, views_count, applications_count, posted_date, deadline, created_at, updated_at) VALUES
(1, 'مطور ويب', 'Web Developer', 'نبحث عن مطور ويب ماهر', 'Looking for skilled web developer', 'خبرة في PHP وJavaScript', 'Experience in PHP and JavaScript', NULL, 'full_time', 60000, 90000, 'YER', FALSE, 2, 'bachelor', 'صنعاء', FALSE, 'PHP,JavaScript,MySQL', 'React,Laravel', 'راتب مجزي،تأمين صحي', 1, 'active', FALSE, 10, 0, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), NOW(), NOW());

-- Insert job application
INSERT INTO job_applications (job_id, job_seeker_id, employer_id, cover_letter, cv_version, application_status, match_score, match_details, applied_date, reviewed_date, response_date, notes, created_at, updated_at) VALUES
(1, 1, 1, 'أنا مهتم بهذا المنصب', NULL, 'pending', 85, 'مطابقة جيدة', NOW(), NULL, NULL, NULL, NOW(), NOW());

-- Insert a course
INSERT INTO courses (course_title_ar, course_title_en, description_ar, description_en, course_image, category_ar, category_en, instructor_name, instructor_bio, instructor_image, duration_hours, difficulty_level, skills_covered, course_content, video_url, course_file, price, currency, status, created_at, updated_at) VALUES
('دورة PHP الأساسية', 'Basic PHP Course', 'تعلم PHP من الصفر', 'Learn PHP from scratch', NULL, 'برمجة', 'Programming', 'أحمد محمد', 'مطور ويب', NULL, 20, 'beginner', 'PHP,MySQL', 'محتوى الدورة', NULL, NULL, 5000, 'YER', 'active', NOW(), NOW());

-- Insert course enrollment
INSERT INTO course_enrollments (user_id, course_id, enrollment_date, progress, completion_date, is_completed, certificate_issued, certificate_id, created_at) VALUES
(2, 1, NOW(), 50, NULL, FALSE, FALSE, NULL, NOW());
