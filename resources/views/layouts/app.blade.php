<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRFlow')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #1E3A5F;
            --primary-dark: #152A45;
            --primary-light: #2D4A6F;
            --accent: #D4AF37;
            --accent-dark: #B8942E;
            --accent-light: #E6C65C;
            --bg-main: #0F172A;
            --card-bg: #1E293B;
            --text-primary: #FFFFFF;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --border-color: rgba(212, 175, 55, 0.3);
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

        [data-theme="light"] {
            --bg-main: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.1);
            --input-bg: #F8FAFC;
            --input-text: #1E293B;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font);
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .app-container { display: flex; min-height: 100vh; }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            border-right: 2px solid var(--accent);
            z-index: 100;
        }

        .logo { padding: 0 24px 32px; border-bottom: 1px solid var(--border-color); margin-bottom: 24px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; color: var(--accent); }
        .logo span { font-size: 0.75rem; color: var(--text-secondary); }

        .nav-menu { list-style: none; padding: 0 12px; }
        .nav-item { margin-bottom: 4px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
            border: 1px solid transparent;
            min-height: 48px;
        }
        .nav-link svg { width: 20px; height: 20px; flex-shrink: 0; }
        .nav-link:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .nav-link.active {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: var(--primary-dark);
            font-weight: 600;
            box-shadow: var(--shadow-gold);
        }

        .sidebar-footer { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-color); }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 16px;
            padding: 12px 20px;
            background: rgba(220, 38, 38, 0.15);
            border: 2px solid var(--error);
            border-radius: var(--radius-sm);
            color: var(--error);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            cursor: pointer;
        }
        .btn-logout:hover {
            background: var(--error);
            color: white;
            transform: translateY(-2px);
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 32px;
            min-height: 100vh;
        }

        .page-header { margin-bottom: 32px; }
        .page-header h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--accent);
        }
        .page-header p { color: var(--text-secondary); font-size: 0.9rem; }

        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--border-color);
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-title svg { width: 20px; height: 20px; color: var(--accent); }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon.blue { background: rgba(59, 130, 246, 0.15); color: #3B82F6; }
        .stat-icon.green { background: rgba(16, 185, 129, 0.15); color: #10B981; }
        .stat-icon.orange { background: rgba(245, 158, 11, 0.15); color: #F59E0B; }
        .stat-icon.purple { background: rgba(139, 92, 246, 0.15); color: #8B5CF6; }
        .stat-icon svg { width: 28px; height: 28px; }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .stat-info p { color: var(--text-secondary); font-size: 0.875rem; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
            gap: 4px;
        }

        .btn-xs {
            padding: 4px 8px;
            font-size: 0.7rem;
            gap: 3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: var(--primary-dark);
            box-shadow: var(--shadow-gold);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
        }
        .btn-secondary:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .btn-danger {
            background: rgba(220, 38, 38, 0.15);
            color: var(--error);
            border: 2px solid var(--error);
        }

        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid var(--border-color); }
        th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--accent);
            background: rgba(255, 255, 255, 0.03);
        }
        td { font-size: 0.9rem; color: var(--text-secondary); }
        tr:hover td { background: rgba(255, 255, 255, 0.03); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success { background: rgba(16, 185, 129, 0.15); color: var(--success); }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
        .badge-error { background: rgba(220, 38, 38, 0.15); color: var(--error); }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-secondary);
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            color: var(--input-text);
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        select.form-control {
            color: var(--input-text);
            background: var(--input-bg);
        }
        select.form-control option { background: var(--card-bg); color: var(--text-primary); }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 48px;
            height: 48px;
            background: var(--card-bg);
            border: 2px solid var(--accent);
            border-radius: var(--radius-sm);
            color: var(--accent);
            font-size: 1.25rem;
            cursor: pointer;
            z-index: 1000;
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

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--card-bg);
            padding: 16px 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateY(100px);
            opacity: 0;
            transition: var(--transition);
            z-index: 9999;
            border-left: 4px solid var(--accent);
        }

        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.success { border-left-color: var(--success); }
        .toast.error { border-left-color: var(--error); }

        .toast-icon { font-size: 1.25rem; }
        .toast.success .toast-icon { color: var(--success); }
        .toast.error .toast-icon { color: var(--error); }

        .toast-message { flex: 1; font-size: 0.9375rem; }

        @media (max-width: 1024px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; padding: 20px; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; }
            .stat-card { padding: 18px; }
            .stat-info h3 { font-size: 1.5rem; }
            .card { padding: 20px; }
            th, td { padding: 10px 12px; font-size: 0.85rem; }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 56px;
                flex-direction: row;
                padding: 0 12px;
                z-index: 1000;
                overflow-x: auto;
                overflow-y: hidden;
                border-right: none;
                border-bottom: 2px solid var(--accent);
                -webkit-overflow-scrolling: touch;
            }
            .logo { padding: 0; margin-bottom: 0; border-bottom: none; display: none; }
            .nav-menu { display: flex; padding: 0; flex-wrap: nowrap; gap: 2px; }
            .nav-item { margin-bottom: 0; flex-shrink: 0; }
            .nav-link { padding: 8px 10px; font-size: 0.75rem; white-space: nowrap; border-radius: 8px; min-height: 44px; display: flex; align-items: center; justify-content: center; }
            .nav-link span { display: none; }
            .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }
            .sidebar-footer { display: none; }
            .btn-logout { margin: 0; padding: 8px 12px; font-size: 0.75rem; }
            .btn-logout span { display: none; }
            .main-content { margin-left: 0; margin-top: 56px; padding: 14px; }
            .page-header { margin-bottom: 16px; }
            .page-header h2 { font-size: 1.3rem; }
            .page-header p { font-size: 0.8rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .stat-card { padding: 14px; gap: 10px; flex-direction: row; align-items: center; }
            .stat-icon { width: 42px; height: 42px; }
            .stat-icon svg { width: 20px; height: 20px; }
            .stat-info h3 { font-size: 1.3rem; }
            .stat-info p { font-size: 0.75rem; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .card { padding: 14px; margin-bottom: 14px; border-radius: 10px; }
            .card-header { flex-direction: column; gap: 10px; align-items: flex-start; }
            .card-title { font-size: 0.95rem; }
            .card-title svg { width: 16px; height: 16px; }
            .btn { padding: 8px 14px; font-size: 0.8rem; }
            .btn-sm { padding: 5px 10px; font-size: 0.7rem; }
            .btn-xs { padding: 4px 8px; font-size: 0.65rem; }
            .form-group { margin-bottom: 14px; }
            .form-group label { font-size: 0.8rem; margin-bottom: 6px; }
            .form-control { padding: 10px 12px; font-size: 0.85rem; }
            table { display: block; width: 100%; min-width: 500px; }
            table th, table td { padding: 8px 10px; font-size: 0.8rem; white-space: nowrap; }
            .toast { left: 12px; right: 12px; bottom: 12px; padding: 12px 16px; }
            .toast-message { font-size: 0.85rem; }
            .theme-toggle { top: 10px; right: 12px; width: 40px; height: 40px; font-size: 1rem; }
        }

        @media (max-width: 480px) {
            .sidebar { height: 50px; padding: 0 8px; }
            .nav-link { padding: 6px 8px; min-height: 38px; }
            .nav-link svg { width: 16px; height: 16px; }
            .main-content { margin-top: 50px; padding: 10px; }
            .page-header { margin-bottom: 12px; }
            .page-header h2 { font-size: 1.15rem; }
            .page-header p { font-size: 0.75rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .stat-card { padding: 10px; gap: 8px; flex-direction: column; text-align: center; }
            .stat-icon { width: 36px; height: 36px; }
            .stat-icon svg { width: 16px; height: 16px; }
            .stat-info h3 { font-size: 1.1rem; }
            .stat-info p { font-size: 0.7rem; }
            .card { padding: 10px; margin-bottom: 10px; border-radius: 8px; }
            .card-title { font-size: 0.85rem; }
            .btn { padding: 7px 12px; font-size: 0.75rem; gap: 4px; }
            .btn-sm { padding: 4px 8px; font-size: 0.65rem; }
            .btn-xs { padding: 3px 6px; font-size: 0.6rem; }
            .form-control { padding: 8px 10px; font-size: 0.8rem; border-radius: 6px; }
        }

        @media (max-width: 360px) {
            .sidebar { height: 46px; padding: 0 6px; }
            .nav-link { padding: 5px 6px; min-height: 34px; }
            .nav-link svg { width: 14px; height: 14px; }
            .main-content { margin-top: 46px; padding: 8px; }
            .page-header h2 { font-size: 1rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 6px; }
            .stat-card { padding: 8px; }
            .stat-icon { width: 30px; height: 30px; }
            .stat-icon svg { width: 14px; height: 14px; }
            .stat-info h3 { font-size: 1rem; }
            .stat-info p { font-size: 0.65rem; }
            .card { padding: 8px; }
            .card-title { font-size: 0.8rem; }
            .btn { padding: 6px 10px; font-size: 0.7rem; }
            .btn-sm { padding: 3px 6px; font-size: 0.6rem; }
            .btn-xs { padding: 2px 5px; font-size: 0.55rem; }
            .form-control { padding: 7px 8px; font-size: 0.75rem; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle theme">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button>

    <div class="app-container">
        <nav class="sidebar">
            <div class="logo">
                <h1>HR Portal</h1>
                <span>@yield('role', 'Dashboard')</span>
            </div>
            <ul class="nav-menu">
                @yield('menu')
            </ul>
            <div class="sidebar-footer">
                <a href="{{ route('logout') }}" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </a>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @if(session('success'))
    <div class="toast show success">
        <span class="toast-icon">✓</span>
        <span class="toast-message">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="toast show error">
        <span class="toast-icon">✕</span>
        <span class="toast-message">{{ session('error') }}</span>
    </div>
    @endif

    <script>
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            const icon = document.querySelector('#themeToggle i');
            if (icon) icon.className = theme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
        }

        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            const savedTheme = localStorage.getItem('hrflow-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const currentTheme = savedTheme || (prefersDark ? 'dark' : 'light');
            applyTheme(currentTheme);
            toggle.addEventListener('click', function() {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                const newTheme = isDark ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('hrflow-theme', newTheme);
            });
        }
        
        document.querySelectorAll('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href) {
                const linkPath = new URL(href, window.location.origin).pathname;
                if (linkPath === window.location.pathname) {
                    link.classList.add('active');
                }
            }
        });
        
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(toast => {
                toast.classList.remove('show');
            });
        }, 4000);
    </script>
    @yield('scripts')
</body>
</html>
