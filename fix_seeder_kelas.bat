@echo off
echo Menjalankan seeder untuk memperbaiki data kelas...

cd /d "c:\xampp\htdocs\UjikomAbi"

echo.
echo 1. Menjalankan KelasSeeder...
php artisan db:seed --class=KelasSeeder

echo.
echo 2. Menjalankan SiswaSeeder jika diperlukan...
php artisan db:seed --class=SiswaSeeder

echo.
echo Selesai! Silakan cek dashboard wali kelas sekarang.
pause