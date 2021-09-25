-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 10:47 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advids_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientdetails`
--

CREATE TABLE `clientdetails` (
  `id` int(11) NOT NULL,
  `personName` varchar(50) NOT NULL,
  `companyName` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `mobileNo` varchar(13) NOT NULL,
  `phoneNo` varchar(13) NOT NULL,
  `skype` varchar(30) NOT NULL,
  `timezone` varchar(50) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clientdetails`
--

INSERT INTO `clientdetails` (`id`, `personName`, `companyName`, `designation`, `mobileNo`, `phoneNo`, `skype`, `timezone`, `createdBy`, `createdOn`) VALUES
(1, '0', 2, 'aaa', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 12:59:36'),
(2, '0', 1, 'bbb', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 13:00:20'),
(3, '12', 2, 'bbb', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 13:01:44'),
(4, 'abc', 1, 'bbb', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 13:03:31'),
(5, 'hsdfsd', 2, 'sfc', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 15:06:22'),
(6, 'popo', 3, 'popo', '7387981658', '7387981658', 'abc12', '12gs', 1, '2020-10-05 15:12:52'),
(7, 'abc', 0, 'ceo', '1231231231', '1231231234', 'sdf3', 'sadszcxc', 2, '2020-10-06 16:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `loginlogs`
--

CREATE TABLE `loginlogs` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `uniqueKey` varchar(50) NOT NULL,
  `loginTime` datetime NOT NULL,
  `logoutTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loginlogs`
--

INSERT INTO `loginlogs` (`id`, `userId`, `uniqueKey`, `loginTime`, `logoutTime`) VALUES
(3, 3, 'P_6b2f05a2a4_16', '2020-09-30 16:04:12', '2020-09-30 16:10:58'),
(4, 1, 'P_6fc2168ca22ba69d05897aea44210732_12', '2020-10-21 12:37:38', '2020-10-09 14:03:38'),
(5, 2, 'P_28b96fe622_15', '2020-10-07 15:53:10', '2020-10-06 15:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `moduleName` varchar(20) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `moduleName`, `createdBy`, `createdOn`) VALUES
(1, 'abc', 1, '2020-10-07 09:58:03'),
(2, 'seeta', 1, '2020-10-07 09:58:26'),
(3, 'bbb', 1, '2020-10-07 09:58:33'),
(6, 'testtwo', 1, '2020-10-07 10:21:57'),
(7, 'sandhya', 1, '2020-10-09 12:45:32'),
(8, 'qqqqqqqqqqq', 1, '2020-10-09 13:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `organizationName` varchar(50) NOT NULL,
  `website` varchar(70) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `organizationName`, `website`, `createdBy`, `createdOn`) VALUES
(1, 'abc', 'http://www.abc.com', 0, '0000-00-00 00:00:00'),
(2, 'pqr', 'http://www.pqr.com', 0, '0000-00-00 00:00:00'),
(3, 'xyz', 'http://www.abc.com', 0, '0000-00-00 00:00:00'),
(4, 'aaa', 'bbb', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `projectName` varchar(50) NOT NULL,
  `videoType` int(5) NOT NULL,
  `videoDuration` int(11) NOT NULL,
  `projectStartDate` datetime DEFAULT NULL,
  `projectStartLater` int(11) NOT NULL,
  `videoDurationUnit` varchar(50) DEFAULT NULL,
  `expectedDelivery` int(11) NOT NULL,
  `expectedDeliveryDate` datetime DEFAULT NULL,
  `projectAge` int(11) DEFAULT NULL,
  `projectStage` int(11) NOT NULL,
  `projectLead` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `projectEndDate` datetime DEFAULT NULL,
  `createBy` int(11) NOT NULL,
  `createOn` datetime NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `projectName`, `videoType`, `videoDuration`, `projectStartDate`, `projectStartLater`, `videoDurationUnit`, `expectedDelivery`, `expectedDeliveryDate`, `projectAge`, `projectStage`, `projectLead`, `clientId`, `projectEndDate`, `createBy`, `createOn`, `status`) VALUES
(1, 'abc', 12, 12, '2012-02-23 00:00:00', 201, '12', 10, '2012-12-02 00:00:00', 122, 2012, 122, 122, '2012-02-12 00:00:00', 1, '2020-10-13 11:58:07', 1),
(3, 'pradnya', 2, 12, '0000-00-00 00:00:00', 12, '', 12, '0000-00-00 00:00:00', 12, 0, 12, 12, '0000-00-00 00:00:00', 1, '2020-10-13 12:08:14', 1),
(4, '2', 0, 12, '2019-09-19 00:00:00', 232, '', 10, '2019-09-19 00:00:00', 12, 0, 22, 33, '0000-00-00 00:00:00', 1, '2020-10-13 12:08:25', 1),
(5, 'pqrs', 33, 33, '2019-07-22 00:00:00', 33, '', 33, '0000-00-00 00:00:00', 33, 33, 33, 33, '2001-08-03 00:00:00', 1, '2020-10-14 12:29:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projectlivestatus`
--

CREATE TABLE `projectlivestatus` (
  `id` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `workProgress` int(11) NOT NULL,
  `liveStatus` varchar(200) NOT NULL,
  `addedOn` datetime NOT NULL,
  `addedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projectlivestatus`
--

INSERT INTO `projectlivestatus` (`id`, `projectId`, `moduleId`, `workProgress`, `liveStatus`, `addedOn`, `addedBy`) VALUES
(1, 1, 3, 23, 'ok', '2020-10-05 14:42:22', 1),
(2, 1, 3, 23, 'ok', '2020-10-05 14:42:57', 1),
(3, 23, 11, 2, 'ssdsd', '2020-10-06 16:00:42', 2),
(4, 22, 22, 22, 'ok', '2020-10-14 17:36:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `projectId` varchar(50) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `projectId`, `createdBy`, `createdOn`) VALUES
(1, '10', 1, '2020-10-10 14:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `teammember`
--

CREATE TABLE `teammember` (
  `id` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstName` varchar(15) NOT NULL,
  `lastName` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `userType` int(11) NOT NULL,
  `token` varchar(300) DEFAULT NULL,
  `userStatus` int(11) NOT NULL,
  `invitedBy` int(11) DEFAULT 0,
  `invitedOn` datetime DEFAULT NULL,
  `emailVerified` int(11) DEFAULT 0,
  `emailVerifiedOn` datetime DEFAULT NULL,
  `addedBy` int(11) NOT NULL,
  `addedOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `firstName`, `lastName`, `email`, `userType`, `token`, `userStatus`, `invitedBy`, `invitedOn`, `emailVerified`, `emailVerifiedOn`, `addedBy`, `addedOn`) VALUES
(1, 'Harshal', 'a07dca9ac23e33993fe029f4ca6c0746', 'Harshal', 'Patil', 'harshal@gmail.com', 1, NULL, 1, 1, '2020-09-28 12:11:49', 1, '2020-09-28 12:09:41', 1, '2020-09-28 12:04:20'),
(2, 'hari', 'a07dca9ac23e33993fe029f4ca6c0746', 'hari', 'kumbhar', 'hari@gmail.com', 2, NULL, 1, 1, '2020-09-28 12:11:54', 1, '2020-09-28 12:09:48', 1, '2020-09-28 12:06:22'),
(3, 'pradnya', 'a07dca9ac23e33993fe029f4ca6c0746', 'pradnya', 'ahire', 'prad@gmail.com', 3, NULL, 1, 1, '2020-09-28 12:10:01', 1, '2020-09-28 12:10:01', 1, '2020-09-28 12:10:55'),
(59, 'nik', '262201fe2fcb9ee8216cdccb04a85584', 'aaa', 'bbb', 'pradnyaahire4@gmail.com', 3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.W10.-xaNB_MuSNXyrN3bij7DA8bhFaqNkK63x9eB3hGGJaE5f882e939e6ea', 1, 1, '2020-10-15 16:32:18', 1, '2020-10-15 16:42:19', 1, '2020-10-15 16:32:18'),
(60, 'sandhya', 'a07dca9ac23e33993fe029f4ca6c0746', 'aaa', 'bbb', 'pradnya.a@advids2.com', 3, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.W10.-xaNB_MuSNXyrN3bij7DA8bhFaqNkK63x9eB3hGGJaE5f8a7c7a982e8', 1, 1, '2020-10-17 10:35:26', 1, '2020-10-17 10:39:14', 1, '2020-10-17 10:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` int(11) NOT NULL,
  `value` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `value`) VALUES
(1, 'Creator'),
(2, 'Producer'),
(3, 'Director'),
(4, 'Client'),
(5, 'pqr'),
(6, 'marketing'),
(7, 'MD'),
(8, 'account');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientdetails`
--
ALTER TABLE `clientdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginlogs`
--
ALTER TABLE `loginlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectlivestatus`
--
ALTER TABLE `projectlivestatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teammember`
--
ALTER TABLE `teammember`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientdetails`
--
ALTER TABLE `clientdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loginlogs`
--
ALTER TABLE `loginlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projectlivestatus`
--
ALTER TABLE `projectlivestatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teammember`
--
ALTER TABLE `teammember`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
