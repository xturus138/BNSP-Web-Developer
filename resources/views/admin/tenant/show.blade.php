@extends('layouts.admin')

@section('title', 'Detail Tenant - ' . $tenant->nama_tenant . ' - INBISKOM')

@section('content')
<div x-data="{ 
    notes: @js($tenant->latest_proposal->catatan_revisi ?? ''),
    updateStatus(status) {
        document.getElementById('status-input').value = status;
        document.getElementById('notes-input').value = this.notes;
        document.getElementById('status-form').submit();
    }
}">
    <div class="mb-6 flex items-center gap-2 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-sky-600 transition-colors">Dashboard</a>
        <span class="text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </span>
        <span class="text-gray-500">Detail Tenant</span>
        <span class="text-gray-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </span>
        <span class="font-semibold text-gray-900">{{ $tenant->nama_tenant }}</span>
    </div>

    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            @if($tenant->logo)
            <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-white">
                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="{{ $tenant->nama_tenant }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="w-16 h-16 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 font-bold text-2xl shadow-sm border border-sky-200">
                {{ substr($tenant->nama_tenant, 0, 1) }}
            </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $tenant->nama_tenant }}</h1>
                <p class="text-gray-500">Profil lengkap dan riwayat pengajuan tenant</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            @php
            $rawStatus = strtolower($tenant->latest_proposal->status ?? 'pending');

            // Normalisasi status (handle mixed english/indonesia)
            $statusMap = [
            'disetujui' => 'approved',
            'ditolak' => 'rejected',
            'peninjauan' => 'pending',
            'setuju' => 'approved',
            'tolak' => 'rejected',
            ];

            $currentStatus = $statusMap[$rawStatus] ?? $rawStatus;

            $statusColors = [
            'pending' => 'bg-sky-100 text-sky-700 border-sky-200',
            'approved' => 'bg-green-100 text-green-700 border-green-200',
            'rejected' => 'bg-red-100 text-red-700 border-red-200',
            ];

            $statusLabels = [
            'pending' => 'Peninjauan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            ];

            // Safety fallback
            $colorClass = $statusColors[$currentStatus] ?? 'bg-gray-100 text-gray-700 border-gray-200';
            $label = $statusLabels[$currentStatus] ?? ucfirst($rawStatus);
            @endphp
            <span class="px-4 py-1.5 rounded-full border {{ $colorClass }} text-sm font-semibold">
                {{ $label }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-8">
        {{-- Left Column: Profile & Team --}}
        <div class="col-span-2 space-y-8">
            {{-- Business Profile --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.651V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3.004 3.004 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                        </svg>
                        Profil Bisnis
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi Singkat</label>
                            <p class="text-gray-700 mt-1 leading-relaxed">{{ $tenant->deskripsi_singkat ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Media Sosial</label>
                            <p class="text-gray-700 mt-1">{{ $tenant->media_sosial ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Alamat Usaha</label>
                            <p class="text-gray-700 mt-1">{{ $tenant->alamat_usaha ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">WhatsApp Usaha</label>
                            <p class="text-gray-700 mt-1">{{ $tenant->no_hp_usaha ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Team Members --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Anggota Tim ({{ $tenant->anggotaTims->count() }})
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($tenant->anggotaTims as $index => $anggota)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-gray-50/30">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center font-bold text-gray-400">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $anggota->nama_anggota }}</p>
                                    <p class="text-xs text-gray-500">{{ $anggota->prodi }} • {{ $anggota->nim }}</p>
                                </div>
                            </div>
                            @if($index === 0)
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-full text-[10px] font-bold uppercase tracking-wider">Ketua Tim</span>
                            @endif
                        </div>
                        @empty
                        <p class="text-center text-gray-400 py-4">Belum ada anggota tim terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Products --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Produk & Layanan
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        @forelse($tenant->produks as $produk)
                        <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/30">
                            <div class="flex gap-3">
                                @if($produk->foto_produk)
                                <div class="w-16 h-16 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 bg-white">
                                    <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-900 truncate">{{ $produk->nama_produk }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $produk->detail_produk }}</p>
                                    <div class="mt-2 text-sm font-bold text-sky-600">
                                        Rp {{ number_format((float) $produk->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center text-gray-400 py-4">Belum ada produk terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Proposals & Action --}}
        <div class="space-y-8">
            {{-- User Account --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        Akun Pengguna
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama User</label>
                            <p class="text-sm font-medium text-gray-900">{{ $tenant->user->name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Email</label>
                            <p class="text-sm font-medium text-gray-900 font-mono">{{ $tenant->user->email }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">No. HP Personal</label>
                            <p class="text-sm font-medium text-gray-900">{{ $tenant->user->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Control --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kontrol Status
                    </h2>
                </div>
                <div class="p-6">
                    <form id="status-form" method="POST" action="{{ route('admin.tenant.updateStatus', $tenant) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" id="status-input">
                        <input type="hidden" name="catatan_revisi" id="notes-input">

                        <div class="space-y-4">
                            <label class="text-xs font-bold text-gray-500 block">Ubah Status Menjadi:</label>
                            <div class="grid grid-cols-1 gap-2">
                                <button type="button" @click="updateStatus('pending')"
                                    class="w-full py-2 px-4 rounded-xl text-sm font-semibold border transition-all flex items-center justify-between
                                    {{ $currentStatus === 'pending' ? 'bg-sky-50 border-sky-200 text-sky-700' : 'bg-white border-gray-200 text-gray-600 hover:border-sky-300' }}">
                                    Peninjauan
                                    @if($currentStatus === 'pending') <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg> @endif
                                </button>
                                <button type="button" @click="updateStatus('approved')"
                                    class="w-full py-2 px-4 rounded-xl text-sm font-semibold border transition-all flex items-center justify-between
                                    {{ $currentStatus === 'approved' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-600 hover:border-green-300' }}">
                                    Disetujui
                                    @if($currentStatus === 'approved') <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg> @endif
                                </button>
                                <button type="button" @click="updateStatus('rejected')"
                                    class="w-full py-2 px-4 rounded-xl text-sm font-semibold border transition-all flex items-center justify-between
                                    {{ $currentStatus === 'rejected' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-white border-gray-200 text-gray-600 hover:border-red-300' }}">
                                    Ditolak
                                    @if($currentStatus === 'rejected') <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg> @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Dedicated Notes Box --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Catatan / Revisi Admin
                    </h2>
                </div>
                <div class="p-6">
                    <p class="text-xs text-gray-500 mb-4 italic">Berikan catatan atau instruksi revisi yang akan terlihat oleh tenant.</p>
                    <textarea x-model="notes" rows="4"
                        class="w-full text-sm rounded-xl border-gray-200 focus:ring-sky-500 focus:border-sky-500 bg-gray-50 focus:bg-white transition-all"
                        placeholder="Contoh: Dokumen pendaftaran belum lengkap, mohon unggah ulang akta pendirian..."></textarea>

                    <div class="mt-4 flex items-center gap-2 text-[10px] text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Catatan akan disimpan saat Anda menekan salah satu tombol status di atas.
                    </div>
                </div>
            </div>

            {{-- Proposal Document --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="font-bold text-gray-900">Proposal Terakhir</h2>
                </div>
                <div class="p-6">
                    @if($tenant->latest_proposal)
                    <div class="p-4 rounded-xl border border-sky-100 bg-sky-50/50 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $tenant->latest_proposal->judul_proposal }}</p>
                                <p class="text-[10px] text-gray-500">Diajukan: {{ $tenant->latest_proposal->tanggal_pengajuan ? \Carbon\Carbon::parse($tenant->latest_proposal->tanggal_pengajuan)->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $tenant->latest_proposal->file_dokumen) }}"
                            target="_blank"
                            class="w-full py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-center text-gray-600 hover:bg-gray-50 hover:text-sky-600 hover:border-sky-200 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            Buka Dokumen
                        </a>

                        @if($tenant->latest_proposal->catatan_revisi)
                        <div class="mt-2 p-3 rounded-lg bg-white border border-gray-100">
                            <label class="text-[9px] font-bold text-gray-400 capitalize block mb-1">Catatan Admin:</label>
                            <p class="text-xs text-gray-700 italic">"{{ $tenant->latest_proposal->catatan_revisi }}"</p>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-center text-gray-400 py-4 text-sm">Tidak ada proposal.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection