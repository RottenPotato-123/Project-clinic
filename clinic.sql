-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 11:44 AM
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
  `status` varchar(20) DEFAULT 'pending',
  `updated_at` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `FirstName`, `MiddleName`, `LastName`, `Age`, `civil_status`, `birth_date`, `birth_place`, `Service`, `appointment_date`, `queue_number`, `status`, `updated_at`) VALUES
(122, 1, 'hahhaha', '', 'marzan', 25, 'Single', '1998-11-11', 'tayabo', 'Post Partum Care Post Partum', '2024-10-28', 1, 'Done', '15:04:19'),
(152, 1, 'mike', '', 'marzan', 26, 'Single', '1998-10-10', 'tayabo', 'Post Partum Care Post Partum', '2024-11-12', 1, 'Confirmed', '18:34:46'),
(153, 1, 'frio', '', 'marzan', 26, 'Single', '1998-10-10', 'tayabo', 'Ear Piercing', '2024-11-12', 2, 'Ongoing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_history`
--

CREATE TABLE `appointment_history` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
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

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `id`, `bp`, `pr`, `rr`, `temp`, `fh`, `fht`, `ie`, `aog`, `lmp`, `edc`, `ob_hx`, `ob_score`, `ad`, `address`, `remarks`) VALUES
(29, 79, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED'),
(30, 82, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED'),
(31, 83, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED'),
(32, 84, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED'),
(33, 119, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'san jose city', 'DELIVERED'),
(34, 119, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'san jose city', 'DELIVERED'),
(35, 122, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'san jose city', 'DELIVERED'),
(36, 122, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'san jose city', 'DELIVERED');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Email` varchar(24) NOT NULL,
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
(1, 'ja@gmail.com', '$2y$10$0s.aQG6Yl4GwSdGwcmeZQuNEYxerRUOvloyfsUNMd/VEFtwSw57Lq', 'mike', 'tayabo', 987654321, 'Admin', NULL, NULL, NULL, 'active'),
(42, 'ruko@gmail.com', '$2y$10$HyErLw.4v9wX7jjAxFnDVeQo0JiEPGJUCmbUYcPGfweVMw3r0XoHS', 'ruko', '173 zone tayabo san jose city ', 9704864551, 'Client', NULL, NULL, NULL, 'active'),
(55, 'jerald02marzan@gmail.com', '$2y$10$Bv6Is0UMwgIqcBdtZU1TxuVwWP2QF86Qc5nbzao3GQ6hWZeFwxJLG', 'MIKE JERALD BIASBAS MARZ', '173 zone tayabo san jose city ', 9704861551, 'Client', '40915ee5a2bc944235718ddadb7facf24500370f716ba92157d79a5cddabe0e7', '2024-10-27 05:07:47', 0, 'active'),
(59, 'ediane.mike@gmail.com', '$2y$10$3qXGv3bSI0.EiDp5N2cm6ubXBeujJHKVazWKoNKUkKk.Z0FKTpsxy', 'JERALD BIASBAS MARZAN', 'kitakitass', 9123231231, 'Client', NULL, NULL, 219, 'inactive');

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
-- Indexes for table `appointment_history`
--
ALTER TABLE `appointment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `appointment_history`
--
ALTER TABLE `appointment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `user` (`Id`);

--
-- Constraints for table `appointment_history`
--
ALTER TABLE `appointment_history`
  ADD CONSTRAINT `appointment_history_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`id`) REFERENCES `appointments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
