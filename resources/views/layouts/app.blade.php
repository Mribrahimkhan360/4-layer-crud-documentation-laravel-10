<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Sidebar transition */
        #sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
        }

        /* Overlay fade */
        #sidebar-overlay {
            transition: opacity 0.3s ease;
        }

        /* Active nav item */
        .nav-active {
            background-color: rgb(30 41 59); /* slate-800 */
            color: white;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">

<div
    class="min-h-screen flex"
    x-data="{ sidebarOpen: false }"
    @keydown.escape.window="sidebarOpen = false"
>

    <!-- ===== Mobile Overlay ===== -->
    <div
        id="sidebar-overlay"
        class="fixed inset-0 bg-black/50 z-20 lg:hidden"
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        style="display:none;"
    ></div>

    <!-- ===== Sidebar ===== -->
    <aside
        id="sidebar"
        class="min-h-screen
            fixed top-0 left-0 z-30 h-full w-64
            bg-slate-900 text-gray-300 flex flex-col shadow-xl
            -translate-x-full
            lg:relative lg:translate-x-0 lg:flex lg:z-auto
        "
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    >

        <!-- Logo + Close Button -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 shrink-0">
            <h1 class="text-xl font-bold text-white tracking-wide">
                Admin Panel
            </h1>
            <!-- Close button — mobile only -->
            <button
                class="lg:hidden text-gray-400 hover:text-white p-1 rounded-md focus:outline-none"
                @click="sidebarOpen = false"
                aria-label="Close sidebar"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1 text-sm overflow-y-auto min-h-screen">

            <p class="text-xs uppercase text-gray-500 mt-2 mb-2 px-2 tracking-wider">Dashboard Management</p>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200 {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                <!-- Icon -->
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Section Label -->
            <p class="text-xs uppercase text-gray-500 mt-2 mb-2 px-2 tracking-wider">Admin Management</p>

            <a href="{{ route('admin.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-2a6 6 0 0112 0v2" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 10h2m-1-1v2" />
                </svg>
                Admin
            </a>
            
            <!-- Section Label -->
            <p class="text-xs uppercase text-gray-500 mt-6 mb-2 px-2 tracking-wider">Management</p>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                </svg>
                Users
            </a>

            <a href="{{ route('roles.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Roles
            </a>

            <a href="{{ route('permissions.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>

                Permissions
            </a>

            <a href="{{ route('brands.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Brands
            </a>

            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Products
            </a>

            <a href="{{ route('stocks.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Stocks
            </a>
            {{--     {{ route('orders.index') }}       --}}
            <a href="{{ route('orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition duration-200">
                <!-- Add to Cart Icon -->
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8H17m-10 0a1 1 0 11-2 0 1 1 0 012 0zm10 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                </svg>
                Order
            </a>

        </nav>

        <!-- Footer -->
        <div class="p-4 border-t border-slate-800 text-xs text-gray-500 text-center shrink-0">
            © {{ date('Y') }} Admin System
        </div>

    </aside>


    <!-- ===== Main Content ===== -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Topbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 shrink-0 sticky top-0 z-10">

            <!-- Left: Hamburger + Page Title -->
            <div class="flex items-center gap-3">
                <!-- Hamburger — visible on mobile/tablet -->
                <button
                    class="lg:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition"
                    @click="sidebarOpen = true"
                    aria-label="Open sidebar"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h2 class="text-base sm:text-lg font-semibold text-gray-700 truncate">
                    {{ $header ?? 'Dashboard' }}
                </h2>
            </div>

            <!-- Right: User + Logout -->
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <!-- Avatar circle -->
                <div class="hidden sm:flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-white text-xs font-bold uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm text-gray-600 max-w-[120px] truncate">
                        {{ Auth::user()->name }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex items-center gap-1 text-red-500 text-sm hover:text-red-700 transition px-2 py-1 rounded hover:bg-red-50"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>

        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 md:p-8 overflow-auto">
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">
                {{ $slot }}
            </div>
        </main>

    </div>

</div>

</body>
</html>
