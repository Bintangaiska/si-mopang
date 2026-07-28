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
    Route::get('/pengajuan/riwayat', [App\Http\Controllers\PengajuanController::class, 'riwayat'])->name('pengajuan.riwayat');
    Route::get('/pengajuan/{id}', [App\Http\Controllers\PengajuanController::class, 'show'])->name('pengajuan.show');

    Route::get('/dev/switch-role/{role}', [App\Http\Controllers\DevToolsController::class, 'switchRole'])->name('dev.switch-role');
});


require __DIR__.'/auth.php';