<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\B2bController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

// Authentication & Session Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Instant Role Switcher (For operational handover and role verification)
Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('auth.switch-role');

// Main Operational Dashboard (Fase 1)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Modular Operational Routes (Protected by Auth & Read-Only Check)
Route::middleware(['auth', 'readonly.owner'])->group(function () {
    // Master Produk, Multi-Satuan & Real-Time Fuzzy Similarity Check (Fase 3)
    Route::post('/products/fuzzy-check', [ProductController::class, 'checkSimilarity'])->name('products.fuzzy-check');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Master Suplayer (Fase 3)
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Audit Trail & Rekam Jejak (Fase 2)
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');

    // Operasional Gudang Pusat & PO (Fase 4 Roadmap)
    Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');

    // Operasional Toko & Kasir POS (Fase 5 Roadmap)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

    // Kemitraan Grosir B2B & Plafon Piutang (Fase 6 Roadmap)
    Route::get('/b2b', [B2bController::class, 'index'])->name('b2b.index');
});

// Super Admin Protected Routes (Zero-Approval System Management)
Route::middleware(['auth', 'role:SUPER_ADMIN', 'readonly.owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
