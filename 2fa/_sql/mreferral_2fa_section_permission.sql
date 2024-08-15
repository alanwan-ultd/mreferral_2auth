-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 15, 2024 at 05:34 AM
-- Server version: 5.7.44
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
('admin', 2, '0', '0', '0', 'admin', '2021-08-30 13:33:17', '', '2021-08-30 13:33:17', 'A', 'N'),
('admin', 3, '0', '0', '0', 'admin', '2021-07-12 11:46:50', '', '2021-08-30 13:33:06', 'A', 'N'),
('admin', 4, '0', '0', '0', 'admin', '2021-07-12 11:51:07', '', '2022-05-23 10:25:42', 'A', 'N'),
('admin', 5, '0', '0', '0', 'admin', '2021-07-12 11:51:27', '', '2022-07-04 11:32:09', 'A', 'N'),
('admin', 6, '0', '0', '0', 'admin', '2021-07-12 11:53:14', '', '2021-08-09 12:20:59', 'A', 'N'),
('adminGroup', 1, '1', '1', '1', '', '2020-04-03 16:16:51', '', '2022-05-19 12:30:53', 'A', 'N'),
('adminGroup', 2, '0', '0', '0', 'admin', '2021-08-30 13:33:17', '', '2021-08-30 13:33:17', 'A', 'N'),
('adminGroup', 3, '0', '0', '0', 'admin', '2021-07-12 11:46:50', '', '2021-08-30 13:33:06', 'A', 'N'),
('adminGroup', 4, '0', '0', '0', 'admin', '2021-07-12 11:51:07', '', '2022-05-23 10:25:42', 'A', 'N'),
('adminGroup', 5, '0', '0', '0', 'admin', '2021-07-12 11:51:28', '', '2022-07-04 11:32:09', 'A', 'N'),
('adminGroup', 6, '0', '0', '0', 'admin', '2021-07-12 11:53:14', '', '2021-08-09 12:20:59', 'A', 'N'),
('mortgageCase', 1, '1', '1', '1', 'admin', '2021-07-12 17:42:08', '', '2021-07-13 19:20:25', 'A', 'N'),
('submitApproval', 1, '1', '1', '1', 'admin', '2021-07-12 11:24:46', '', '2021-08-06 19:24:37', 'A', 'N'),
('submitApproval', 3, '0', '0', '0', 'admin', '2021-07-12 11:46:49', '', '2021-07-12 11:48:13', 'A', 'N'),
('submitApproval', 4, '0', '0', '0', 'admin', '2021-07-12 11:51:07', '', '2021-07-12 11:51:07', 'A', 'N'),
('submitApproval', 5, '0', '0', '0', 'admin', '2021-07-12 11:51:27', '', '2021-07-12 11:52:37', 'A', 'N'),
('submitApproval', 6, '0', '0', '0', 'admin', '2021-07-12 11:53:14', '', '2021-08-09 12:20:59', 'A', 'N');

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
