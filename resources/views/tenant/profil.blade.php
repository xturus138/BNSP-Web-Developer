@extends('layouts.tenant')

@section('title', 'Profil - INBISKOM')

@section('content')
{{-- Page Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan data pribadi Anda</p>
</div>

{{-- Flash Messages --}}
@if (session('success'))
<div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-6">
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif

<div class="grid grid-cols-3 gap-6">

    {{-- ============================================================
         LEFT: Profile Card
    ============================================================ --}}
    <div class="col-span-1 space-y-6">
        {{-- Avatar Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
            <div class="w-20 h-20 rounded-full bg-sky-500 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <h2 class="text-lg font-bold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <div class="mt-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-sky-100 text-sky-700">{{ ucfirst($user->role) }}</span>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Informasi Akun</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400">Terdaftar Sejak</p>
                    <p class="text-sm text-gray-700">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Terakhir Diupdate</p>
                    <p class="text-sm text-gray-700">{{ $user->updated_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">NIM</p>
                    <p class="text-sm text-gray-700">{{ $user->nim ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Program Studi</p>
                    <p class="text-sm text-gray-700">{{ $user->prodi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Fakultas</p>
                    <p class="text-sm text-gray-700">{{ $user->fakultas ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         RIGHT: Edit Form
    ============================================================ --}}
    <div class="col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Edit Profil</h3>

            <form method="POST" action="{{ route('tenant.profil.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-x-6 gap-y-5">

                    {{-- Nama Lengkap --}}
                    <div class="col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                        <input
                            id="no_hp"
                            type="tel"
                            name="no_hp"
                            value="{{ old('no_hp', $user->no_hp) }}"
                            placeholder="Masukkan nomor telepon"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('no_hp')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIM --}}
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                        <input
                            id="nim"
                            type="text"
                            name="nim"
                            value="{{ old('nim', $user->nim) }}"
                            placeholder="Masukkan NIM"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('nim')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Prodi --}}
                    <div>
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <input
                            id="prodi"
                            type="text"
                            name="prodi"
                            value="{{ old('prodi', $user->prodi) }}"
                            placeholder="Masukkan program studi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('prodi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fakultas --}}
                    <div class="col-span-2">
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <input
                            id="fakultas"
                            type="text"
                            name="fakultas"
                            value="{{ old('fakultas', $user->fakultas) }}"
                            placeholder="Masukkan fakultas"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
                        @error('fakultas')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection