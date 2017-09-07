-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2017 at 02:57 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stl170817`
--

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` int(10) NOT NULL,
  `invoice_booking_id` int(10) NOT NULL,
  `created_on` date NOT NULL,
  `company_id` int(10) NOT NULL,
  `created_by` int(10) NOT NULL,
  `voucher_no` int(10) NOT NULL,
  `purchase_ledger_account` int(10) NOT NULL,
  `vendor_id` int(10) NOT NULL,
  `transaction_date` date NOT NULL,
  `total_cgst_amount` decimal(15,2) NOT NULL,
  `total_sgst_amount` decimal(15,2) NOT NULL,
  `total_igst_amount` decimal(15,2) NOT NULL,
  `total_taxable_value` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `due_payment` decimal(15,2) NOT NULL,
  `supplier_date` date NOT NULL,
  `cst_vat` varchar(25) NOT NULL,
  `gst_type` varchar(25) NOT NULL DEFAULT 'Non-Gst'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `invoice_booking_id`, `created_on`, `company_id`, `created_by`, `voucher_no`, `purchase_ledger_account`, `vendor_id`, `transaction_date`, `total_cgst_amount`, `total_sgst_amount`, `total_igst_amount`, `total_taxable_value`, `total`, `due_payment`, `supplier_date`, `cst_vat`, `gst_type`) VALUES
(1, 321, '2017-09-02', 25, 23, 1, 799, 5, '2017-09-01', '0.00', '0.00', '0.00', '0.00', '103660.00', '0.00', '0000-00-00', '', 'Gst'),
(2, 321, '2017-09-02', 25, 23, 2, 799, 5, '2017-09-01', '0.00', '0.00', '0.00', '0.00', '103660.00', '0.00', '0000-00-00', '', 'Gst'),
(3, 319, '2017-09-02', 25, 23, 3, 797, 5, '2017-09-02', '0.00', '0.00', '6480.00', '0.00', '42480.00', '0.00', '0000-00-00', '', 'Gst'),
(4, 320, '2017-09-02', 25, 23, 4, 799, 9, '2017-09-01', '2544.84', '2544.84', '0.00', '0.00', '23260.00', '0.00', '0000-00-00', '', 'Gst'),
(5, 312, '2017-09-02', 25, 23, 5, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(6, 312, '2017-09-02', 25, 23, 6, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(7, 312, '2017-09-02', 25, 23, 7, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(8, 312, '2017-09-02', 25, 23, 8, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(9, 312, '2017-09-02', 25, 23, 9, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(10, 312, '2017-09-02', 25, 23, 10, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(11, 312, '2017-09-02', 25, 23, 11, 799, 37, '2017-09-23', '102.80', '102.80', '0.00', '0.00', '1125.60', '0.00', '0000-00-00', '', 'Gst'),
(12, 259, '2017-09-02', 25, 23, 12, 797, 9, '2017-09-13', '0.00', '0.00', '1785.00', '0.00', '8160.00', '0.00', '0000-00-00', '', 'Gst'),
(13, 260, '2017-09-02', 25, 23, 13, 799, 19, '2017-09-06', '1205.82', '1205.82', '0.00', '0.00', '15810.00', '0.00', '0000-00-00', '', 'Gst'),
(14, 261, '2017-09-02', 25, 23, 14, 797, 1, '2017-09-08', '0.00', '0.00', '5142.85', '0.00', '33714.00', '0.00', '0000-00-00', '', 'Gst'),
(15, 261, '2017-09-02', 25, 23, 15, 797, 1, '2017-09-08', '0.00', '0.00', '5142.85', '0.00', '33714.00', '0.00', '0000-00-00', '', 'Gst'),
(16, 261, '2017-09-02', 25, 23, 17, 797, 1, '2017-09-08', '0.00', '0.00', '5142.85', '0.00', '33714.00', '0.00', '0000-00-00', '', 'Gst');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_rows`
--

CREATE TABLE `purchase_return_rows` (
  `id` int(11) NOT NULL,
  `purchase_return_id` int(10) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `vat_per_item` decimal(15,5) NOT NULL,
  `unit_rate_from_po` decimal(15,2) NOT NULL,
  `pnf_per` tinyint(4) NOT NULL,
  `pnf` decimal(15,2) NOT NULL,
  `rate` decimal(20,5) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `description` varchar(500) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `gst_discount_per` varchar(20) NOT NULL,
  `gst_pnf_per` varchar(20) NOT NULL,
  `cgst_per` varchar(20) NOT NULL,
  `cgst` decimal(15,2) NOT NULL,
  `sgst_per` varchar(20) NOT NULL,
  `sgst` decimal(15,2) NOT NULL,
  `igst_per` varchar(11) NOT NULL,
  `igst` decimal(15,2) NOT NULL,
  `taxable_value` decimal(15,2) NOT NULL,
  `discount` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_return_rows`
--

INSERT INTO `purchase_return_rows` (`id`, `purchase_return_id`, `item_id`, `quantity`, `vat_per_item`, `unit_rate_from_po`, `pnf_per`, `pnf`, `rate`, `amount`, `description`, `total`, `gst_discount_per`, `gst_pnf_per`, `cgst_per`, `cgst`, `sgst_per`, `sgst`, `igst_per`, `igst`, `taxable_value`, `discount`) VALUES
(1, 1, 665, 3, '0.00000', '26999.00', 0, '801.88', '26996.63333', '80998.0000', '<p>Model : NZRP 25 160 TBG V 1 J&nbsp;</p><p>Flow : 5 m3/hr&nbsp;</p><p>Head : 40 mtrs</p><p>Liquid : 33% HCL&nbsp;</p><p>Power : 5 HP / 2900 RPM (Remi Make )&nbsp;</p><p>Sealing : Mechanical Seal&nbsp;</p><p>Scope of supply :&nbsp;</p><p>Pump with base frame ,Coupling , Coupling guard, foundations and mounting bolts&nbsp;</p><p>NOTE : As per last supply vide invoice no. R/16-17/1037 date 17.09.2016&nbsp;</p>', '103660.00', '1', '1', '21', '11338.59', '22', '11338.59', '', '0.00', '80989.90', ''),
(2, 2, 665, 3, '0.00000', '26999.00', 0, '801.88', '26996.63333', '80998.0000', '<p>Model : NZRP 25 160 TBG V 1 J&nbsp;</p><p>Flow : 5 m3/hr&nbsp;</p><p>Head : 40 mtrs</p><p>Liquid : 33% HCL&nbsp;</p><p>Power : 5 HP / 2900 RPM (Remi Make )&nbsp;</p><p>Sealing : Mechanical Seal&nbsp;</p><p>Scope of supply :&nbsp;</p><p>Pump with base frame ,Coupling , Coupling guard, foundations and mounting bolts&nbsp;</p><p>NOTE : As per last supply vide invoice no. R/16-17/1037 date 17.09.2016&nbsp;</p>', '103660.00', '1', '1', '21', '11338.59', '22', '11338.59', '', '0.00', '80989.90', ''),
(3, 3, 1380, 1, '0.00000', '17500.00', 0, '0.00', '17500.00000', '17500.0000', '', '20650.00', '0', '0', '', '0.00', '', '0.00', '24', '3150.00', '17500.00', ''),
(4, 3, 650, 1, '0.00000', '18500.00', 0, '0.00', '18500.00000', '18500.0000', '', '21830.00', '0', '0', '', '0.00', '', '0.00', '24', '3330.00', '18500.00', ''),
(6, 5, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(7, 5, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(8, 6, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(9, 6, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(10, 7, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(11, 7, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(12, 8, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(13, 8, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(14, 9, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(15, 9, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(16, 10, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(17, 10, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(18, 11, 1463, 4, '0.00000', '130.00', 0, '0.00', '130.00000', '520.0000', '<p><br></p>', '613.60', '0', '0', '19', '46.80', '20', '46.80', '', '0.00', '520.00', ''),
(19, 11, 1295, 2, '0.00000', '200.00', 0, '0.00', '200.00000', '400.0000', '<p><br></p>', '512.00', '0', '0', '21', '56.00', '22', '56.00', '', '0.00', '400.00', ''),
(20, 12, 755, 15, '0.00000', '425.00', 0, '0.00', '425.00000', '6375.0000', '<p>Mechanical Seal for Johnson Pump Size : 16 mm</p><p>Face : Carban / Ceramic/ EPDM for Stork Pump</p>', '8160.00', '0', '0', '', '0.00', '', '0.00', '25', '1785.00', '6375.00', ''),
(21, 13, 1195, 2, '0.00000', '6699.00', 0, '0.00', '6699.00000', '13398.0000', '<p>Mounting : Foot Mounted&nbsp;</p><p>Frame Size : 90L&nbsp;</p>', '15810.00', '0', '0', '19', '1205.82', '20', '1205.82', '', '0.00', '13398.00', ''),
(22, 14, 1373, 1, '0.00000', '43956.00', 0, '0.00', '28571.40000', '43956.0000', '<p>CCR 40C 200 R6 S2 L3&nbsp;</p>', '33714.00', '35', '0', '', '0.00', '', '0.00', '24', '5142.85', '28571.40', ''),
(23, 15, 1373, 1, '0.00000', '43956.00', 0, '0.00', '28571.40000', '43956.0000', '<p>CCR 40C 200 R6 S2 L3&nbsp;</p>', '33714.00', '35', '0', '', '0.00', '', '0.00', '24', '5142.85', '28571.40', ''),
(27, 16, 1373, 1, '0.00000', '43956.00', 0, '0.00', '28571.40000', '43956.0000', '<p>CCR 40C 200 R6 S2 L3&nbsp;</p>', '33714.00', '35', '0', '', '0.00', '', '0.00', '24', '5142.85', '28571.40', ''),
(28, 4, 1686, 8, '0.00000', '2250.00', 0, '356.42', '2272.17625', '18001.0000', '<p>Complete Mechanical Seal Type 2100 Size: 25mm</p><p>Face: Silicon/Silicon/Viton&nbsp;</p>', '23260.00', '1', '2', '21', '2544.84', '22', '2544.84', '', '0.00', '18177.41', '180.01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_rows`
--
ALTER TABLE `purchase_return_rows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `purchase_return_rows`
--
ALTER TABLE `purchase_return_rows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
