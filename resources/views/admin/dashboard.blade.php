<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - INBISKOM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- TOPBAR --}}
    <header class="bg-white border-b border-gray-200 h-16 flex items-center px-8 shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/Unikom.png') }}" alt="UNIKOM" class="h-8 w-8 object-contain">
            <span class="text-lg font-bold text-gray-900">INBISKOM Admin</span>
        </div>

        <div class="flex-1"></div>

        {{-- User Info --}}
        <div class="flex items-center gap-3">
            <div class="text-right leading-tight">
                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1.5 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg px-3 py-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Selamat datang, {{ Auth::user()->name }}</h1>

        <div class="bg-white rounded-xl border border-gray-200 px-6 py-5">
            <p class="text-sm text-gray-600">
                Anda masuk sebagai <strong>Administrator</strong>. Gunakan panel ini untuk mengelola sistem INBISKOM.
            </p>
        </div>
    </main>

</body>

</html>