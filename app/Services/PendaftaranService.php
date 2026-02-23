<?php

namespace App\Services;

use App\Models\AnggotaTim;
use App\Models\Produk;
use App\Models\Proposal;
use App\Models\Tenant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PendaftaranService
{
    /**
     * [Metode 2: Service Pattern] — Memisahkan logika bisnis dari controller.
     * Controller hanya validasi + redirect, service mengurus penyimpanan data + file.
     *
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, string>>  $anggota
     */
    public function store(
        array $data,
        array $anggota,
        ?UploadedFile $logo,
        ?UploadedFile $fileDokumen,
        ?UploadedFile $fotoProduk,
    ): Tenant {
        // [Metode 2: DB Transaction] — semua INSERT dalam satu transaksi
        // Jika salah satu gagal, semuanya di-rollback (tidak ada data setengah jadi)
        return DB::transaction(function () use ($data, $anggota, $logo, $fileDokumen, $fotoProduk) {

            // ── 1. Simpan Tenant ──
            // [Metode 2: File Upload] — store() generate nama unik (UUID) + simpan di disk 'public'
            // Hasil: storage/app/public/logos/abc123.jpg → diakses via /storage/logos/abc123.jpg
            $tenantData = [
                'user_id' => $data['user_id'],
                'nama_tenant' => $data['nama_tenant'],
                'deskripsi_singkat' => $data['deskripsi_singkat'] ?? null,
                'no_hp_usaha' => $data['no_hp_usaha'] ?? null,
                'alamat_usaha' => $data['alamat_usaha'] ?? null,
                'media_sosial' => $data['media_sosial'] ?? null,
            ];

            if ($logo) {
                $tenantData['logo'] = $logo->store('logos', 'public');
            }

            $tenant = Tenant::create($tenantData);

            // ── 2. Simpan Proposal ──
            $proposalData = [
                'tenant_id' => $tenant->id,
                'judul_proposal' => $data['judul_proposal'],
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ];

            if ($fileDokumen) {
                $proposalData['file_dokumen'] = $fileDokumen->store('proposals', 'public');
            }

            Proposal::create($proposalData);

            // ── 3. Simpan Produk ──
            $produkData = [
                'tenant_id' => $tenant->id,
                'nama_produk' => $data['nama_produk'],
                'detail_produk' => $data['detail_produk'],
                'harga' => $data['harga'] ?? null,
            ];

            if ($fotoProduk) {
                $produkData['foto_produk'] = $fotoProduk->store('produks', 'public');
            }

            Produk::create($produkData);

            // ── 4. Simpan Anggota Tim ──
            foreach ($anggota as $member) {
                AnggotaTim::create([
                    'tenant_id' => $tenant->id,
                    'nama_anggota' => $member['nama_anggota'],
                    'nim' => $member['nim'],
                    'prodi' => $member['prodi'] ?? null,
                    'fakultas' => $member['fakultas'] ?? null,
                ]);
            }

            return $tenant;
        });
    }
}
