# TODO: Perbaikan Project Sistem Pelanggaran Siswa

📘 USER GUIDE
Sippres
Sistem Point Pelanggaran & Prestasi Siswa
Tanggal Rilis : 27 November 2025
Developer : Muhamad Abi Pebriana
────────────────────────────

DAFTAR ISI

Pendahuluan

Login

Dashboard
    3.1 Dashboard Admin
    3.2 Dashboard Kesiswaan
    3.3 Dashboard Guru
    3.4 Dashboard Wali Kelas
    3.5 Dashboard Konselor
    3.6 Dashboard Kepala Sekolah
    3.7 Dashboard Siswa
    3.8 Dashboard Orang Tua

Data Siswa

Data Guru

Data Kelas

Data Jurusan

Data Tahun Ajaran

Pelanggaran Siswa

Verifikasi Pelanggaran

Prestasi Siswa

Data BK / Sanksi

Laporan

Profil Pengguna

Logout

1. Pendahuluan

Aplikasi Sippres merupakan aplikasi yang digunakan untuk mendukung proses kedisiplinan dan pemantauan perkembangan siswa melalui pencatatan pelanggaran dan prestasi. Aplikasi ini diharapkan dapat membantu sekolah dalam melakukan pembinaan dan menjadi media komunikasi antara sekolah dan orang tua.

Aplikasi digunakan oleh berbagai role seperti Admin, Kesiswaan, Guru, Wali Kelas, Konselor, Kepala Sekolah, Siswa, dan Orang Tua dengan hak akses berbeda sesuai kebutuhan masing-masing.

2. Login

Pengguna harus memasukkan email/username dan password untuk masuk ke sistem.
Jika data benar, pengguna akan diarahkan ke dashboard sesuai role.
Jika salah, akan muncul peringatan kesalahan.

📌 (Gambar: login_page.png)

3. Dashboard

Tampilan utama setelah login yang terdiri dari:

Nama pengguna dan role

Menu navigasi sesuai hak akses

Informasi ringkas mengenai pelanggaran dan prestasi siswa

3.1 Dashboard Admin

Admin memiliki akses penuh seperti:

Kelola data siswa

Kelola data guru

Kelola kelas & jurusan

Input dan monitoring pelanggaran & prestasi

Export laporan & manajemen pengguna

📌 (Gambar: dashboard_admin.png)

3.2 Dashboard Kesiswaan

Berperan dalam pengelolaan kedisiplinan.

Fitur:

Input & verifikasi pelanggaran

Input prestasi siswa

Monitoring seluruh siswa

Export laporan

📌 (Gambar: dashboard_kesiswaan.png)

3.3 Dashboard Guru

Fokus pada pencatatan pelanggaran di kelas yang diawasi.

📌 (Gambar: dashboard_guru.png)

3.4 Dashboard Wali Kelas

Monitoring data kedisiplinan kelas yang diampu.

📌 (Gambar: dashboard_wk.png)

3.5 Dashboard Konselor

Melakukan pembinaan (BK) kepada siswa yang memiliki permasalahan.

📌 (Gambar: dashboard_konselor.png)

3.6 Dashboard Kepala Sekolah

Melihat monitoring seluruh data dan laporan.

📌 (Gambar: dashboard_kepsek.png)

3.7 Dashboard Siswa

Melihat data pelanggaran dan prestasi diri sendiri.

📌 (Gambar: dashboard_siswa.png)

3.8 Dashboard Orang Tua

Melihat riwayat poin pelanggaran dan prestasi anaknya.

📌 (Gambar: dashboard_ortu.png)

4. Data Siswa

Digunakan untuk mengelola data siswa:

Tambah

Edit

Hapus

Pencarian siswa

📌 (Gambar: data_siswa.png)

5. Data Guru

Mengelola data guru dalam sistem.

📌 (Gambar: data_guru.png)

6. Data Kelas

Mengelola pembagian kelas & wali kelas.

📌 (Gambar: data_kelas.png)

7. Data Jurusan

Daftar jurusan sekolah (RPL, TJKT, dll).

📌 (Gambar: data_jurusan.png)

8. Data Tahun Ajaran

Mengatur tahun ajaran aktif dalam aplikasi.

📌 (Gambar: data_tahunajaran.png)

9. Pelanggaran Siswa

Mencatat setiap kejadian pelanggaran:

Nama siswa

Jenis pelanggaran

Poin pelanggaran

Waktu kejadian

📌 (Gambar: pelanggaran_siswa.png)

10. Verifikasi Pelanggaran

Dilakukan oleh Admin atau Kesiswaan sebelum data disahkan.

📌 (Gambar: verifikasi_pelanggaran.png)

11. Prestasi Siswa

Mencatat prestasi akademik dan non-akademik.

📌 (Gambar: prestasi_siswa.png)

12. Data BK / Sanksi

Mengelola pembinaan & sanksi sesuai poin pelanggaran.

📌 (Gambar: data_sanksi.png)

13. Laporan

Export PDF:

Pelanggaran

Prestasi

Rekap per kelas

Rekap seluruh sekolah

📌 (Gambar: laporan.png)

14. Profil Pengguna

Mengubah password & melihat data akun.

📌 (Gambar: profil.png)

15. Logout

Untuk keluar dari sistem dengan aman setelah digunakan.

📌 (Gambar: logout.png)

🎉 PENUTUP

Dengan adanya Sippres, sekolah dapat meningkatkan kedisiplinan siswa dan transparansi kepada orang tua dalam memantau perkembangan anak.
## Fitur yang Perlu Ditambahkan

### 1. Middleware Role-based Access Control
- [ ] Buat middleware untuk membatasi akses per role
- [ ] Implementasi di routes untuk keamanan

### 2. Dashboard Analytics
- [ ] Chart statistik pelanggaran per bulan
- [ ] Top 10 siswa dengan pelanggaran terbanyak
- [ ] Statistik per kategori pelanggaran

### 3. Sistem Laporan
- [ ] Laporan pelanggaran per siswa
- [ ] Laporan pelanggaran per kelas
- [ ] Laporan pelanggaran per periode
- [ ] Export ke PDF dan Excel

### 4. Notifikasi System
- [ ] Email notification untuk orang tua
- [ ] WhatsApp integration (optional)
- [ ] In-app notifications

### 5. Fitur Tambahan
- [ ] Bulk import siswa dari Excel
- [ ] Backup dan restore database
- [ ] Audit trail untuk tracking perubahan data
- [ ] Print kartu siswa dengan QR code

## Database Improvements

### 1. Soft Delete
```php
// Tambahkan di model yang penting
use SoftDeletes;
protected $dates = ['deleted_at'];
```

### 2. Indexing
```php
// Tambahkan index untuk performa
$table->index(['siswa_id', 'created_at']);
$table->index(['status_verifikasi']);
```

### 3. Relasi Tahun Ajaran
- [ ] Implementasi tahun_ajaran_id di semua tabel transaksi
- [ ] Auto-set tahun ajaran aktif

## Security Improvements

### 1. Validation Rules
- [ ] Form Request classes untuk validasi
- [ ] CSRF protection di semua form
- [ ] Input sanitization

### 2. Authorization
- [ ] Policy classes untuk authorization
- [ ] Gate definitions untuk fine-grained access

## UI/UX Improvements

### 1. Loading States
- [ ] Loading spinner saat submit form
- [ ] Progress bar untuk upload file

### 2. Error Handling
- [ ] User-friendly error messages
- [ ] 404 dan 500 error pages

### 3. Mobile Optimization
- [ ] Touch-friendly buttons
- [ ] Mobile-first responsive design