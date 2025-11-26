@echo off
echo ========================================
echo SETUP DATA PELANGGARAN UNTUK ADMIN
echo ========================================

echo.
echo 1. Menjalankan seeder jenis pelanggaran...
php artisan db:seed --class=JenisPelanggaranSeeder

echo.
echo 2. Menjalankan seeder data pelanggaran...
php artisan db:seed --class=PelanggaranSeeder

echo.
echo 3. Mengecek data yang berhasil dibuat...
php artisan tinker --execute="
echo 'Total Jenis Pelanggaran: ' . App\Models\JeniPelanggaran::count();
echo 'Total Pelanggaran: ' . App\Models\Pelanggaran::count();
echo 'Status Verifikasi:';
echo '- Menunggu: ' . App\Models\Pelanggaran::where('status_verifikasi', 'menunggu')->count();
echo '- Diverifikasi: ' . App\Models\Pelanggaran::where('status_verifikasi', 'diverifikasi')->count();
echo '- Ditolak: ' . App\Models\Pelanggaran::where('status_verifikasi', 'ditolak')->count();
echo '- Revisi: ' . App\Models\Pelanggaran::where('status_verifikasi', 'revisi')->count();
"

echo.
echo ========================================
echo SETUP SELESAI!
echo Silakan login sebagai admin dan cek dashboard
echo Username: admin
echo Password: admin123
echo ========================================
pause