@echo off
echo ========================================
echo IMPORT DATABASE SIPPRES (No Password)
echo ========================================
echo.

REM Pastikan XAMPP MySQL berjalan
echo Checking MySQL service...
net start | find "MySQL" >nul
if errorlevel 1 (
    echo MySQL service tidak berjalan. Silakan start XAMPP MySQL terlebih dahulu.
    pause
    exit /b 1
)

echo MySQL service sudah berjalan.
echo.

REM Buat database jika belum ada
echo Creating database 'sippres' if not exists...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sippres CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if errorlevel 1 (
    echo Gagal membuat database. Periksa koneksi MySQL.
    pause
    exit /b 1
)

echo Database 'sippres' berhasil dibuat/sudah ada.
echo.

REM Import file SQL
echo Importing sippres.sql...
mysql -u root sippres < public\sippres.sql

if errorlevel 1 (
    echo Gagal mengimpor database.
    pause
    exit /b 1
)

echo.
echo ========================================
echo DATABASE BERHASIL DIIMPOR!
echo ========================================
echo.
echo Database: sippres
echo File: public\sippres.sql
echo.
echo Akun login yang tersedia:
echo - Admin: admin / password
echo - Kesiswaan: kesiswaan / password  
echo - Guru: guru / password
echo - Wali Kelas: walikelas / password
echo - Konselor: konselor / password
echo - Kepala Sekolah: kepsek / password
echo - Siswa: siswa / password
echo - Orang Tua: ortu / password
echo.
pause