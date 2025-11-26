# 📋 PENJELASAN SISTEM SANKSI

## 🎯 OVERVIEW

Sistem sanksi di project ini terdiri dari **2 tabel utama**:
1. **`sanksi`** - Data sanksi yang diberikan
2. **`pelaksanaan_sanksi`** - Tracking pelaksanaan sanksi

---

## 📊 STRUKTUR DATABASE

### 1. Tabel `sanksi`

```sql
CREATE TABLE `sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggaran_id` bigint(20) UNSIGNED NOT NULL,  -- FK ke pelanggaran
  `jenis_sanksi` varchar(200) NOT NULL,            -- Jenis sanksi
  `deskripsi_sanksi` text DEFAULT NULL,            -- Detail sanksi
  `tanggal_mulai` date NOT NULL,                   -- Tanggal mulai
  `tanggal_selesai` date NOT NULL,                 -- Tanggal selesai
  `status` enum('direncanakan','berjalan','selesai','ditunda','dibatalkan'),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);
```

**Status Sanksi:**
- `direncanakan` - Sanksi sudah dibuat, belum dimulai
- `berjalan` - Sanksi sedang dilaksanakan
- `selesai` - Sanksi sudah selesai dilaksanakan
- `ditunda` - Sanksi ditunda sementara
- `dibatalkan` - Sanksi dibatalkan

### 2. Tabel `pelaksanaan_sanksi`

```sql
CREATE TABLE `pelaksanaan_sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanksi_id` bigint(20) UNSIGNED NOT NULL,        -- FK ke sanksi
  `tanggal_pelaksanaan` date NOT NULL,             -- Tanggal pelaksanaan
  `bukti_pelaksanaan` varchar(255) DEFAULT NULL,   -- File bukti (PDF/foto)
  `catatan` text DEFAULT NULL,                     -- Catatan pelaksanaan
  `status` enum('terjadwal','dikerjakan','tuntas','terlambat','perpanjangan'),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);
```

**Status Pelaksanaan:**
- `terjadwal` - Sudah dijadwalkan
- `dikerjakan` - Sedang dikerjakan
- `tuntas` - Sudah selesai
- `terlambat` - Terlambat dari jadwal
- `perpanjangan` - Diperpanjang waktunya

---

## 🔄 WORKFLOW SISTEM SANKSI

```
1. PELANGGARAN TERJADI
   ↓
2. PELANGGARAN DIVERIFIKASI (Kesiswaan/Admin)
   ↓
3. SANKSI DIBERIKAN (Admin/Kesiswaan)
   - Input jenis sanksi
   - Tentukan periode (tanggal mulai - selesai)
   - Status: direncanakan
   ↓
4. PELAKSANAAN SANKSI (Wali Kelas/Guru)
   - Update status: berjalan
   - Input tanggal pelaksanaan
   - Upload bukti pelaksanaan
   - Tambah catatan
   ↓
5. SANKSI SELESAI
   - Status sanksi: selesai
   - Status pelaksanaan: tuntas
```

---

## 📝 JENIS-JENIS SANKSI

### 1. **Teguran Lisan**
- Untuk pelanggaran ringan
- Tidak perlu bukti tertulis
- Durasi: 1 hari

### 2. **Teguran Tertulis**
- Surat pernyataan
- Ditandatangani siswa & ortu
- Bukti: scan surat pernyataan

### 3. **Panggilan Orang Tua**
- Ortu dipanggil ke sekolah
- Konseling bersama
- Bukti: berita acara pertemuan

### 4. **Skorsing**
- Tidak masuk sekolah 1-7 hari
- Tetap mengerjakan tugas
- Bukti: surat skorsing

### 5. **Konseling BK**
- Bimbingan konseling
- 1-5 sesi
- Bukti: form konseling

### 6. **Tugas Tambahan**
- Tugas khusus
- Sesuai pelanggaran
- Bukti: hasil tugas

### 7. **Kerja Sosial**
- Membersihkan lingkungan
- Membantu perpustakaan
- Durasi: 1-2 minggu
- Bukti: foto kegiatan

---

## 💻 FITUR YANG SUDAH ADA

### ✅ Admin/Kesiswaan Bisa:

1. **Tambah Sanksi**
   - Pilih pelanggaran yang sudah diverifikasi
   - Pilih jenis sanksi
   - Input deskripsi detail
   - Tentukan periode
   - Status awal: direncanakan

2. **Edit Sanksi**
   - Update jenis sanksi
   - Ubah periode
   - Update status
   - Edit deskripsi

3. **Hapus Sanksi**
   - Hapus sanksi yang salah input
   - Cascade delete pelaksanaan

4. **View Sanksi**
   - List semua sanksi
   - Filter by status
   - Search by nama siswa
   - Detail sanksi

### ✅ Wali Kelas Bisa:

1. **View Sanksi Kelas**
   - Lihat sanksi siswa di kelasnya
   - Filter by status

2. **Monitor Pelaksanaan**
   - Cek progress sanksi
   - Update status pelaksanaan

---

## 📊 CONTOH DATA SANKSI

### Contoh 1: Terlambat
```
Pelanggaran: Terlambat masuk sekolah (5 poin)
Sanksi: Teguran Tertulis
Deskripsi: Membuat surat pernyataan tidak akan terlambat lagi
Periode: 01 Nov 2024 - 01 Nov 2024
Status: selesai

Pelaksanaan:
- Tanggal: 01 Nov 2024
- Bukti: surat_pernyataan_001.pdf
- Catatan: Siswa sudah membuat surat pernyataan dengan tanda tangan ortu
- Status: tuntas
```

### Contoh 2: Berkelahi
```
Pelanggaran: Berkelahi dengan teman (25 poin)
Sanksi: Skorsing
Deskripsi: Skorsing 1 hari + konseling BK + panggilan ortu
Periode: 07 Nov 2024 - 07 Nov 2024
Status: selesai

Pelaksanaan:
- Tanggal: 07 Nov 2024
- Bukti: form_skorsing_001.pdf
- Catatan: Skorsing dilaksanakan, ortu sudah datang ke sekolah
- Status: tuntas
```

### Contoh 3: Merokok
```
Pelanggaran: Merokok di area sekolah (40 poin)
Sanksi: Skorsing
Deskripsi: Skorsing 3 hari + konseling intensif + panggilan ortu
Periode: 09 Nov 2024 - 11 Nov 2024
Status: berjalan

Pelaksanaan:
- Tanggal: 09 Nov 2024
- Bukti: (belum upload)
- Catatan: Hari ke-1 skorsing
- Status: dikerjakan
```

---

## 🎯 RELASI DATABASE

```
pelanggaran (1) ──→ (N) sanksi (1) ──→ (N) pelaksanaan_sanksi
     ↓
   siswa
     ↓
   kelas
```

**Artinya:**
- 1 pelanggaran bisa punya banyak sanksi (jarang, biasanya 1)
- 1 sanksi bisa punya banyak pelaksanaan (untuk sanksi bertahap)

---

## 📱 TAMPILAN UI

### Halaman Sanksi (`/admin/sanksi`)

**Fitur:**
- ✅ DataTable dengan pagination
- ✅ Filter by status
- ✅ Search by nama siswa
- ✅ Button: Tambah, Edit, Hapus, Detail
- ✅ Color coding status:
  - `direncanakan` - badge warning (kuning)
  - `berjalan` - badge info (biru)
  - `selesai` - badge success (hijau)
  - `ditunda` - badge secondary (abu)
  - `dibatalkan` - badge danger (merah)

**Kolom Tabel:**
1. No
2. Nama Siswa
3. Kelas
4. Jenis Pelanggaran
5. Jenis Sanksi
6. Periode (tanggal mulai - selesai)
7. Status
8. Aksi (Detail, Edit, Hapus)

---

## 🔐 HAK AKSES

| Role | Tambah | Edit | Hapus | View |
|------|--------|------|-------|------|
| Admin | ✅ | ✅ | ✅ | ✅ |
| Kesiswaan | ✅ | ✅ | ✅ | ✅ |
| Konselor | ❌ | ❌ | ❌ | ✅ |
| Wali Kelas | ❌ | ❌ | ❌ | ✅ (kelas sendiri) |
| Guru | ❌ | ❌ | ❌ | ✅ (terbatas) |
| Kepala Sekolah | ❌ | ❌ | ❌ | ✅ (monitoring) |
| Siswa | ❌ | ❌ | ❌ | ✅ (sanksi sendiri) |
| Orang Tua | ❌ | ❌ | ❌ | ✅ (sanksi anak) |

---

## 📊 STATISTIK SANKSI

### Dashboard Admin/Kesiswaan:
- Total sanksi bulan ini
- Sanksi berjalan
- Sanksi selesai
- Sanksi tertunda

### Grafik:
- Sanksi per bulan (line chart)
- Sanksi per jenis (pie chart)
- Sanksi per kelas (bar chart)

---

## 🚀 CARA MENGGUNAKAN

### 1. Tambah Sanksi Baru

```
1. Login sebagai Admin/Kesiswaan
2. Menu: Sanksi → Tambah Sanksi
3. Pilih pelanggaran (yang sudah diverifikasi)
4. Pilih jenis sanksi
5. Input deskripsi detail
6. Tentukan tanggal mulai & selesai
7. Klik Simpan
```

### 2. Update Status Sanksi

```
1. Buka detail sanksi
2. Klik Edit
3. Ubah status:
   - direncanakan → berjalan (saat mulai)
   - berjalan → selesai (saat selesai)
4. Klik Update
```

### 3. Input Pelaksanaan

```
1. Buka detail sanksi
2. Tab: Pelaksanaan
3. Klik Tambah Pelaksanaan
4. Input tanggal pelaksanaan
5. Upload bukti (PDF/foto)
6. Tambah catatan
7. Pilih status
8. Klik Simpan
```

---

## ✅ KELEBIHAN SISTEM SANKSI

1. ✅ **Tracking Lengkap** - Dari pemberian sampai selesai
2. ✅ **Bukti Digital** - Upload file bukti pelaksanaan
3. ✅ **Status Jelas** - 5 status sanksi, 5 status pelaksanaan
4. ✅ **Relasi Kuat** - Terhubung dengan pelanggaran
5. ✅ **Multi-Role** - Setiap role punya akses berbeda
6. ✅ **Laporan** - Bisa export PDF/Excel
7. ✅ **Notifikasi** - Auto notif saat sanksi diberikan
8. ✅ **History** - Riwayat sanksi per siswa

---

## 📝 KESIMPULAN

Sistem sanksi di project ini **LENGKAP** dengan:
- ✅ Database terstruktur (2 tabel)
- ✅ Workflow jelas
- ✅ 7 jenis sanksi
- ✅ Tracking pelaksanaan
- ✅ Upload bukti
- ✅ Multi-status
- ✅ Role-based access
- ✅ Laporan & statistik

**Status: PRODUCTION READY!** ✅

---

Ada yang mau ditanyakan lagi tentang sanksi? 😊
