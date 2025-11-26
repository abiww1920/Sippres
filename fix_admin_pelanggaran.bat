@echo off
echo ========================================
echo PERBAIKAN SISTEM ADMIN PELANGGARAN
echo ========================================

echo.
echo 1. Menjalankan debug untuk mengecek masalah...
php debug_admin_pelanggaran.php

echo.
echo 2. Menjalankan seeder jenis pelanggaran...
php artisan db:seed --class=JenisPelanggaranSeeder

echo.
echo 3. Menjalankan seeder data pelanggaran...
php artisan db:seed --class=PelanggaranSeeder

echo.
echo 4. Clearing cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo.
echo 5. Mengecek hasil perbaikan...
php artisan tinker --execute="
echo '=== HASIL PERBAIKAN ===';
echo 'Total Jenis Pelanggaran: ' . App\Models\JeniPelanggaran::count();
echo 'Total Pelanggaran: ' . App\Models\Pelanggaran::count();
echo '';
echo 'Status Verifikasi:';
echo '- Menunggu: ' . App\Models\Pelanggaran::where('status_verifikasi', 'menunggu')->count();
echo '- Diverifikasi: ' . App\Models\Pelanggaran::where('status_verifikasi', 'diverifikasi')->count();
echo '- Ditolak: ' . App\Models\Pelanggaran::where('status_verifikasi', 'ditolak')->count();
echo '- Revisi: ' . App\Models\Pelanggaran::where('status_verifikasi', 'revisi')->count();
echo '';
echo 'Admin User: ' . (App\Models\User::where('level', 'admin')->exists() ? 'EXISTS' : 'NOT FOUND');
"

echo.
echo ========================================
echo PERBAIKAN SELESAI!
echo.
echo CARA LOGIN:
echo 1. Buka: http://localhost/UjikomAbi/public/login
echo 2. Username: admin
echo 3. Password: admin123
echo 4. Setelah login, buka dashboard admin
echo.
echo YANG SUDAH DIPERBAIKI:
echo - Data jenis pelanggaran sudah ada
echo - Data pelanggaran sample sudah ada
echo - Dashboard admin akan menampilkan data
echo - Semua status verifikasi tersedia
echo ========================================
pause