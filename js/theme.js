/* Theme Management */
const ThemeManager = {
    init() {
        const darkMode = localStorage.getItem('darkMode') === 'true';
        if (darkMode) {
            document.body.classList.add('dark-mode');
        }
        this.updateThemeButton();
    },
    
    toggle() {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDarkMode);
        this.updateThemeButton();
    },
    
    updateThemeButton() {
        const btn = document.getElementById('theme-toggle');
        if (btn) {
            const isDark = document.body.classList.contains('dark-mode');
            btn.innerHTML = isDark ? '☀️' : '🌙';
            btn.title = isDark ? 'المظهر الفاتح' : 'المظهر الداكن';
        }
    }
};

/* Toast Notifications */
const Toast = {
    container: null,
    
    init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        }
    },
    
    show(message, type = 'info', duration = 3000) {
        this.init();
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <span>${message}</span>
            <button style="background: none; border: none; color: inherit; font-size: 1.2rem; cursor: pointer;">&times;</button>
        `;
        
        const closeBtn = toast.querySelector('button');
        closeBtn.addEventListener('click', () => toast.remove());
        
        this.container.appendChild(toast);
        
        if (duration > 0) {
            setTimeout(() => toast.remove(), duration);
        }
        
        return toast;
    },
    
    success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    },
    
    error(message, duration = 4000) {
        return this.show(message, 'error', duration);
    },
    
    warning(message, duration = 3500) {
        return this.show(message, 'warning', duration);
    },
    
    info(message, duration = 3000) {
        return this.show(message, 'info', duration);
    }
};

/* Modal Management */
const Modal = {
    create(title, content, buttons = []) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay active';
        
        const modal = document.createElement('div');
        modal.className = 'modal';
        
        let html = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0;">${title}</h3>
                <button onclick="this.closest('.modal-overlay').remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999;">&times;</button>
            </div>
            <div style="margin-bottom: 20px;">${content}</div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
        `;
        
        buttons.forEach(btn => {
            html += `<button class="btn btn-${btn.type || 'primary'}" onclick="${btn.onclick}">${btn.text}</button>`;
        });
        
        html += '</div>';
        modal.innerHTML = html;
        overlay.appendChild(modal);
        
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.remove();
            }
        });
        
        document.body.appendChild(overlay);
        return overlay;
    },
    
    confirm(title, message, onConfirm, onCancel) {
        return this.create(title, message, [
            {
                text: 'إلغاء',
                type: 'outline',
                onclick: `this.closest('.modal-overlay').remove(); ${onCancel ? onCancel : ''}`
            },
            {
                text: 'تأكيد',
                type: 'danger',
                onclick: `this.closest('.modal-overlay').remove(); ${onConfirm}`
            }
        ]);
    },
    
    alert(title, message) {
        return this.create(title, message, [
            {
                text: 'حسناً',
                onclick: 'this.closest(".modal-overlay").remove()'
            }
        ]);
    }
};

/* Navigation Helper */
const Navigation = {
    navigate(path) {
        window.location.href = path;
    },
    
    getCurrentPage() {
        const path = window.location.pathname;
        return path.substring(path.lastIndexOf('/') + 1) || 'index.php';
    },
    
    setActiveNavLink() {
        const currentPage = this.getCurrentPage();
        document.querySelectorAll('nav a').forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href && (href.includes(currentPage) || (currentPage === 'index.php' && href === '/'))) {
                link.classList.add('active');
            }
        });
    }
};

/* Page Transition Animation */
const PageTransition = {
    startTransition(callback) {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary);
            animation: fadeOut 0.3s ease forwards;
            z-index: 9999;
        `;
        
        document.body.appendChild(overlay);
        
        setTimeout(() => {
            callback();
            overlay.remove();
        }, 150);
    }
};

/* Scroll to Top Button */
const ScrollToTop = {
    init() {
        this.button = document.createElement('button');
        this.button.id = 'scroll-to-top';
        this.button.innerHTML = '↑';
        this.button.style.cssText = `
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            cursor: pointer;
            display: none;
            font-size: 1.5rem;
            z-index: 999;
            box-shadow: var(--shadow-lg);
            transition: all var(--transition-base);
        `;
        
        this.button.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        document.body.appendChild(this.button);
        
        window.addEventListener('scroll', () => this.toggle());
    },
    
    toggle() {
        if (window.scrollY > 300) {
            this.button.style.display = 'flex';
            this.button.style.alignItems = 'center';
            this.button.style.justifyContent = 'center';
        } else {
            this.button.style.display = 'none';
        }
    }
};

/* Smooth Scroll */
document.addEventListener('click', (e) => {
    const target = e.target.closest('a[href^="#"]');
    if (target && target.hash) {
        e.preventDefault();
        const element = document.querySelector(target.hash);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

/* Initialize on Page Load */
document.addEventListener('DOMContentLoaded', () => {
    ThemeManager.init();
    Navigation.setActiveNavLink();
    ScrollToTop.init();
    
    // Add animation to cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.card').forEach(card => observer.observe(card));
});

/* Fade In Up Animation */
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

/* Expose functions globally */
window.toggleTheme = () => ThemeManager.toggle();
window.navigate = (path) => Navigation.navigate(path);
window.Toast = Toast;
window.Modal = Modal;
