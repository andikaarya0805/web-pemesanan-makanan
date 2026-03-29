<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix for Vercel persistence
        if (env('VERCEL_URL')) {
            config([
                'view.compiled' => '/tmp/storage/framework/views',
                'session.driver' => 'cookie',
                'cache.default' => 'array',
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
