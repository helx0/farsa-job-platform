let darkMode = localStorage.getItem('darkMode') === 'true';

if (darkMode) {
    document.body.classList.add('dark-mode');
}

function switchTab(tab) {
    document.querySelectorAll('[id$="-tab"]').forEach(el => el.style.display = 'none');
    document.getElementById(tab + '-tab').style.display = 'block';
    
    document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));
    if (event && event.target) {
        const link = event.target.closest('.sidebar-link');
        if (link) link.classList.add('active');
    }
}

function switchSection(section) {
    document.querySelectorAll('[id$="-section"]').forEach(el => {
        el.style.display = 'none';
    });
    document.getElementById(section + '-section').style.display = 'block';

    document.querySelectorAll('.sidebar-link').forEach(el => {
        el.classList.remove('active');
    });
    
    if (event && event.target) {
        const link = event.target.closest('.sidebar-link');
        if (link) link.classList.add('active');
    }

    if (window.innerWidth <= 768) {
        toggleSidebar();
    }
}

function toggleTheme() {
    if (ThemeManager && ThemeManager.toggle) {
        ThemeManager.toggle();
    } else {
        darkMode = !darkMode;
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', darkMode);
    }
}

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

function logout() {
    if (confirm('هل تريد تسجيل الخروج؟')) {
        // call server-side logout script which destroys the session and redirects
        window.location.href = '../../php/logout.php';
    }
}

window.switchTab = switchTab;
window.switchSection = switchSection;
window.toggleTheme = toggleTheme;
window.toggleSidebar = toggleSidebar;
window.logout = logout;
