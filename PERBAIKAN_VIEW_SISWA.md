# PERBAIKAN ERROR VIEW SISWA

## Masalah yang Ditemukan

**Error**: `Call to a member function format() on null`
**Lokasi**: `resources\views\siswa\pelanggaran.blade.php:36`
**Route**: `/siswa/pelanggaran`

## Analisis Masalah

1. **Field tidak ada**: View mencoba mengakses `tanggal_pelanggaran` yang tidak ada di tabel
2. **Null value**: Field yang diakses bernilai null sehingga method `format()` gagal
3. **Struktur tabel tidak sesuai**: View tidak sesuai dengan struktur tabel yang sebenarnya

## Perbaikan yang Dilakukan

### 1. Perbaikan View Pelanggaran (`resources/views/siswa/pelanggaran.blade.php`)

**Sebelum:**
```php
<td>{{ $item->tanggal_pelanggaran->format('d/m/Y') }}</td>
```

**Sesudah:**
```php
<td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
```

**Alasan**: Tabel `pelanggaran` tidak memiliki kolom `tanggal_pelanggaran`, menggunakan `created_at` sebagai tanggal pelanggaran.

### 2. Perbaikan View Prestasi (`resources/views/siswa/prestasi.blade.php`)

**Masalah serupa ditemukan dan diperbaiki:**

#### A. Field Tanggal
**Sebelum:**
```php
<td>{{ $item->tanggal_prestasi->format('d/m/Y') }}</td>
```

**Sesudah:**
```php
<td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
```

#### B. Struktur Tabel
**Header tabel diperbarui:**
```php
// Sebelum
<th>Jenis Prestasi</th>
<th>Poin</th>
<th>Status</th>

// Sesudah  
<th>Nama Prestasi</th>
<th>Tingkat</th>
<th>Juara</th>
```

#### C. Data Tabel
**Sebelum:**
```php
<td>{{ $item->jenisPrestasi->nama_prestasi ?? '-' }}</td>
<td><span class="badge bg-success">{{ $item->poin }}</span></td>
<td>Status verifikasi...</td>
```

**Sesudah:**
```php
<td>{{ $item->nama_prestasi ?? '-' }}</td>
<td><span class="badge bg-info">{{ ucfirst($item->tingkat ?? '-') }}</span></td>
<td><span class="badge bg-warning">{{ $item->juara ?? '-' }}</span></td>
```

### 3. Perbaikan Model Prestasi (`app/Models/Prestasi.php`)

#### A. Menambahkan Date Casting
```php
protected $casts = [
    'tanggal' => 'date',
];
```

#### B. Menghapus Relationship yang Tidak Valid
**Dihapus:**
- `guruPencatat()`
- `jenisPrestasi()`  
- `tahunAjaran()`
- `scopeMenungguVerifikasi()`
- `scopeDiverifikasi()`

**Alasan**: Field-field ini sudah dihapus dari tabel prestasi berdasarkan migration.

### 4. Perbaikan Controller (`app/Http/Controllers/Siswa/DashboardController.php`)

**Sebelum:**
```php
$prestasi = Prestasi::with(['jenisPrestasi', 'createdBy'])
```

**Sesudah:**
```php
$prestasi = Prestasi::with(['createdBy'])
```

**Alasan**: Relationship `jenisPrestasi` sudah tidak valid.

## Struktur Tabel Saat Ini

### Tabel Pelanggaran
- `id` (primary key)
- `siswa_id` (foreign key)
- `guru_pencatat` (foreign key)
- `jenis_pelanggaran_id` (foreign key)
- `tahun_ajaran_id` (foreign key)
- `poin` (integer)
- `keterangan` (text)
- `status_verifikasi` (enum)
- `created_at`, `updated_at` (timestamps)

### Tabel Prestasi
- `id` (primary key)
- `siswa_id` (foreign key)
- `nama_prestasi` (string)
- `tingkat` (enum: sekolah, kecamatan, kabupaten, provinsi, nasional, internasional)
- `juara` (string)
- `tanggal` (date)
- `keterangan` (text)
- `created_by` (foreign key)
- `created_at`, `updated_at` (timestamps)

## Testing

### Script Test
Jalankan `test_siswa_views.php` untuk memeriksa struktur tabel:
```bash
php test_siswa_views.php
```

### Manual Test
1. Login sebagai siswa
2. Akses `/siswa/pelanggaran` - harus tidak error
3. Akses `/siswa/prestasi` - harus tidak error

## Catatan Penting

1. **Null Safety**: Semua akses field menggunakan null check (`?` operator atau `?? '-'`)
2. **Date Handling**: Menggunakan Carbon untuk format tanggal dengan null check
3. **Model Consistency**: Model disesuaikan dengan struktur tabel yang sebenarnya
4. **View Consistency**: View menampilkan data sesuai field yang tersedia

## File yang Dimodifikasi

1. `resources/views/siswa/pelanggaran.blade.php`
2. `resources/views/siswa/prestasi.blade.php`
3. `app/Models/Prestasi.php`
4. `app/Http/Controllers/Siswa/DashboardController.php`

## File Bantuan yang Dibuat

1. `test_siswa_views.php` - Script untuk test struktur tabel
2. `PERBAIKAN_VIEW_SISWA.md` - Dokumentasi ini