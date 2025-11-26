-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 02:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pelanggaran`
--

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan_konseling`
--

CREATE TABLE `bimbingan_konseling` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_konselor` bigint(20) UNSIGNED NOT NULL,
  `topik` varchar(200) NOT NULL,
  `tindakan` text DEFAULT NULL,
  `status` enum('terdaftar','diproses','selesai','tindak_lanjut') NOT NULL DEFAULT 'terdaftar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan_konseling`
--

INSERT INTO `bimbingan_konseling` (`id`, `siswa_id`, `guru_konselor`, `topik`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 7, 'Sering ribut di kelas', 'Konseling individu tentang etika di kelas dan dampak ganggu teman', 'selesai', '2024-11-02 17:00:00', NULL),
(2, 10, 7, 'Bolos sekolah', 'Konseling + panggilan ortu, mencari tahu penyebab sering bolos', 'diproses', '2024-11-03 17:00:00', NULL),
(3, 16, 7, 'Berbohong ke guru', 'Konseling tentang kejujuran dan konsekuensi berbohong', 'selesai', '2024-11-04 17:00:00', NULL),
(4, 22, 7, 'Berkelahi', 'Konseling individu + mediasi dengan korban, pembinaan sikap', 'selesai', '2024-11-05 17:00:00', NULL),
(5, 28, 7, 'Merokok di sekolah', 'Konseling intensif tentang bahaya rokok + panggilan ortu', 'diproses', '2024-11-08 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `bidang_studi` varchar(100) DEFAULT NULL,
  `status` enum('aktif','non_aktif','pensiun') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama_guru`, `bidang_studi`, `status`, `created_at`, `updated_at`) VALUES
(1, '198501012010011001', 'Deni Danis, S.Kom', 'Pemrograman', 'aktif', '2025-11-12 14:43:29', '2025-11-12 09:53:06'),
(2, '198703152011012002', 'Syifa Febrianti, S.Sn', 'Desain Grafis', 'aktif', '2025-11-12 14:43:29', '2025-11-12 09:52:45'),
(3, '198906202012011003', 'Ahmad Fauzi, S.Sn', 'Animasi', 'aktif', '2025-11-12 14:43:29', NULL),
(4, '199002102013012004', 'Rina Wijaya, S.E', 'Pemasaran', 'aktif', '2025-11-12 14:43:29', NULL),
(5, '198808252014011005', 'Dedi Kurniawan, S.E', 'Akuntansi', 'aktif', '2025-11-12 14:43:29', NULL),
(6, '198512102009011006', 'Dr. Hendra Wijaya, M.Pd', 'Kepala Sekolah', 'aktif', '2025-11-12 14:43:29', NULL),
(7, '198709152010012007', 'Lilis Suryani, S.Pd', 'BK', 'aktif', '2025-11-12 14:43:29', NULL),
(8, '199001202011011008', 'Bambang Supriyanto, S.Pd', 'Kesiswaan', 'aktif', '2025-11-12 14:43:29', NULL),
(9, '198803152012012009', 'Ani Rahmawati, S.Pd', 'Matematika', 'aktif', '2025-11-12 14:43:29', NULL),
(10, '199105102013011010', 'Rudi Hartono, S.Pd', 'Bahasa Inggris', 'aktif', '2025-11-12 14:43:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pelanggaran`
--

CREATE TABLE `jenis_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggaran` varchar(200) NOT NULL,
  `poin` int(11) NOT NULL,
  `kategori` enum('ringan','sedang','berat','sangat_berat') NOT NULL,
  `sanksi_rekomendasi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pelanggaran`
--

INSERT INTO `jenis_pelanggaran` (`id`, `nama_pelanggaran`, `poin`, `kategori`, `sanksi_rekomendasi`, `created_at`, `updated_at`) VALUES
(1, 'Terlambat masuk sekolah', 5, 'ringan', 'Teguran lisan + surat pernyataan', '2025-11-12 14:55:16', '2025-11-13 00:03:51'),
(2, 'Tidak mengerjakan tugas', 3, 'ringan', 'Mengerjakan tugas + teguran', '2025-11-12 14:55:16', NULL),
(3, 'Tidak memakai atribut lengkap', 2, 'ringan', 'Teguran + melengkapi atribut', '2025-11-12 14:55:16', NULL),
(4, 'Tidak membawa buku pelajaran', 2, 'ringan', 'Teguran lisan', '2025-11-12 14:55:16', NULL),
(5, 'Ribut di kelas', 5, 'ringan', 'Teguran + berdiri di depan kelas', '2025-11-12 14:55:16', NULL),
(6, 'Tidak masuk tanpa keterangan', 20, 'sedang', 'Panggilan ortu + surat pernyataan', '2025-11-12 14:55:16', NULL),
(7, 'Berbohong kepada guru', 15, 'sedang', 'Konseling BK + surat pernyataan', '2025-11-12 14:55:16', NULL),
(8, 'Berkelahi ringan', 25, 'sedang', 'Skorsing 1 hari + konseling BK', '2025-11-12 14:55:16', NULL),
(9, 'Membuat keributan di sekolah', 18, 'sedang', 'Panggilan ortu + membersihkan lingkungan', '2025-11-12 14:55:16', NULL),
(10, 'Memalsukan tanda tangan', 20, 'sedang', 'Panggilan ortu + surat pernyataan', '2025-11-12 14:55:16', NULL),
(11, 'Merokok di area sekolah', 40, 'berat', 'Skorsing 3 hari + konseling + panggilan ortu', '2025-11-12 14:55:16', NULL),
(12, 'Membawa senjata tajam', 45, 'berat', 'Skorsing 5 hari + diserahkan ke polisi', '2025-11-12 14:55:16', NULL),
(13, 'Berkelahi berat', 40, 'berat', 'Skorsing 3 hari + konseling intensif', '2025-11-12 14:55:16', NULL),
(14, 'Mencuri barang teman', 35, 'berat', 'Skorsing + ganti rugi + konseling', '2025-11-12 14:55:16', NULL),
(15, 'Merusak fasilitas sekolah', 30, 'berat', 'Ganti rugi + kerja sosial 1 minggu', '2025-11-12 14:55:16', NULL),
(16, 'Narkoba', 100, 'sangat_berat', 'Dikeluarkan + diserahkan ke pihak berwajib', '2025-11-12 14:55:16', NULL),
(17, 'Pelecehan seksual', 100, 'sangat_berat', 'Dikeluarkan + diserahkan ke pihak berwajib', '2025-11-12 14:55:16', NULL),
(18, 'Tawuran antar sekolah', 80, 'sangat_berat', 'Skorsing 1 bulan + konseling + panggilan ortu', '2025-11-12 14:55:16', NULL),
(19, 'Melawan guru/kepala sekolah', 70, 'sangat_berat', 'Skorsing 2 minggu + konseling intensif', '2025-11-12 14:55:16', NULL),
(20, 'Membawa/konsumsi miras', 60, 'sangat_berat', 'Skorsing 1 minggu + konseling + panggilan ortu', '2025-11-12 14:55:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_prestasi`
--

CREATE TABLE `jenis_prestasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(200) NOT NULL,
  `poin` int(11) NOT NULL,
  `kategori` enum('akademik','non_akademik') NOT NULL,
  `penghargaan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_prestasi`
--

INSERT INTO `jenis_prestasi` (`id`, `nama_prestasi`, `poin`, `kategori`, `penghargaan`, `created_at`, `updated_at`) VALUES
(1, 'Juara 1 Olimpiade Nasional', 100, 'akademik', 'Piagam + beasiswa 1 semester', '2025-11-12 14:55:36', NULL),
(2, 'Juara 2 Olimpiade Nasional', 80, 'akademik', 'Piagam + uang pembinaan', '2025-11-12 14:55:36', NULL),
(3, 'Juara 3 Olimpiade Nasional', 60, 'akademik', 'Piagam + uang pembinaan', '2025-11-12 14:55:36', NULL),
(4, 'Juara 1 Olimpiade Provinsi', 50, 'akademik', 'Piagam + beasiswa 1 bulan', '2025-11-12 14:55:36', NULL),
(5, 'Juara 1 Olimpiade Kota', 30, 'akademik', 'Piagam', '2025-11-12 14:55:36', NULL),
(6, 'Ranking 1 Kelas', 20, 'akademik', 'Piagam', '2025-11-12 14:55:36', NULL),
(7, 'Ranking 2 Kelas', 15, 'akademik', 'Piagam', '2025-11-12 14:55:36', NULL),
(8, 'Ranking 3 Kelas', 10, 'akademik', 'Piagam', '2025-11-12 14:55:36', NULL),
(9, 'Juara 1 LKS Nasional', 100, 'non_akademik', 'Piagam + beasiswa', '2025-11-12 14:55:36', NULL),
(10, 'Juara 2 LKS Nasional', 80, 'non_akademik', 'Piagam + uang pembinaan', '2025-11-12 14:55:36', NULL),
(11, 'Juara 1 Lomba Seni Nasional', 70, 'non_akademik', 'Piagam + hadiah', '2025-11-12 14:55:36', NULL),
(12, 'Juara 1 Olahraga Provinsi', 60, 'non_akademik', 'Piagam + hadiah', '2025-11-12 14:55:36', NULL),
(13, 'Juara Lomba Desain Kota', 40, 'non_akademik', 'Piagam', '2025-11-12 14:55:36', NULL),
(14, 'Ketua OSIS', 30, 'non_akademik', 'SK Pengurus', '2025-11-12 14:55:36', NULL),
(15, 'Pengurus OSIS', 15, 'non_akademik', 'SK Pengurus', '2025-11-12 14:55:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_sanksi`
--

CREATE TABLE `jenis_sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_sanksi` varchar(200) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(6, '2025_11_11_042212_create_guru_table', 2),
(7, '2025_11_11_044045_create_tahun_ajaran_table', 3),
(8, '2025_11_11_025459_create_kelas_table', 4),
(9, '2025_11_11_043606_create_siswa_table', 5),
(10, '2025_11_11_044926_create_jenis_pelanggaran_table', 5),
(11, '2025_11_11_063237_create_jenis_sanksi_table', 5),
(12, '2025_11_11_063647_create_pelanggarans_table', 5),
(13, '2025_11_11_063830_create_sanksi_table', 5),
(14, '2025_11_11_064036_create_pelaksanaan_sanksi_table', 5),
(15, '2025_11_11_064401_create_jenis_prestasis_table', 5),
(16, '2025_11_11_064926_create_prestasi_table', 5),
(17, '2025_11_11_065159_create_bimbingan_konselings_table', 5),
(18, '2025_11_11_065453_create_monitoring_pelanggarans_table', 5),
(19, '2025_11_11_065735_create_verifikasi_data_table', 5),
(20, '2025_11_13_013942_add_additional_fields_to_siswa_table', 6),
(21, '2025_11_13_100000_add_foto_to_siswa_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_pelanggaran`
--

CREATE TABLE `monitoring_pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `guru_kepsek` bigint(20) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monitoring_pelanggaran`
--

INSERT INTO `monitoring_pelanggaran` (`id`, `pelanggaran_id`, `guru_kepsek`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 6, 'Kasus berkelahi perlu dimonitor, pastikan tidak terulang', 'dimonitor', '2024-11-05 17:00:00', NULL),
(2, 11, 6, 'Kasus merokok sangat serius, perlu perhatian khusus dan follow up intensif', 'prioritas', '2024-11-07 17:00:00', NULL),
(3, 5, 6, 'Kasus bolos berulang, perlu kerjasama dengan ortu dan BK', 'dimonitor', '2024-11-04 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelaksanaan_sanksi`
--

CREATE TABLE `pelaksanaan_sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sanksi_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `bukti_pelaksanaan` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('terjadwal','dikerjakan','tuntas','terlambat','perpanjangan') NOT NULL DEFAULT 'terjadwal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelaksanaan_sanksi`
--

INSERT INTO `pelaksanaan_sanksi` (`id`, `sanksi_id`, `tanggal_pelaksanaan`, `bukti_pelaksanaan`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-11-01', 'surat_pernyataan_001.pdf', 'Siswa sudah membuat surat pernyataan dengan tanda tangan ortu', 'tuntas', '2025-11-12 14:57:05', NULL),
(2, 2, '2024-11-05', 'tugas_pemrograman_revisi.zip', 'Tugas sudah dikerjakan dengan baik, ada penambahan fitur login', 'tuntas', '2025-11-12 14:57:05', NULL),
(3, 3, '2024-11-03', '-', 'Siswa sudah berdiri di depan kelas, berjanji tidak mengulangi', 'tuntas', '2025-11-12 14:57:05', NULL),
(4, 4, '2024-11-02', 'foto_seragam_lengkap.jpg', 'Siswa sudah datang dengan seragam lengkap', 'tuntas', '2025-11-12 14:57:05', NULL),
(5, 6, '2024-11-05', 'surat_pernyataan_006.pdf', 'Surat pernyataan sudah ditandatangani ortu', 'tuntas', '2025-11-12 14:57:05', NULL),
(6, 7, '2024-11-08', 'form_konseling_bk_001.pdf', 'Sudah konseling 2x, siswa menunjukkan penyesalan', 'tuntas', '2025-11-12 14:57:05', NULL),
(7, 9, '2024-11-07', 'form_skorsing_001.pdf', 'Skorsing dilaksanakan, ortu sudah datang ke sekolah', 'tuntas', '2025-11-12 14:57:05', NULL),
(8, 10, '2024-11-08', '-', 'Siswa sudah membawa buku akuntansi lengkap', 'tuntas', '2025-11-12 14:57:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_pencatat` bigint(20) UNSIGNED NOT NULL,
  `jenis_pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_verifikasi` enum('menunggu','diverifikasi','ditolak','revisi') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggaran`
--

INSERT INTO `pelanggaran` (`id`, `siswa_id`, `guru_pencatat`, `jenis_pelanggaran_id`, `tahun_ajaran_id`, `poin`, `keterangan`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 1, 1, 5, 'Terlambat 15 menit tanpa alasan jelas', 'diverifikasi', '2024-11-01 00:30:00', NULL),
(2, 3, 1, 2, 1, 3, 'Tidak mengerjakan tugas pemrograman web', 'diverifikasi', '2024-11-02 03:00:00', NULL),
(3, 5, 10, 5, 1, 5, 'Ribut saat pelajaran Bahasa Inggris', 'diverifikasi', '2024-11-03 02:00:00', NULL),
(4, 7, 2, 3, 1, 2, 'Tidak memakai seragam lengkap', 'diverifikasi', '2024-11-01 00:00:00', NULL),
(5, 10, 9, 6, 1, 20, 'Tidak masuk 2 hari tanpa keterangan', 'menunggu', '2024-11-04 01:00:00', NULL),
(6, 13, 3, 1, 1, 5, 'Terlambat masuk kelas', 'diverifikasi', '2024-11-05 00:45:00', NULL),
(7, 16, 10, 7, 1, 15, 'Berbohong tentang sakit', 'diverifikasi', '2024-11-05 03:00:00', NULL),
(8, 19, 4, 2, 1, 3, 'Tidak mengerjakan tugas', 'diverifikasi', '2024-11-06 01:00:00', NULL),
(9, 22, 9, 8, 1, 25, 'Berkelahi dengan teman sekelas', 'diverifikasi', '2024-11-06 04:00:00', NULL),
(10, 25, 5, 4, 1, 2, 'Tidak membawa buku akuntansi', 'diverifikasi', '2024-11-07 01:00:00', NULL),
(11, 28, 9, 11, 1, 40, 'Kedapatan merokok di toilet', 'diverifikasi', '2024-11-08 02:30:00', NULL),
(12, 5, 2, 6, 1, 20, 'belum di veriffikasi', 'menunggu', '2025-11-12 08:39:09', '2025-11-12 08:39:09'),
(13, 31, 1, 16, 1, 100, 'bbb', 'menunggu', '2025-11-12 20:21:11', '2025-11-12 20:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `guru_pencatat` bigint(20) UNSIGNED NOT NULL,
  `jenis_prestasi_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran_id` bigint(20) UNSIGNED NOT NULL,
  `poin` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status_verifikasi` enum('menunggu','diverifikasi','ditolak','revisi') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id`, `siswa_id`, `guru_pencatat`, `jenis_prestasi_id`, `tahun_ajaran_id`, `poin`, `keterangan`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 9, 1, 100, 'Juara 1 LKS Web Technology tingkat Nasional', 'diverifikasi', '2024-10-14 17:00:00', NULL),
(2, 4, 1, 6, 1, 20, 'Ranking 1 kelas semester ganjil', 'diverifikasi', '2024-10-19 17:00:00', NULL),
(3, 9, 2, 11, 1, 70, 'Juara 1 Lomba Desain Poster tingkat Nasional', 'diverifikasi', '2024-10-09 17:00:00', NULL),
(4, 11, 2, 13, 1, 40, 'Juara 2 Lomba Logo tingkat Kota', 'diverifikasi', '2024-10-24 17:00:00', NULL),
(5, 15, 3, 7, 1, 15, 'Ranking 2 kelas semester ganjil', 'diverifikasi', '2024-10-19 17:00:00', NULL),
(6, 17, 3, 11, 1, 70, 'Juara 1 Festival Animasi Pelajar Nasional', 'menunggu', '2024-10-31 17:00:00', NULL),
(7, 21, 4, 14, 1, 30, 'Ketua OSIS periode 2024/2025', 'diverifikasi', '2024-08-31 17:00:00', NULL),
(8, 23, 4, 8, 1, 10, 'Ranking 3 kelas semester ganjil', 'diverifikasi', '2024-10-19 17:00:00', NULL),
(9, 27, 5, 6, 1, 20, 'Ranking 1 kelas semester ganjil', 'diverifikasi', '2024-10-19 17:00:00', NULL),
(10, 29, 5, 4, 1, 50, 'Juara 1 Olimpiade Akuntansi tingkat Provinsi', 'diverifikasi', '2024-10-11 17:00:00', NULL),
(11, 31, 2, 4, 1, 50, 'jpj', 'menunggu', '2025-11-12 20:32:18', '2025-11-12 20:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `sanksi`
--

CREATE TABLE `sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggaran_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_sanksi` varchar(200) NOT NULL,
  `deskripsi_sanksi` text DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('direncanakan','berjalan','selesai','ditunda','dibatalkan') NOT NULL DEFAULT 'direncanakan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanksi`
--

INSERT INTO `sanksi` (`id`, `pelanggaran_id`, `jenis_sanksi`, `deskripsi_sanksi`, `tanggal_mulai`, `tanggal_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Teguran Tertulis', 'Membuat surat pernyataan tidak akan terlambat lagi', '2024-11-01', '2024-11-01', 'selesai', '2025-11-12 14:56:44', NULL),
(2, 2, 'Tugas Tambahan', 'Mengerjakan ulang tugas pemrograman dengan tambahan fitur', '2024-11-02', '2024-11-05', 'selesai', '2025-11-12 14:56:44', NULL),
(3, 3, 'Teguran Lisan', 'Berdiri di depan kelas selama 30 menit', '2024-11-03', '2024-11-03', 'selesai', '2025-11-12 14:56:44', NULL),
(4, 4, 'Teguran Lisan', 'Melengkapi atribut seragam besok', '2024-11-01', '2024-11-02', 'selesai', '2025-11-12 14:56:44', NULL),
(5, 5, 'Panggilan Orang Tua', 'Orang tua dipanggil ke sekolah + surat pernyataan', '2024-11-05', '2024-11-06', 'berjalan', '2025-11-12 14:56:44', NULL),
(6, 6, 'Teguran Tertulis', 'Surat pernyataan tidak terlambat', '2024-11-05', '2024-11-05', 'selesai', '2025-11-12 14:56:44', NULL),
(7, 7, 'Konseling BK', 'Konseling tentang kejujuran + surat pernyataan', '2024-11-06', '2024-11-08', 'selesai', '2025-11-12 14:56:44', NULL),
(8, 8, 'Tugas Tambahan', 'Mengerjakan tugas pemasaran tambahan', '2024-11-06', '2024-11-09', 'berjalan', '2025-11-12 14:56:44', NULL),
(9, 9, 'Skorsing', 'Skorsing 1 hari + konseling BK + panggilan ortu', '2024-11-07', '2024-11-07', 'selesai', '2025-11-12 14:56:44', NULL),
(10, 10, 'Teguran Lisan', 'Teguran dan harus membawa buku besok', '2024-11-07', '2024-11-08', 'selesai', '2025-11-12 14:56:44', NULL),
(11, 11, 'Skorsing', 'Skorsing 3 hari + konseling intensif + panggilan ortu', '2024-11-09', '2024-11-11', 'berjalan', '2025-11-12 14:56:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lNZfISC4ZCxjAnGx0xQYKmXuCA54YRfe26PfiUhu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMlBManplTGtWaW84ajN3dnVRbFEyM2pzd1dVQ3U0ZXFtYURTWkFUZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762823766),
('mM9QVOUv0xJma6ECg0g4zxV0jqfnNcmXfSAANr0g', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFRkSDd2U2tXWk1Xbng0NnJlQ0ZmcEQ4OWZsUzI5UE96NjdiSXhSNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1762826409),
('msHaN2MjiMjjUt6YIGNiGxqRYwHyhK0OboFmVIWW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSG1iczRlVVlzQlhMUzVIV1M4Wm8xMGlvNW00aWRsTDFpYkRjRmlkbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1762823761),
('Sc1Ruw7UL3qYpR6bDFtW9ocsfszdEBXBYgEBHBqe', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUzZyeXhqZkdmTDk0Z1dMd2FoNlJJYnJ4aTA2NVJuUGdxdlpubVc4MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1762824706),
('yQYLsd9krcinGyncUZSJVBNcdfmMFRTp6g9L4jXD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidllqamV5TGZ1c0dvUGlVSENwVWNJemhaZUlFc3BDeTd1YjlwTUtpeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1762825654);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `nama_ortu` varchar(100) DEFAULT NULL,
  `no_hp_ortu` varchar(15) DEFAULT NULL,
  `status` enum('aktif','lulus','pindah','drop_out','cuti') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama_siswa`, `foto`, `kelas_id`, `jenis_kelamin`, `alamat`, `no_hp`, `nama_ortu`, `no_hp_ortu`, `status`, `created_at`, `updated_at`) VALUES
(1, '2022001', 'Andi Prasetyo', NULL, 1, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(2, '2022002', 'Dewi Lestari', NULL, 1, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(3, '2022003', 'Rizky Firmansyah', NULL, 1, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(4, '2022004', 'Sinta Maharani', NULL, 1, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(5, '2022005', 'Farhan Maulana', NULL, 1, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(6, '2022006', 'Rania Putri', NULL, 1, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(7, '2022007', 'Indah Permata', NULL, 2, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(8, '2022008', 'Bayu Saputra', NULL, 2, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(9, '2022009', 'Citra Ayu', NULL, 2, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(10, '2022010', 'Dimas Wijaya', NULL, 2, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(11, '2022011', 'Zahra Azzahra', NULL, 2, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(12, '2022012', 'Kevin Ananda', NULL, 2, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(13, '2022013', 'Nadia Rahma', NULL, 3, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(14, '2022014', 'Ilham Maulana', NULL, 3, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(15, '2022015', 'Maya Safitri', NULL, 3, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(16, '2022016', 'Yoga Pratama', NULL, 3, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(17, '2022017', 'Salsa Bila', NULL, 3, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(18, '2022018', 'Raffi Ahmad', NULL, 3, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(19, '2022019', 'Putri Cantika', NULL, 4, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(20, '2022020', 'Arief Rachman', NULL, 4, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(21, '2022021', 'Lina Marlina', NULL, 4, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(22, '2022022', 'Hendra Gunawan', NULL, 4, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(23, '2022023', 'Tika Sari', NULL, 4, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(24, '2022024', 'Bima Sakti', NULL, 4, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(25, '2022025', 'Annisa Fitri', NULL, 5, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(26, '2022026', 'Ryan Hidayat', NULL, 5, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(27, '2022027', 'Dinda Puspita', NULL, 5, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(28, '2022028', 'Eko Prasetyo', NULL, 5, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(29, '2022029', 'Fitria Wulandari', NULL, 5, 'P', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(30, '2022030', 'Agus Setiawan', NULL, 5, 'L', NULL, NULL, NULL, NULL, 'aktif', '2025-11-12 14:54:48', NULL),
(31, '12345', 'Yuda Wiratama', '1763003794_WhatsApp Image 2025-11-13 at 09.32.56.jpeg', 1, 'L', 'Andir', '08632782933', 'Lukman', '0876376244', 'aktif', '2025-11-12 20:16:34', '2025-11-12 20:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(20) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun_ajaran`, `semester`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2024/2025', 'ganjil', 0, '2025-11-12 14:43:29', NULL),
(2, '2023/2024', 'genap', 0, '2025-11-12 14:43:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_data`
--

CREATE TABLE `verifikasi_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tabel_terkait` varchar(100) NOT NULL,
  `id_terkait` bigint(20) UNSIGNED NOT NULL,
  `guru_verifikator` bigint(20) UNSIGNED NOT NULL,
  `status` enum('menunggu','diverifikasi','ditolak','revisi') NOT NULL DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifikasi_data`
--

INSERT INTO `verifikasi_data` (`id`, `tabel_terkait`, `id_terkait`, `guru_verifikator`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'pelanggaran', 1, 8, 'diverifikasi', NULL, '2024-11-01 01:00:00', NULL),
(2, 'pelanggaran', 2, 8, 'diverifikasi', NULL, '2024-11-02 03:30:00', NULL),
(3, 'pelanggaran', 3, 8, 'diverifikasi', NULL, '2024-11-03 02:30:00', NULL),
(4, 'pelanggaran', 5, 8, 'menunggu', NULL, '2024-11-04 01:30:00', NULL),
(5, 'prestasi', 1, 8, 'diverifikasi', NULL, '2024-10-15 07:00:00', NULL),
(6, 'prestasi', 2, 8, 'diverifikasi', NULL, '2024-10-20 08:00:00', NULL),
(7, 'prestasi', 3, 8, 'diverifikasi', NULL, '2024-10-10 06:00:00', NULL),
(8, 'prestasi', 6, 8, 'menunggu', NULL, '2024-11-01 03:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bimbingan_konseling_siswa_id_foreign` (`siswa_id`),
  ADD KEY `bimbingan_konseling_guru_konselor_foreign` (`guru_konselor`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guru_nip_unique` (`nip`);

--
-- Indexes for table `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_sanksi`
--
ALTER TABLE `jenis_sanksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitoring_pelanggaran_pelanggaran_id_foreign` (`pelanggaran_id`),
  ADD KEY `monitoring_pelanggaran_guru_kepsek_foreign` (`guru_kepsek`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelaksanaan_sanksi_sanksi_id_foreign` (`sanksi_id`);

--
-- Indexes for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_siswa_id_foreign` (`siswa_id`),
  ADD KEY `pelanggaran_guru_pencatat_foreign` (`guru_pencatat`),
  ADD KEY `pelanggaran_jenis_pelanggaran_id_foreign` (`jenis_pelanggaran_id`),
  ADD KEY `pelanggaran_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestasi_siswa_id_foreign` (`siswa_id`),
  ADD KEY `prestasi_guru_pencatat_foreign` (`guru_pencatat`),
  ADD KEY `prestasi_jenis_prestasi_id_foreign` (`jenis_prestasi_id`),
  ADD KEY `prestasi_tahun_ajaran_id_foreign` (`tahun_ajaran_id`);

--
-- Indexes for table `sanksi`
--
ALTER TABLE `sanksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sanksi_pelanggaran_id_foreign` (`pelanggaran_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_nis_unique` (`nis`),
  ADD KEY `siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verifikasi_data_guru_verifikator_foreign` (`guru_verifikator`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `jenis_pelanggaran`
--
ALTER TABLE `jenis_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `jenis_prestasi`
--
ALTER TABLE `jenis_prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `jenis_sanksi`
--
ALTER TABLE `jenis_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `sanksi`
--
ALTER TABLE `sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bimbingan_konseling`
--
ALTER TABLE `bimbingan_konseling`
  ADD CONSTRAINT `bimbingan_konseling_guru_konselor_foreign` FOREIGN KEY (`guru_konselor`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_konseling_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `monitoring_pelanggaran`
--
ALTER TABLE `monitoring_pelanggaran`
  ADD CONSTRAINT `monitoring_pelanggaran_guru_kepsek_foreign` FOREIGN KEY (`guru_kepsek`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `monitoring_pelanggaran_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelaksanaan_sanksi`
--
ALTER TABLE `pelaksanaan_sanksi`
  ADD CONSTRAINT `pelaksanaan_sanksi_sanksi_id_foreign` FOREIGN KEY (`sanksi_id`) REFERENCES `sanksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_guru_pencatat_foreign` FOREIGN KEY (`guru_pencatat`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_jenis_pelanggaran_id_foreign` FOREIGN KEY (`jenis_pelanggaran_id`) REFERENCES `jenis_pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD CONSTRAINT `prestasi_guru_pencatat_foreign` FOREIGN KEY (`guru_pencatat`) REFERENCES `guru` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_jenis_prestasi_id_foreign` FOREIGN KEY (`jenis_prestasi_id`) REFERENCES `jenis_prestasi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestasi_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sanksi`
--
ALTER TABLE `sanksi`
  ADD CONSTRAINT `sanksi_pelanggaran_id_foreign` FOREIGN KEY (`pelanggaran_id`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifikasi_data`
--
ALTER TABLE `verifikasi_data`
  ADD CONSTRAINT `verifikasi_data_guru_verifikator_foreign` FOREIGN KEY (`guru_verifikator`) REFERENCES `guru` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
