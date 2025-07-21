<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReferralService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the ReferralService
        $this->app->singleton(ReferralService::class, function ($app) {
            return new ReferralService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}