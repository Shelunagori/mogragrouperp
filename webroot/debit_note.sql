-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2017 at 08:51 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
-- Table structure for table `debit_notes`
--

CREATE TABLE `debit_notes` (
  `id` int(10) NOT NULL,
  `voucher_no` varchar(10) NOT NULL,
  `created_on` date NOT NULL,
  `transaction_date` date NOT NULL,
  `customer_suppiler_id` int(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `edited_by` int(10) NOT NULL,
  `edited_on` date NOT NULL,
  `subject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debit_notes`
--

INSERT INTO `debit_notes` (`id`, `voucher_no`, `created_on`, `transaction_date`, `customer_suppiler_id`, `company_id`, `created_by`, `edited_by`, `edited_on`, `subject`) VALUES
(8, '1', '2017-05-23', '2017-05-23', 23, 25, 16, 0, '0000-00-00', ''),
(9, '2', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(10, '3', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(11, '4', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(12, '5', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(13, '6', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(14, '7', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(15, '8', '2017-05-24', '2017-05-24', 23, 25, 16, 0, '0000-00-00', ''),
(16, '9', '2017-05-25', '2017-05-25', 0, 25, 16, 0, '0000-00-00', ''),
(17, '10', '2017-05-25', '2017-05-25', 23, 25, 16, 0, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `debit_notes_rows`
--

CREATE TABLE `debit_notes_rows` (
  `id` int(10) NOT NULL,
  `debit_note_id` int(10) NOT NULL,
  `head_id` int(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `narration` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debit_notes_rows`
--

INSERT INTO `debit_notes_rows` (`id`, `debit_note_id`, `head_id`, `amount`, `narration`) VALUES
(12, 8, 22, '5.00', 'GG'),
(13, 8, 22, '7.00', 'HGH'),
(14, 9, 22, '111.00', 'wdwsdsdsdsd'),
(15, 10, 22, '111.00', 'wdwsdsdsdsd'),
(16, 11, 22, '111.00', 'wdwsdsdsdsd'),
(17, 12, 23, '100.00', 'dsadas'),
(18, 12, 25, '200.00', 'ssafadsf'),
(19, 13, 23, '100.00', 'dsadas'),
(20, 13, 25, '200.00', 'ssafadsf'),
(21, 14, 23, '100.00', 'dsadas'),
(22, 14, 25, '200.00', 'ssafadsf'),
(23, 15, 22, '100.00', '1sdasdasd'),
(24, 15, 25, '111.00', 'sdfasd'),
(25, 17, 22, '123.00', 'dfds'),
(26, 17, 25, '123.00', 'dfdsf'),
(27, 17, 28, '123.00', 'defdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `debit_notes`
--
ALTER TABLE `debit_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_notes_rows`
--
ALTER TABLE `debit_notes_rows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `debit_notes`
--
ALTER TABLE `debit_notes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `debit_notes_rows`
--
ALTER TABLE `debit_notes_rows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
