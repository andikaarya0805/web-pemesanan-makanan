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

            // High-Compatibility Manual Parsing for Supabase Pooler
            $targetUrl = getenv('DATABASE_URL') ?: ($_ENV['DATABASE_URL'] ?? ($_SERVER['DATABASE_URL'] ?? null));
            
            if ($targetUrl) {
                // Remove trailing slash to prevent empty database name
                $targetUrl = rtrim($targetUrl, '/');
                $components = parse_url($targetUrl);
                
                if (isset($components['host'])) {
                    config([
                        'database.default' => 'pgsql',
                        'database.connections.pgsql.host' => $components['host'],
                        'database.connections.pgsql.port' => $components['port'] ?? 5432,
                        'database.connections.pgsql.database' => ltrim($components['path'] ?? 'postgres', '/'),
                        'database.connections.pgsql.username' => isset($components['user']) ? urldecode($components['user']) : null,
                        'database.connections.pgsql.password' => isset($components['pass']) ? urldecode($components['pass']) : null,
                        'database.connections.pgsql.url' => null, // CRITICAL: Stop Laravel internal re-parsing
                        'database.connections.pgsql.schema' => 'public',
                        'database.connections.pgsql.search_path' => 'public',
                        'database.connections.pgsql.sslmode' => 'prefer',
                    ]);
                }
            }
        }
    }
}
