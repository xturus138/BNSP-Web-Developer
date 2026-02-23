@extends('layouts.tenant')

@section('title', 'Dashboard - INBISKOM')

@section('content')
{{-- Greeting --}}
<h1 class="text-2xl font-bold text-gray-900 mb-6">Selamat datang, Raditya Aryabudhi Ramadhan</h1>

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
            <p class="text-xl font-bold text-gray-900">26 Januari 2026</p>
            <p class="text-xs text-gray-400 mt-0.5">Tanggal pendaftaran akun</p>
        </div>
    </div>

    {{-- Kelengkapan Dokumen --}}
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-4 flex items-center gap-4">
        <div class="text-gray-400 shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 mb-0.5">Kelengkapan Dokumen</p>
            <p class="text-xl font-bold text-gray-900">0%</p>
            <p class="text-xs text-gray-400 mt-0.5">Belum ada dokumen yang diupload</p>
        </div>
    </div>

</div>

{{-- Registration CTA Card --}}
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
    <a href="#"
        class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
        Mulai Pendaftaran Tenant
    </a>
</div>
@endsection