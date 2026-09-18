<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/navbar-footer.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        body.dark-mode {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        #navbar-container {
            flex-shrink: 0;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        #footer-container {
            flex-shrink: 0;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1000px;
            height: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                height: auto;
            }

            .login-left {
                display: none;
            }
        }

        body.dark-mode .login-wrapper {
            background: #1e293b;
            color: #e2e8f0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -100px;
            right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            left: -50px;
        }

        .login-left > * {
            position: relative;
            z-index: 1;
        }

        .login-logo {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .login-left h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .login-left p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .features-list {
            text-align: right;
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 100%;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
            opacity: 0.95;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .feature-item i {
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .feature-item span {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .login-right {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #1e40af;
        }

        body.dark-mode .login-right h2 {
            color: #60a5fa;
        }

        .login-right .subtitle {
            color: #999;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        body.dark-mode .login-right .subtitle {
            color: #94a3b8;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        body.dark-mode .form-group label {
            color: #cbd5e1;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i {
            position: absolute;
            right: 15px;
            color: #1e40af;
            font-size: 1.1rem;
        }

        body.dark-mode .input-group i {
            color: #60a5fa;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        body.dark-mode .form-group input {
            background-color: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
            background-color: white;
        }

        body.dark-mode .form-group input:focus {
            background-color: #1e293b;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        }

        .form-group input::placeholder {
            color: #bbb;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            margin: 0;
            color: #666;
        }

        body.dark-mode .remember-forgot label {
            color: #cbd5e1;
        }

        .remember-forgot input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-forgot a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        body.dark-mode .remember-forgot a {
            color: #60a5fa;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .btn-login.loading .spinner {
            display: block;
        }

        .btn-login.loading span {
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #bbb;
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%; 
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        body.dark-mode .divider::before {
            background: #334155;
        }

        .divider span {
            position: relative;
            background: white;
            padding: 0 10px;
        }

        body.dark-mode .divider span {
            background: #1e293b;
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        body.dark-mode .signup-link {
            color: #cbd5e1;
        }

        .signup-link a {
            color: #1e40af;
            font-weight: 700;
            text-decoration: none;
        }

        body.dark-mode .signup-link a {
            color: #60a5fa;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ef4444;
            display: none;
            font-size: 0.9rem;
        }

        body.dark-mode .error-message {
            background: #7f1d1d;
            color: #fca5a5;
            border-left-color: #f87171;
        }

        .error-message.show {
            display: block;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 1024px) {
            .login-wrapper {
                max-width: 95%;
                height: auto;
            }

            .login-left {
                padding: 40px;
            }

            .login-right {
                padding: 40px;
            }

            .features-list {
                margin-top: 30px;
            }
        }

        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                height: auto;
                max-width: 100%;
                border-radius: 0;
                width: 100%;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .login-left {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 40px 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 300px;
            }

            .login-logo {
                font-size: 3rem;
                margin-bottom: 15px;
            }

            .login-left h1 {
                font-size: 1.8rem;
            }

            .login-left p {
                font-size: 0.95rem;
                margin-bottom: 20px;
            }

            .features-list {
                margin-top: 20px;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                width: 100%;
            }

            .feature-item {
                padding: 10px;
                gap: 8px;
            }

            .feature-item i {
                font-size: 1.5rem;
            }

            .feature-item span {
                font-size: 0.8rem;
            }

            .login-right {
                padding: 30px 20px;
            }

            .login-right h2 {
                font-size: 1.5rem;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 10px;
            }

            .btn-login {
                margin-bottom: 12px;
            }
        }

        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }

            .login-wrapper {
                border-radius: 0;
            }

            .login-left {
                padding: 30px 15px;
                min-height: 250px;
            }

            .login-logo {
                font-size: 2.5rem;
            }

            .login-left h1 {
                font-size: 1.5rem;
            }

            .login-left p {
                font-size: 0.9rem;
                margin-bottom: 15px;
            }

            .features-list {
                gap: 8px;
                margin-top: 15px;
            }

            .feature-item {
                padding: 8px;
                font-size: 0.75rem;
            }

            .feature-item i {
                font-size: 1.3rem;
            }

            .login-right {
                padding: 20px 15px;
            }

            .login-right h2 {
                font-size: 1.3rem;
                margin-bottom: 8px;
            }

            .login-right .subtitle {
                font-size: 0.85rem;
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 0.85rem;
            }

            .form-group input {
                padding: 10px 12px 10px 35px;
                font-size: 0.9rem;
            }

            .remember-forgot {
                font-size: 0.85rem;
                gap: 8px;
            }

            .btn-login {
                padding: 11px;
                font-size: 0.95rem;
            }

            .divider {
                margin: 20px 0;
                font-size: 0.85rem;
            }

            .signup-link {
                font-size: 0.85rem;
            }

            .error-message {
                padding: 10px 12px;
                font-size: 0.85rem;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>
    <main>
    <div class="login-wrapper">
        <div class="login-left">
            <div class="login-logo">🚀</div>
            <h1>مرحباً بك في فرصة</h1>
            <p>منصة التوظيف الذكية الأولى في اليمن</p>
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>مطابقة ذكية للوظائف</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>شهادات آمنة بالبلوكشين</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>دعم دورات تدريبية</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>عمل متجاوب على جميع الأجهزة</span>
                </div>
            </div>
        </div>

        <div class="login-right">
            <h2>تسجيل الدخول</h2>
            <p class="subtitle">استخدم بيانات حسابك للدخول</p>

            <div class="error-message" id="errorMessage"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" placeholder="user@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" id="remember">
                        تذكرني
                    </label>
                    <a href="forgot-password.html">هل نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span>تسجيل الدخول</span>
                    <div class="spinner"></div>
                </button>
            </form>

            <div class="divider"><span>أو</span></div>

            <div class="signup-link">
                ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a>
            </div>
        </div>
    </div>
    </main>

    <div id="footer-container"></div>

    <script>
        const form = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const errorMessage = document.getElementById('errorMessage');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;

            errorMessage.classList.remove('show');
            loginBtn.disabled = true;
            loginBtn.classList.add('loading');

            try {
                const response = await fetch('../../api_login.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        remember: remember
                    })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    setTimeout(() => {
                        if (data.data.user_type === 'job_seeker') {
                            window.location.href = '../dashboard/job-seeker/index.php';
                        } else if (data.data.user_type === 'employer') {
                            window.location.href = '../dashboard/employer/index.php';
                        } else if (data.data.user_type === 'admin') {
                            window.location.href = '../dashboard/admin/index.php';
                        } else {
                            window.location.href = '../../index.php';
                        }
                    }, 500);
                } else {
                    errorMessage.textContent = data.message || 'فشل تسجيل الدخول. تحقق من البريد الإلكتروني وكلمة المرور.';
                    errorMessage.classList.add('show');
                    console.error('Login error response:', data);
                }
            } catch (error) {
                console.error('Network error:', error);
                errorMessage.textContent = 'حدث خطأ في الاتصال بالخادم. تأكد من:' + '\n' + 
                    '1. تشغيل خادم Apache' + '\n' + 
                    '2. تشغيل MySQL' + '\n' +
                    '3. استيراد قاعدة البيانات (database.sql)';
                errorMessage.classList.add('show');
            } finally {
                loginBtn.disabled = false;
                loginBtn.classList.remove('loading');
            }
        });

        window.toggleTheme = function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        };
    </script>
    <script src="../../js/navbar-footer-loader.js"></script>
</body>
</html>
