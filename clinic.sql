-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 11:36 AM
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

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `FirstName`, `MiddleName`, `LastName`, `Age`, `civil_status`, `birth_date`, `birth_place`, `Service`, `appointment_date`, `queue_number`, `status`) VALUES
(78, 1, 'mike', 'haha', 'marzan', 21, 'Single', '1992-10-10', 'tayabo', 'New Born Screening', '2024-10-19', 3, 'Confirmed'),
(79, 1, 'mike', 'haha', 'marzan', 21, 'Single', '2001-12-19', 'tayabo', 'New Born Care', '2024-10-19', 4, 'Confirmed'),
(82, 1, 'mike', 'haha', 'marzan', 21, 'Single', '1231-12-31', 'tayabo', 'Post Partum Care Post Partum', '2024-10-19', 7, 'Confirmed'),
(83, 1, 'mike', 'haha', 'marzan', 21, 'Single', '0232-12-31', 'tayabo', 'Normal Spontaneous Delivery', '2024-10-19', 8, 'Confirmed'),
(84, 1, 'mike', 'haha', 'marzan', 21, 'Single', '2233-12-31', 'tayabo', 'Normal Spontaneous Delivery', '2024-10-19', 9, 'Confirmed'),
(92, 32, 'mike', 'haha', 'marzan', 21, 'Single', '1998-12-31', 'tayabo', 'Ear Piercing', '2024-10-26', 1, 'pending'),
(93, 32, 'mike', 'haha', 'marzan', 21, 'Single', '1998-12-31', 'tayabo', 'Ear Piercing', '2024-10-26', 2, 'pending');

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
(32, 84, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED');

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
(32, 'jerald02@gmail.com', '$2y$10$9bIgRbX19W3wjIRCBwg9bu8ucQf8nDvkYveXfKtL0t7s74TUjAejO', 'mark ', '173 zone tayabo san jose city ', 9704864553, 'Client', 'b1ed6b2995ca35cb05bf5464e91511d86763770f6010e421b5924c26df778768', '2024-10-15 08:11:30', NULL, ''),
(42, 'ruko@gmail.com', '$2y$10$HyErLw.4v9wX7jjAxFnDVeQo0JiEPGJUCmbUYcPGfweVMw3r0XoHS', 'ruko', '173 zone tayabo san jose city ', 9704864551, 'Client', NULL, NULL, NULL, ''),
(55, 'jerald02marzan@gmail.com', '$2y$10$m5cJwispmq8QUwOG50WZ8.KmUNEM0nqdDeJP9tlvPpVIt6zBn0g/6', 'MIKE JERALD BIASBAS MARZ', '173 zone tayabo san jose city ', 9704861551, 'Client', NULL, NULL, 0, 'active');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `appointment_history`
--
ALTER TABLE `appointment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
