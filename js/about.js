document.addEventListener('DOMContentLoaded', () => {
    initializeAnimations();
    initializeCounterAnimation();
});

function initializeAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.mission-card, .value-card, .team-card, .stat-card, .timeline-item').forEach(el => {
        observer.observe(el);
    });
}

function initializeCounterAnimation() {
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                animateCounter(entry.target);
                entry.target.classList.add('counted');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-number').forEach(el => {
        observer.observe(el);
    });
}

function animateCounter(element) {
    const targetValue = parseInt(element.getAttribute('data-count'));
    const duration = 2000;
    const start = Date.now();
    
    const animate = () => {
        const elapsed = Date.now() - start;
        const progress = Math.min(elapsed / duration, 1);
        
        const easeOutQuad = 1 - Math.pow(1 - progress, 2);
        const currentValue = Math.floor(targetValue * easeOutQuad);
        
        element.textContent = currentValue;
        
        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            element.textContent = targetValue;
        }
    };
    
    animate();
}

const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

document.head.appendChild(style);

window.navigate = function(path) {
    window.location.href = path;
};
