-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 02, 2025 at 02:05 PM
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
-- Database: `db_metode_waspas`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akun`
--

CREATE TABLE `tbl_akun` (
  `id_akun` int NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','kepala_dinas') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_akun`
--

INSERT INTO `tbl_akun` (`id_akun`, `nama_lengkap`, `username`, `password`, `role`) VALUES
(1, 'Administrator', 'admin', '12345', 'admin'),
(2, 'Kepala Dinas', 'Kepala_dinas', '12345', 'kepala_dinas');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alternatif`
--

CREATE TABLE `tbl_alternatif` (
  `id_alternatif` int NOT NULL,
  `nama_alternatif` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_hama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `bentuk_pestisida` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `warna_pestisida` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `matriks_a` double NOT NULL,
  `matriks_b` double NOT NULL,
  `nilai_waspas` double NOT NULL,
  `rangking` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_alternatif`
--

INSERT INTO `tbl_alternatif` (`id_alternatif`, `nama_alternatif`, `jenis_hama`, `bentuk_pestisida`, `warna_pestisida`, `matriks_a`, `matriks_b`, `nilai_waspas`, `rangking`) VALUES
(1, 'Curater 3G', 'Ulat Grayak', 'Butiran Bubuk', 'Biru keabu-abu', 0.44166666666667, 0.43384846345563, 0.43775756506115, 8),
(2, 'Curacron 500 EC', 'Kutu Daun', 'Larutan Air', 'Kuning Kecoklatan', 0.725, 0.62286546980776, 0.67393273490388, 2),
(3, 'Pima X 480 SL', 'Ulat Daun', 'Larutan Air', 'Hijau', 0.39166666666667, 0.37768702424645, 0.38467684545656, 10),
(4, 'Gromoxon 276 SL', 'Gulma', 'Larutan Air', 'Hijau Tua', 0.39166666666667, 0.38415871140618, 0.38791268903643, 9),
(5, 'Round UP 486 SL', 'Belalang', 'Larutan Air', 'Kuning Keemasan', 0.525, 0.50426556816621, 0.51463278408311, 7),
(6, 'Agrobat 50 WP', 'Ulat Grayak & Busuk Daun', 'Bubuk Tepung', 'Putih', 0.70833333333333, 0.68078121064845, 0.69455727199089, 1),
(7, 'Spesial D', 'Ulat Daun', 'Bubuk Tepung', 'Kekuningan', 0.55833333333333, 0.5529661697435, 0.55564975153842, 6),
(8, 'Herbatop 480 SL', 'Gulma', 'Larutan Air', 'Hijau', 0.65833333333333, 0.61920810048774, 0.63877071691053, 3),
(9, 'Fujiwan 10 WP', 'Wereng', 'Larutan Air', 'Coklat Muda', 0.65, 0.59265446641143, 0.62132723320572, 4),
(10, 'Indobas 500 EC', 'Serangga', 'Larutan Air', 'Coklat Muda', 0.64166666666667, 0.57924902863417, 0.61045784765042, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kepala`
--

CREATE TABLE `tbl_kepala` (
  `id_kepala` int NOT NULL,
  `nama_kepala` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kepala`
--

INSERT INTO `tbl_kepala` (`id_kepala`, `nama_kepala`, `jabatan`, `nip`) VALUES
(1, 'FOFY HIDAYAH', 'KEPALA DESA', '21101152610284');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

CREATE TABLE `tbl_kriteria` (
  `id_kriteria` int NOT NULL,
  `nama_kriteria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `bobot_kriteria` double NOT NULL,
  `tipe_kriteria` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kriteria`
--

INSERT INTO `tbl_kriteria` (`id_kriteria`, `nama_kriteria`, `bobot_kriteria`, `tipe_kriteria`) VALUES
(1, 'Harga (Rp)', 30, 'Cost'),
(2, 'Volume Racun/Ha (ml/gr)', 25, 'Benefit'),
(3, 'Ukuran Kemasan (liter/kg)', 10, 'Benefit'),
(4, 'Masa Kadaluarsa (Tahun)', 20, 'Benefit'),
(5, 'Luas Cakupan (m2)', 15, 'Benefit');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nilai`
--

CREATE TABLE `tbl_nilai` (
  `id_nilai` int NOT NULL,
  `id_alternatif` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `id_subkriteria` int NOT NULL,
  `nilai_alternatif` int NOT NULL,
  `nilai_subkriteria` int NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_nilai`
--

INSERT INTO `tbl_nilai` (`id_nilai`, `id_alternatif`, `id_kriteria`, `id_subkriteria`, `nilai_alternatif`, `nilai_subkriteria`, `tanggal`) VALUES
(303, 1, 1, 45, 55000, 2, '2025-01-31 00:00:00'),
(304, 1, 2, 50, 1000, 1, '2025-01-31 00:00:00'),
(305, 1, 3, 53, 11, 1, '2025-01-31 00:00:00'),
(306, 1, 4, 57, 4, 2, '2025-01-31 00:00:00'),
(307, 1, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(308, 2, 1, 47, 150000, 4, '2025-01-31 00:00:00'),
(309, 2, 2, 52, 100, 3, '2025-01-31 00:00:00'),
(310, 2, 3, 55, 1, 3, '2025-01-31 00:00:00'),
(311, 2, 4, 58, 3, 3, '2025-01-31 00:00:00'),
(312, 2, 5, 44, 5000, 2, '2025-01-31 00:00:00'),
(313, 3, 1, 45, 81000, 2, '2025-01-31 00:00:00'),
(314, 3, 2, 50, 1000, 1, '2025-01-31 00:00:00'),
(315, 3, 3, 53, 10, 1, '2025-01-31 00:00:00'),
(316, 3, 4, 56, 5, 1, '2025-01-31 00:00:00'),
(317, 3, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(318, 4, 1, 46, 125000, 3, '2025-01-31 00:00:00'),
(319, 4, 2, 50, 1000, 1, '2025-01-31 00:00:00'),
(320, 4, 3, 53, 7, 1, '2025-01-31 00:00:00'),
(321, 4, 4, 57, 4, 2, '2025-01-31 00:00:00'),
(322, 4, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(323, 5, 1, 45, 88800, 2, '2025-01-31 00:00:00'),
(324, 5, 2, 50, 1000, 1, '2025-01-31 00:00:00'),
(325, 5, 3, 54, 5, 2, '2025-01-31 00:00:00'),
(326, 5, 4, 58, 3, 3, '2025-01-31 00:00:00'),
(327, 5, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(328, 6, 1, 29, 50000, 1, '2025-01-31 00:00:00'),
(329, 6, 2, 51, 400, 2, '2025-01-31 00:00:00'),
(330, 6, 3, 54, 2, 2, '2025-01-31 00:00:00'),
(331, 6, 4, 57, 4, 2, '2025-01-31 00:00:00'),
(332, 6, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(333, 7, 1, 45, 84000, 2, '2025-01-31 00:00:00'),
(334, 7, 2, 51, 250, 2, '2025-01-31 00:00:00'),
(335, 7, 3, 54, 5, 2, '2025-01-31 00:00:00'),
(336, 7, 4, 57, 4, 2, '2025-01-31 00:00:00'),
(337, 7, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(338, 8, 1, 45, 70000, 2, '2025-01-31 00:00:00'),
(339, 8, 2, 52, 100, 3, '2025-01-31 00:00:00'),
(340, 8, 3, 53, 8, 1, '2025-01-31 00:00:00'),
(341, 8, 4, 58, 3, 3, '2025-01-31 00:00:00'),
(342, 8, 5, 43, 10000, 1, '2025-01-31 00:00:00'),
(343, 9, 1, 45, 82900, 2, '2025-01-31 00:00:00'),
(344, 9, 2, 50, 500, 1, '2025-01-31 00:00:00'),
(345, 9, 3, 54, 3, 2, '2025-01-31 00:00:00'),
(346, 9, 4, 59, 2, 4, '2025-01-31 00:00:00'),
(347, 9, 5, 44, 5000, 2, '2025-01-31 00:00:00'),
(348, 10, 1, 29, 35000, 1, '2025-02-02 13:45:12'),
(349, 10, 2, 50, 400, 1, '2025-02-02 13:45:12'),
(350, 10, 3, 53, 5, 1, '2025-02-02 13:45:12'),
(351, 10, 4, 58, 3, 3, '2025-02-02 13:45:12'),
(352, 10, 5, 43, 10000, 1, '2025-02-02 13:45:12'),
(353, 8, 1, 45, 70000, 2, '2025-01-31 00:00:00'),
(354, 8, 2, 50, 1000, 1, '2025-01-31 00:00:00'),
(355, 8, 3, 53, 8, 1, '2025-01-31 00:00:00'),
(356, 8, 4, 58, 3, 3, '2025-01-31 00:00:00'),
(357, 8, 5, 43, 10000, 1, '2025-01-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subkriteria`
--

CREATE TABLE `tbl_subkriteria` (
  `id_subkriteria` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nama_subkriteria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_subkriteria` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subkriteria`
--

INSERT INTO `tbl_subkriteria` (`id_subkriteria`, `id_kriteria`, `nama_subkriteria`, `nilai_subkriteria`) VALUES
(26, 8, '2 Tahun', 4),
(27, 9, '10000 m2', 1),
(28, 9, '5000 m2', 2),
(29, 1, '>30.000-50.000', 1),
(43, 5, '10000 m2', 1),
(44, 5, '5000 m2', 2),
(45, 1, '> 50.000-100.000', 2),
(46, 1, '> 100.000-149.000', 3),
(47, 1, '>=150.000', 4),
(50, 2, '500 ml/mg - 1000 ml/mg', 1),
(51, 2, '250 ml/mg - 449 ml/mg', 2),
(52, 2, '100 ml/mg - 249 ml/mg', 3),
(53, 3, '6 Liter/kg - 11 Liter/kg', 1),
(54, 3, '2 Liter/kg - 5 Liter/kg', 2),
(55, 3, '0,5 Liter/kg - 1 Liter/kg', 3),
(56, 4, '5 Tahun', 1),
(57, 4, '4 Tahun', 2),
(58, 4, '3 Tahun', 3),
(59, 4, '2 Tahun', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_akun`
--
ALTER TABLE `tbl_akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indexes for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `tbl_kepala`
--
ALTER TABLE `tbl_kepala`
  ADD PRIMARY KEY (`id_kepala`);

--
-- Indexes for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tbl_subkriteria`
--
ALTER TABLE `tbl_subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_akun`
--
ALTER TABLE `tbl_akun`
  MODIFY `id_akun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  MODIFY `id_alternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `tbl_subkriteria`
--
ALTER TABLE `tbl_subkriteria`
  MODIFY `id_subkriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
