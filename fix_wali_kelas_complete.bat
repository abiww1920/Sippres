@echo off
echo ========================================
echo MEMPERBAIKI MASALAH WALI KELAS
echo ========================================

cd /d "c:\xampp\htdocs\UjikomAbi"

echo.
echo 1. Menjalankan ulang seeder untuk memperbaiki data...
php artisan db:seed --class=GuruSeeder --force
php artisan db:seed --class=KelasSeeder --force
php artisan db:seed --class=UserSeeder --force

echo.
echo 2. Memeriksa data yang telah dibuat...
echo.
echo Data Guru Handi Radiman:
php artisan tinker --execute="echo App\Models\Guru::where('nip', '198501012010011005')->first();"

echo.
echo Data Kelas:
php artisan tinker --execute="echo App\Models\Kelas::with('waliKelas')->get();"

echo.
echo ========================================
echo SELESAI! 
echo ========================================
echo.
echo Login sebagai wali kelas:
echo Username: handi
echo Password: handi123
echo.
echo Atau gunakan user wali kelas yang sudah ada:
echo Username: walikelas  
echo Password: walikelas123
echo.
pause