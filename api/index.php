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
        $tmpDir . '/logs',
    ];

    foreach ($folders as $folder) {
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    // Force environment for serverless
    putenv('VIEW_COMPILED_PATH=' . $tmpDir . '/framework/views');
    putenv('SESSION_DRIVER=cookie'); 
    putenv('LOG_CHANNEL=stderr');
    putenv('CACHE_STORE=array'); 
    putenv('APP_ENV=production');

    // Load Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // Boot Application Manually
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Attempt to resolve the app to ensure core services are registered
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    // Now handle the request
    $app->handleRequest(Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    // This will be caught by the global handler above if it rethrows,
    // but we can also handle it here for extra safety.
    throw $e;
}