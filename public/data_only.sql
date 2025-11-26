
INSERT INTO `monitoring_pelanggaran` (`id`, `pelanggaran_id`, `guru_kepsek`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 6, 'Kasus berkelahi perlu dimonitor, pastikan tidak terulang', 'dimonitor', '2024-11-05 17:00:00', NULL),
(2, 11, 6, 'Kasus merokok sangat serius, perlu perhatian khusus dan follow up intensif', 'prioritas', '2024-11-07 17:00:00', NULL),
(3, 5, 6, 'Kasus bolos berulang, perlu kerjasama dengan ortu dan BK', 'dimonitor', '2024-11-04 17:00:00', NULL);

INSERT INTO `verifikasi_data` (`id`, `tabel_terkait`, `id_terkait`, `guru_verifikator`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'pelanggaran', 1, 8, 'diverifikasi', NULL, '2024-11-01 01:00:00', NULL),
(2, 'pelanggaran', 2, 8, 'diverifikasi', NULL, '2024-11-02 03:30:00', NULL),
(3, 'pelanggaran', 3, 8, 'diverifikasi', NULL, '2024-11-03 02:30:00', NULL),
(4, 'pelanggaran', 5, 8, 'menunggu', NULL, '2024-11-04 01:30:00', NULL),
(5, 'prestasi', 1, 8, 'diverifikasi', NULL, '2024-10-15 07:00:00', NULL),
(6, 'prestasi', 2, 8, 'diverifikasi', NULL, '2024-10-20 08:00:00', NULL),
(7, 'prestasi', 3, 8, 'diverifikasi', NULL, '2024-10-10 06:00:00', NULL),
(8, 'prestasi', 6, 8, 'menunggu', NULL, '2024-11-01 03:00:00', NULL);