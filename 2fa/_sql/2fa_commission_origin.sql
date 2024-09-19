-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Sep 16, 2024 at 11:21 AM
-- Server version: 5.6.51
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mreferral`
--

-- --------------------------------------------------------

--
-- Table structure for table `2fa_commission_origin`
--

DROP TABLE IF EXISTS `2fa_commission_origin`;
CREATE TABLE `2fa_commission_origin` (
  `id` int(11) NOT NULL,
  `staff_no` varchar(20) NOT NULL,
  `commission_data` longtext,
  `createBy` varchar(50) NOT NULL,
  `createDateTime` datetime NOT NULL,
  `lastModifyBy` varchar(50) NOT NULL,
  `lastModifyDateTime` datetime NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_commission_origin`
--
ALTER TABLE `2fa_commission_origin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `2fa_commission_origin`
--
ALTER TABLE `2fa_commission_origin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
