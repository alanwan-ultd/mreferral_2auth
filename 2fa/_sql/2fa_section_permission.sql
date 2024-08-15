-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 15, 2024 at 09:05 AM
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
-- Table structure for table `2fa_section_permission`
--

DROP TABLE IF EXISTS `2fa_section_permission`;
CREATE TABLE `2fa_section_permission` (
  `section` varchar(191) NOT NULL,
  `admingroup_id` int(11) NOT NULL,
  `read_` char(1) NOT NULL,
  `write_` char(1) NOT NULL,
  `approve_` char(1) NOT NULL,
  `createBy` varchar(16) NOT NULL,
  `createDateTime` datetime NOT NULL,
  `lastModifyBy` varchar(16) NOT NULL,
  `lastModifyDateTime` datetime NOT NULL,
  `status` char(1) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `2fa_section_permission`
--

INSERT INTO `2fa_section_permission` (`section`, `admingroup_id`, `read_`, `write_`, `approve_`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
('admin', 1, '1', '1', '1', '', '2020-04-03 16:16:51', '', '2022-05-19 12:30:53', 'A', 'N'),
('adminGroup', 1, '1', '1', '1', '', '2020-04-03 16:16:51', '', '2022-05-19 12:30:53', 'A', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_section_permission`
--
ALTER TABLE `2fa_section_permission`
  ADD PRIMARY KEY (`section`,`admingroup_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
