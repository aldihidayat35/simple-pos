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

// Master Produk, Multi-Satuan & Real-Time Fuzzy Similarity Check (Fase 3)
Route::middleware(['auth', 'readonly.owner'])->group(function () {
    Route::post('/products/fuzzy-check', [\App\Http\Controllers\ProductController::class, 'checkSimilarity'])->name('products.fuzzy-check');
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');

    // Master Suplayer (Fase 3)
    Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [\App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('suppliers.destroy');
});

// Super Admin Protected Routes (Zero-Approval System Management)
Route::middleware(['auth', 'role:SUPER_ADMIN', 'readonly.owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

