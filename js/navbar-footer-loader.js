async function loadNavbarAndFooter() {
    try {
        const currentPath = window.location.pathname;
        const isInAuth = currentPath.includes('/pages/auth/');
        const isInPages = currentPath.includes('/pages/') && !isInAuth;
        const isInDashboard = currentPath.includes('/pages/dashboard/');
        
        let upLevels = '';
        if (isInAuth) {
            upLevels = '../../';
        } else if (isInDashboard) {
            upLevels = '../../../';
        } else if (isInPages) {
            upLevels = '../';
        }

        const navbarContainer = document.getElementById('navbar-container');
        const footerContainer = document.getElementById('footer-container');

        let indexPath, jobsPath, coursesPath, aboutPath, contactPath, loginPath, registerPath;
        
        if (!upLevels) {
            indexPath = 'index.php';
            jobsPath = 'pages/jobs.php';
            coursesPath = 'pages/courses.php';
            aboutPath = 'pages/about.php';
            contactPath = 'pages/contact.php';
            loginPath = 'pages/auth/login.php';
            registerPath = 'pages/auth/register.php';
        } else if (isInPages) {
            indexPath = '../index.php';
            jobsPath = './jobs.php';
            coursesPath = './courses.php';
            aboutPath = './about.php';
            contactPath = './contact.php';
            loginPath = './auth/login.php';
            registerPath = './auth/register.php';
        } else if (isInAuth) {
            indexPath = upLevels + 'index.php';
            jobsPath = upLevels + 'pages/jobs.php';
            coursesPath = upLevels + 'pages/courses.php';
            aboutPath = upLevels + 'pages/about.php';
            contactPath = upLevels + 'pages/contact.php';
            loginPath = './login.php';
            registerPath = './register.php';
        } else if (isInDashboard) {
            indexPath = upLevels + 'index.php';
            jobsPath = upLevels + 'pages/jobs.php';
            coursesPath = upLevels + 'pages/courses.php';
            aboutPath = upLevels + 'pages/about.php';
            contactPath = upLevels + 'pages/contact.php';
            loginPath = upLevels + 'pages/auth/login.php';
            registerPath = upLevels + 'pages/auth/register.php';
        }

        if (navbarContainer) {
            const navbarWrapper = document.createElement('div');
            navbarWrapper.className = 'navbar';
            
            navbarWrapper.innerHTML = `
                <div class="navbar-container">
                    <a href="${indexPath}" class="navbar-logo">
                        <span>🚀</span> فرصة
                    </a>
                    <button class="mobile-menu-toggle" id="mobile-menu-btn" aria-label="قائمة الملاحة">
                        <i class="fas fa-bars"></i>
                    </button>
                    <nav class="navbar-nav" id="navbar-nav">
                        <li><a href="${indexPath}" class="nav-link">الرئيسية</a></li>
                        <li><a href="${jobsPath}" class="nav-link">الوظائف</a></li>
                        <li><a href="${coursesPath}" class="nav-link">الدورات</a></li>
                        <li><a href="${aboutPath}" class="nav-link">عن المنصة</a></li>
                        <li><a href="${contactPath}" class="nav-link">تواصل معنا</a></li>
                    </nav>
                    <div class="navbar-user-menu" id="navbar-user-menu">
                        ${isInDashboard ? '' : `
                        <button class="navbar-btn navbar-btn-outline" onclick="navigate('${loginPath}')">دخول</button>
                        <button class="navbar-btn navbar-btn-primary" onclick="navigate('${registerPath}')">تسجيل</button>
                        <button class="theme-toggle-btn" id="navbar-theme-toggle" onclick="toggleTheme()" title="تبديل المظهر">🌙</button>
                        `}
                    </div>
                </div>
            `;
            navbarContainer.appendChild(navbarWrapper);

            updateNavbarActive();
            setupNavbarScroll();
            setupMobileMenu();
        }

        if (footerContainer) {
            const footerWrapper = document.createElement('footer');
            
            let footerIndexPath = indexPath;
            let footerJobsPath = jobsPath;
            let footerCoursesPath = coursesPath;
            let footerAboutPath = aboutPath;
            let footerContactPath = contactPath;
            
            const footerContent = `
                <div class="container" style="max-width: 1200px; margin: 0 auto;">
                    <div class="footer-content">
                        <div class="footer-section">
                            <h3>🚀 فرصة</h3>
                            <p>
                                منصة التوظيف الذكية الأولى في اليمن تربطك بأفضل الفرص الوظيفية والتدريبية مع أكبر الشركات والمنظمات.
                            </p>
                        </div>

                        <div class="footer-section">
                            <h3>روابط سريعة</h3>
                            <ul>
                                <li><a href="${footerIndexPath}">الرئيسية</a></li>
                                <li><a href="${footerJobsPath}">الوظائف</a></li>
                                <li><a href="${footerCoursesPath}">الدورات</a></li>
                                <li><a href="${footerAboutPath}">عن المنصة</a></li>
                            </ul>
                        </div>

                        <div class="footer-section">
                            <h3>الموارد</h3>
                            <ul>
                                <li><a href="${footerContactPath}">تواصل معنا</a></li>
                                <li><a href="#">سياسة الخصوصية</a></li>
                                <li><a href="#">شروط الاستخدام</a></li>
                                <li><a href="#">الأسئلة الشائعة</a></li>
                            </ul>
                        </div>

                        <div class="footer-section">
                            <h3>تواصل معنا</h3>
                            <div class="footer-contact-info">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:support@farsa.com">support@farsa.com</a>
                            </div>
                            <div class="footer-contact-info">
                                <i class="fas fa-phone"></i>
                                <a href="tel:+967123456789">+967 123456789</a>
                            </div>
                            <div class="footer-socials">
                                <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="footer-divider">
                        <p>جميع الحقوق محفوظة © 2024 <a href="${footerIndexPath}">فرصة - منصة التوظيف الذكية</a> | تطوير مع ❤️ لليمن</p>
                    </div>
                </div>
            `;
            footerWrapper.innerHTML = footerContent;
            footerContainer.appendChild(footerWrapper);
        }
    } catch (error) {
        console.error('Error loading navbar/footer:', error);
    }
}

function updateNavbarActive() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPath = window.location.pathname;

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        const linkPath = window.location.origin + href.replace(/^\.\.\//, '/').replace(/^\//, '');
        const currentFullPath = window.location.href;

        if (currentFullPath.includes(href) || currentFullPath.includes(href.split('/').pop())) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

function setupNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
}

function setupMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navbarNav = document.getElementById('navbar-nav');
    const navbarUserMenu = document.getElementById('navbar-user-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    if (mobileMenuBtn && navbarNav) {
        mobileMenuBtn.addEventListener('click', () => {
            navbarNav.classList.toggle('mobile-active');
            navbarUserMenu.classList.toggle('mobile-active');
            mobileMenuBtn.classList.toggle('mobile-active');
        });

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navbarNav.classList.remove('mobile-active');
                navbarUserMenu.classList.remove('mobile-active');
                mobileMenuBtn.classList.remove('mobile-active');
            });
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.navbar-container')) {
                navbarNav.classList.remove('mobile-active');
                navbarUserMenu.classList.remove('mobile-active');
                mobileMenuBtn.classList.remove('mobile-active');
            }
        });
    }
}

function navigate(path) {
    window.location.href = path;
}

document.addEventListener('DOMContentLoaded', loadNavbarAndFooter);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadNavbarAndFooter);
} else {
    loadNavbarAndFooter();
}
