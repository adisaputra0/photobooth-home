-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Jul 2025 pada 06.37
-- Versi server: 8.0.30
-- Versi PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ignosstudio`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_orang` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `package` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penambahan_waktu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tirai` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `spotlight` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kendaraan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `nama`, `jumlah_orang`, `tanggal`, `waktu`, `package`, `background`, `penambahan_waktu`, `tirai`, `spotlight`, `nomor_telp`, `kendaraan`, `created_at`, `updated_at`) VALUES
(2, 'I Putu Adi Saputra', 2, '2024-08-19', '14:00-15:00', 'basic', 'white', '-', '', '0', '083847406501', '', '2024-08-17 07:11:04', '2024-08-17 07:11:04'),
(3, 'Edmund Theodore Thio', 2, '2024-08-19', '15:00-16:00', 'basic', 'white', '-', '', '0', '', '', '2024-08-17 19:08:21', '2024-08-17 19:08:21'),
(4, 'I Putu Adi Saputra', 2, '2024-11-10', '22:00-23:00', 'basic', 'white', '-', '-', '-', '0', '', '2024-11-10 01:31:22', '2024-11-10 01:31:22'),
(5, 'I Putu Adi Saputra', 2, '2024-11-10', '21:00-22:00', 'basic', 'white', '-', 'pakai', '-', '0', '', '2024-11-10 01:35:51', '2024-11-10 01:35:51'),
(6, 'Edmund Theodore Thio', 2, '2024-11-10', '20:00-21:00', 'basic', 'white', '-', 'pakai', '-', '0', '', '2024-11-10 01:40:08', '2024-11-10 01:40:08'),
(7, 'K', 2, '2024-11-13', '22:00-23:00', 'basic', 'white', '-', 'pakai', '-', '0', '', '2024-11-10 02:05:02', '2024-11-10 02:05:02'),
(8, 'Adi222222', 5, '2024-11-21', '22:00-23:00', 'basic', 'gray', '20 menit', 'benar', 'benar', '0', '', '2024-11-12 06:58:16', '2024-11-12 06:58:16'),
(9, 'adi', 2, '2024-11-13', '21:00-22:00', 'basic', 'gray', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:09:52', '2024-11-12 07:09:52'),
(10, 'adi', 2, '2024-11-13', '19:00-20:00', 'basic', 'gray', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:10:47', '2024-11-12 07:10:47'),
(11, 'Angga333333333', 2, '2024-11-13', '20:00-21:00', 'basic', 'peach', '20 menit', 'pakai', '-', '0', '', '2024-11-12 07:29:03', '2024-11-12 07:29:03'),
(12, 'Angga333333333', 2, '2024-11-13', '16:00-17:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:31:29', '2024-11-12 07:31:29'),
(13, 'K', 2, '2024-12-06', '16:00-17:00', 'basic', 'white', '-', '-', 'pakai', '0', '', '2024-11-12 07:33:19', '2024-11-12 07:33:19'),
(14, 'I Ketut Angga Saputra', 2, '2024-12-30', '22:00-23:00', 'basic', 'white', '10 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:39:54', '2024-11-12 07:39:54'),
(15, 'I Ketut Angga Saputra', 2, '2024-12-30', '20:00-21:00', 'basic', 'white', '10 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:41:17', '2024-11-12 07:41:17'),
(16, 'I Ketut Angga Saputra', 2, '2025-01-31', '22:00-23:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:43:23', '2024-11-12 07:43:23'),
(17, 'I Ketut Angga Saputra', 2, '2025-01-31', '21:00-22:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-12 07:43:36', '2024-11-12 07:43:36'),
(18, 'I Ketut Angga Saputra', 2, '2025-01-31', '20:00-21:00', 'basic', 'peach', '-', 'pakai', 'pakai', '0', '', '2024-11-12 07:43:53', '2024-11-12 07:43:53'),
(19, 'I Putu Adi Saputra', 4, '2024-11-21', '21:00-22:00', 'basic', 'gray', '10 menit', 'pakai', 'pakai', '0', '', '2024-11-14 05:31:42', '2024-11-14 05:31:42'),
(20, 'I Putu Adi Saputra', 2, '2024-11-15', '22:00-23:00', 'basic', 'orange', '-', 'pakai', '-', '0', '', '2024-11-14 06:06:02', '2024-11-14 06:06:02'),
(21, 'I Putu Adi Saputra', 15, '2024-11-15', '12:00-13:00', 'basic', 'white', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-14 19:48:55', '2024-11-14 19:48:55'),
(22, 'I Putu Adi Saputra', 2, '2024-11-29', '22:00-23:00', 'basic', 'white', '-', 'pakai', 'pakai', '0', '', '2024-11-15 06:38:26', '2024-11-15 06:38:26'),
(23, 'I Putu Adi Saputra', 15, '2025-12-31', '22:00-23:00', 'basic', 'gray', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-27 05:40:37', '2024-11-27 05:40:37'),
(24, 'I Putu Adi Saputra', 15, '2025-12-31', '21:00-22:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-27 05:41:42', '2024-11-27 05:41:42'),
(25, 'I Putu Adi Saputra', 15, '2024-11-30', '22:00-23:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '0', '', '2024-11-27 06:36:14', '2024-11-27 06:36:14'),
(26, 'I Putu Adi Saputra', 2, '2024-12-31', '22:00-23:00', 'basic', 'white', '-', '-', '-', '0', '', '2024-11-30 01:45:35', '2024-11-30 01:45:35'),
(27, 'I Putu Adi Saputra', 2, '2030-12-31', '14:00-15:00', 'basic', 'peach', '20 menit', 'pakai', 'pakai', '083847406501', '', '2024-11-30 02:53:27', '2024-11-30 02:53:27'),
(28, 'fdkd', 2, '2024-12-25', '08:00-09:00', 'basic', 'white', '20 menit', 'pakai', 'pakai', '083847406501', '', '2024-12-22 20:12:20', '2024-12-22 20:12:20'),
(29, 'I Putu Adi Saputra', 2, '2024-12-24', '14:00-15:00', 'basic', 'white', '-', '-', '-', '083847406501', '', '2024-12-22 20:28:36', '2024-12-22 20:28:36'),
(30, 'Edmund Theodore Thio', 2, '2024-12-31', '08:00-09:00', 'basic', 'white', '-', '-', '-', '083847406501', '', '2024-12-24 04:06:57', '2024-12-24 04:06:57'),
(31, 'I Putu Adi Saputra', 2, '2025-01-10', '22:00-23:00', 'basic', 'white', '-', '-', '-', '083847406501', '', '2025-01-09 20:29:56', '2025-01-09 20:29:56'),
(32, 'I Putu Adi Saputra', 2, '2025-01-21', '08:00-09:00', 'basic', 'white', '-', '-', '-', '083847406501', '', '2025-01-09 20:30:29', '2025-01-09 20:30:29'),
(33, 'I Putu Adi Saputra', 2, '2025-02-07', '22:00-23:00', 'basic', 'white', '20 menit', 'pakai', 'pakai', '083847406501', 'Motor', '2025-02-06 21:48:52', '2025-02-06 21:48:52'),
(34, 'I Putu Adi Saputra', 2, '2025-02-07', '21:00-22:00', 'basic', 'white', '20 menit', 'pakai', 'pakai', '083847406501', 'Gocar', '2025-02-06 21:49:50', '2025-02-06 21:49:50'),
(35, 'I Putu Adi Saputra', 2, '2025-02-07', '20:00-21:00', 'basic', 'white', '20 menit', 'pakai', 'pakai', '083847406501', 'Gocar', '2025-02-06 21:50:27', '2025-02-06 21:50:27'),
(36, 'adi', 2, '2031-12-27', '22:00-23:00', 'basic', 'white', '-', '-', '-', '083847406501', 'Motor', '2025-02-06 22:20:57', '2025-02-06 22:20:57'),
(37, 'adi', 2, '2031-12-27', '21:00-22:00', 'basic', 'white', '-', '-', '-', '083847406501', 'Gocar', '2025-02-06 22:21:14', '2025-02-06 22:21:14'),
(38, 'Testing', 2, '2025-05-31', '22:00-23:00', 'basic', 'american yearbook', '-', '-', '-', '083847406501', 'Motor', '2025-05-23 00:18:18', '2025-05-23 00:18:18'),
(39, 'Adi', 2, '2025-06-30', '22:00-23:00', 'basic', 'white', '-', 'pakai', 'pakai', '083847406501', 'Motor', '2025-06-06 04:32:35', '2025-06-06 04:32:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `gambar_bando`
--

CREATE TABLE `gambar_bando` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photobox_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `gambar_bando`
--

INSERT INTO `gambar_bando` (`id`, `nama`, `photobox_id`, `created_at`, `updated_at`) VALUES
(33, '674721fd70218.jpg', 19, '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(34, '674721fd7501b.jpg', 19, '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(35, '674721fd75e58.jpg', 19, '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(36, '674721fd77b6c.png', 19, '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(37, '674721fd78390.jpg', 19, '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(39, '67a5a78d01729.jpg', 41, '2025-02-06 22:26:21', '2025-02-06 22:26:21'),
(40, '67a5a78d02234.png', 41, '2025-02-06 22:26:21', '2025-02-06 22:26:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga_paket`
--

CREATE TABLE `harga_paket` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `harga_paket`
--

INSERT INTO `harga_paket` (`id`, `nama_paket`, `harga`, `created_at`, `updated_at`) VALUES
(1, 'basic', 90000, '2024-06-28 07:20:31', '2024-06-28 07:20:31'),
(2, 'spotlight', 40000, '2024-06-28 07:20:31', '2024-06-28 07:20:31'),
(3, 'photobox', 30000, '2024-06-28 07:20:31', '2024-06-28 07:20:31'),
(4, 'tirai', 40000, NULL, '2024-11-10 00:56:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga_per_orang`
--

CREATE TABLE `harga_per_orang` (
  `id` bigint UNSIGNED NOT NULL,
  `harga` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `harga_per_orang`
--

INSERT INTO `harga_per_orang` (`id`, `harga`, `created_at`, `updated_at`) VALUES
(1, 35000, '2024-06-28 07:20:31', '2024-06-28 07:20:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_04_09_035050_create_bookings_table', 1),
(6, '2024_04_14_050006_create_harga_paket_table', 1),
(7, '2024_04_14_050133_create_harga_per_orang_table', 1),
(8, '2024_06_24_151451_create_photobox_table', 1),
(9, '2024_06_28_151924_create_gambar_bando_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `photobox`
--

CREATE TABLE `photobox` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_orang` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penambahan_waktu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_bando` int DEFAULT NULL,
  `nomor_telp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kendaraan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `photobox`
--

INSERT INTO `photobox` (`id`, `nama`, `jumlah_orang`, `tanggal`, `waktu`, `penambahan_waktu`, `jumlah_bando`, `nomor_telp`, `kendaraan`, `created_at`, `updated_at`) VALUES
(10, 'Edmund Theodore Thio', 2, '2024-08-18', '08:00', '-', NULL, '', '', '2024-08-17 07:10:33', '2024-08-17 07:10:33'),
(11, 'Edmund Theodore Thio', 2, '2024-08-19', '14:00', '-', NULL, '', '', '2024-08-17 07:11:42', '2024-08-17 07:11:42'),
(12, 'I Putu Adi Saputra', 2, '2024-08-20', '14:00', '-', NULL, '', '', '2024-08-17 19:07:07', '2024-08-17 19:07:07'),
(13, 'I Putu Adi Saputra', 2, '2024-08-20', '14:30', '-', NULL, '', '', '2024-08-17 19:07:34', '2024-08-17 19:07:34'),
(14, 'I Putu Adi Saputra', 2, '2024-08-20', '15:00', '-', NULL, '', '', '2024-08-17 19:07:48', '2024-08-17 19:07:48'),
(19, 'I Putu Adi Saputra', 2, '2025-12-31', '22:30', '10 menit', 5, '', '', '2024-11-27 05:43:25', '2024-11-27 05:43:25'),
(26, 'I Putu Adi Saputra', 2, '2030-12-30', '22:30', '10 menit', 0, '083847406501', '', '2024-11-30 03:03:46', '2024-11-30 03:03:46'),
(27, 'vfhksfvs', 2, '2024-12-26', '08:00', '-', 0, '083847406501', '', '2024-12-22 20:13:54', '2024-12-22 20:13:54'),
(28, 'dkdjka', 2, '2024-12-26', '08:30', '-', 0, '083847406501', '', '2024-12-22 20:16:38', '2024-12-22 20:16:38'),
(29, 'I Putu Adi Saputra', 2, '2024-12-25', '08:00', '-', 0, '083847406501', '', '2024-12-22 20:17:27', '2024-12-22 20:17:27'),
(30, 'I Putu Adi Saputra', 2, '2024-12-26', '14:00', '-', 0, '083847406501', '', '2024-12-22 20:22:38', '2024-12-22 20:22:38'),
(31, 'I Putu Adi Saputra', 2, '2024-12-26', '22:30', '-', 0, '083847406501', '', '2024-12-22 20:23:42', '2024-12-22 20:23:42'),
(32, 'I Putu Adi Saputra', 2, '2024-12-23', '22:30', '-', 0, '083847406501', '', '2024-12-22 20:27:32', '2024-12-22 20:27:32'),
(33, 'I Putu Adi Saputra', 2, '2024-12-25', '22:30', '-', 0, '083847406501', '', '2024-12-22 20:37:41', '2024-12-22 20:37:41'),
(34, 'I Putu Adi Saputra', 2, '2024-12-26', '19:30', '-', 0, '083847406501', '', '2024-12-22 20:54:37', '2024-12-22 20:54:37'),
(35, 'I Putu Adi Saputra', 2, '2024-12-31', '08:00', '-', 0, '083847406501', '', '2024-12-24 04:08:03', '2024-12-24 04:08:03'),
(36, 'I Putu Adi Saputra', 2, '2025-01-21', '14:00', '-', 0, '083847406501', '', '2025-01-09 20:53:01', '2025-01-09 20:53:01'),
(37, 'I Putu Adi Saputra', 2, '2025-01-10', '22:30', '-', 0, '083847406501', '', '2025-01-09 20:53:38', '2025-01-09 20:53:38'),
(38, 'I Putu Adi Saputra', 2, '2025-01-21', '08:00', '-', 0, '083847406501', '', '2025-01-09 20:55:41', '2025-01-09 20:55:41'),
(39, 'I Putu Adi Saputra', 2, '2025-02-08', '22:30', '10 menit', 0, '083847406501', 'Mobil', '2025-02-06 21:57:39', '2025-02-06 21:57:39'),
(40, 'I Putu Adi Saputra', 2, '2034-12-07', '15:30', '5 menit', 0, '083847406501', 'Mobil', '2025-02-06 22:24:25', '2025-02-06 22:24:25'),
(41, 'I Putu Adi Saputra', 2, '2034-12-07', '15:00', '5 menit', 2, '083847406501', 'Gocar', '2025-02-06 22:26:21', '2025-02-06 22:26:21'),
(42, 'Adi', 2, '2025-06-07', '08:00', '-', 0, '083847406501', 'Motor', '2025-06-06 04:35:40', '2025-06-06 04:35:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, '$2y$12$81Kan4.QGAndEU87ItUBIuCdF/bG2pBfs9AM8QWwQgXavXrtD1V0a', NULL, '2024-06-28 07:20:31', '2024-06-28 07:20:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu_operasional`
--

CREATE TABLE `waktu_operasional` (
  `id` int NOT NULL,
  `hari` varchar(100) NOT NULL,
  `waktu_awal` int NOT NULL,
  `waktu_akhir` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `waktu_operasional`
--

INSERT INTO `waktu_operasional` (`id`, `hari`, `waktu_awal`, `waktu_akhir`) VALUES
(2, 'Tuesday', 8, 13),
(3, 'Wednesday', 8, 11),
(4, 'Thursday', 8, 13),
(5, 'Friday', 8, 11),
(6, 'Saturday', 0, 0),
(22, 'Monday', 0, 0),
(23, 'Sunday', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu_studio`
--

CREATE TABLE `waktu_studio` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_awal` int NOT NULL,
  `waktu_akhir` int NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `waktu_studio`
--

INSERT INTO `waktu_studio` (`id`, `tanggal`, `waktu_awal`, `waktu_akhir`, `status`) VALUES
(17, '2025-01-11', 8, 20, 'tutup'),
(18, '2025-01-11', 8, 9, 'tutup'),
(19, '2025-01-04', 8, 8, 'tutup');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gambar_bando`
--
ALTER TABLE `gambar_bando`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `harga_paket`
--
ALTER TABLE `harga_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `harga_per_orang`
--
ALTER TABLE `harga_per_orang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `photobox`
--
ALTER TABLE `photobox`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indeks untuk tabel `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `waktu_studio`
--
ALTER TABLE `waktu_studio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gambar_bando`
--
ALTER TABLE `gambar_bando`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `harga_paket`
--
ALTER TABLE `harga_paket`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `harga_per_orang`
--
ALTER TABLE `harga_per_orang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `photobox`
--
ALTER TABLE `photobox`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `waktu_studio`
--
ALTER TABLE `waktu_studio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
