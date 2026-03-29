<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix for Laravel 11-13 core services on Vercel
        if (env('VERCEL_URL') || env('APP_ENV') === 'production') {
            Config::set('view.compiled', '/tmp/framework/views');
            Config::set('session.driver', 'cookie');
            Config::set('cache.default', 'array');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force Database Configuration late in the boot process for maximum reliability
        if (env('VERCEL_URL') || env('APP_ENV') === 'production' || env('DATABASE_URL')) {
            $this->applyDatabaseEnvironment();
        }
    }

    /**
     * Aggressive database detection and normalization for Supabase/Vercel
     */
    protected function applyDatabaseEnvironment(): void
    {
        // 1. Find the URL
        $pgUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? getenv('DATABASE_URL');
        
        // 2. Fallback to common Vercel/Neon variables if DATABASE_URL is missing
        if (!$pgUrl) {
            $pgUrl = $_ENV['POSTGRES_URL_NON_POOLING'] ?? $_SERVER['POSTGRES_URL_NON_POOLING'] 
                  ?? $_ENV['POSTGRES_URL'] ?? $_SERVER['POSTGRES_URL'] 
                  ?? getenv('POSTGRES_URL_NON_POOLING') 
                  ?? getenv('POSTGRES_URL');
        }

        if ($pgUrl) {
            // Normalize 'postgresql://' to 'postgres://' for PHP pdo_pgsql
            if (str_starts_with($pgUrl, 'postgresql://')) {
                $pgUrl = 'postgres://' . substr($pgUrl, 13);
            }

            // FORCE search_path=public for Supabase Pooler compatibility
            if (!str_contains($pgUrl, 'search_path=')) {
                $pgUrl .= (str_contains($pgUrl, '?') ? '&' : '?') . 'options=-csearch_path%3Dpublic';
            }

            // Ensure SSL is required
            if (!str_contains($pgUrl, 'sslmode=')) {
                $pgUrl .= '&sslmode=require';
            }

            // Apply overrides
            Config::set('database.default', 'pgsql');
            Config::set('database.connections.pgsql.url', $pgUrl);
            Config::set('database.connections.pgsql.search_path', 'public');
            Config::set('database.connections.pgsql.schema', 'public');
            Config::set('database.connections.pgsql.sslmode', 'require');
        } elseif (env('POSTGRES_HOST')) {
            // Discrete variable fallback
            Config::set('database.default', 'pgsql');
            Config::set('database.connections.pgsql.host', env('POSTGRES_HOST'));
            Config::set('database.connections.pgsql.database', env('POSTGRES_DATABASE', 'postgres'));
            Config::set('database.connections.pgsql.username', env('POSTGRES_USER'));
            Config::set('database.connections.pgsql.password', env('POSTGRES_PASSWORD'));
            Config::set('database.connections.pgsql.port', env('POSTGRES_PORT', 5432));
            Config::set('database.connections.pgsql.sslmode', 'require');
            Config::set('database.connections.pgsql.search_path', 'public');
        }
    }
}
