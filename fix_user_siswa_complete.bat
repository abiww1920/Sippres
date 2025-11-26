@echo off
echo ========================================
echo    PERBAIKAN LENGKAP USER-SISWA
echo ========================================
echo.

echo 1. Checking current status...
php check_user_siswa_sync.php
echo.

echo 2. Running migration (if needed)...
php artisan migrate
echo.

echo 3. Running user-siswa synchronization...
php artisan db:seed --class=SinkronisasiUserSiswaSeeder
echo.

echo 4. Checking final status...
php check_user_siswa_sync.php
echo.

echo ========================================
echo           PERBAIKAN SELESAI
echo ========================================
pause