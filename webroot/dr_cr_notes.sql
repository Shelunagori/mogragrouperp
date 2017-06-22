-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2017 at 11:06 AM
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
-- Table structure for table `credit_notes`
--

CREATE TABLE `credit_notes` (
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
-- Dumping data for table `credit_notes`
--

INSERT INTO `credit_notes` (`id`, `voucher_no`, `created_on`, `transaction_date`, `customer_suppiler_id`, `company_id`, `created_by`, `edited_by`, `edited_on`, `subject`) VALUES
(1, '23', '2017-05-27', '2017-05-27', 23, 25, 16, 0, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes_rows`
--

CREATE TABLE `credit_notes_rows` (
  `id` int(10) NOT NULL,
  `credit_note_id` int(10) NOT NULL,
  `head_id` int(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `narration` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_notes_rows`
--

INSERT INTO `credit_notes_rows` (`id`, `credit_note_id`, `head_id`, `amount`, `narration`) VALUES
(85, 1, 25, '100.00', '1'),
(86, 1, 27, '500.00', '2'),
(87, 1, 28, '100.00', '3'),
(88, 1, 47, '300.00', '4');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes_rows`
--
ALTER TABLE `credit_notes_rows`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `credit_notes_rows`
--
ALTER TABLE `credit_notes_rows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `debit_notes`
--
ALTER TABLE `debit_notes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `debit_notes_rows`
--
ALTER TABLE `debit_notes_rows`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
