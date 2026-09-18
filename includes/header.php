<header class="header" style="background: white; padding: 15px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="header-content" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <a href="../index.php" class="logo" style="font-size: 1.5rem; font-weight: 700; text-decoration: none; color: #667eea; display: flex; align-items: center; gap: 8px;">
                🚀 فرصة
            </a>
            <nav style="display: flex; gap: 30px;">
                <ul class="nav" style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0;">
                    <li><a href="../index.php" style="text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; cursor: pointer;">الرئيسية</a></li>
                    <li><a href="../pages/jobs.php" style="text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; cursor: pointer;">الوظائف</a></li>
                    <li><a href="../pages/courses.php" style="text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; cursor: pointer;">الدورات</a></li>
                    <li><a href="../pages/about.php" style="text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; cursor: pointer;">عن المنصة</a></li>
                    <li><a href="../pages/contact.php" style="text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s; cursor: pointer;">تواصل معنا</a></li>
                </ul>
            </nav>
            <div class="user-menu" style="display: flex; gap: 15px; align-items: center;">
                <button class="btn btn-outline" onclick="navigate('../pages/auth/login.php')" style="padding: 8px 16px; border: 2px solid #667eea; background: transparent; color: #667eea; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">دخول</button>
                <button class="btn btn-primary" onclick="navigate('../pages/auth/register.php')" style="padding: 8px 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">تسجيل</button>
                <button class="btn" id="theme-toggle" onclick="toggleTheme()" title="تبديل المظهر" style="background: none; border: none; font-size: 1.2rem; cursor: pointer;">🌙</button>
            </div>
        </div>
    </div>
</header>
