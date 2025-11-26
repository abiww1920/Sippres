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

echo "=== MENAMBAHKAN FOTO SAMPLE KE SISWA ===\n\n";

try {
    // Sample foto names (you can add more)
    $samplePhotos = [
        'sample_student_1.jpg',
        'sample_student_2.jpg', 
        'sample_student_3.jpg',
        'default_avatar.png'
    ];
    
    // Get all siswa without photos
    $siswaList = Capsule::table('siswa')->whereNull('foto')->get();
    
    $updated = 0;
    foreach ($siswaList as $siswa) {
        // Randomly assign a sample photo
        $randomPhoto = $samplePhotos[array_rand($samplePhotos)];
        
        Capsule::table('siswa')
            ->where('id', $siswa->id)
            ->update(['foto' => $randomPhoto]);
        
        echo "Foto '{$randomPhoto}' ditambahkan untuk siswa: {$siswa->nama_siswa} (NIS: {$siswa->nis})\n";
        $updated++;
    }
    
    echo "\n=== SELESAI ===\n";
    echo "Total siswa yang diupdate: {$updated}\n";
    
    // Show current status
    $totalSiswa = Capsule::table('siswa')->count();
    $siswaWithPhoto = Capsule::table('siswa')->whereNotNull('foto')->count();
    
    echo "\nStatus saat ini:\n";
    echo "- Total siswa: {$totalSiswa}\n";
    echo "- Siswa dengan foto: {$siswaWithPhoto}\n";
    echo "- Siswa tanpa foto: " . ($totalSiswa - $siswaWithPhoto) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}