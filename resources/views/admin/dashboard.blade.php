@extends('layouts.admin')

@section('title', 'Dashboard Admin - INBISKOM')

@section('content')
{{-- Flash Messages --}}
@if (session('success'))
<div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 mb-6">
    <p class="text-sm text-green-700">{{ session('success') }}</p>
</div>
@endif

{{-- Page Header --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola akun tenant dan calon tenant!</p>
    </div>
    <div class="flex items-center gap-3 no-print">
        <button onclick="exportCSV()" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-lg text-sm font-semibold hover:bg-sky-600 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export CSV
        </button>
    </div>
</div>

{{-- Filter Periode --}}
<div id="filter-panel" class="bg-white rounded-xl border border-gray-200 px-6 py-5 mb-6">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-end gap-4">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-sm font-semibold text-gray-700">Filter Periode</span>
        </div>
        <div>
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                placeholder="Tanggal Awal">
        </div>
        <span class="text-gray-400">—</span>
        <div>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent"
                placeholder="Tanggal Akhir">
        </div>
        {{-- Preserve other filters --}}
        @if (request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if (request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <button type="submit"
            class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
            Terapkan
        </button>
        @if (request('tanggal_awal') || request('tanggal_akhir'))
        <a href="{{ route('admin.dashboard', request()->except(['tanggal_awal', 'tanggal_akhir'])) }}"
            class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
        @endif
    </form>
</div>

{{-- Stat Cards --}}
<div id="stats-panel" class="grid grid-cols-4 gap-4 mb-6">
    {{-- Total --}}
    <div class="bg-white rounded-xl border border-gray-200 px-5 py-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Total Tenant</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
    </div>

    {{-- Pending --}}
    <div class="bg-white rounded-xl border border-gray-200 px-5 py-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Dalam Peninjauan</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
        </div>
    </div>

    {{-- Approved --}}
    <div class="bg-white rounded-xl border border-gray-200 px-5 py-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Disetujui</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
        </div>
    </div>

    {{-- Rejected --}}
    <div class="bg-white rounded-xl border border-gray-200 px-5 py-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500">Ditolak</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
        </div>
    </div>
</div>

{{-- Search & Status Filter --}}
<div class="flex gap-4 mb-4">
    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex-1 flex gap-4">
        {{-- Preserve date filters --}}
        @if (request('tanggal_awal'))
        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
        @endif
        @if (request('tanggal_akhir'))
        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        @endif

        <div class="flex-1 relative">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama bisnis, ketua tim, atau NIM..."
                class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent">
        </div>

        <select name="status"
            class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent min-w-[160px]"
            onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Peninjauan</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </form>
</div>

{{-- Pagination Info --}}
<p class="text-sm text-gray-500 mb-4">
    Menampilkan {{ $tenants->firstItem() ?? 0 }} - {{ $tenants->lastItem() ?? 0 }} dari {{ $tenants->total() }} tenant
</p>

{{-- Tenant Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-base font-bold text-gray-900">Daftar Tenant</h2>
        <p class="text-xs text-gray-500 mt-0.5">Semua akun tenant dan status pendaftaran</p>
    </div>

    <div class="overflow-x-auto">
        <table id="tenant-table" class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Bisnis</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ketua Tim</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Daftar</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($tenants as $index => $tenant)
                @php
                $proposal = $tenant->latest_proposal;
                $ketua = $tenant->ketua;
                $rawStatus = strtolower($proposal->status ?? 'pending');

                // Normalisasi status
                $statusMap = [
                'disetujui' => 'approved',
                'ditolak' => 'rejected',
                'peninjauan' => 'pending',
                'setuju' => 'approved',
                'tolak' => 'rejected',
                ];

                $statusKey = $statusMap[$rawStatus] ?? $rawStatus;

                $colors = [
                'pending' => 'bg-sky-100 text-sky-700 border-sky-200',
                'approved' => 'bg-green-100 text-green-700 border-green-200',
                'rejected' => 'bg-red-100 text-red-700 border-red-200',
                ];

                $labels = [
                'pending' => 'Peninjauan',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                ];

                $badgeColor = $colors[$statusKey] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                $badgeLabel = $labels[$statusKey] ?? ucfirst($rawStatus);
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3.5 text-gray-500">{{ $tenants->firstItem() + $index }}</td>
                    <td class="px-4 py-3.5 font-medium text-gray-900">{{ $tenant->nama_tenant }}</td>
                    <td class="px-4 py-3.5">
                        @if ($ketua)
                        <div>
                            <p class="text-gray-900">{{ $ketua->nama_anggota }}</p>
                            <p class="text-xs text-gray-400">{{ $ketua->nim }}</p>
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-gray-700">{{ $tenant->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3.5 text-gray-500">Lainnya</td>
                    <td class="px-4 py-3.5">
                        <span class="px-2.5 py-1 rounded-full border {{ $badgeColor }} text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">
                            {{ $badgeLabel }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 no-print">
                        <a href="{{ route('admin.tenant.show', $tenant) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:text-sky-700 bg-sky-50 hover:bg-sky-100 px-3 py-1.5 rounded-full transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        Belum ada data tenant.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($tenants->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-center gap-1">
        {{-- Previous --}}
        @if ($tenants->onFirstPage())
        <span class="px-3 py-1.5 text-sm text-gray-400 cursor-not-allowed">‹ Previous</span>
        @else
        <a href="{{ $tenants->previousPageUrl() }}"
            class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">‹ Previous</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($tenants->getUrlRange(1, $tenants->lastPage()) as $page => $url)
        @if ($page == $tenants->currentPage())
        <span class="px-3 py-1.5 text-sm font-bold text-sky-600 bg-sky-50 rounded-lg">{{ $page }}</span>
        @else
        <a href="{{ $url }}"
            class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">{{ $page }}</a>
        @endif
        @endforeach

        {{-- Next --}}
        @if ($tenants->hasMorePages())
        <a href="{{ $tenants->nextPageUrl() }}"
            class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">Next ›</a>
        @else
        <span class="px-3 py-1.5 text-sm text-gray-400 cursor-not-allowed">Next ›</span>
        @endif
    </div>
    @endif
</div>

<script>
    function exportCSV() {
        const table = document.getElementById('tenant-table');
        const rows = table.querySelectorAll('tr');
        let csv = [];

        rows.forEach(row => {
            const cols = row.querySelectorAll('th, td');
            const data = [];
            cols.forEach((col, i) => {
                // Skip kolom No (0) dan Aksi (terakhir)
                if (i === 0 || i === cols.length - 1) return;

                let text = col.innerText.replace(/"/g, '""').trim();

                // Jika itu kolom status (dropdown), ambil teks yang terpilih
                const select = col.querySelector('select');
                if (select) {
                    text = select.options[select.selectedIndex].text;
                }

                data.push('"' + text + '"');
            });
            if (data.length) csv.push(data.join(','));
        });

        if (csv.length === 0) return;

        const blob = new Blob([csv.join('\n')], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "daftar_tenant_" + new Date().toISOString().slice(0, 10) + ".csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection