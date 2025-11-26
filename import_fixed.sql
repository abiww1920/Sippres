-- ============================================
-- FIXED SQL IMPORT FOR LARAGON
-- Handles foreign key constraints properly
-- ============================================

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Clear existing data safely
DELETE FROM verifikasi_data;
DELETE FROM monitoring_pelanggaran;
DELETE FROM bimbingan_konseling;
DELETE FROM pelaksanaan_sanksi;
DELETE FROM sanksi;
DELETE FROM pelanggaran;
DELETE FROM prestasi;
DELETE FROM jenis_prestasi;
DELETE FROM jenis_pelanggaran;
DELETE FROM jenis_sanksi;
DELETE FROM users WHERE id > 1; -- Keep admin user
DELETE FROM siswa;
DELETE FROM kelas;
DELETE FROM guru WHERE id > 1; -- Keep some basic data
DELETE FROM tahun_ajaran;

-- Reset auto increment
ALTER TABLE verifikasi_data AUTO_INCREMENT = 1;
ALTER TABLE monitoring_pelanggaran AUTO_INCREMENT = 1;
ALTER TABLE bimbingan_konseling AUTO_INCREMENT = 1;
ALTER TABLE pelaksanaan_sanksi AUTO_INCREMENT = 1;
ALTER TABLE sanksi AUTO_INCREMENT = 1;
ALTER TABLE pelanggaran AUTO_INCREMENT = 1;
ALTER TABLE prestasi AUTO_INCREMENT = 1;
ALTER TABLE jenis_prestasi AUTO_INCREMENT = 1;
ALTER TABLE jenis_pelanggaran AUTO_INCREMENT = 1;
ALTER TABLE jenis_sanksi AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 2;
ALTER TABLE siswa AUTO_INCREMENT = 1;
ALTER TABLE kelas AUTO_INCREMENT = 1;
ALTER TABLE guru AUTO_INCREMENT = 2;
ALTER TABLE tahun_ajaran AUTO_INCREMENT = 1;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Insert basic data
INSERT INTO tahun_ajaran (tahun_ajaran, semester, status_aktif, created_at) VALUES
('2024/2025', 'ganjil', 1, NOW()),
('2024/2025', 'genap', 0, NOW());

INSERT INTO guru (nip, nama_guru, bidang_studi, status, created_at) VALUES
('198501012010011001', 'Deni Danis, S.Kom', 'Pemrograman', 'aktif', NOW()),
('198703152011012002', 'Syifa Febrianti, S.Sn', 'Desain Grafis', 'aktif', NOW()),
('198906202012011003', 'Ahmad Fauzi, S.Sn', 'Animasi', 'aktif', NOW()),
('199002102013012004', 'Rina Wijaya, S.E', 'Pemasaran', 'aktif', NOW()),
('198808252014011005', 'Dedi Kurniawan, S.E', 'Akuntansi', 'aktif', NOW()),
('198512102009011006', 'Dr. Hendra Wijaya, M.Pd', 'Kepala Sekolah', 'aktif', NOW()),
('198709152010012007', 'Lilis Suryani, S.Pd', 'BK', 'aktif', NOW()),
('199001202011011008', 'Bambang Supriyanto, S.Pd', 'Kesiswaan', 'aktif', NOW());

INSERT INTO kelas (nama_kelas, jurusan, wali_kelas_id, created_at) VALUES
('X RPL 1', 'Rekayasa Perangkat Lunak', 2, NOW()),
('X RPL 2', 'Rekayasa Perangkat Lunak', 3, NOW()),
('XI RPL 1', 'Rekayasa Perangkat Lunak', 4, NOW()),
('XI RPL 2', 'Rekayasa Perangkat Lunak', 5, NOW()),
('XII RPL 1', 'Rekayasa Perangkat Lunak', 6, NOW());

INSERT INTO jenis_pelanggaran (nama_pelanggaran, poin, kategori, sanksi_rekomendasi, created_at) VALUES
('Terlambat masuk sekolah', 5, 'ringan', 'Teguran lisan + surat pernyataan', NOW()),
('Tidak mengerjakan tugas', 3, 'ringan', 'Mengerjakan tugas + teguran', NOW()),
('Tidak memakai atribut lengkap', 2, 'ringan', 'Teguran + melengkapi atribut', NOW()),
('Ribut di kelas', 5, 'ringan', 'Teguran + berdiri di depan kelas', NOW()),
('Tidak masuk tanpa keterangan', 20, 'sedang', 'Panggilan ortu + surat pernyataan', NOW()),
('Berbohong kepada guru', 15, 'sedang', 'Konseling BK + surat pernyataan', NOW()),
('Berkelahi ringan', 25, 'sedang', 'Skorsing 1 hari + konseling BK', NOW()),
('Merokok di area sekolah', 40, 'berat', 'Skorsing 3 hari + konseling + panggilan ortu', NOW()),
('Membawa senjata tajam', 45, 'berat', 'Skorsing 5 hari + diserahkan ke polisi', NOW()),
('Narkoba', 100, 'sangat_berat', 'Dikeluarkan + diserahkan ke pihak berwajib', NOW());

INSERT INTO jenis_prestasi (nama_prestasi, poin, kategori, penghargaan, created_at) VALUES
('Juara 1 Kelas', 20, 'akademik', 'Piagam', NOW()),
('Juara 2 Kelas', 15, 'akademik', 'Piagam', NOW()),
('Juara 3 Kelas', 10, 'akademik', 'Piagam', NOW()),
('Juara 1 LKS Nasional', 100, 'non_akademik', 'Piagam + beasiswa', NOW()),
('Juara 1 Lomba Seni Nasional', 70, 'non_akademik', 'Piagam + hadiah', NOW()),
('Ketua OSIS', 30, 'non_akademik', 'SK Pengurus', NOW());

-- Sample siswa data
INSERT INTO siswa (nis, nama_siswa, kelas_id, jenis_kelamin, status, created_at) VALUES
('2022001', 'Andi Prasetyo', 1, 'L', 'aktif', NOW()),
('2022002', 'Dewi Lestari', 1, 'P', 'aktif', NOW()),
('2022003', 'Rizky Firmansyah', 2, 'L', 'aktif', NOW()),
('2022004', 'Sinta Maharani', 2, 'P', 'aktif', NOW()),
('2022005', 'Farhan Maulana', 3, 'L', 'aktif', NOW());

COMMIT;