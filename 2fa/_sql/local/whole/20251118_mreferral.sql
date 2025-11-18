-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 18, 2025 at 10:07 AM
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
(1, 1, 'Admin', 'Administrator - Most powerful user.', 'admin', '2022-04-01 00:00:00', 'admin', '2024-09-19 11:20:30', 'A', 'N'),
(2, NULL, 'editor', 'editor', 'user01', '2024-08-15 18:08:44', '', '2024-09-19 13:21:00', 'A', 'N'),
(3, NULL, 'sales', 'sales group', 'admin', '2024-09-13 18:16:40', '', '2024-09-19 13:20:50', 'A', 'N'),
(4, NULL, 'test group', 'testing', 'admin', '2024-11-08 10:47:10', '', '2024-11-08 10:47:10', 'A', 'N'),
(5, NULL, 'test', 'test', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `2fa_adminuser`
--

CREATE TABLE `2fa_adminuser` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'For users setting up their password for the first time',
  `2fa_secret` varchar(255) DEFAULT NULL,
  `2fa_qrcode` varchar(255) DEFAULT NULL,
  `2fa_receive_email` char(1) DEFAULT 'N',
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

INSERT INTO `2fa_adminuser` (`id`, `login`, `password`, `password_reset_token`, `2fa_secret`, `2fa_qrcode`, `2fa_receive_email`, `name`, `email`, `description`, `groupId`, `lastLoginDateTime`, `noOfLogin`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'IRNAESP7XE3YEFXB', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=otpauth%3A%2F%2Ftotp%2Fwww.mreferral.com%3AMreferral%202FA%3Fsecret%3DIRNAESP7XE3YEFXB%26issuer%3Dwww.mreferral.com&ecc=M', 'N', 'administrator', '', 'CMS administrator', 1, '2025-11-18 17:49:28', 133, 'admin', '2022-04-01 00:00:00', 'admin', '2024-08-15 15:54:17', 'A', 'N'),
(2, 'user01', 'e38dc741a9ce83d561a6a511b94778f6', NULL, '5RBTF3GMLOK2NF3V', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&amp;data=otpauth://totp/www.mreferral.com:Mreferral 2FA?secret=5RBTF3GMLOK2NF3V&amp;issuer=www.mreferral.com&amp;ecc=M', 'N', 'user o1', '', '', 1, '2024-08-15 18:08:17', 1, 'admin', '2024-08-15 17:10:32', 'admin', '2024-08-15 19:21:49', 'A', 'N'),
(3, 'editor01', 'e38dc741a9ce83d561a6a511b94778f6', NULL, 'TUN6BG7WY6KQIAVG', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&amp;data=otpauth://totp/www.mreferral.com:Mreferral 2FA?secret=TUN6BG7WY6KQIAVG&amp;issuer=www.mreferral.com&amp;ecc=M', 'N', 'editor 01', '', '', 2, '2024-08-15 18:50:19', 6, 'user01', '2024-08-15 18:09:59', 'admin', '2024-08-15 19:21:56', 'A', 'N'),
(4, 'test_cms', 'e38dc741a9ce83d561a6a511b94778f6', NULL, 'SIIIJ36RLBN2LVNE', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=otpauth%3A%2F%2Ftotp%2Fwww.mreferral.com%3AMreferral%202FA%3Fsecret%3DSIIIJ36RLBN2LVNE%26issuer%3Dwww.mreferral.com&ecc=M', 'N', 'test cms', 'test@test.com', '', 4, '1000-01-01 00:00:00', 0, 'admin', '2024-11-08 11:31:37', 'admin', '2024-11-08 11:31:37', 'A', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `2fa_commission_origin`
--

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
-- Dumping data for table `2fa_commission_origin`
--

INSERT INTO `2fa_commission_origin` (`id`, `staff_no`, `commission_data`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `deleted`) VALUES
(74, 'H2115681', '{\"type_code\":\"Private Completed Property\",\"application_code\":\"388785\",\"mreferral_staff_name\":\"Keith Tong\",\"tel_no\":\"31966510\",\"team_head\":\"Michael Mo\",\"team_head_phone_no\":\"31966654\",\"drawdown_date\":\"24\\/5\\/2024\",\"property_addr\":\"BAKER CIRCLDOVER,\",\"payment_date\":\"31\\/7\\/2024\",\"staff_no\":\"H2115681\",\"staff_name\":\"NULL\",\"staff_bank_acc\":\"NULL\",\"comm_to_pc\":\"HKD$ 1918.00\",\"department_head_id\":\"H0114540\",\"department_head_name\":\"CHU SAU MUI\",\"department_head_bank_account\":\"004-xxx-xxx7031\",\"commission_branch_mgr\":\"HKD$ 240.00\",\"branch\":\"SKR\"}', 'admin', '2024-12-05 11:35:35', 'admin', '2024-12-05 11:35:35', 'N'),
(75, 'H2115681', '{\"type_code\":\"Private Completed Property\",\"application_code\":\"388785\",\"mreferral_staff_name\":\"Keith Tong\",\"tel_no\":\"31966510\",\"team_head\":\"Michael Mo\",\"team_head_phone_no\":\"31966654\",\"drawdown_date\":\"24\\/5\\/2024\",\"property_addr\":\"BAKER CIRCLDOVER,\",\"payment_date\":\"31\\/7\\/2024\",\"staff_no\":\"H2115681\",\"staff_name\":\"NULL\",\"staff_bank_acc\":\"NULL\",\"comm_to_pc\":\"HKD$ 360.00\",\"department_head_id\":\"H0114540\",\"department_head_name\":\"CHU SAU MUI\",\"department_head_bank_account\":\"004-xxx-xxx7031\",\"commission_branch_mgr\":\"HKD$ 45.00\",\"branch\":\"SKR\"}', 'admin', '2024-12-05 11:35:35', 'admin', '2024-12-05 11:35:35', 'N'),
(76, 'H2103742', '{\"type_code\":\"Private Completed Property\",\"application_code\":\"394458\",\"mreferral_staff_name\":\"Duncan Yung\",\"tel_no\":\"31966649\",\"team_head\":\"Cissy Cheung\",\"team_head_phone_no\":\"31966651\",\"drawdown_date\":\"14\\/5\\/2024\",\"property_addr\":\"THE PAVILIA BAY,\",\"payment_date\":\"30\\/8\\/2024\",\"staff_no\":\"H2103742\",\"staff_name\":\"CHAN HEI CHUNG\",\"staff_bank_acc\":\"012-xxx-xxx8827\",\"comm_to_pc\":\"HKD$ 1194.00\",\"department_head_id\":\"H1208463\",\"department_head_name\":\"LAW MAN FAI\",\"department_head_bank_account\":\"004-xxx-xxx0695\",\"commission_branch_mgr\":\"HKD$ 149.00\",\"branch\":\"DYS\"}', 'admin', '2024-12-05 11:35:35', 'admin', '2024-12-05 11:35:35', 'N'),
(77, 'H2103742', '{\"type_code\":\"Private Completed Property\",\"application_code\":\"394458\",\"mreferral_staff_name\":\"Duncan Yung\",\"tel_no\":\"31966649\",\"team_head\":\"Cissy Cheung\",\"team_head_phone_no\":\"31966651\",\"drawdown_date\":\"14\\/5\\/2024\",\"property_addr\":\"THE PAVILIA BAY,\",\"payment_date\":\"31\\/7\\/2024\",\"staff_no\":\"H2103742\",\"staff_name\":\"CHAN HEI CHUNG\",\"staff_bank_acc\":\"012-xxx-xxx8827\",\"comm_to_pc\":\"HKD$ 11854.00\",\"department_head_id\":\"H1208463\",\"department_head_name\":\"LAW MAN FAI\",\"department_head_bank_account\":\"004-xxx-xxx0695\",\"commission_branch_mgr\":\"HKD$ 1482.00\",\"branch\":\"DYS\"}', 'admin', '2024-12-05 11:35:35', 'admin', '2024-12-05 11:35:35', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `2fa_section_permission`
--

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
('admin', 1, '1', '1', '1', '', '2020-04-03 16:16:51', '', '2024-09-19 11:20:30', 'A', 'N'),
('admin', 2, '0', '0', '0', 'user01', '2024-08-15 18:08:44', '', '2024-09-19 13:21:00', 'A', 'N'),
('admin', 3, '0', '0', '0', 'admin', '2024-09-13 18:16:40', '', '2024-09-19 13:20:50', 'A', 'N'),
('admin', 4, '0', '0', '0', 'admin', '2024-11-08 10:47:11', '', '2024-11-08 10:47:11', 'A', 'N'),
('admin', 5, '0', '0', '0', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N'),
('adminGroup', 1, '1', '1', '1', '', '2020-04-03 16:16:51', '', '2024-09-19 11:20:30', 'A', 'N'),
('adminGroup', 2, '0', '0', '0', 'user01', '2024-08-15 18:08:45', '', '2024-09-19 13:21:00', 'A', 'N'),
('adminGroup', 3, '0', '0', '0', 'admin', '2024-09-13 18:16:41', '', '2024-09-19 13:20:51', 'A', 'N'),
('adminGroup', 4, '0', '0', '0', 'admin', '2024-11-08 10:47:11', '', '2024-11-08 10:47:11', 'A', 'N'),
('adminGroup', 5, '0', '0', '0', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N'),
('commission', 1, '1', '1', '1', 'admin', '2024-09-19 11:20:30', '', '2024-09-19 11:20:30', 'A', 'N'),
('commission', 2, '1', '1', '1', 'admin', '2024-09-19 13:21:00', '', '2024-09-19 13:21:00', 'A', 'N'),
('commission', 3, '1', '1', '1', 'admin', '2024-09-19 13:20:50', '', '2024-09-19 13:20:50', 'A', 'N'),
('commission', 4, '0', '0', '0', 'admin', '2024-11-08 10:47:11', '', '2024-11-08 10:47:11', 'A', 'N'),
('commission', 5, '0', '0', '0', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N'),
('uploadCommissionCSV', 1, '1', '1', '1', 'admin', '2024-09-16 18:31:50', '', '2024-09-19 11:20:30', 'A', 'N'),
('uploadCommissionCSV', 2, '0', '0', '0', 'admin', '2024-09-19 13:21:00', '', '2024-09-19 13:21:00', 'A', 'N'),
('uploadCommissionCSV', 3, '0', '0', '0', 'admin', '2024-09-19 13:20:51', '', '2024-09-19 13:20:51', 'A', 'N'),
('uploadCommissionCSV', 4, '0', '0', '0', 'admin', '2024-11-08 10:47:11', '', '2024-11-08 10:47:11', 'A', 'N'),
('uploadCommissionCSV', 5, '0', '0', '0', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N'),
('uploadSalesCSV', 1, '1', '1', '1', 'admin', '2024-09-16 12:50:26', '', '2024-09-19 11:20:30', 'A', 'N'),
('uploadSalesCSV', 2, '0', '0', '0', 'admin', '2024-09-19 13:21:00', '', '2024-09-19 13:21:00', 'A', 'N'),
('uploadSalesCSV', 3, '0', '0', '0', 'admin', '2024-09-19 13:20:51', '', '2024-09-19 13:20:51', 'A', 'N'),
('uploadSalesCSV', 4, '0', '0', '0', 'admin', '2024-11-08 10:47:11', '', '2024-11-08 10:47:11', 'A', 'N'),
('uploadSalesCSV', 5, '0', '0', '0', 'admin', '2024-11-08 12:22:45', '', '2024-11-08 12:22:45', 'A', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_admingroup`
--
ALTER TABLE `2fa_admingroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `2fa_adminuser`
--
ALTER TABLE `2fa_adminuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `2fa_commission_origin`
--
ALTER TABLE `2fa_commission_origin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `2fa_section_permission`
--
ALTER TABLE `2fa_section_permission`
  ADD PRIMARY KEY (`section`,`admingroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `2fa_admingroup`
--
ALTER TABLE `2fa_admingroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `2fa_adminuser`
--
ALTER TABLE `2fa_adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `2fa_commission_origin`
--
ALTER TABLE `2fa_commission_origin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
