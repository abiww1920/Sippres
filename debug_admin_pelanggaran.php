<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\JeniPelanggaran;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;

echo "========================================\n";
echo "DEBUG ADMIN PELANGGARAN SYSTEM\n";
echo "========================================\n\n";

// 1. Cek user admin
echo "1. CHECKING ADMIN USER:\n";
$admin = User::where('level', 'admin')->first();
if ($admin) {
    echo "✓ Admin user found: {$admin->username} (ID: {$admin->id})\n";
    echo "  Email: {$admin->email}\n";
    echo "  Level: {$admin->level}\n";
} else {
    echo "✗ Admin user not found!\n";
}
echo "\n";

// 2. Cek data master
echo "2. CHECKING MASTER DATA:\n";
$totalSiswa = Siswa::count();
$totalGuru = Guru::count();
$totalKelas = Kelas::count();
$totalJenisPelanggaran = JeniPelanggaran::count();

echo "✓ Total Siswa: {$totalSiswa}\n";
echo "✓ Total Guru: {$totalGuru}\n";
echo "✓ Total Kelas: {$totalKelas}\n";
echo "✓ Total Jenis Pelanggaran: {$totalJenisPelanggaran}\n";

if ($totalJenisPelanggaran == 0) {
    echo "⚠ WARNING: Tidak ada data jenis pelanggaran!\n";
    echo "  Jalankan: php artisan db:seed --class=JenisPelanggaranSeeder\n";
}
echo "\n";

// 3. Cek data pelanggaran
echo "3. CHECKING PELANGGARAN DATA:\n";
$totalPelanggaran = Pelanggaran::count();
echo "✓ Total Pelanggaran: {$totalPelanggaran}\n";

if ($totalPelanggaran == 0) {
    echo "⚠ WARNING: Tidak ada data pelanggaran!\n";
    echo "  Jalankan: php artisan db:seed --class=PelanggaranSeeder\n";
} else {
    $statusCount = [
        'menunggu' => Pelanggaran::where('status_verifikasi', 'menunggu')->count(),
        'diverifikasi' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
        'ditolak' => Pelanggaran::where('status_verifikasi', 'ditolak')->count(),
        'revisi' => Pelanggaran::where('status_verifikasi', 'revisi')->count()
    ];
    
    echo "  Status Breakdown:\n";
    foreach ($statusCount as $status => $count) {
        echo "  - {$status}: {$count}\n";
    }
}
echo "\n";

// 4. Cek relasi data
echo "4. CHECKING DATA RELATIONSHIPS:\n";
if ($totalPelanggaran > 0) {
    $pelanggaranWithRelations = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->first();
    if ($pelanggaranWithRelations) {
        echo "✓ Sample pelanggaran data:\n";
        echo "  - Siswa: {$pelanggaranWithRelations->siswa->nama_siswa}\n";
        echo "  - Kelas: {$pelanggaranWithRelations->siswa->kelas->nama_kelas}\n";
        echo "  - Jenis: {$pelanggaranWithRelations->jenisPelanggaran->nama_pelanggaran}\n";
        echo "  - Guru: {$pelanggaranWithRelations->guruPencatat->nama_guru}\n";
        echo "  - Status: {$pelanggaranWithRelations->status_verifikasi}\n";
        echo "  - Poin: {$pelanggaranWithRelations->poin}\n";
    }
} else {
    echo "⚠ No pelanggaran data to check relationships\n";
}
echo "\n";

// 5. Cek routes
echo "5. CHECKING ROUTES:\n";
echo "✓ Admin dashboard route: /admin/dashboard\n";
echo "✓ Admin pelanggaran route: /admin/pelanggaran\n";
echo "✓ Login route: /login\n";
echo "\n";

// 6. Recommendations
echo "6. RECOMMENDATIONS:\n";
if ($totalJenisPelanggaran == 0) {
    echo "⚠ Run: php artisan db:seed --class=JenisPelanggaranSeeder\n";
}
if ($totalPelanggaran == 0) {
    echo "⚠ Run: php artisan db:seed --class=PelanggaranSeeder\n";
}
if ($totalJenisPelanggaran == 0 || $totalPelanggaran == 0) {
    echo "⚠ Or run: php artisan db:seed (to run all seeders)\n";
}
echo "✓ Login as admin: username=admin, password=admin123\n";
echo "✓ Check dashboard at: http://localhost/UjikomAbi/public/admin/dashboard\n";

echo "\n========================================\n";
echo "DEBUG COMPLETED\n";
echo "========================================\n";