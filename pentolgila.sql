-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 12:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pentolgila`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'adminDea', 'Dea123'),
(2, 'adminDona', 'adminDona'),
(4, 'tasa', 'tasa'),
(7, 'adminTasa', 'Tasa123');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `pesanan_id`, `menu_id`, `jumlah`) VALUES
(1, 1, 1, 1),
(2, 1, 9, 2),
(3, 2, 8, 1),
(4, 2, 1, 1),
(5, 3, 5, 2),
(6, 3, 3, 1),
(7, 3, 7, 1),
(8, 4, 4, 6),
(9, 5, 6, 1),
(10, 6, 3, 1),
(11, 6, 7, 1),
(12, 6, 8, 1),
(15, 9, 2, 2),
(16, 10, 3, 1),
(17, 10, 9, 1),
(18, 11, 6, 1),
(19, 11, 4, 2),
(20, 12, 1, 1),
(21, 12, 7, 3),
(22, 12, 8, 1),
(23, 13, 1, 1),
(24, 13, 5, 1),
(25, 7, 6, 10),
(26, 8, 2, 4),
(27, 8, 8, 2),
(28, 9, 4, 2),
(29, 10, 3, 2),
(30, 10, 6, 1),
(31, 11, 8, 1),
(32, 12, 8, 1),
(33, 13, 8, 1),
(34, 14, 7, 1),
(35, 15, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu1`
--

CREATE TABLE `menu1` (
  `id` int(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(20) NOT NULL,
  `gambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu1`
--

INSERT INTO `menu1` (`id`, `nama`, `harga`, `gambar`) VALUES
(1, 'Paket Gila Aja', 14000, 'Gila Aja.png'),
(2, 'Paket Gila Banget', 15000, 'Gila Banget.png'),
(3, 'Paket Super Gila', 15000, 'Super Jumbo.png'),
(4, 'Paket Petarung', 15000, 'Petarung.png'),
(5, 'Paket Nonjok', 13000, 'Nonjok.png'),
(6, 'Paket Korean Fire', 14000, 'Korean Fire Sauce.png'),
(7, 'Paket Ramah 1', 13000, 'Ramah 1.png'),
(8, 'Paket Ramah 2', 14000, 'Ramah 2.png'),
(9, 'Bakso Goreng Kopong', 13000, 'Bakso Goreng Kopong.png');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `username`, `password`) VALUES
(1, 'Dea', 'Dea'),
(2, 'dona', 'dona'),
(3, 'kiki', 'kiki'),
(4, 'audy', 'audy'),
(13, 'rendi', 'rendi'),
(14, 'elang', 'elang'),
(15, 'rehan', 'rehan123'),
(16, 'ida', 'ida123');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal_pesanan`, `nama_pelanggan`, `total`) VALUES
(1, '2023-03-27', 'ayah', '40000.00'),
(2, '2023-04-04', 'audy', '28000.00'),
(3, '2023-04-07', 'kakak', '54000.00'),
(4, '2023-06-12', 'rendi', '90000.00'),
(5, '2023-06-12', 'kiki', '14000.00'),
(6, '2023-06-12', 'dea', '42000.00'),
(7, '2023-06-13', 'dona', '140000.00'),
(8, '2023-06-13', 'Dea', '88000.00'),
(9, '2023-06-13', 'dona', '30000.00'),
(10, '2023-06-13', 'audy', '44000.00'),
(11, '2023-06-13', 'dona', '14000.00'),
(12, '2023-06-13', 'dona', '0.00'),
(13, '2023-06-13', 'dona', '0.00'),
(14, '2023-06-13', 'kiki', '13000.00'),
(15, '2023-06-13', 'Dea', '28000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `menu1`
--
ALTER TABLE `menu1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu1`
--
ALTER TABLE `menu1`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pembeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
