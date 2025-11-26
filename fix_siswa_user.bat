@echo off
echo Memperbaiki relasi User-Siswa...
echo.

echo 1. Menjalankan migration...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Migration gagal!
    pause
    exit /b 1
)
echo Migration berhasil!
echo.

echo 2. Menjalankan seeder sinkronisasi...
php artisan db:seed --class=SinkronisasiUserSiswaSeeder
if %errorlevel% neq 0 (
    echo ERROR: Seeder gagal!
    pause
    exit /b 1
)
echo Seeder berhasil!
echo.

echo Selesai! Relasi User-Siswa sudah diperbaiki.
echo.
pause