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
                // Neon Authentication Pattern: Prefix username with endpoint ID (endpoint$user)
                // This avoids SNI issues and the 'options' TypeError in Laravel/Connector.php
                $urlParts = parse_url($pgUrl);
                $host = $urlParts['host'] ?? '';
                $user = $urlParts['user'] ?? '';
                
                if (str_contains($host, 'neon.tech')) {
                    $endpoint = explode('.', $host)[0];
                    if (!str_contains($user, '$')) {
                        $newUser = $endpoint . '$' . $user;
                        $pgUrl = str_replace($user . ':', $newUser . ':', $pgUrl);
                    }
                }

                // Force sslmode=require
                if (!str_contains($pgUrl, 'sslmode=')) {
                    $pgUrl .= (str_contains($pgUrl, '?') ? '&' : '?') . 'sslmode=require';
                }
                
                $config['database.connections.pgsql.url'] = $pgUrl;
            } elseif (env('POSTGRES_HOST')) {
                // ... individual vars mode (Neon Pattern)
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
