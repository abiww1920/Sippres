# Konselor - Quick Start Guide

## 🚀 Mulai Cepat

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Buat User Konselor (Jika belum ada)
```bash
php artisan tinker
```

```php
$user = User::create([
    'name' => 'Konselor Sekolah',
    'email' => 'konselor@sekolah.com',
    'password' => bcrypt('password'),
    'role' => 'konselor'
]);
```

### 3. Login & Akses Dashboard
- URL: `http://localhost/UjikomAbi/konselor/dashboard`
- Email: `konselor@sekolah.com`
- Password: `password`

---

## 📋 Menu Utama

| Menu | URL | Deskripsi |
|------|-----|-----------|
| Dashboard | `/konselor/dashboard` | Statistik & overview |
| Data Bimbingan | `/konselor/bimbingan` | Daftar semua bimbingan |
| Input Bimbingan | `/konselor/bimbingan/create` | Tambah bimbingan baru |
| Daftar Siswa | `/konselor/siswa` | Lihat semua siswa |
| Laporan | `/konselor/laporan` | Laporan & export |

---

## 🎯 Fitur Utama

### Input Bimbingan
```
1. Klik "Input Bimbingan" di sidebar
2. Pilih siswa
3. Isi topik, tanggal, waktu, deskripsi
4. Pilih status (Terjadwal/Proses/Selesai)
5. Klik Simpan
```

### Lihat Data Bimbingan
```
1. Klik "Data Bimbingan" di sidebar
2. Lihat tabel semua bimbingan
3. Klik icon mata untuk detail
4. Klik icon pensil untuk edit
5. Klik icon trash untuk hapus
```

### Lihat Data Siswa
```
1. Klik "Daftar Siswa" di sidebar
2. Lihat tabel semua siswa
3. Klik icon mata untuk detail
4. Di detail siswa, lihat riwayat bimbingan
```

### Export Laporan
```
1. Klik "Laporan" di sidebar
2. Filter berdasarkan bulan & status (opsional)
3. Klik "Export Excel" atau "Export PDF"
4. File akan diunduh
```

---

## 📊 Dashboard Info

**Statistik yang ditampilkan:**
- Total Siswa
- Total Bimbingan
- Bimbingan Bulan Ini
- Bimbingan Selesai
- Daftar Bimbingan Terbaru (5 data)

---

## 🔧 Troubleshooting

### Halaman tidak ditemukan
```bash
php artisan route:cache
php artisan cache:clear
```

### Database error
- Cek file `.env`
- Verifikasi database connection
- Jalankan `php artisan migrate`

### User tidak bisa login
- Pastikan role user adalah 'konselor'
- Cek database: `SELECT * FROM users WHERE email = 'konselor@sekolah.com';`

### View error
- Pastikan folder `resources/views/konselor/` ada
- Verifikasi file blade.php ada di folder yang benar

---

## 📝 Database Fields

### Tabel: bimbingan_konselings
```
- id
- siswa_id (FK)
- guru_konselor (FK)
- topik
- tanggal
- waktu
- deskripsi
- status (terjadwal/proses/selesai)
- tindakan
- created_at
- updated_at
```

### Tabel: siswa (updated)
```
- id
- nis
- nama_siswa
- email (NEW)
- no_telepon (NEW)
- kelas_id (FK)
- jurusan_id (FK) (NEW)
- jenis_kelamin
- alamat
- no_hp
- nama_ortu
- no_hp_ortu
- status
- foto
- created_at
- updated_at
```

---

## 🎨 Style & Design

- **Framework**: Bootstrap 5
- **Icons**: Tabler Icons
- **Charts**: ApexCharts
- **Responsive**: Mobile-friendly
- **Color Scheme**: Sama dengan Admin

---

## 📞 Support

Jika ada masalah:
1. Cek `storage/logs/laravel.log`
2. Verifikasi database connection
3. Jalankan `php artisan migrate`
4. Clear cache: `php artisan cache:clear`

---

## ✅ Checklist Implementasi

- [x] Views & Layout dibuat
- [x] Controllers dibuat
- [x] Routes ditambahkan
- [x] Models diupdate
- [x] Migration dibuat
- [x] Sidebar menu dibuat
- [x] Dashboard dibuat
- [x] Fitur Input BK dibuat
- [x] Fitur View Data dibuat
- [x] Fitur Export Laporan dibuat

---

**Status**: ✅ Ready to Use
**Last Updated**: 2025-11-20
