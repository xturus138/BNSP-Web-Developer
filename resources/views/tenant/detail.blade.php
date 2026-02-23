@extends('layouts.tenant')

@section('title', 'Detail Tenant - INBISKOM')

@section('content')
{{-- Page Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Detail Tenant</h1>
    <p class="text-sm text-gray-500 mt-1">Informasi lengkap tentang tenant Anda</p>
</div>

@if (! $tenant)
{{-- Belum Terdaftar --}}
<div class="bg-white rounded-xl border border-gray-200 px-8 py-12 text-center">
    <div class="text-gray-300 mb-4">
        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    </div>
    <h2 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Data Tenant</h2>
    <p class="text-sm text-gray-500 mb-6">Anda belum melakukan pendaftaran tenant. Silakan daftar terlebih dahulu.</p>
    <a href="{{ route('tenant.pendaftaran') }}"
        class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
        Mulai Pendaftaran
    </a>
</div>
@else
<div class="space-y-6">

    {{-- ============================================================
             SECTION 1: Informasi Tenant
        ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">1</span>
            <h2 class="text-lg font-semibold text-gray-900">Informasi Tenant</h2>
        </div>

        <div class="flex items-start gap-6">
            {{-- Logo --}}
            @if ($tenant->logo)
            <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo {{ $tenant->nama_tenant }}"
                class="w-24 h-24 rounded-xl border border-gray-200 object-cover shrink-0">
            @else
            <div class="w-24 h-24 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            @endif

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 gap-x-8 gap-y-4 flex-1">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nama Tenant</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $tenant->nama_tenant }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">No. HP Usaha</p>
                    <p class="text-sm text-gray-700">{{ $tenant->no_hp_usaha ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Alamat Usaha</p>
                    <p class="text-sm text-gray-700">{{ $tenant->alamat_usaha ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Media Sosial</p>
                    <p class="text-sm text-gray-700">{{ $tenant->media_sosial ?? '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-0.5">Deskripsi Singkat</p>
                    <p class="text-sm text-gray-700">{{ $tenant->deskripsi_singkat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Terdaftar Sejak</p>
                    <p class="text-sm text-gray-700">{{ $tenant->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
             SECTION 2: Proposal Bisnis
        ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">2</span>
            <h2 class="text-lg font-semibold text-gray-900">Proposal Bisnis</h2>
        </div>

        @forelse ($tenant->proposals as $proposal)
        <div class="border border-gray-100 rounded-lg p-4 mb-3 last:mb-0">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900">{{ $proposal->judul_proposal }}</h3>
                @php
                $statusColor = match($proposal->status) {
                'approved' => 'bg-green-100 text-green-700',
                'rejected' => 'bg-red-100 text-red-700',
                default => 'bg-amber-100 text-amber-700',
                };
                @endphp
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                    {{ ucfirst($proposal->status) }}
                </span>
            </div>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Tanggal Pengajuan</p>
                    <p class="text-gray-700">{{ $proposal->tanggal_pengajuan ? \Carbon\Carbon::parse($proposal->tanggal_pengajuan)->translatedFormat('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Tanggal Persetujuan</p>
                    <p class="text-gray-700">{{ $proposal->tanggal_persetujuan ? \Carbon\Carbon::parse($proposal->tanggal_persetujuan)->translatedFormat('d F Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">File Dokumen</p>
                    @if ($proposal->file_dokumen)
                    <a href="{{ asset('storage/' . $proposal->file_dokumen) }}" target="_blank"
                        class="text-sky-600 hover:text-sky-700 font-medium inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh
                    </a>
                    @else
                    <span class="text-gray-400">-</span>
                    @endif
                </div>
            </div>
            @if ($proposal->catatan_revisi)
            <div class="mt-3 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                <p class="text-xs font-semibold text-amber-700 mb-0.5">Catatan Revisi</p>
                <p class="text-sm text-amber-800">{{ $proposal->catatan_revisi }}</p>
            </div>
            @endif
        </div>
        @empty
        <p class="text-sm text-gray-400">Belum ada proposal.</p>
        @endforelse
    </div>

    {{-- ============================================================
             SECTION 3: Produk
        ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">3</span>
            <h2 class="text-lg font-semibold text-gray-900">Produk</h2>
        </div>

        <div class="grid grid-cols-2 gap-4">
            @forelse ($tenant->produks as $produk)
            <div class="border border-gray-100 rounded-lg p-4 flex gap-4">
                {{-- Foto --}}
                @if ($produk->foto_produk)
                <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}"
                    class="w-20 h-20 rounded-lg object-cover border border-gray-200 shrink-0">
                @else
                <div class="w-20 h-20 rounded-lg border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                @endif
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $produk->nama_produk }}</h3>
                    @if ($produk->harga)
                    <p class="text-sm font-bold text-sky-600 mb-1">{{ $produk->harga }}</p>
                    @endif
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $produk->detail_produk }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 col-span-2">Belum ada produk.</p>
            @endforelse
        </div>
    </div>

    {{-- ============================================================
             SECTION 4: Anggota Tim
        ============================================================ --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="w-8 h-8 rounded-full bg-sky-500 text-white text-sm font-bold flex items-center justify-center shrink-0">4</span>
            <h2 class="text-lg font-semibold text-gray-900">Anggota Tim</h2>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIM</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Program Studi</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fakultas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($tenant->anggotaTims as $index => $anggota)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $anggota->nama_anggota }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $anggota->nim }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $anggota->prodi ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $anggota->fakultas ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada anggota tim.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endif
@endsection