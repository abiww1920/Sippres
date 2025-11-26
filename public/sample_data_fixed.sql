-- ============================================
-- DATABASE: sistem-poin-pelanggaran (LENGKAP)
-- Sesuai Requirements PDF UJI KOMPETENSI
-- ============================================

USE `sistem-poin-pelanggaran`;

-- ============================================
-- MODIFIKASI Tabel USERS (Jika Belum Ada Kolom yang Dibutuhkan)
-- ============================================

-- Cek apakah kolom guru_id sudah ada, jika belum tambahkan
SET @col_exists = (SELECT COUNT(*) 
                   FROM information_schema.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'users' 
                   AND COLUMN_NAME = 'guru_id');

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `users` ADD COLUMN `guru_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `id`',
    'SELECT "Column guru_id already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Cek apakah kolom level sudah ada, jika belum tambahkan
SET @col_exists = (SELECT COUNT(*) 
                   FROM information_schema.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'users' 
                   AND COLUMN_NAME = 'level');

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `users` ADD COLUMN `level` enum(\'admin\',\'kesiswaan\',\'guru\',\'wali_kelas\',\'konselor\',\'kepala_sekolah\',\'siswa\',\'ortu\') NOT NULL DEFAULT \'guru\' AFTER `password`',
    'SELECT "Column level already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Cek apakah kolom can_verify sudah ada, jika belum tambahkan
SET @col_exists = (SELECT COUNT(*) 
                   FROM information_schema.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'users' 
                   AND COLUMN_NAME = 'can_verify');

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `users` ADD COLUMN `can_verify` tinyint(1) NOT NULL DEFAULT 0 AFTER `level`',
    'SELECT "Column can_verify already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Tambahkan foreign key jika belum ada
SET @fk_exists = (SELECT COUNT(*) 
                  FROM information_schema.TABLE_CONSTRAINTS 
                  WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = 'users' 
                  AND CONSTRAINT_NAME = 'users_guru_id_foreign');

SET @sql = IF(@fk_exists = 0,
    'ALTER TABLE `users` ADD CONSTRAINT `users_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL',
    'SELECT "Foreign key users_guru_id_foreign already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Data Seed untuk USERS
INSERT INTO `users` (`id`, `guru_id`, `username`, `password`, `email`, `level`, `can_verify`, `created_at`) VALUES
(1, NULL, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@sekolah.com', 'admin', 1, NOW()),
(2, 8, 'kesiswaan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kesiswaan@sekolah.com', 'kesiswaan', 1, NOW()),
(3, 6, 'kepsek', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepsek@sekolah.com', 'kepala_sekolah', 0, NOW()),
(4, 7, 'konselor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bk@sekolah.com', 'konselor', 0, NOW()),
(5, 1, 'guru_deni', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'deni@sekolah.com', 'wali_kelas', 0, NOW()),
(6, 2, 'guru_syifa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'syifa@sekolah.com', 'wali_kelas', 0, NOW()),
(7, 9, 'guru_ani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ani@sekolah.com', 'guru', 0, NOW());

-- Password default semua: "password"


-- ============================================
-- DATA SEED untuk JENIS_SANKSI (YANG MASIH KOSONG)
-- ============================================

INSERT INTO `jenis_sanksi` (`id`, `nama_sanksi`, `kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Teguran Lisan', 'Ringan', 'Teguran secara lisan oleh guru/wali kelas', NOW()),
(2, 'Teguran Tertulis', 'Ringan', 'Surat pernyataan tidak akan mengulangi pelanggaran', NOW()),
(3, 'Tugas Tambahan', 'Ringan', 'Mengerjakan tugas tambahan sesuai mata pelajaran', NOW()),
(4, 'Berdiri di Depan Kelas', 'Ringan', 'Berdiri di depan kelas selama waktu tertentu', NOW()),
(5, 'Panggilan Orang Tua', 'Sedang', 'Orang tua dipanggil ke sekolah untuk pembinaan', NOW()),
(6, 'Konseling BK', 'Sedang', 'Bimbingan konseling dengan guru BK', NOW()),
(7, 'Kerja Sosial', 'Sedang', 'Membersihkan lingkungan sekolah/tugas sosial lainnya', NOW()),
(8, 'Skorsing 1 Hari', 'Berat', 'Tidak boleh masuk sekolah selama 1 hari', NOW()),
(9, 'Skorsing 3 Hari', 'Berat', 'Tidak boleh masuk sekolah selama 3 hari', NOW()),
(10, 'Skorsing 5 Hari', 'Berat', 'Tidak boleh masuk sekolah selama 5 hari', NOW()),
(11, 'Skorsing 1 Minggu', 'Sangat Berat', 'Tidak boleh masuk sekolah selama 1 minggu', NOW()),
(12, 'Skorsing 2 Minggu', 'Sangat Berat', 'Tidak boleh masuk sekolah selama 2 minggu', NOW()),
(13, 'Skorsing 1 Bulan', 'Sangat Berat', 'Tidak boleh masuk sekolah selama 1 bulan', NOW()),
(14, 'Penyerahan ke Pihak Berwajib', 'Sangat Berat', 'Kasus diserahkan ke polisi/pihak berwajib', NOW()),
(15, 'Dikeluarkan dari Sekolah', 'Sangat Berat', 'Siswa dikeluarkan dari sekolah', NOW());


-- ============================================
-- MIGRATION TAMBAHAN (JIKA DIPERLUKAN)
-- ============================================

-- Tambah kolom created_by dan updated_by untuk audit trail (OPSIONAL)
ALTER TABLE `pelanggaran` 
ADD COLUMN `created_by` bigint(20) UNSIGNED DEFAULT NULL AFTER `status_verifikasi`,
ADD COLUMN `updated_by` bigint(20) UNSIGNED DEFAULT NULL AFTER `created_by`,
ADD KEY `pelanggaran_created_by_foreign` (`created_by`),
ADD KEY `pelanggaran_updated_by_foreign` (`updated_by`);

ALTER TABLE `prestasi` 
ADD COLUMN `created_by` bigint(20) UNSIGNED DEFAULT NULL AFTER `status_verifikasi`,
ADD COLUMN `updated_by` bigint(20) UNSIGNED DEFAULT NULL AFTER `created_by`,
ADD KEY `prestasi_created_by_foreign` (`created_by`),
ADD KEY `prestasi_updated_by_foreign` (`updated_by`);

-- Tambah index untuk performa query
CREATE INDEX idx_pelanggaran_siswa_tahun ON pelanggaran(siswa_id, tahun_ajaran_id);
CREATE INDEX idx_prestasi_siswa_tahun ON prestasi(siswa_id, tahun_ajaran_id);
CREATE INDEX idx_sanksi_status ON sanksi(status);
CREATE INDEX idx_pelaksanaan_status ON pelaksanaan_sanksi(status);


-- ============================================
-- VIEW untuk Dashboard dan Reporting (BONUS)
-- ============================================

-- View: Rekap Pelanggaran Per Siswa
CREATE OR REPLACE VIEW v_rekap_pelanggaran_siswa AS
SELECT 
    s.id AS siswa_id,
    s.nis,
    s.nama_siswa,
    k.nama_kelas,
    k.jurusan,
    COUNT(p.id) AS total_pelanggaran,
    SUM(p.poin) AS total_poin_pelanggaran,
    COUNT(CASE WHEN jp.kategori = 'ringan' THEN 1 END) AS pelanggaran_ringan,
    COUNT(CASE WHEN jp.kategori = 'sedang' THEN 1 END) AS pelanggaran_sedang,
    COUNT(CASE WHEN jp.kategori = 'berat' THEN 1 END) AS pelanggaran_berat,
    COUNT(CASE WHEN jp.kategori = 'sangat_berat' THEN 1 END) AS pelanggaran_sangat_berat
FROM siswa s
LEFT JOIN kelas k ON s.kelas_id = k.id
LEFT JOIN pelanggaran p ON s.id = p.siswa_id AND p.status_verifikasi = 'diverifikasi'
LEFT JOIN jenis_pelanggaran jp ON p.jenis_pelanggaran_id = jp.id
GROUP BY s.id, s.nis, s.nama_siswa, k.nama_kelas, k.jurusan;

-- View: Rekap Prestasi Per Siswa
CREATE OR REPLACE VIEW v_rekap_prestasi_siswa AS
SELECT 
    s.id AS siswa_id,
    s.nis,
    s.nama_siswa,
    k.nama_kelas,
    k.jurusan,
    COUNT(pr.id) AS total_prestasi,
    SUM(pr.poin) AS total_poin_prestasi,
    COUNT(CASE WHEN jp.kategori = 'akademik' THEN 1 END) AS prestasi_akademik,
    COUNT(CASE WHEN jp.kategori = 'non_akademik' THEN 1 END) AS prestasi_non_akademik
FROM siswa s
LEFT JOIN kelas k ON s.kelas_id = k.id
LEFT JOIN prestasi pr ON s.id = pr.siswa_id AND pr.status_verifikasi = 'diverifikasi'
LEFT JOIN jenis_prestasi jp ON pr.jenis_prestasi_id = jp.id
GROUP BY s.id, s.nis, s.nama_siswa, k.nama_kelas, k.jurusan;

-- View: Saldo Poin Siswa (Prestasi - Pelanggaran)
CREATE OR REPLACE VIEW v_saldo_poin_siswa AS
SELECT 
    s.id AS siswa_id,
    s.nis,
    s.nama_siswa,
    k.nama_kelas,
    COALESCE(rpr.total_poin_prestasi, 0) AS poin_prestasi,
    COALESCE(rpl.total_poin_pelanggaran, 0) AS poin_pelanggaran,
    COALESCE(rpr.total_poin_prestasi, 0) - COALESCE(rpl.total_poin_pelanggaran, 0) AS saldo_poin,
    CASE 
        WHEN COALESCE(rpr.total_poin_prestasi, 0) - COALESCE(rpl.total_poin_pelanggaran, 0) >= 100 THEN 'Sangat Baik'
        WHEN COALESCE(rpr.total_poin_prestasi, 0) - COALESCE(rpl.total_poin_pelanggaran, 0) >= 50 THEN 'Baik'
        WHEN COALESCE(rpr.total_poin_prestasi, 0) - COALESCE(rpl.total_poin_pelanggaran, 0) >= 0 THEN 'Cukup'
        WHEN COALESCE(rpr.total_poin_prestasi, 0) - COALESCE(rpl.total_poin_pelanggaran, 0) >= -50 THEN 'Kurang'
        ELSE 'Sangat Kurang'
    END AS kategori_siswa
FROM siswa s
LEFT JOIN kelas k ON s.kelas_id = k.id
LEFT JOIN v_rekap_prestasi_siswa rpr ON s.id = rpr.siswa_id
LEFT JOIN v_rekap_pelanggaran_siswa rpl ON s.id = rpl.siswa_id
WHERE s.status = 'aktif';

-- View: Monitoring Sanksi Aktif
CREATE OR REPLACE VIEW v_sanksi_aktif AS
SELECT 
    sa.id,
    s.nis,
    s.nama_siswa,
    k.nama_kelas,
    jp.nama_pelanggaran,
    sa.jenis_sanksi,
    sa.tanggal_mulai,
    sa.tanggal_selesai,
    sa.status,
    DATEDIFF(sa.tanggal_selesai, CURDATE()) AS hari_tersisa,
    ps.status AS status_pelaksanaan
FROM sanksi sa
JOIN pelanggaran p ON sa.pelanggaran_id = p.id
JOIN siswa s ON p.siswa_id = s.id
JOIN kelas k ON s.kelas_id = k.id
JOIN jenis_pelanggaran jp ON p.jenis_pelanggaran_id = jp.id
LEFT JOIN pelaksanaan_sanksi ps ON sa.id = ps.sanksi_id
WHERE sa.status IN ('direncanakan', 'berjalan')
ORDER BY sa.tanggal_mulai DESC;


-- ============================================
-- STORED PROCEDURE untuk Operasi Umum (BONUS)
-- ============================================

DELIMITER //

-- Procedure: Auto Assign Sanksi Berdasarkan Poin
CREATE PROCEDURE sp_auto_assign_sanksi(IN p_pelanggaran_id BIGINT)
BEGIN
    DECLARE v_poin INT;
    DECLARE v_jenis_sanksi VARCHAR(200);
    DECLARE v_deskripsi TEXT;
    
    -- Ambil poin pelanggaran
    SELECT poin INTO v_poin 
    FROM pelanggaran 
    WHERE id = p_pelanggaran_id;
    
    -- Tentukan sanksi berdasarkan poin
    IF v_poin <= 5 THEN
        SET v_jenis_sanksi = 'Teguran Lisan';
        SET v_deskripsi = 'Teguran lisan oleh guru';
    ELSEIF v_poin <= 15 THEN
        SET v_jenis_sanksi = 'Teguran Tertulis';
        SET v_deskripsi = 'Surat pernyataan + teguran tertulis';
    ELSEIF v_poin <= 30 THEN
        SET v_jenis_sanksi = 'Konseling BK';
        SET v_deskripsi = 'Konseling dengan BK + panggilan orang tua';
    ELSEIF v_poin <= 50 THEN
        SET v_jenis_sanksi = 'Skorsing';
        SET v_deskripsi = 'Skorsing 1-3 hari + konseling';
    ELSE
        SET v_jenis_sanksi = 'Skorsing Berat';
        SET v_deskripsi = 'Skorsing 1 minggu atau dikeluarkan';
    END IF;
    
    -- Insert sanksi
    INSERT INTO sanksi (pelanggaran_id, jenis_sanksi, deskripsi_sanksi, tanggal_mulai, tanggal_selesai, status)
    VALUES (p_pelanggaran_id, v_jenis_sanksi, v_deskripsi, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'direncanakan');
END//

-- Procedure: Hitung Total Poin Siswa
CREATE PROCEDURE sp_hitung_poin_siswa(
    IN p_siswa_id BIGINT, 
    OUT p_total_pelanggaran INT, 
    OUT p_total_prestasi INT, 
    OUT p_saldo_poin INT
)
BEGIN
    -- Total poin pelanggaran
    SELECT COALESCE(SUM(poin), 0) INTO p_total_pelanggaran
    FROM pelanggaran
    WHERE siswa_id = p_siswa_id AND status_verifikasi = 'diverifikasi';
    
    -- Total poin prestasi
    SELECT COALESCE(SUM(poin), 0) INTO p_total_prestasi
    FROM prestasi
    WHERE siswa_id = p_siswa_id AND status_verifikasi = 'diverifikasi';
    
    -- Saldo poin
    SET p_saldo_poin = p_total_prestasi - p_total_pelanggaran;
END//

DELIMITER ;


-- ============================================
-- TRIGGER untuk Audit Trail (BONUS)
-- ============================================

DELIMITER //

-- Trigger: Log perubahan status pelanggaran
CREATE TRIGGER trg_pelanggaran_after_update
AFTER UPDATE ON pelanggaran
FOR EACH ROW
BEGIN
    IF OLD.status_verifikasi != NEW.status_verifikasi THEN
        INSERT INTO verifikasi_data (tabel_terkait, id_terkait, status, catatan, created_at)
        VALUES ('pelanggaran', NEW.id, NEW.status_verifikasi, 
                CONCAT('Status berubah dari ', OLD.status_verifikasi, ' ke ', NEW.status_verifikasi), 
                NOW());
    END IF;
END//

-- Trigger: Log perubahan status prestasi
CREATE TRIGGER trg_prestasi_after_update
AFTER UPDATE ON prestasi
FOR EACH ROW
BEGIN
    IF OLD.status_verifikasi != NEW.status_verifikasi THEN
        INSERT INTO verifikasi_data (tabel_terkait, id_terkait, status, catatan, created_at)
        VALUES ('prestasi', NEW.id, NEW.status_verifikasi, 
                CONCAT('Status berubah dari ', OLD.status_verifikasi, ' ke ', NEW.status_verifikasi), 
                NOW());
    END IF;
END//

DELIMITER ;


-- ============================================
-- TESTING QUERIES (untuk Validasi)
-- ============================================

-- Test: Cek semua tabel ada
SELECT TABLE_NAME 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'db_pelanggaran' 
ORDER BY TABLE_NAME;

-- Test: Cek data siswa dengan poin
SELECT * FROM v_saldo_poin_siswa ORDER BY saldo_poin DESC LIMIT 10;

-- Test: Cek sanksi aktif
SELECT * FROM v_sanksi_aktif;

-- Test: Total rekap
SELECT 
    (SELECT COUNT(*) FROM siswa WHERE status = 'aktif') AS total_siswa_aktif,
    (SELECT COUNT(*) FROM pelanggaran WHERE status_verifikasi = 'diverifikasi') AS total_pelanggaran,
    (SELECT COUNT(*) FROM prestasi WHERE status_verifikasi = 'diverifikasi') AS total_prestasi,
    (SELECT COUNT(*) FROM sanksi WHERE status IN ('direncanakan', 'berjalan')) AS total_sanksi_aktif;