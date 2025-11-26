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

echo "=== DEBUG TAMBAH SISWA ===\n\n";

try {
    // 1. Cek struktur tabel siswa
    echo "1. STRUKTUR TABEL SISWA:\n";
    $columns = Capsule::select("SHOW COLUMNS FROM siswa");
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type}) " . ($column->Null == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
    }
    
    echo "\n2. JUMLAH DATA SISWA SAAT INI:\n";
    $totalSiswa = Capsule::table('siswa')->count();
    echo "Total siswa: {$totalSiswa}\n";
    
    echo "\n3. DATA SISWA TERAKHIR (5 data):\n";
    $lastSiswa = Capsule::table('siswa')->orderBy('id', 'desc')->limit(5)->get();
    foreach ($lastSiswa as $siswa) {
        echo "- ID: {$siswa->id}, NIS: {$siswa->nis}, Nama: {$siswa->nama_siswa}, Created: {$siswa->created_at}\n";
    }
    
    echo "\n4. CEK KELAS YANG TERSEDIA:\n";
    $kelas = Capsule::table('kelas')->get();
    foreach ($kelas as $k) {
        echo "- ID: {$k->id}, Nama: {$k->nama_kelas}\n";
    }
    
    echo "\n5. CEK JURUSAN YANG TERSEDIA:\n";
    $jurusan = Capsule::table('jurusan')->get();
    foreach ($jurusan as $j) {
        echo "- ID: {$j->id}, Nama: {$j->nama_jurusan}\n";
    }
    
    echo "\n6. TEST INSERT SISWA BARU:\n";
    $testData = [
        'nis' => 'TEST' . time(),
        'nama_siswa' => 'Test Siswa Debug',
        'kelas_id' => 1, // Assuming kelas with id 1 exists
        'jenis_kelamin' => 'L',
        'alamat' => 'Test Alamat',
        'nama_ortu' => 'Test Orang Tua',
        'status' => 'aktif',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $insertId = Capsule::table('siswa')->insertGetId($testData);
    echo "Test insert berhasil! ID: {$insertId}\n";
    
    // Verify the insert
    $insertedSiswa = Capsule::table('siswa')->where('id', $insertId)->first();
    echo "Verifikasi: NIS = {$insertedSiswa->nis}, Nama = {$insertedSiswa->nama_siswa}\n";
    
    echo "\n7. JUMLAH DATA SISWA SETELAH TEST INSERT:\n";
    $newTotalSiswa = Capsule::table('siswa')->count();
    echo "Total siswa sekarang: {$newTotalSiswa}\n";
    
    // Clean up test data
    Capsule::table('siswa')->where('id', $insertId)->delete();
    echo "Test data berhasil dihapus.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== SELESAI ===\n";