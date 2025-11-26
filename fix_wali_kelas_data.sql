-- Fix untuk masalah wali kelas dan data kelas

-- 1. Tambah guru Handi Radiman S.sn
INSERT INTO `guru` (`id`, `nip`, `nama_guru`, `bidang_studi`, `status`, `created_at`, `updated_at`) VALUES
(11, '198501012010011005', 'Handi Radiman S.sn', 'Seni Budaya', 'aktif', NOW(), NOW());

-- 2. Tambah data kelas yang hilang
INSERT INTO `kelas` (`id`, `nama_kelas`, `jurusan`, `wali_kelas_id`, `created_at`, `updated_at`) VALUES
(1, 'XII RPL 1', 'RPL', 1, NOW(), NOW()),
(2, 'XII RPL 2', 'RPL', 2, NOW(), NOW()),
(3, 'XI RPL 1', 'RPL', 3, NOW(), NOW()),
(4, 'XI RPL 2', 'RPL', 11, NOW(), NOW()),
(5, 'X RPL 1', 'RPL', 5, NOW(), NOW());

-- 3. Update user wali kelas untuk menggunakan guru Handi Radiman
UPDATE `users` SET `guru_id` = 11 WHERE `level` = 'wali_kelas' AND `username` = 'walikelas';

-- 4. Atau buat user baru untuk Handi Radiman
INSERT INTO `users` (`username`, `email`, `password`, `level`, `guru_id`, `can_verify`, `created_at`, `updated_at`) VALUES
('handi', 'handi@smk.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wali_kelas', 11, 0, NOW(), NOW());