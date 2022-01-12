-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 04:53 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efutsal`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `jmlLap` int(1) NOT NULL,
  `jamBuka` int(11) NOT NULL,
  `jamTutup` int(11) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama`, `jmlLap`, `jamBuka`, `jamTutup`, `password`) VALUES
(1, 'eFutsal :)', 2, 6, 2, '$2y$10$/7CZQxwJU7m55KiffM0xteK04XIvSOKZfTSfYXlu9x7hHUkeAij3a');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` int(2) NOT NULL,
  `lapangan` int(1) NOT NULL,
  `bayar` int(11) NOT NULL,
  `selesai` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`id`, `nama`, `tanggal`, `jam`, `lapangan`, `bayar`, `selesai`) VALUES
(2, 'anji', '2022-01-14', 9, 2, 20000, 0),
(3, 'nia', '2022-01-11', 10, 1, 50000, 0),
(4, 'jaka', '2022-01-16', 15, 1, 20000, 0),
(5, 'edi', '2022-01-13', 18, 2, 30000, 0),
(6, 'adi', '2022-01-14', 21, 1, 20000, 0),
(7, 'Roni', '2022-01-16', 15, 2, 20000, 0),
(8, 'Andi', '2022-01-12', 10, 1, 50000, 1),
(9, 'Asiz', '2022-01-12', 10, 2, 50000, 1),
(10, 'Abdul', '2022-01-12', 11, 2, 50000, 1),
(11, 'jono', '2022-01-12', 15, 2, 50000, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
