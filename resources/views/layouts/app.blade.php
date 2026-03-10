<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --sidebar-bg: #0f172a;
            --sidebar-border: #1e293b;
            --sidebar-hover: #1e293b;
            --sidebar-active: #334155;
            --sidebar-text: #94a3b8;
            --sidebar-heading: #475569;
            --accent: #6366f1;
            --accent-soft: rgba(99,102,241,0.12);
            --accent-glow: rgba(99,102,241,0.25);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
            --card: #ffffff;
            --red: #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            margin: 0;
        }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 40;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 4px 0 24px rgba(0,0,0,0.18);
        }

        #sidebar.is-open,
        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0); }
        }

        /* Sidebar logo bar */
        .sidebar-logo {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }

        .logo-mark {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 32px; height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .logo-icon svg { color: white; }

        .logo-text {
            font-size: 15px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.3px;
        }

        .logo-badge {
            font-family: 'Space Mono', monospace;
            font-size: 9px;
            background: var(--accent-soft);
            color: #818cf8;
            border: 1px solid rgba(99,102,241,0.3);
            border-radius: 4px;
            padding: 1px 5px;
            letter-spacing: 0.5px;
        }

        /* Sidebar nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #334155; border-radius: 2px; }

        .nav-section {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--sidebar-heading);
            padding: 0 8px;
            margin: 20px 0 6px;
        }

        .nav-section:first-child { margin-top: 4px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.18s ease;
            position: relative;
            margin-bottom: 2px;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .nav-link.nav-active {
            background: var(--accent-soft);
            color: #a5b4fc;
            border: 1px solid rgba(99,102,241,0.2);
        }

        .nav-link.nav-active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 18px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }

        .nav-link svg {
            width: 16px; height: 16px;
            flex-shrink: 0;
            opacity: 0.7;
            transition: opacity 0.18s;
        }

        .nav-link:hover svg,
        .nav-link.nav-active svg {
            opacity: 1;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-user-info { flex: 1; min-width: 0; }

        .sidebar-user-name {
            font-size: 12px;
            font-weight: 600;
            color: #cbd5e1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 10px;
            color: #475569;
            margin-top: 1px;
        }

        /* ── Overlay ── */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(2px);
            z-index: 35;
        }

        #sidebar-overlay.is-visible { display: block; }

        /* ── Main wrapper ── */
        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        /* ── Topbar ── */
        .topbar {
            height: var(--topbar-height);
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 30;
            flex-shrink: 0;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .hamburger {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .hamburger:hover {
            background: #f1f5f9;
            color: var(--text-primary);
        }

        .page-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        /* Breadcrumb dot separator */
        .topbar-sep {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--border);
            display: none;
        }

        .topbar-right { display: flex; align-items: center; gap: 8px; }

        /* Notification bell */
        .topbar-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-secondary);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.18s ease;
            position: relative;
            text-decoration: none;
        }

        .topbar-btn:hover {
            background: #f8fafc;
            color: var(--text-primary);
            border-color: #cbd5e1;
        }

        .notif-dot {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: #f97316;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* User chip */
        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 40px;
            border: 1px solid var(--border);
            background: var(--card);
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .user-chip:hover { border-color: #cbd5e1; background: #f8fafc; }

        .user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            max-width: 110px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 7px 12px;
            border-radius: 8px;
            border: 1px solid #fecaca;
            background: #fff5f5;
            color: var(--red);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .logout-btn:hover { background: #fee2e2; border-color: #fca5a5; }
        .logout-btn svg { width: 14px; height: 14px; }

        /* ── Page content ── */
        .page-content {
            flex: 1;
            padding: 24px;
            overflow: auto;
        }

        .content-card {
            background: var(--card);
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-height) - 48px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);
        }

        /* ── Desktop layout ── */
        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0); }
            .main-wrapper { margin-left: var(--sidebar-width); }
            .hamburger { display: none; }
        }

        /* ── Tablet ── */
        @media (max-width: 640px) {
            .page-content { padding: 16px; }
            .content-card { padding: 16px; border-radius: 10px; }
            .page-title { font-size: 14px; }
            .user-name { display: none; }
        }

        /* Alpine transition helpers */
        [x-cloak] { display: none !important; }
    </style>
</head>

<body>

<div
    x-data="{ sidebarOpen: false }"
    @keydown.escape.window="sidebarOpen = false"
>

    <!-- ── Overlay ── -->
    <div
        id="sidebar-overlay"
        :class="sidebarOpen ? 'is-visible' : ''"
        @click="sidebarOpen = false"
        x-cloak
    ></div>

    <!-- ── Sidebar ── -->
    <aside
        id="sidebar"
        :class="sidebarOpen ? 'is-open' : ''"
    >
        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="logo-mark">
                <div class="logo-icon">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="logo-text">AdminPanel</div>
                </div>
            </div>
            <span class="logo-badge">v2.0</span>
            <!-- Mobile close -->
            <button
                class="lg:hidden"
                style="background:none;border:none;color:#64748b;cursor:pointer;padding:4px;border-radius:6px;"
                @click="sidebarOpen = false"
                aria-label="Close sidebar"
            >
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <p class="nav-section">Overview</p>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>
                </svg>
                Dashboard
            </a>

            <p class="nav-section">Admin</p>

            <a href="{{ route('admin.index') }}"
               class="nav-link {{ request()->routeIs('admin.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Administrators
            </a>

            <p class="nav-section">Management</p>

            <a href="{{ route('users.index') }}"
               class="nav-link {{ request()->routeIs('users.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Users
            </a>

            <a href="{{ route('roles.index') }}"
               class="nav-link {{ request()->routeIs('roles.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Roles
            </a>

            <a href="{{ route('permissions.index') }}"
               class="nav-link {{ request()->routeIs('permissions.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Permissions
            </a>

            <p class="nav-section">Catalog</p>

            <a href="{{ route('brands.index') }}"
               class="nav-link {{ request()->routeIs('brands.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Brands
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-link {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Products
            </a>

            <a href="{{ route('stocks.index') }}"
               class="nav-link {{ request()->routeIs('stocks.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Stocks
            </a>

            <a href="{{ route('orders.index') }}"
               class="nav-link {{ request()->routeIs('orders.*') ? 'nav-active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8H17m-10 0a1 1 0 11-2 0 1 1 0 012 0zm10 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                </svg>
                Orders
            </a>

        </nav>

        <!-- Sidebar footer: user info -->
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ── Main ── -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">

            <div class="topbar-left">
                <button
                    class="hamburger lg:hidden"
                    @click="sidebarOpen = true"
                    aria-label="Open sidebar"
                >
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h2 class="page-title">{{ $header ?? 'Dashboard' }}</h2>
            </div>

            <div class="topbar-right">

                <!-- Notifications -->
                <button class="topbar-btn" style="display:none;" aria-label="Notifications">
                    <span class="notif-dot"></span>
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <!-- User chip (desktop) -->
                <div class="user-chip hidden sm:flex">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>

        </header>

        <!-- Page content -->
        <main class="page-content">
            <div class="content-card">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>

</body>
</html>
