<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="تواصل معنا في منصة فرصة">
    <title>تواصل معنا - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/navbar-footer.css">
</head>
<body>
    <div id="navbar-container"></div>

    <section style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 80px 20px; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3rem; margin-bottom: 20px;">تواصل معنا</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                لدينا دائماً أذن صاغية لآرائك واقتراحاتك ورسائلك
            </p>
        </div>
    </section>

    <section class="container py-20">
        <div class="grid grid-cols-2" style="margin-bottom: 40px;">
            <!-- Contact Info -->
            <div>
                <h2 style="margin-bottom: 30px;">طرق التواصل</h2>
                
                <div class="card" style="margin-bottom: 20px;">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <div style="font-size: 1.5rem; color: var(--primary); flex-shrink: 0;">📍</div>
                        <div>
                            <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">العنوان</h3>
                            <p style="color: #666; margin: 0;">
                                صنعاء، اليمن<br>
                                الحي الدبلوماسي<br>
                                شارع الثورة
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 20px;">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <div style="font-size: 1.5rem; color: var(--info); flex-shrink: 0;">📧</div>
                        <div>
                            <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">البريد الإلكتروني</h3>
                            <p style="color: #666; margin: 0;">
                                <a href="mailto:support@farsa.com" style="color: var(--primary);">support@farsa.com</a><br>
                                <a href="mailto:info@farsa.com" style="color: var(--primary);">info@farsa.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 20px;">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <div style="font-size: 1.5rem; color: var(--success); flex-shrink: 0;">📱</div>
                        <div>
                            <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">الهاتف</h3>
                            <p style="color: #666; margin: 0;">
                                +967 123456789<br>
                                +967 987654321
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div style="display: flex; gap: 15px; align-items: flex-start;">
                        <div style="font-size: 1.5rem; color: var(--warning); flex-shrink: 0;">⏰</div>
                        <div>
                            <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">أوقات العمل</h3>
                            <p style="color: #666; margin: 0;">
                                الأحد - الخميس: 8:00 - 18:00<br>
                                الجمعة والسبت: مغلق
                            </p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h3 style="margin-bottom: 15px;">تابعنا على:</h3>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" class="btn btn-primary btn-small">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-primary btn-small">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-primary btn-small">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-primary btn-small">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h2 style="margin-bottom: 30px;">أرسل رسالة</h2>
                <form id="contactForm" class="card">
                    <div class="form-group">
                        <label for="name">الاسم الكامل</label>
                        <input type="text" id="name" placeholder="أدخل اسمك" required>
                    </div>

                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" placeholder="your@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" id="phone" placeholder="+967 xxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label for="subject">الموضوع</label>
                        <input type="text" id="subject" placeholder="موضوع الرسالة" required>
                    </div>

                    <div class="form-group">
                        <label for="category">نوع الاستفسار</label>
                        <select id="category" required>
                            <option value="">اختر نوع الاستفسار</option>
                            <option value="support">دعم فني</option>
                            <option value="feedback">تغذية راجعة</option>
                            <option value="partnership">شراكة</option>
                            <option value="employment">فرص عمل</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">الرسالة</label>
                        <textarea id="message" placeholder="اكتب رسالتك هنا..." rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> إرسال الرسالة
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 60px 20px;">
        <div class="container" style="text-align: center;">
            <h2 style="margin-bottom: 20px;">شركاؤنا من الشركات</h2>
            <p style="opacity: 0.9; margin-bottom: 30px;">
                نشتغل مع أكبر الشركات والمنظمات في اليمن والعالم
            </p>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; align-items: center;">
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; font-weight: 700;">TechCorp</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; font-weight: 700;">Digital Pro</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; font-weight: 700;">Global Hub</div>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: var(--radius-md);">
                    <div style="font-size: 2rem; font-weight: 700;">Innovation Co</div>
                </div>
            </div>
        </div>
    </section>

    <div id="footer-container"></div>

    <script src="../js/theme.js"></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                subject: document.getElementById('subject').value,
                category: document.getElementById('category').value,
                message: document.getElementById('message').value
            };
            
            Toast.success('شكراً لرسالتك! سنتواصل معك قريباً.');
            document.getElementById('contactForm').reset();
        });
    </script>
    
    <div id="footer-container"></div>
    
    <script src="../js/theme.js"></script>
    <script src="../js/navbar-footer-loader.js"></script>
</body>
</html>
