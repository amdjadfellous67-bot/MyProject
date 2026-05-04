<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HRFlow</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' stroke='%23D4AF37' stroke-width='2.5' fill='%23152A45'/%3E%3Cpath d='M11 18L15 22L25 13' stroke='%23D4AF37' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
    :root {
        --primary: #1E3A5F;
        --primary-dark: #152A45;
        --primary-light: #2D4A6F;
        --accent: #D4AF37;
        --accent-dark: #B8942E;
        --accent-light: #E6C65C;
        --bg-light: #F1F5F9;
        --bg-white: #FFFFFF;
        --text-dark: #1E3A5F;
        --text-muted: #5A6B7D;
        --text-light: #94A3B8;
        --success: #10B981;
        --error: #DC2626;
        --warning: #F59E0B;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
        --shadow-gold: 0 4px 20px rgba(212, 175, 55, 0.3);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-lg: 20px;
        --transition: 0.3s ease;
        --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    :root, [data-theme="dark"] {
        --bg-main: #0F172A;
        --card-bg: #1E293B;
        --text-primary: #FFFFFF;
        --text-secondary: rgba(255, 255, 255, 0.8);
        --border-color: rgba(212, 175, 55, 0.3);
        --navbar-bg: #152A45;
        --roles-bg: #0F172A;
        --features-bg: #152A45;
    }

    [data-theme="light"] {
        --bg-main: #F8FAFC;
        --card-bg: #FFFFFF;
        --text-primary: #1E293B;
        --text-secondary: #64748B;
        --border-color: #E2E8F0;
        --navbar-bg: #1E3A5F;
        --roles-bg: #F1F5F9;
        --features-bg: #F8FAFC;
    }

    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html { scroll-behavior: smooth; }

    body {
        font-family: var(--font);
        background: var(--bg-main);
        color: var(--text-primary);
        line-height: 1.6;
        overflow-x: hidden;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .skip-link {
        position: absolute;
        top: -100%;
        left: 50%;
        transform: translateX(-50%);
        background: var(--accent);
        color: var(--primary-dark);
        padding: 12px 24px;
        border-radius: var(--radius);
        font-weight: 600;
        z-index: 9999;
        transition: top 0.3s;
        text-decoration: none;
    }

    .skip-link:focus { top: 10px; }

    :focus-visible {
        outline: 3px solid var(--accent);
        outline-offset: 2px;
    }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg-main); }
    ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--accent-dark); }

    .theme-toggle {
        position: fixed;
        top: 80px;
        right: 20px;
        width: 48px;
        height: 48px;
        background: var(--card-bg);
        border: 2px solid var(--accent);
        border-radius: var(--radius-sm);
        color: var(--accent);
        font-size: 1.25rem;
        cursor: pointer;
        z-index: 1001;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .theme-toggle:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: rotate(15deg);
    }

    .btn {
        padding: 14px 28px;
        border-radius: var(--radius);
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        touch-action: manipulation;
    }

    .btn-primary {
        background: var(--accent);
        color: var(--primary-dark);
        border-color: var(--accent);
    }

    .btn-primary:hover {
        background: var(--accent-dark);
        border-color: var(--accent-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-gold);
    }

    .btn-secondary {
        background: transparent;
        color: var(--accent);
        border-color: var(--accent);
    }

    .btn-secondary:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-nav {
        background: var(--accent);
        color: var(--primary-dark) !important;
        padding: 10px 20px;
    }

    .btn-nav:hover { background: var(--accent-dark); }

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: var(--navbar-bg);
        padding: 15px 30px;
        z-index: 1000;
        box-shadow: var(--shadow);
        border-bottom: 2px solid var(--accent);
        transition: var(--transition);
    }

    .nav-container {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent);
        text-decoration: none;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 30px;
        list-style: none;
    }

    .nav-link {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        font-weight: 500;
        padding: 8px 0;
        position: relative;
        transition: var(--transition);
    }

    .nav-link:hover, .nav-link:focus { color: var(--accent); }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent);
        transition: var(--transition);
    }

    .nav-link:hover::after { width: 100%; }

    .mobile-menu-toggle {
        display: none;
        background: none;
        border: 2px solid var(--accent);
        color: var(--accent);
        padding: 8px 12px;
        border-radius: var(--radius-sm);
        font-size: 1.25rem;
        cursor: pointer;
    }

    .login-page-wrapper {
        width: 100%;
        max-width: 750px;
        height: auto;
        max-height: 90vh;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 2px solid var(--accent);
        box-shadow: var(--shadow-lg), 0 0 60px rgba(212, 175, 55, 0.15);
        animation: fadeIn 0.8s ease;
        display: flex;
        margin: auto;
        background: var(--card-bg);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-left {
        width: 320px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 35px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 60px; height: 100%;
        background: linear-gradient(to left, rgba(212, 175, 55, 0.15), transparent);
        clip-path: ellipse(80% 100% at 100% 50%);
    }

    .login-left::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0;
        width: 100px; height: 60px;
        background: linear-gradient(to top left, rgba(212, 175, 55, 0.1), transparent);
        border-radius: 50% 0 0 0;
    }

    .float-icon {
        position: absolute;
        color: rgba(212, 175, 55, 0.15);
        animation: floatIcon 6s ease-in-out infinite;
    }

    .float-icon:nth-child(1) { top: 6%; left: 8%; font-size: 1.5rem; }
    .float-icon:nth-child(2) { top: 18%; right: 12%; font-size: 1.2rem; animation-delay: 1s; }
    .float-icon:nth-child(3) { bottom: 22%; left: 6%; font-size: 1.4rem; animation-delay: 2s; }
    .float-icon:nth-child(4) { bottom: 12%; right: 8%; font-size: 1.8rem; animation-delay: 0.5s; }
    .float-icon:nth-child(5) { top: 45%; left: 4%; font-size: 1rem; animation-delay: 1.5s; }

    @keyframes floatIcon {
        0%, 100% { transform: translate(0, 0); }
        25% { transform: translate(6px, -10px); }
        50% { transform: translate(-4px, 6px); }
        75% { transform: translate(10px, 4px); }
    }

    .left-content { position: relative; z-index: 1; text-align: center; max-width: 260px; }

    .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }

    .logo-icon {
        width: 42px; height: 42px;
        background: rgba(212, 175, 55, 0.2);
        border: 2px solid rgba(212, 175, 55, 0.4);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    .logo-icon svg { width: 24px; height: 24px; }

    .logo span { font-size: 1.75rem; font-weight: 800; color: var(--accent); letter-spacing: -1px; }

    .tagline { font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 24px; }

    .welcome-text h2 { font-size: 1.375rem; font-weight: 700; color: white; margin-bottom: 10px; }
    .welcome-text p { font-size: 0.875rem; color: rgba(255, 255, 255, 0.9); margin-bottom: 28px; }

    .btn-login, .modal .btn-submit {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: var(--primary-dark);
        border: none; border-radius: var(--radius);
        font-size: 0.95rem; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.3s;
        box-shadow: var(--shadow-gold);
    }

    .btn-login:hover, .modal .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4); }

    .btn-outline { background: transparent !important; border: 2px solid var(--accent) !important; color: var(--accent) !important; box-shadow: none !important; margin-top: 8px; }
    .btn-outline:hover { background: rgba(212, 175, 55, 0.1) !important; }

    .login-right {
        flex: 1; background: var(--card-bg); padding: 30px 35px;
        display: flex; flex-direction: column; justify-content: center;
        transition: background 0.3s ease;
    }

    .login-header { text-align: center; margin-bottom: 28px; }
    .login-header h1 { font-size: 1.75rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
    .login-header p { font-size: 0.9rem; color: var(--text-secondary); }

    .form-group { margin-bottom: 18px; }

    .form-group label {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.875rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;
    }

    .form-group label i { color: var(--accent); width: 16px; }

    .form-group input {
        width: 100%; padding: 13px 15px;
        border: 2px solid var(--border-color); border-radius: var(--radius-sm);
        font-size: 15px; background: var(--input-bg); color: var(--input-text);
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none; border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    }

    .form-group input::placeholder { color: var(--input-placeholder); opacity: 1; }

    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 40px; }

    .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); cursor: pointer; }
    .toggle-password:hover { color: var(--accent); }

    .form-options { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
    .forgot-link { font-size: 0.875rem; color: var(--accent); text-decoration: none; cursor: pointer; font-weight: 500; }
    .forgot-link:hover { opacity: 0.8; }

    .error-message { display: block; font-size: 0.75rem; color: #EF4444; margin-top: 5px; min-height: 18px; }

    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s;
    }

    .modal-overlay.active { opacity: 1; visibility: visible; }

    .modal {
        background: var(--card-bg); border-radius: 16px; padding: 24px;
        max-width: 360px; width: 92%;
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s;
        box-shadow: var(--shadow-lg);
        position: relative;
    }

    .modal-overlay.active .modal { transform: scale(1) translateY(0); }

    .modal-close { position: absolute; top: 12px; right: 16px; font-size: 1.25rem; color: var(--text-secondary); cursor: pointer; z-index: 10; }
    .modal-close:hover { color: var(--text-primary); }

    .modal-header { text-align: center; margin-bottom: 24px; }
    .modal-header h2 { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; }
    .modal-header p { color: var(--text-secondary); font-size: 0.875rem; }

    .modal-icon.success { font-size: 2rem; color: #10B981; margin-bottom: 8px; }
    .modal-icon.error { font-size: 2rem; color: #ef4444; margin-bottom: 8px; }
    .text-muted { font-size: 0.75rem; margin-top: 6px; color: var(--text-secondary); }

    .code-sent-icon { font-size: 3rem; color: var(--accent); margin-bottom: 15px; }

    .toast {
        position: fixed; bottom: 30px; right: 30px;
        background: var(--card-bg); padding: 16px 20px;
        border-radius: var(--radius); box-shadow: var(--shadow-lg);
        display: flex; align-items: center; gap: 12px;
        transform: translateY(100px); opacity: 0;
        transition: var(--transition); z-index: 9999;
        border-left: 4px solid var(--accent);
    }

    .toast.show { transform: translateY(0); opacity: 1; }
    .toast.success { border-left-color: #10B981; }
    .toast.error { border-left-color: #ef4444; }
    .toast.warning { border-left-color: #F59E0B; }

    .toast-icon { font-size: 1.25rem; }
    .toast.success .toast-icon { color: #10B981; }
    .toast.error .toast-icon { color: #ef4444; }
    .toast.warning .toast-icon { color: #F59E0B; }

    .toast-message { flex: 1; font-size: 0.9375rem; color: var(--text-primary); }
    .toast-close { background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 4px; font-size: 0.875rem; }
    .toast-close:hover { color: var(--text-primary); }

    @media (max-width: 768px) {
        .login-page-wrapper { flex-direction: column; max-width: 450px; max-height: none; }
        .login-left { width: 100%; padding: 30px 25px; }
        .login-left::before { width: 100%; height: 35px; top: auto; bottom: 0; clip-path: ellipse(100% 80% at 50% 100%); }
        .left-content { max-width: 100%; }
        .logo span { font-size: 1.5rem; }
        .welcome-text h2 { font-size: 1.25rem; }
        .login-right { padding: 30px 25px; }
        .login-header h1 { font-size: 1.5rem; }
        .theme-toggle { top: auto; bottom: 20px; }
    }

    @media (max-width: 480px) {
        body { padding: 10px; }
        .login-page-wrapper { border-radius: 12px; max-width: 100%; }
        .login-left { padding: 25px 20px; }
        .login-right { padding: 25px 20px; }
        .login-header { margin-bottom: 20px; }
        .login-header h1 { font-size: 1.35rem; }
        .login-header p { font-size: 0.85rem; }
        .form-group { margin-bottom: 14px; }
        .form-group input { padding: 11px 13px; font-size: 14px; }
        .btn-login { padding: 12px; font-size: 0.9rem; }
        .modal { padding: 20px 16px; max-width: 92%; }
        .modal-header h2 { font-size: 1.25rem; }
        .modal-header p { font-size: 0.8rem; }
        .float-icon { display: none; }
        .toast { left: 12px; right: 12px; bottom: 12px; }
        .code-sent-icon { font-size: 2.5rem; margin-bottom: 10px; }
    }

    @media (max-width: 360px) {
        body { padding: 8px; }
        .login-page-wrapper { border-radius: 10px; }
        .login-left { padding: 20px 16px; }
        .login-right { padding: 20px 16px; }
        .logo span { font-size: 1.3rem; }
        .welcome-text h2 { font-size: 1.1rem; }
        .welcome-text p { font-size: 0.8rem; }
        .login-header h1 { font-size: 1.2rem; }
        .login-header p { font-size: 0.8rem; }
        .form-group input { padding: 10px 12px; font-size: 13px; }
        .btn-login { padding: 10px; font-size: 0.85rem; }
        .theme-toggle { width: 40px; height: 40px; font-size: 1rem; }
    }

    .theme-toggle {
        position: fixed;
        top: 80px;
        right: 20px;
        width: 48px;
        height: 48px;
        background: var(--card-bg);
        border: 2px solid var(--accent);
        border-radius: var(--radius-sm);
        color: var(--accent);
        font-size: 1.25rem;
        cursor: pointer;
        z-index: 1001;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .theme-toggle:hover {
        background: var(--accent);
        color: var(--primary-dark);
        transform: rotate(15deg);
    }
    </style>
</head>
<body>
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-hidden="true">
        <i class="toast-icon fas" aria-hidden="true"></i>
        <span class="toast-message"></span>
        <button class="toast-close" aria-label="Close notification">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>

    <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle theme">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button>

    <div class="login-page-wrapper">
        <div class="login-left">
            <i class="fas fa-users float-icon"></i>
            <i class="fas fa-chart-line float-icon"></i>
            <i class="fas fa-calendar-check float-icon"></i>
            <i class="fas fa-hand-holding-usd float-icon"></i>
            <i class="fas fa-clock float-icon"></i>
            <div class="left-content">
                <div class="logo">
                    <div class="logo-icon">
                        <svg viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" stroke="#D4AF37" stroke-width="2.5" fill="#152A45"/>
                            <path d="M11 18L15 22L25 13" stroke="#D4AF37" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span>HRFlow</span>
                </div>
                <p class="tagline">Streamline Your HR Operations</p>
                <div class="welcome-text">
                    <h2>Welcome Back!</h2>
                    <p>Sign in to manage your HR operations.</p>
                </div>
            </div>
        </div>
        <div class="login-right">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
            </div>
            <form id="loginForm" action="{{ route('login.post') }}" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="name@company.com" autocomplete="off">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span id="email-error" class="error-message"></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="new-password">
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @else
                        <span id="password-error" class="error-message"></span>
                    @enderror
                </div>
                <div class="form-options">
                    <span class="forgot-link" id="forgotPasswordLink">Forgot Password?</span>
                </div>
                <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</button>
                <a href="{{ url('/') }}" class="btn-login btn-outline" style="margin-top: 12px;"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="forgotModalOverlay">
        <div class="modal">
            <div class="modal-close" id="closeForgotModal"><i class="fas fa-times"></i></div>
            <div class="modal-content">
                <div id="forgotViewForm">
                    <div class="modal-header">
                        <i class="fas fa-envelope-open-text code-sent-icon"></i>
                        <h2>Forgot Password?</h2>
                        <p>Send a reset request to the admin</p>
                    </div>
                    <form id="forgotForm" novalidate>
                        <div class="form-group">
                            <label for="forgot-email"><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" id="forgot-email" required placeholder="name@company.com">
                            <span id="forgot-email-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="forgot-message"><i class="fas fa-comment"></i> Message</label>
                            <textarea id="forgot-message" rows="3" style="width:100%;padding:12px 14px;border:2px solid var(--border-color);border-radius:var(--radius-sm);font-size:14px;background:var(--input-bg);color:var(--input-text);transition:all 0.3s;resize:vertical;font-family:inherit;" placeholder="Hi Admin, I forgot my password. Could you please reset it?"></textarea>
                        </div>
                        <button type="submit" class="btn-submit" id="forgotSubmitBtn"><i class="fas fa-paper-plane"></i> Send Request</button>
                    </form>
                </div>
                
                <div id="forgotViewSuccess" style="display:none;">
                    <div class="modal-header">
                        <div class="modal-icon success"><i class="fas fa-check-circle"></i></div>
                        <h2>Request Sent!</h2>
                        <p>Your password reset request has been sent to the administrator. Please wait for them to process it.</p>
                    </div>
                    <button type="button" class="btn-submit" id="reloadPageBtn"><i class="fas fa-sign-in-alt"></i> Back to Login</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    @if(session('error'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('error') }}', 'error');
        });
    @endif
    @if(session('success'))
        window.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}', 'success');
        });
    @endif
    </script>

    <script>
    (function() {
        'use strict';

        const $ = (sel, ctx = document) => ctx.querySelector(sel);
        const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

        document.addEventListener('DOMContentLoaded', init);

        function init() {
            initThemeToggle();
            initMobileMenu();
            initSmoothScroll();
            initRoleTabs();
            initScrollReveal();
            initStatsCounter();
            initToastClose();
        }

        function initThemeToggle() {
            const toggle = $('#themeToggle');
            if (!toggle) return;

            const savedTheme = localStorage.getItem('hrflow-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const currentTheme = savedTheme || (prefersDark ? 'dark' : 'light');

            applyTheme(currentTheme);

            toggle.addEventListener('click', () => {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('hrflow-theme', newTheme);
                showToast(`${newTheme === 'dark' ? 'Dark' : 'Light'} mode enabled`, 'success');
            });
        }

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            const icon = $('#themeToggle i');
            if (icon) {
                icon.className = theme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
            }
        }

        function initMobileMenu() {
            const toggle = $('#mobileMenuToggle');
            const menu = $('#navMenu');
            if (!toggle || !menu) return;

            let isOpen = false;

            function closeMenu() {
                isOpen = false;
                menu.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.querySelector('i').className = 'fas fa-bars';
            }

            function openMenu() {
                isOpen = true;
                menu.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.querySelector('i').className = 'fas fa-times';
            }

            toggle.addEventListener('click', () => {
                isOpen ? closeMenu() : openMenu();
            });

            document.addEventListener('click', (e) => {
                if (isOpen && !menu.contains(e.target) && !toggle.contains(e.target)) {
                    closeMenu();
                }
            });
        }

        function initSmoothScroll() {
            $$('.nav-link, .btn[href^="#"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = $(link.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        $('#navMenu')?.classList.remove('active');
                    }
                });
            });
        }

        function initRoleTabs() {
            const tabs = $$('.role-tab');
            const panels = $$('.role-panel');

            if (!tabs.length || !panels.length) return;

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const role = tab.dataset.role;

                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                        t.setAttribute('tabindex', '-1');
                    });
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');
                    tab.setAttribute('tabindex', '0');

                    panels.forEach(panel => {
                        const panelId = panel.id.replace('panel-', '');
                        if (panelId === role) {
                            panel.classList.add('active');
                            panel.hidden = false;
                            panel.removeAttribute('hidden');
                        } else {
                            panel.classList.remove('active');
                            panel.hidden = true;
                            panel.setAttribute('hidden', '');
                        }
                    });
                });
            });
        }

        function initScrollReveal() {
            const revealElements = $$('.reveal');

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                revealElements.forEach(el => el.classList.add('revealed'));
                return;
            }

            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            revealElements.forEach(el => revealObserver.observe(el));
        }

        function initStatsCounter() {
            const statNumbers = $$('.stat-number');
            if (!statNumbers.length) return;

            const observerOptions = { threshold: 0.5 };

            const animateCounter = (element) => {
                const target = parseInt(element.dataset.target, 10);
                const suffix = element.dataset.suffix || '';
                const duration = 2000;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(easeOut * target);

                    element.textContent = current + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = target + suffix;
                    }
                }

                requestAnimationFrame(updateCounter);
            };

            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            statNumbers.forEach(stat => statsObserver.observe(stat));
        }

        function showToast(message, type = 'success') {
            const toast = $('#toast');
            if (!toast) return;

            const icon = toast.querySelector('.toast-icon');
            const msg = toast.querySelector('.toast-message');

            toast.className = 'toast ' + type;
            toast.setAttribute('aria-hidden', 'false');

            if (icon) {
                icon.className = 'toast-icon fas';
                if (type === 'success') icon.classList.add('fa-check-circle');
                else if (type === 'error') icon.classList.add('fa-exclamation-circle');
                else icon.classList.add('fa-info-circle');
            }

            if (msg) msg.textContent = message;

            toast.classList.add('show');

            clearTimeout(toast.hideTimeout);
            toast.hideTimeout = setTimeout(() => {
                toast.classList.remove('show');
                toast.setAttribute('aria-hidden', 'true');
            }, 4000);
        }

        function initToastClose() {
            const closeBtn = $('.toast-close');
            const toast = $('#toast');
            if (!closeBtn || !toast) return;

            closeBtn.addEventListener('click', () => {
                toast.classList.remove('show');
                toast.setAttribute('aria-hidden', 'true');
            });
        }
    })();
    </script>
</body>
</html>
