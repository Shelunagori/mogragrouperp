-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2017 at 03:10 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shilpa_treding_52917`
--

-- --------------------------------------------------------

--
-- Table structure for table `vouchers_references`
--

CREATE TABLE `vouchers_references` (
  `id` int(10) NOT NULL,
  `voucher_entity` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `company_id` int(10) NOT NULL,
  `module` varchar(255) NOT NULL,
  `sub_entity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers_references`
--

INSERT INTO `vouchers_references` (`id`, `voucher_entity`, `description`, `company_id`, `module`, `sub_entity`) VALUES
(1, 'PaymentVoucher -> Paid To', 'payment ', 25, 'Payment Voucher', 'Paid To'),
(2, 'PaymentVoucher -> Cash/Bank', 'payment', 25, 'Payment Voucher', 'Cash/Bank'),
(3, 'Receipt Voucher -> Received From', 'receipt voucher ', 25, 'Receipt Voucher', 'Received From'),
(4, 'Receipt Voucher -> Cash/Bank', 'bnvnb', 25, 'Receipt Voucher', 'Cash/Bank'),
(5, 'Petty Cash Payment -> Received From', 'bnvnb', 25, 'Petty Cash Payment', 'Paid To'),
(6, 'Petty Cash Payment -> Cash/Bank', 'bnvnb', 25, 'Petty Cash Payment', 'Cash/Bank'),
(7, 'Contra Voucher -> Paid To', 'bnvnb', 25, 'Contra Voucher', 'Paid To'),
(8, 'Contra Voucher -> Cash/Bank', 'bnvnb', 25, 'Contra Voucher', 'Cash/Bank'),
(9, 'Journal Voucher -> Ledger', 'bnvnb', 25, 'Journal Voucher', 'Ledger'),
(10, 'Debit Notes -> Sales Account', 'bnvnb', 25, 'Debit Notes', 'Customer-Suppiler'),
(11, 'Debit Notes -> Party', 'bnvnb', 25, 'Debit Notes', 'Heads'),
(12, 'Credit Notes -> Purchase Account', 'bnvnb', 25, 'Credit Notes', 'Purchase Account'),
(13, 'Credit Notes -> Party', 'bnvnb', 25, 'Credit Notes', 'Party'),
(14, 'PaymentVoucher -> Paid To', 'payment ', 26, 'Payment Voucher', 'Paid To'),
(15, 'PaymentVoucher -> Cash/Bank', 'payment', 26, 'Payment Voucher', 'Cash/Bank'),
(16, 'Receipt Voucher -> Received From', 'receipt voucher ', 26, 'Receipt Voucher', 'Received From'),
(17, 'Receipt Voucher -> Cash/Bank', 'bnvnb', 26, 'Receipt Voucher', 'Cash/Bank'),
(18, 'Petty Cash Payment -> Received From', 'bnvnb', 26, 'Petty Cash Payment', 'Paid To'),
(19, 'Petty Cash Payment -> Cash/Bank', 'bnvnb', 26, 'Petty Cash Payment', 'Cash/Bank'),
(20, 'Contra Voucher -> Paid To', 'bnvnb', 26, 'Contra Voucher', 'Paid To'),
(21, 'Contra Voucher -> Cash/Bank', 'bnvnb', 26, 'Contra Voucher', 'Cash/Bank'),
(22, 'Journal Voucher -> Ledger', 'bnvnb', 26, 'Journal Voucher', 'Ledger'),
(23, 'Debit Notes -> Sales Account', 'bnvnb', 26, 'Debit Notes', 'Sales Account'),
(24, 'Debit Notes -> Party', 'bnvnb', 26, 'Debit Notes', 'Party'),
(25, 'Credit Notes -> Purchase Account', 'bnvnb', 26, 'Credit Notes', 'Purchase Account'),
(26, 'Credit Notes -> Party', 'bnvnb', 26, 'Credit Notes', 'Party'),
(27, 'PaymentVoucher -> Paid To', 'payment ', 27, 'Payment Voucher', 'Paid To'),
(28, 'PaymentVoucher -> Cash/Bank', 'payment', 27, 'Payment Voucher', 'Cash/Bank'),
(29, 'Receipt Voucher -> Received From', 'receipt voucher ', 27, 'Receipt Voucher', 'Received From'),
(30, 'Receipt Voucher -> Cash/Bank', 'Receipt', 27, 'Receipt Voucher', 'Cash/Bank'),
(31, 'Petty Cash Payment -> Received From', 'bnvnb', 27, 'Petty Cash Payment', 'Paid To'),
(32, 'Petty Cash Payment -> Cash/Bank', 'bnvnb', 27, 'Petty Cash Payment', 'Cash/Bank'),
(33, 'Contra Voucher -> Paid To', 'bnvnb', 27, 'Contra Voucher', 'Paid To'),
(34, 'Contra Voucher -> Cash/Bank', 'bnvnb', 27, 'Contra Voucher', 'Cash/Bank'),
(35, 'Journal Voucher -> Ledger', 'bnvnb', 27, 'Journal Voucher', 'Ledger'),
(36, 'Debit Notes -> Sales Account', 'bnvnb', 27, 'Debit Notes', 'Sales Account'),
(37, 'Debit Notes -> Party', 'bnvnb', 27, 'Debit Notes', 'Party'),
(38, 'Credit Notes -> Purchase Account', 'bnvnb', 27, 'Credit Notes', 'Purchase Account'),
(39, 'Credit Notes -> Party', 'bnvnb', 27, 'Credit Notes', 'Party'),
(40, 'Bank Reconciliation Add -> Bank', 'bnvnb', 25, 'Bank Reconciliation Add', 'Bank'),
(41, 'Bank Reconciliation Add -> Bank', 'bnvnb', 26, 'Bank Reconciliation Add', 'Bank'),
(42, 'Bank Reconciliation Add -> Bank', 'bnvnb', 27, 'Bank Reconciliation Add', 'Bank');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vouchers_references`
--
ALTER TABLE `vouchers_references`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vouchers_references`
--
ALTER TABLE `vouchers_references`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
