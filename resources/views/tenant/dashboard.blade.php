@extends('layouts.tenant')

@section('title', 'Dashboard - INBISKOM')

@section('content')
{{-- Flash Messages --}}
@if (session('success'))
<div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-6">
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif

{{-- Greeting --}}
<h1 class="text-2xl font-bold text-gray-900 mb-6">Selamat datang, {{ $user->name }}</h1>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 gap-4 mb-6">

    {{-- Terdaftar Sejak --}}
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-4 flex items-center gap-4">
        <div class="text-gray-400 shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Terdaftar Sejak</p>
            <p class="text-xl font-bold text-gray-900">{{ $user->created_at->translatedFormat('d F Y') }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Tanggal pendaftaran akun</p>
        </div>
    </div>

    {{-- Status Pendaftaran --}}
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-4 flex items-center gap-4">
        @php
        $statusConfig = match($proposal->status ?? null) {
        'approved' => ['color' => 'text-green-400', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Approved', 'textColor' => 'text-green-600'],
        'rejected' => ['color' => 'text-red-400', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Rejected', 'textColor' => 'text-red-600'],
        'pending' => ['color' => 'text-amber-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Pending', 'textColor' => 'text-amber-500'],
        default => ['color' => 'text-gray-400', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Belum Daftar', 'textColor' => 'text-gray-500'],
        };
        @endphp
        <div class="shrink-0 {{ $statusConfig['color'] }}">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $statusConfig['icon'] }}" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Status</p>
            <p class="text-xl font-bold {{ $statusConfig['textColor'] }}">{{ $statusConfig['label'] }}</p>
        </div>
    </div>

</div>

@if ($tenant)
{{-- ======================================
         SUDAH TERDAFTAR
    ====================================== --}}
<div class="bg-white rounded-xl border border-gray-200 px-8 py-7">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Pendaftaran Berhasil</h2>
    </div>
    <p class="text-sm text-gray-500 mb-6">
        Tenant <strong>{{ $tenant->nama_tenant }}</strong> telah terdata.
        Anda dapat melihat informasi lengkap di halaman Detail Tenant.
    </p>

    <div class="flex gap-3">
        <a href="{{ route('tenant.detail') }}"
            class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Lihat Detail Tenant
        </a>
        <a href="{{ route('tenant.profil') }}"
            class="inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Lengkapi Profil
        </a>
    </div>
</div>

{{-- Catatan Revisi --}}
@if ($proposal)
<div class="bg-sky-50 rounded-xl border border-sky-200 px-8 py-6 mt-6">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-sm font-bold text-sky-800">Catatan Revisi dari Admin</h3>
    </div>
    <p class="text-sm text-sky-700 ml-11">{{ $proposal->catatan_revisi ?? '-' }}</p>
</div>
@endif
@else
{{-- ======================================
         BELUM TERDAFTAR
    ====================================== --}}
<div class="bg-white rounded-xl border border-gray-200 px-8 py-7">
    <h2 class="text-lg font-bold text-gray-900 mb-2">Belum Memulai Pendaftaran Tenant</h2>
    <p class="text-sm text-gray-500 mb-6 max-w-2xl">
        Anda belum memulai proses pendaftaran tenant. Untuk mengikuti program INBISKOM, silakan isi formulir
        pendaftaran tenant dan unggah proposal bisnis Anda terlebih dahulu.
    </p>

    {{-- Steps --}}
    <div class="bg-gray-50 rounded-xl p-5 mb-6">
        <p class="text-sm font-semibold text-gray-700 mb-4">Langkah-langkah yang harus Anda lakukan:</p>
        <div class="grid grid-cols-2 gap-3">

            <div class="bg-white rounded-lg p-3 flex items-start gap-3 border border-gray-100">
                <span class="w-6 h-6 rounded-full bg-sky-500 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                <p class="text-sm text-gray-700">Isi formulir pendaftaran tenant dengan data lengkap</p>
            </div>

            <div class="bg-white rounded-lg p-3 flex items-start gap-3 border border-gray-100">
                <span class="w-6 h-6 rounded-full bg-sky-500 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                <p class="text-sm text-gray-700">Unggah proposal bisnis tenant Anda</p>
            </div>

            <div class="bg-white rounded-lg p-3 flex items-start gap-3 border border-gray-100">
                <span class="w-6 h-6 rounded-full bg-sky-500 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                <p class="text-sm text-gray-700">Tunggu verifikasi dari admin (3-5 hari kerja)</p>
            </div>

            <div class="bg-white rounded-lg p-3 flex items-start gap-3 border border-gray-100">
                <span class="w-6 h-6 rounded-full bg-sky-500 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                <p class="text-sm text-gray-700">Akun anda berhasil terdaftar sebagai tenant!</p>
            </div>

        </div>
    </div>

    {{-- CTA Button --}}
    <a href="{{ route('tenant.pendaftaran') }}"
        class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
        Mulai Pendaftaran Tenant
    </a>
</div>
@endif
@endsection