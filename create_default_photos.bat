@echo off
echo Membuat foto default untuk siswa...

cd public\uploads\siswa

echo Copying default avatar...
copy "..\..\..\fotohalamanKosongAtasnya.png" "default_avatar.png" >nul 2>&1
copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_1.jpg" >nul 2>&1
copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_2.jpg" >nul 2>&1
copy "..\..\..\fotohalamanKosongAtasnya.png" "sample_student_3.jpg" >nul 2>&1

echo Foto default berhasil dibuat!
echo.
dir /b *.png *.jpg
echo.
echo Sekarang jalankan: php add_sample_photos.php
pause