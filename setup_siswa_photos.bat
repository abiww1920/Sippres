@echo off
echo ========================================
echo      SETUP FOTO PROFIL SISWA
echo ========================================
echo.

echo 1. Membuat foto default...
cd public\uploads\siswa

echo Copying default photos...
if exist "..\..\..\fotohalamanKosongAtasnya.png" (
    copy "..\..\..\fotohalamanKosongAtasnya.png" "default_avatar.png" >nul 2>&1
    copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_1.jpg" >nul 2>&1
    copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_2.jpg" >nul 2>&1
    copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_3.jpg" >nul 2>&1
    echo Foto default berhasil dibuat!
) else (
    echo File fotohalamanKosongAtasnya.png tidak ditemukan, menggunakan placeholder...
)

cd ..\..\..

echo.
echo 2. Menjalankan seeder foto siswa...
php artisan db:seed --class=SiswaFotoSeeder

echo.
echo 3. Checking hasil...
php -r "
require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
\$capsule = new Capsule;
\$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost', 
    'database' => 'db_pelanggaran',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
\$capsule->setAsGlobal();
\$capsule->bootEloquent();
\$total = Capsule::table('siswa')->count();
\$withPhoto = Capsule::table('siswa')->whereNotNull('foto')->count();
echo \"Total siswa: {\$total}\n\";
echo \"Siswa dengan foto: {\$withPhoto}\n\";
echo \"Siswa tanpa foto: \" . (\$total - \$withPhoto) . \"\n\";
"

echo.
echo ========================================
echo        SETUP SELESAI!
echo ========================================
echo.
echo Sekarang siswa bisa melihat foto profil mereka di:
echo - Halaman Profile: /siswa/profile  
echo - Header dropdown (foto kecil)
echo.
pause