-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 07:51 AM
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
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `FirstName` varchar(24) NOT NULL,
  `MiddleName` varchar(24) NOT NULL,
  `LastName` varchar(24) NOT NULL,
  `Age` int(3) NOT NULL,
  `civil_status` varchar(30) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(30) NOT NULL,
  `Service` varchar(60) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `pr` int(11) DEFAULT NULL,
  `rr` int(11) DEFAULT NULL,
  `temp` decimal(2,2) DEFAULT NULL,
  `fh` int(11) DEFAULT NULL,
  `fht` int(11) NOT NULL,
  `ie` varchar(255) DEFAULT NULL,
  `aog` varchar(255) DEFAULT NULL,
  `lmp` varchar(40) DEFAULT NULL,
  `edc` varchar(40) DEFAULT NULL,
  `ob_hx` varchar(255) DEFAULT NULL,
  `ob_score` varchar(255) DEFAULT NULL,
  `ad` varchar(255) DEFAULT NULL,
  `address` varchar(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Email` varchar(65) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FName` varchar(24) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Phone` bigint(20) NOT NULL,
  `UserType` varchar(11) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `ConfirmationCode` int(24) DEFAULT NULL,
  `Status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Email`, `Password`, `FName`, `Address`, `Phone`, `UserType`, `reset_token_hash`, `reset_token_expires_at`, `ConfirmationCode`, `Status`) VALUES
(1, 'ja@gmail.com', '$2y$10$T0T7JX3c4p9SB9wouKKhmuzPe9udsb3qleamXq48M.6s.NZyVQw62', 'ja mess', 'kitakits', 9123123123, 'Admin', NULL, NULL, NULL, 'active'),
(60, 'firewaterearth2121@gmail.com', '$2y$10$8gBew.ctJeUDCqNw.WiNnuRQjMPvFlAVIXuVt3W/.cz33Z7pwUkxi', 'Britney Manangan', 'Tayug Pangasinan', 9123333424, 'Client', '964d501f0e53149f14d32fc793fb1003f366c99f7b858934d64c09a38bb12dd5', '2024-10-27 11:38:41', 0, 'active'),
(67, 'Ceraunointel@gmail.com', '$2y$10$HdordD1r5QxvcYRbki5q4.4Zyf2qQIfttLkjq7oGlPNv4pPhau04u', 'Michael Guimera', 'Kita-kita San Jose', 9214034793, 'Client', NULL, NULL, 3, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `user` (`Id`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`id`) REFERENCES `appointments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
