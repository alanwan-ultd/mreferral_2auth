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
-- Table structure for table `2fa_adminuser`
--

DROP TABLE IF EXISTS `2fa_adminuser`;
CREATE TABLE `2fa_adminuser` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'For users setting up their password for the first time',
  `2fa_secret` varchar(255) DEFAULT NULL,
  `2fa_qrcode` varchar(255) DEFAULT NULL,
  `2fa_receive_email` char(1) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `groupId` int(11) NOT NULL,
  `lastLoginDateTime` datetime NOT NULL,
  `noOfLogin` int(11) NOT NULL DEFAULT '0',
  `createBy` varchar(50) NOT NULL,
  `createDateTime` datetime NOT NULL,
  `lastModifyBy` varchar(50) NOT NULL,
  `lastModifyDateTime` datetime NOT NULL,
  `status` char(1) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `2fa_adminuser`
--

INSERT INTO `2fa_adminuser` (`id`, `login`, `password`, `2fa_secret`, `2fa_qrcode`, `name`, `email`, `description`, `groupId`, `lastLoginDateTime`, `noOfLogin`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, 'administrator', '', 'CMS administrator', 1, '2024-08-15 15:51:38', 117, 'admin', '2022-04-01 00:00:00', 'admin', '2024-08-15 15:54:17', 'A', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_adminuser`
--
ALTER TABLE `2fa_adminuser`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
