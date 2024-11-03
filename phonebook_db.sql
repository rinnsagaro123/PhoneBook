-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 04:55 PM
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
-- Database: `phonebook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `phonebook`
--

CREATE TABLE `phonebook` (
  `id` int(11) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phonebook`
--

INSERT INTO `phonebook` (`id`, `data`) VALUES
(2, '{\"name\":\"Angelo \",\"address\":\"Silang Cavite \",\"phone_number\":\"09066806016\",\"email_address\":\"\"}'),
(3, '{\"name\":\"Paolo\",\"address\":\"San Pedro Laguna\",\"phone_number\":\"09291067407\",\"email_address\":\"\"}'),
(6, '{\"name\":\"Michael \",\"address\":\"Landayan San Pedro\",\"phone_number\":\"09659087654\",\"email_address\":\"\"}'),
(7, '{\"name\":\"Ijen\",\"address\":\"Cuyab San Pedro\",\"phone_number\":\"09276578709\",\"email_address\":\"\"}');

-- --------------------------------------------------------

--
-- Table structure for table `phonebook_fields`
--

CREATE TABLE `phonebook_fields` (
  `id` int(11) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phonebook_fields`
--

INSERT INTO `phonebook_fields` (`id`, `field_name`, `field_type`) VALUES
(1, 'Name', 'text'),
(2, 'Address', 'text'),
(3, 'Phone Number', 'number');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phonebook`
--
ALTER TABLE `phonebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phonebook_fields`
--
ALTER TABLE `phonebook_fields`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phonebook`
--
ALTER TABLE `phonebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `phonebook_fields`
--
ALTER TABLE `phonebook_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
