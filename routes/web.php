<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\DetailTenantController;
use App\Http\Controllers\Tenant\PendaftaranController;
use App\Http\Controllers\Tenant\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth — Tenant
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'tenantLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'tenantLogout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'tenantRegister'])->name('register.post');

// Auth — Admin
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

Route::post('/admin/logout', [AuthController::class, 'adminLogout'])
    ->middleware('auth')
    ->name('admin.logout');

// Admin — Protected
Route::middleware(['auth', 'superadmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/monitoring', [\App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('admin.monitoring');
    Route::get('/tenant/{tenant}', [AdminDashboardController::class, 'show'])->name('admin.tenant.show');
    Route::patch('/tenant/{tenant}/status', [AdminDashboardController::class, 'updateStatus'])->name('admin.tenant.updateStatus');
    Route::delete('/tenant/{tenant}', [AdminDashboardController::class, 'destroy'])->name('admin.tenant.destroy');
});

// Tenant — Protected
Route::middleware('keycode')->group(function () {
    Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
    Route::get('/tenant/pendaftaran', [PendaftaranController::class, 'index'])->name('tenant.pendaftaran');
    Route::post('/tenant/pendaftaran', [PendaftaranController::class, 'store'])->name('tenant.pendaftaran.store');
    Route::get('/tenant/detail', [DetailTenantController::class, 'index'])->name('tenant.detail');
    Route::get('/tenant/profil', [ProfilController::class, 'index'])->name('tenant.profil');
    Route::put('/tenant/profil', [ProfilController::class, 'update'])->name('tenant.profil.update');
});
