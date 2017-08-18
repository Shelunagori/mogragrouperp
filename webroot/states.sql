-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2017 at 02:21 PM
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
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `state_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `state_code`) VALUES
(1, 'JAMMU AND KASHMIR', 1),
(2, 'HIMACHAL PRADESH', 2),
(3, 'PUNJAB', 3),
(4, 'CHANDIGARH', 4),
(5, 'UTTARAKHAND', 5),
(6, 'HARYANA', 6),
(7, 'DELHI', 7),
(8, 'RAJASTHAN', 8),
(9, 'UTTAR  PRADESH', 9),
(10, 'BIHAR', 10),
(11, 'SIKKIM', 11),
(12, 'ARUNACHAL PRADESH', 12),
(13, 'NAGALAND', 13),
(14, 'MANIPUR', 14),
(15, 'MIZORAM', 15),
(16, 'TRIPURA', 16),
(17, 'MEGHLAYA', 17),
(18, 'ASSAM', 18),
(19, 'WEST BENGAL', 19),
(20, 'JHARKHAND', 20),
(21, 'ODISHA', 21),
(22, 'CHATTISGARH', 22),
(23, 'MADHYA PRADESH', 23),
(24, 'GUJARAT', 24),
(25, 'DAMAN AND DIU', 25),
(26, 'DADRA AND NAGAR HAVELI', 26),
(27, 'MAHARASHTRA', 27),
(28, 'ANDHRA PRADESH(BEFORE DIVISION)', 28),
(29, 'KARNATAKA', 29),
(30, 'GOA', 30),
(31, 'LAKSHWADEEP', 31),
(32, 'KERALA', 32),
(33, 'TAMIL NADU', 33),
(34, 'PUDUCHERRY', 34),
(35, 'ANDAMAN AND NICOBAR ISLANDS', 35),
(36, 'TELANGANA', 36),
(37, 'ANDHRA PRADESH (NEW)', 37);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
