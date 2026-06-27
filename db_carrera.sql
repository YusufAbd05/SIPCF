-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2026 at 03:51 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_carrera`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(2, '2026-04-22-130000', 'App\\Database\\Migrations\\TLapang', 'default', 'App', 1776862916, 2),
(3, '2026-04-22-130100', 'App\\Database\\Migrations\\TLapangTarif', 'default', 'App', 1776862916, 2),
(5, '2026-04-22-130300', 'App\\Database\\Migrations\\TPembayaran', 'default', 'App', 1776862916, 2),
(7, '2026-04-11-162558', 'App\\Database\\Migrations\\TUser', 'default', 'App', 1776994042, 3),
(8, '2026-04-22-130200', 'App\\Database\\Migrations\\TSewaLapangan', 'default', 'App', 1776994059, 4),
(9, '2026-05-17-040000', 'App\\Database\\Migrations\\AddTipeSewaColumn', 'default', 'App', 1778991078, 5),
(10, '2026-05-17-041800', 'App\\Database\\Migrations\\CreateJadwalMembership', 'default', 'App', 1778991782, 6),
(11, '2026-05-17-051500', 'App\\Database\\Migrations\\RenameTipeSewaAndJadwalTable', 'default', 'App', 1778995208, 7),
(12, '2026-05-17-054800', 'App\\Database\\Migrations\\FixDatabaseOverall', 'default', 'App', 1778997164, 8),
(13, '2026-05-17-055700', 'App\\Database\\Migrations\\MoveScheduleToJadwal', 'default', 'App', 1778997441, 9),
(14, '2026-05-26-140000', 'App\\Database\\Migrations\\AddOwnerRole', 'default', 'App', 1779804075, 10),
(15, '2026-05-26-142900', 'App\\Database\\Migrations\\AddIdLapangToJadwal', 'default', 'App', 1779805846, 11),
(16, '2026-06-06-235600', 'App\\Database\\Migrations\\AddEmailPenyewaToTSewaLapangan', 'default', 'App', 1780765265, 12),
(17, '2026-06-07-112000', 'App\\Database\\Migrations\\AlterTLapangTarifChangeHargaMember', 'default', 'App', 1780831322, 13);

-- --------------------------------------------------------

--
-- Table structure for table `t_jadwal`
--

CREATE TABLE `t_jadwal` (
  `id_jadwal` int UNSIGNED NOT NULL,
  `id_sewa` int UNSIGNED NOT NULL,
  `id_lapang` int UNSIGNED NOT NULL,
  `sesi_ke` tinyint NOT NULL,
  `tanggal_main` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_sesi` enum('Terjadwal','Selesai','Dibatalkan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Terjadwal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_lapang`
--

CREATE TABLE `t_lapang` (
  `id_lapang` int UNSIGNED NOT NULL,
  `nama_lapangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `spesifikasi_lapang` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_lapang` enum('Tersedia','Perbaikan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Tersedia',
  `jam_buka_weekday` time NOT NULL,
  `jam_tutup_weekday` time NOT NULL,
  `jam_buka_weekend` time NOT NULL,
  `jam_tutup_weekend` time NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_lapang`
--

INSERT INTO `t_lapang` (`id_lapang`, `nama_lapangan`, `spesifikasi_lapang`, `status_lapang`, `jam_buka_weekday`, `jam_tutup_weekday`, `jam_buka_weekend`, `jam_tutup_weekend`, `created_at`, `updated_at`) VALUES
(1, 'Lapang 1', 'Rumput Sintetis', 'Tersedia', '08:00:00', '00:00:00', '08:00:00', '23:00:00', '2026-06-27 15:36:46', '2026-06-27 15:36:53'),
(2, 'Lapang 2', 'Rumput Sintetis', 'Tersedia', '08:00:00', '00:00:00', '08:00:00', '23:00:00', '2026-06-27 15:37:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_lapang_tarif`
--

CREATE TABLE `t_lapang_tarif` (
  `id_tarif` int UNSIGNED NOT NULL,
  `id_lapang` int UNSIGNED NOT NULL,
  `nama_tarif` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hari` enum('Weekday','Weekend','Libur Nasional') COLLATE utf8mb4_general_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `harga_umum` decimal(12,2) NOT NULL DEFAULT '0.00',
  `harga_harian` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_lapang_tarif`
--

INSERT INTO `t_lapang_tarif` (`id_tarif`, `id_lapang`, `nama_tarif`, `hari`, `jam_mulai`, `jam_selesai`, `harga_umum`, `harga_harian`) VALUES
(1, 1, 'Pagi Weekday Lapang 1', 'Weekday', '08:00:00', '12:00:00', '80000.00', 0),
(2, 1, 'Sore Weekday Lapang 1', 'Weekday', '12:00:00', '18:00:00', '90000.00', 0),
(3, 1, 'Malam Weekday Lapang 1', 'Weekday', '18:00:00', '00:00:00', '100000.00', 0),
(4, 1, 'Pagi Weekend Lapang 1', 'Weekend', '08:00:00', '12:00:00', '90000.00', 0),
(5, 1, 'Sore Weekend Lapang 1', 'Weekend', '12:00:00', '18:00:00', '100000.00', 0),
(6, 1, 'Malam Weekend Lapang 1', 'Weekend', '08:00:00', '23:00:00', '120000.00', 0),
(7, 2, 'Pagi Weekday Lapang 2', 'Weekday', '08:00:00', '12:00:00', '80000.00', 0),
(8, 2, 'Sore Weekday Lapang 2', 'Weekday', '12:00:00', '18:00:00', '90000.00', 0),
(9, 2, 'Malam Weekday Lapang 2', 'Weekday', '18:00:00', '00:00:00', '100000.00', 0),
(10, 2, 'Pagi Weekend Lapang 2', 'Weekend', '08:00:00', '12:00:00', '90000.00', 0),
(11, 2, 'Sore Weekend Lapang 2', 'Weekend', '12:00:00', '18:00:00', '100000.00', 0),
(13, 2, 'Malam Weekend Lapang 2', 'Weekend', '18:00:00', '23:00:00', '120000.00', 0),
(14, 1, 'Harian Weekday Lapang 1', 'Weekday', '08:00:00', '00:00:00', '0.00', 1000000),
(15, 1, 'Harian Weekend', 'Weekend', '08:00:00', '23:00:00', '0.00', 1500000),
(16, 2, 'Harian Weekday Lapang 2', 'Weekday', '08:00:00', '00:00:00', '0.00', 1000000),
(17, 2, 'Harian Weekend Lapang 2', 'Weekend', '08:00:00', '23:00:00', '0.00', 1500000);

-- --------------------------------------------------------

--
-- Table structure for table `t_pembayaran`
--

CREATE TABLE `t_pembayaran` (
  `id_pembayaran` int UNSIGNED NOT NULL,
  `id_sewa` int UNSIGNED NOT NULL,
  `jenis_pembayaran` enum('DP','Pelunasan','Full') COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL DEFAULT '0.00',
  `metode` enum('Transfer Bank','E-Wallet','Cash') COLLATE utf8mb4_general_ci NOT NULL,
  `url_bukti_bayar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pembayaran` enum('Pending','Sukses','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `waktu_pembayaran` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_sewa_lapangan`
--

CREATE TABLE `t_sewa_lapangan` (
  `id_sewa` int UNSIGNED NOT NULL,
  `kode_sewa` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_lapang` int UNSIGNED NOT NULL,
  `nama_penyewa` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp_penyewa` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email_penyewa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipe_pesanan` enum('Online','Walk-in') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Online',
  `tipe_sewa` enum('Per Jam','Harian','Membership') COLLATE utf8mb4_general_ci DEFAULT 'Per Jam',
  `durasi_jam` int NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status_pesanan` enum('Menunggu','Menunggu Pembayaran','Menunggu Verifikasi','Dikonfirmasi','Ditolak','Selesai','Dibatalkan') COLLATE utf8mb4_general_ci DEFAULT 'Menunggu Pembayaran',
  `alasan_penolakan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Admin','Manajer','Owner') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `nama`, `email`, `no_hp`, `password`, `role`, `created_at`, `updated_at`) VALUES
(3, 'manajer', 'manajer@gmail.com', '087965478921', '$2y$10$a2.OpAnW46xHxM5IBVlG4.2JcNEyGGDcMSvVldoakEB8U2isDrsDK', 'Manajer', '2026-05-26 14:04:14', NULL),
(4, 'owner', 'owner@gmail.com', '087659462718', '$2y$10$KVMbsTPQwu6SgIswBK/jceMzFvQ.UQaBkjSLjbvx7FV../DI9wm..', 'Owner', '2026-05-26 14:04:43', NULL),
(6, 'admin', 'admin@gmail.com', '087654362718', '$2y$10$jdvzK8R7L6OOX8CZVwfRyeYM0IhL4.onlA4HUQfd8KLY8EEK2UQ2e', 'Admin', '2026-06-23 11:06:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_jadwal`
--
ALTER TABLE `t_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `idx_jadwal_tanggal` (`tanggal_main`),
  ADD KEY `t_jadwal_id_sewa_foreign` (`id_sewa`),
  ADD KEY `idx_jadwal_lapang` (`id_lapang`);

--
-- Indexes for table `t_lapang`
--
ALTER TABLE `t_lapang`
  ADD PRIMARY KEY (`id_lapang`);

--
-- Indexes for table `t_lapang_tarif`
--
ALTER TABLE `t_lapang_tarif`
  ADD PRIMARY KEY (`id_tarif`),
  ADD KEY `t_lapang_tarif_id_lapang_foreign` (`id_lapang`);

--
-- Indexes for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `t_pembayaran_id_sewa_foreign` (`id_sewa`);

--
-- Indexes for table `t_sewa_lapangan`
--
ALTER TABLE `t_sewa_lapangan`
  ADD PRIMARY KEY (`id_sewa`),
  ADD UNIQUE KEY `idx_kode_sewa` (`kode_sewa`),
  ADD KEY `idx_status_pesanan` (`status_pesanan`),
  ADD KEY `idx_slot_check` (`id_lapang`,`status_pesanan`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `idx_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_jadwal`
--
ALTER TABLE `t_jadwal`
  MODIFY `id_jadwal` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_lapang`
--
ALTER TABLE `t_lapang`
  MODIFY `id_lapang` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_lapang_tarif`
--
ALTER TABLE `t_lapang_tarif`
  MODIFY `id_tarif` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  MODIFY `id_pembayaran` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_sewa_lapangan`
--
ALTER TABLE `t_sewa_lapangan`
  MODIFY `id_sewa` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_jadwal`
--
ALTER TABLE `t_jadwal`
  ADD CONSTRAINT `t_jadwal_id_sewa_foreign` FOREIGN KEY (`id_sewa`) REFERENCES `t_sewa_lapangan` (`id_sewa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_lapang_tarif`
--
ALTER TABLE `t_lapang_tarif`
  ADD CONSTRAINT `t_lapang_tarif_id_lapang_foreign` FOREIGN KEY (`id_lapang`) REFERENCES `t_lapang` (`id_lapang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  ADD CONSTRAINT `t_pembayaran_id_sewa_foreign` FOREIGN KEY (`id_sewa`) REFERENCES `t_sewa_lapangan` (`id_sewa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_sewa_lapangan`
--
ALTER TABLE `t_sewa_lapangan`
  ADD CONSTRAINT `t_sewa_lapangan_id_lapang_foreign` FOREIGN KEY (`id_lapang`) REFERENCES `t_lapang` (`id_lapang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
