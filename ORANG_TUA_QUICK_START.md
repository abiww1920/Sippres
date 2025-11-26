# 👨👩👧👦 Login Orang Tua - Quick Start

## ✅ SUDAH SELESAI!

User orang tua sudah dibuat untuk semua siswa!

---

## 🔐 Cara Login Orang Tua

### Format Login:
```
Email: ortu_[NIS]@sekolah.com
Password: [no_hp_ortu] atau 'password'
```

### Contoh:
```
Siswa: Syalsan Nur Salim (NIS: 2024001)

Login Orang Tua:
Email: ortu_2024001@sekolah.com
Password: [cek no_hp_ortu di database]
```

---

## 📊 User Orang Tua yang Sudah Dibuat

| Email | Siswa | NIS |
|-------|-------|-----|
| ortu_2024001@sekolah.com | Syalsan Nur Salim | 2024001 |
| ortu_2024002@sekolah.com | Siti Nurhaliza | 2024002 |
| ortu_2024003@sekolah.com | Dedi Kurniawan | 2024003 |
| ortu_2024004@sekolah.com | Maya Sari Dewi | 2024004 |
| ortu_2024005@sekolah.com | Fajar Ramadhan | 2024005 |

---

## 🎯 Apa yang Bisa Diakses Orang Tua?

### ✅ Bisa Lihat:
- Dashboard anak (statistik pelanggaran & prestasi)
- Data pelanggaran anak (detail, foto bukti, sanksi)
- Data prestasi anak (detail, tingkat, juara)
- Profil anak (foto, data lengkap)
- Total poin pelanggaran anak

### ❌ Tidak Bisa:
- Input pelanggaran
- Input prestasi
- Edit data siswa
- Hapus data apapun

---

## 🔧 Cara Kerja di Code

### Ambil Data Anak:
```php
$user = Auth::user(); // User orang tua
$siswa = $user->siswa; // Data anak
```

### Ambil Pelanggaran Anak:
```php
$pelanggaran = $siswa->pelanggaran()
    ->where('status_verifikasi', 'diverifikasi')
    ->get();
```

### Ambil Prestasi Anak:
```php
$prestasi = $siswa->prestasi()->get();
```

---

## 🔄 Generate User Baru

Jika ada siswa baru:
```bash
php artisan db:seed --class=UserOrangTuaSeeder
```

---

## 📝 Next Steps

1. Buat Controller untuk Orang Tua
2. Buat Views untuk Dashboard Orang Tua
3. Tambah Routes untuk Orang Tua
4. Testing login & akses data

---

**Status**: ✅ Backend Ready!
**File Lengkap**: Lihat `ORANG_TUA_LOGIN_GUIDE.md`
