@echo off
cd /d "c:\laragon\www\UjikomAbi"
"c:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe" -u root sippres < import_fixed.sql
pause