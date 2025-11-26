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

try {
    echo "Memulai perbaikan guru_id untuk users...\n";
    
    // Update user guru dengan guru_id dari tabel guru
    $guruUser = Capsule::table('users')->where('level', 'guru')->first();
    if ($guruUser) {
        $guru = Capsule::table('guru')->where('level', 'guru')->first();
        if ($guru) {
            Capsule::table('users')
                ->where('level', 'guru')
                ->update(['guru_id' => $guru->id]);
            echo "✓ User guru berhasil diupdate dengan guru_id: {$guru->id}\n";
        }
    }
    
    // Update user wali_kelas dengan guru_id dari tabel guru
    $waliKelasUser = Capsule::table('users')->where('level', 'wali_kelas')->first();
    if ($waliKelasUser) {
        $waliKelas = Capsule::table('guru')->where('level', 'wali_kelas')->first();
        if ($waliKelas) {
            Capsule::table('users')
                ->where('level', 'wali_kelas')
                ->update(['guru_id' => $waliKelas->id]);
            echo "✓ User wali_kelas berhasil diupdate dengan guru_id: {$waliKelas->id}\n";
        }
    }
    
    // Update user konselor dengan guru_id dari tabel guru
    $konselorUser = Capsule::table('users')->where('level', 'konselor')->first();
    if ($konselorUser) {
        $konselor = Capsule::table('guru')->where('level', 'konselor')->first();
        if ($konselor) {
            Capsule::table('users')
                ->where('level', 'konselor')
                ->update(['guru_id' => $konselor->id]);
            echo "✓ User konselor berhasil diupdate dengan guru_id: {$konselor->id}\n";
        }
    }
    
    // Update user kepala_sekolah dengan guru_id dari tabel guru
    $kepsekUser = Capsule::table('users')->where('level', 'kepala_sekolah')->first();
    if ($kepsekUser) {
        $kepsek = Capsule::table('guru')->where('level', 'kepala_sekolah')->first();
        if ($kepsek) {
            Capsule::table('users')
                ->where('level', 'kepala_sekolah')
                ->update(['guru_id' => $kepsek->id]);
            echo "✓ User kepala_sekolah berhasil diupdate dengan guru_id: {$kepsek->id}\n";
        }
    }
    
    echo "\nPerbaikan selesai! Sekarang guru bisa input data pelanggaran.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}