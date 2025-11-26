# Perbaikan Database - Bimbingan Konseling

## Masalah
Error: `SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value`

Terjadi saat mencoba insert data ke tabel `bimbingan_konselings`.

## Penyebab
Tabel `bimbingan_konselings` tidak memiliki kolom `id` dengan auto increment yang benar, menyebabkan error saat insert data baru.

## Solusi yang Diterapkan

### 1. Migration Baru
Dibuat migration baru: `2025_11_20_fix_bimbingan_konselings_id.php`
- Drop tabel lama
- Recreate dengan struktur yang benar
- Kolom `id` dengan auto increment
- Semua foreign key dan constraint yang benar

### 2. Update Model
File: `app/Models/BimbinganKonseling.php`
- Menghapus `guru_konselor` dari fillable (tidak digunakan)
- Memastikan hanya field yang ada di tabel yang masuk fillable

### 3. Struktur Tabel Final
```sql
- id (bigint, auto_increment, primary key)
- siswa_id (foreign key ke tabel siswa)
- topik (varchar 200)
- tindakan (text, nullable)
- deskripsi (text, nullable)
- tanggal (date, nullable)
- waktu (time, nullable)
- status (enum: terdaftar, diproses, selesai, tindak_lanjut, terjadwal, proses)
- created_by (foreign key ke tabel users, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Cara Menjalankan Perbaikan

Jika terjadi error yang sama di environment lain:

```bash
php artisan migrate --path=database/migrations/2025_11_20_fix_bimbingan_konselings_id.php
```

## Status
✅ Perbaikan berhasil diterapkan
✅ Tabel sudah bisa menerima insert data baru
✅ Semua foreign key dan constraint sudah benar

## Testing
Silakan test dengan:
1. Login sebagai konselor
2. Buka menu Bimbingan Konseling
3. Klik "Tambah Bimbingan"
4. Isi form dan submit
5. Data harus tersimpan tanpa error
