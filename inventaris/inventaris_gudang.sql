-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 06:26 PM
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
-- Database: `inventaris_gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(50) NOT NULL,
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `harga`, `kategori_id`) VALUES
(1, 'chips', 2000, 1),
(2, 'kentang', 1500, 1),
(3, 'larutan', 8000, 2),
(4, 'soda', 4500, 2),
(5, 'Milo', 2500, 2),
(6, 'ciki', 2000, 1),
(7, 'teh', 2500, 2),
(8, 'kopi', 2000, 2),
(9, 'susu', 2000, 2),
(10, 'sosis', 1000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pencatatan`
--

CREATE TABLE `detail_pencatatan` (
  `id` int(11) NOT NULL,
  `pencatatan_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pencatatan`
--

INSERT INTO `detail_pencatatan` (`id`, `pencatatan_id`, `barang_id`, `jumlah_barang`, `total_harga`) VALUES
(1, 1, 1, 12, 24000),
(2, 2, 1, 12, 24000),
(3, 2, 4, 4, 18000),
(4, 2, 3, 4, 32000),
(5, 3, 1, 12, 24000),
(6, 3, 4, 4, 18000),
(7, 3, 3, 4, 32000),
(8, 4, 1, 120, 240000),
(9, 5, 1, 120, 240000),
(10, 6, 1, 13, 26000),
(11, 7, 1, 120, 240000),
(12, 8, 4, 13, 58500),
(13, 9, 6, 20, 40000),
(14, 10, 1, 200, 400000),
(15, 11, 7, 30, 75000),
(16, 12, 7, 20, 50000),
(17, 14, 8, 20, 40000),
(18, 15, 9, 20, 40000),
(19, 16, 10, 30, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'makanan'),
(2, 'minuman');

-- --------------------------------------------------------

--
-- Table structure for table `pencatatan_barang`
--

CREATE TABLE `pencatatan_barang` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_catatan` enum('masuk','keluar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pencatatan_barang`
--

INSERT INTO `pencatatan_barang` (`id`, `users_id`, `tanggal`, `jenis_catatan`) VALUES
(1, 2, '2024-06-15', 'masuk'),
(2, 2, '2024-06-15', 'masuk'),
(3, 2, '2024-06-15', 'masuk'),
(4, 1, '2024-06-16', 'masuk'),
(5, 1, '2024-06-16', 'masuk'),
(6, 1, '2024-06-16', 'masuk'),
(7, 1, '2024-06-16', 'masuk'),
(8, 1, '2024-06-16', 'masuk'),
(9, 2, '2024-06-16', 'masuk'),
(10, 1, '2024-06-16', 'keluar'),
(11, 2, '2024-06-16', 'masuk'),
(12, 2, '2024-06-16', 'masuk'),
(13, 2, '2024-06-16', 'masuk'),
(14, 2, '2024-06-16', 'masuk'),
(15, 2, '2024-06-16', 'masuk'),
(16, 2, '2024-06-16', 'masuk');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `barang_id`, `stok`) VALUES
(1, 1, 209),
(2, 2, 25),
(3, 3, 23),
(4, 4, 41),
(5, 5, 20),
(6, 6, 20),
(7, 7, 50),
(8, 8, 20),
(9, 9, 20),
(10, 10, 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(8) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'user', 'test', 'user'),
(2, 'admin', 'test', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori_id`);

--
-- Indexes for table `detail_pencatatan`
--
ALTER TABLE `detail_pencatatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pencatatan` (`pencatatan_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pencatatan_barang`
--
ALTER TABLE `pencatatan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`users_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail_pencatatan`
--
ALTER TABLE `detail_pencatatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pencatatan_barang`
--
ALTER TABLE `pencatatan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `detail_pencatatan`
--
ALTER TABLE `detail_pencatatan`
  ADD CONSTRAINT `barang_id` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `pencatatan` FOREIGN KEY (`pencatatan_id`) REFERENCES `pencatatan_barang` (`id`);

--
-- Constraints for table `pencatatan_barang`
--
ALTER TABLE `pencatatan_barang`
  ADD CONSTRAINT `user` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
