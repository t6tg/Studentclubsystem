-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2019 at 01:43 PM
-- Server version: 5.6.38
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thanawat_cnrclub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` blob NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `status`) VALUES
(1, 'admin', 0x4a616d65733135313237, 'ธนวัฒน์ กุลาตี', 'admin'),
(2, 'chinorot', 0x6368696e6f726f74636c756232303139, 'ผู้ดูแลระบบ', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `clublist`
--

CREATE TABLE `clublist` (
  `id` int(11) NOT NULL,
  `club_id` varchar(100) NOT NULL,
  `club_name` varchar(100) NOT NULL,
  `club_tc` varchar(100) NOT NULL,
  `club_class` varchar(100) NOT NULL,
  `count_in` varchar(100) NOT NULL DEFAULT '0',
  `count_all` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clublist`
--

INSERT INTO `clublist` (`id`, `club_id`, `club_name`, `club_tc`, `club_class`, `count_in`, `count_all`) VALUES
(1, 'ว31129', 'วิทยาศาสตร์', 'เด็ดดวง อรทัย', '515', '0', '40'),
(3, 'ค323332', 'คณิตคิดหนัก', 'ดวงจันทร์ วันเพ็ญ', '426', '0', '30');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `num` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `room` varchar(100) NOT NULL,
  `club_value` varchar(100) NOT NULL,
  `u_status` varchar(100) NOT NULL DEFAULT 'user',
  `count` int(11) NOT NULL DEFAULT '1',
  `stamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `name`, `num`, `class`, `room`, `club_value`, `u_status`, `count`, `stamp`) VALUES
(1, '47471', '1102003199061', 'ธนวัฒน์ กุลาตี', '4', '6', '2', '', 'user', 1, ''),
(2, '44444', '1234567890000', 'ทดสอบ เว็บไซต์', '1', '6', '2', '', 'user', 1, ''),
(3, '47474', '1111111111111', 'ทดสอบ2 เว็บไซต์', '5', '6', '2', '', 'user', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `on_time` date NOT NULL,
  `off_time` date NOT NULL,
  `notice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`id`, `on_time`, `off_time`, `notice`) VALUES
(1, '2019-06-01', '2019-06-07', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clublist`
--
ALTER TABLE `clublist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clublist`
--
ALTER TABLE `clublist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
