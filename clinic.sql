-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 08:51 AM
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
  `Service` varchar(24) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `FirstName`, `MiddleName`, `LastName`, `Age`, `civil_status`, `birth_date`, `birth_place`, `Service`, `appointment_date`, `queue_number`, `status`) VALUES
(40, 32, 'MIKE JERALD', 'biasbas', 'marzan', 21, 'single', '1998-10-10', 'tayabo', 'Counselling', '2024-10-13', 11, 'confirmed'),
(41, 32, 'MIKE ', 'haha', 'marzan', 21, 'single', '2024-10-01', 'tayabo', 'Counselling', '2024-10-13', 12, 'confirmed');

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
(25, 40, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED'),
(26, 41, '100/80', 833, 20, 0.99, 28, 140, '10 cm', '39 3/9', '10 20 22', '7-27-23', 'G2P1', '1.0.0.1', 'PUFF CIL ACTIVE LABOR PAIN', 'ZONE2 TAYABO', 'DELIVERED');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Email` varchar(24) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `FName` varchar(24) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Phone` bigint(20) NOT NULL,
  `UserType` varchar(11) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Email`, `Password`, `FName`, `Address`, `Phone`, `UserType`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'ja@gmail.com', '$2y$10$0s.aQG6Yl4GwSdGwcmeZQuNEYxerRUOvloyfsUNMd/VEFtwSw57Lq', 'mike', 'tayabo', 987654321, 'Admin', NULL, NULL),
(32, 'jerald02@gmail.com', '$2y$10$9bIgRbX19W3wjIRCBwg9bu8ucQf8nDvkYveXfKtL0t7s74TUjAejO', 'mike jerald marzan', 'tayabo', 9153635353, 'Client', NULL, NULL),
(33, 'frozenheart2121@gmail.co', '$2y$10$wur8WxlmDJzhRWX.4/E.yOfsmZkGDVBKl8uFA39xTY7rE0t0q6GOS', 'frio', 'asdfasdf', 98128312312, 'Client', NULL, NULL),
(35, 'jerald02marzan@gmail.com', '$2y$10$YPGwkN15YWsywB.8f2suMudpE8gxvPTzjZVa3vsDR.maKDyDxZWHm', 'mike jerald marzan', 'tayabo', 9704864552, 'Client', 'add764e2e69c6c97c5dce3426736ced9e7eb3a7249b53a6f39e5c478c9abd636', '2024-09-07 07:11:00'),
(36, 'isay@gmail', '$2y$10$R/bJmcjtqkIq6aK//WJImeKIQJRttpcCboAmeFgoOJsn5A5OCQKwG', 'isay', '123 sto nino 3rd', 9412312312, 'Client', NULL, NULL),
(37, 'john@gmail.com', '$2y$10$8.tFgKFyy0ElU9XYwod1IuiAywYGd.7CZ9ZqC0H10MypQNBjBxFOa', 'john', '123 sto nino 3rd', 9704864551, 'Client', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `appointment_history`
--
ALTER TABLE `appointment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
