-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 15, 2024 at 09:04 AM
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
-- Table structure for table `2fa_admingroup`
--

DROP TABLE IF EXISTS `2fa_admingroup`;
CREATE TABLE `2fa_admingroup` (
  `id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `createBy` varchar(16) NOT NULL,
  `createDateTime` datetime NOT NULL,
  `lastModifyBy` varchar(16) NOT NULL,
  `lastModifyDateTime` datetime NOT NULL,
  `status` char(1) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `2fa_admingroup`
--

INSERT INTO `2fa_admingroup` (`id`, `position`, `title`, `description`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
(1, 1, 'Admin', 'Administrator - Most powerful user.', 'admin', '2022-04-01 00:00:00', 'admin', '2023-03-01 19:24:56', 'A', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_admingroup`
--
ALTER TABLE `2fa_admingroup`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
