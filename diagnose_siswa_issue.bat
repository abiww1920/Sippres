@echo off
echo ========================================
echo    DIAGNOSA MASALAH TAMBAH SISWA
echo ========================================
echo.

echo 1. Menjalankan debug database...
php debug_tambah_siswa.php
echo.

echo 2. Menjalankan test form...
php test_form_siswa.php
echo.

echo 3. Cek log Laravel...
if exist "storage\logs\laravel.log" (
    echo === LOG TERAKHIR ===
    powershell "Get-Content 'storage\logs\laravel.log' -Tail 20"
) else (
    echo Log file tidak ditemukan
)

echo.
echo 4. Cek permission folder uploads...
if exist "public\uploads\siswa" (
    echo ✓ Folder uploads/siswa ada
    dir "public\uploads\siswa" /b
) else (
    echo ✗ Folder uploads/siswa tidak ada
    mkdir "public\uploads\siswa"
    echo ✓ Folder uploads/siswa dibuat
)

echo.
echo ========================================
echo           DIAGNOSA SELESAI
echo ========================================
echo.
echo Jika masih ada masalah, coba:
echo 1. Cek browser console untuk error JavaScript
echo 2. Cek network tab untuk melihat response server
echo 3. Pastikan form action URL benar
echo 4. Cek apakah CSRF token valid
echo.
pause