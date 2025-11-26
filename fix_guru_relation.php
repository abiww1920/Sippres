<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Setup database connection
$capsule = new DB;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'sippres',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    echo "Memperbaiki relasi User-Guru...\n";
    
    // Update guru_id untuk user guru
    DB::table('users')
        ->where('username', 'guru')
        ->update(['guru_id' => 2]);
    
    // Update guru_id untuk user wali kelas
    DB::table('users')
        ->where('username', 'walikelas')
        ->update(['guru_id' => 1]);
    
    // Update guru_id untuk user konselor
    DB::table('users')
        ->where('username', 'konselor')
        ->update(['guru_id' => 3]);
    
    // Update guru_id untuk user kepala sekolah
    DB::table('users')
        ->where('username', 'kepsek')
        ->update(['guru_id' => 4]);
    
    echo "Relasi User-Guru berhasil diperbaiki!\n";
    
    // Verifikasi hasil
    $users = DB::table('users')
        ->whereIn('level', ['guru', 'wali_kelas', 'konselor', 'kepala_sekolah'])
        ->get(['username', 'level', 'guru_id']);
    
    echo "\nVerifikasi hasil:\n";
    foreach ($users as $user) {
        echo "- {$user->username} ({$user->level}): guru_id = {$user->guru_id}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}