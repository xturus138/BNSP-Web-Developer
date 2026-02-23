<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
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
});

// Tenant — Protected
Route::middleware('keycode')->group(function () {
    Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});
