<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/theme.css">
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

        .register-container {
            max-width: 550px;
            width: 100%;
            animation: slideUp 0.6s ease;
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

        .register-card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 30px 20px;
            }

            main {
                padding: 20px 15px;
            }
        }

        body.dark-mode .register-card {
            background: #1e293b;
            color: #e2e8f0;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-logo {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .register-header h1 {
            font-size: 2rem;
            color: #1e40af;
            margin-bottom: 10px;
        }

        body.dark-mode .register-header h1 {
            color: #60a5fa;
        }

        .register-header p {
            color: #666;
            font-size: 0.95rem;
        }

        body.dark-mode .register-header p {
            color: #cbd5e1;
        }

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
        }

        body.dark-mode .tabs {
            border-bottom-color: #334155;
        }

        .tab {
            padding: 14px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #999;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab:hover {
            color: #1e40af;
        }

        .tab.active {
            color: #1e40af;
        }

        body.dark-mode .tab.active {
            color: #60a5fa;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-group {
            margin-bottom: 18px;
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
            font-size: 1rem;
        }

        body.dark-mode .input-group i {
            color: #60a5fa;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 15px 11px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        body.dark-mode .form-group input,
        body.dark-mode .form-group select {
            background-color: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
            background-color: white;
        }

        body.dark-mode .form-group input:focus,
        body.dark-mode .form-group select:focus {
            background-color: #1e293b;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        }

        .form-group input::placeholder {
            color: #bbb;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .password-strength {
            display: flex;
            gap: 3px;
            margin-top: 8px;
        }

        .strength-bar {
            flex: 1;
            height: 3px;
            background: #e2e8f0;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-bar.filled.weak {
            background: #ef4444;
        }

        .strength-bar.filled.medium {
            background: #f59e0b;
        }

        .strength-bar.filled.strong {
            background: #10b981;
        }

        .strength-text {
            font-size: 0.75rem;
            margin-top: 4px;
            color: #666;
        }

        body.dark-mode .strength-text {
            color: #94a3b8;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .checkbox-group label {
            margin: 0;
            font-size: 0.85rem;
            color: #666;
            cursor: pointer;
            line-height: 1.4;
        }

        body.dark-mode .checkbox-group label {
            color: #cbd5e1;
        }

        .checkbox-group a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 600;
        }

        body.dark-mode .checkbox-group a {
            color: #60a5fa;
        }

        .checkbox-group a:hover {
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

        .btn-register {
            width: 100%;
            padding: 12px;
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

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        .btn-register:disabled {
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

        .btn-register.loading .spinner {
            display: block;
        }

        .btn-register.loading span {
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-link {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        body.dark-mode .login-link {
            color: #cbd5e1;
        }

        .login-link a {
            color: #1e40af;
            font-weight: 700;
            text-decoration: none;
        }

        body.dark-mode .login-link a {
            color: #60a5fa;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .register-card {
                padding: 30px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .register-header h1 {
                font-size: 1.5rem;
            }

            .register-logo {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>
    <main>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">✨</div>
                <h1>إنشاء حساب جديد</h1>
                <p>انضم إلى الآلاف من الباحثين عن العمل والشركات</p>
            </div>

            <div class="tabs">
                <button class="tab active" onclick="switchTab('job_seeker', this)">📋 باحث عن عمل</button>
                <button class="tab" onclick="switchTab('employer', this)">🏢 صاحب عمل</button>
            </div>

            <div class="error-message" id="errorMessage"></div>

            <form id="registerForm">
                <input type="hidden" id="userType" value="job_seeker">

                <div class="form-group">
                    <label for="fullName"><i class="fas fa-user" style="margin-left: 6px; color: #1e40af;"></i>الاسم الكامل</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="fullName" placeholder="أحمد محمد علي" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username"><i class="fas fa-at" style="margin-left: 6px; color: #1e40af;"></i>اسم المستخدم</label>
                    <div class="input-group">
                        <i class="fas fa-at"></i>
                        <input type="text" id="username" placeholder="ahmedmohamed2024" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope" style="margin-left: 6px; color: #1e40af;"></i>البريد الإلكتروني</label>
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" placeholder="ahmed@example.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone" style="margin-left: 6px; color: #1e40af;"></i>رقم الهاتف</label>
                        <div class="input-group">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="phone" placeholder="+967 7x xxx xxxx" required>
                        </div>
                    </div>
                </div>

                <div id="jobSeekerFields" style="display: block;">
                    <div class="form-group">
                        <label for="city"><i class="fas fa-map-marker-alt" style="margin-left: 6px; color: #1e40af;"></i>المدينة</label>
                        <div class="input-group">
                            <i class="fas fa-map-marker-alt"></i>
                            <select id="city" required>
                                <option value="">اختر المدينة</option>
                                <option value="صنعاء">صنعاء</option>
                                <option value="عدن">عدن</option>
                                <option value="تعز">تعز</option>
                                <option value="إب">إب</option>
                                <option value="الحديدة">الحديدة</option>
                                <option value="لحج">لحج</option>
                                <option value="ذمار">ذمار</option>
                                <option value="أبين">أبين</option>
                                <option value="الضالع">الضالع</option>
                                <option value="حجة">حجة</option>
                                <option value="مأرب">مأرب</option>
                                <option value="شبوة">شبوة</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="employerFields" style="display: none;">
                    <div class="form-group">
                        <label for="companyName"><i class="fas fa-building" style="margin-left: 6px; color: #1e40af;"></i>اسم الشركة</label>
                        <div class="input-group">
                            <i class="fas fa-building"></i>
                            <input type="text" id="companyName" placeholder="شركة فرصة للتوظيف">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="industry"><i class="fas fa-industry" style="margin-left: 6px; color: #1e40af;"></i>مجال التخصص</label>
                        <div class="input-group">
                            <i class="fas fa-industry"></i>
                            <select id="industry">
                                <option value="">اختر المجال</option>
                                <option value="technology">تكنولوجيا المعلومات</option>
                                <option value="finance">المالية والبنوك</option>
                                <option value="education">التعليم</option>
                                <option value="healthcare">الصحة</option>
                                <option value="retail">التجزئة</option>
                                <option value="manufacturing">التصنيع</option>
                                <option value="logistics">الخدمات واللوجستيات</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock" style="margin-left: 6px; color: #1e40af;"></i>كلمة المرور</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="أدخل كلمة مرور قوية" required>
                    </div>
                    <div class="password-strength" id="strengthBars">
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                    </div>
                    <div class="strength-text" id="strengthText">كلمة المرور ضعيفة جداً</div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword"><i class="fas fa-check-circle" style="margin-left: 6px; color: #1e40af;"></i>تأكيد كلمة المرور</label>
                    <div class="input-group">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" id="confirmPassword" placeholder="أعد إدخال كلمة المرور" required>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">أوافق على <a href="#">شروط الاستخدام</a> و<a href="#">سياسة الخصوصية</a> والحصول على رسائل بريدية</label>
                </div>

                <button type="submit" class="btn-register" id="registerBtn">
                    <span>إنشاء الحساب</span>
                    <div class="spinner"></div>
                </button>
            </form>

            <div class="login-link">
                هل لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a>
            </div>
        </div>
    </div>
    </main>

    <div id="footer-container"></div>

    <script>
        const form = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const errorMessage = document.getElementById('errorMessage');
        const passwordInput = document.getElementById('password');
        const strengthBars = document.querySelectorAll('.strength-bar');
        const strengthText = document.getElementById('strengthText');

        function switchTab(type, btn) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('userType').value = type;

            if (type === 'job_seeker') {
                document.getElementById('jobSeekerFields').style.display = 'block';
                document.getElementById('employerFields').style.display = 'none';
                document.getElementById('city').required = true;
                document.getElementById('companyName').required = false;
            } else {
                document.getElementById('jobSeekerFields').style.display = 'none';
                document.getElementById('employerFields').style.display = 'block';
                document.getElementById('city').required = false;
                document.getElementById('companyName').required = true;
            }
        }

        window.switchTab = switchTab;

        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

            strengthBars.forEach((bar, index) => {
                bar.classList.remove('filled', 'weak', 'medium', 'strong');
                if (index < strength) {
                    bar.classList.add('filled');
                    bar.classList.add(strength <= 2 ? 'weak' : strength === 3 ? 'medium' : 'strong');
                }
            });

            if (strength <= 1) {
                strengthText.textContent = 'كلمة المرور ضعيفة جداً';
                strengthText.style.color = '#ef4444';
            } else if (strength === 2) {
                strengthText.textContent = 'كلمة المرور ضعيفة';
                strengthText.style.color = '#f59e0b';
            } else if (strength === 3) {
                strengthText.textContent = 'كلمة المرور متوسطة';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthText.textContent = 'كلمة المرور قوية جداً';
                strengthText.style.color = '#10b981';
            }
        }

        passwordInput.addEventListener('input', (e) => {
            checkPasswordStrength(e.target.value);
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            errorMessage.classList.remove('show');

            if (password !== confirmPassword) {
                errorMessage.textContent = '❌ كلمات المرور غير متطابقة';
                errorMessage.classList.add('show');
                return;
            }

            if (password.length < 8) {
                errorMessage.textContent = '❌ كلمة المرور يجب أن تكون 8 أحرف على الأقل';
                errorMessage.classList.add('show');
                return;
            }

            const userType = document.getElementById('userType').value;
            const fullName = document.getElementById('fullName').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            const data = {
                username: username,
                full_name: fullName,
                email: email,
                phone: phone,
                password: password,
                user_type: userType
            };

            if (userType === 'job_seeker') {
                data.city = document.getElementById('city').value;
            } else {
                data.company_name = document.getElementById('companyName').value;
                data.industry = document.getElementById('industry').value;
            }

            registerBtn.disabled = true;
            registerBtn.classList.add('loading');

            try {
                const response = await fetch('../../php/api/auth.php?action=register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.status === 'success') {
                    errorMessage.classList.remove('show');
                    setTimeout(() => {
                        if (result.data.user_type === 'job_seeker') {
                            window.location.href = '../dashboard/job-seeker/index.php';
                        } else if (result.data.user_type === 'employer') {
                            window.location.href = '../dashboard/employer/index.php';
                        } else {
                            window.location.href = 'login.php';
                        }
                    }, 500);
                } else {
                    errorMessage.textContent = '❌ ' + (result.message || 'فشل إنشاء الحساب');
                    errorMessage.classList.add('show');
                }
            } catch (error) {
                errorMessage.textContent = '❌ حدث خطأ في الاتصال. حاول مجدداً.';
                errorMessage.classList.add('show');
            } finally {
                registerBtn.disabled = false;
                registerBtn.classList.remove('loading');
            }
        });

        window.toggleTheme = function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        };
    </script>
    <script src="../../js/theme.js"></script>
    <script src="../../js/navbar-footer-loader.js"></script>
</body>
</html>
