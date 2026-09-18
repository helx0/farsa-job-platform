class APIClient {
    constructor(baseUrl = '/فرصة/php/api/') {
        this.baseUrl = baseUrl;
        this.headers = {
            'Content-Type': 'application/json'
        };
    }

    async request(endpoint, options = {}) {
        const url = this.baseUrl + endpoint;
        const defaultOptions = {
            method: 'GET',
            headers: this.headers,
            ...options
        };

        try {
            const response = await fetch(url, defaultOptions);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'حدث خطأ');
            }

            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    async searchJobs(filters = {}) {
        const params = new URLSearchParams();
        params.append('action', 'jobs');

        Object.entries(filters).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        return this.request(`search.php?${params.toString()}`);
    }

    async searchCandidates(filters = {}) {
        const params = new URLSearchParams();
        params.append('action', 'candidates');

        Object.entries(filters).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        return this.request(`search.php?${params.toString()}`);
    }

    async getJobDetails(jobId) {
        return this.request(`jobs.php?action=get&id=${jobId}`);
    }

    async applyForJob(jobId, coverLetter = '') {
        return this.request('applications.php?action=apply', {
            method: 'POST',
            body: JSON.stringify({
                job_id: jobId,
                cover_letter: coverLetter
            })
        });
    }

    async getApplications(filters = {}) {
        const params = new URLSearchParams();
        params.append('action', 'list');

        Object.entries(filters).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        return this.request(`applications.php?${params.toString()}`);
    }

    async getApplicationDetails(applicationId) {
        return this.request(`applications.php?action=get&id=${applicationId}`);
    }

    async updateApplicationStatus(applicationId, status, notes = '') {
        return this.request('applications.php?action=update-status', {
            method: 'POST',
            body: JSON.stringify({
                application_id: applicationId,
                status: status,
                notes: notes
            })
        });
    }

    async sendMessage(recipientId, messageBody, subject = '', relatedJobId = null) {
        return this.request('messages.php?action=send', {
            method: 'POST',
            body: JSON.stringify({
                recipient_id: recipientId,
                subject: subject,
                message_body: messageBody,
                related_job_id: relatedJobId
            })
        });
    }

    async getConversation(userId, page = 1) {
        return this.request(`messages.php?action=conversation&user_id=${userId}&page=${page}`);
    }

    async getInbox(page = 1) {
        return this.request(`messages.php?action=inbox&page=${page}`);
    }

    async getSentMessages(page = 1) {
        return this.request(`messages.php?action=sent&page=${page}`);
    }

    async getUnreadCount() {
        return this.request('messages.php?action=unread-count');
    }

    async markMessageAsRead(messageId) {
        return this.request('messages.php?action=mark-read', {
            method: 'POST',
            body: JSON.stringify({
                message_id: messageId
            })
        });
    }

    async deleteMessage(messageId) {
        return this.request('messages.php?action=delete', {
            method: 'POST',
            body: JSON.stringify({
                message_id: messageId
            })
        });
    }

    async addReview(reviewData) {
        return this.request('reviews.php?action=add', {
            method: 'POST',
            body: JSON.stringify(reviewData)
        });
    }

    async getCompanyReviews(companyId, page = 1) {
        return this.request(`reviews.php?action=list&company_id=${companyId}&page=${page}`);
    }

    async getCompanyStats(companyId) {
        return this.request(`reviews.php?action=stats&company_id=${companyId}`);
    }

    async getPendingReviews(page = 1) {
        return this.request(`reviews.php?action=pending&page=${page}`);
    }

    async approveReview(reviewId) {
        return this.request('reviews.php?action=approve', {
            method: 'POST',
            body: JSON.stringify({
                review_id: reviewId
            })
        });
    }

    async rejectReview(reviewId, reason = '') {
        return this.request('reviews.php?action=reject', {
            method: 'POST',
            body: JSON.stringify({
                review_id: reviewId,
                reason: reason
            })
        });
    }

    async deleteReview(reviewId) {
        return this.request('reviews.php?action=delete', {
            method: 'POST',
            body: JSON.stringify({
                review_id: reviewId
            })
        });
    }
}

const api = new APIClient();

class JobMatcher {
    static getMatchColor(score) {
        if (score >= 80) return '#10b981';
        if (score >= 60) return '#f59e0b';
        if (score >= 40) return '#ef4444';
        return '#6b7280';
    }

    static getMatchText(score) {
        if (score >= 80) return 'مطابقة ممتازة';
        if (score >= 60) return 'مطابقة جيدة';
        if (score >= 40) return 'مطابقة متوسطة';
        return 'مطابقة ضعيفة';
    }

    static createMatchCard(job, matchScore = null) {
        const container = document.createElement('div');
        container.className = 'job-card';
        container.innerHTML = `
            <div class="job-header">
                <h3>${job.job_title_ar}</h3>
                ${matchScore ? `<span class="match-badge" style="background: ${this.getMatchColor(matchScore)}">
                    ${matchScore}% ${this.getMatchText(matchScore)}
                </span>` : ''}
            </div>
            <div class="company-info">
                ${job.company_logo ? `<img src="${job.company_logo}" alt="${job.company_name}">` : ''}
                <p>${job.company_name}</p>
            </div>
            <div class="job-details">
                <span class="location"><i class="fas fa-map-marker-alt"></i> ${job.location_city}</span>
                <span class="salary"><i class="fas fa-briefcase"></i> ${job.salary_min}-${job.salary_max}</span>
            </div>
            <p class="description">${job.job_description_ar.substring(0, 200)}...</p>
            <button class="btn btn-primary" onclick="viewJobDetails(${job.id})">عرض التفاصيل</button>
        `;
        return container;
    }
}

class NotificationManager {
    static async checkUnreadMessages() {
        try {
            const response = await api.getUnreadCount();
            if (response.data && response.data.count > 0) {
                this.updateBadge(response.data.count);
            }
        } catch (error) {
            console.error('Error checking unread messages:', error);
        }
    }

    static updateBadge(count) {
        const badge = document.getElementById('message-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'block' : 'none';
        }
    }

    static async pollMessages(interval = 30000) {
        setInterval(() => {
            this.checkUnreadMessages();
        }, interval);
    }
}

class ApplicationManager {
    static async applyJob(jobId, coverLetter = '') {
        try {
            const response = await api.applyForJob(jobId, coverLetter);
            if (response.status === 'success') {
                Toast.success('تم تقديم الطلب بنجاح');
                return true;
            }
        } catch (error) {
            Toast.error(error.message || 'فشل تقديم الطلب');
            return false;
        }
    }

    static async getApplicationsList(filters = {}) {
        try {
            const response = await api.getApplications(filters);
            if (response.status === 'success') {
                return response.data.applications;
            }
        } catch (error) {
            Toast.error('خطأ في جلب الطلبات');
            return [];
        }
    }

    static async updateStatus(applicationId, status) {
        try {
            const response = await api.updateApplicationStatus(applicationId, status);
            if (response.status === 'success') {
                Toast.success('تم تحديث الحالة');
                return true;
            }
        } catch (error) {
            Toast.error(error.message || 'فشل التحديث');
            return false;
        }
    }
}

class MessageManager {
    static async sendMessage(recipientId, messageBody, subject = '') {
        try {
            const response = await api.sendMessage(recipientId, messageBody, subject);
            if (response.status === 'success') {
                Toast.success('تم إرسال الرسالة');
                return true;
            }
        } catch (error) {
            Toast.error(error.message || 'فشل إرسال الرسالة');
            return false;
        }
    }

    static async loadConversation(userId, page = 1) {
        try {
            const response = await api.getConversation(userId, page);
            if (response.status === 'success') {
                return response.data.messages;
            }
        } catch (error) {
            Toast.error('خطأ في جلب الرسائل');
            return [];
        }
    }

    static async loadInbox(page = 1) {
        try {
            const response = await api.getInbox(page);
            if (response.status === 'success') {
                return response.data.messages;
            }
        } catch (error) {
            Toast.error('خطأ في جلب البريد الوارد');
            return [];
        }
    }

    static renderConversation(messages) {
        const container = document.getElementById('conversation-messages');
        if (!container) return;

        container.innerHTML = messages.map(msg => `
            <div class="message ${msg.sender_id === currentUserId ? 'sent' : 'received'}">
                <div class="message-header">
                    <strong>${msg.full_name}</strong>
                    <small>${new Date(msg.created_at).toLocaleString('ar-SA')}</small>
                </div>
                <p class="message-body">${msg.message_body}</p>
                ${msg.sender_id !== currentUserId ? `
                    <button class="btn btn-sm" onclick="markAsRead(${msg.id})">وضع علامة مقروءة</button>
                ` : ''}
            </div>
        `).join('');

        container.scrollTop = container.scrollHeight;
    }
}

class ReviewManager {
    static async submitReview(reviewData) {
        try {
            const response = await api.addReview(reviewData);
            if (response.status === 'success') {
                Toast.success('تم إرسال التقييم للمراجعة');
                return true;
            }
        } catch (error) {
            Toast.error(error.message || 'فشل إرسال التقييم');
            return false;
        }
    }

    static async loadCompanyReviews(companyId, page = 1) {
        try {
            const response = await api.getCompanyReviews(companyId, page);
            if (response.status === 'success') {
                return {
                    reviews: response.data.reviews,
                    stats: response.data.stats
                };
            }
        } catch (error) {
            console.error('Error loading reviews:', error);
            return { reviews: [], stats: null };
        }
    }

    static renderReviews(reviews, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = reviews.map(review => `
            <div class="review-item">
                <div class="review-header">
                    <strong>${review.full_name}</strong>
                    <div class="rating">
                        ${'★'.repeat(review.rating)}${'☆'.repeat(5-review.rating)}
                    </div>
                </div>
                <h4>${review.review_title_ar}</h4>
                <p>${review.review_text_ar}</p>
                ${review.verified_applicant ? '<span class="badge badge-success">موظف تم التحقق</span>' : ''}
                ${review.would_recommend ? '<span class="badge badge-info">ينصح به</span>' : ''}
            </div>
        `).join('');
    }

    static renderStats(stats, containerId) {
        const container = document.getElementById(containerId);
        if (!container || !stats) return;

        container.innerHTML = `
            <div class="stats-grid">
                <div class="stat-item">
                    <strong>${stats.average_rating}</strong>
                    <p>التقييم العام</p>
                </div>
                <div class="stat-item">
                    <strong>${stats.total_reviews}</strong>
                    <p>عدد التقييمات</p>
                </div>
                <div class="stat-item">
                    <strong>${stats.recommended_count}</strong>
                    <p>ينصح به</p>
                </div>
                <div class="stat-item">
                    <strong>${stats.verified_reviews}</strong>
                    <p>موظفون تحقق</p>
                </div>
            </div>
        `;
    }
}

const Toast = {
    success: (message) => {
        console.log('✓', message);
        showNotification(message, 'success');
    },
    error: (message) => {
        console.error('✗', message);
        showNotification(message, 'error');
    },
    warning: (message) => {
        console.warn('⚠', message);
        showNotification(message, 'warning');
    },
    info: (message) => {
        console.info('ℹ', message);
        showNotification(message, 'info');
    }
};

let currentUserId = null;

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    NotificationManager.pollMessages();
});
