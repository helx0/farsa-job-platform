<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الوظائف - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/theme.css">
    <link rel="stylesheet" href="../css/navbar-footer.css">
    <style>
        .jobs-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 100px 20px;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .jobs-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .jobs-hero > div {
            position: relative;
            z-index: 1;
        }

        .jobs-hero h1 {
            font-size: 3.2rem;
            margin-bottom: 15px;
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.6s ease;
        }

        .jobs-hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.95;
            animation: slideUp 0.7s ease 0.1s backwards;
        }

        .search-stats {
            background: rgba(255, 255, 255, 0.18);
            padding: 14px 35px;
            border-radius: 50px;
            display: inline-block;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: slideUp 0.8s ease 0.2s backwards;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .filters-panel {
            background: var(--light);
            border-radius: var(--radius-lg);
            padding: 35px;
            margin-bottom: 35px;
            box-shadow: var(--shadow-lg);
            border: 2px solid var(--border-color);
            transition: all var(--transition-base);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }

        .filters-header h2 {
            font-size: 1.35em;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            color: var(--text-dark);
            font-weight: 700;
        }

        .filters-header h2 i {
            color: var(--primary);
            font-size: 1.2em;
        }

        .filter-toggle {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.3em;
            cursor: pointer;
            display: none;
            transition: transform var(--transition-fast);
        }

        .filter-toggle:hover {
            transform: scale(1.1);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-group label {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.95em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-group label i {
            color: var(--primary);
        }

        .filter-group input,
        .filter-group select {
            padding: 13px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.95em;
            background: var(--light);
            color: var(--text-dark);
            transition: all var(--transition-fast);
            font-family: inherit;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .filter-buttons {
            display: flex;
            gap: 12px;
            margin-top: 0;
        }

        .filter-buttons .btn {
            flex: 1;
            padding: 14px 25px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-fast);
            font-size: 0.95em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .active-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .filter-tag {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .filter-tag i {
            font-size: 1em;
        }

        .filter-tag button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.1em;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            transition: all var(--transition-fast);
            margin-left: 4px;
        }

        .filter-tag button:hover {
            transform: rotate(90deg) scale(1.2);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .jobs-wrapper {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
        }

        .sidebar {
            background: var(--light);
            border-radius: 14px;
            padding: 28px;
            height: fit-content;
            border: 2px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 20px;
        }

        .sidebar-title {
            font-size: 1.25em;
            font-weight: 800;
            margin-bottom: 22px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-title i {
            color: var(--primary);
            font-size: 1.2em;
        }

        .sidebar-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px;
            margin-bottom: 12px;
            font-weight: 700;
            transition: all var(--transition-fast);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .sidebar-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .sidebar-stat i {
            font-size: 1.3em;
            margin-right: 8px;
        }

        .sidebar-stat span:last-child {
            font-size: 1.6em;
            font-weight: 900;
        }

        .jobs-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .job-card {
            background: var(--light);
            border-radius: 14px;
            padding: 28px;
            border: 2px solid var(--border-color);
            transition: all var(--transition-base);
            animation: cardEnter 0.5s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            transition: all var(--transition-base);
        }

        .job-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
            opacity: 0;
            transition: opacity var(--transition-base);
            pointer-events: none;
        }

        .job-card:hover {
            border-color: var(--primary);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
            transform: translateY(-6px);
        }

        .job-card:hover::before {
            width: 6px;
            box-shadow: -2px 0 8px rgba(102, 126, 234, 0.3);
        }

        .job-card:hover::after {
            opacity: 1;
        }

        @keyframes cardEnter {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
            gap: 15px;
        }

        .job-title-section {
            flex: 1;
        }

        .job-title-section h3 {
            font-size: 1.45em;
            margin: 0 0 8px 0;
            color: var(--text-dark);
            font-weight: 800;
        }

        .company-badge {
            font-size: 0.95em;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .company-badge i {
            color: var(--primary);
        }

        .job-rating {
            color: #fbbf24;
            font-size: 0.9em;
            font-weight: 600;
        }

        .job-rating i {
            margin: 0 1px;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.88em;
            font-weight: 600;
            transition: all var(--transition-fast);
        }

        .badge i {
            font-size: 0.95em;
        }

        .badge-primary {
            background: rgba(102, 126, 234, 0.15);
            color: var(--primary);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .badge-primary:hover {
            background: rgba(102, 126, 234, 0.2);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .badge-success:hover {
            background: rgba(16, 185, 129, 0.2);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .badge-warning:hover {
            background: rgba(245, 158, 11, 0.2);
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-info:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .badge-danger:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .job-description {
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 18px;
            font-size: 0.95em;
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .job-actions {
            display: flex;
            gap: 10px;
        }

        .btn-details {
            flex: 1;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: all var(--transition-fast);
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .btn-details:hover {
            transform: translateX(-3px) translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-details i {
            font-size: 1em;
        }

        .btn-save {
            padding: 12px 24px;
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .btn-save.saved {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            border-color: var(--success);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .btn-save.saved:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-save i {
            font-size: 1em;
        }

        .applicants-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6b7280;
            font-size: 0.9em;
        }

        .loading {
            text-align: center;
            padding: 60px 20px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .no-results {
            text-align: center;
            padding: 80px 40px;
            background: var(--light);
            border-radius: var(--radius-lg);
            border: 2px dashed var(--border-color);
            grid-column: 1;
        }

        .no-results i {
            font-size: 3em;
            color: var(--border-color);
            margin-bottom: 20px;
            display: block;
        }

        .no-results h3 {
            margin: 10px 0;
            color: var(--text-dark);
        }

        .load-more-btn {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            padding: 20px;
        }

        .load-more-btn .btn {
            padding: 14px 40px;
            font-size: 1em;
            border-radius: var(--radius-md);
        }

        .sort-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            border: 2px solid var(--border-color);
        }

        .sort-section span {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sort-section span i {
            color: var(--primary);
            font-size: 1.1em;
        }

        .sort-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sort-btn {
            padding: 10px 18px;
            border: 2px solid var(--border-color);
            background: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all var(--transition-fast);
            color: var(--text-dark);
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sort-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sort-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .jobs-wrapper {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                height: auto;
                position: static;
            }

            .filters-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-toggle {
                display: block;
            }

            .filters-grid {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .filters-grid.active {
                max-height: 500px;
            }
        }

        @media (max-width: 768px) {
            .jobs-hero {
                padding: 60px 20px;
            }

            .jobs-hero h1 {
                font-size: 2.2rem;
                margin-bottom: 12px;
            }

            .jobs-hero p {
                font-size: 1em;
                margin-bottom: 20px;
            }

            .search-stats {
                font-size: 0.95rem;
                padding: 12px 25px;
            }

            .filters-panel {
                padding: 25px;
            }

            .filters-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .sort-section {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .sort-section span {
                justify-content: flex-start;
            }

            .sort-options {
                justify-content: flex-start;
            }

            .job-header {
                flex-direction: column;
                gap: 12px;
            }

            .job-card {
                padding: 20px;
            }

            .job-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .job-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-details,
            .btn-save {
                width: 100%;
                padding: 11px 20px;
                font-size: 0.9em;
            }

            .job-meta {
                margin-bottom: 12px;
                gap: 8px;
            }

            .sidebar {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                padding: 20px;
                gap: 12px;
            }

            .sidebar-title {
                grid-column: 1 / -1;
                font-size: 1.1em;
                margin-bottom: 12px;
            }

            .sidebar-stat {
                padding: 12px;
                font-size: 0.85em;
                margin-bottom: 0;
            }

            .sidebar-stat span:last-child {
                font-size: 1.3em;
            }
        }

        @media (max-width: 480px) {
            .jobs-hero {
                padding: 50px 15px;
                margin-bottom: 30px;
            }

            .jobs-hero h1 {
                font-size: 1.8rem;
            }

            .jobs-hero p {
                font-size: 0.95em;
            }

            .search-stats {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            .filters-panel {
                padding: 20px;
                margin-bottom: 25px;
            }

            .filters-header h2 {
                font-size: 1.1em;
            }

            .filter-group label {
                font-size: 0.9em;
            }

            .sort-btn {
                padding: 8px 14px;
                font-size: 0.85em;
            }

            .job-card {
                padding: 16px;
                border-radius: 10px;
            }

            .job-title-section h3 {
                font-size: 1.2em;
            }

            .badge {
                font-size: 0.8em;
                padding: 6px 12px;
            }

            .applicants-info {
                font-size: 0.85em;
            }

            .filter-tag {
                font-size: 0.85em;
                padding: 6px 12px;
            }
        }

        body.dark-mode .job-description,
        body.dark-mode .applicants-info {
            color: #a0aec0;
        }

        body.dark-mode .filters-panel,
        body.dark-mode .sidebar,
        body.dark-mode .job-card {
            background: var(--dark-light);
            border-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .sort-section {
            background: rgba(102, 126, 234, 0.08);
        }

        body.dark-mode .sidebar-stat {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        body.dark-mode .filters-header {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .active-filters {
            border-top-color: rgba(255, 255, 255, 0.1);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .jobs-list > .job-card:nth-child(1) {
            animation: cardEnter 0.5s ease 0.05s backwards;
        }

        .jobs-list > .job-card:nth-child(2) {
            animation: cardEnter 0.5s ease 0.1s backwards;
        }

        .jobs-list > .job-card:nth-child(3) {
            animation: cardEnter 0.5s ease 0.15s backwards;
        }

        .jobs-list > .job-card:nth-child(4) {
            animation: cardEnter 0.5s ease 0.2s backwards;
        }

        .jobs-list > .job-card:nth-child(5) {
            animation: cardEnter 0.5s ease 0.25s backwards;
        }

        .jobs-list > .job-card:nth-child(n+6) {
            animation: cardEnter 0.5s ease 0.3s backwards;
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>

    <section class="jobs-hero">
        <div class="container">
            <h1>ابحث عن فرصتك الوظيفية</h1>
            <p>اكتشف آلاف الوظائف المتاحة من أفضل الشركات</p>
            <div class="search-stats">
                <i class="fas fa-briefcase"></i> <span id="total-jobs">0</span> وظيفة متاحة
            </div>
        </div>
    </section>

    <div class="container">
        <div class="filters-panel">
            <div class="filters-header">
                <h2><i class="fas fa-filter"></i> تصفية النتائج</h2>
                <button class="filter-toggle" id="filter-toggle" onclick="toggleFilters()">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>

            <div class="filters-grid" id="filters-grid">
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> البحث عن وظيفة</label>
                    <input type="text" id="search" placeholder="مثال: مهندس برمجيات">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-map-marker-alt"></i> المدينة</label>
                    <select id="location">
                        <option value="">جميع المدن</option>
                        <option value="صنعاء">صنعاء</option>
                        <option value="عدن">عدن</option>
                        <option value="تعز">تعز</option>
                        <option value="إب">إب</option>
                        <option value="الحديدة">الحديدة</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-briefcase"></i> نوع الوظيفة</label>
                    <select id="job-type">
                        <option value="">جميع الأنواع</option>
                        <option value="full_time">دوام كامل</option>
                        <option value="part_time">دوام جزئي</option>
                        <option value="freelance">عمل حر</option>
                        <option value="contract">عقد محدد</option>
                    </select>
                </div>
            </div>

            <div class="filter-buttons">
                <button class="btn" style="background: var(--primary); color: white; flex: 1;" onclick="searchJobs()">
                    <i class="fas fa-search"></i> بحث
                </button>
                <button class="btn" style="background: transparent; color: var(--primary); border: 2px solid var(--primary); flex: 1;" onclick="clearFilters()">
                    <i class="fas fa-redo"></i> إعادة تعيين
                </button>
            </div>

            <div class="active-filters" id="active-filters"></div>
        </div>

        <div class="sort-section">
            <span><i class="fas fa-sort"></i> ترتيب النتائج:</span>
            <div class="sort-options">
                <button class="sort-btn active" onclick="setSortOrder('newest')">الأحدث</button>
                <button class="sort-btn" onclick="setSortOrder('salary_high')">أعلى راتب</button>
                <button class="sort-btn" onclick="setSortOrder('salary_low')">أقل راتب</button>
                <button class="sort-btn" onclick="setSortOrder('popular')">الأكثر تطبيقات</button>
            </div>
        </div>

        <div class="jobs-wrapper">
            <div class="jobs-list" id="jobs-container">
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <p>جاري تحميل الوظائف...</p>
                </div>
            </div>

            <div class="sidebar">
                <div class="sidebar-title">إحصائيات</div>
                <div class="sidebar-stat">
                    <span><i class="fas fa-briefcase"></i> إجمالي الوظائف</span>
                    <span id="stat-total">0</span>
                </div>
                <div class="sidebar-stat">
                    <span><i class="fas fa-building"></i> الشركات</span>
                    <span id="stat-companies">0</span>
                </div>
                <div class="sidebar-stat">
                    <span><i class="fas fa-user-tie"></i> تم اليوم</span>
                    <span id="stat-today">0</span>
                </div>
            </div>
        </div>

        <div class="load-more-btn">
            <button class="btn btn-outline" id="load-more" onclick="loadMoreJobs()" style="display: none;">
                <i class="fas fa-chevron-down"></i> تحميل المزيد
            </button>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 فرصة - جميع الحقوق محفوظة</p>
            </div>
        </div>
    </main>

    <div id="footer-container"></div>

    <div id="notification" class="notification hidden"></div>

    <script src="../js/app.js"></script>
    <script src="../js/mock-jobs.js"></script>
    <script>
        let currentPage = 1;
        let currentSort = 'newest';
        let savedJobs = new Set();
        let allJobs = [];

        function toggleFilters() {
            const filtersGrid = document.getElementById('filters-grid');
            filtersGrid.style.display = filtersGrid.style.display === 'none' ? 'grid' : 'none';
        }

        function searchJobs() {
            currentPage = 1;
            loadJobs();
            updateActiveFilters();
        }

        function clearFilters() {
            document.getElementById('search').value = '';
            document.getElementById('location').value = '';
            document.getElementById('job-type').value = '';
            currentSort = 'newest';
            updateSortButtons();
            document.getElementById('active-filters').innerHTML = '';
            searchJobs();
        }

        function setSortOrder(order) {
            currentSort = order;
            const buttons = document.querySelectorAll('.sort-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            currentPage = 1;
            loadJobs();
        }

        function updateActiveFilters() {
            const filters = {
                search: document.getElementById('search').value,
                location: document.getElementById('location').value,
                job_type: document.getElementById('job-type').value
            };

            const activeFiltersDiv = document.getElementById('active-filters');
            activeFiltersDiv.innerHTML = '';

            if (filters.search) {
                activeFiltersDiv.innerHTML += `
                    <div class="filter-tag">
                        <i class="fas fa-search"></i> ${filters.search}
                        <button onclick="clearFilter('search')">×</button>
                    </div>
                `;
            }

            if (filters.location) {
                activeFiltersDiv.innerHTML += `
                    <div class="filter-tag">
                        <i class="fas fa-map-marker-alt"></i> ${filters.location}
                        <button onclick="clearFilter('location')">×</button>
                    </div>
                `;
            }

            if (filters.job_type) {
                const typeLabel = {
                    'full_time': 'دوام كامل',
                    'part_time': 'دوام جزئي',
                    'freelance': 'عمل حر',
                    'contract': 'عقد محدد'
                };
                activeFiltersDiv.innerHTML += `
                    <div class="filter-tag">
                        <i class="fas fa-briefcase"></i> ${typeLabel[filters.job_type]}
                        <button onclick="clearFilter('job-type')">×</button>
                    </div>
                `;
            }
        }

        function clearFilter(filterId) {
            if (filterId === 'search') document.getElementById('search').value = '';
            else if (filterId === 'location') document.getElementById('location').value = '';
            else if (filterId === 'job-type') document.getElementById('job-type').value = '';
            
            searchJobs();
        }

        function sortJobs(jobs) {
            const sorted = [...jobs];

            switch(currentSort) {
                case 'salary_high':
                    return sorted.sort((a, b) => (b.salary_max || 0) - (a.salary_max || 0));
                case 'salary_low':
                    return sorted.sort((a, b) => (a.salary_min || 0) - (b.salary_min || 0));
                case 'popular':
                    return sorted.sort((a, b) => Math.random() - 0.5);
                case 'newest':
                default:
                    return sorted.sort((a, b) => new Date(b.published_at) - new Date(a.published_at));
            }
        }

        function loadJobs() {
            const filters = {
                search: document.getElementById('search').value,
                location: document.getElementById('location').value,
                job_type: document.getElementById('job-type').value
            };

            setTimeout(() => {
                const data = getMockJobs(filters, currentPage, 20);
                
                if (data.status === 'success') {
                    const container = document.getElementById('jobs-container');
                    
                    if (currentPage === 1) {
                        container.innerHTML = '';
                    }

                    if (data.data.length === 0 && currentPage === 1) {
                        container.innerHTML = `
                            <div class="no-results">
                                <i class="fas fa-search"></i>
                                <h3>لم نجد وظائف مطابقة</h3>
                                <p>حاول تغيير معايير البحث</p>
                            </div>
                        `;
                        updateStats(0, 0, 0);
                        return;
                    }

                    const sortedJobs = sortJobs(data.data);

                    sortedJobs.forEach((job, index) => {
                        const card = document.createElement('div');
                        card.className = 'job-card';
                        card.style.animationDelay = (index * 0.1) + 's';

                        const isSaved = savedJobs.has(job.id);
                        const applicantsCount = Math.floor(Math.random() * 50) + 5;
                        const rating = (Math.random() * 0.5 + 4).toFixed(1);

                        card.innerHTML = `
                            <div class="job-header">
                                <div class="job-title-section">
                                    <h3>${job.job_title_ar}</h3>
                                    <div class="company-badge">
                                        <i class="fas fa-building"></i> ${job.company_name || 'شركة'}
                                    </div>
                                    <div class="job-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span style="margin-right: 5px;">(${Math.floor(Math.random() * 200) + 50})</span>
                                    </div>
                                </div>
                            </div>

                            <div class="job-meta">
                                <span class="badge badge-primary">
                                    <i class="fas fa-clock"></i>
                                    ${job.job_type === 'full_time' ? 'دوام كامل' : job.job_type === 'part_time' ? 'دوام جزئي' : job.job_type === 'freelance' ? 'عمل حر' : 'عقد محدد'}
                                </span>
                                <span class="badge badge-success">
                                    <i class="fas fa-map-marker-alt"></i>
                                    ${job.location_city}
                                </span>
                                ${job.salary_min ? `
                                    <span class="badge badge-warning">
                                        <i class="fas fa-money-bill-wave"></i>
                                        ${job.salary_min.toLocaleString('ar-SA')} - ${job.salary_max.toLocaleString('ar-SA')} YER
                                    </span>
                                ` : `
                                    <span class="badge badge-warning">
                                        <i class="fas fa-money-bill-wave"></i>
                                        حسب التفاوض
                                    </span>
                                `}
                                <span class="badge badge-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    حديثة
                                </span>
                            </div>

                            <p class="job-description">
                                ${job.job_description_ar.substring(0, 150)}...
                            </p>

                            <div class="job-footer">
                                <div class="applicants-info">
                                    <i class="fas fa-users"></i>
                                    <span>${applicantsCount} متقدمين</span>
                                </div>
                                <div class="job-actions">
                                    <a href="job-details.php?id=${job.id}" class="btn-details">
                                        <i class="fas fa-arrow-left"></i> التفاصيل
                                    </a>
                                    <button class="btn-save ${isSaved ? 'saved' : ''}" onclick="saveJob(${job.id}, this)">
                                        <i class="fas fa-bookmark"></i> ${isSaved ? 'محفوظة' : 'حفظ'}
                                    </button>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });

                    const totalCompanies = new Set(mockJobs.map(j => j.company_name)).size;
                    updateStats(data.total, totalCompanies, Math.floor(Math.random() * 10) + 3);
                    document.getElementById('load-more').style.display = data.data.length >= 20 ? 'block' : 'none';
                }
            }, 300);
        }

        function loadMoreJobs() {
            currentPage++;
            loadJobs();
        }

        function saveJob(jobId, button) {
            if (savedJobs.has(jobId)) {
                savedJobs.delete(jobId);
                button.classList.remove('saved');
                button.innerHTML = '<i class="fas fa-bookmark"></i> حفظ';
                showNotification('تم إلغاء حفظ الوظيفة', 'warning');
            } else {
                savedJobs.add(jobId);
                button.classList.add('saved');
                button.innerHTML = '<i class="fas fa-bookmark"></i> محفوظة';
                showNotification('تم حفظ الوظيفة بنجاح', 'success');
            }
        }

        function showNotification(message, type = 'info') {
            const notification = document.getElementById('notification');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        function updateStats(total, companies, today) {
            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-companies').textContent = companies;
            document.getElementById('stat-today').textContent = today;
            document.getElementById('total-jobs').textContent = total.toLocaleString('ar-SA');
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadJobs();
        });
    </script>
    
    <div id="footer-container"></div>
    
    <script src="../js/theme.js"></script>
    <script src="../js/navbar-footer-loader.js"></script>
</body>
</html>
