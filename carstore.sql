-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11.08.2025 klo 19:05
-- Palvelimen versio: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carstore`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(5, 'Audi'),
(4, 'BMW'),
(3, 'Ford'),
(2, 'Honda'),
(9, 'Hyundai'),
(10, 'Kia'),
(6, 'Mercedes-Benz'),
(8, 'Nissan'),
(1, 'Toyota'),
(7, 'Volkswagen');

-- --------------------------------------------------------

--
-- Rakenne taululle `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `mileage` int(11) DEFAULT 0,
  `transmission` enum('manual','automatic','other') DEFAULT 'manual',
  `fuel_type` enum('petrol','diesel','electric','hybrid','other') DEFAULT 'petrol',
  `price` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_filename` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `cars`
--

INSERT INTO `cars` (`id`, `user_id`, `brand_id`, `model_id`, `year`, `mileage`, `transmission`, `fuel_type`, `price`, `description`, `image_filename`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 41, 2024, 50, 'manual', 'diesel', 2.00, 'test', 'car_689a108444b267.45129076.jpg', '2025-08-11 18:47:16', '2025-08-11 19:58:47');

-- --------------------------------------------------------

--
-- Rakenne taululle `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `models`
--

INSERT INTO `models` (`id`, `brand_id`, `name`) VALUES
(9, 1, '86'),
(10, 1, 'Avalon'),
(2, 1, 'Camry'),
(1, 1, 'Corolla'),
(7, 1, 'Highlander'),
(4, 1, 'Hilux'),
(8, 1, 'Land Cruiser'),
(6, 1, 'Prius'),
(3, 1, 'RAV4'),
(5, 1, 'Yaris'),
(12, 2, 'Accord'),
(11, 2, 'Civic'),
(13, 2, 'CR-V'),
(15, 2, 'Fit'),
(20, 2, 'HR-V'),
(16, 2, 'Insight'),
(17, 2, 'Odyssey'),
(19, 2, 'Passport'),
(14, 2, 'Pilot'),
(18, 2, 'Ridgeline'),
(29, 3, 'Bronco'),
(26, 3, 'Edge'),
(25, 3, 'Escape'),
(23, 3, 'Explorer'),
(24, 3, 'F-150'),
(21, 3, 'Focus'),
(27, 3, 'Fusion'),
(22, 3, 'Mustang'),
(30, 3, 'Ranger'),
(28, 3, 'Taurus'),
(31, 4, '3 Series'),
(32, 4, '5 Series'),
(33, 4, '7 Series'),
(40, 4, 'i3'),
(38, 4, 'M3'),
(39, 4, 'M5'),
(34, 4, 'X1'),
(35, 4, 'X3'),
(36, 4, 'X5'),
(37, 4, 'Z4'),
(41, 5, 'A3'),
(42, 5, 'A4'),
(43, 5, 'A6'),
(44, 5, 'A8'),
(50, 5, 'e-tron'),
(45, 5, 'Q3'),
(46, 5, 'Q5'),
(47, 5, 'Q7'),
(49, 5, 'R8'),
(48, 5, 'TT'),
(51, 6, 'A-Class'),
(52, 6, 'C-Class'),
(59, 6, 'CLA'),
(60, 6, 'CLS'),
(53, 6, 'E-Class'),
(55, 6, 'GLA'),
(56, 6, 'GLC'),
(57, 6, 'GLE'),
(58, 6, 'GLS'),
(54, 6, 'S-Class'),
(66, 7, 'Arteon'),
(69, 7, 'Atlas'),
(68, 7, 'Beetle'),
(61, 7, 'Golf'),
(70, 7, 'ID.4'),
(65, 7, 'Jetta'),
(62, 7, 'Passat'),
(64, 7, 'Polo'),
(63, 7, 'Tiguan'),
(67, 7, 'Touareg'),
(71, 8, 'Altima'),
(80, 8, 'Frontier'),
(79, 8, 'Juke'),
(75, 8, 'Leaf'),
(77, 8, 'Maxima'),
(78, 8, 'Murano'),
(74, 8, 'Pathfinder'),
(73, 8, 'Rogue'),
(72, 8, 'Sentra'),
(76, 8, 'Titan'),
(88, 9, 'Accent'),
(81, 9, 'Elantra'),
(87, 9, 'Ioniq'),
(86, 9, 'Kona'),
(89, 9, 'Palisade'),
(84, 9, 'Santa Fe'),
(82, 9, 'Sonata'),
(83, 9, 'Tucson'),
(90, 9, 'Veloster'),
(85, 9, 'Venue'),
(95, 10, 'Forte'),
(100, 10, 'Niro'),
(99, 10, 'Optima'),
(97, 10, 'Rio'),
(96, 10, 'Seltos'),
(93, 10, 'Sorento'),
(91, 10, 'Soul'),
(92, 10, 'Sportage'),
(98, 10, 'Stinger'),
(94, 10, 'Telluride');

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$vPfdUC6p/5T8Ywa4v20ZkuSEQg7QXkSvDIcLBGV9oCN6W0NCVKS5.', '2025-08-10 20:09:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `model_id` (`model_id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_id` (`brand_id`,`name`),
  ADD KEY `idx_models_brand_id` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `cars_ibfk_3` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`);

--
-- Rajoitteet taululle `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `models_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
