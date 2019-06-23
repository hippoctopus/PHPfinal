-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.2
-- Generation Time: Jun 11, 2019 at 04:36 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trickortrip`
--

-- --------------------------------------------------------

--
-- Table structure for table `Member`
--

CREATE TABLE `Member` (
  `Uid` int(11) NOT NULL,
  `User_account` varchar(99) CHARACTER SET latin1 NOT NULL,
  `User_password` varchar(99) CHARACTER SET latin1 NOT NULL,
  `User_age` int(11) NOT NULL,
  `Is_admin` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Member`
--

INSERT INTO `Member` (`Uid`, `User_account`, `User_password`, `User_age`, `Is_admin`) VALUES
(1, 'admin', 'trickortrip', 25, 1),
(2, 'user', 'user123', 18, 0),
(3, 'test', 'test123', 44, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Place`
--

CREATE TABLE `Place` (
  `pid` int(11) NOT NULL,
  `name` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` time NOT NULL,
  `sid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Place`
--

INSERT INTO `Place` (`pid`, `name`, `time`, `sid`, `uid`) VALUES
(6, '學院餐車', '02:00:00', 2, 3),
(7, '管院', '23:59:00', 2, 3),
(10, '怡東農園', '09:00:00', 6, 2),
(11, '南瀛天文館', '11:05:00', 7, 3),
(12, '怡東農園', '12:00:00', 7, 3),
(13, '怡東農園', '11:00:00', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Schedule`
--

CREATE TABLE `Schedule` (
  `sid` int(11) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int(11) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Schedule`
--

INSERT INTO `Schedule` (`sid`, `date`, `name`, `uid`, `is_private`) VALUES
(2, '2019-06-03', 'test', 3, 0),
(6, '2019-06-12', '快樂出遊', 2, 0),
(7, '2019-06-10', '與阿玫出遊', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Member`
--
ALTER TABLE `Member`
  ADD PRIMARY KEY (`Uid`),
  ADD UNIQUE KEY `User_account` (`User_account`);

--
-- Indexes for table `Place`
--
ALTER TABLE `Place`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `Schedule`
--
ALTER TABLE `Schedule`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Member`
--
ALTER TABLE `Member`
  MODIFY `Uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Place`
--
ALTER TABLE `Place`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Schedule`
--
ALTER TABLE `Schedule`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
