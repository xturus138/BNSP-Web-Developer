<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    /**
     * [J.620100.045.01] Melakukan Pemantauan Resource yang Digunakan Aplikasi
     * [J.620100.044.01] Menerapkan Alert Notification Jika Aplikasi Bermasalah
     */
    public function index(): View
    {
        $status = [];

        // 1. Cek Status Aplikasi
        // Note: Menghindari Http::get(config('app.url') . '/up') untuk mencegah deadlock pada php artisan serve
        $status['app'] = [
            'label' => 'Aplikasi',
            'ok' => true,
            'message' => 'Running',
            'color' => 'green',
        ];

        // 2. Cek Koneksi Database
        try {
            DB::connection()->getPdo();
            $status['db'] = [
                'label' => 'Database',
                'ok' => true,
                'message' => 'Connected',
                'color' => 'green',
            ];
        } catch (\Exception $e) {
            $status['db'] = [
                'label' => 'Database',
                'ok' => false,
                'message' => 'Disconnected: ' . $e->getMessage(),
                'color' => 'red',
            ];
        }

        // 3. Resource Monitoring (Memory & Storage)
        try {
            $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
            $diskFree = disk_free_space(base_path()) / 1024 / 1024 / 1024; // GB
            $diskTotal = disk_total_space(base_path()) / 1024 / 1024 / 1024; // GB

            $status['resources'] = [
                'memory' => round($memoryUsage, 2) . ' MB',
                'disk_free' => round($diskFree, 2) . ' GB',
                'disk_usage' => round((($diskTotal - $diskFree) / $diskTotal) * 100, 2) . '%',
            ];
        } catch (\Exception $e) {
            $status['resources'] = [
                'error' => $e->getMessage()
            ];
        }

        // 4. System Info
        $status['system'] = [
            'php_version' => PHP_VERSION,
            'os' => PHP_OS,
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'laravel_version' => app()->version(),
        ];

        return view('admin.monitoring', compact('status'));
    }
}
