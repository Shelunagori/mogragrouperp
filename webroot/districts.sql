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
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `district` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `state_id`, `district`) VALUES
(1, 8, 'Udaipur'),
(2, 8, 'Chittorgarh'),
(3, 8, 'Beawer'),
(4, 8, 'Rajsamand'),
(5, 8, 'Bhilwara'),
(6, 8, 'Nimbahera'),
(7, 8, 'Sirohi'),
(8, 24, 'Ahmedabad'),
(9, 22, 'Raipur'),
(10, 23, 'Dhar'),
(11, 8, 'Bikaner'),
(12, 8, 'Barmer'),
(13, 8, 'Kota'),
(14, 8, 'Jaipur'),
(15, 8, 'Jodhpur'),
(16, 8, 'Pali'),
(17, 8, 'Banswara'),
(18, 8, 'Ajmer'),
(19, 8, 'Baran'),
(20, 8, 'Bharatpur'),
(21, 8, 'Bundi'),
(22, 8, 'Churu'),
(23, 8, 'Dausa'),
(24, 8, 'Dholpur'),
(25, 8, 'Dungarpur'),
(26, 8, 'Ganganagar'),
(27, 8, 'Hanumangarh'),
(28, 8, 'Jaisalmer'),
(29, 8, 'Jalor'),
(30, 8, 'Jhalawar'),
(31, 8, 'Jhujhunu'),
(32, 8, 'Karauli'),
(33, 8, 'Nagaur'),
(34, 8, 'Sawai Madhopur'),
(35, 8, 'Sikar'),
(36, 8, 'Tonk'),
(37, 5, 'Haridwar'),
(38, 24, 'Kutch'),
(39, 3, 'Bathinda'),
(40, 27, 'Chandrapur'),
(41, 6, 'Panipat'),
(42, 8, 'Alwar'),
(43, 27, 'Mumbai'),
(44, 6, 'Rewari'),
(45, 7, 'Delhi'),
(46, 9, 'Kanpur'),
(47, 23, 'Bhopal'),
(48, 23, 'Morena'),
(49, 3, 'Hoshiarpur'),
(50, 19, 'Kolkata'),
(51, 29, 'BANGALURU'),
(52, 10, 'Aurangabad'),
(53, 23, 'Neemuch'),
(54, 9, 'Bulandshahr'),
(55, 23, 'Sagar'),
(56, 29, 'Bellary');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
