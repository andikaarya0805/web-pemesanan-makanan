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
        if (env('VERCEL_URL') || env('APP_ENV') === 'production' || env('DATABASE_URL')) {
            $this->applyDatabaseEnvironment();
        }
    }

    /**
     * Set database configuration using URL only to avoid array configuration conflicts on Vercel.
     */
    protected function applyDatabaseEnvironment(): void
    {
        $pgUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? getenv('DATABASE_URL') ?: null;
        
        if (!$pgUrl) {
            $pgUrl = $_ENV['POSTGRES_URL'] ?? $_SERVER['POSTGRES_URL'] ?? getenv('POSTGRES_URL');
        }

        if ($pgUrl) {
            // Normalize postgresql -> postgres
            if (str_starts_with($pgUrl, 'postgresql://')) {
                $pgUrl = 'postgres://' . substr($pgUrl, 13);
            }

            // Force search_path=public directly in the URL string
            // This is the most reliable way for Supabase Transaction Poolers
            if (!str_contains($pgUrl, 'search_path=')) {
                $separator = str_contains($pgUrl, '?') ? '&' : '?';
                $pgUrl .= $separator . 'options=-csearch_path%3Dpublic';
            }

            // Ensure SSL
            if (!str_contains($pgUrl, 'sslmode=')) {
                $pgUrl .= '&sslmode=require';
            }

            Config::set('database.default', 'pgsql');
            Config::set('database.connections.pgsql.url', $pgUrl);
            
            // Clear all discrete keys to prevent any merging/conflict issues
            Config::set('database.connections.pgsql.host', null);
            Config::set('database.connections.pgsql.port', null);
            Config::set('database.connections.pgsql.database', null);
            Config::set('database.connections.pgsql.username', null);
            Config::set('database.connections.pgsql.password', null);
        }
    }
}
