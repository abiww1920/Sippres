-- ============================================
-- SISTEM PENCATATAN PELANGGARAN, SANKSI DAN PRESTASI SISWA
-- Database Insert Statements
-- ============================================

-- Bersihkan data lama (opsional, untuk testing)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE verifikasi_data;
TRUNCATE TABLE monitoring_pelanggaran;
TRUNCATE TABLE bimbingan_konseling;
TRUNCATE TABLE pelaksanaan_sanksi;
TRUNCATE TABLE sanksi;
TRUNCATE TABLE pelanggaran;
TRUNCATE TABLE prestasi;
TRUNCATE TABLE jenis_prestasi;
TRUNCATE TABLE jenis_pelanggaran;
TRUNCATE TABLE jenis_sanksi;
TRUNCATE TABLE users;
TRUNCATE TABLE guru;
TRUNCATE TABLE siswa;
TRUNCATE TABLE kelas;
TRUNCATE TABLE tahun_ajaran;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- 1. TABEL TAHUN AJARAN
-- ============================================
INSERT INTO tahun_ajaran (id, tahun_ajaran, semester, status_aktif, created_at) VALUES
(1, '2024/2025', 'Ganjil', 1, NOW()),
(2, '2024/2025', 'Genap', 0, NOW()),
(3, '2023/2024', 'Ganjil', 0, NOW()),
(4, '2023/2024', 'Genap', 0, NOW());

-- ============================================
-- 2. TABEL GURU
-- ============================================
INSERT INTO guru (id, nip, nama_guru, bidang_studi, status, created_at) VALUES
(1, '198501012010011001', 'Drs. Ahmad Subarkah, M.Pd', 'Kepala Sekolah', 'aktif', NOW()),
(2, '198603152011012002', 'Sri Wahyuni, S.Pd', 'Kesiswaan', 'aktif', NOW()),
(3, '198705202012011003', 'Budi Santoso, S.Kom', 'Rekayasa Perangkat Lunak', 'aktif', NOW()),
(4, '198808252013012004', 'Siti Nurjanah, S.Pd', 'Matematika', 'aktif', NOW()),
(5, '198910102014011005', 'Eko Prasetyo, S.Pd', 'Bahasa Indonesia', 'aktif', NOW()),
(6, '199001152015012006', 'Dewi Lestari, S.Psi', 'Bimbingan Konseling', 'aktif', NOW()),
(7, '199103202016011007', 'Rizki Firmansyah, S.Kom', 'Basis Data', 'aktif', NOW()),
(8, '199205252017012008', 'Anita Sari, S.Pd', 'Bahasa Inggris', 'aktif', NOW()),
(9, '199308102018011009', 'Hendra Gunawan, S.Pd', 'Pemrograman Web', 'aktif', NOW()),
(10, '199410152019012010', 'Maya Kusuma, S.Pd', 'Pendidikan Agama', 'aktif', NOW());

-- ============================================
-- 3. TABEL KELAS
-- ============================================
INSERT INTO kelas (id, nama_kelas, jurusan, wali_kelas_id, created_at) VALUES
(1, 'X RPL 1', 'Rekayasa Perangkat Lunak', 3, NOW()),
(2, 'X RPL 2', 'Rekayasa Perangkat Lunak', 7, NOW()),
(3, 'XI RPL 1', 'Rekayasa Perangkat Lunak', 9, NOW()),
(4, 'XI RPL 2', 'Rekayasa Perangkat Lunak', 4, NOW()),
(5, 'XII RPL 1', 'Rekayasa Perangkat Lunak', 5, NOW()),
(6, 'XII RPL 2', 'Rekayasa Perangkat Lunak', 8, NOW());

-- ============================================
-- 4. TABEL USERS
-- ============================================
INSERT INTO users (id, guru_id, username, password, level, can_verify, created_at) VALUES
(1, 1, 'kepsek', MD5('kepsek123'), 'kepala_sekolah', 0, NOW()),
(2, 2, 'kesiswaan', MD5('kesiswaan123'), 'kesiswaan', 1, NOW()),
(3, 3, 'guru_budi', MD5('guru123'), 'guru', 0, NOW()),
(4, 4, 'wali_siti', MD5('wali123'), 'wali_kelas', 0, NOW()),
(5, 6, 'bk_dewi', MD5('bk123'), 'konselor', 0, NOW()),
(6, 7, 'guru_rizki', MD5('guru123'), 'guru', 0, NOW()),
(7, 9, 'wali_hendra', MD5('wali123'), 'wali_kelas', 0, NOW()),
(8, NULL, 'admin', MD5('admin123'), 'admin', 1, NOW());

-- ============================================
-- 5. TABEL SISWA
-- ============================================
INSERT INTO siswa (id, nis, nama_siswa, kelas_id, jenis_kelamin, status, created_at) VALUES
(1, '2024001', 'Ahmad Fauzi', 1, 'L', 'aktif', NOW()),
(2, '2024002', 'Siti Aisyah', 1, 'P', 'aktif', NOW()),
(3, '2024003', 'Budi Prasetyo', 1, 'L', 'aktif', NOW()),
(4, '2024004', 'Dewi Anjani', 2, 'P', 'aktif', NOW()),
(5, '2024005', 'Eko Saputra', 2, 'L', 'aktif', NOW()),
(6, '2023006', 'Fitri Handayani', 3, 'P', 'aktif', NOW()),
(7, '2023007', 'Gilang Ramadhan', 3, 'L', 'aktif', NOW()),
(8, '2023008', 'Hani Nurhaliza', 4, 'P', 'aktif', NOW()),
(9, '2023009', 'Ilham Maulana', 4, 'L', 'aktif', NOW()),
(10, '2022010', 'Juwita Sari', 5, 'P', 'aktif', NOW()),
(11, '2022011', 'Kurniawan Adi', 5, 'L', 'aktif', NOW()),
(12, '2022012', 'Lina Marlina', 6, 'P', 'aktif', NOW()),
(13, '2024013', 'Muhamad Rizky', 1, 'L', 'aktif', NOW()),
(14, '2024014', 'Nur Azizah', 2, 'P', 'aktif', NOW()),
(15, '2023015', 'Oki Setiawan', 3, 'L', 'aktif', NOW());

-- ============================================
-- 6. TABEL JENIS PELANGGARAN (Sesuai PDF - Tata Tertib)
-- ============================================
INSERT INTO jenis_pelanggaran (id, nama_pelanggaran, poin, kategori, sanksi_rekomendasi, created_at) VALUES
-- A. KEPRIBADIAN (Sikap)
-- A. KETERTIBAN
(1, 'Membuat keributan / kegaduhan dalam kelas pada saat berlangsungnya pelajaran', 10, 'ringan', 'Teguran dan pembinaan', NOW()),
(2, 'Masuk dan atau keluar lingkungan sekolah tidak melalui gerbang sekolah', 20, 'sedang', 'Teguran tertulis dan panggilan orang tua', NOW()),
(3, 'Berkata tidak jujur, tidak sopan/kasar', 10, 'ringan', 'Pembinaan karakter', NOW()),
(4, 'Mengotori (mencoret-coret) barang milik sekolah, guru, karyawan atau teman', 10, 'ringan', 'Membersihkan dan ganti rugi', NOW()),
(5, 'Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25, 'sedang', 'Ganti rugi dan sanksi', NOW()),
(6, 'Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50, 'berat', 'Ganti rugi dan sanksi berat', NOW()),
(7, 'Makan atau minum di dalam kelas saat berlangsungnya pelajaran', 5, 'ringan', 'Teguran lisan', NOW()),
(8, 'Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5, 'ringan', 'Penyitaan alat komunikasi', NOW()),
(9, 'Membuang sampah tidak pada tempatnya', 5, 'ringan', 'Piket kebersihan', NOW()),
(10, 'Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5, 'ringan', 'Teguran dan pembinaan', NOW()),
(11, 'Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10, 'ringan', 'Penyitaan barang', NOW()),
(12, 'Bertengkar / bertentangan dengan teman di lingkungan sekolah', 15, 'ringan', 'Mediasi dan konseling', NOW()),
(13, 'Memalsu tandatangan guru, walikelas, kepala sekolah', 40, 'berat', 'Sanksi berat dan panggilan orang tua', NOW()),
(14, 'Menggunakan/mengopelaskan SPP dari orang/makan/minum', 40, 'berat', 'Sanksi berat', NOW()),
(15, 'Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15, 'ringan', 'Pembubaran organisasi', NOW()),
(16, 'Menyalahgunakan Uang SPP', 40, 'berat', 'Sanksi berat dan pengembalian', NOW()),
(17, 'Berbuat asusila', 100, 'sangat_berat', 'Dikembalikan ke orang tua', NOW()),

-- B. ROKOK
(18, 'Membawa rokok', 25, 'sedang', 'Penyitaan dan sanksi', NOW()),
(19, 'Merokok / menghisap rokok di sekolah', 40, 'berat', 'Sanksi berat', NOW()),
(20, 'Merokok / menghisap rokok di luar sekolah sementara sekolah memakai seragam sekolah', 40, 'berat', 'Sanksi berat', NOW()),

-- C. BUKU, MAJALAH ATAU KASET TERLARANG
(21, 'Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25, 'sedang', 'Penyitaan dan konseling', NOW()),
(22, 'Memperjual belikan buku, majalah atau kaset terlarang', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),

-- D. SENJATA
(23, 'Membawa senjata tajam tanpa ijin', 40, 'berat', 'Penyitaan dan sanksi berat', NOW()),
(24, 'Memperjual belikan senjata tajam di sekolah', 40, 'berat', 'Sanksi berat', NOW()),
(25, 'Menggunakan senjata tajam untuk mengancam', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),
(26, 'Menggunakan senjata tajam untuk melukai', 75, 'sangat_berat', 'Dikembalikan ke orang tua', NOW()),

-- E. OBAT / MINUMAN TERLARANG
(27, 'Membawa obat terlarang / minuman terlarang', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),
(28, 'Menggunakan obat / minuman terlarang di dalam lingkungan sekolah', 100, 'sangat_berat', 'Dikembalikan ke orang tua', NOW()),
(29, 'Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100, 'sangat_berat', 'Dikeluarkan dari sekolah', NOW()),

-- F. PERKELAHIAN
(30, 'Disebabkan oleh siswa di dalam sekolah (Intern)', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),
(31, 'Disebabkan oleh sekolah lain', 25, 'sedang', 'Sanksi dan konseling', NOW()),
(32, 'Antar siswa SMK BN 666', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),

-- G. PELANGGARAN TERHADAP KEPALA SEKOLAH, GURU DAN KARYAWAN
(33, 'Disertai ancaman', 75, 'sangat_berat', 'Sanksi sangat berat', NOW()),
(34, 'Disertai pemukulan', 100, 'sangat_berat', 'Dikeluarkan dari sekolah', NOW()),

-- II. KERAJIAN
-- A. KETERLAMBATAN
(35, 'Terlambat masuk sekolah lebih dari 15 menit - Satu kali', 2, 'ringan', 'Teguran lisan', NOW()),
(36, 'Terlambat masuk sekolah lebih dari 15 menit - Dua kali', 3, 'ringan', 'Teguran tertulis', NOW()),
(37, 'Terlambat masuk sekolah lebih dari 15 menit - Tiga kali dan selebihnya', 5, 'ringan', 'Panggilan orang tua', NOW()),
(38, 'Terlambat masuk karena izin', 3, 'ringan', 'Dicatat', NOW()),
(39, 'Terlambat masuk karena diberi tugas guru', 2, 'ringan', 'Dicatat', NOW()),
(40, 'Terlambat masuk karena alasan yang dibuat-buat', 5, 'ringan', 'Teguran dan konseling', NOW()),
(41, 'Izin keluar saat proses belajar berlangsung dan tidak kembali', 10, 'ringan', 'Teguran dan pembinaan', NOW()),
(42, 'Pulang tanpa izin', 10, 'ringan', 'Panggilan orang tua', NOW()),

-- B. KEHADIRAN
(43, 'Siswa tidak masuk karena sakit tanpa keterangan (surat)', 2, 'ringan', 'Konfirmasi orang tua', NOW()),
(44, 'Siswa tidak masuk karena izin tanpa keterangan (surat)', 2, 'ringan', 'Konfirmasi orang tua', NOW()),
(45, 'Siswa tidak masuk karena alpa', 5, 'ringan', 'Panggilan orang tua', NOW()),
(46, 'Tidak mengikuti kegiatan belajar (membolos)', 10, 'ringan', 'Sanksi dan konseling', NOW()),
(47, 'Siswa tidak masuk dengan membuat keterangan (surat)', 10, 'ringan', 'Sanksi dan panggilan orang tua', NOW()),
(48, 'Palsu', 10, 'ringan', 'Sanksi', NOW()),
(49, 'Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5, 'ringan', 'Teguran', NOW()),

-- III. KERAPIAN
-- A. PAKAIAN
(50, 'Memakai seragam tidak rapi / tidak dimasukkan', 5, 'ringan', 'Teguran', NOW()),
(51, 'Siswa putri memakai seragam yang ketat / rok pendek', 5, 'ringan', 'Teguran dan pembinaan', NOW()),
(52, 'Tidak memakai perlengkapan upacara bendera (topi)', 5, 'ringan', 'Teguran', NOW()),
(53, 'Salah memakai baju, rok atau celana', 5, 'ringan', 'Teguran', NOW()),
(54, 'Salah atau tidak memakai ikat pinggang', 5, 'ringan', 'Teguran', NOW()),
(55, 'Salah memakai sepatu (tidak sesuai ketentuan)', 5, 'ringan', 'Teguran', NOW()),
(56, 'Tidak memakai kaos kaki', 5, 'ringan', 'Teguran', NOW()),
(57, 'Salah / tidak memakai kaos dalam', 5, 'ringan', 'Teguran', NOW()),
(58, 'Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5, 'ringan', 'Penyitaan topi', NOW()),
(59, 'Siswa putri memakai perhiasan perlebihan', 5, 'ringan', 'Teguran', NOW()),
(60, 'Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5, 'ringan', 'Teguran dan penyitaan', NOW()),

-- B. RAMBUT
(61, 'Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 15, 'ringan', 'Potong rambut', NOW()),
(62, 'Dicat / diwarna-warnai (putra-putri)', 15, 'ringan', 'Cat rambut hitam', NOW()),

-- C. BADAN
(63, 'Bertato', 100, 'sangat_berat', 'Dikembalikan ke orang tua', NOW()),
(64, 'Kuku di cat', 20, 'sedang', 'Bersihkan kuku', NOW());

-- ============================================
-- 7. TABEL JENIS SANKSI
-- ============================================
INSERT INTO jenis_sanksi (id, nama_sanksi, kategori, deskripsi, created_at) VALUES
(1, 'Teguran Lisan', 'ringan', 'Pemberian peringatan secara lisan', NOW()),
(2, 'Teguran Tertulis', 'ringan', 'Pemberian surat peringatan tertulis', NOW()),
(3, 'Membuat Surat Pernyataan', 'ringan', 'Siswa membuat surat pernyataan tidak mengulangi', NOW()),
(4, 'Panggilan Orang Tua', 'sedang', 'Orang tua dipanggil ke sekolah', NOW()),
(5, 'Piket Kebersihan', 'ringan', 'Melakukan piket kebersihan tambahan', NOW()),
(6, 'Skorsing 1 Hari', 'sedang', 'Tidak diperbolehkan masuk sekolah 1 hari', NOW()),
(7, 'Skorsing 3 Hari', 'sedang', 'Tidak diperbolehkan masuk sekolah 3 hari', NOW()),
(8, 'Skorsing 1 Minggu', 'berat', 'Tidak diperbolehkan masuk sekolah 1 minggu', NOW()),
(9, 'Konseling BK', 'sedang', 'Mengikuti bimbingan konseling', NOW()),
(10, 'Ganti Rugi', 'berat', 'Mengganti kerugian yang ditimbulkan', NOW()),
(11, 'Dikembalikan ke Orang Tua', 'sangat_berat', 'Sementara tidak diperbolehkan sekolah', NOW()),
(12, 'Dikeluarkan dari Sekolah', 'sangat_berat', 'Tidak diperbolehkan sekolah lagi', NOW());

-- ============================================
-- 8. TABEL JENIS PRESTASI
-- ============================================
INSERT INTO jenis_prestasi (id, nama_prestasi, poin, kategori, penghargaan, created_at) VALUES
-- Akademik
(1, 'Juara 1 Kelas', 15, 'akademik', 'Piagam dan hadiah', NOW()),
(2, 'Juara 2 Kelas', 12, 'akademik', 'Piagam', NOW()),
(3, 'Juara 3 Kelas', 10, 'akademik', 'Piagam', NOW()),
(4, 'Juara Olimpiade Tingkat Kabupaten', 25, 'akademik', 'Piagam, hadiah, dan beasiswa', NOW()),
(5, 'Juara Olimpiade Tingkat Provinsi', 40, 'akademik', 'Piagam, hadiah, dan beasiswa', NOW()),
(6, 'Juara Olimpiade Tingkat Nasional', 60, 'akademik', 'Piagam, hadiah, dan beasiswa', NOW()),
(7, 'Nilai Ujian Sempurna', 10, 'akademik', 'Sertifikat apresiasi', NOW()),

-- Non-Akademik Olahraga
(8, 'Juara 1 Olahraga Tingkat Sekolah', 10, 'olahraga', 'Piagam dan medali', NOW()),
(9, 'Juara 1 Olahraga Tingkat Kabupaten', 20, 'olahraga', 'Piagam, medali, dan hadiah', NOW()),
(10, 'Juara 1 Olahraga Tingkat Provinsi', 35, 'olahraga', 'Piagam, medali, dan hadiah', NOW()),
(11, 'Juara 1 Olahraga Tingkat Nasional', 55, 'olahraga', 'Piagam, medali, dan beasiswa', NOW()),

-- Non-Akademik Seni
(12, 'Juara Lomba Seni Tingkat Sekolah', 10, 'seni', 'Piagam', NOW()),
(13, 'Juara Lomba Seni Tingkat Kabupaten', 20, 'seni', 'Piagam dan hadiah', NOW()),
(14, 'Juara Lomba Seni Tingkat Provinsi', 35, 'seni', 'Piagam dan hadiah', NOW()),

-- Kepemimpinan & Karakter
(15, 'Ketua OSIS', 20, 'kepemimpinan', 'Surat keputusan', NOW()),
(16, 'Ketua Kelas', 10, 'kepemimpinan', 'Surat keputusan', NOW()),
(17, 'Siswa Teladan Sekolah', 30, 'karakter', 'Piagam dan hadiah', NOW()),
(18, 'Tidak pernah terlambat 1 semester', 15, 'karakter', 'Sertifikat apresiasi', NOW());

-- ============================================
-- 9. TABEL PELANGGARAN
-- ============================================
INSERT INTO pelanggaran (id, siswa_id, guru_pencatat, jenis_pelanggaran_id, tahun_ajaran_id, poin, keterangan, status_verifikasi, created_at) VALUES
(1, 1, 3, 35, 1, 2, 'Terlambat 20 menit - pertama kali', 'diverifikasi', '2024-08-15 07:25:00'),
(2, 3, 4, 46, 1, 10, 'Membolos pelajaran Matematika tanpa izin', 'diverifikasi', '2024-08-20 10:00:00'),
(3, 5, 3, 46, 1, 10, 'Bolos pelajaran pemrograman', 'diverifikasi', '2024-09-05 08:30:00'),
(4, 7, 9, 8, 1, 5, 'Membawa HP dan bermain game saat pelajaran', 'diverifikasi', '2024-09-12 09:15:00'),
(5, 9, 4, 47, 1, 10, 'Membuat surat sakit palsu', 'diverifikasi', '2024-09-25 11:00:00'),
(6, 2, 5, 50, 1, 5, 'Tidak memakai seragam dengan rapi', 'diverifikasi', '2024-10-01 07:30:00'),
(7, 13, 3, 1, 1, 10, 'Membuat keributan di kelas saat pelajaran', 'menunggu', '2024-11-10 13:00:00'),
(8, 11, 5, 19, 1, 40, 'Ketahuan merokok di belakang sekolah', 'diverifikasi', '2024-10-15 12:00:00'),
(9, 15, 9, 30, 1, 75, 'Berkelahi dengan teman sekelas (intern)', 'diverifikasi', '2024-10-20 14:30:00'),
(10, 4, 8, 36, 1, 3, 'Terlambat 20 menit - kedua kali', 'diverifikasi', '2024-11-05 07:30:00'),
(11, 6, 3, 45, 1, 5, 'Alpa tanpa keterangan', 'diverifikasi', '2024-09-18 08:00:00'),
(12, 8, 4, 9, 1, 5, 'Membuang sampah sembarangan', 'diverifikasi', '2024-10-05 10:30:00'),
(13, 10, 5, 61, 1, 15, 'Rambut tidak sesuai ketentuan (terlalu panjang)', 'diverifikasi', '2024-08-25 07:15:00'),
(14, 12, 7, 18, 1, 25, 'Membawa rokok ke sekolah', 'diverifikasi', '2024-10-28 11:00:00'),
(15, 14, 8, 51, 1, 5, 'Rok terlalu pendek/ketat', 'diverifikasi', '2024-09-30 07:45:00'),
(16, 1, 3, 37, 1, 5, 'Terlambat ketiga kali bulan ini', 'diverifikasi', '2024-09-22 07:20:00'),
(17, 7, 9, 12, 1, 15, 'Bertengkar dengan teman di kantin', 'menunggu', '2024-11-12 12:30:00'),
(18, 11, 5, 23, 1, 40, 'Membawa cutter tanpa keperluan jelas', 'diverifikasi', '2024-10-18 09:00:00');

-- ============================================
-- 10. TABEL SANKSI
-- ============================================
INSERT INTO sanksi (id, pelanggaran_id, jenis_sanksi, deskripsi_sanksi, tanggal_mulai, tanggal_selesai, status, created_at) VALUES
(1, 1, 'Teguran Tertulis', 'Membuat surat pernyataan tidak akan terlambat lagi', '2024-08-15', '2024-08-15', 'selesai', '2024-08-15 08:00:00'),
(2, 2, 'Mengerjakan tugas 2x lipat', 'Mengerjakan soal tambahan matematika', '2024-08-20', '2024-08-22', 'selesai', '2024-08-20 10:30:00'),
(3, 3, 'Skorsing 1 hari dan panggilan orang tua', 'Tidak boleh masuk sekolah 1 hari', '2024-09-06', '2024-09-06', 'selesai', '2024-09-05 15:00:00'),
(4, 4, 'HP disita dan panggilan orang tua', 'HP dikembalikan setelah 1 minggu', '2024-09-12', '2024-09-19', 'selesai', '2024-09-12 10:00:00'),
(5, 5, 'Nilai ujian 0 dan panggilan orang tua', 'Harus mengikuti ujian susulan', '2024-09-25', '2024-09-30', 'selesai', '2024-09-25 12:00:00'),
(6, 6, 'Teguran tertulis', 'Membuat surat pernyataan', '2024-10-01', '2024-10-01', 'selesai', '2024-10-01 08:00:00'),
(7, 8, 'Skorsing 3 hari', 'Tidak boleh masuk sekolah 3 hari', '2024-10-16', '2024-10-18', 'selesai', '2024-10-15 14:00:00'),
(8, 9, 'Skorsing dan konseling BK', 'Skorsing 2 hari + wajib konseling', '2024-10-21', '2024-10-25', 'berjalan', '2024-10-20 15:00:00'),
(9, 10, 'Teguran lisan', 'Peringatan untuk tidak terlambat lagi', '2024-11-05', '2024-11-05', 'selesai', '2024-11-05 08:00:00');

-- ============================================
-- 11. TABEL PELAKSANAAN SANKSI
-- ============================================
INSERT INTO pelaksanaan_sanksi (id, sanksi_id, tanggal_pelaksanaan, bukti_pelaksanaan, catatan, status, created_at) VALUES
(1, 1, '2024-08-15', 'surat_pernyataan_001.pdf', 'Siswa membuat surat pernyataan dengan baik', 'tuntas', '2024-08-15 09:00:00'),
(2, 2, '2024-08-22', 'tugas_tambahan_002.pdf', 'Tugas dikerjakan lengkap', 'tuntas', '2024-08-22 14:00:00'),
(3, 3, '2024-09-06', 'form_skorsing_003.pdf', 'Orang tua sudah dipanggil dan diberikan pengarahan', 'tuntas', '2024-09-06 16:00:00'),
(4, 4, '2024-09-19', 'form_penyitaan_hp.pdf', 'HP dikembalikan setelah pertemuan dengan orang tua', 'tuntas', '2024-09-19 10:00:00'),
(5, 5, '2024-09-30', 'nilai_ujian_susulan.pdf', 'Siswa mengikuti ujian susulan dengan nilai 75', 'tuntas', '2024-09-30 11:00:00'),
(6, 6, '2024-10-01', 'surat_pernyataan_006.pdf', 'Siswa berjanji tidak mengulangi', 'tuntas', '2024-10-01 10:00:00'),
(7, 7, '2024-10-18', 'laporan_skorsing_007.pdf', 'Siswa menjalani skorsing 3 hari', 'tuntas', '2024-10-18 15:00:00'),
(8, 8, '2024-10-23', NULL, 'Sedang menjalani konseling dengan BK', 'dikerjakan', '2024-10-23 09:00:00'),
(9, 9, '2024-11-05', NULL, 'Teguran lisan diberikan', 'tuntas', '2024-11-05 08:15:00');

-- ============================================
-- 12. TABEL PRESTASI
-- ============================================
INSERT INTO prestasi (id, siswa_id, guru_pencatat, jenis_prestasi_id, tahun_ajaran_id, poin, keterangan, status_verifikasi, created_at) VALUES
(1, 2, 4, 1, 1, 15, 'Juara 1 kelas semester ganjil', 'diverifikasi', '2024-09-15 10:00:00'),
(2, 6, 9, 4, 1, 25, 'Juara 2 Olimpiade Pemrograman Tingkat Kabupaten', 'diverifikasi', '2024-09-20 14:00:00'),
(3, 10, 5, 17, 1, 30, 'Terpilih sebagai siswa teladan', 'diverifikasi', '2024-10-01 11:00:00'),
(4, 12, 8, 9, 1, 20, 'Juara 1 Bulu Tangkis Tingkat Kabupaten', 'diverifikasi', '2024-10-10 15:00:00'),
(5, 7, 3, 13, 1, 20, 'Juara 1 Lomba Desain Poster Tingkat Kabupaten', 'diverifikasi', '2024-10-15 13:00:00'),
(6, 4, 4, 2, 1, 12, 'Juara 2 kelas semester ganjil', 'diverifikasi', '2024-09-15 10:00:00'),
(7, 11, 5, 15, 1, 20, 'Ketua OSIS periode 2024/2025', 'diverifikasi', '2024-08-10 09:00:00'),
(8, 1, 3, 16, 1, 10, 'Ketua Kelas X RPL 1', 'diverifikasi', '2024-08-05 08:00:00'),
(9, 8, 4, 18, 1, 15, 'Tidak pernah terlambat semester ganjil', 'diverifikasi', '2024-11-01 10:00:00'),
(10, 14, 8, 7, 1, 10, 'Nilai ujian Bahasa Inggris sempurna (100)', 'menunggu', '2024-11-15 11:00:00');

-- ============================================
-- 13. TABEL BIMBINGAN KONSELING
-- ============================================
INSERT INTO bimbingan_konseling (id, siswa_id, guru_konselor, topik, tindakan, status, created_at) VALUES
(1, 5, 6, 'Membolos pelajaran', 'Konseling individu tentang pentingnya pendidikan', 'selesai', '2024-09-07 10:00:00'),
(2, 9, 6, 'Berkelahi dengan teman', 'Mediasi antara kedua pihak dan konseling tentang pengendalian emosi', 'diproses', '2024-10-21 09:00:00'),
(3, 11, 6, 'Merokok di sekolah', 'Konseling tentang bahaya merokok dan dampaknya', 'selesai', '2024-10-16 13:00:00'),
(4, 15, 6, 'Berkelahi dengan teman', 'Konseling pengendalian amarah', 'tindak_lanjut', '2024-10-22 10:00:00'),
(5, 7, 6, 'Penggunaan HP saat pelajaran', 'Konseling tentang fokus belajar', 'selesai', '2024-09-14 11:00:00');

-- ============================================
-- 14. TABEL MONITORING PELANGGARAN
-- ============================================
INSERT INTO monitoring_pelanggaran (id, pelanggaran_id, guru_kepsek, catatan, status, created_at) VALUES
(1, 3, 1, 'Kasus membolos perlu ditindaklanjuti dengan panggilan orang tua', 'ditindaklanjuti', '2024-09-06 14:00:00'),
(2, 5, 1, 'Kasus mencontek perlu perhatian khusus untuk mencegah terulang', 'ditindaklanjuti', '2024-09-26 10:00:00'),
(3, 8, 1, 'Kasus merokok sangat serius, perlu konseling intensif', 'dalam_pengawasan', '2024-10-16 09:00:00'),
(4, 9, 1, 'Kasus berkelahi memerlukan mediasi dan konseling BK', 'dalam_pengawasan', '2024-10-21 08:00:00');

-- ============================================
-- 15. TABEL VERIFIKASI DATA
-- ============================================
INSERT INTO verifikasi_data (id, tabel_terkait, id_terkait, guru_verifikator, status, created_at) VALUES
(1, 'pelanggaran', 1, 2, 'diverifikasi', '2024-08-15 08:00:00'),
(2, 'pelanggaran', 2, 2, 'diverifikasi', '2024-08-20 10:30:00'),
(3, 'pelanggaran', 3, 2, 'diverifikasi', '2024-09-05 14:00:00'),
(4, 'pelanggaran', 4, 2, 'diverifikasi', '2024-09-12 10:00:00'),
(5, 'pelanggaran', 5, 2, 'diverifikasi', '2024-09-25 12:00:00'),
(6, 'prestasi', 1, 2, 'diverifikasi', '2024-09-15 11:00:00'),
(7, 'prestasi', 2, 2, 'diverifikasi', '2024-09-20 15:00:00'),
(8, 'prestasi', 3, 2, 'diverifikasi', '2024-10-01 12:00:00'),
(9, 'prestasi', 4, 2, 'diverifikasi', '2024-10-10 16:00:00'),
(10, 'prestasi', 5, 2, 'diverifikasi', '2024-10-15 14:00:00'),
(11, 'pelanggaran', 7, 2, 'menunggu', '2024-11-10 14:00:00'),
(12, 'prestasi', 10, 2, 'menunggu', '2024-11-15 12:00:00');

-- ============================================
-- SELESAI
-- ============================================
-- Total Data:
-- - Tahun Aj