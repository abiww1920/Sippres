<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Setup database connection
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'db_pelanggaran',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "=== TEST STRUKTUR TABEL ===\n\n";

try {
    // Test pelanggaran table structure
    echo "TABEL PELANGGARAN:\n";
    $pelanggaranColumns = Capsule::select("SHOW COLUMNS FROM pelanggaran");
    foreach ($pelanggaranColumns as $column) {
        echo "- {$column->Field} ({$column->Type})\n";
    }
    
    echo "\nTABEL PRESTASI:\n";
    $prestasiColumns = Capsule::select("SHOW COLUMNS FROM prestasi");
    foreach ($prestasiColumns as $column) {
        echo "- {$column->Field} ({$column->Type})\n";
    }
    
    echo "\n=== TEST DATA SAMPLE ===\n\n";
    
    // Test sample pelanggaran data
    $samplePelanggaran = Capsule::table('pelanggaran')->limit(3)->get();
    echo "SAMPLE PELANGGARAN:\n";
    foreach ($samplePelanggaran as $item) {
        echo "- ID: {$item->id}, Siswa ID: {$item->siswa_id}, Created: {$item->created_at}\n";
    }
    
    // Test sample prestasi data
    $samplePrestasi = Capsule::table('prestasi')->limit(3)->get();
    echo "\nSAMPLE PRESTASI:\n";
    foreach ($samplePrestasi as $item) {
        $tanggal = $item->tanggal ?? 'NULL';
        echo "- ID: {$item->id}, Siswa ID: {$item->siswa_id}, Tanggal: {$tanggal}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";