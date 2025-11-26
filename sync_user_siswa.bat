@echo off
echo Menjalankan sinkronisasi User-Siswa...
php artisan db:seed --class=SinkronisasiUserSiswaSeeder
echo.
echo Sinkronisasi selesai!
pause