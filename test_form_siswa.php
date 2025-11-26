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

echo "=== TEST FORM TAMBAH SISWA ===\n\n";

// Simulate form data
$formData = [
    'nis' => 'TEST' . time(),
    'nama_siswa' => 'Test Siswa Form',
    'kelas_id' => 1,
    'jenis_kelamin' => 'L',
    'alamat' => 'Jl. Test No. 123',
    'no_hp' => '081234567890',
    'nama_ortu' => 'Test Orang Tua',
    'no_hp_ortu' => '081234567891',
    'status' => 'aktif'
];

echo "Data yang akan diinsert:\n";
foreach ($formData as $key => $value) {
    echo "- {$key}: {$value}\n";
}

try {
    echo "\n1. Cek apakah kelas_id valid:\n";
    $kelas = Capsule::table('kelas')->where('id', $formData['kelas_id'])->first();
    if ($kelas) {
        echo "✓ Kelas ditemukan: {$kelas->nama_kelas}\n";
    } else {
        echo "✗ Kelas tidak ditemukan!\n";
        // Get available kelas
        $availableKelas = Capsule::table('kelas')->get();
        echo "Kelas yang tersedia:\n";
        foreach ($availableKelas as $k) {
            echo "  - ID: {$k->id}, Nama: {$k->nama_kelas}\n";
        }
        if ($availableKelas->count() > 0) {
            $formData['kelas_id'] = $availableKelas->first()->id;
            echo "Menggunakan kelas ID: {$formData['kelas_id']}\n";
        }
    }
    
    echo "\n2. Cek apakah NIS sudah ada:\n";
    $existingNis = Capsule::table('siswa')->where('nis', $formData['nis'])->first();
    if ($existingNis) {
        echo "✗ NIS sudah ada!\n";
        $formData['nis'] = 'TEST' . time() . rand(100, 999);
        echo "Menggunakan NIS baru: {$formData['nis']}\n";
    } else {
        echo "✓ NIS tersedia\n";
    }
    
    echo "\n3. Insert data siswa:\n";
    $formData['created_at'] = date('Y-m-d H:i:s');
    $formData['updated_at'] = date('Y-m-d H:i:s');
    
    $insertId = Capsule::table('siswa')->insertGetId($formData);
    echo "✓ Insert berhasil! ID: {$insertId}\n";
    
    echo "\n4. Verifikasi data yang diinsert:\n";
    $insertedData = Capsule::table('siswa')->where('id', $insertId)->first();
    echo "- ID: {$insertedData->id}\n";
    echo "- NIS: {$insertedData->nis}\n";
    echo "- Nama: {$insertedData->nama_siswa}\n";
    echo "- Kelas ID: {$insertedData->kelas_id}\n";
    echo "- Status: {$insertedData->status}\n";
    echo "- Created: {$insertedData->created_at}\n";
    
    echo "\n5. Cek total siswa sekarang:\n";
    $totalSiswa = Capsule::table('siswa')->count();
    echo "Total siswa: {$totalSiswa}\n";
    
    // Clean up
    echo "\n6. Hapus data test:\n";
    Capsule::table('siswa')->where('id', $insertId)->delete();
    echo "✓ Data test berhasil dihapus\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== SELESAI ===\n";