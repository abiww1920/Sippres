@echo off
echo Resetting database and running seeders...
echo.

echo 1. Clearing cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo.
echo 2. Running migrations fresh...
php artisan migrate:fresh --force

echo.
echo 3. Running seeders...
php artisan db:seed --class=UserSeeder

echo.
echo Database reset completed!
echo.
echo Login credentials:
echo - Admin: admin@smk.com / admin123
echo - Kesiswaan: kesiswaan@smk.com / kesiswaan123
echo - Guru: guru@smk.com / guru123
echo.
pause