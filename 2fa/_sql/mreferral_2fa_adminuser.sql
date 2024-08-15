
-- --------------------------------------------------------

--
-- Table structure for table `2fa_adminuser`
--

DROP TABLE IF EXISTS `2fa_adminuser`;
CREATE TABLE `2fa_adminuser` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `groupId` int NOT NULL,
  `lastLoginDateTime` datetime NOT NULL,
  `noOfLogin` int NOT NULL DEFAULT '0',
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

INSERT INTO `2fa_adminuser` (`id`, `login`, `password`, `name`, `email`, `description`, `groupId`, `lastLoginDateTime`, `noOfLogin`, `createBy`, `createDateTime`, `lastModifyBy`, `lastModifyDateTime`, `status`, `deleted`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrator', NULL, 'CMS administrator', 1, '2023-03-02 13:55:34', 112, 'admin', '2022-04-01 00:00:00', 'admin', '2022-04-01 00:00:00', 'A', 'N');
