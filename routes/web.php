<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

//Tenant
Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
