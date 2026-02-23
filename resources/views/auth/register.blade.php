<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - INBISKOM</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="bg-white rounded-2xl shadow-md w-full max-w-sm px-10 py-10 flex flex-col items-center">

        {{-- Logo --}}
        <img src="{{ asset('images/Unikom.png') }}" alt="Logo Unikom" class="w-24 h-24 object-contain mb-6">

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Daftar Akun</h1>
        <p class="text-sm text-gray-500 text-center mb-6">
            Buat akun untuk mengakses sistem<br>INBISKOM
        </p>

        {{-- Form --}}
        <form method="POST" action="{{ route('register.post') }}" class="w-full space-y-4">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input
                    id="nama_lengkap"
                    type="text"
                    name="nama_lengkap"
                    placeholder="Masukkan Nama Lengkap"
                    value="{{ old('nama_lengkap') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('nama_lengkap')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    placeholder="Masukkan Email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('email')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input
                    id="nomor_telepon"
                    type="tel"
                    name="nomor_telepon"
                    placeholder="Masukkan Nomor Telepon"
                    value="{{ old('nomor_telepon') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('nomor_telepon')
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

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi Password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('password_confirmation')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Captcha --}}
            <div>
                <label for="captcha" class="block text-sm font-medium text-gray-700 mb-1">{{ $a }} + {{ $b }} = ?</label>
                <input
                    id="captcha"
                    type="number"
                    name="captcha"
                    placeholder="Jawab pertanyaan di atas"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                @error('captcha')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold py-2.5 rounded-lg transition-colors duration-200 mt-2">
                Daftar
            </button>

            {{-- Link ke Login --}}
            <p class="text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-sky-500 font-medium hover:underline">Login</a>
            </p>

        </form>

    </div>

</body>

</html>