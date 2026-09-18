<?php
session_start();
$emp_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'المستخدم');
$emp_avatar = isset($_SESSION['avatar_url']) ? $_SESSION['avatar_url'] : null;
$emp_role = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'employer';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - صاحب العمل - فرصة</title>
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

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7ff 0%, #f0e6ff 50%, #ffe6f0 100%);
            color: #2d3436;
            transition: background 0.3s ease;
            overflow-x: hidden;
            min-height: 100vh;
        }

        body.dark-mode {
            background: #0f172a;
            color: #e2e8f0;
        }

        /* ==================== TOP NAVBAR ==================== */
        .top-navbar {
            background: transparent;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 100;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
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
            text-decoration: none;
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

        /* ==================== TOP NAVBAR ==================== */
        .top-navbar {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 147, 251, 0.05) 100%);
            padding: 15px 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15);
            border: 2px solid rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            margin-left: auto;
            justify-content: right;
        }

        /* ==================== SIDEBAR (Hidden) ==================== */
        .sidebar {
            display: none;
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
            flex-wrap: wrap;
            gap: 15px;
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
            flex-wrap: wrap;
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
            white-space: nowrap;
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

        /* ==================== STATS GRID ==================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
            flex-wrap: wrap;
            gap: 15px;
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
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
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

        /* ==================== TABS ==================== */
        .tab-content {
            animation: fadeInUp 0.4s ease;
        }

        #saved-tab, #applications-tab, #profile-tab, #messages-tab {
            display: none;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 1200px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 240px;
            }

            .main-content {
                margin-left: 240px;
                padding: 25px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.7rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 2.2rem;
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
                display: none;
            }

            .sidebar-toggle {
                display: none !important;
            }

            .sidebar-overlay {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                margin-bottom: 20px;
            }

            .header {
                flex-direction: column;
                gap: 12px;
                padding: 15px;
                margin-bottom: 20px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .header h1 {
                font-size: 1.4rem;
            }

            .section {
                padding: 20px;
                margin-bottom: 15px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .table-wrapper {
                font-size: 0.9rem;
            }

            table th, table td {
                padding: 12px 8px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 0.85rem;
            }

            .btn-icon {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 12px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 1.8rem;
            }

            .stat-icon {
                font-size: 2rem;
            }

            .header {
                padding: 12px;
                margin-bottom: 15px;
            }

            .header h1 {
                font-size: 1.1rem;
            }

            .header-right {
                flex-direction: column-reverse;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .section {
                padding: 15px;
                margin-bottom: 12px;
            }

            .section-title {
                font-size: 1rem;
            }

            table {
                font-size: 0.8rem;
            }

            table th, table td {
                padding: 8px 4px;
            }

            .badge {
                padding: 4px 10px;
                font-size: 0.7rem;
            }
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
                        <i class="fas fa-building"></i>
                        <span><?= htmlspecialchars($emp_name) ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userMenu">
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php if (!empty($emp_avatar)): ?>
                                    <img src="<?= htmlspecialchars($emp_avatar) ?>" alt="avatar" style="width:50px;height:50px;border-radius:50%;object-fit:cover;" />
                                <?php else: ?>
                                    <?= htmlspecialchars(mb_substr($emp_name,0,1,'UTF-8')) ?>
                                <?php endif; ?>
                            </div>
                            <div class="user-details">
                                <div class="user-name"><?= htmlspecialchars($emp_name) ?></div>
                                <div class="user-role">
                                    <i class="fas fa-building"></i>
                                    <span>صاحب عمل</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" onclick="switchTab('post-job')">
                            <i class="fas fa-plus"></i>
                            <span>نشر وظيفة</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('my-jobs')">
                            <i class="fas fa-briefcase"></i>
                            <span>وظائفي</span>
                        </button>
                      
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item logout-btn" href="../../php/logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- HEADER -->
            <div class="header">
                <h1><i class="fas fa-gauge"></i> لوحة التحكم</h1>
                <div class="header-right">
                    <a href="../../jobs.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة وظيفة
                    </a>
                    <button class="btn btn-icon" onclick="toggleTheme()" title="تبديل المظهر">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>

            <!-- POST JOB TAB -->
            <div id="post-job-tab" class="tab-content">
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-plus"></i>
                        نشر وظيفة جديدة
                    </h2>
                    <form id="job-post-form" style="margin-top: 30px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">عنوان الوظيفة</label>
                                <input type="text" required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">فئة الوظيفة</label>
                                <select required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                    <option value="">اختر الفئة</option>
                                    <option value="it">تكنولوجيا المعلومات</option>
                                    <option value="engineering">هندسة</option>
                                    <option value="marketing">تسويق</option>
                                    <option value="finance">مالية</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">نوع الوظيفة</label>
                                <select required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                    <option value="full_time">دوام كامل</option>
                                    <option value="part_time">دوام جزئي</option>
                                    <option value="freelance">عمل حر</option>
                                    <option value="contract">عقد محدد</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">المدينة</label>
                                <select required style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                                    <option value="صنعاء">صنعاء</option>
                                    <option value="عدن">عدن</option>
                                    <option value="تعز">تعز</option>
                                    <option value="إب">إب</option>
                                    <option value="الحديدة">الحديدة</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">الراتب الدنيا (ريال يمني)</label>
                                <input type="number" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 8px; font-weight: 600;">الراتب العليا (ريال يمني)</label>
                                <input type="number" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">وصف الوظيفة</label>
                            <textarea required rows="6" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                        </div>
                        <div style="margin-top: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">المتطلبات</label>
                            <textarea required rows="4" style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                        </div>
                        <div style="margin-top: 30px; text-align: center;">
                            <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 16px;">
                                <i class="fas fa-paper-plane"></i> نشر الوظيفة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MY JOBS TAB -->
            <div id="my-jobs-tab" class="tab-content">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-briefcase"></i>
                            وظائفي المنشورة
                        </h2>
                        <button class="btn btn-primary" onclick="switchTab('post-job')">
                            <i class="fas fa-plus"></i> نشر وظيفة جديدة
                        </button>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>عنوان الوظيفة</th>
                                    <th>الحالة</th>
                                    <th>عدد المتقدمين</th>
                                    <th>تاريخ النشر</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody id="my-jobs-table">
                                <tr>
                                    <td><strong>مهندس برمجيات سينيور</strong></td>
                                    <td><span class="badge badge-success">نشط</span></td>
                                    <td>15</td>
                                    <td>2025-11-20</td>
                                    <td>
                                        <button class="btn btn-primary">
                                            <i class="fas fa-eye"></i> عرض
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>مطور ويب فول ستاك</strong></td>
                                    <td><span class="badge badge-success">نشط</span></td>
                                    <td>12</td>
                                    <td>2025-11-18</td>
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
        </div>
    </div>

    <div id="footer-container"></div>

    <script src="../../../js/dashboard.js"></script>
    <script src="../../../js/navbar-footer-loader.js"></script>
    <script>
        function toggleUserMenu() {
            const userMenu = document.getElementById('userMenu');
            const isVisible = userMenu.classList.contains('show');
            document.querySelectorAll('.dropdown-menu').forEach(menu=>menu.classList.remove('show'));
            if (!isVisible) userMenu.classList.add('show');
        }

        document.addEventListener('click', (e) => {
            const userMenu = document.getElementById('userMenu');
            const userMenuBtn = document.querySelector('.user-menu-btn');
            if (!userMenu || !userMenuBtn) return;
            if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.remove('show');
            }
        });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') document.querySelectorAll('.dropdown-menu').forEach(m=>m.classList.remove('show')); });

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
        
        // Open tab if specified by URL query ?tab=post-job or ?tab=my-jobs
        (function openTabFromQuery(){
            try {
                const params = new URLSearchParams(window.location.search);
                const tab = params.get('tab');
                if (tab) {
                    // delay to allow DOM
                    setTimeout(()=>{
                        if (typeof switchTab === 'function') switchTab(tab);
                    }, 50);
                }
            } catch (e) {}
        })();
    </script>
    <script>
        function toggleSidebarMobile() {
            // No sidebar in employer dashboard
        }

        function switchTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.style.display = 'none');

            // Show selected tab
            const selectedTab = document.getElementById(tabName + '-tab');
            if (selectedTab) {
                selectedTab.style.display = 'block';
            }

            // Update active state
            updateNavbarActiveState(tabName);
        }

        // Job posting form handler
        document.getElementById('job-post-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would typically send the form data to the server
            alert('تم إرسال الوظيفة للمراجعة من قبل المسؤول');
            this.reset();
        });
    </script>
</body>
</html>
