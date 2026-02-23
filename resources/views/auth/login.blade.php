<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - INBISKOM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-md w-full max-w-sm px-10 py-10 flex flex-col items-center">

        {{-- Logo --}}
        <img src="{{ asset('images/Unikom.png') }}" alt="Logo Unikom" class="w-24 h-24 object-contain mb-6">

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Login Aplikasi</h1>
        <p class="text-sm text-gray-500 text-center mb-6">
            Silakan login untuk masuk ke sistem<br>INBISKOM
        </p>

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    type="text"
                    name="email"
                    placeholder="Masukkan Email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Masukkan Password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Register --}}
            <div class="text-center">
                <p class="text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-sky-500 font-medium hover:underline">Daftar</a>
                </p>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold py-2.5 rounded-lg transition-colors duration-200 mt-2">
                Login
            </button>
        </form>

    </div>

</body>

</html>