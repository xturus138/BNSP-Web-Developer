<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - INBISKOM')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex" x-data="{ sidebarOpen: true }">

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <aside
        class="w-60 shrink-0 bg-white border-r border-gray-200 flex flex-col min-h-screen transition-all duration-300"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- Logo --}}
        <div class="px-4 py-4 border-b border-gray-100 flex items-center justify-center">
            <img src="{{ asset('images/Banner Unikom.png') }}" alt="UNIKOM" class="h-20 object-contain">
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4 space-y-1 px-2">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                    {{ request()->routeIs('admin.dashboard') ? 'bg-sky-50 text-sky-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            {{-- Monitoring --}}
            <a href="{{ route('admin.monitoring') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors
                    {{ request()->routeIs('admin.monitoring') ? 'bg-sky-50 text-sky-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Monitoring
            </a>

        </nav>

        {{-- Footer --}}
        <div class="px-4 py-3 border-t border-gray-100">
            <p class="text-xs text-gray-400 text-center">© 2026 UNIKOM</p>
        </div>

    </aside>

    {{-- ============================================================
         MAIN AREA (topbar + content)
    ============================================================ --}}
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-200 h-16 flex items-center px-8 gap-4 shrink-0">

            {{-- Hamburger --}}
            <button @click="sidebarOpen = !sidebarOpen"
                class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="flex-1"></div>

            {{-- User Info + Dropdown --}}
            <div class="relative" x-data="{ open: false }">

                {{-- Trigger --}}
                <button @click="open = !open"
                    class="flex items-center gap-2.5 hover:bg-gray-50 rounded-lg px-2 py-1.5 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="text-left leading-tight">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 ml-1 transition-transform" :class="open ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-50">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors w-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

            </div>

        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-8">
            @include('partials.alerts')
            @yield('content')
        </main>

    </div>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('modals')
</body>

</html>