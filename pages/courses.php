<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="دورات تطوير مهارات في منصة فرصة">
    <title>الدورات التدريبية - فرصة</title>
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
            <h1 style="font-size: 3rem; margin-bottom: 20px;">دورات تطوير المهارات</h1>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                تطور مهاراتك مع برامج تدريبية متخصصة من خبراء المجال
            </p>
        </div>
    </section>

    <section class="container py-20">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 40px;">
            <div style="padding: 20px; background: white; border-radius: var(--radius-md); border: 2px solid var(--border-color); text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">0</div>
                <p style="color: #666; margin: 0;">دورة مكتملة</p>
            </div>
            <div style="padding: 20px; background: white; border-radius: var(--radius-md); border: 2px solid var(--border-color); text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--success);">12+</div>
                <p style="color: #666; margin: 0;">دورة قيد الإعداد</p>
            </div>
            <div style="padding: 20px; background: white; border-radius: var(--radius-md); border: 2px solid var(--border-color); text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: var(--warning);">8+</div>
                <p style="color: #666; margin: 0;">متخصصون معتمدون</p>
            </div>
        </div>

        <h2 style="margin-bottom: 30px; text-align: center;">الدورات القادمة</h2>
        <div class="grid grid-cols-3">
            <!-- Course 1 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">💻</div>
                    <h3 style="margin: 0;">تطوير الويب</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    تعلم أساسيات وتقنيات تطوير المواقع من HTML و CSS و JavaScript
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 8 أسابيع</span>
                    <span><i class="fas fa-users"></i> 45 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-primary">مبتدئ</span>
                    <span style="font-weight: 700; color: var(--primary);">مجاني</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>

            <!-- Course 2 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📊</div>
                    <h3 style="margin: 0;">تحليل البيانات</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    استخدم Excel و Python لتحليل البيانات واستخراج الرؤى
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 10 أسابيع</span>
                    <span><i class="fas fa-users"></i> 32 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-info">متوسط</span>
                    <span style="font-weight: 700; color: #f5576c;">249,999 ر.ي</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>

            <!-- Course 3 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📱</div>
                    <h3 style="margin: 0;">تطوير التطبيقات</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    تطور تطبيقات جوال احترافية باستخدام React Native و Flutter
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 12 أسابيع</span>
                    <span><i class="fas fa-users"></i> 28 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-success">متقدم</span>
                    <span style="font-weight: 700; color: #00f2fe;">399,999 ر.ي</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>

            <!-- Course 4 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">🎨</div>
                    <h3 style="margin: 0;">التصميم الجرافيكي</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    تصميم جرافيكي احترافي باستخدام Figma و Adobe Creative Suite
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 6 أسابيع</span>
                    <span><i class="fas fa-users"></i> 38 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-primary">مبتدئ</span>
                    <span style="font-weight: 700; color: var(--primary);">مجاني</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>

            <!-- Course 5 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">💼</div>
                    <h3 style="margin: 0;">إدارة المشاريع</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    تعلم أفضل الممارسات في إدارة المشاريع والقيادة الفعالة
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 7 أسابيع</span>
                    <span><i class="fas fa-users"></i> 42 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-info">متوسط</span>
                    <span style="font-weight: 700; color: var(--primary);">299,999 ر.ي</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>

            <!-- Course 6 -->
            <div class="card">
                <div style="background: linear-gradient(135deg, #ff9a56 0%, #ff6a88 100%); color: white; padding: 20px; border-radius: var(--radius-md); margin-bottom: 15px; text-align: center;">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">🤖</div>
                    <h3 style="margin: 0;">الذكاء الاصطناعي</h3>
                </div>
                <p style="color: #666; margin-bottom: 15px; min-height: 60px;">
                    دخول عالم الذكاء الاصطناعي وتعلم الآلة مع خبراء المجال
                </p>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #999; margin-bottom: 15px;">
                    <span><i class="fas fa-clock"></i> 14 أسبوع</span>
                    <span><i class="fas fa-users"></i> 25 طالب</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span class="badge badge-warning">متقدم</span>
                    <span style="font-weight: 700; color: #ff6a88;">499,999 ر.ي</span>
                </div>
                <button class="btn btn-primary btn-block" onclick="Toast.success('تم إضافة الدورة إلى قائمتك!')">
                    <i class="fas fa-bookmark"></i> اهتمام
                </button>
            </div>
        </div>
    </section>

    <section style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 60px 20px; text-align: center;">
        <div class="container">
            <h2 style="margin-bottom: 20px;">هل تريد تطوير مهاراتك؟</h2>
            <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.9;">
                اختر الدورة المناسبة لك وابدأ رحلة التطور الآن
            </p>
            <button class="btn btn-large" style="background: white; color: var(--primary);" onclick="navigate('../pages/auth/register.php')">
                <i class="fas fa-arrow-left"></i> ابدأ الآن
            </button>
        </div>
    </section>

    <div id="footer-container"></div>

    <script src="../js/theme.js"></script>
    <script src="../js/navbar-footer-loader.js"></script>
</body>
</html>
