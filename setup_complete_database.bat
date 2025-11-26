@echo off
echo ========================================
echo SETUP LENGKAP DATABASE SIPPRES
echo ========================================
echo.

REM Import database terlebih dahulu
call import_database_no_password.bat

if errorlevel 1 (
    echo Gagal mengimpor database.
    pause
    exit /b 1
)

echo.
echo ========================================
echo MENJALANKAN SEEDER LARAVEL
echo ========================================
echo.

REM Jalankan seeder untuk data sample
echo Running database seeders...
php artisan db:seed --class=GuruSeeder
php artisan db:seed --class=JurusanSeeder  
php artisan db:seed --class=KelasSeeder
php artisan db:seed --class=SiswaSeeder
php artisan db:seed --class=JeniSanksiSeeder
php artisan db:seed --class=PrestasiSeeder

echo.
echo ========================================
echo SETUP DATABASE SELESAI!
echo ========================================
echo.
echo Database telah diimpor dan diisi dengan data sample.
echo Anda dapat langsung menggunakan aplikasi.
echo.
pause