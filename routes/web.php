<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InventoryDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'show'])->name('welcome');
Route::get('/custom-register', [RegisterController::class, 'show'])->name('register.show');
Route::get('/custom-login', [LoginController::class, 'show'])->name('login.show');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth'])->group(function () {
    // Controller Single-Page (Tetap pakai GET karena hanya menampilkan 1 halaman)
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/report', [ReportController::class, 'show'])->name('report');

    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.excel');

    // Profile Controller (Biasanya tetap manual karena tidak menggunakan parameter {id})
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==== DIUBAH MENJADI RESOURCE ====
    // Ini otomatis meng-generate route untuk index, store, update, dan destroy
    Route::resource('category', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('inventory-data', InventoryDataController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('transaction', TransactionController::class)->only(['index', 'store']);
    Route::resource('log', LogController::class)->only(['index']);
    Route::resource('user-management', UserManagementController::class)->parameters(['user-management' => 'user'])->only(['index', 'store', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
