<?php

// Test script for Supabase connection
$host = 'db.kqujatdfxlswyzjkshda.supabase.co';
$port = '6543';
$dbname = 'postgres';
$user = 'postgres.kqujatdfxlswyzjkshda';
$pass = 'KyaaaMancung';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";

try {
    echo "Connecting to $host:$port...\n";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "SUCCESS: Connected to database!\n";
    
    $stmt = $pdo->query("SELECT version()");
    echo "Database: " . $stmt->fetchColumn() . "\n";
    
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . count($tables) . "\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
} catch (PDOException $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
