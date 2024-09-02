-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2024 at 08:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food-orderr`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('kasir','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(4, 'Admin', 'admin@mail.com', '$2y$12$7x9917xVX.qDhvrMViDs3udOHewPBJGNHf7yLCzqksolb3/VRXozW', 'admin', NULL, NULL),
(5, 'Kasir', 'kasir@mail.com', '$2y$12$XNbEVyOIuaokw0Czrhvde.MMniM5E71vw7NhBdXjORRVpIrHWOOAW', 'kasir', NULL, NULL);

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
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Beverages', 'Minuman', '2024-08-07 19:55:12', '2024-08-19 01:24:25'),
(2, 'Desserts', 'Makanan Penutup', '2024-08-07 19:55:23', '2024-08-19 01:24:37'),
(3, 'Side Dishes', 'Lauk Pauk', '2024-08-18 23:12:50', '2024-08-19 01:25:04'),
(4, 'Main Course', 'Hidangan Utama', '2024-08-18 23:14:58', '2024-08-19 01:24:50'),
(5, 'Appetizers', 'Makanan Pembuka', '2024-08-18 23:15:25', '2024-08-19 01:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `keranjangs`
--

CREATE TABLE `keranjangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `kode` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjangs`
--

INSERT INTO `keranjangs` (`id`, `id_menu`, `nama_pelanggan`, `kode`, `created_at`, `updated_at`) VALUES
(15, 5, 'tia', 7373, '2024-08-18 23:24:56', '2024-08-18 23:24:56'),
(17, 1, 'Kila', 3939, '2024-08-19 00:05:24', '2024-08-19 00:05:24'),
(28, 1, 'smcscs', 5952, '2024-08-20 20:16:25', '2024-08-20 20:16:25'),
(41, 5, 'Jisung', 7058, '2024-09-01 18:44:19', '2024-09-01 18:44:19'),
(42, 5, 'Jisung', 7058, '2024-09-01 18:44:22', '2024-09-01 18:44:22'),
(43, 5, 'Jisung', 7058, '2024-09-01 18:44:26', '2024-09-01 18:44:26'),
(47, 2, 'Jisung', 1267, '2024-09-01 18:45:36', '2024-09-01 18:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama`, `kategori_id`, `deskripsi`, `foto`, `stok`, `harga`, `diskon`, `created_at`, `updated_at`) VALUES
(1, 'Bruschetta', 5, 'Roti panggang yang diberi topping seperti tomat cincang, bawang putih, basil, dan minyak zaitun.', 'images/1724057706.jpeg', 130, 35000, 4, '2024-08-07 20:02:33', '2024-08-19 01:55:06'),
(2, 'Espresso', 1, 'Kopi hitam pekat yang dibuat dengan mengekstraksi kopi bubuk dengan air panas bertekanan tinggi.', 'images/1724057757.jpeg', 200, 30000, 2, '2024-08-08 17:21:10', '2024-08-19 01:55:57'),
(3, 'Latte', 1, 'Kopi dengan campuran espresso dan susu panas dengan sedikit buih susu di atasnya.', 'images/1724057776.jpeg', 70, 35000, 0, '2024-08-18 23:22:39', '2024-08-19 01:56:16'),
(4, 'Spageti Carbonara', 4, 'Spageti dengan saus berbasis telur, keju, pancetta (daging babi), dan lada hitam.', 'images/1724057787.jpeg', 80, 15000, 0, '2024-08-18 23:23:27', '2024-08-19 01:56:27'),
(5, 'Chicken Wings (Sayap Ayam)', 5, 'Sayap ayam yang dimasak dengan berbagai saus seperti saus pedas, BBQ, atau madu mustard.', 'images/1724057739.jpeg', 75, 70000, 6, '2024-08-18 23:24:38', '2024-08-19 01:55:39');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_22_014853_create_admins_table', 2),
(6, '2024_07_29_162851_create_kategoris_table', 3),
(7, '2024_07_29_163008_create_menus_table', 3),
(8, '2024_07_29_163045_create_transaksis_table', 3),
(9, '2024_07_29_163117_create_keranjangs_table', 3),
(10, '2024_07_29_163149_create_pesanans_table', 3);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanans`
--

CREATE TABLE `pesanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `kode` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` enum('proses','selesai','pending') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanans`
--

INSERT INTO `pesanans` (`id`, `nama_pelanggan`, `kode`, `id_menu`, `jumlah`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Pipit', 1695, 2, 1, 'proses', '2024-08-18 21:10:23', '2024-08-18 21:10:23'),
(13, 'tia', 7373, 1, 1, 'pending', '2024-08-18 21:38:48', '2024-08-25 19:54:32'),
(15, 'Kila', 3939, 5, 1, 'selesai', '2024-08-18 23:25:56', '2024-08-25 19:39:56'),
(16, 'userrrrrrrr', 5506, 1, 1, 'proses', '2024-08-19 01:22:24', '2024-08-19 01:22:24'),
(17, 'userrrrrrrr', 5506, 1, 1, 'proses', '2024-08-19 01:28:10', '2024-08-19 01:28:10'),
(19, 'michael', 4115, 1, 1, 'proses', '2024-08-19 01:57:16', '2024-08-19 01:57:16'),
(20, 'michael', 4115, 2, 1, 'proses', '2024-08-19 01:57:16', '2024-08-19 01:57:16'),
(21, 'michael', 4115, 3, 1, 'proses', '2024-08-19 01:57:16', '2024-08-19 01:57:16'),
(22, 'Laura', 5065, 4, 1, 'proses', '2024-08-19 01:58:45', '2024-08-19 01:58:45'),
(23, 'putri', 7046, 5, 1, 'proses', '2024-08-19 20:04:01', '2024-08-19 20:04:01'),
(24, 'putri', 7046, 3, 1, 'proses', '2024-08-19 20:23:14', '2024-08-19 20:23:14'),
(25, 'putri', 7046, 2, 1, 'proses', '2024-08-19 20:23:14', '2024-08-19 20:23:14'),
(26, 'laravel', 4745, 5, 1, 'proses', '2024-08-20 20:43:19', '2024-08-20 20:43:19'),
(27, 'laravel', 4745, 3, 1, 'proses', '2024-08-20 20:43:19', '2024-08-20 20:43:19'),
(28, 'erika', 6830, 5, 1, 'pending', '2024-08-25 18:36:37', '2024-08-25 19:37:54'),
(29, 'erika', 6830, 4, 1, 'proses', '2024-08-25 18:36:37', '2024-08-25 18:36:37'),
(30, 'Tiwi', 9726, 1, 1, 'proses', '2024-08-25 19:27:38', '2024-08-25 19:27:38'),
(31, 'Tiwi', 9726, 3, 1, 'proses', '2024-08-25 19:27:38', '2024-08-25 19:27:38'),
(32, 'Jeno', 8787, 3, 1, 'selesai', '2024-08-28 18:24:32', '2024-08-28 18:25:09'),
(33, 'Jeno', 8787, 5, 1, 'pending', '2024-08-28 18:24:32', '2024-08-28 18:25:02'),
(34, 'Yuta', 1504, 1, 1, 'proses', '2024-09-01 18:42:42', '2024-09-01 18:42:42'),
(35, 'Yuta', 1504, 5, 1, 'proses', '2024-09-01 18:43:23', '2024-09-01 18:43:23'),
(36, 'Yuta', 1504, 4, 1, 'proses', '2024-09-01 18:43:23', '2024-09-01 18:43:23'),
(37, 'Yuta', 1504, 1, 1, 'proses', '2024-09-01 18:43:23', '2024-09-01 18:43:23'),
(38, 'Jisung', 1267, 2, 1, 'pending', '2024-09-01 18:45:10', '2024-09-01 21:02:34'),
(39, 'Jisung', 1267, 2, 1, 'selesai', '2024-09-01 18:45:10', '2024-09-01 20:00:49'),
(40, 'Jisung', 1267, 2, 1, 'proses', '2024-09-01 18:45:10', '2024-09-01 18:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menu` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_kategori_id_foreign` (`kategori_id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesanans`
--
ALTER TABLE `pesanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keranjangs`
--
ALTER TABLE `keranjangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanans`
--
ALTER TABLE `pesanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
