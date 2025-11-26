@echo off
echo Memperbaiki masalah input pelanggaran guru...
echo.

echo 1. Menjalankan migration...
php artisan migrate --force

echo.
echo 2. Menjalankan seeder untuk data guru...
php artisan db:seed --class=GuruSeeder --force

echo.
echo 3. Menjalankan seeder untuk data user...
php artisan db:seed --class=UserSeeder --force

echo.
echo 4. Memperbaiki guru_id untuk user yang sudah ada...
php artisan fix:guru-id

echo.
echo Perbaikan selesai! Sekarang guru bisa input data pelanggaran.
echo Login dengan:
echo - Username: guru, Password: guru123
echo - Username: walikelas, Password: walikelas123
pause