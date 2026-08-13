<?php

namespace App\Providers;

use App\Models\PengajuanAnggaran;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();
            $role = $user->role;

            if ($role === 'super_admin') {
                $notifikasi = PengajuanAnggaran::with('user')
                    ->orderBy('updated_at', 'desc')
                    ->take(5)
                    ->get();
            } elseif ($role === 'admin') {
                $notifikasi = PengajuanAnggaran::with('user')
                    ->where('unit_kerja', $user->unit_kerja)
                    ->orderBy('updated_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                $notifikasi = PengajuanAnggaran::where('user_id', $user->id)
                    ->orderBy('updated_at', 'desc')
                    ->take(5)
                    ->get();
            }

            $view->with('notifikasi', $notifikasi);
        });
    }
}