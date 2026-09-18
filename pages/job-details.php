<?php ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الوظيفة - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/navbar-footer.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7ff 0%, #f0e6ff 50%, #ffe6f0 100%);
            color: #333;
        }

        body.dark-mode {
            background: #0f172a;
            color: #e2e8f0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .job-header {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240, 147, 251, 0.05) 100%);
            border-radius: 20px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            padding: 50px 40px;
            margin-bottom: 40px;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15);
            backdrop-filter: blur(10px);
            animation: slideUp 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        .job-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
            animation: blob 8s ease-in-out infinite;
            z-index: 0;
        }

        .job-header > * {
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .job-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 8s ease infinite;
        }

        .company-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            color: #555;
        }

        .meta-item i {
            font-size: 1.3rem;
            color: #667eea;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(240, 147, 251, 0.15));
            color: #667eea;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            border: 1px solid rgba(102, 126, 234, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content-section {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240, 147, 251, 0.02) 100%);
            border-radius: 18px;
            border: 2px solid rgba(102, 126, 234, 0.15);
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(10px);
            animation: slideUp 0.7s ease 0.1s backwards;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 25px;
            color: #2d3436;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding-bottom: 15px;
            border-bottom: 3px solid rgba(102, 126, 234, 0.2);
        }

        .description {
            line-height: 1.8;
            color: #555;
            font-size: 1.05rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
        }

        .requirements-list li {
            padding: 12px 0;
            padding-right: 20px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            color: #555;
            font-weight: 500;
            font-size: 1.02rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .requirements-list li:last-child {
            border-bottom: none;
        }

        .requirements-list li::before {
            content: '✓';
            display: inline-block;
            color: #667eea;
            font-weight: 900;
            font-size: 1.3rem;
        }

        .salary-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }

        .salary-label {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .salary-range {
            font-size: 2rem;
            font-weight: 900;
            margin: 15px 0;
        }

        .salary-note {
            font-size: 0.85rem;
            opacity: 0.85;
            font-weight: 500;
        }

        .apply-section {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .apply-btn {
            flex: 1;
            min-width: 200px;
            padding: 18px 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .apply-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .apply-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.4), 0 0 30px rgba(240, 147, 251, 0.3);
            background-position: 100% 0;
        }

        .apply-btn:hover::before {
            left: 100%;
        }

        .apply-btn:active {
            transform: translateY(-1px);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 28px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(240, 147, 251, 0.1));
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(240, 147, 251, 0.2));
            border-color: rgba(102, 126, 234, 0.4);
            transform: translateX(5px);
        }

        body.dark-mode .content-section,
        body.dark-mode .job-header {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(102, 126, 234, 0.2);
        }

        body.dark-mode .description,
        body.dark-mode .meta-item {
            color: #cbd5e1;
        }

        @media (max-width: 768px) {
            .job-title {
                font-size: 1.8rem;
            }

            .job-header {
                padding: 30px 25px;
            }

            .content-section {
                padding: 25px 20px;
            }

            .job-meta {
                flex-direction: column;
                gap: 15px;
            }

            .apply-section {
                flex-direction: column;
            }

            .apply-btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>

    <div class="container">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-arrow-right"></i> العودة
        </a>

        <div class="job-header" id="job-header">
            <div class="job-title" id="job-title">جاري التحميل...</div>
            <div class="company-info" id="company-info">
                <i class="fas fa-building"></i>
                <span id="company-name">جاري التحميل...</span>
            </div>
            <div class="job-meta">
                <div class="meta-item">
                    <i class="fas fa-briefcase"></i>
                    <span id="job-type">---</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span id="location">---</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span id="publish-date">---</span>
                </div>
            </div>
        </div>

        <div class="content-section">
            <h2 class="section-title"><i class="fas fa-briefcase" style="margin-left: 10px;"></i> وصف الوظيفة</h2>
            <p class="description" id="description">جاري التحميل...</p>
        </div>

        <div id="salary-section" class="salary-section" style="display: none;">
            <div class="salary-label">نطاق الراتب الشهري</div>
            <div class="salary-range" id="salary-range">---</div>
            <div class="salary-note">الراتب يعتمد على الخبرة والمؤهلات</div>
        </div>

        <div class="content-section">
            <h2 class="section-title"><i class="fas fa-tasks" style="margin-left: 10px;"></i> المتطلبات</h2>
            <ul class="requirements-list" id="requirements-list">
                <li>جاري التحميل...</li>
            </ul>
        </div>

        <div class="apply-section">
            <button class="apply-btn" onclick="applyForJob()">
                <i class="fas fa-paper-plane"></i> تقديم طلب
            </button>
            <button class="apply-btn" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(240, 147, 251, 0.15)); color: #667eea; border: 2px solid #667eea;" onclick="shareJob()">
                <i class="fas fa-share-alt"></i> مشاركة
            </button>
        </div>
    </div>

    <div id="footer-container" style="margin-top: 60px;"></div>

    <script src="../js/mock-jobs.js"></script>
    <script src="../js/theme.js"></script>

    <script>
        function getJobIdFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return parseInt(urlParams.get('id')) || 1;
        }

        function getJobTypeAr(type) {
            const types = {
                'full_time': 'دوام كامل',
                'part_time': 'دوام جزئي',
                'freelance': 'عمل حر',
                'contract': 'عقد محدد'
            };
            return types[type] || type;
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const date = new Date(dateString);
            return date.toLocaleDateString('ar-SA', options);
        }

        function formatSalary(amount) {
            return amount.toLocaleString('ar-SA');
        }

        function loadJobDetails() {
            const jobId = getJobIdFromUrl();
            const job = mockJobs.find(j => j.id === jobId);

            if (!job) {
                document.querySelector('.container').innerHTML = `
                    <div style="text-align: center; padding: 60px 20px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ef4444; margin-bottom: 20px; display: block;"></i>
                        <h2 style="color: #ef4444; margin-bottom: 20px;">الوظيفة غير موجودة</h2>
                        <p style="color: #6b7280; margin-bottom: 30px; font-size: 1.1rem;">عذراً، لم نتمكن من العثور على الوظيفة المطلوبة.</p>
                        <a href="jobs.php" class="back-btn" style="display: inline-flex;">
                            <i class="fas fa-arrow-right"></i> العودة إلى الوظائف
                        </a>
                    </div>
                `;
                return;
            }

            document.getElementById('job-title').textContent = job.job_title_ar;
            document.getElementById('company-name').textContent = job.company_name;
            document.getElementById('job-type').textContent = getJobTypeAr(job.job_type);
            document.getElementById('location').textContent = job.location_city;
            document.getElementById('publish-date').textContent = formatDate(job.published_at);
            document.getElementById('description').textContent = job.job_description_ar;

            if (job.salary_min > 0 || job.salary_max > 0) {
                const salarySection = document.getElementById('salary-section');
                const salaryRange = document.getElementById('salary-range');
                
                if (job.salary_min > 0 && job.salary_max > 0) {
                    salaryRange.textContent = `${formatSalary(job.salary_min)} - ${formatSalary(job.salary_max)} ريال يمني`;
                    salarySection.style.display = 'block';
                }
            }

            const requirementsList = document.getElementById('requirements-list');
            requirementsList.innerHTML = '';

            const requirements = [
                'درجة عالية من الاحترافية والالتزام',
                'خبرة سابقة في المجال المتخصص',
                'مهارات تواصل ممتازة',
                'القدرة على التعلم السريع والتطور المستمر',
                'العمل ضمن فريق بكفاءة عالية',
                'الالتزام بالمواعيد والجودة العالية'
            ];

            requirements.forEach(req => {
                const li = document.createElement('li');
                li.textContent = req;
                requirementsList.appendChild(li);
            });

            document.title = `${job.job_title_ar} - فرصة`;
        }

        function applyForJob() {
            const jobId = getJobIdFromUrl();
            alert('تم تقديم طلبك بنجاح! سنتواصل معك قريباً.');
        }

        function shareJob() {
            const jobId = getJobIdFromUrl();
            const job = mockJobs.find(j => j.id === jobId);
            const shareUrl = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: job.job_title_ar,
                    text: `انظر إلى هذه الفرصة الوظيفية: ${job.job_title_ar}`,
                    url: shareUrl
                }).catch(err => console.log('Error sharing:', err));
            } else {
                alert('رابط الوظيفة:\n' + shareUrl);
            }
        }

        document.addEventListener('DOMContentLoaded', loadJobDetails);
    </script>

    <script src="../js/navbar-footer-loader.js"></script>
</body>
</html>
