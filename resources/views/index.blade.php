<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRFlow - HR Management System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' stroke='%23D4AF37' stroke-width='2.5' fill='%23152A45'/%3E%3Cpath d='M11 18L15 22L25 13' stroke='%23D4AF37' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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

.hero-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--primary-light), var(--primary), var(--primary-dark));
    background-size: 300% 300%;
    position: relative;
    overflow: hidden;
    padding: 120px 30px 80px;
    animation: sheen 10s ease-in-out infinite;
}

@keyframes sheen {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

[data-theme="light"] .hero-section {
    background: linear-gradient(135deg, #1E3A5F, #2D4A6F, #4A6A8F, #2D4A6F, #1E3A5F);
}

.hero-container {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.hero-content { max-width: 600px; }

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    color: var(--accent);
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 24px;
    border: 1px solid var(--accent);
}

.hero-title {
    font-size: clamp(3rem, 5vw, 4.5rem);
    font-weight: 900;
    line-height: 1.1;
    color: white;
    margin-bottom: 16px;
    letter-spacing: -2px;
}

.hero-subtitle {
    font-size: clamp(1.25rem, 2vw, 1.75rem);
    font-weight: 700;
    color: var(--accent);
    margin-bottom: 24px;
}

.hero-description {
    font-size: 1.125rem;
    color: rgba(255,255,255,0.85);
    line-height: 1.8;
    margin-bottom: 32px;
    max-width: 500px;
}

.hero-pillars {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 40px;
}

.pillar {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-radius: var(--radius);
    border: 1px solid var(--accent);
    transition: var(--transition);
}

.pillar:hover {
    transform: translateX(8px);
    background: rgba(212,175,55,0.2);
}

.pillar-icon {
    width: 48px;
    height: 48px;
    background: var(--accent);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-dark);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.pillar-text h4 {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    margin-bottom: 2px;
}

.pillar-text p {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.7);
}

.hero-actions {
    display: flex;
    gap: 16px;
    margin-top: 32px;
    flex-wrap: wrap;
}

.btn-outline {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-outline:hover {
    background: white;
    color: var(--primary-dark);
    transform: translateY(-2px);
}

.hero-avatar {
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-container {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, rgba(21, 42, 69, 0.8), rgba(30, 58, 95, 0.6));
    border-radius: 50%;
    padding: 15px;
    border: 4px solid transparent;
    background-clip: padding-box;
    position: relative;
    box-shadow: 0 0 40px rgba(212, 175, 55, 0.3);
    transition: var(--transition);
}

.avatar-container::before {
    content: '';
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    background: linear-gradient(135deg, var(--accent), var(--accent-dark), var(--accent));
    border-radius: 50%;
    z-index: -1;
    opacity: 0.8;
}

.hero-avatar:hover .avatar-container {
    transform: scale(1.08);
    box-shadow: 0 0 60px rgba(212, 175, 55, 0.6);
}

.hr-avatar-svg { width: 100%; height: 100%; }

.section-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 30px;
}

.section-title {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 15px;
    text-align: center;
}

[data-theme="light"] .section-title { color: var(--primary); }

.section-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    text-align: center;
    margin-bottom: 50px;
}

.roles-section {
    padding: 100px 30px;
    background: var(--roles-bg);
}

.role-tabs {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 50px;
    flex-wrap: wrap;
}

.role-tab {
    background: var(--card-bg);
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 15px 30px;
    border-radius: var(--radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
}

.role-tab:hover, .role-tab[aria-selected="true"] {
    background: var(--primary);
    color: white;
}

.role-panel {
    display: none;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    animation: slideIn 0.5s ease;
}

.role-panel.active { display: grid; }

@keyframes slideIn {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

.panel-text h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 15px;
}

.panel-text > p {
    color: var(--text-secondary);
    margin-bottom: 30px;
}

.feature-list { list-style: none; }

.feature-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    font-weight: 500;
    color: var(--text-primary);
}

.feature-list i { color: var(--accent); font-size: 1.25rem; }

.panel-visual { display: flex; justify-content: center; }

.visual-card {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 60px;
    border-radius: var(--radius-lg);
    text-align: center;
    box-shadow: var(--shadow-lg);
    border: 2px solid var(--accent);
}

.visual-icon { font-size: 4rem; margin-bottom: 20px; }

.features-section {
    padding: 100px 30px;
    background: var(--features-bg);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

.feature-card {
    background: var(--card-bg);
    padding: 35px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: var(--transition);
    border-bottom: 3px solid transparent;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
    border-bottom-color: var(--accent);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: rgba(212,175,55,0.15);
    color: var(--accent-dark);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 20px;
    border: 1px solid var(--accent);
}

.feature-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 10px;
}

[data-theme="light"] .feature-card h3 { color: var(--primary); }

.feature-card p {
    color: var(--text-secondary);
    font-size: 0.9375rem;
}

.stats-section {
    padding: 80px 30px;
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: var(--primary-dark);
}

[data-theme="light"] .stats-section {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    text-align: center;
}

.stat-item { color: inherit; }

.stat-number {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 800;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 1.125rem;
    opacity: 0.9;
}

.footer {
    background: var(--navbar-bg);
    color: var(--text-primary);
    padding: 40px 30px;
    border-top: 3px solid var(--accent);
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--accent);
}

.footer > .section-container > .footer-content > p {
    width: 100%;
    text-align: center;
    margin-top: 20px;
    color: var(--text-secondary);
    font-size: 0.875rem;
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

.toast-message {
    flex: 1;
    font-size: 0.9375rem;
    color: var(--text-primary);
}

.toast-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 4px;
    font-size: 0.875rem;
}

.toast-close:hover { color: var(--text-primary); }

.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width: 1100px) {
    .hero-container {
        grid-template-columns: 1fr;
        gap: 60px;
        text-align: center;
    }
    .hero-content { max-width: 100%; }
    .hero-description { margin: 0 auto 32px; }
    .hero-pillars { align-items: center; }
    .pillar { max-width: 400px; }
    .hero-actions { justify-content: center; }
    .theme-toggle { top: auto; bottom: 20px; }
}

@media (max-width: 968px) {
    .nav-menu {
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        background: var(--navbar-bg);
        flex-direction: column;
        padding: 30px;
        gap: 20px;
        box-shadow: var(--shadow-lg);
        transform: translateY(-120%);
        transition: transform var(--transition);
        border-top: 2px solid var(--accent);
    }
    .nav-menu.active { transform: translateY(0); }
    .nav-link { color: var(--text-primary); }
    .mobile-menu-toggle { display: block; }
    .role-panel { grid-template-columns: 1fr; text-align: center; }
    .feature-list li { justify-content: center; }
}

@media (max-width: 640px) {
    .hero-section { padding: 100px 20px 60px; }
    .hero-title { font-size: 2.5rem; }
    .hero-actions { flex-direction: column; }
    .hero-actions .btn { width: 100%; }
    .pillar { flex-direction: column; text-align: center; }
    .avatar-container { width: 200px; height: 200px; }
    .role-tabs { flex-direction: column; align-items: center; }
    .role-tab { width: 100%; max-width: 280px; justify-content: center; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .footer-content { flex-direction: column; text-align: center; }
    .toast { left: 20px; right: 20px; bottom: 20px; }
}
    </style>
</head>
<body>
    <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle theme">
        <i class="fas fa-moon" aria-hidden="true"></i>
    </button>
    
    <nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
        <div class="nav-container">
            <a href="#hero" class="nav-logo" aria-label="HRFlow Home">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                    <circle cx="18" cy="18" r='16' stroke='#D4AF37' stroke-width='2.5' fill='#152A45'/>
                    <path d='M11 18L15 22L25 13' stroke='#D4AF37' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                </svg>
                <span>HRFlow</span>
            </a>
            <ul class="nav-menu" id="navMenu" role="menubar">
                <li role="none"><a href="#hero" class="nav-link" role="menuitem">Home</a></li>
                <li role="none"><a href="#features" class="nav-link" role="menuitem">Features</a></li>
                <li role="none"><a href="#roles" class="nav-link" role="menuitem">Solutions</a></li>
                <li role="none"><a href="#stats" class="nav-link" role="menuitem">About</a></li>
                <li role="none"><a href="{{ route('login') }}" class="btn btn-nav" role="menuitem">Login</a></li>
            </ul>
            <button id="mobileMenuToggle" class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="navMenu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </nav>
    
    <main id="main-content">
        <section id="hero" class="hero-section" aria-labelledby="hero-title">
            <div class="hero-container">
                <div class="hero-content">
                    <span class="hero-badge animate-item">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        Secure HR Platform
                    </span>
                    
                    <h1 id="hero-title" class="hero-title animate-item">
                        HR Management<br>System
                    </h1>
                    
                    <p class="hero-subtitle animate-item">
                        Finally Simple. Totally Secure.
                    </p>
                    
                    <p class="hero-description animate-item">
                        Stop drowning in manual admin. Centralize, automate, and secure your entire HR workflow in one powerful platform.
                    </p>
                    
                    <div class="hero-pillars animate-item">
                        <div class="pillar">
                            <div class="pillar-icon"><i class="fas fa-money-bill-wave" aria-hidden="true"></i></div>
                            <div class="pillar-text">
                                <h4>Automated Payroll & Leave</h4>
                                <p>Smart calculations, zero errors</p>
                            </div>
                        </div>
                        <div class="pillar">
                            <div class="pillar-icon"><i class="fas fa-server" aria-hidden="true"></i></div>
                            <div class="pillar-text">
                                <h4>Centralized Database</h4>
                                <p>All employee data in one place</p>
                            </div>
                        </div>
                        <div class="pillar">
                            <div class="pillar-icon"><i class="fas fa-chart-line" aria-hidden="true"></i></div>
                            <div class="pillar-text">
                                <h4>Performance Tracking</h4>
                                <p>Data-driven insights & reporting</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hero-actions animate-item">
                        <a href="#roles" class="btn btn-primary">
                            <i class="fas fa-play-circle" aria-hidden="true"></i>
                            Learn More
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                            Login
                        </a>
                    </div>
                </div>
                
                <div class="hero-avatar">
                    <div class="avatar-container">
                        <svg class="hr-avatar-svg" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="circleBg" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#152A45"/>
                                    <stop offset="100%" style="stop-color:#1E3A5F"/>
                                </linearGradient>
                                <linearGradient id="goldFill" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#D4AF37"/>
                                    <stop offset="50%" style="stop-color:#E6C65C"/>
                                    <stop offset="100%" style="stop-color:#D4AF37"/>
                                </linearGradient>
                            </defs>
                            <circle cx="150" cy="150" r="145" fill="url(#circleBg)" stroke="url(#goldFill)" stroke-width="4"/>
                            <circle cx="150" cy="150" r="125" fill="none" stroke="#B8942E" stroke-width="2" opacity="0.4"/>
                            <text x="150" y="100" text-anchor="middle" fill="url(#goldFill)" font-size="60" font-weight="bold" font-family="Arial" letter-spacing="5">HR</text>
                            <circle cx="150" cy="145" r="20" fill="none" stroke="url(#goldFill)" stroke-width="3"/>
                            <path d="M150 130 C130 130 115 145 115 165 L115 175 L185 175 L185 165 C185 145 170 130 150 130Z" fill="none" stroke="url(#goldFill)" stroke-width="3"/>
                            <circle cx="150" cy="118" r="15" fill="url(#goldFill)"/>
                            <path d="M150 195 L120 205 L120 230 C120 245 135 255 150 260 C165 255 180 245 180 230 L180 205 Z" fill="none" stroke="url(#goldFill)" stroke-width="3"/>
                            <path d="M142 228 L148 234 L160 220" fill="none" stroke="url(#goldFill)" stroke-width="3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="roles" class="roles-section" aria-labelledby="roles-title">
            <div class="section-container">
                <h2 id="roles-title" class="section-title">A Solution for Everyone</h2>
                
                <div class="role-tabs" role="tablist">
                    <button class="role-tab active" role="tab" aria-selected="true" data-role="employee" id="tab-employee" tabindex="0">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <span>Employee</span>
                    </button>
                    <button class="role-tab" role="tab" aria-selected="false" data-role="hr" id="tab-hr" tabindex="-1">
                        <i class="fas fa-user-tie" aria-hidden="true"></i>
                        <span>HR Manager</span>
                    </button>
                    <button class="role-tab" role="tab" aria-selected="false" data-role="admin" id="tab-admin" tabindex="-1">
                        <i class="fas fa-user-shield" aria-hidden="true"></i>
                        <span>Administrator</span>
                    </button>
                </div>
                
                <div id="roleContent">
                    <div class="role-panel active" id="panel-employee" aria-labelledby="tab-employee">
                        <div class="panel-text">
                            <h3>Personal Access</h3>
                            <p>Manage your information and requests easily from your personal workspace.</p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> View your profile and information</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Submit leave requests</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Download your pay slips</li>
                            </ul>
                            <a href="{{ route('login') }}" class="btn btn-secondary mt-4">
                                <i class="fas fa-arrow-right" aria-hidden="true"></i> Login
                            </a>
                        </div>
                        <div class="panel-visual">
                            <div class="visual-card">
                                <div class="visual-icon"><i class="fas fa-user-circle" aria-hidden="true"></i></div>
                                <span>Employee Portal</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="role-panel" id="panel-hr" aria-labelledby="tab-hr" hidden>
                        <div class="panel-text">
                            <h3>Operational HR Management</h3>
                            <p>Efficiently manage your company's human resources with comprehensive tools.</p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Manage employee files</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Approve leave requests</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Process salaries</li>
                            </ul>
                            <a href="{{ route('login') }}" class="btn btn-secondary mt-4">
                                <i class="fas fa-arrow-right" aria-hidden="true"></i> Login
                            </a>
                        </div>
                        <div class="panel-visual">
                            <div class="visual-card">
                                <div class="visual-icon"><i class="fas fa-users-cog" aria-hidden="true"></i></div>
                                <span>HR Dashboard</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="role-panel" id="panel-admin" aria-labelledby="tab-admin" hidden>
                        <div class="panel-text">
                            <h3>System Administration</h3>
                            <p>Monitor and manage the entire platform with full system control.</p>
                            <ul class="feature-list">
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Manage user accounts</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Configure system settings</li>
                                <li><i class="fas fa-check-circle" aria-hidden="true"></i> Database backup</li>
                            </ul>
                            <a href="{{ route('login') }}" class="btn btn-secondary mt-4">
                                <i class="fas fa-arrow-right" aria-hidden="true"></i> Login
                            </a>
                        </div>
                        <div class="panel-visual">
                            <div class="visual-card">
                                <div class="visual-icon"><i class="fas fa-server" aria-hidden="true"></i></div>
                                <span>Admin Console</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="features" class="features-section" aria-labelledby="features-title">
            <div class="section-container">
                <h2 id="features-title" class="section-title">Powerful Features</h2>
                <p class="section-subtitle">Everything you need to manage your workforce efficiently</p>
                
                <div class="features-grid">
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-wallet" aria-hidden="true"></i></div>
                        <h3>Payroll Management</h3>
                        <p>Automated salary calculations and payments with tax compliance.</p>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-clock" aria-hidden="true"></i></div>
                        <h3>Leave Management</h3>
                        <p>Track attendance, leave requests, and balances effortlessly.</p>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                        <h3>Employee Records</h3>
                        <p>Centralized database for all employee information.</p>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-chart-pie" aria-hidden="true"></i></div>
                        <h3>Analytics</h3>
                        <p>Data-driven insights for better HR decision making.</p>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-shield-alt" aria-hidden="true"></i></div>
                        <h3>Security</h3>
                        <p>Enterprise-grade security to protect your sensitive data.</p>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><i class="fas fa-file-pdf" aria-hidden="true"></i></div>
                        <h3>Reports & PDF</h3>
                        <p>Generate reports and export payslips as PDF.</p>
                    </article>
                </div>
            </div>
        </section>
        
        <section id="stats" class="stats-section" aria-labelledby="stats-title">
            <div class="section-container">
                <div class="stats-grid">
                    <div class="stat-item reveal">
                        <div class="stat-number" data-target="50">50</div>
                        <div class="stat-label">Companies</div>
                    </div>
                    <div class="stat-item reveal">
                        <div class="stat-number" data-target="1000">1000</div>
                        <div class="stat-label">Employees</div>
                    </div>
                    <div class="stat-item reveal">
                        <div class="stat-number" data-target="99" data-suffix="%">99%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                    <div class="stat-item reveal">
                        <div class="stat-number" data-target="24" data-suffix="/7">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="footer" role="contentinfo">
        <div class="section-container">
            <div class="footer-content">
                <div class="footer-brand">
                    <svg width="32" height="32" viewBox="0 0 36 36" fill="none">
                        <circle cx="18" cy="18" r='16' stroke='#D4AF37' stroke-width='2.5' fill='#152A45'/>
                        <path d='M11 18L15 22L25 13' stroke='#D4AF37' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'/>
                    </svg>
                    <span>HRFlow</span>
                </div>
                <p>&copy; <span id="year"></span> HRFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-hidden="true">
        <i class="toast-icon fas" aria-hidden="true"></i>
        <span class="toast-message"></span>
        <button class="toast-close" aria-label="Close notification">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>
    
    <script>
    (function() {
        'use strict';
        
        const $ = (sel, ctx = document) => ctx.querySelector(sel);
        const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];
        
        document.addEventListener('DOMContentLoaded', init);
        
        function init() {
            const yearEl = $('#year');
            if (yearEl) yearEl.textContent = new Date().getFullYear();
            
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
