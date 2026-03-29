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
     * Set database configuration using discrete keys to avoid array_diff_key errors.
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

            // Parse URL manually to set discrete keys
            $parts = parse_url($pgUrl);
            if ($parts) {
                Config::set('database.default', 'pgsql');
                Config::set('database.connections.pgsql.host', $parts['host'] ?? null);
                Config::set('database.connections.pgsql.port', $parts['port'] ?? 5432);
                Config::set('database.connections.pgsql.database', ltrim($parts['path'] ?? '', '/'));
                Config::set('database.connections.pgsql.username', $parts['user'] ?? null);
                Config::set('database.connections.pgsql.password', isset($parts['pass']) ? urldecode($parts['pass']) : null);
                
                // Force schema and sslmode
                Config::set('database.connections.pgsql.schema', 'public');
                Config::set('database.connections.pgsql.search_path', 'public');
                Config::set('database.connections.pgsql.sslmode', 'require');
                
                // CRITICAL: Set url to null to prevent Laravel from trying to re-parse it and causing TypeError
                Config::set('database.connections.pgsql.url', null);
            }
        }
    }
}
