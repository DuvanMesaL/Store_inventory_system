<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        // Configurar longitud de índices para MySQL
        Schema::defaultStringLength(191);

        // Usar Bootstrap para paginación
        Paginator::useBootstrapFive();

        // Configurar timezone si está definido
        if (config('app.timezone')) {
            date_default_timezone_set(config('app.timezone'));
        }
    }
}
