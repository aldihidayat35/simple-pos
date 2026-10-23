<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Authentication & Session Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Instant Role Switcher (For operational handover and role verification)
Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('auth.switch-role');

// Main Operational Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Super Admin Protected Routes (Zero-Approval System Management)
Route::middleware(['auth', 'role:SUPER_ADMIN', 'readonly.owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
