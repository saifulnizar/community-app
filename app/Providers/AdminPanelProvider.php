<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class AdminPanelProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Saat Filament dimuat
        Filament::serving(function () {
            // Hanya izinkan user dengan role admin
            if (auth()->check() && !auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized');
            }
        });
    }
}
