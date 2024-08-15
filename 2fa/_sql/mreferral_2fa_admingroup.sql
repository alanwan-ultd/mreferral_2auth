
-- --------------------------------------------------------

--
-- Table structure for table `2fa_admingroup`
--

DROP TABLE IF EXISTS `2fa_admingroup`;
CREATE TABLE `2fa_admingroup` (
  `id` int NOT NULL,
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

INSERT INTO `2fa_admingroup` (`id`, `title`, `description`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
(1, 'Admin', 'Administrator - Most powerful user.', 'admin', '2022-04-01 00:00:00', 'admin', '2023-03-01 19:24:56', 'A', 'N');
