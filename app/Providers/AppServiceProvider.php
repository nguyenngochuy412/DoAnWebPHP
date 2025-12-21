<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
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
        // Chỉ force HTTPS trong production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http'); // Thêm dòng này
        }

        Paginator::useBootstrapFive();
    }
}
