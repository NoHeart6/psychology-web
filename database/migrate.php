<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Koneksi ke MongoDB
try {
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->psychology_web;
    echo "Terhubung ke MongoDB.\n";
} catch (Exception $e) {
    die("Gagal terhubung ke MongoDB: " . $e->getMessage() . "\n");
}

// Load semua file migrasi
$migrationFiles = glob(__DIR__ . '/migrations/*.php');
$migrations = [];

foreach ($migrationFiles as $file) {
    if (basename($file) === 'Migration.php') continue;
    
    require_once $file;
    $className = pathinfo($file, PATHINFO_FILENAME);
    $className = substr($className, 4); // Hapus angka dan underscore di depan
    $migrations[] = new $className($database);
}

// Fungsi untuk menjalankan migrasi
function runMigrations($migrations, $method) {
    foreach ($migrations as $migration) {
        try {
            echo "\nMenjalankan " . get_class($migration) . "::$method...\n";
            $migration->$method();
            echo "Selesai.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}

// Parse argumen command line
$action = isset($argv[1]) ? strtolower($argv[1]) : 'up';

switch ($action) {
    case 'up':
        echo "Menjalankan migrasi...\n";
        runMigrations($migrations, 'up');
        break;
        
    case 'down':
        echo "Membatalkan migrasi...\n";
        runMigrations(array_reverse($migrations), 'down');
        break;
        
    case 'refresh':
        echo "Menyegarkan database...\n";
        runMigrations(array_reverse($migrations), 'down');
        runMigrations($migrations, 'up');
        break;
        
    default:
        echo "Penggunaan: php migrate.php [up|down|refresh]\n";
        exit(1);
} 