# IMPLEMENTASI FOTO PROFIL SISWA

## Fitur yang Ditambahkan

✅ **Foto profil siswa di halaman Profile**
✅ **Foto profil kecil di header dropdown**  
✅ **Fallback untuk siswa tanpa foto**
✅ **Sample foto default**
✅ **Seeder untuk menambahkan foto ke siswa existing**

## Struktur Database

### Tabel Siswa
Kolom `foto` sudah ada di tabel siswa:
```sql
ALTER TABLE siswa ADD COLUMN foto VARCHAR(255) NULL AFTER nama_siswa;
```

## File yang Dimodifikasi

### 1. View Profile (`resources/views/siswa/profile.blade.php`)
- ✅ Menampilkan foto profil siswa
- ✅ Fallback icon jika foto tidak ada
- ✅ File existence check
- ✅ Responsive design

### 2. Layout Siswa (`resources/views/mainSiswa.blade.php`)
- ✅ Foto profil kecil di header (35x35px)
- ✅ Nama siswa dan NIS di dropdown
- ✅ Link profil yang benar
- ✅ Logout form yang proper

### 3. Seeder (`database/seeders/SiswaFotoSeeder.php`)
- ✅ Menambahkan foto sample ke siswa existing
- ✅ Random assignment foto
- ✅ Progress logging

## Cara Setup

### Opsi 1: Setup Otomatis
```bash
setup_siswa_photos.bat
```

### Opsi 2: Manual
```bash
# 1. Buat foto default
create_default_photos.bat

# 2. Jalankan seeder
php artisan db:seed --class=SiswaFotoSeeder

# 3. Atau jalankan script PHP
php add_sample_photos.php
```

## Struktur Folder

```
public/uploads/siswa/
├── default_avatar.png
├── sample_student_1.jpg
├── sample_student_2.jpg
├── sample_student_3.jpg
└── [foto siswa lainnya]
```

## Tampilan Foto

### 1. Halaman Profile
- **Lokasi**: `/siswa/profile`
- **Ukuran**: Responsive (max-height: 300px)
- **Fallback**: Icon user dengan text "Foto belum tersedia"

### 2. Header Dropdown
- **Lokasi**: Header semua halaman siswa
- **Ukuran**: 35x35px (rounded)
- **Fallback**: Icon user dalam circle abu-abu

## Kode Implementasi

### Menampilkan Foto di View
```php
@if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
    <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama_siswa }}">
@else
    <div class="bg-light rounded d-flex align-items-center justify-content-center">
        <i class="ti ti-user fs-1 text-muted"></i>
    </div>
@endif
```

### Foto di Header
```php
@if(auth()->user()->siswa && auth()->user()->siswa->foto && file_exists(public_path('uploads/siswa/' . auth()->user()->siswa->foto)))
    <img src="{{ asset('uploads/siswa/' . auth()->user()->siswa->foto) }}" class="rounded-circle">
@else
    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center">
        <i class="ti ti-user text-white"></i>
    </div>
@endif
```

## Upload Foto (Future Enhancement)

Untuk menambahkan fitur upload foto siswa, bisa ditambahkan:

1. **Form Upload di Profile**
2. **Validation (image, max size, dimensions)**
3. **Image resize/crop**
4. **Delete old photo when uploading new one**

## Troubleshooting

### Foto tidak muncul
1. Cek apakah file ada di `public/uploads/siswa/`
2. Cek permission folder (755)
3. Cek database apakah kolom `foto` terisi

### Error permission
```bash
chmod 755 public/uploads/siswa/
```

### Reset foto siswa
```bash
php artisan db:seed --class=SiswaFotoSeeder --force
```

## Status Implementasi

- ✅ Database structure ready
- ✅ View profile with photo
- ✅ Header photo display  
- ✅ Fallback handling
- ✅ Sample photos seeder
- ✅ Setup scripts
- ⏳ Upload functionality (future)
- ⏳ Photo management (future)