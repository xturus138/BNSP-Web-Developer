<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(Request $request): View
    {
        // 1. Base Query with Eager Loading (N+1 Prevention)
        $query = Tenant::with(['user', 'proposals' => fn ($q) => $q->latest()->limit(1), 'anggotaTims']);

        // 2. Apply Scopes (Logic moved to Model)
        $query->dateRange($request->tanggal_awal, $request->tanggal_akhir)
            ->byStatus($request->status)
            ->search($request->search);

        // 3. Execute Pagination
        $tenants = $query->latest()->paginate(10)->withQueryString();

        // 4. Calculate Stats using base filters (Efficient counting)
        $statsBase = Tenant::dateRange($request->tanggal_awal, $request->tanggal_akhir);

        $stats = [
            'total' => (clone $statsBase)->count(),
            'pending' => (clone $statsBase)->byStatus('pending')->count(),
            'approved' => (clone $statsBase)->byStatus('approved')->count(),
            'rejected' => (clone $statsBase)->byStatus('rejected')->count(),
        ];

        return view('admin.dashboard', compact('tenants', 'stats'));
    }

    public function show(Tenant $tenant): View
    {
        $tenant->load(['user', 'proposals', 'produks', 'anggotaTims']);

        return view('admin.tenant.show', compact('tenant'));
    }

    public function updateStatus(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
            'catatan_revisi' => ['nullable', 'string', 'max:1000'],
        ]);

        $proposal = $tenant->proposals()->latest()->first();

        if ($proposal) {
            $data = ['status' => $validated['status']];

            // Simpan catatan jika ada
            if ($request->has('catatan_revisi')) {
                $data['catatan_revisi'] = $validated['catatan_revisi'];
            }

            // Set tanggal persetujuan jika approved
            if ($validated['status'] === 'approved') {
                $data['tanggal_persetujuan'] = now();
            }

            $proposal->update($data);
        }

        return back()->with('success', "Status tenant {$tenant->nama_tenant} berhasil diperbarui.");
    }
}
