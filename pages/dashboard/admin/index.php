<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - فرصة</title>
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

        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
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

        /* ==================== HIDDEN SECTIONS ==================== */
        #users-tab, #companies-tab, #jobs-tab, #logs-tab {
            display: none;
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
                        <i class="fas fa-user-shield"></i>
                        <span>المسؤول</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userMenu">
                        <div class="user-info">
                            <div class="user-avatar">👨‍💼</div>
                            <div class="user-details">
                                <div class="user-name">أحمد أمين</div>
                                <div class="user-role">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>مسؤول النظام</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" onclick="switchTab('overview')">
                            <i class="fas fa-home"></i>
                            <span>نظرة عامة</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('users')">
                            <i class="fas fa-users"></i>
                            <span>المستخدمون</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('companies')">
                            <i class="fas fa-building"></i>
                            <span>الشركات</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('jobs')">
                            <i class="fas fa-briefcase"></i>
                            <span>الوظائف</span>
                        </button>
                        <button class="dropdown-item" onclick="switchTab('logs')">
                            <i class="fas fa-file-alt"></i>
                            <span>السجلات</span>
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
            <!-- HEADER -->
            <div class="header">
                <button class="sidebar-toggle btn btn-icon" onclick="toggleSidebarMobile()" title="تبديل القائمة"><i class="fas fa-bars"></i></button>
                <h1><i class="fas fa-gauge"></i> لوحة الإدارة</h1>
                <div class="header-right">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-cogs"></i> إعدادات
                    </a>
                    <button class="btn btn-icon" onclick="toggleTheme()" title="تبديل المظهر">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>

            <!-- OVERVIEW TAB -->
            <div id="overview-tab" class="tab-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-label">إجمالي المستخدمين</div>
                        <div class="stat-value">1,234</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+56 هذا الأسبوع</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🏢</div>
                        <div class="stat-label">عدد الشركات</div>
                        <div class="stat-value">89</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+5 جديد</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">💼</div>
                        <div class="stat-label">الوظائف المنشورة</div>
                        <div class="stat-value">456</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+23 هذا الشهر</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-label">معدل التفاعل</div>
                        <div class="stat-value">78%</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            <span>+8% عن السابق</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Users Section -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-history"></i>
                            آخر المستخدمين المسجلين
                        </h2>
                        <a href="#" class="btn btn-primary" onclick="switchTab('users')">
                            <i class="fas fa-eye"></i> عرض الكل
                        </a>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>النوع</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>محمد علي</strong></td>
                                    <td>mohammad@example.com</td>
                                    <td>باحث عن عمل</td>
                                    <td>2025-11-25</td>
                                    <td><span class="badge badge-success">نشط</span></td>
                                </tr>
                                <tr>
                                    <td><strong>فاطمة محمود</strong></td>
                                    <td>fatima@company.com</td>
                                    <td>صاحب عمل</td>
                                    <td>2025-11-24</td>
                                    <td><span class="badge badge-success">نشط</span></td>
                                </tr>
                                <tr>
                                    <td><strong>حسن يوسف</strong></td>
                                    <td>hassan@example.com</td>
                                    <td>باحث عن عمل</td>
                                    <td>2025-11-23</td>
                                    <td><span class="badge badge-info">معطل</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- System Status Section -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-heartbeat"></i>
                            حالة النظام
                        </h2>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>الخدمة</th>
                                    <th>الحالة</th>
                                    <th>الأداء</th>
                                    <th>آخر تحديث</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>قاعدة البيانات</strong></td>
                                    <td><span class="badge badge-success">يعمل</span></td>
                                    <td>✓ ممتاز</td>
                                    <td>2025-11-28</td>
                                </tr>
                                <tr>
                                    <td><strong>خادم الويب</strong></td>
                                    <td><span class="badge badge-success">يعمل</span></td>
                                    <td>✓ سريع</td>
                                    <td>2025-11-28</td>
                                </tr>
                                <tr>
                                    <td><strong>البريد الإلكتروني</strong></td>
                                    <td><span class="badge badge-success">يعمل</span></td>
                                    <td>✓ عادي</td>
                                    <td>2025-11-28</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- USERS TAB -->
            <div id="users-tab" class="tab-content">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-users"></i>
                            إدارة المستخدمين
                        </h2>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="text" id="userSearch" placeholder="البحث في المستخدمين..." style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                            <select id="statusFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الحالات</option>
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                                <option value="suspended">معطل</option>
                                <option value="pending_verification">في انتظار التحقق</option>
                            </select>
                            <select id="typeFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الأنواع</option>
                                <option value="job_seeker">باحث عن عمل</option>
                                <option value="employer">صاحب عمل</option>
                                <option value="admin">مسؤول</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>النوع</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #667eea; margin-bottom: 10px;"></i>
                                        <br>
                                        جاري تحميل المستخدمين...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="pagination" style="margin-top: 20px;"></div>
                </div>
            </div>

            <!-- COMPANIES TAB -->
            <div id="companies-tab" class="tab-content">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-building"></i>
                            إدارة الشركات
                        </h2>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="text" id="companySearch" placeholder="البحث في الشركات..." style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                            <select id="companyStatusFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الحالات</option>
                                <option value="verified">مُتحققة</option>
                                <option value="pending">قيد الانتظار</option>
                                <option value="rejected">مرفوضة</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>اسم الشركة</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>حالة التحقق</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="companiesTableBody">
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #667eea; margin-bottom: 10px;"></i>
                                        <br>
                                        جاري تحميل الشركات...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="companiesPagination" style="margin-top: 20px;"></div>
                </div>
            </div>

            <!-- JOBS TAB -->
            <div id="jobs-tab" class="tab-content">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-briefcase"></i>
                            إدارة الوظائف
                        </h2>
                        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                            <input type="text" id="jobSearch" placeholder="البحث في الوظائف..." style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                            <select id="jobStatusFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الحالات</option>
                                <option value="active">نشطة</option>
                                <option value="closed">مغلقة</option>
                            </select>
                            <select id="jobVerificationFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الوضعيات</option>
                                <option value="1">محققة</option>
                                <option value="0">بانتظار التحقق</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>عنوان الوظيفة</th>
                                    <th>الشركة</th>
                                    <th>الموقع</th>
                                    <th>الراتب</th>
                                    <th>الحالة</th>
                                    <th>التحقق</th>
                                    <th>مميزة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="jobsTableBody">
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #667eea; margin-bottom: 10px;"></i>
                                        <br>
                                        جاري تحميل الوظائف...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="jobsPagination" style="margin-top: 20px;"></div>
                </div>
            </div>

            <!-- LOGS TAB -->
            <div id="logs-tab" class="tab-content">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-file-alt"></i>
                            السجلات
                        </h2>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <select id="logTypeFilter" style="padding: 8px 12px; border: 2px solid rgba(102, 126, 234, 0.2); border-radius: 8px; font-size: 0.9rem;">
                                <option value="">جميع الأنواع</option>
                                <option value="update_user">تحديث المستخدم</option>
                                <option value="delete_user">حذف المستخدم</option>
                                <option value="verify_company">التحقق من الشركة</option>
                                <option value="verify_job">التحقق من الوظيفة</option>
                            </select>
                            <button class="btn btn-primary" onclick="clearOldLogs()" title="حذف السجلات القديمة">
                                <i class="fas fa-trash"></i> حذف القديمة
                            </button>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>الإجراء</th>
                                    <th>النوع</th>
                                    <th>المسؤول</th>
                                    <th>التاريخ والوقت</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="logsTableBody">
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #667eea; margin-bottom: 10px;"></i>
                                        <br>
                                        جاري تحميل السجلات...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="logsPagination" style="margin-top: 20px;"></div>
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

        // User Management Functions
        let currentPage = 1;
        let currentFilters = {};

        function loadUsers(page = 1, filters = {}) {
            currentPage = page;
            currentFilters = filters;

            const params = new URLSearchParams({
                page: page,
                ...filters
            });

            fetch(`../../../php/api/admin_users.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayUsers(data.data.users);
                        displayPagination(data.data.pagination);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading users:', error);
                    showError('حدث خطأ في تحميل المستخدمين');
                });
        }

        function displayUsers(users) {
            const tbody = document.getElementById('usersTableBody');

            if (users.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;">لا توجد مستخدمين</td></tr>';
                return;
            }

            tbody.innerHTML = users.map(user => `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.full_name || user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.phone || '-'}</td>
                    <td>${getUserTypeLabel(user.user_type)}</td>
                    <td><span class="badge ${getStatusBadgeClass(user.status)}">${getStatusLabel(user.status)}</span></td>
                    <td>${new Date(user.created_at).toLocaleDateString('ar')}</td>
                    <td>
                        <button class="btn btn-icon" onclick="editUser(${user.id})" title="تعديل">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-icon" onclick="toggleUserStatus(${user.id}, '${user.status}')" title="تغيير الحالة">
                            <i class="fas fa-${user.status === 'active' ? 'ban' : 'check'}"></i>
                        </button>
                        <button class="btn btn-icon" onclick="deleteUser(${user.id})" title="حذف" style="background: #ef4444; color: white;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function displayPagination(pagination) {
            const paginationEl = document.getElementById('pagination');
            const { page, total_pages } = pagination;

            if (total_pages <= 1) {
                paginationEl.innerHTML = '';
                return;
            }

            let html = '<div style="display: flex; justify-content: center; gap: 10px; align-items: center;">';

            // Previous button
            if (page > 1) {
                html += `<button class="btn" onclick="loadUsers(${page - 1}, currentFilters)">السابق</button>`;
            }

            // Page numbers
            const start = Math.max(1, page - 2);
            const end = Math.min(total_pages, page + 2);

            for (let i = start; i <= end; i++) {
                if (i === page) {
                    html += `<span class="btn btn-primary" style="cursor: default;">${i}</span>`;
                } else {
                    html += `<button class="btn" onclick="loadUsers(${i}, currentFilters)">${i}</button>`;
                }
            }

            // Next button
            if (page < total_pages) {
                html += `<button class="btn" onclick="loadUsers(${page + 1}, currentFilters)">التالي</button>`;
            }

            html += '</div>';
            paginationEl.innerHTML = html;
        }

        function getUserTypeLabel(type) {
            const labels = {
                'job_seeker': 'باحث عن عمل',
                'employer': 'صاحب عمل',
                'admin': 'مسؤول'
            };
            return labels[type] || type;
        }

        function getStatusLabel(status) {
            const labels = {
                'active': 'نشط',
                'inactive': 'غير نشط',
                'suspended': 'معطل',
                'pending_verification': 'في انتظار التحقق'
            };
            return labels[status] || status;
        }

        function getStatusBadgeClass(status) {
            const classes = {
                'active': 'badge-success',
                'inactive': 'badge-warning',
                'suspended': 'badge-danger',
                'pending_verification': 'badge-info'
            };
            return classes[status] || 'badge-info';
        }

        function editUser(userId) {
            // Open edit modal or form
            const newName = prompt('أدخل الاسم الجديد:');
            if (newName && newName.trim()) {
                updateUser(userId, { full_name: newName.trim() });
            }
        }

        function toggleUserStatus(userId, currentStatus) {
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            const confirmMessage = newStatus === 'active' ? 'هل أنت متأكد من تفعيل هذا المستخدم؟' : 'هل أنت متأكد من إلغاء تفعيل هذا المستخدم؟';

            if (confirm(confirmMessage)) {
                updateUser(userId, { status: newStatus });
            }
        }

        function deleteUser(userId) {
            if (confirm('هل أنت متأكد من حذف هذا المستخدم؟ سيتم تعليقه وليس حذفه نهائياً.')) {
                fetch('../../../php/api/admin_users.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ user_id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccess(data.message);
                        loadUsers(currentPage, currentFilters);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    showError('حدث خطأ في حذف المستخدم');
                });
            }
        }

        function updateUser(userId, updates) {
            fetch('../../../php/api/admin_users.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ user_id: userId, ...updates })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccess(data.message);
                    loadUsers(currentPage, currentFilters);
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error updating user:', error);
                showError('حدث خطأ في تحديث المستخدم');
            });
        }

        function showSuccess(message) {
            // Simple notification - you can enhance this
            alert('نجح: ' + message);
        }

        function showError(message) {
            // Simple notification - you can enhance this
            alert('خطأ: ' + message);
        }

        // Event listeners for filters
        document.getElementById('userSearch').addEventListener('input', function() {
            const searchTerm = this.value.trim();
            const filters = { ...currentFilters };
            if (searchTerm) {
                filters.search = searchTerm;
            } else {
                delete filters.search;
            }
            loadUsers(1, filters);
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            const filters = { ...currentFilters };
            if (status) {
                filters.status = status;
            } else {
                delete filters.status;
            }
            loadUsers(1, filters);
        });

        document.getElementById('typeFilter').addEventListener('change', function() {
            const type = this.value;
            const filters = { ...currentFilters };
            if (type) {
                filters.type = type;
            } else {
                delete filters.type;
            }
            loadUsers(1, filters);
        });

        // ============================= COMPANIES =============================
        let currentCompaniesPage = 1;
        let currentCompaniesFilters = {};

        function loadCompanies(page = 1, filters = {}) {
            currentCompaniesPage = page;
            currentCompaniesFilters = filters;

            const params = new URLSearchParams({
                page: page,
                ...filters
            });

            fetch(`../../../php/api/admin_companies.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayCompanies(data.data.companies);
                        displayPagination(data.data.pagination, 'companies');
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading companies:', error);
                    showError('حدث خطأ في تحميل الشركات');
                });
        }

        function displayCompanies(companies) {
            const tbody = document.getElementById('companiesTableBody');

            if (companies.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;">لا توجد شركات</td></tr>';
                return;
            }

            tbody.innerHTML = companies.map(company => `
                <tr>
                    <td>${company.id}</td>
                    <td><strong>${company.name}</strong></td>
                    <td>${company.email}</td>
                    <td>${company.phone || '-'}</td>
                    <td><span class="badge ${getVerificationBadgeClass(company.verification_status)}">${getVerificationLabel(company.verification_status)}</span></td>
                    <td><span class="badge ${company.is_active ? 'badge-success' : 'badge-danger'}">${company.is_active ? 'نشطة' : 'معطلة'}</span></td>
                    <td>${new Date(company.created_at).toLocaleDateString('ar')}</td>
                    <td>
                        ${company.verification_status === 'pending' ? `
                            <button class="btn btn-icon" onclick="verifyCompany(${company.id})" title="قبول" style="background: #10b981; color: white;">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-icon" onclick="rejectCompany(${company.id})" title="رفض" style="background: #ef4444; color: white;">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                        <button class="btn btn-icon" onclick="editCompany(${company.id})" title="تعديل">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-icon" onclick="toggleCompanyStatus(${company.id})" title="${company.is_active ? 'تعطيل' : 'تفعيل'}">
                            <i class="fas fa-${company.is_active ? 'ban' : 'check'}"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function getVerificationBadgeClass(status) {
            const classes = {
                'verified': 'badge-success',
                'pending': 'badge-warning',
                'rejected': 'badge-danger'
            };
            return classes[status] || 'badge-info';
        }

        function getVerificationLabel(status) {
            const labels = {
                'verified': 'مُتحققة',
                'pending': 'قيد الانتظار',
                'rejected': 'مرفوضة'
            };
            return labels[status] || status;
        }

        function verifyCompany(companyId) {
            if (confirm('هل أنت متأكد من قبول هذه الشركة؟')) {
                updateCompany(companyId, { action: 'verify' });
            }
        }

        function rejectCompany(companyId) {
            if (confirm('هل أنت متأكد من رفض هذه الشركة؟')) {
                updateCompany(companyId, { action: 'reject' });
            }
        }

        function editCompany(companyId) {
            const newName = prompt('أدخل الاسم الجديد:');
            if (newName && newName.trim()) {
                updateCompany(companyId, { action: 'update', name: newName.trim() });
            }
        }

        function toggleCompanyStatus(companyId) {
            updateCompany(companyId, { action: 'toggle_status' });
        }

        function updateCompany(companyId, data) {
            fetch('../../../php/api/admin_companies.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ company_id: companyId, ...data })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccess(data.message);
                    loadCompanies(currentCompaniesPage, currentCompaniesFilters);
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error updating company:', error);
                showError('حدث خطأ في تحديث الشركة');
            });
        }

        document.getElementById('companySearch') && document.getElementById('companySearch').addEventListener('input', function() {
            const searchTerm = this.value.trim();
            const filters = { ...currentCompaniesFilters };
            if (searchTerm) {
                filters.search = searchTerm;
            } else {
                delete filters.search;
            }
            loadCompanies(1, filters);
        });

        document.getElementById('companyStatusFilter') && document.getElementById('companyStatusFilter').addEventListener('change', function() {
            const status = this.value;
            const filters = { ...currentCompaniesFilters };
            if (status) {
                filters.status = status;
            } else {
                delete filters.status;
            }
            loadCompanies(1, filters);
        });

        // ============================= JOBS =============================
        let currentJobsPage = 1;
        let currentJobsFilters = {};

        function loadJobs(page = 1, filters = {}) {
            currentJobsPage = page;
            currentJobsFilters = filters;

            const params = new URLSearchParams({
                page: page,
                ...filters
            });

            fetch(`../../../php/api/admin_jobs.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayJobs(data.data.jobs);
                        displayPagination(data.data.pagination, 'jobs');
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading jobs:', error);
                    showError('حدث خطأ في تحميل الوظائف');
                });
        }

        function displayJobs(jobs) {
            const tbody = document.getElementById('jobsTableBody');

            if (jobs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 40px;">لا توجد وظائف</td></tr>';
                return;
            }

            tbody.innerHTML = jobs.map(job => {
                const salary = job.salary_min && job.salary_max 
                    ? `${job.salary_min} - ${job.salary_max}` 
                    : 'غير محدد';
                return `
                    <tr>
                        <td>${job.id}</td>
                        <td><strong>${job.title}</strong></td>
                        <td>${job.company_name || '-'}</td>
                        <td>${job.location}</td>
                        <td>${salary}</td>
                        <td><span class="badge ${job.status === 'active' ? 'badge-success' : 'badge-danger'}">${job.status === 'active' ? 'نشطة' : 'مغلقة'}</span></td>
                        <td><span class="badge ${job.is_verified ? 'badge-success' : 'badge-warning'}">${job.is_verified ? 'محققة' : 'بانتظار'}</span></td>
                        <td><span class="badge ${job.is_featured ? 'badge-success' : 'badge-info'}">${job.is_featured ? 'مميزة' : 'عادية'}</span></td>
                        <td>${new Date(job.created_at).toLocaleDateString('ar')}</td>
                        <td>
                            ${!job.is_verified ? `
                                <button class="btn btn-icon" onclick="verifyJob(${job.id})" title="قبول" style="background: #10b981; color: white;">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-icon" onclick="rejectJob(${job.id})" title="رفض" style="background: #ef4444; color: white;">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : ''}
                            <button class="btn btn-icon" onclick="featureJob(${job.id}, ${job.is_featured ? 0 : 1})" title="${job.is_featured ? 'إلغاء التمييز' : 'تمييز'}">
                                <i class="fas fa-star"></i>
                            </button>
                            <button class="btn btn-icon" onclick="deleteJob(${job.id})" title="حذف" style="background: #ef4444; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function verifyJob(jobId) {
            if (confirm('هل أنت متأكد من قبول نشر هذه الوظيفة؟')) {
                updateJob(jobId, { action: 'verify' });
            }
        }

        function rejectJob(jobId) {
            if (confirm('هل أنت متأكد من رفض هذه الوظيفة؟')) {
                updateJob(jobId, { action: 'reject' });
            }
        }

        function featureJob(jobId, featured) {
            updateJob(jobId, { action: 'feature', featured: featured });
        }

        function deleteJob(jobId) {
            if (confirm('هل أنت متأكد من حذف هذه الوظيفة؟')) {
                fetch('../../../php/api/admin_jobs.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ job_id: jobId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccess(data.message);
                        loadJobs(currentJobsPage, currentJobsFilters);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting job:', error);
                    showError('حدث خطأ في حذف الوظيفة');
                });
            }
        }

        function updateJob(jobId, data) {
            fetch('../../../php/api/admin_jobs.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ job_id: jobId, ...data })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showSuccess(data.message);
                    loadJobs(currentJobsPage, currentJobsFilters);
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error('Error updating job:', error);
                showError('حدث خطأ في تحديث الوظيفة');
            });
        }

        document.getElementById('jobSearch') && document.getElementById('jobSearch').addEventListener('input', function() {
            const searchTerm = this.value.trim();
            const filters = { ...currentJobsFilters };
            if (searchTerm) {
                filters.search = searchTerm;
            } else {
                delete filters.search;
            }
            loadJobs(1, filters);
        });

        document.getElementById('jobStatusFilter') && document.getElementById('jobStatusFilter').addEventListener('change', function() {
            const status = this.value;
            const filters = { ...currentJobsFilters };
            if (status) {
                filters.status = status;
            } else {
                delete filters.status;
            }
            loadJobs(1, filters);
        });

        document.getElementById('jobVerificationFilter') && document.getElementById('jobVerificationFilter').addEventListener('change', function() {
            const verification = this.value;
            const filters = { ...currentJobsFilters };
            if (verification) {
                filters.verification = verification;
            } else {
                delete filters.verification;
            }
            loadJobs(1, filters);
        });

        // ============================= LOGS =============================
        let currentLogsPage = 1;
        let currentLogsFilters = {};

        function loadLogs(page = 1, filters = {}) {
            currentLogsPage = page;
            currentLogsFilters = filters;

            const params = new URLSearchParams({
                page: page,
                ...filters
            });

            fetch(`../../../php/api/admin_logs.php?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        displayLogs(data.data.logs);
                        displayPagination(data.data.pagination, 'logs');
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading logs:', error);
                    showError('حدث خطأ في تحميل السجلات');
                });
        }

        function displayLogs(logs) {
            const tbody = document.getElementById('logsTableBody');

            if (logs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;">لا توجد سجلات</td></tr>';
                return;
            }

            tbody.innerHTML = logs.map(log => {
                const dateTime = new Date(log.created_at).toLocaleString('ar');
                return `
                    <tr>
                        <td>${log.id}</td>
                        <td>${log.action}</td>
                        <td><span class="badge badge-info">${log.type}</span></td>
                        <td>${log.admin_name || 'نظام'}</td>
                        <td>${dateTime}</td>
                        <td>
                            <button class="btn btn-icon" onclick="deleteLog(${log.id})" title="حذف" style="background: #ef4444; color: white;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function deleteLog(logId) {
            if (confirm('هل أنت متأكد من حذف هذا السجل؟')) {
                fetch('../../../php/api/admin_logs.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'delete_single', log_id: logId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccess(data.message);
                        loadLogs(currentLogsPage, currentLogsFilters);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting log:', error);
                    showError('حدث خطأ في حذف السجل');
                });
            }
        }

        function clearOldLogs() {
            if (confirm('هل أنت متأكد من حذف السجلات أقدم من 30 يوم؟')) {
                fetch('../../../php/api/admin_logs.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'clear_by_date', days: 30 })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccess(data.message);
                        loadLogs(1, {});
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error clearing logs:', error);
                    showError('حدث خطأ في حذف السجلات');
                });
            }
        }

        document.getElementById('logTypeFilter') && document.getElementById('logTypeFilter').addEventListener('change', function() {
            const type = this.value;
            const filters = { ...currentLogsFilters };
            if (type) {
                filters.type = type;
            } else {
                delete filters.type;
            }
            loadLogs(1, filters);
        });

        // ============================= GENERIC PAGINATION =============================
        function displayPagination(pagination, type) {
            const paginationEl = document.getElementById(type + 'Pagination');
            const { page, total_pages } = pagination;

            if (total_pages <= 1) {
                paginationEl.innerHTML = '';
                return;
            }

            let html = '<div style="display: flex; justify-content: center; gap: 10px; align-items: center;">';

            // Previous button
            if (page > 1) {
                const filters = type === 'companies' ? currentCompaniesFilters : (type === 'jobs' ? currentJobsFilters : currentLogsFilters);
                const loadFunc = type === 'companies' ? 'loadCompanies' : (type === 'jobs' ? 'loadJobs' : 'loadLogs');
                html += `<button class="btn" onclick="${loadFunc}(${page - 1}, currentFilters = JSON.parse('${JSON.stringify(filters)}'))">السابق</button>`;
            }

            // Page numbers
            const start = Math.max(1, page - 2);
            const end = Math.min(total_pages, page + 2);

            for (let i = start; i <= end; i++) {
                const filters = type === 'companies' ? currentCompaniesFilters : (type === 'jobs' ? currentJobsFilters : currentLogsFilters);
                const loadFunc = type === 'companies' ? 'loadCompanies' : (type === 'jobs' ? 'loadJobs' : 'loadLogs');
                if (i === page) {
                    html += `<span class="btn btn-primary" style="cursor: default;">${i}</span>`;
                } else {
                    html += `<button class="btn" onclick="${loadFunc}(${i}, JSON.parse('${JSON.stringify(filters)}'))">${i}</button>`;
                }
            }

            // Next button
            if (page < total_pages) {
                const filters = type === 'companies' ? currentCompaniesFilters : (type === 'jobs' ? currentJobsFilters : currentLogsFilters);
                const loadFunc = type === 'companies' ? 'loadCompanies' : (type === 'jobs' ? 'loadJobs' : 'loadLogs');
                html += `<button class="btn" onclick="${loadFunc}(${page + 1}, JSON.parse('${JSON.stringify(filters)}'))">التالي</button>`;
            }

            html += '</div>';
            paginationEl.innerHTML = html;
        }

        // Load users when users tab is clicked
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').style.display = 'block';

            // Update active state in navbar
            updateNavbarActiveState(tabName);

            // Load data for specific tab
            if (tabName === 'users') {
                loadUsers();
            } else if (tabName === 'companies') {
                loadCompanies();
            } else if (tabName === 'jobs') {
                loadJobs();
            } else if (tabName === 'logs') {
                loadLogs();
            }
        }

        // ============================= STATS AUTO-UPDATE =============================
        function loadStats() {
            fetch('../../../php/api/admin_stats.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateStatsDisplay(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                });
        }

        function updateStatsDisplay(stats) {
            const statCards = document.querySelectorAll('.stat-card');
            if (statCards.length >= 4) {
                statCards[0].querySelector('.stat-value').textContent = stats.total_users.toLocaleString('ar');
                statCards[1].querySelector('.stat-value').textContent = stats.total_companies.toLocaleString('ar');
                statCards[2].querySelector('.stat-value').textContent = stats.total_jobs.toLocaleString('ar');
                statCards[3].querySelector('.stat-value').textContent = stats.acceptance_rate + '%';
                
                if (stats.new_users_week !== undefined) {
                    statCards[0].querySelector('.stat-change').innerHTML = `<i class="fas fa-arrow-up"></i><span>+${stats.new_users_week} هذا الأسبوع</span>`;
                }
                if (stats.new_companies_week !== undefined) {
                    statCards[1].querySelector('.stat-change').innerHTML = `<i class="fas fa-arrow-up"></i><span>+${stats.new_companies_week} جديد</span>`;
                }
                if (stats.new_jobs_week !== undefined) {
                    statCards[2].querySelector('.stat-change').innerHTML = `<i class="fas fa-arrow-up"></i><span>+${stats.new_jobs_week} هذا الشهر</span>`;
                }
            }
        }

        loadStats();
        setInterval(loadStats, 30000);

    </script>
</body>
</html>
