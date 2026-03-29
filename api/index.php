<?php

/**
 * NutriBox - Vercel Deep Probe & Entry Point
 * This script is designed to bypass standard error handlers 
 * and reveal the primary exception causing the 500 error.
 */

// 1. Absolute earliest error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Global exception handler for RAW output
set_exception_handler(function ($e) {
    header('Content-Type: text/html', true, 500);
    echo "<h1>RAW Emergency Debug - NutriBox</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Class:</strong> " . get_class($e) . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<h3>Environment Context:</h3>";
    echo "<ul>";
    echo "<li>PHP Version: " . PHP_VERSION . "</li>";
    echo "<li>APP_KEY Set: " . (getenv('APP_KEY') ? 'Yes' : 'No') . "</li>";
    echo "<li>DB_CONNECTION: " . getenv('DB_CONNECTION') . "</li>";
    
    $pgUrl = $_ENV['DATABASE_URL'] ?? $_SERVER['DATABASE_URL'] ?? getenv('DATABASE_URL') ?? getenv('POSTGRES_URL');
    $maskedUrl = preg_replace('/:[^@\/]+@/', ':****@', $pgUrl);
    echo "<li>Detected PG URL: " . ($pgUrl ? "Yes (<code>$maskedUrl</code>)" : "None") . "</li>";
    echo "</ul>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
});

try {
    $tmpDir = '/tmp';
    $folders = [
        $tmpDir . '/app/public',
        $tmpDir . '/framework/cache/data',
        $tmpDir . '/framework/sessions',
        $tmpDir . '/framework/testing',
        $tmpDir . '/framework/views',
        $tmpDir . '/bootstrap/cache',
        $tmpDir . '/logs',
    ];

    foreach ($folders as $folder) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    // Force environment variables for writable cache paths (Laravel 11-13)
    putenv('APP_SERVICES_CACHE=' . $tmpDir . '/bootstrap/cache/services.php');
    putenv('APP_PACKAGES_CACHE=' . $tmpDir . '/bootstrap/cache/packages.php');
    putenv('APP_CONFIG_CACHE=' . $tmpDir . '/bootstrap/cache/config.php');
    putenv('APP_ROUTES_CACHE=' . $tmpDir . '/bootstrap/cache/routes.php');
    putenv('APP_EVENTS_CACHE=' . $tmpDir . '/bootstrap/cache/events.php');
    
    // Legacy / general overrides
    putenv('VIEW_COMPILED_PATH=' . $tmpDir . '/framework/views');
    putenv('SESSION_DRIVER=cookie'); 
    putenv('LOG_CHANNEL=stderr');
    putenv('CACHE_STORE=array'); 
    putenv('APP_ENV=production');
    putenv('DB_CONNECTION=pgsql');
    putenv('DB_PORT=5432');

    // Load Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // Boot Application
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Explicitly set storage path to /tmp
    $app->useStoragePath($tmpDir);

    // Now handle the request using the standard Kernel flow for stability
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    
    $response->send();
    
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    // This will be caught by the global handler above if it rethrows,
    // but we can also handle it here for extra safety.
    throw $e;
}