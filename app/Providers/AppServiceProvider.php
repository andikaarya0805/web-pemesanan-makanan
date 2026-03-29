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
        if (env('VERCEL_URL')) {
            $config = [
                'view.compiled' => '/tmp/storage/framework/views',
                'session.driver' => 'cookie',
                'cache.default' => 'array',
            ];

            // Auto-configure Vercel Postgres if available
            if ($pgUrl = env('POSTGRES_URL')) {
                $config['database.default'] = 'pgsql';
                
                // Ensure sslmode=require if not specifically disabled
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
