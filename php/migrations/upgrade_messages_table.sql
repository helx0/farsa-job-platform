-- تحسينات جدول الرسائل - Upgrade Schema
-- إضافة ميزات متقدمة لنظام الرسائل الداخلي

-- إضافة أعمدة جديدة إلى جدول الرسائل
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `status` ENUM('pending', 'sent', 'delivered', 'read', 'replied', 'archived') DEFAULT 'sent' AFTER `is_read`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `is_pinned` BOOLEAN DEFAULT FALSE AFTER `status`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `is_archived` BOOLEAN DEFAULT FALSE AFTER `is_pinned`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `is_important` BOOLEAN DEFAULT FALSE AFTER `is_archived`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `message_type` ENUM('general', 'job_related', 'application_related', 'offer', 'rejection') DEFAULT 'general' AFTER `is_important`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `has_attachment` BOOLEAN DEFAULT FALSE AFTER `message_type`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `attachment_url` VARCHAR(255) AFTER `has_attachment`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `replied_to_message_id` INT AFTER `attachment_url`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `last_reply_at` DATETIME AFTER `replied_to_message_id`;
ALTER TABLE messages ADD COLUMN IF NOT EXISTS `reply_count` INT DEFAULT 0 AFTER `last_reply_at`;

-- إضافة Foreign Key للرد على الرسائل
ALTER TABLE messages ADD CONSTRAINT fk_replied_to_message 
FOREIGN KEY (replied_to_message_id) REFERENCES messages(id) ON DELETE SET NULL;

-- إضافة جدول التلميحات السريعة (Quick Replies)
CREATE TABLE IF NOT EXISTS `quick_replies` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `content` TEXT NOT NULL,
    `message_type` VARCHAR(50),
    `is_active` BOOLEAN DEFAULT TRUE,
    `usage_count` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_active (is_active)
);

-- إضافة جدول تنبيهات الرسائل
CREATE TABLE IF NOT EXISTS `message_alerts` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `message_id` INT NOT NULL,
    `alert_type` ENUM('new_message', 'replied', 'awaiting_reply', 'archived') DEFAULT 'new_message',
    `is_sent` BOOLEAN DEFAULT FALSE,
    `sent_at` DATETIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_is_sent (is_sent)
);

-- إضافة جدول مرفقات الرسائل
CREATE TABLE IF NOT EXISTS `message_attachments` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `message_id` INT NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_url` VARCHAR(500) NOT NULL,
    `file_size` INT,
    `file_type` VARCHAR(50),
    `uploaded_by` INT NOT NULL,
    `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_message_id (message_id)
);

-- إضافة جدول معلومات المحادثة
CREATE TABLE IF NOT EXISTS `conversation_settings` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `other_user_id` INT NOT NULL,
    `is_muted` BOOLEAN DEFAULT FALSE,
    `is_blocked` BOOLEAN DEFAULT FALSE,
    `custom_label` VARCHAR(100),
    `last_message_id` INT,
    `unread_count` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (other_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (last_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    UNIQUE KEY unique_conversation (user_id, other_user_id),
    INDEX idx_user_id (user_id),
    INDEX idx_is_muted (is_muted),
    INDEX idx_is_blocked (is_blocked)
);

-- إضافة indexed جديدة للأداء
CREATE INDEX idx_status ON messages(status);
CREATE INDEX idx_is_pinned ON messages(is_pinned);
CREATE INDEX idx_is_archived ON messages(is_archived);
CREATE INDEX idx_is_important ON messages(is_important);
CREATE INDEX idx_message_type ON messages(message_type);
CREATE INDEX idx_sender_recipient ON messages(sender_id, recipient_id);
CREATE INDEX idx_created_at ON messages(created_at);
CREATE INDEX idx_related_job ON messages(related_job_id);
CREATE INDEX idx_related_app ON messages(related_application_id);

-- إضافة views للإحصائيات
CREATE OR REPLACE VIEW `user_message_statistics` AS
SELECT 
    u.id,
    u.full_name,
    COUNT(DISTINCT CASE WHEN m.sender_id = u.id THEN m.id END) as sent_count,
    COUNT(DISTINCT CASE WHEN m.recipient_id = u.id THEN m.id END) as received_count,
    COUNT(DISTINCT CASE WHEN m.recipient_id = u.id AND m.is_read = FALSE THEN m.id END) as unread_count,
    COUNT(DISTINCT CASE WHEN m.message_type = 'job_related' THEN m.id END) as job_related_count,
    COUNT(DISTINCT CASE WHEN m.message_type = 'application_related' THEN m.id END) as application_related_count
FROM users u
LEFT JOIN messages m ON (u.id = m.sender_id OR u.id = m.recipient_id)
GROUP BY u.id;

-- إضافة view للمحادثات الفعالة
CREATE OR REPLACE VIEW `active_conversations` AS
SELECT 
    CASE WHEN m.sender_id < m.recipient_id THEN m.sender_id ELSE m.recipient_id END as user1_id,
    CASE WHEN m.sender_id < m.recipient_id THEN m.recipient_id ELSE m.sender_id END as user2_id,
    COUNT(*) as message_count,
    MAX(m.created_at) as last_message_at,
    SUM(CASE WHEN m.sender_id = user1_id AND m.is_read = FALSE THEN 1 ELSE 0 END) as unread_count
FROM messages m
GROUP BY user1_id, user2_id;

-- إضافة stored procedure لحذف الرسائل القديمة (أرشفة)
DELIMITER //
CREATE PROCEDURE archive_old_messages(IN days_old INT)
BEGIN
    UPDATE messages 
    SET is_archived = TRUE 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL days_old DAY)
    AND is_archived = FALSE;
END//
DELIMITER ;

-- إضافة stored procedure للحصول على احصائيات المحادثات
DELIMITER //
CREATE PROCEDURE get_conversation_stats(IN user_id INT)
BEGIN
    SELECT 
        COUNT(*) as total_conversations,
        SUM(CASE WHEN unread_count > 0 THEN 1 ELSE 0 END) as conversations_with_unread,
        SUM(unread_count) as total_unread
    FROM active_conversations
    WHERE user1_id = user_id OR user2_id = user_id;
END//
DELIMITER ;
