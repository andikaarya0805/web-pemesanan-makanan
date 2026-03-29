<?php

/**
 * Entry point for Vercel Serverless Function
 */

// Enable error reporting for emergency debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Setup temporary storage for Vercel read-only filesystem
    $tmpDir = '/tmp';
    
    // Subdirectories required for Laravel storage
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

    // Force environment variables for serverless compatibility
    putenv('VIEW_COMPILED_PATH=' . $tmpDir . '/framework/views');
    putenv('SESSION_DRIVER=cookie'); 
    putenv('LOG_CHANNEL=stderr');
    putenv('CACHE_STORE=array'); // Simplest for serverless if not using shared cache
    
    // Ensure we tell Laravel about our environment
    putenv('APP_ENV=production');

    // Proceed with Laravel bootstrap
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "<h1>NutriBox Emergency Debug</h1>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}