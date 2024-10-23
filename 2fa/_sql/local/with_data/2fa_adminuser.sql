-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 23, 2024 at 10:45 AM
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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'IRNAESP7XE3YEFXB', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=otpauth%3A%2F%2Ftotp%2Fwww.mreferral.com%3AMreferral%202FA%3Fsecret%3DIRNAESP7XE3YEFXB%26issuer%3Dwww.mreferral.com&ecc=M', 'N', 'administrator', '', 'CMS administrator', 1, '2024-10-23 15:14:47', 129, 'admin', '2022-04-01 00:00:00', 'admin', '2024-08-15 15:54:17', 'A', 'N'),
(2, 'user01', 'e38dc741a9ce83d561a6a511b94778f6', NULL, '5RBTF3GMLOK2NF3V', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&amp;data=otpauth://totp/www.mreferral.com:Mreferral 2FA?secret=5RBTF3GMLOK2NF3V&amp;issuer=www.mreferral.com&amp;ecc=M', 'N', 'user o1', '', '', 1, '2024-08-15 18:08:17', 1, 'admin', '2024-08-15 17:10:32', 'admin', '2024-08-15 19:21:49', 'A', 'N'),
(3, 'editor01', 'e38dc741a9ce83d561a6a511b94778f6', NULL, 'TUN6BG7WY6KQIAVG', 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&amp;data=otpauth://totp/www.mreferral.com:Mreferral 2FA?secret=TUN6BG7WY6KQIAVG&amp;issuer=www.mreferral.com&amp;ecc=M', 'N', 'editor 01', '', '', 2, '2024-08-15 18:50:19', 6, 'user01', '2024-08-15 18:09:59', 'admin', '2024-08-15 19:21:56', 'A', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2fa_adminuser`
--
ALTER TABLE `2fa_adminuser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `2fa_adminuser`
--
ALTER TABLE `2fa_adminuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
