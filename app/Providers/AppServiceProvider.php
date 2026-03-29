<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
     * Parse DATABASE_URL manually and set individual config values 
     * to avoid Laravel's URL parser conflicting with array_diff_key.
     */
    protected function applyDatabaseEnvironment(): void
    {
        // Find the URL from all possible sources
        $pgUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? getenv('DATABASE_URL') ?: null;
        
        if (!$pgUrl) {
            $pgUrl = $_ENV['POSTGRES_URL_NON_POOLING'] ?? $_SERVER['POSTGRES_URL_NON_POOLING'] 
                  ?? $_ENV['POSTGRES_URL'] ?? $_SERVER['POSTGRES_URL'] 
                  ?? getenv('POSTGRES_URL_NON_POOLING') 
                  ?: getenv('POSTGRES_URL');
        }

        Config::set('database.default', 'pgsql');

        if ($pgUrl) {
            // Normalize postgresql:// to pgsql compatible format
            if (str_starts_with($pgUrl, 'postgresql://')) {
                $pgUrl = 'postgres://' . substr($pgUrl, 13);
            }

            // Parse the URL ourselves to avoid Laravel connector issues
            $parts = parse_url($pgUrl);

            Config::set('database.connections.pgsql.host', $parts['host'] ?? '127.0.0.1');
            Config::set('database.connections.pgsql.port', $parts['port'] ?? 5432);
            Config::set('database.connections.pgsql.database', ltrim($parts['path'] ?? '/postgres', '/'));
            Config::set('database.connections.pgsql.username', $parts['user'] ?? 'postgres');
            Config::set('database.connections.pgsql.password', urldecode($parts['pass'] ?? ''));
            Config::set('database.connections.pgsql.sslmode', 'require');
            Config::set('database.connections.pgsql.search_path', 'public');
            
            // Remove URL key to prevent Laravel from re-parsing it
            Config::set('database.connections.pgsql.url', null);

        } elseif (env('POSTGRES_HOST')) {
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
