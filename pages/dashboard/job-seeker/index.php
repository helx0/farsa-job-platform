<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الباحث عن عمل - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/theme.css">
    <link rel="stylesheet" href="../../../css/navbar-footer.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7ff 0%, #f0e6ff 50%, #ffe6f0 100%);
            color: #2d3436;
            overflow-x: hidden;
            transition: background 0.3s ease;
        }

   
      
        .navbar-right {
            display: flex;
            align-items: center;
            margin-left: auto;
            justify-content: right;
        }

        .navbar-menu {
            display: flex;
            gap: 5px;
            list-style: none;
        }

        .navbar-menu-item {
            position: relative;
            padding: 21px;
            

        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(183, 102, 220, 0.95);
            padding: 14px 20px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%);
            border: 2px solid rgba(255, 255, 255, 0.25);
            font-size: 0.95rem;
            font-weight: 600;
            backdrop-filter: blur(15px);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
        }

        .user-menu-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .user-menu-btn:hover::before {
            left: 100%;
        }

        .user-menu-btn:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.25);
            color: white;
        }

        .user-menu-btn i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .user-menu-btn:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .user-menu-btn .fa-chevron-down {
            font-size: 0.8rem;
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .user-menu-btn:hover .fa-chevron-down {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.95) 100%);
            min-width: 300px;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.3);
            margin-top: 8px;
            display: none;
            flex-direction: column;
            z-index: 1001;
            overflow: hidden;
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            animation: dropdownSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .dropdown-menu.show {
            display: flex;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px 24px 16px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.03) 100%);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .user-details {
            flex: 1;
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 0.85rem;
            color: #718096;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-role i {
            color: #667eea;
        }

        .dropdown-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.2), transparent);
            margin: 8px 0;
        }

        .dropdown-item {
            padding: 18px 24px;
            color: #4a5568;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            gap: 16px;
            border: none;
            background: transparent;
            width: 100%;
            text-align: right;
            font-size: 0.95rem;
            font-weight: 500;
            position: relative;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.05) 100%);
            transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: -1;
        }

        .dropdown-item:hover::before {
            width: 100%;
        }

        .dropdown-item:hover {
            background: transparent;
            color: #667eea;
            transform: translateX(-8px);
            padding-left: 32px;
        }

        .dropdown-item.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.06) 100%);
            color: #667eea;
            font-weight: 600;
        }

        .dropdown-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            color: #667eea;
            transition: transform 0.3s ease;
        }

        .dropdown-item:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .dropdown-item:first-child {
            border-radius: 24px 24px 0 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.04) 100%);
            font-weight: 600;
            color: #2d3748;
        }

        .logout-btn {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(220, 38, 38, 0.04) 100%);
            border-radius: 0 0 24px 24px;
        }

        .logout-btn:hover {
            color: #e53e3e;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.08) 100%);
        }

        .logout-btn i {
            color: #e53e3e;
        }

        @keyframes dropdownSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ==================== SIDEBAR (Hidden) ==================== */
        .sidebar {
            display: none;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            animation: slideIn 0.6s ease;
        }

        .sidebar-logo i {
            font-size: 2.2rem;
            animation: float 3s ease-in-out infinite;
        }

        .user-widget {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.6s ease 0.1s backwards;
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 12px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        .user-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .user-type {
            font-size: 0.85rem;
            opacity: 0.85;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .sidebar-menu {
            list-style: none;
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            margin: 4px 0;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: rgba(255, 255, 255, 0.5);
            transition: height 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(-4px);
        }

        .sidebar-link:hover::before {
            height: 20px;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-left-color: #fff;
        }

        .sidebar-link.active::before {
            height: 24px;
            background: white;
        }

        .sidebar-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
            flex-shrink: 0;
        }

        .sidebar-footer .sidebar-link {
            margin: 0;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: 0;
            padding: 30px;
            flex: 1;
            width: 100%;
        }

        /* ==================== HEADER ==================== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 147, 251, 0.05) 100%);
            padding: 25px 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15);
            border: 2px solid rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(10px);
            animation: slideDown 0.6s ease;
        }

        body.dark-mode .header {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.8) 100%);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-icon {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: 2px solid #667eea;
            width: 48px;
            height: 48px;
            padding: 0;
            justify-content: center;
        }

        .btn-icon:hover {
            background: #667eea;
            color: white;
        }

        /* ==================== SIDEBAR TOGGLE ==================== */
        .sidebar-toggle {
            display: none;
            margin-left: auto;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
        }

        /* ==================== STATS GRID ==================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.7) 100%);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1);
            border: 2px solid rgba(102, 126, 234, 0.1);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease backwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        body.dark-mode .stat-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.8) 100%);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            animation: iconBounce 2s ease-in-out infinite;
        }

        .stat-card:nth-child(1) .stat-icon { animation-delay: 0s; }
        .stat-card:nth-child(2) .stat-icon { animation-delay: 0.3s; }
        .stat-card:nth-child(3) .stat-icon { animation-delay: 0.6s; }
        .stat-card:nth-child(4) .stat-icon { animation-delay: 0.9s; }

        .stat-label {
            color: #666;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        body.dark-mode .stat-label {
            color: #94a3b8;
        }

        .stat-value {
            font-size: 2.8rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 0.85rem;
            color: #10b981;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ==================== SECTIONS ==================== */
        .section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.7) 100%);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.1);
            border: 2px solid rgba(102, 126, 234, 0.1);
            margin-bottom: 25px;
            animation: fadeInUp 0.6s ease 0.3s backwards;
        }

        body.dark-mode .section {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.8) 100%);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.8rem;
        }

        /* ==================== TABLE ==================== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        table th {
            text-align: right;
            padding: 16px;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(102, 126, 234, 0.2);
        }

        body.dark-mode table th {
            color: #a5f3fc;
            border-color: rgba(102, 126, 234, 0.3);
        }

        table td {
            padding: 16px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        table tbody tr {
            transition: all 0.3s ease;
        }

        table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        body.dark-mode table tbody tr:hover {
            background: rgba(102, 126, 234, 0.15);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
        }

        .badge-info {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
        }

        @keyframes iconBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 1024px) {
            .navbar-menu {
                gap: 0;
            }

            .navbar-link span {
                display: none;
            }

            .navbar-link {
                padding: 10px;
            }
        }

        @media (max-width: 768px) {
            .top-navbar {
                flex-wrap: wrap;
                padding: 10px 15px;
            }

            .navbar-left {
                gap: 10px;
                width: 100%;
                order: 1;
            }


            
            .navbar-right {
                width: 100%;
                order: 2;
                justify-content: flex-start !important;
                margin-top: 10px;
            }

            .navbar-right .btn {
                flex: 1;
                justify-content: center;
            }

            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                width: 280px;
                height: 100vh;
                z-index: 1001;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar-toggle {
                display: flex !important;
            }

            .sidebar-overlay {
                display: block;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                padding: 20px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .header h1 {
                font-size: 1.3rem;
            }

            .section {
                padding: 20px;
            }

            .table-wrapper {
                font-size: 0.9rem;
            }

            table th, table td {
                padding: 12px 8px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-value {
                font-size: 2rem;
            }

            .header h1 {
                font-size: 1.1rem;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.85rem;
            }

            table {
                font-size: 0.85rem;
            }

            table th, table td {
                padding: 10px 6px;
            }
        }

        /* ==================== TABS ==================== */
        .tab-content {
            animation: fadeInUp 0.4s ease;
        }

        /* ==================== HIDDEN SECTIONS ==================== */
        #saved-tab, #applications-tab {
            display: none;
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>
    
    <div class="dashboard-container">
        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="navbar-left">
               
            </div>
            <div class="navbar-right">
                <div class="navbar-menu-item">
                    <button class="user-menu-btn" onclick="toggleUserMenu()">
                        <i class="fas fa-user-circle"></i>
                        <span>المستخدم</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userMenu">
                        <div class="user-info">
                            <div class="user-avatar">👤</div>
                            <div class="user-details">
                                <div class="user-name">محمد أحمد</div>
                                <div class="user-role">
                                    <i class="fas fa-briefcase"></i>
                                    <span>باحث عن عمل</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" onclick="switchTab('overview')">
                            <i class="fas fa-home"></i>
                            <span>نظرة عامة</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('saved')">
                            <i class="fas fa-bookmark"></i>
                            <span>المحفوظة</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('applications')">
                            <i class="fas fa-file-alt"></i>
                            <span>طلباتي</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('profile')">
                            <i class="fas fa-user-edit"></i>
                            <span>الملف الشخصي</span>
                        </button>
                      
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item logout-btn" onclick="logout()">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

           
       
        <!-- SIDEBAR OVERLAY -->
        <div class="sidebar-overlay" onclick="toggleSidebarMobile()"></div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <button class="sidebar-toggle btn btn-icon" onclick="toggleSidebarMobile()" title="تبديل القائمة"><i class="fas fa-bars"></i></button>
                <h1><i class="fas fa-gauge"></i> لوحة التحكم</h1>
                <div class="header-right">
                    <a href="../../jobs.php" class="btn btn-primary">
                        <i class="fas fa-briefcase"></i> ابحث عن وظائف
                    </a>
                    
                </div>
            </div>

            <!-- OVERVIEW TAB -->
            <div id="overview-tab" class="tab-content">
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">💼</div>
                        <div class="stat-label">الوظائف المحفوظة</div>
                        <div class="stat-value">12</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+3 هذا الشهر</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📝</div>
                        <div class="stat-label">الطلبات المرسلة</div>
                        <div class="stat-value">8</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+2 منتظر</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-label">المقابلات</div>
                        <div class="stat-value">3</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+1 قريب</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-label">التقييم</div>
                        <div class="stat-value">4.5</div>
                        <div class="stat-change">
                            <i class="fas fa-star"></i>
                            <span>ممتاز جداً</span>
                        </div>
                    </div>
                </div>

                <!-- Matched Jobs Section -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-lightning-bolt"></i>
                            الوظائف المتطابقة
                        </h2>
                        <a href="../../jobs.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> عرض المزيد
                        </a>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-briefcase"></i> الوظيفة</th>
                                    <th><i class="fas fa-building"></i> الشركة</th>
                                    <th><i class="fas fa-map-marker-alt"></i> الموقع</th>
                                    <th><i class="fas fa-chart-pie"></i> المطابقة</th>
                                    <th><i class="fas fa-cog"></i> الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>مهندس برمجيات</strong></td>
                                    <td>شركة التكنولوجيا</td>
                                    <td>صنعاء</td>
                                    <td><span class="badge badge-success">95%</span></td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> تقديم
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>مطور ويب</strong></td>
                                    <td>وكالة التطوير</td>
                                    <td>عدن</td>
                                    <td><span class="badge badge-success">88%</span></td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> تقديم
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>محلل بيانات</strong></td>
                                    <td>منصة البيانات</td>
                                    <td>صنعاء</td>
                                    <td><span class="badge badge-warning">78%</span></td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> تقديم
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Applications Section -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-history"></i>
                            آخر التقديمات
                        </h2>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>الوظيفة</th>
                                    <th>تاريخ التقديم</th>
                                    <th>الحالة</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>مهندس برمجيات</strong></td>
                                    <td>2025-11-25</td>
                                    <td><span class="badge badge-info">قيد المراجعة</span></td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-eye"></i> عرض
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>مطور فرونتند</strong></td>
                                    <td>2025-11-20</td>
                                    <td><span class="badge badge-success">مقبول</span></td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-eye"></i> عرض
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SAVED TAB -->
            <div id="saved-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-bookmark"></i>
                        الوظائف المحفوظة
                    </h2>
                    <p style="color: #999; margin-top: 20px; text-align: center;">قريباً سيتم إضافة المزيد من الميزات</p>
                </div>
            </div>

            <!-- APPLICATIONS TAB -->
            <div id="applications-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        طلباتي
                    </h2>
                    <p style="color: #999; margin-top: 20px; text-align: center;">قريباً سيتم إضافة المزيد من الميزات</p>
                </div>
            </div>

            <!-- PROFILE TAB -->
            <div id="profile-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-user-circle"></i>
                        ملفي الشخصي
                    </h2>
                    <p style="color: #999; margin-top: 20px; text-align: center;">قريباً سيتم إضافة المزيد من الميزات</p>
                </div>
            </div>

            <!-- CERTIFICATES TAB -->
            <div id="certificates-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-certificate"></i>
                        الشهادات
                    </h2>
                    <p style="color: #999; margin-top: 20px; text-align: center;">قريباً سيتم إضافة المزيد من الميزات</p>
                </div>
            </div>

            <!-- MESSAGES TAB -->
            <div id="messages-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-envelope"></i>
                        الرسائل
                    </h2>
                    <p style="color: #999; margin-top: 20px; text-align: center;">قريباً سيتم إضافة المزيد من الميزات</p>
                </div>
            </div>
        </div>
    </div>

    <div id="footer-container"></div>

    <script src="../../../js/dashboard.js"></script>
    <script src="../../../js/navbar-footer-loader.js"></script>
    <script>
        function toggleUserMenu() {
            const userMenu = document.getElementById('userMenu');
            const isVisible = userMenu.classList.contains('show');

            // Close all dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            // Toggle the clicked menu
            if (!isVisible) {
                userMenu.classList.add('show');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const userMenu = document.getElementById('userMenu');
            const userMenuBtn = document.querySelector('.user-menu-btn');

            if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.remove('show');
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        function updateNavbarActiveState(tabName) {
            // Remove active class from navbar links
            document.querySelectorAll('.navbar-link').forEach(link => {
                link.classList.remove('active');
            });
            // Remove active class from dropdown items
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.classList.remove('active');
            });

            // Find and activate the corresponding navbar link or dropdown item
            const activeLink = Array.from(document.querySelectorAll('.navbar-link')).find(link =>
                link.getAttribute('onclick') && link.getAttribute('onclick').includes(tabName)
            );
            const activeDropdownItem = Array.from(document.querySelectorAll('.dropdown-item')).find(item =>
                item.getAttribute('onclick') && item.getAttribute('onclick').includes(tabName)
            );

            if (activeLink) {
                activeLink.classList.add('active');
            }
            if (activeDropdownItem) {
                activeDropdownItem.classList.add('active');
            }
        }

        // Theme persistence
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
