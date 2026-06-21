-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2026 at 08:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parttime_ku`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'barustu', 'nonaktif', '2026-06-17 04:27:25', '2026-06-17 05:06:10'),
(3, 'as', 'nonaktif', '2026-06-17 04:28:01', '2026-06-17 05:07:01'),
(4, 'caca', 'aktif', '2026-06-17 05:07:12', '2026-06-17 05:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lowongan_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `lowongan_id`, `created_at`, `updated_at`) VALUES
(3, 8, 8, '2026-06-19 18:14:04', '2026-06-19 18:14:04'),
(4, 8, 3, '2026-06-19 18:14:21', '2026-06-19 18:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lamarans`
--

CREATE TABLE `lamarans` (
  `id` bigint UNSIGNED NOT NULL,
  `pelamar_id` bigint UNSIGNED NOT NULL,
  `lowongan_id` bigint UNSIGNED NOT NULL,
  `catatan_tambahan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','diproses','diterima','ditolak','selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lamarans`
--

INSERT INTO `lamarans` (`id`, `pelamar_id`, `lowongan_id`, `catatan_tambahan`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 3, NULL, 'diproses', '2026-06-17 05:43:36', '2026-06-19 17:40:17'),
(3, 8, 3, 'sadw', 'diproses', '2026-06-17 07:43:06', '2026-06-17 23:26:05');

-- --------------------------------------------------------

--
-- Table structure for table `lowongans`
--

CREATE TABLE `lowongans` (
  `id` bigint UNSIGNED NOT NULL,
  `penyedia_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kriteria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji` decimal(15,2) DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_review',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quota` int DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `salary_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lowongans`
--

INSERT INTO `lowongans` (`id`, `penyedia_id`, `judul`, `deskripsi`, `kriteria`, `shift`, `gaji`, `lokasi`, `status`, `created_at`, `updated_at`, `category`, `quota`, `deadline`, `contact`, `start_date`, `end_date`, `salary_type`) VALUES
(1, 2, 'Barista Part-Time Shift Malam', 'Dibutuhkan barista untuk shift malam.', 'Bisa buat kopi', 'Malam', '1500000.00', 'Purwokerto', 'aktif', '2026-06-16 21:23:48', '2026-06-17 21:36:49', 'Barista', 2, '2026-07-17', NULL, '2026-06-17', NULL, 'Bulan'),
(3, 2, 'Barista Part-Time Shift Malam', 'Dibutuhkan barista untuk shift malam. Pengalaman minimal 1 tahun.', 'Bisa buat kopi, ramah, jujur', 'Malam', '1500000.00', 'Purwokerto', 'aktif', '2026-06-17 05:43:35', '2026-06-19 17:48:59', 'Barista', 2, '2026-07-17', NULL, '2026-06-17', NULL, 'Bulan'),
(4, 2, 'Kasir Toko Buku Part-Time', 'Dibutuhkan kasir untuk toko buku di akhir pekan (Sabtu & Minggu).', 'Teliti, ramah, bisa mengoperasikan mesin kasir', 'Pagi', '750000.00', 'Banyumas', 'aktif', '2026-06-17 05:43:35', '2026-06-17 05:43:35', 'Kasir', 1, '2026-07-02', NULL, '2026-06-19', NULL, 'Bulan'),
(5, 2, 'Admin Media Sosial (Remote)', 'Dicari admin untuk membalas DM dan komentar Instagram. Waktu kerja fleksibel.', 'Aktif medsos, kreatif, fast response', 'Fleksibel', '1000000.00', 'Remote', 'aktif', '2026-06-17 05:43:35', '2026-06-17 05:43:35', 'Administrasi', 3, '2026-07-07', NULL, '2026-06-22', NULL, 'Bulan'),
(6, 2, 'Penjaga Stand Makanan', 'Membantu menjaga stand makanan di bazar kampus selama 3 hari.', 'Cekatan, sehat jasmani', 'Siang', '300000.00', 'Unsoed Purwokerto', 'aktif', '2026-06-17 05:43:35', '2026-06-17 05:43:35', 'Event', 4, '2026-06-25', NULL, '2026-06-27', NULL, 'Proyek'),
(8, 2, 'Barista Parking', 'mnmk', 'efeas', 'santu - minggu., 15.00-17.00', '1000000.00', 'jakarta', 'aktif', '2026-06-17 19:04:32', '2026-06-19 17:38:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `lamaran_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `lamaran_id`, `sender_id`, `body`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'halo', '2026-06-17 21:24:52', '2026-06-17 21:23:41', '2026-06-17 21:24:52'),
(2, 3, 8, 'halo juga', '2026-06-17 21:35:36', '2026-06-17 21:24:55', '2026-06-17 21:35:36'),
(3, 3, 8, 'test', NULL, '2026-06-17 23:29:02', '2026-06-17 23:29:02'),
(4, 3, 8, 'halo', NULL, '2026-06-18 23:18:42', '2026-06-18 23:18:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_06_003252_create_lowongans_table', 1),
(5, '2026_06_06_003256_create_lamarans_table', 1),
(6, '2026_06_11_030729_create_profiles_table', 1),
(7, '2026_06_17_033822_add_extra_columns_to_lowongans_table', 2),
(8, '2026_06_17_044713_create_categories_table', 3),
(9, '2026_06_17_044713_create_reviews_table', 3),
(10, '2026_06_17_050537_add_search_indexes_to_tables', 4),
(11, '2026_06_17_102358_add_is_active_to_users_table', 5),
(12, '2026_06_17_115034_alter_status_enum_on_lowongans_table', 6),
(13, '2026_06_17_130148_create_favorites_table', 7),
(15, '2026_06_18_031207_add_selesai_status_to_lamarans_table', 9),
(16, '2026_06_18_040229_create_messages_table', 10),
(17, '2026_06_18_044247_add_cv_path_to_profiles_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `universitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fakultas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` int DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `ktm_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_address` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `nim`, `universitas`, `fakultas`, `jurusan`, `semester`, `ipk`, `alamat`, `ktm_path`, `cv_path`, `business_name`, `business_type`, `business_email`, `business_phone`, `business_address`, `description`, `logo_path`, `document_path`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-12 00:52:59', '2026-06-12 00:52:59'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kopi Kenangan Purwokerto', 'F&B', NULL, '422', 'Jl. HR Bunyamin, Purwokerto', 'Mencari mahasiswa part-time untuk posisi Barista shift sore.', 'business_logos/WXuxYh4KAAH1XmiAZBDRSL45nBLTUjQedCC4ZShj.jpg', 'verification_documents/nX32g1WfKc7yL2rIWfsHUpaUPJHBcSgxnK9pXTHt.pdf', '2026-06-12 00:52:59', '2026-06-17 21:36:04'),
(3, 3, NULL, 'Universitas Jenderal Soedirman', 'Teknik', 'Informatika', 4, '3.80', 'Purwokerto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-12 00:52:59', '2026-06-12 00:52:59'),
(5, 5, NULL, 'ada', NULL, 'wada', 6, '3.50', 'sad', 'documents/ktm/S3ryRkFz8pqC7OHO8r6NmWt6OnDzRaquWkmECYPB.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-15 22:25:05', '2026-06-15 22:25:05'),
(6, 6, NULL, 'ada', NULL, 'wada', 13, '3.50', 'damd', 'documents/ktm/Q6ueHg9XcrRCSPrnSZpnXbhwNplrS2c69096i8Xs.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-16 20:47:41', '2026-06-16 20:47:41'),
(7, 8, NULL, 'Universitas Jenderal Soedirman', NULL, 'Inf', 5, '3.67', 'Makassar', 'cv_documents/FFowraXeGKSCYYIhzSu4uXuSNlAYFT7h53xJQGbj.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-17 05:38:53', '2026-06-17 07:39:20'),
(8, 9, NULL, 'Universitas Jenderal Soedirman', NULL, 'Informatika', 11, '4.00', '2dsfs', 'documents/ktm/Jpk5rf0PXuigfQNIOs274M741KUKK7xCkn32RtP7.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-19 17:34:24', '2026-06-19 17:34:24'),
(9, 10, NULL, 'Universitas Jenderal Soedirman', NULL, 'Informatika', 13, '4.00', 'sdgs', 'documents/ktm/wp57qaDTTRV66ehI2FIBPM0zOch7qJ9UjKeHbqJM.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-19 18:05:06', '2026-06-19 18:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `lamaran_id` bigint UNSIGNED NOT NULL,
  `reviewer_id` bigint UNSIGNED NOT NULL,
  `reviewee_id` bigint UNSIGNED NOT NULL,
  `rating` int UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `lamaran_id`, `reviewer_id`, `reviewee_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 8, 5, 'sangat bagus', '2026-06-17 21:24:09', '2026-06-17 21:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aiQtjiHrethLntDMqtZRBCjsoLN1eQAU2N7VmcW0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJQOVQ1eW9CY3Y1NlJtM0t0bmo5Qkk5ZGE1TTBpVU9lblI2TGluMnJGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BhcnR0aW1lLnRlc3QiLCJyb3V0ZSI6bnVsbH0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1782030665),
('fx64mM58XWwtFXFbpN6DdMh9Az0WDNLT9L4AkbFM', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'eyJfdG9rZW4iOiJuRTBoVWI0NndNZDJZazRaTDR1d0VEMU9zNkNoWWpLSGNRd0NpM3JpIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvcGFydHRpbWUudGVzdFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn19', 1781918291);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','penyedia','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mahasiswa',
  `status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `no_hp`, `email_verified_at`, `password`, `role`, `status`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator PartTime-KU', 'admin_pusat', 'admsin@parttime.com', '081345678', NULL, '$2y$12$UA4Ensst40p1rSs0OEn44uOWdJClwa0K18YN8ws.zItLa0CbsSk8O', 'admin', 'verified', 1, NULL, '2026-06-12 00:52:59', '2026-06-17 23:24:45'),
(2, 'Budi Kopi Kenangan', 'kopi_kenangan', 'umkm@parttime.com', '08222222222', NULL, '$2y$12$Hd2/VVEFlChBZzwrl1oNgejjE00CWShC10Zhg2VxWX/6qNy7WE4TK', 'penyedia', 'verified', 1, NULL, '2026-06-12 00:52:59', '2026-06-12 00:52:59'),
(3, 'Yusuf Rafii Ahmad', 'yusuf_rafii', 'mahasiswa@parttime.com', '08333333333', NULL, '$2y$12$GIQ8C5Kym0eqUuRWm7XvU.nEOednjLQai4fXYuOKJOQqLoIQ4dQO6', 'mahasiswa', 'verified', 1, NULL, '2026-06-12 00:52:59', '2026-06-12 00:52:59'),
(5, 'danyu', 'dabyu', 'yusuf1234@gmail.com', '088102450193322', NULL, '$2y$12$hP3qdtX/ZWjbk9coOooDSe2vVvmGNFA2OPMgKSV1oz2G4oojb3Nha', 'mahasiswa', 'rejected', 1, NULL, '2026-06-15 22:25:05', '2026-06-17 02:48:21'),
(6, 'bayu', 'bayu', 'bayu@gmail.com', '234234325', NULL, '$2y$12$abzboj3ZPdtFC9XA8yfv.ezZ3EcmkR9IG4UiYthYp92sxWTR8SFNm', 'mahasiswa', 'verified', 1, NULL, '2026-06-16 20:47:41', '2026-06-16 21:20:45'),
(7, 'Lautmsdsd', 'lautmsdsd328', 'admin@tokoxku.com', '7989880', NULL, '$2y$12$KTtRVQiXp8.eVzE47VgP6.haxLPms/Sd9D3SWyWZkdP7m4JRCL6WC', 'admin', 'pending', 1, NULL, '2026-06-17 05:05:09', '2026-06-17 05:05:39'),
(8, 'YUSUF RAFII AHMAD', 'yurah25', 'yusufrafiiahmad25@gmail.com', '0881024501933', NULL, '$2y$12$thlMIoa0b2O5c1QmuZebq.RJnf39kSluMWxYZ5pN2QvaZGjojjUxS', 'mahasiswa', 'verified', 1, NULL, '2026-06-17 05:38:53', '2026-06-17 05:39:38'),
(9, 'Naufal Zaky Ahmad', 'naufa', 'Naufal@gmail.com', '234242', NULL, '$2y$12$XqhMqCHfctJobMhqYxImVu0cJfQTPcKb0cPj5aUBp3BKL57MYHwgG', 'mahasiswa', 'pending', 1, NULL, '2026-06-19 17:34:24', '2026-06-19 17:34:24'),
(10, 'yurah', 'yufansa', 'budsi@gmail.com', '2341', NULL, '$2y$12$FH.90C6PUC70b8e9lsJy2OTMMlBr6r/vLlr/Nuf9cTI02C7Hs4yhq', 'mahasiswa', 'pending', 1, NULL, '2026-06-19 18:05:06', '2026-06-19 18:05:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_lowongan_id_unique` (`user_id`,`lowongan_id`),
  ADD KEY `favorites_lowongan_id_foreign` (`lowongan_id`);

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
-- Indexes for table `lamarans`
--
ALTER TABLE `lamarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lamarans_pelamar_id_foreign` (`pelamar_id`),
  ADD KEY `lamarans_lowongan_id_foreign` (`lowongan_id`),
  ADD KEY `lamarans_status_index` (`status`);

--
-- Indexes for table `lowongans`
--
ALTER TABLE `lowongans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lowongans_penyedia_id_foreign` (`penyedia_id`),
  ADD KEY `lowongans_judul_index` (`judul`),
  ADD KEY `lowongans_category_index` (`category`),
  ADD KEY `lowongans_status_index` (`status`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_lamaran_id_foreign` (`lamaran_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_lamaran_id_foreign` (`lamaran_id`),
  ADD KEY `reviews_reviewer_id_foreign` (`reviewer_id`),
  ADD KEY `reviews_reviewee_id_foreign` (`reviewee_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_name_index` (`name`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lamarans`
--
ALTER TABLE `lamarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lowongans`
--
ALTER TABLE `lowongans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_lowongan_id_foreign` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lamarans`
--
ALTER TABLE `lamarans`
  ADD CONSTRAINT `lamarans_lowongan_id_foreign` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lamarans_pelamar_id_foreign` FOREIGN KEY (`pelamar_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lowongans`
--
ALTER TABLE `lowongans`
  ADD CONSTRAINT `lowongans_penyedia_id_foreign` FOREIGN KEY (`penyedia_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_lamaran_id_foreign` FOREIGN KEY (`lamaran_id`) REFERENCES `lamarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_lamaran_id_foreign` FOREIGN KEY (`lamaran_id`) REFERENCES `lamarans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewee_id_foreign` FOREIGN KEY (`reviewee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
