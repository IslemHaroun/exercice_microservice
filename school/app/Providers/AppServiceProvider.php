<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConsulService;

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
        ConsulService::registerService(
            'student-service', 
            'student-service-id',
            8001,
            'student',
            'http://student:8001/health'
        );
    }
}