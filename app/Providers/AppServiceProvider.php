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
                'database.connections.pgsql.port' => 5432,
            ];

            // Priority: Explicit $_ENV/$_SERVER > Vercel Linked Storage vars > Laravel env()
            $pgUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? env('DATABASE_URL');
            
            // Fallback to Vercel specific ones if DATABASE_URL is missing
            if (!$pgUrl) {
                $pgUrl = $_ENV['POSTGRES_URL_NON_POOLING'] ?? $_SERVER['POSTGRES_URL_NON_POOLING'] ?? env('POSTGRES_URL_NON_POOLING')
                      ?? $_ENV['POSTGRES_URL'] ?? $_SERVER['POSTGRES_URL'] ?? env('POSTGRES_URL');
            }

            if ($pgUrl) {
                // Normalize 'postgresql://' to 'postgres://' if needed
                if (str_starts_with($pgUrl, 'postgresql://')) {
                    $pgUrl = 'postgres://' . substr($pgUrl, 13);
                }

                // Ensure sslmode=require
                if (!str_contains($pgUrl, 'sslmode=')) {
                    $pgUrl .= (str_contains($pgUrl, '?') ? '&' : '?') . 'sslmode=require';
                }
                $config['database.connections.pgsql.url'] = $pgUrl;
            } elseif (env('POSTGRES_HOST')) {
                $config['database.connections.pgsql.host'] = env('POSTGRES_HOST');
                $config['database.connections.pgsql.database'] = env('POSTGRES_DATABASE', 'postgres');
                $config['database.connections.pgsql.username'] = env('POSTGRES_USER');
                $config['database.connections.pgsql.password'] = env('POSTGRES_PASSWORD');
                $config['database.connections.pgsql.port'] = env('POSTGRES_PORT', 5432);
                $config['database.connections.pgsql.sslmode'] = 'require';
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
