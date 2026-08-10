<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/pengajuan', [App\Http\Controllers\PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/ajukan', [App\Http\Controllers\PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [App\Http\Controllers\PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/riwayat', [App\Http\Controllers\PengajuanController::class, 'riwayat'])->name('pengajuan.riwayat');
    Route::get('/pengajuan/{id}', [App\Http\Controllers\PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::patch('/pengajuan/{id}/status', [App\Http\Controllers\PengajuanController::class, 'updateStatus'])->name('pengajuan.update-status');

    Route::get('/dev/switch-role/{role}', [App\Http\Controllers\DevToolsController::class, 'switchRole'])->name('dev.switch-role');

    Route::get('/rekap/admin/export/excel', [App\Http\Controllers\RekapController::class, 'exportExcelAdmin'])->name('rekap.export-excel-admin');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/user-management', [App\Http\Controllers\UserManagementController::class, 'index'])->name('user-management.index');
    Route::get('/user-management/{user}/edit', [App\Http\Controllers\UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::patch('/user-management/{user}', [App\Http\Controllers\UserManagementController::class, 'update'])->name('user-management.update');
    Route::delete('/user-management/{user}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('user-management.destroy');

    Route::get('/rekap/export/pdf', [App\Http\Controllers\RekapController::class, 'exportPdf'])->name('rekap.export-pdf');
    Route::get('/rekap/export/excel', [App\Http\Controllers\RekapController::class, 'exportExcel'])->name('rekap.export-excel');

    Route::get('/settings/pagu', [App\Http\Controllers\SettingsController::class, 'editPagu'])->name('settings.pagu');
    Route::patch('/settings/pagu', [App\Http\Controllers\SettingsController::class, 'updatePagu'])->name('settings.pagu.update');
});


require __DIR__.'/auth.php';
