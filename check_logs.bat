@echo off
echo ========================================
echo       CEK LOG LARAVEL
echo ========================================
echo.

echo Menampilkan 50 baris terakhir dari log Laravel...
echo.

if exist "storage\logs\laravel.log" (
    echo === LOG LARAVEL ===
    powershell "Get-Content 'storage\logs\laravel.log' -Tail 50"
) else (
    echo Log file tidak ditemukan: storage\logs\laravel.log
)

echo.
echo ========================================
echo.

echo Untuk melihat log real-time, jalankan:
echo tail -f storage/logs/laravel.log
echo.
echo Atau untuk Windows:
echo powershell "Get-Content 'storage\logs\laravel.log' -Wait -Tail 10"
echo.

pause