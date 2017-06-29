-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2017 at 11:17 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shilpa_treding`
--

-- --------------------------------------------------------

--
-- Table structure for table `left_rivs`
--

CREATE TABLE `left_rivs` (
  `id` int(10) NOT NULL,
  `riv_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `left_rivs`
--

INSERT INTO `left_rivs` (`id`, `riv_id`, `item_id`, `quantity`) VALUES
(3, 3, 903, 1),
(4, 4, 1208, 1),
(11, 5, 1208, 1),
(13, 6, 1482, 1);

-- --------------------------------------------------------

--
-- Table structure for table `right_rivs`
--

CREATE TABLE `right_rivs` (
  `id` int(10) NOT NULL,
  `left_riv_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `right_rivs`
--

INSERT INTO `right_rivs` (`id`, `left_riv_id`, `item_id`, `quantity`) VALUES
(11, 3, 665, 1),
(12, 3, 1050, 2),
(13, 3, 590, 1),
(14, 3, 863, 3),
(15, 3, 889, 4),
(16, 4, 605, 1),
(17, 4, 580, 1),
(18, 4, 863, 1),
(19, 4, 897, 1),
(20, 4, 888, 1),
(21, 4, 1048, 1),
(22, 4, 1024, 4),
(23, 4, 1031, 4),
(24, 4, 1036, 8),
(25, 4, 1017, 2),
(26, 4, 1029, 2),
(27, 4, 1034, 4),
(28, 4, 1021, 4),
(29, 4, 1030, 4),
(30, 4, 1035, 8),
(31, 5, 605, 1),
(32, 5, 580, 1),
(33, 5, 863, 1),
(34, 5, 897, 1),
(35, 5, 888, 1),
(36, 5, 1048, 1),
(37, 5, 1024, 4),
(38, 5, 1031, 4),
(39, 5, 1036, 8),
(40, 5, 1017, 2),
(41, 5, 1029, 2),
(42, 5, 1034, 4),
(43, 5, 1021, 4),
(44, 5, 1030, 4),
(45, 5, 1035, 8),
(46, 11, 605, 1),
(47, 11, 580, 1),
(48, 11, 863, 1),
(49, 11, 897, 1),
(50, 11, 888, 1),
(51, 11, 1048, 1),
(52, 11, 1024, 4),
(53, 11, 1031, 4),
(54, 11, 1036, 8),
(55, 11, 1017, 2),
(56, 11, 1029, 2),
(57, 11, 1034, 4),
(58, 11, 1021, 4),
(59, 11, 1030, 4),
(60, 11, 1035, 8),
(61, 12, 724, 1),
(62, 12, 1485, 1),
(63, 12, 863, 1),
(64, 12, 888, 1),
(65, 12, 897, 1),
(66, 12, 1048, 1),
(67, 12, 1024, 4),
(68, 12, 1031, 4),
(69, 12, 1036, 4),
(70, 12, 1021, 4),
(71, 12, 1020, 2),
(72, 12, 1030, 6),
(73, 12, 1035, 6),
(74, 12, 1017, 2),
(75, 12, 1029, 2),
(76, 12, 1034, 2),
(77, 12, 1392, 2),
(78, 13, 724, 1),
(79, 13, 1485, 1),
(80, 13, 863, 1),
(81, 13, 888, 1),
(82, 13, 897, 1),
(83, 13, 1048, 1),
(84, 13, 1024, 4),
(85, 13, 1031, 4),
(86, 13, 1036, 4),
(87, 13, 1021, 4),
(88, 13, 1020, 2),
(89, 13, 1030, 6),
(90, 13, 1035, 6),
(91, 13, 1017, 2),
(92, 13, 1029, 2),
(93, 13, 1034, 2),
(94, 13, 1392, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rivs`
--

CREATE TABLE `rivs` (
  `id` int(10) NOT NULL,
  `sale_return_id` int(10) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `created_on` date NOT NULL,
  `company_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rivs`
--

INSERT INTO `rivs` (`id`, `sale_return_id`, `voucher_no`, `created_on`, `company_id`) VALUES
(3, 6, 1, '2017-06-28', 25),
(4, 7, 2, '2017-06-28', 25),
(5, 7, 3, '2017-06-28', 25),
(6, 8, 4, '2017-06-28', 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `left_rivs`
--
ALTER TABLE `left_rivs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `right_rivs`
--
ALTER TABLE `right_rivs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rivs`
--
ALTER TABLE `rivs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `left_rivs`
--
ALTER TABLE `left_rivs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `right_rivs`
--
ALTER TABLE `right_rivs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `rivs`
--
ALTER TABLE `rivs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
