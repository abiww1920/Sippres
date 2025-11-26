# Setup Role Konselor - Sistem Manajemen Pelanggaran Siswa

## Ringkasan Implementasi

Telah berhasil membuat struktur lengkap untuk role **Konselor** dengan fitur sesuai requirement:

### ✅ File yang Telah Dibuat

#### 1. **Layout & Views**
- `resources/views/mainKonselor.blade.php` - Layout utama Konselor
- `resources/views/layout/sidebarKonselor.blade.php` - Sidebar navigasi

#### 2. **Dashboard**
- `resources/views/konselor/dashboard.blade.php` - Dashboard dengan statistik

#### 3. **Bimbingan Konseling**
- `resources/views/konselor/bimbingan/index.blade.php` - Daftar bimbingan
- `resources/views/konselor/bimbingan/create.blade.php` - Form input bimbingan
- `resources/views/konselor/bimbingan/edit.blade.php` - Form edit bimbingan
- `resources/views/konselor/bimbingan/show.blade.php` - Detail bimbingan

#### 4. **Data Siswa**
- `resources/views/konselor/siswa/index.blade.php` - Daftar siswa
- `resources/views/konselor/siswa/show.blade.php` - Detail siswa dengan riwayat bimbingan

#### 5. **Laporan**
- `resources/views/konselor/laporan/index.blade.php` - Laporan bimbingan dengan filter & export

#### 6. **Controllers**
- `app/Http/Controllers/Konselor/DashboardController.php`
- `app/Http/Controllers/Konselor/BimbinganController.php`
- `app/Http/Controllers/Konselor/SiswaController.php`
- `app/Http/Controllers/Konselor/LaporanController.php`

#### 7. **Database**
- `database/migrations/2025_11_20_000000_add_fields_to_siswa_table.php` - Migration untuk field tambahan

#### 8. **Routes**
- Update `routes/web.php` dengan routes lengkap untuk Konselor

### 📋 Fitur yang Tersedia untuk Konselor

Sesuai dengan tabel requirement:

| Fitur | Status |
|-------|--------|
| Input BK (Bimbingan Konseling) | ✅ Full Access |
| View Data Sendiri | ✅ Full Access |
| Export Laporan | ✅ Full Access (Excel & PDF) |
| View Data Siswa | ✅ Full Access |
| View Data Anak | ✅ Full Access |

### 🔧 Langkah Implementasi

1. **Jalankan Migration**
   ```bash
   php artisan migrate
   ```

2. **Pastikan Model BimbinganKonseling sudah ter-update** dengan field:
   - `tanggal`
   - `waktu`
   - `deskripsi`
   - `status` (terjadwal, proses, selesai)

3. **Pastikan User dengan role 'konselor' sudah ada di database**

4. **Akses Dashboard Konselor**
   - URL: `/konselor/dashboard`
   - Hanya bisa diakses oleh user dengan role 'konselor'

### 📊 Menu Sidebar Konselor

```
Dashboard
├── Dashboard

Bimbingan Konseling
├── Data Bimbingan
└── Input Bimbingan

Data Siswa
└── Daftar Siswa

Laporan & Notifikasi
├── Laporan
└── Notifikasi

System
└── Logout
```

### 🎨 Style & Design

- Menggunakan style yang sama dengan Admin
- Bootstrap 5 framework
- Responsive design
- Tabler Icons untuk icon
- ApexCharts untuk chart (jika diperlukan)

### 📝 Catatan Penting

1. **Model BimbinganKonseling** sudah diupdate dengan:
   - Field: `tanggal`, `waktu`, `deskripsi`
   - Relasi ke Siswa
   - Status: terjadwal, proses, selesai

2. **Model Siswa** sudah diupdate dengan:
   - Field: `email`, `no_telepon`, `jurusan_id`
   - Relasi ke Jurusan
   - Relasi ke BimbinganKonseling

3. **Routes** sudah ditambahkan dengan middleware `role:konselor`

4. **Export Excel & PDF** masih perlu diimplementasikan dengan library (barryvdh/laravel-dompdf atau maatwebsite/excel)

### 🚀 Langkah Selanjutnya (Opsional)

1. Implementasi export Excel menggunakan `maatwebsite/excel`
2. Implementasi export PDF menggunakan `barryvdh/laravel-dompdf`
3. Tambahkan chart/grafik di dashboard
4. Implementasi notifikasi real-time
5. Tambahkan validasi dan error handling yang lebih detail

---

**Status**: ✅ Siap Digunakan
**Last Updated**: 2025-11-20
