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
        // Fix for Vercel persistence & Database
        if (env('VERCEL_URL') || env('APP_ENV') === 'production') {
            $config = [
                'view.compiled' => '/tmp/framework/views',
                'session.driver' => 'cookie',
                'cache.default' => 'array',
                'database.default' => 'pgsql',
            ];

            // Auto-configure Vercel Postgres if available
            if ($pgUrl = env('POSTGRES_URL')) {
                // Ensure sslmode=require for Vercel Postgres
                if (!str_contains($pgUrl, 'sslmode=')) {
                    $pgUrl .= (str_contains($pgUrl, '?') ? '&' : '?') . 'sslmode=require';
                }
                
                $config['database.connections.pgsql.url'] = $pgUrl;
            }

            config($config);
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
