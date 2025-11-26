# Troubleshooting Dashboard Kesiswaan

## Masalah yang Ditemukan dan Solusinya

### 1. **Dashboard Kesiswaan Tidak Muncul**

**Penyebab:**
- Syntax error di AuthController
- Database belum di-seed dengan benar
- Template layout tidak sesuai

**Solusi:**
1. Jalankan script reset database:
   ```bash
   reset_database.bat
   ```

2. Atau manual:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   php artisan migrate:fresh
   php artisan db:seed --class=UserSeeder
   ```

### 2. **Login Credentials**

**Kesiswaan:**
- Email: `kesiswaan@smk.com`
- Password: `kesiswaan123`

**Admin:**
- Email: `admin@smk.com`
- Password: `admin123`

### 3. **Jika Masih Error 500**

1. Cek log Laravel:
   ```
   storage/logs/laravel.log
   ```

2. Pastikan database `sippres` sudah dibuat di MySQL

3. Cek konfigurasi database di `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sippres
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 4. **Jika View Tidak Ditemukan**

Pastikan file-file berikut ada:
- `resources/views/mainKesiswaan.blade.php`
- `resources/views/layout/sidebarKesiswaan.blade.php`
- `resources/views/kesiswaan/dashboard.blade.php`

### 5. **Jika Assets Tidak Load**

1. Pastikan folder `public/assets` ada
2. Jalankan:
   ```bash
   php artisan storage:link
   ```

### 6. **Testing Login**

1. Buka browser ke: `http://localhost/UjikomAbi/public`
2. Login dengan credentials kesiswaan
3. Seharusnya redirect ke dashboard kesiswaan

## Struktur File yang Diperbaiki

```
resources/views/
├── mainKesiswaan.blade.php (BARU)
├── layout/
│   ├── sidebarAdmin.blade.php
│   └── sidebarKesiswaan.blade.php (BARU)
└── kesiswaan/
    └── dashboard.blade.php (DIPERBAIKI)

database/seeders/
└── UserSeeder.php (DIPERBAIKI)

app/Http/Controllers/
└── AuthController.php (DIPERBAIKI)
```

## Langkah Verifikasi

1. ✅ Database di-reset dan di-seed
2. ✅ Cache di-clear
3. ✅ Login dengan user kesiswaan
4. ✅ Dashboard kesiswaan muncul dengan layout yang benar
5. ✅ Sidebar menampilkan menu kesiswaan
6. ✅ Data statistik muncul (meskipun kosong karena belum ada data)

## Jika Masih Bermasalah

1. Restart Apache/Nginx
2. Restart MySQL
3. Cek permission folder storage dan bootstrap/cache
4. Pastikan PHP extension yang dibutuhkan sudah aktif (pdo_mysql, mbstring, etc)