# PANDUAN IMPORT DATABASE DARI XAMPP KE LARAGON

## MASALAH YANG TERJADI

Ketika import file SQL backup dari XAMPP ke Laragon, sering muncul error:
```
TRUNCATE TABLE bimbingan_konseling;
ERROR: Cannot truncate a table referenced in a foreign key constraint
```

## PENYEBAB MASALAH

1. **Foreign Key Constraints**: Tabel memiliki relasi foreign key yang mencegah TRUNCATE
2. **Perbedaan MySQL Version**: XAMPP dan Laragon mungkin menggunakan versi MySQL berbeda
3. **SQL Mode**: Pengaturan SQL mode yang berbeda antara XAMPP dan Laragon
4. **AUTO_INCREMENT**: Nilai AUTO_INCREMENT yang konflik

## SOLUSI

### Opsi 1: Gunakan File yang Sudah Diperbaiki
```bash
# Import menggunakan file yang sudah diperbaiki
mysql -u root sippres < db_pelanggaran_fixed.sql
```

### Opsi 2: Gunakan Batch File
```bash
# Jalankan batch file yang sudah disediakan
import_safe.bat
```

### Opsi 3: Import Manual dengan Langkah Aman
```sql
-- 1. Disable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Gunakan DELETE instead of TRUNCATE
DELETE FROM bimbingan_konseling;
DELETE FROM pelanggaran;
-- dst...

-- 3. Reset AUTO_INCREMENT
ALTER TABLE bimbingan_konseling AUTO_INCREMENT = 1;

-- 4. Insert data
INSERT INTO bimbingan_konseling (...) VALUES (...);

-- 5. Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
```

## FILE YANG TERSEDIA

1. **import_fixed.sql** - File import yang aman dan bersih
2. **db_pelanggaran_fixed.sql** - File backup yang sudah diperbaiki
3. **sippres_fixed.sql** - File lengkap yang sudah diperbaiki
4. **import_safe.bat** - Batch file untuk import otomatis
5. **fix_sql_import.php** - Script untuk memperbaiki file SQL lainnya

## LANGKAH IMPORT YANG DIREKOMENDASIKAN

1. **Backup database lama** (jika ada):
   ```bash
   mysqldump -u root sippres > backup_old.sql
   ```

2. **Drop dan create database baru**:
   ```sql
   DROP DATABASE IF EXISTS sippres;
   CREATE DATABASE sippres;
   ```

3. **Jalankan migration Laravel**:
   ```bash
   php artisan migrate
   ```

4. **Import data menggunakan file yang sudah diperbaiki**:
   ```bash
   mysql -u root sippres < import_fixed.sql
   ```

## PERBEDAAN XAMPP VS LARAGON

| Aspek | XAMPP | Laragon |
|-------|-------|---------|
| MySQL Version | Biasanya 5.7.x | Biasanya 8.0.x |
| SQL Mode | Lebih permisif | Lebih ketat |
| Foreign Keys | Kadang diabaikan | Selalu dicheck |
| AUTO_INCREMENT | Lebih fleksibel | Lebih ketat |

## TIPS MENCEGAH MASALAH

1. **Selalu gunakan DELETE instead of TRUNCATE** untuk tabel dengan foreign key
2. **Disable foreign key checks** saat import data besar
3. **Reset AUTO_INCREMENT** setelah delete data
4. **Gunakan transaction** untuk rollback jika error
5. **Test import di database terpisah** dulu

## TROUBLESHOOTING

### Error: "Cannot truncate table"
**Solusi**: Ganti TRUNCATE dengan DELETE

### Error: "Duplicate entry for key PRIMARY"
**Solusi**: Reset AUTO_INCREMENT atau hapus data lama

### Error: "Foreign key constraint fails"
**Solusi**: Disable foreign key checks atau import dengan urutan yang benar

### Error: "Unknown column"
**Solusi**: Pastikan migration sudah dijalankan

## KONTAK

Jika masih ada masalah, periksa:
1. Log Laravel: `storage/logs/laravel.log`
2. MySQL Error Log di Laragon
3. Jalankan: `php artisan migrate:status`