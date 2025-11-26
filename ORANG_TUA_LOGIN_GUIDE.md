# 👨‍👩‍👧‍👦 Login Orang Tua Siswa - Panduan Lengkap

## ✅ Implementasi Selesai!

Sistem login untuk orang tua siswa sudah berhasil diimplementasikan menggunakan **Pendekatan 1: Relasi User → Siswa**

---

## 📋 Struktur Database

### Tabel: users
```
- id
- username (ortu_[NIS])
- email (ortu_[NIS]@sekolah.com)
- password (dari no_hp_ortu atau 'password')
- level = 'orang_tua'
- siswa_id (FK ke table siswa) ← KOLOM BARU
- can_verify = false
```

### Relasi:
```
User (orang_tua) → belongsTo → Siswa
Siswa → hasOne → User (orang_tua)
```

---

## 🔐 Kredensial Login Orang Tua

### Format Email:
```
ortu_[NIS]@sekolah.com
```

### Format Password:
```
[no_hp_ortu] atau 'password' (jika no_hp_ortu kosong)
```

### Contoh:
```
Siswa: Ahmad (NIS: 2024001, No HP Ortu: 081234567890)

Login Orang Tua:
- Email: ortu_2024001@sekolah.com
- Password: 081234567890
```

---

## 🎯 Cara Kerja

### 1. Login
```php
// Orang tua login dengan email dan password
Auth::attempt([
    'email' => 'ortu_2024001@sekolah.com',
    'password' => '081234567890'
]);
```

### 2. Ambil Data Anak
```php
$user = Auth::user(); // User dengan level = 'orang_tua'
$siswa = $user->siswa; // Data anak (relasi belongsTo)

// Akses data anak
echo $siswa->nama_siswa;
echo $siswa->nis;
echo $siswa->kelas->nama_kelas;
```

### 3. Ambil Data Pelanggaran Anak
```php
$pelanggaran = $siswa->pelanggaran()
    ->where('status_verifikasi', 'diverifikasi')
    ->orderBy('created_at', 'desc')
    ->get();
```

### 4. Ambil Data Prestasi Anak
```php
$prestasi = $siswa->prestasi()
    ->orderBy('created_at', 'desc')
    ->get();
```

---

## 📊 Contoh Dashboard Controller Orang Tua

```php
<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Data anak
        
        // Statistik anak
        $totalPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        $totalPrestasi = $siswa->prestasi()->count();
        
        $totalPoin = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        // Data terbaru
        $pelanggaranTerbaru = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $prestasiTerbaru = $siswa->prestasi()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('orang_tua.dashboard', compact(
            'siswa',
            'totalPelanggaran',
            'totalPrestasi',
            'totalPoin',
            'pelanggaranTerbaru',
            'prestasiTerbaru'
        ));
    }
}
```

---

## 🔒 Middleware & Routes

### Middleware:
```php
// app/Http/Middleware/RoleMiddleware.php
if ($user->level === 'orang_tua' && !$user->siswa) {
    abort(403, 'Data siswa tidak ditemukan');
}
```

### Routes:
```php
// routes/web.php
Route::middleware(['auth', 'role:orang_tua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    Route::get('/dashboard', [OrangTuaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pelanggaran', [OrangTuaPelanggaranController::class, 'index'])->name('pelanggaran');
    Route::get('/prestasi', [OrangTuaPrestasiController::class, 'index'])->name('prestasi');
    Route::get('/profil-anak', [OrangTuaProfilController::class, 'index'])->name('profil');
});
```

---

## 📝 Fitur yang Bisa Diakses Orang Tua

### ✅ Dashboard
- Lihat statistik anak (total pelanggaran, prestasi, poin)
- Lihat pelanggaran terbaru anak
- Lihat prestasi terbaru anak

### ✅ Data Pelanggaran
- Lihat semua pelanggaran anak
- Filter berdasarkan tanggal, status
- Lihat detail pelanggaran (foto bukti, sanksi, dll)

### ✅ Data Prestasi
- Lihat semua prestasi anak
- Filter berdasarkan tingkat, tanggal
- Lihat detail prestasi

### ✅ Profil Anak
- Lihat data lengkap anak
- Lihat foto anak
- Lihat data kelas, jurusan
- Lihat total poin pelanggaran

### ❌ Tidak Bisa Akses
- Input pelanggaran
- Input prestasi
- Edit data siswa
- Hapus data

---

## 🧪 Testing Login

### 1. Cek User Orang Tua di Database
```sql
SELECT * FROM users WHERE level = 'orang_tua';
```

### 2. Cek Relasi
```sql
SELECT u.email, u.level, s.nama_siswa, s.nis 
FROM users u 
JOIN siswa s ON u.siswa_id = s.id 
WHERE u.level = 'orang_tua';
```

### 3. Login Manual
```
URL: http://localhost/UjikomAbi/login
Email: ortu_[NIS]@sekolah.com
Password: [no_hp_ortu]
```

---

## 🔄 Generate Ulang User Orang Tua

Jika ada siswa baru atau perlu regenerate:

```bash
php artisan db:seed --class=UserOrangTuaSeeder
```

Seeder akan otomatis skip user yang sudah ada.

---

## 📱 Contoh Data Login

Berdasarkan data siswa yang ada:

| Nama Siswa | NIS | Email Login | Password |
|------------|-----|-------------|----------|
| Siswa 1 | 2024001 | ortu_2024001@sekolah.com | [no_hp_ortu] |
| Siswa 2 | 2024002 | ortu_2024002@sekolah.com | [no_hp_ortu] |
| Siswa 3 | 2024003 | ortu_2024003@sekolah.com | [no_hp_ortu] |

---

## ⚠️ Catatan Penting

1. **1 Orang Tua = 1 Siswa**: Satu user orang tua hanya bisa melihat data 1 anak
2. **Password**: Gunakan no_hp_ortu sebagai password default
3. **Email Unik**: Format email `ortu_[NIS]@sekolah.com` memastikan tidak ada duplikat
4. **Read Only**: Orang tua hanya bisa melihat data, tidak bisa input/edit/hapus
5. **Auto Generate**: Setiap siswa baru otomatis dibuatkan user orang tua

---

## 🎨 UI/UX untuk Orang Tua

### Dashboard:
- Card statistik anak (pelanggaran, prestasi, poin)
- Foto anak
- Grafik perkembangan pelanggaran per bulan
- Tabel pelanggaran & prestasi terbaru

### Warna Tema:
- Primary: Biru (untuk info umum)
- Danger: Merah (untuk pelanggaran)
- Success: Hijau (untuk prestasi)
- Warning: Kuning (untuk peringatan)

---

## ✅ Status Implementasi

- [x] Migration siswa_id di users table
- [x] Model User relasi siswa
- [x] Seeder UserOrangTuaSeeder
- [x] Generate user orang tua untuk semua siswa
- [ ] Controller OrangTua (Dashboard, Pelanggaran, Prestasi)
- [ ] Views OrangTua (Dashboard, Pelanggaran, Prestasi)
- [ ] Routes untuk orang tua
- [ ] Middleware protection
- [ ] Testing & debugging

---

**Status**: ✅ Backend Ready - Siap untuk implementasi Frontend!
**Last Updated**: 2025-11-19
