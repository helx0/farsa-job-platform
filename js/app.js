class FarsaApp {
    constructor() {
        this.currentUser = null;
        this.currentLanguage = localStorage.getItem('language') || 'ar';
        this.darkMode = localStorage.getItem('darkMode') === 'true';
        this.init();
    }

    init() {
        this.loadUserSession();
        this.setupTheme();
        this.setupLanguage();
        this.setupEventListeners();
    }

    loadUserSession() {
        fetch('php/api/auth.php?action=check-session')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    this.currentUser = data.data;
                    this.updateNavigation();
                }
            })
            .catch(err => console.log('Not logged in'));
    }

    setupTheme() {
        if (this.darkMode) {
            document.body.classList.add('dark-mode');
            document.getElementById('theme-toggle').textContent = '☀️';
        } else {
            document.body.classList.remove('dark-mode');
            document.getElementById('theme-toggle').textContent = '🌙';
        }
    }

    setupLanguage() {
        document.documentElement.lang = this.currentLanguage;
        document.documentElement.dir = this.currentLanguage === 'ar' ? 'rtl' : 'ltr';
    }

    setupEventListeners() {
        window.toggleTheme = () => this.toggleTheme();
        window.toggleLanguage = () => this.toggleLanguage();
    }

    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        this.setupTheme();
    }

    toggleLanguage() {
        this.currentLanguage = this.currentLanguage === 'ar' ? 'en' : 'ar';
        localStorage.setItem('language', this.currentLanguage);
        this.setupLanguage();
        location.reload();
    }

    updateNavigation() {
        const userMenu = document.querySelector('.user-menu');
        if (userMenu && this.currentUser) {
            userMenu.innerHTML = `
                <div class="user-profile">
                    <span>${this.currentUser.user_id}</span>
                    <a href="pages/dashboard/index.php" class="btn btn-secondary">لوحة التحكم</a>
                    <button class="btn btn-danger" onclick="app.logout()">خروج</button>
                </div>
            `;
        }
    }

    logout() {
        fetch('php/api/auth.php?action=logout', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                this.showNotification(data.message, 'success');
                setTimeout(() => location.href = 'index.php', 1500);
            });
    }

    showNotification(message, type = 'info') {
        const notif = document.getElementById('notification');
        notif.className = `notification alert alert-${type}`;
        notif.textContent = message;
        notif.classList.remove('hidden');
        setTimeout(() => notif.classList.add('hidden'), 3000);
    }

    showModal(title, content) {
        const modal = document.getElementById('modal');
        if (!modal) return;
        modal.querySelector('.modal-header').textContent = title;
        modal.querySelector('.modal-body').innerHTML = content;
        modal.classList.add('active');
    }

    closeModal() {
        const modal = document.getElementById('modal');
        if (modal) modal.classList.remove('active');
    }
}

class FormValidator {
    static validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    static validatePassword(password) {
        return password.length >= 8 && 
               /[A-Z]/.test(password) && 
               /[0-9]/.test(password) && 
               /[!@#$%^&*(),.?":{}|<>]/.test(password);
    }

    static validatePhone(phone) {
        const regex = /^[0-9\-\+\(\)\.]{10,}$/;
        return regex.test(phone);
    }

    static validateForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;

        const inputs = form.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                this.showError(input, 'هذا الحقل مطلوب');
                isValid = false;
            } else {
                this.clearError(input);
            }
        });

        return isValid;
    }

    static showError(element, message) {
        element.classList.add('error');
        const errorDiv = element.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.textContent = message;
        } else {
            const div = document.createElement('div');
            div.className = 'error-message error';
            div.textContent = message;
            element.parentElement.appendChild(div);
        }
    }

    static clearError(element) {
        element.classList.remove('error');
        const errorDiv = element.parentElement.querySelector('.error-message');
        if (errorDiv) errorDiv.remove();
    }
}

class APIClient {
    static async request(endpoint, method = 'GET', data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (data && (method === 'POST' || method === 'PUT')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(endpoint, options);
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            return { status: 'error', message: 'خطأ في الاتصال' };
        }
    }

    static register(userData) {
        return this.request('php/api/auth.php?action=register', 'POST', userData);
    }

    static login(email, password) {
        return this.request('php/api/auth.php?action=login', 'POST', { email, password });
    }

    static getJobs(filters = {}, page = 1) {
        const params = new URLSearchParams();
        params.append('action', 'list');
        params.append('page', page);
        Object.entries(filters).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });
        return this.request(`php/api/jobs.php?${params.toString()}`);
    }

    static getJob(jobId) {
        return this.request(`php/api/jobs.php?action=get&id=${jobId}`);
    }

    static applyJob(jobId, coverLetter = '') {
        return this.request('php/api/jobs.php?action=apply', 'POST', {
            job_id: jobId,
            cover_letter: coverLetter
        });
    }

    static saveJob(jobId) {
        return this.request('php/api/jobs.php?action=save', 'POST', {
            job_id: jobId
        });
    }

    static getNotifications() {
        return this.request('php/api/notifications.php?action=list');
    }

    static markNotificationAsRead(notificationId) {
        return this.request(`php/api/notifications.php?action=read&id=${notificationId}`, 'POST');
    }

    static uploadCertificate(formData) {
        return fetch('php/blockchain/upload-certificate.php', {
            method: 'POST',
            body: formData
        }).then(r => r.json());
    }

    static verifyCertificate(hash) {
        return this.request(`php/blockchain/verify-certificate.php?hash=${hash}`);
    }
}

class JobMatcher {
    static async getMatches(jobId) {
        const response = await APIClient.request(`php/api/matching.php?action=get-matches&job_id=${jobId}`);
        return response;
    }

    static async getSuggestedJobs(userId) {
        const response = await APIClient.request(`php/api/matching.php?action=suggest&user_id=${userId}`);
        return response;
    }

    static calculateMatchScore(job, candidate) {
        let score = 0;

        const skillsMatch = this.matchSkills(job.required_skills, candidate.skills);
        score += skillsMatch * 0.4;

        const expMatch = Math.min(100, (candidate.experience_years / job.experience_required) * 100);
        score += expMatch * 0.25;

        const educationMatch = this.matchEducation(job.education_level, candidate.education_level);
        score += educationMatch * 0.15;

        if (job.remote_work || job.location_city === candidate.city) {
            score += 10;
        }

        if (job.salary_min <= candidate.salary_expectation <= job.salary_max) {
            score += 10;
        }

        return Math.min(100, score);
    }

    static matchSkills(jobSkills, candidateSkills) {
        if (!jobSkills || !candidateSkills) return 0;
        const jobSkillsArray = jobSkills.split(',').map(s => s.trim());
        const candidateSkillsArray = candidateSkills.split(',').map(s => s.trim());
        const matches = jobSkillsArray.filter(s => candidateSkillsArray.includes(s)).length;
        return (matches / jobSkillsArray.length) * 100;
    }

    static matchEducation(jobLevel, candidateLevel) {
        const levels = { 'high_school': 1, 'diploma': 2, 'bachelor': 3, 'master': 4, 'phd': 5 };
        const jobLevelVal = levels[jobLevel] || 0;
        const candidateLevelVal = levels[candidateLevel] || 0;
        return candidateLevelVal >= jobLevelVal ? 100 : (candidateLevelVal / jobLevelVal) * 100;
    }
}

class StorageManager {
    static set(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (e) {
            console.error('Storage error:', e);
        }
    }

    static get(key) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : null;
        } catch (e) {
            return null;
        }
    }

    static remove(key) {
        try {
            localStorage.removeItem(key);
        } catch (e) {
            console.error('Storage error:', e);
        }
    }

    static clear() {
        try {
            localStorage.clear();
        } catch (e) {
            console.error('Storage error:', e);
        }
    }
}

class PushNotificationManager {
    static async requestPermission() {
        if (!('Notification' in window)) return false;
        
        if (Notification.permission === 'granted') return true;
        
        if (Notification.permission !== 'denied') {
            const permission = await Notification.requestPermission();
            return permission === 'granted';
        }
        
        return false;
    }

    static send(title, options = {}) {
        if (Notification.permission === 'granted') {
            new Notification(title, options);
        }
    }

    static subscribe() {
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            navigator.serviceWorker.ready.then(registration => {
                registration.pushManager.getSubscription().then(subscription => {
                    if (!subscription) {
                        registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: this.urlBase64ToUint8Array(
                                'YOUR_PUBLIC_VAPID_KEY_HERE'
                            )
                        }).catch(err => console.error('Push subscription error:', err));
                    }
                });
            });
        }
    }

    static urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        return new Uint8Array([...rawData].map(char => char.charCodeAt(0)));
    }
}

const app = new FarsaApp();

window.addEventListener('online', () => {
    app.showNotification('تم الاتصال بالإنترنت', 'success');
});

window.addEventListener('offline', () => {
    app.showNotification('فقدان الاتصال بالإنترنت', 'warning');
});

console.log('Farsa App Initialized');
