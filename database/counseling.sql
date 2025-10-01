-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2025 at 07:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `counseling`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_catatan_konseling`
--

CREATE TABLE `tb_catatan_konseling` (
  `id` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_siswa` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `id_pelanggaran` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pencatat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggaran`
--

CREATE TABLE `tb_pelanggaran` (
  `id` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori` enum('ringan','sedang','berat') COLLATE utf8mb4_general_ci NOT NULL,
  `poin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passwd` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id`, `nama`, `username`, `email`, `passwd`) VALUES
(1, 'Syaoqi', 'admin', NULL, 'dc76e9f0c0006e8f919e0c515c66dbba3982f785');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nisn` varchar(50) NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `jenis_kelamin` enum('pria','perempuan') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `poin` int NOT NULL DEFAULT '0',
  `alamat` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `orang_tua` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_catatan_konseling`
--
ALTER TABLE `tb_catatan_konseling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_catatan_siswa` (`id_siswa`),
  ADD KEY `fk_catatan_pelanggaran` (`id_pelanggaran`),
  ADD KEY `fk_catatan_pencatat` (`pencatat`);

--
-- Indexes for table `tb_pelanggaran`
--
ALTER TABLE `tb_pelanggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nisn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_catatan_konseling`
--
ALTER TABLE `tb_catatan_konseling`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pelanggaran`
--
ALTER TABLE `tb_pelanggaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_catatan_konseling`
--
ALTER TABLE `tb_catatan_konseling`
  ADD CONSTRAINT `fk_catatan_pelanggaran` FOREIGN KEY (`id_pelanggaran`) REFERENCES `tb_pelanggaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_catatan_pencatat` FOREIGN KEY (`pencatat`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_catatan_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`nisn`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
