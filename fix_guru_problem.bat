@echo off
echo ========================================
echo MEMPERBAIKI MASALAH GURU INPUT PELANGGARAN
echo ========================================
echo.

echo 1. Menjalankan fresh migration dan seeder...
php artisan migrate:fresh --seed

echo.
echo 2. Memperbaiki relasi User-Guru...
php fix_guru_relation.php

echo.
echo 3. Membersihkan cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo.
echo ========================================
echo PERBAIKAN SELESAI!
echo ========================================
echo.
echo Sekarang guru sudah bisa input pelanggaran siswa.
echo Login dengan:
echo - Username: guru
echo - Password: guru123
echo.
pause