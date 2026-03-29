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

            // Priority: Non-pooling URL (Migration safe) > Standard URL > Individual vars
            $pgUrl = env('POSTGRES_URL_NON_POOLING') ?: env('POSTGRES_URL') ?: env('DATABASE_URL');

            if ($pgUrl) {
                // The 'Bulletproof' Neon Pattern: Break URL into individual parts
                // and inject endpoint into username to bypass SNI issues.
                $urlParts = parse_url($pgUrl);
                $host = $urlParts['host'] ?? '';
                $user = $urlParts['user'] ?? '';
                $pass = $urlParts['pass'] ?? '';
                $database = ltrim($urlParts['path'] ?? '', '/');
                $port = $urlParts['port'] ?? 5432;

                if (str_contains($host, 'neon.tech') && !str_contains($user, '$')) {
                    $endpoint = explode('.', $host)[0];
                    $user = $endpoint . '$' . $user;
                }

                $config['database.connections.pgsql.host'] = $host;
                $config['database.connections.pgsql.port'] = $port;
                $config['database.connections.pgsql.database'] = $database;
                $config['database.connections.pgsql.username'] = $user;
                $config['database.connections.pgsql.password'] = $pass;
                $config['database.connections.pgsql.sslmode'] = 'require';
                
                // CRITICAL: Unset 'url' to force Laravel to use individual keys above
                $config['database.connections.pgsql.url'] = null; 
            } elseif (env('POSTGRES_HOST')) {
                // Individual vars mode fallback
                $host = env('POSTGRES_HOST');
                $user = env('POSTGRES_USER');
                if (str_contains($host, 'neon.tech') && !str_contains($user, '$')) {
                    $endpoint = explode('.', $host)[0];
                    $user = $endpoint . '$' . $user;
                }
                
                $config['database.connections.pgsql.host'] = $host;
                $config['database.connections.pgsql.database'] = env('POSTGRES_DATABASE', 'verceldb');
                $config['database.connections.pgsql.username'] = $user;
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
