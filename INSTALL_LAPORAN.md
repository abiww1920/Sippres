# Instalasi Fitur Laporan & Notifikasi

## 1. Install Package PDF
```bash
composer require barryvdh/laravel-dompdf
```

## 2. Jalankan Migration Notifikasi
```bash
php artisan migrate
```

## 3. Tambahkan Menu di Sidebar

Tambahkan di file `resources/views/layouts/admin.blade.php` atau sidebar:

```html
<!-- Menu Laporan -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.laporan') }}">
        <i class="fas fa-file-alt"></i>
        <span>Laporan</span>
    </a>
</li>

<!-- Menu Notifikasi -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('notifications.index') }}">
        <i class="fas fa-bell"></i>
        <span>Notifikasi</span>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </a>
</li>
```

## 4. Fitur yang Ditambahkan

### A. Laporan
- ✅ Laporan Pelanggaran (PDF & Excel)
- ✅ Laporan Prestasi (PDF)
- ✅ Laporan Per Siswa (PDF)
- ✅ Filter berdasarkan tanggal
- ✅ Export ke Excel/PDF

### B. Notifikasi
- ✅ Notifikasi otomatis ke orang tua saat ada pelanggaran
- ✅ Notifikasi sanksi
- ✅ Tandai sudah dibaca
- ✅ Tandai semua sudah dibaca
- ✅ Badge counter notifikasi belum dibaca

## 5. Routes yang Ditambahkan

```php
// Laporan
GET  /admin/laporan
GET  /admin/laporan/pelanggaran
GET  /admin/laporan/prestasi
GET  /admin/laporan/siswa/{id}

// Notifikasi
GET  /notifications
POST /notifications/{id}/read
POST /notifications/read-all
GET  /notifications/unread
```

## 6. Cara Menggunakan

### Generate Laporan:
1. Akses menu "Laporan"
2. Pilih jenis laporan (Pelanggaran/Prestasi)
3. Isi filter tanggal (opsional)
4. Pilih format (PDF/Excel)
5. Klik "Generate"

### Notifikasi:
- Notifikasi otomatis terkirim saat:
  - Ada pelanggaran baru → ke orang tua siswa
  - Ada sanksi baru → ke orang tua siswa
- Akses menu "Notifikasi" untuk melihat semua notifikasi
- Klik "Tandai Dibaca" untuk menandai notifikasi sudah dibaca

## 7. Customisasi

### Tambah Notifikasi Custom:
```php
use App\Notifications\PelanggaranNotification;

$user->notify(new PelanggaranNotification($pelanggaran));
```

### Ubah Template PDF:
Edit file di `resources/views/admin/laporan/*-pdf.blade.php`
