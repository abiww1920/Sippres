@echo off
echo ============================================
echo SAFE SQL IMPORT FOR LARAGON
echo ============================================
echo.
echo This will import data safely to your database
echo Database: sippres
echo.
pause

echo Importing data...
mysql -u root -h 127.0.0.1 -P 3306 sippres < import_fixed.sql

if %errorlevel% equ 0 (
    echo.
    echo ============================================
    echo SUCCESS: Data imported successfully!
    echo ============================================
) else (
    echo.
    echo ============================================
    echo ERROR: Import failed!
    echo ============================================
)

echo.
pause