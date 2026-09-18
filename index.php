<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="فرصة - منصة توظيف ذكية متخصصة في اليمن">
    <meta name="theme-color" content="#1e40af">
    <title>فرصة - منصة التوظيف الذكية</title>
    
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/rtl.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar-footer.css">
    
    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }

        @keyframes glow {
            0%, 100% { text-shadow: 0 0 10px rgba(102, 126, 234, 0.3); }
            50% { text-shadow: 0 0 30px rgba(102, 126, 234, 0.6), 0 0 50px rgba(118, 75, 162, 0.4); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes pulse-scale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .hero-badge {
            display: inline-block;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            color: #667eea;
            padding: 12px 28px;
            border-radius: 50px;
            margin-bottom: 30px;
            font-size: 0.95rem;
            font-weight: 700;
            animation: slideDown 0.6s ease, pulse-scale 3s ease-in-out infinite;
            border: 2px solid rgba(102, 126, 234, 0.3);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.1;
            animation: slideUp 0.8s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideUp 0.8s ease, gradient-shift 8s ease infinite;
        }

        .hero-title span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 30%, #f093fb 60%, #4facfe 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 6s ease infinite;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            background: linear-gradient(135deg, #4b5563 0%, #2d3436 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 50px;
            line-height: 1.7;
            animation: slideUp 0.7s ease 0.1s backwards;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .search-box {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 100%);
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15), inset 0 1px 0 rgba(255,255,255,0.8);
            border: 2px solid rgba(102, 126, 234, 0.2);
            animation: slideUp 0.8s ease 0.2s backwards, float 4s ease-in-out infinite;
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .search-box::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(79, 172, 254, 0.1) 100%);
            animation: blob 8s ease-in-out infinite;
            z-index: 0;
        }

        .search-box > * {
            position: relative;
            z-index: 1;
        }

        .search-primary {
            margin-bottom: 25px;
        }

        .search-primary input {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 16px;
            font-size: 1.05em;
            background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(240, 147, 251, 0.02));
            color: #2d3436;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: inherit;
            font-weight: 500;
        }

        .search-primary input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 5px rgba(102, 126, 234, 0.15), 0 10px 30px rgba(102, 126, 234, 0.1);
            background: linear-gradient(135deg, rgba(255,255,255,1), rgba(240, 147, 251, 0.05));
        }

        .search-primary input::placeholder {
            color: #a0aec0;
        }

        .search-filters {
            display: block;
            margin-bottom: 20px;
            padding: 30px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(240, 147, 251, 0.05));
            border-radius: 16px;
            border: 2px solid rgba(102, 126, 234, 0.1);
            backdrop-filter: blur(5px);
        }

        .search-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 0;
        }

        .search-input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .search-input-group label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95em;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .search-input-group input,
        .search-input-group select {
            padding: 14px 18px;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 12px;
            font-size: 0.98em;
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(240, 147, 251, 0.03));
            color: #2d3436;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: inherit;
            font-weight: 500;
        }

        .search-input-group input:focus,
        .search-input-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15), 0 5px 20px rgba(102, 126, 234, 0.1);
            background: linear-gradient(135deg, rgba(255,255,255,1), rgba(240, 147, 251, 0.08));
        }

        .search-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
        }

        .search-btn {
            width: 100%;
            padding: 16px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1.05em;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .search-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .search-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4), 0 0 30px rgba(240, 147, 251, 0.3);
            background-position: 100% 0;
        }

        .search-btn:hover::before {
            left: 100%;
        }

        .search-btn:active {
            transform: translateY(-1px);
        }

        .advanced-search-btn {
            width: 100%;
            padding: 15px 30px;
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .advanced-search-btn:hover {
            background: var(--primary);
            color: white;
        }

        .features-section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 70px;
            position: relative;
            padding-bottom: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            border-radius: 3px;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3), 0 0 40px rgba(240, 147, 251, 0.2);
            animation: pulse-scale 2s ease-in-out infinite;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            padding: 45px 40px;
            border-radius: 20px;
            border: 2px solid rgba(102, 126, 234, 0.15);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 0;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            transition: left 0.6s;
            z-index: 1;
        }

        .feature-card:hover {
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2), inset 0 0 20px rgba(240, 147, 251, 0.05);
            transform: translateY(-15px) scale(1.02);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover::after {
            left: 100%;
        }

        .feature-icon {
            font-size: 4em;
            margin-bottom: 25px;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        .feature-card h3 {
            font-size: 1.4em;
            margin-bottom: 15px;
            color: #2d3436;
            font-weight: 800;
            position: relative;
            z-index: 2;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card p {
            color: #555;
            line-height: 1.8;
            font-size: 0.98em;
            position: relative;
            z-index: 2;
            font-weight: 500;
        }

        .jobs-section {
            background: linear-gradient(135deg, var(--light) 0%, rgba(102, 126, 234, 0.05) 100%);
            padding: 80px 0;
        }

        .latest-jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .latest-job-card {
            background: linear-gradient(135deg, #fff 0%, rgba(240, 147, 251, 0.02) 100%);
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 18px;
            padding: 35px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease;
            backdrop-filter: blur(10px);
        }

        .latest-job-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            transition: width 0.3s;
        }

        .latest-job-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .latest-job-card:hover {
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.2), inset 0 0 20px rgba(240, 147, 251, 0.05);
            transform: translateY(-12px) scale(1.01);
        }

        .latest-job-card:hover::before {
            width: 100%;
        }

        .latest-job-card:hover::after {
            opacity: 1;
        }

        .job-card-title {
            font-size: 1.4em;
            font-weight: 800;
            margin-bottom: 12px;
            color: #2d3436;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s;
        }

        .latest-job-card:hover .job-card-title {
            -webkit-text-fill-color: unset;
            color: #667eea;
        }

        .job-card-company {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.05em;
        }

        .job-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .job-card-badge {
            display: inline-block;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(240, 147, 251, 0.15));
            color: #667eea;
            border-radius: 8px;
            font-size: 0.88em;
            font-weight: 700;
            border: 1px solid rgba(102, 126, 234, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .job-card-desc {
            color: #555;
            font-size: 0.98em;
            margin-bottom: 15px;
            line-height: 1.7;
            min-height: 60px;
            font-weight: 500;
        }

        .job-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
        }

        .job-card-btn {
            display: inline-block;
            padding: 11px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .job-card-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .job-card-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .job-card-btn:hover::before {
            left: 100%;
        }

        .view-all-btn {
            display: inline-block;
            margin-top: 50px;
            padding: 16px 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .view-all-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s;
        }

        .view-all-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.4), 0 0 30px rgba(240, 147, 251, 0.3);
            background-position: 100% 0;
        }

        .view-all-btn:hover::before {
            left: 100%;
        }

        .view-all-btn:active {
            transform: translateY(-1px);
        }

        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            animation: gradient-shift 10s ease infinite;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s ease infinite;
            z-index: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            text-align: center;
            padding: 45px 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2), inset 0 0 20px rgba(255, 255, 255, 0.1);
            transform: translateY(-8px) scale(1.05);
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-number {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 15px;
            animation: countUp 2.5s ease-out;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.15em;
            opacity: 0.98;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px) scale(0.8); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .no-jobs-message {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .advanced-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .advanced-modal.active {
            display: flex;
        }

        .advanced-modal-content {
            background: var(--light);
            border-radius: 16px;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            box-shadow: var(--shadow-xl);
            animation: slideUp 0.3s ease;
        }

        .advanced-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        .advanced-modal-header h2 {
            margin: 0;
            color: var(--text-dark);
        }

        .advanced-modal-close {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #6b7280;
        }

        .advanced-modal-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .advanced-modal-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .advanced-modal-field label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .advanced-modal-field input,
        .advanced-modal-field select {
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 1em;
            background: var(--light);
            color: var(--text-dark);
            font-family: inherit;
        }

        .advanced-modal-field input:focus,
        .advanced-modal-field select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .advanced-modal-actions {
            display: flex;
            gap: 15px;
        }

        .advanced-modal-actions button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .advanced-modal-actions .search-btn {
            flex: auto;
        }

        body.dark-mode .search-box,
        body.dark-mode .feature-card,
        body.dark-mode .latest-job-card,
        body.dark-mode .advanced-modal-content {
            background: var(--dark-light);
        }

        body.dark-mode .search-primary input,
        body.dark-mode .search-input-group input,
        body.dark-mode .search-input-group select,
        body.dark-mode .advanced-modal-field input,
        body.dark-mode .advanced-modal-field select {
            background: var(--dark-light);
            color: var(--text-dark);
        }

        body.dark-mode .search-filters {
            background: rgba(102, 126, 234, 0.05);
            border-color: rgba(102, 126, 234, 0.15);
        }

        body.dark-mode .hero-subtitle,
        body.dark-mode .feature-card p,
        body.dark-mode .job-card-desc {
            color: #a0aec0;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1em;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .features-grid,
            .latest-jobs-grid {
                grid-template-columns: 1fr;
            }

            .search-primary input {
                font-size: 0.95em;
                padding: 14px 16px;
            }

            .search-filters {
                padding: 20px;
            }

            .search-inputs {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .search-input-group label {
                justify-content: flex-start;
            }

            .search-btn,
            .advanced-search-btn {
                padding: 13px 24px;
                font-size: 0.95em;
            }

            .advanced-modal-fields {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <meta property="og:title" content="فرصة - منصة التوظيف الذكية">
    <meta property="og:description" content="منصة توظيف ذكية متخصصة في اليمن بنظام مطابقة ذكي">
    <meta property="og:image" content="images/logo.png">
</head>
<body>
    <div id="navbar-container"></div>

    <section class="hero" id="home" style="padding: 120px 20px; background: linear-gradient(135deg, #f5f7ff 0%, #f0e6ff 50%, #ffe6f0 100%); position: relative; overflow: hidden;">
        <style>
            .hero::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: 
                    radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(79, 172, 254, 0.1) 0%, transparent 50%);
                animation: blob 15s ease-in-out infinite;
                z-index: 0;
            }

            .hero .container {
                position: relative;
                z-index: 1;
            }
        </style>
        <div class="container">
            <div style="text-align: center;">
                <div class="hero-badge">
                    <i class="fas fa-chart-line" style="margin-left: 8px;"></i>أكثر من 20,000 فرصة عمل نشطة
                </div>
                <h1 class="hero-title">
                    ابحث عن <span>الفرصة المثالية</span>
                    <br>واصنع مستقبلك المهني
                </h1>
                <p class="hero-subtitle">
                    منصة التوظيف الأولى في اليمن ترتبطك بأفضل الفرص الوظيفية والتدريبية مع أكبر الشركات والمنظمات المحلية والدولية
                </p>
            </div>
        </div>
    </section>

    <section class="features-section" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9ff 50%, #f3f0ff 100%); position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.5; background-image: 
            radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.05) 0%, transparent 50%);
            pointer-events: none; z-index: 0;"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <h2 class="section-title">مميزات المنصة</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3>مطابقة ذكية</h3>
                    <p>نظام ذكي يطابق الوظائف مع المرشحين بناءً على المهارات والخبرة والموقع الجغرافي</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>شهادات آمنة</h3>
                    <p>تحقق من الشهادات باستخدام تقنية البلوكشين لضمان الأمان والموثوقية الكاملة</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3>تطوير مهني</h3>
                    <p>دورات تدريبية متخصصة لتطوير مهاراتك والحصول على شهادات رسمية معترف بها</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>متعدد المنصات</h3>
                    <p>تطبيق ويب متجاوب يعمل على جميع الأجهزة والشاشات بكفاءة عالية جداً</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h3>إشعارات ذكية</h3>
                    <p>احصل على إشعارات فورية حول الوظائف المناسبة والطلبات الجديدة والفرص</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌙</div>
                    <h3>وضع ليلي</h3>
                    <p>استخدم المنصة براحة مع الوضع الليلي المحسّن والحماية الكاملة للعيون</p>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="jobs-section" style="background: linear-gradient(180deg, #ffffff 0%, #f9fafb 50%, #f3f4f6 100%); position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.3; background-image: 
            radial-gradient(circle at 80% 20%, rgba(102, 126, 234, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 20% 80%, rgba(79, 172, 254, 0.08) 0%, transparent 50%);
            pointer-events: none; z-index: 0;"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <h2 class="section-title">آخر الوظائف المضافة</h2>
            <div class="latest-jobs-grid" id="latest-jobs">
                <div class="no-jobs-message">
                    <i class="fas fa-briefcase" style="font-size: 2em; margin-bottom: 10px; display: block; color: #d1d5db;"></i>
                    جاري تحميل الوظائف...
                </div>
            </div>
            <div style="text-align: center;">
                <a href="pages/jobs.php" class="view-all-btn">
                    <i class="fas fa-arrow-left"></i> عرض جميع الوظائف
                </a>
            </div>
        </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <h2 class="section-title" style="color: white; margin-bottom: 60px;">إحصائيات المنصة</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" id="stat-users">0</div>
                    <div class="stat-label"><i class="fas fa-users" style="margin-right: 10px;"></i>مستخدم نشط</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="stat-jobs">0</div>
                    <div class="stat-label"><i class="fas fa-briefcase" style="margin-right: 10px;"></i>وظيفة مفتوحة</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="stat-companies">0</div>
                    <div class="stat-label"><i class="fas fa-building" style="margin-right: 10px;"></i>شركة موثوقة</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="stat-applications">0</div>
                    <div class="stat-label"><i class="fas fa-paper-plane" style="margin-right: 10px;"></i>طلب توظيف</div>
                </div>
            </div>
        </div>
    </section>

    <div class="advanced-modal" id="advancedModal">
        <div class="advanced-modal-content">
            <div class="advanced-modal-header">
                <h2><i class="fas fa-sliders-h"></i> بحث متقدم</h2>
                <button class="advanced-modal-close" onclick="closeAdvancedSearch()">✕</button>
            </div>
            <div class="advanced-modal-fields">
                <div class="advanced-modal-field">
                    <label>اسم الوظيفة</label>
                    <input type="text" id="adv-job" placeholder="أدخل اسم الوظيفة">
                </div>
                <div class="advanced-modal-field">
                    <label>المدينة</label>
                    <select id="adv-location">
                        <option value="">جميع المدن</option>
                        <option value="صنعاء">صنعاء</option>
                        <option value="عدن">عدن</option>
                        <option value="تعز">تعز</option>
                        <option value="إب">إب</option>
                        <option value="الحديدة">الحديدة</option>
                    </select>
                </div>
                <div class="advanced-modal-field">
                    <label>نوع الوظيفة</label>
                    <select id="adv-type">
                        <option value="">جميع الأنواع</option>
                        <option value="full_time">دوام كامل</option>
                        <option value="part_time">دوام جزئي</option>
                        <option value="freelance">عمل حر</option>
                        <option value="contract">عقد محدد</option>
                    </select>
                </div>
                <div class="advanced-modal-field">
                    <label>الحد الأدنى للراتب (YER)</label>
                    <input type="number" id="adv-salary-min" placeholder="أدخل الحد الأدنى">
                </div>
                <div class="advanced-modal-field">
                    <label>الحد الأقصى للراتب (YER)</label>
                    <input type="number" id="adv-salary-max" placeholder="أدخل الحد الأقصى">
                </div>
                <div class="advanced-modal-field">
                    <label>الشركة</label>
                    <input type="text" id="adv-company" placeholder="اسم الشركة (اختياري)">
                </div>
            </div>
            <div class="advanced-modal-actions">
                <button style="background: var(--primary); color: white;" class="search-btn" onclick="performAdvancedSearch()">
                    <i class="fas fa-search"></i> بحث
                </button>
                <button style="background: transparent; border: 2px solid var(--primary); color: var(--primary);" onclick="closeAdvancedSearch()">إغلاق</button>
            </div>
        </div>
    </div>

    <div id="footer-container"></div>

    <div id="notification" class="notification hidden"></div>

    <script src="js/app.js"></script>
    <script src="js/mock-jobs.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('js/service-worker.js').catch(err => console.log('SW registration failed'));
        }

        function performSearch() {
            const job = document.getElementById('search-job').value;
            const location = document.getElementById('search-location').value;
            const type = document.getElementById('search-type').value;

            let url = 'pages/jobs.php?';
            if (job) url += 'search=' + encodeURIComponent(job) + '&';
            if (location) url += 'location=' + encodeURIComponent(location) + '&';
            if (type) url += 'type=' + encodeURIComponent(type) + '&';

            window.location.href = url;
        }

        function openAdvancedSearch() {
            document.getElementById('advancedModal').classList.add('active');
        }

        function closeAdvancedSearch() {
            document.getElementById('advancedModal').classList.remove('active');
        }

        function performAdvancedSearch() {
            const job = document.getElementById('adv-job').value;
            const location = document.getElementById('adv-location').value;
            const type = document.getElementById('adv-type').value;

            let url = 'pages/jobs.php?';
            if (job) url += 'search=' + encodeURIComponent(job) + '&';
            if (location) url += 'location=' + encodeURIComponent(location) + '&';
            if (type) url += 'type=' + encodeURIComponent(type) + '&';

            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadLatestJobs();
            loadStatistics();
        });

        function loadLatestJobs() {
            setTimeout(() => {
                const data = getMockJobs({}, 1, 4);
                if (data.status === 'success' && data.data.length > 0) {
                    const container = document.getElementById('latest-jobs');
                    container.innerHTML = '';
                    data.data.forEach((job, index) => {
                        const card = document.createElement('div');
                        card.className = 'latest-job-card';
                        card.style.animationDelay = (index * 0.1) + 's';
                        
                        const applicantsCount = Math.floor(Math.random() * 50) + 5;

                        card.innerHTML = `
                            <div class="job-card-title">${job.job_title_ar}</div>
                            <div class="job-card-company">
                                <i class="fas fa-building"></i> ${job.company_name}
                            </div>
                            <div class="job-card-meta">
                                <span class="job-card-badge"><i class="fas fa-clock"></i> ${job.job_type === 'full_time' ? 'دوام كامل' : job.job_type === 'part_time' ? 'دوام جزئي' : job.job_type === 'freelance' ? 'عمل حر' : 'عقد محدد'}</span>
                                <span class="job-card-badge"><i class="fas fa-map-marker-alt"></i> ${job.location_city}</span>
                            </div>
                            <div class="job-card-desc">${job.job_description_ar.substring(0, 120)}...</div>
                            <div class="job-card-footer">
                                <div style="display: flex; align-items: center; gap: 5px; color: #6b7280; font-size: 0.9em;">
                                    <i class="fas fa-users"></i> ${applicantsCount} متقدم
                                </div>
                                <a href="pages/job-details.php?id=${job.id}" class="job-card-btn">
                                    <i class="fas fa-arrow-left"></i> التفاصيل
                                </a>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                }
            }, 300);
        }

        function loadStatistics() {
            const stats = {
                users: Math.floor(Math.random() * 50000) + 5000,
                jobs: 20,
                companies: 15,
                applications: Math.floor(Math.random() * 10000) + 1000
            };

            document.getElementById('stat-users').textContent = stats.users.toLocaleString('ar-SA');
            document.getElementById('stat-jobs').textContent = stats.jobs;
            document.getElementById('stat-companies').textContent = stats.companies;
            document.getElementById('stat-applications').textContent = stats.applications.toLocaleString('ar-SA');
        }

        document.getElementById('advancedModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    </script>
    
    <div id="footer-container"></div>
    
    <script src="js/theme.js"></script>
    <script src="js/navbar-footer-loader.js"></script>
</body>
</html>