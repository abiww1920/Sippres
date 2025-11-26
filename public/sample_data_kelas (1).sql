-- ============================================
-- SAMPLE DATA LENGKAP - SEMUA TABEL
-- URUTAN PENGISIAN SUDAH DIATUR AGAR TIDAK ERROR
-- ============================================

/*
URUTAN PENGISIAN TABEL (PENTING!):
1. tahun_ajaran (tidak ada FK)
2. guru (tidak ada FK)
3. users (FK: guru_id)
4. kelas (FK: wali_kelas_id -> guru)
5. siswa (FK: kelas_id -> kelas)
6. jenis_pelanggaran (tidak ada FK)
7. jenis_prestasi (tidak ada FK)
8. pelanggaran (FK: siswa_id, guru_pencatat, jenis_pelanggaran_id, tahun_ajaran_id)
9. sanksi (FK: pelanggaran_id)
10. pelaksanaan_sanksi (FK: sanksi_id)
11. prestasi (FK: siswa_id, guru_pencatat, jenis_prestasi_id, tahun_ajaran_id)
12. bimbingan_konseling (FK: siswa_id, guru_konselor)
13. monitoring_pelanggaran (FK: pelanggaran_id, guru_kepsek)
14. verifikasi_data (FK: guru_verifikator)
*/

-- ============================================
-- 1. TAHUN AJARAN (ISI PERTAMA - TIDAK ADA FK)
-- ============================================
INSERT INTO tahun_ajaran (id, tahun_ajaran, semester, status_aktif, created_at) VALUES
(1, '2024/2025', 'Ganjil', 'aktif', NOW()),
(2, '2023/2024', 'Genap', 'tidak_aktif', NOW());

-- ============================================
-- 2. DATA GURU (ISI KEDUA - TIDAK ADA FK)
-- ============================================
INSERT INTO guru (id, nip, nama_guru, mata_pelajaran, jabatan, created_at) VALUES
(1, '198501012010011001', 'Budi Santoso, S.Kom', 'Pemrograman Web', 'Guru', NOW()),
(2, '198502022010012002', 'Sari Indah, S.Pd', 'Desain Grafis', 'Guru', NOW()),
(3, '198503032010013003', 'Andi Wijaya, S.Sn', 'Animasi 2D/3D', 'Guru', NOW()),
(4, '198504042010014004', 'Rina Marlina, S.E', 'Pemasaran Digital', 'Guru', NOW()),
(5, '198505052010015005', 'Dedi Kurniawan, S.Pd', 'Akuntansi Dasar', 'Guru', NOW()),
(6, '198506062010016006', 'Maya Sari, S.Pd', 'Bahasa Indonesia', 'Guru', NOW()),
(7, '198507072010017007', 'Rudi Hartono, S.Pd', 'Matematika', 'Guru', NOW()),
(8, '198508082010018008', 'Lina Kusuma, S.Pd', 'Bahasa Inggris', 'Guru', NOW()),
(9, '198509092010019009', 'Agus Priyanto, S.Pd', 'PKn', 'Wakil Kepala Sekolah', NOW()),
(10, '198510102010020010', 'Dewi Lestari, S.Pd', 'Bimbingan Konseling', 'Guru BK', NOW());

-- ============================================
-- 3. DATA USERS (ISI KETIGA - FK: guru_id)
-- ============================================
INSERT INTO users (id, guru_id, username, password, level, can_verify, created_at) VALUES
(1, 1, 'budi.santoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 0, NOW()),
(2, 2, 'sari.indah', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 0, NOW()),
(3, 3, 'andi.wijaya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 0, NOW()),
(4, 4, 'rina.marlina', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 0, NOW()),
(5, 5, 'dedi.kurniawan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 0, NOW()),
(6, 6, 'maya.sari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', 0, NOW()),
(7, 7, 'rudi.hartono', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', 0, NOW()),
(8, 8, 'lina.kusuma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', 0, NOW()),
(9, 9, 'agus.priyanto', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kesiswaan', 1, NOW()),
(10, 10, 'dewi.lestari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'konselor', 0, NOW()),
(11, NULL, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NOW()),
(12, NULL, 'kepsek', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepala_sekolah', 1, NOW());

-- ============================================
-- 4. DATA KELAS (ISI KEEMPAT - FK: wali_kelas_id)
-- ============================================
INSERT INTO kelas (id, nama_kelas, jurusan, wali_kelas_id, created_at) VALUES
(1, 'XII PPLG 1', 'Pengembangan Perangkat Lunak dan Gim', 1, NOW()),
(2, 'XII DKV 1', 'Desain Komunikasi Visual', 2, NOW()),
(3, 'XII ANI 1', 'Animasi', 3, NOW()),
(4, 'XII PM 1', 'Pemasaran', 4, NOW()),
(5, 'XII AKL 1', 'Akuntansi dan Keuangan Lembaga', 5, NOW());

-- ============================================
-- 5. DATA SISWA (ISI KELIMA - FK: kelas_id)
-- ============================================

-- Kelas XII PPLG 1
INSERT INTO siswa (id, nis, nama_siswa, kelas_id, jenis_kelamin, created_at) VALUES
(1, '2022001', 'Andi Prasetyo', 1, 'L', NOW()),
(2, '2022002', 'Dewi Lestari', 1, 'P', NOW()),
(3, '2022003', 'Rizky Firmansyah', 1, 'L', NOW()),
(4, '2022004', 'Sinta Maharani', 1, 'P', NOW()),
(5, '2022005', 'Farhan Maulana', 1, 'L', NOW()),
(6, '2022006', 'Rania Putri', 1, 'P', NOW()),

-- Kelas XII DKV 1
(7, '2022007', 'Indah Permata', 2, 'P', NOW()),
(8, '2022008', 'Bayu Saputra', 2, 'L', NOW()),
(9, '2022009', 'Citra Ayu', 2, 'P', NOW()),
(10, '2022010', 'Dimas Wijaya', 2, 'L', NOW()),
(11, '2022011', 'Zahra Azzahra', 2, 'P', NOW()),
(12, '2022012', 'Kevin Ananda', 2, 'L', NOW()),

-- Kelas XII ANI 1
(13, '2022013', 'Nadia Rahma', 3, 'P', NOW()),
(14, '2022014', 'Ilham Maulana', 3, 'L', NOW()),
(15, '2022015', 'Maya Safitri', 3, 'P', NOW()),
(16, '2022016', 'Yoga Pratama', 3, 'L', NOW()),
(17, '2022017', 'Salsa Bila', 3, 'P', NOW()),
(18, '2022018', 'Raffi Ahmad', 3, 'L', NOW()),

-- Kelas XII PM 1
(19, '2022019', 'Putri Cantika', 4, 'P', NOW()),
(20, '2022020', 'Arief Rachman', 4, 'L', NOW()),
(21, '2022021', 'Lina Marlina', 4, 'P', NOW()),
(22, '2022022', 'Hendra Gunawan', 4, 'L', NOW()),
(23, '2022023', 'Tika Sari', 4, 'P', NOW()),
(24, '2022024', 'Bima Sakti', 4, 'L', NOW()),

-- Kelas XII AKL 1
(25, '2022025', 'Annisa Fitri', 5, 'P', NOW()),
(26, '2022026', 'Ryan Hidayat', 5, 'L', NOW()),
(27, '2022027', 'Dinda Puspita', 5, 'P', NOW()),
(28, '2022028', 'Eko Prasetyo', 5, 'L', NOW()),
(29, '2022029', 'Fitria Wulandari', 5, 'P', NOW()),
(30, '2022030', 'Agus Setiawan', 5, 'L', NOW());

-- ============================================
-- 6. JENIS PELANGGARAN (ISI KEENAM - TIDAK ADA FK)
-- ============================================
INSERT INTO jenis_pelanggaran (id, nama_pelanggaran, poin, kategori, sanksi_rekomendasi, created_at) VALUES
-- PELANGGARAN RINGAN (1-15 poin)
(1, 'Terlambat masuk sekolah', 5, 'ringan', 'Teguran lisan + surat pernyataan', NOW()),
(2, 'Tidak mengerjakan tugas', 3, 'ringan', 'Mengerjakan tugas + teguran', NOW()),
(3, 'Tidak memakai atribut lengkap', 2, 'ringan', 'Teguran + melengkapi atribut', NOW()),
(4, 'Tidak membawa buku pelajaran', 2, 'ringan', 'Teguran lisan', NOW()),
(5, 'Ribut di kelas', 5, 'ringan', 'Teguran + berdiri di depan kelas', NOW()),

-- PELANGGARAN SEDANG (16-30 poin)
(6, 'Tidak masuk tanpa keterangan', 20, 'sedang', 'Panggilan ortu + surat pernyataan', NOW()),
(7, 'Berbohong kepada guru', 15, 'sedang', 'Konseling BK + surat pernyataan', NOW()),
(8, 'Berkelahi ringan', 25, 'sedang', 'Skorsing 1 hari + konseling BK', NOW()),
(9, 'Membuat keributan di sekolah', 18, 'sedang', 'Panggilan ortu + membersihkan lingkungan', NOW()),
(10, 'Memalsukan tanda tangan', 20, 'sedang', 'Panggilan ortu + surat pernyataan', NOW()),

-- PELANGGARAN BERAT (31-50 poin)
(11, 'Merokok di area sekolah', 40, 'berat', 'Skorsing 3 hari + konseling + panggilan ortu', NOW()),
(12, 'Membawa senjata tajam', 45, 'berat', 'Skorsing 5 hari + diserahkan ke polisi', NOW()),
(13, 'Berkelahi berat', 40, 'berat', 'Skorsing 3 hari + konseling intensif', NOW()),
(14, 'Mencuri barang teman', 35, 'berat', 'Skorsing + ganti rugi + konseling', NOW()),
(15, 'Merusak fasilitas sekolah', 30, 'berat', 'Ganti rugi + kerja sosial 1 minggu', NOW()),

-- PELANGGARAN SANGAT BERAT (51+ poin)
(16, 'Narkoba', 100, 'sangat_berat', 'Dikeluarkan + diserahkan ke pihak berwajib', NOW()),
(17, 'Pelecehan seksual', 100, 'sangat_berat', 'Dikeluarkan + diserahkan ke pihak berwajib', NOW()),
(18, 'Tawuran antar sekolah', 80, 'sangat_berat', 'Skorsing 1 bulan + konseling + panggilan ortu', NOW()),
(19, 'Melawan guru/kepala sekolah', 70, 'sangat_berat', 'Skorsing 2 minggu + konseling intensif', NOW()),
(20, 'Membawa/konsumsi miras', 60, 'sangat_berat', 'Skorsing 1 minggu + konseling + panggilan ortu', NOW());

-- ============================================
-- 7. JENIS PRESTASI (ISI KETUJUH - TIDAK ADA FK)
-- ============================================
INSERT INTO jenis_prestasi (id, nama_prestasi, poin, kategori, penghargaan, created_at) VALUES
-- PRESTASI AKADEMIK
(1, 'Juara 1 Olimpiade Nasional', 100, 'akademik', 'Piagam + beasiswa 1 semester', NOW()),
(2, 'Juara 2 Olimpiade Nasional', 80, 'akademik', 'Piagam + uang pembinaan', NOW()),
(3, 'Juara 3 Olimpiade Nasional', 60, 'akademik', 'Piagam + uang pembinaan', NOW()),
(4, 'Juara 1 Olimpiade Provinsi', 50, 'akademik', 'Piagam + beasiswa 1 bulan', NOW()),
(5, 'Juara 1 Olimpiade Kota', 30, 'akademik', 'Piagam', NOW()),
(6, 'Ranking 1 Kelas', 20, 'akademik', 'Piagam', NOW()),
(7, 'Ranking 2 Kelas', 15, 'akademik', 'Piagam', NOW()),
(8, 'Ranking 3 Kelas', 10, 'akademik', 'Piagam', NOW()),

-- PRESTASI NON-AKADEMIK
(9, 'Juara 1 LKS Nasional', 100, 'non_akademik', 'Piagam + beasiswa', NOW()),
(10, 'Juara 2 LKS Nasional', 80, 'non_akademik', 'Piagam + uang pembinaan', NOW()),
(11, 'Juara 1 Lomba Seni Nasional', 70, 'non_akademik', 'Piagam + hadiah', NOW()),
(12, 'Juara 1 Olahraga Provinsi', 60, 'non_akademik', 'Piagam + hadiah', NOW()),
(13, 'Juara Lomba Desain Kota', 40, 'non_akademik', 'Piagam', NOW()),
(14, 'Ketua OSIS', 30, 'non_akademik', 'SK Pengurus', NOW()),
(15, 'Pengurus OSIS', 15, 'non_akademik', 'SK Pengurus', NOW());

-- ============================================
-- 8. DATA PELANGGARAN (ISI KEDELAPAN - FK: siswa_id, guru_pencatat, jenis_pelanggaran_id, tahun_ajaran_id)
-- ============================================
INSERT INTO pelanggaran (id, siswa_id, guru_pencatat, jenis_pelanggaran_id, tahun_ajaran_id, poin, keterangan, status_verifikasi, created_at) VALUES
-- Pelanggaran siswa PPLG
(1, 1, 9, 1, 1, 5, 'Terlambat 15 menit tanpa alasan jelas', 'diverifikasi', '2024-11-01 07:30:00'),
(2, 3, 1, 2, 1, 3, 'Tidak mengerjakan tugas pemrograman web', 'diverifikasi', '2024-11-02 10:00:00'),
(3, 5, 10, 5, 1, 5, 'Ribut saat pelajaran Bahasa Inggris', 'diverifikasi', '2024-11-03 09:00:00'),

-- Pelanggaran siswa DKV
(4, 7, 2, 3, 1, 2, 'Tidak memakai seragam lengkap', 'diverifikasi', '2024-11-01 07:00:00'),
(5, 10, 9, 6, 1, 20, 'Tidak masuk 2 hari tanpa keterangan', 'menunggu', '2024-11-04 08:00:00'),

-- Pelanggaran siswa Animasi
(6, 13, 3, 1, 1, 5, 'Terlambat masuk kelas', 'diverifikasi', '2024-11-05 07:45:00'),
(7, 16, 10, 7, 1, 15, 'Berbohong tentang sakit', 'diverifikasi', '2024-11-05 10:00:00'),

-- Pelanggaran siswa Pemasaran
(8, 19, 4, 2, 1, 3, 'Tidak mengerjakan tugas', 'diverifikasi', '2024-11-06 08:00:00'),
(9, 22, 9, 8, 1, 25, 'Berkelahi dengan teman sekelas', 'diverifikasi', '2024-11-06 11:00:00'),

-- Pelanggaran siswa Akuntansi
(10, 25, 5, 4, 1, 2, 'Tidak membawa buku akuntansi', 'diverifikasi', '2024-11-07 08:00:00'),
(11, 28, 9, 11, 1, 40, 'Kedapatan merokok di toilet', 'diverifikasi', '2024-11-08 09:30:00');

-- ============================================
-- 9. DATA SANKSI (ISI KESEMBILAN - FK: pelanggaran_id)
-- ============================================
INSERT INTO sanksi (id, pelanggaran_id, jenis_sanksi, deskripsi_sanksi, tanggal_mulai, tanggal_selesai, status, created_at) VALUES
(1, 1, 'Teguran Tertulis', 'Membuat surat pernyataan tidak akan terlambat lagi', '2024-11-01', '2024-11-01', 'selesai', NOW()),
(2, 2, 'Tugas Tambahan', 'Mengerjakan ulang tugas pemrograman dengan tambahan fitur', '2024-11-02', '2024-11-05', 'selesai', NOW()),
(3, 3, 'Teguran Lisan', 'Berdiri di depan kelas selama 30 menit', '2024-11-03', '2024-11-03', 'selesai', NOW()),
(4, 4, 'Teguran Lisan', 'Melengkapi atribut seragam besok', '2024-11-01', '2024-11-02', 'selesai', NOW()),
(5, 5, 'Panggilan Orang Tua', 'Orang tua dipanggil ke sekolah + surat pernyataan', '2024-11-05', '2024-11-06', 'berjalan', NOW()),
(6, 6, 'Teguran Tertulis', 'Surat pernyataan tidak terlambat', '2024-11-05', '2024-11-05', 'selesai', NOW()),
(7, 7, 'Konseling BK', 'Konseling tentang kejujuran + surat pernyataan', '2024-11-06', '2024-11-08', 'selesai', NOW()),
(8, 8, 'Tugas Tambahan', 'Mengerjakan tugas pemasaran tambahan', '2024-11-06', '2024-11-09', 'berjalan', NOW()),
(9, 9, 'Skorsing', 'Skorsing 1 hari + konseling BK + panggilan ortu', '2024-11-07', '2024-11-07', 'selesai', NOW()),
(10, 10, 'Teguran Lisan', 'Teguran dan harus membawa buku besok', '2024-11-07', '2024-11-08', 'selesai', NOW()),
(11, 11, 'Skorsing', 'Skorsing 3 hari + konseling intensif + panggilan ortu', '2024-11-09', '2024-11-11', 'berjalan', NOW());

-- ============================================
-- 10. PELAKSANAAN SANKSI (ISI KESEPULUH - FK: sanksi_id)
-- ============================================
INSERT INTO pelaksanaan_sanksi (id, sanksi_id, tanggal_pelaksanaan, bukti_pelaksanaan, catatan, status, created_at) VALUES
(1, 1, '2024-11-01', 'surat_pernyataan_001.pdf', 'Siswa sudah membuat surat pernyataan dengan tanda tangan ortu', 'tuntas', NOW()),
(2, 2, '2024-11-05', 'tugas_pemrograman_revisi.zip', 'Tugas sudah dikerjakan dengan baik, ada penambahan fitur login', 'tuntas', NOW()),
(3, 3, '2024-11-03', '-', 'Siswa sudah berdiri di depan kelas, berjanji tidak mengulangi', 'tuntas', NOW()),
(4, 4, '2024-11-02', 'foto_seragam_lengkap.jpg', 'Siswa sudah datang dengan seragam lengkap', 'tuntas', NOW()),
(5, 6, '2024-11-05', 'surat_pernyataan_006.pdf', 'Surat pernyataan sudah ditandatangani ortu', 'tuntas', NOW()),
(6, 7, '2024-11-08', 'form_konseling_bk_001.pdf', 'Sudah konseling 2x, siswa menunjukkan penyesalan', 'tuntas', NOW()),
(7, 9, '2024-11-07', 'form_skorsing_001.pdf', 'Skorsing dilaksanakan, ortu sudah datang ke sekolah', 'tuntas', NOW()),
(8, 10, '2024-11-08', '-', 'Siswa sudah membawa buku akuntansi lengkap', 'tuntas', NOW());

-- ============================================
-- 11. DATA PRESTASI (ISI KESEBELAS - FK: siswa_id, guru_pencatat, jenis_prestasi_id, tahun_ajaran_id)
-- ============================================
INSERT INTO prestasi (id, siswa_id, guru_pencatat, jenis_prestasi_id, tahun_ajaran_id, poin, keterangan, status_verifikasi, created_at) VALUES
-- Prestasi siswa PPLG
(1, 2, 1, 9, 1, 100, 'Juara 1 LKS Web Technology tingkat Nasional', 'diverifikasi', '2024-10-15'),
(2, 4, 1, 6, 1, 20, 'Ranking 1 kelas semester ganjil', 'diverifikasi', '2024-10-20'),

-- Prestasi siswa DKV
(3, 9, 2, 11, 1, 70, 'Juara 1 Lomba Desain Poster tingkat Nasional', 'diverifikasi', '2024-10-10'),
(4, 11, 2, 13, 1, 40, 'Juara 2 Lomba Logo tingkat Kota', 'diverifikasi', '2024-10-25'),

-- Prestasi siswa Animasi
(5, 15, 3, 7, 1, 15, 'Ranking 2 kelas semester ganjil', 'diverifikasi', '2024-10-20'),
(6, 17, 3, 11, 1, 70, 'Juara 1 Festival Animasi Pelajar Nasional', 'menunggu', '2024-11-01'),

-- Prestasi siswa Pemasaran
(7, 21, 4, 14, 1, 30, 'Ketua OSIS periode 2024/2025', 'diverifikasi', '2024-09-01'),
(8, 23, 4, 8, 1, 10, 'Ranking 3 kelas semester ganjil', 'diverifikasi', '2024-10-20'),

-- Prestasi siswa Akuntansi
(9, 27, 5, 6, 1, 20, 'Ranking 1 kelas semester ganjil', 'diverifikasi', '2024-10-20'),
(10, 29, 5, 4, 1, 50, 'Juara 1 Olimpiade Akuntansi tingkat Provinsi', 'diverifikasi', '2024-10-12');

-- ============================================
-- 12. BIMBINGAN KONSELING (ISI KEDUABELAS - FK: siswa_id, guru_konselor)
-- ============================================
INSERT INTO bimbingan_konseling (id, siswa_id, guru_konselor, topik, tindakan, status, created_at) VALUES
(1, 5, 7, 'Sering ribut di kelas', 'Konseling individu tentang etika di kelas dan dampak ganggu teman', 'selesai', '2024-11-03'),
(2, 10, 7, 'Bolos sekolah', 'Konseling + panggilan ortu, mencari tahu penyebab sering bolos', 'diproses', '2024-11-04'),
(3, 16, 7, 'Berbohong ke guru', 'Konseling tentang kejujuran dan konsekuensi berbohong', 'selesai', '2024-11-05'),
(4, 22, 7, 'Berkelahi', 'Konseling individu + mediasi dengan korban, pembinaan sikap', 'selesai', '2024-11-06'),
(5, 28, 7, 'Merokok di sekolah', 'Konseling intensif tentang bahaya rokok + panggilan ortu', 'diproses', '2024-11-09');

-- ============================================
-- 13. MONITORING PELANGGARAN (ISI KETIGABELAS - FK: pelanggaran_id, guru_kepsek)
-- ============================================
INSERT INTO monitoring_pelanggaran (id, pelanggaran_id, guru_kepsek, catatan, status, created_at) VALUES
(1, 9, 6, 'Kasus berkelahi perlu dimonitor, pastikan tidak terulang', 'dimonitor', '2024-11-06'),
(2, 11, 6, 'Kasus merokok sangat serius, perlu perhatian khusus dan follow up intensif', 'prioritas', '2024-11-08'),
(3, 5, 6, 'Kasus bolos berulang, perlu kerjasama dengan ortu dan BK', 'dimonitor', '2024-11-05');

-- ============================================
-- 14. VERIFIKASI DATA (ISI KEEMPATBELAS - FK: guru_verifikator)
-- ============================================
INSERT INTO verifikasi_data (id, tabel_terkait, id_terkait, guru_verifikator, status, created_at) VALUES
-- Verifikasi pelanggaran
(1, 'pelanggaran', 1, 8, 'diverifikasi', '2024-11-01 08:00:00'),
(2, 'pelanggaran', 2, 8, 'diverifikasi', '2024-11-02 10:30:00'),
(3, 'pelanggaran', 3, 8, 'diverifikasi', '2024-11-03 09:30:00'),
(4, 'pelanggaran', 5, 8, 'menunggu', '2024-11-04 08:30:00'),

-- Verifikasi prestasi
(5, 'prestasi', 1, 8, 'diverifikasi', '2024-10-15 14:00:00'),
(6, 'prestasi', 2, 8, 'diverifikasi', '2024-10-20 15:00:00'),
(7, 'prestasi', 3, 8, 'diverifikasi', '2024-10-10 13:00:00'),
(8, 'prestasi', 6, 8, 'menunggu', '2024-11-01 10:00:00');

-- ============================================
-- QUERY CEK DATA (UNTUK VERIFIKASI)
-- ============================================

-- 1. Cek semua kelas dengan wali kelas dan jumlah siswa
SELECT 
    k.id,
    k.nama_kelas,
    k.jurusan,
    g.nama_guru AS wali_kelas,
    COUNT(s.id) AS jumlah_siswa
FROM kelas k
LEFT JOIN guru g ON k.wali_kelas_id = g.id
LEFT JOIN siswa s ON k.id = s.kelas_id
GROUP BY k.id, k.nama_kelas, k.jurusan, g.nama_guru
ORDER BY k.id;

-- Lihat semua siswa per kelas
SELECT 
    k.nama_kelas,
    k.jurusan,
    s.nis,
    s.nama_siswa,
    s.jenis_kelamin
FROM siswa s
JOIN kelas k ON s.kelas_id = k.id
ORDER BY k.id, s.nama_siswa;

-- 2. Cek pelanggaran per kelas
SELECT 
    k.nama_kelas,
    s.nama_siswa,
    jp.nama_pelanggaran,
    p.poin,
    p.keterangan,
    p.status_verifikasi,
    DATE_FORMAT(p.created_at, '%d-%m-%Y') as tanggal
FROM pelanggaran p
JOIN siswa s ON p.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
JOIN jenis_pelanggaran jp ON p.jenis_pelanggaran_id = jp.id
ORDER BY p.created_at DESC;

-- 3. Cek prestasi per kelas
SELECT 
    k.nama_kelas,
    s.nama_siswa,
    jp.nama_prestasi,
    pr.poin,
    pr.status_verifikasi,
    DATE_FORMAT(pr.created_at, '%d-%m-%Y') as tanggal
FROM prestasi pr
JOIN siswa s ON pr.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
JOIN jenis_prestasi jp ON pr.jenis_prestasi_id = jp.id
ORDER BY pr.poin DESC;

-- 4. Cek sanksi yang sedang berjalan
SELECT 
    s.nama_siswa,
    k.nama_kelas,
    jp.nama_pelanggaran,
    sk.jenis_sanksi,
    sk.deskripsi_sanksi,
    sk.status,
    DATE_FORMAT(sk.tanggal_mulai, '%d-%m-%Y') as mulai,
    DATE_FORMAT(sk.tanggal_selesai, '%d-%m-%Y') as selesai
FROM sanksi sk
JOIN pelanggaran p ON sk.pelanggaran_id = p.id
JOIN siswa s ON p.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
JOIN jenis_pelanggaran jp ON p.jenis_pelanggaran_id = jp.id
WHERE sk.status IN ('berjalan', 'direncanakan')
ORDER BY sk.tanggal_mulai;

-- 5. Rekap poin siswa (pelanggaran vs prestasi)
SELECT 
    s.nama_siswa,
    k.nama_kelas,
    COALESCE(SUM(pel.poin), 0) as total_pelanggaran,
    COALESCE(SUM(pres.poin), 0) as total_prestasi,
    COALESCE(SUM(pres.poin), 0) - COALESCE(SUM(pel.poin), 0) as saldo_poin
FROM siswa s
JOIN kelas k ON s.kelas_id = k.id
LEFT JOIN pelanggaran pel ON s.id = pel.siswa_id AND pel.status_verifikasi = 'diverifikasi'
LEFT JOIN prestasi pres ON s.id = pres.siswa_id AND pres.status_verifikasi = 'diverifikasi'
GROUP BY s.id, s.nama_siswa, k.nama_kelas
ORDER BY saldo_poin DESC;

-- 6. Siswa yang sedang dalam bimbingan BK
SELECT 
    s.nama_siswa,
    k.nama_kelas,
    bk.topik,
    bk.status,
    DATE_FORMAT(bk.created_at, '%d-%m-%Y') as tanggal
FROM bimbingan_konseling bk
JOIN siswa s ON bk.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
WHERE bk.status IN ('diproses', 'tindak_lanjut')
ORDER BY bk.created_at DESC;

-- 7. Dashboard Kepala Sekolah - Statistik
SELECT 
    'Total Pelanggaran' as keterangan, 
    COUNT(*) as jumlah 
FROM pelanggaran WHERE status_verifikasi = 'diverifikasi'
UNION ALL
SELECT 
    'Total Prestasi', 
    COUNT(*) 
FROM prestasi WHERE status_verifikasi = 'diverifikasi'
UNION ALL
SELECT 
    'Sanksi Berjalan', 
    COUNT(*) 
FROM sanksi WHERE status = 'berjalan'
UNION ALL
SELECT 
    'Kasus BK Aktif', 
    COUNT(*) 
FROM bimbingan_konseling WHERE status IN ('diproses', 'tindak_lanjut');

-- ============================================
-- INFORMASI LOGIN
-- ============================================
/*
DATA LOGIN UNTUK TESTING:

1. Kepala Sekolah:
   Username: kepsek
   Password: kepsek123
   Level: kepsek

2. Kesiswaan:
   Username: kesiswaan
   Password: kesiswaan123
   Level: kesiswaan

3. Konselor BK:
   Username: konselor
   Password: konselor123
   Level: konselor

4. Wali Kelas PPLG:
   Username: budi.santoso
   Password: guru123
   Level: wali_kelas

5. Wali Kelas DKV:
   Username: siti.nurhaliza
   Password: guru123
   Level: wali_kelas

6. Wali Kelas Animasi:
   Username: ahmad.fauzi
   Password: guru123
   Level: wali_kelas

7. Wali Kelas Pemasaran:
   Username: rina.wijaya
   Password: guru123
   Level: wali_kelas

8. Wali Kelas Akuntansi:
   Username: dedi.kurniawan
   Password: guru123
   Level: wali_kelas

9. Guru Matematika:
   Username: ani.rahmawati
   Password: guru123
   Level: guru

10. Guru Bahasa Inggris:
    Username: rudi.hartono
    Password: guru123
    Level: guru

Note: Semua password sudah di-hash dengan MD5
*/