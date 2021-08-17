-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2021 at 10:59 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4-midtrans-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `client_name` varchar(64) NOT NULL,
  `invoice_code` varchar(32) DEFAULT NULL,
  `invoice_status` enum('Lunas','Belum Lunas','Dibatalkan') NOT NULL,
  `description` varchar(255) NOT NULL,
  `total_amount` bigint(20) NOT NULL,
  `paid_amount` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client_name`, `invoice_code`, `invoice_status`, `description`, `total_amount`, `paid_amount`, `created_at`, `updated_at`) VALUES
(1, 'Septiana Nugraha', '2914836507', 'Lunas', 'Pembayaran Tagihan', 50000, 50000, '2021-04-30 05:01:03', '2021-04-30 05:02:46'),
(2, 'Septiana Nugraha', '7598023461', 'Lunas', 'Pembayaran Tagihan 2', 25000, 25000, '2021-04-30 05:08:57', '2021-04-30 05:11:02'),
(3, 'Septiana Nugraha', '6209378415', 'Lunas', 'Pembayaran Tagihan 3', 100000, 100000, '2021-04-30 05:11:36', '2021-04-30 05:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `snaps`
--

CREATE TABLE `snaps` (
  `id` bigint(20) NOT NULL,
  `invoice_code` varchar(32) NOT NULL,
  `snap_token` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `snaps`
--

INSERT INTO `snaps` (`id`, `invoice_code`, `snap_token`, `is_used`, `created_at`, `updated_at`) VALUES
(1, '2914836507', '9cebd6aa-6614-4e8d-bc74-c92b2e1e6e82', 0, '2021-04-30 05:01:03', '2021-04-30 05:01:03'),
(2, '7598023461', 'c8e2b8a5-8b51-4396-a09c-45a3fcdb2965', 0, '2021-04-30 05:08:58', '2021-04-30 05:08:58'),
(3, '6209378415', '8a541001-37cb-4a7f-a9f5-474faffa275b', 0, '2021-04-30 05:11:37', '2021-04-30 05:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL,
  `invoice_code` varchar(32) NOT NULL,
  `payment_type` varchar(32) NOT NULL,
  `payment_bank` varchar(32) DEFAULT NULL,
  `payment_code` varchar(128) DEFAULT NULL,
  `payment_amount` bigint(20) NOT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `transaction_code` varchar(255) NOT NULL,
  `transaction_status` varchar(32) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_code`, `payment_type`, `payment_bank`, `payment_code`, `payment_amount`, `transaction_time`, `transaction_code`, `transaction_status`, `created_at`, `updated_at`) VALUES
(1, '2914836507', 'bank_transfer', 'BCA', '94837952486', 50000, '2021-04-30 05:01:09', 'b5f8bdc2-bd84-4dc5-b95c-7545b2f55d81', 'Berhasil', '2021-04-30 05:01:14', '2021-04-30 05:02:46'),
(2, '7598023461', 'cstore', 'INDOMARET', '249670051825', 25000, '2021-04-30 05:09:15', '91ad239f-bb1d-4616-8427-dc4471dfd47a', 'Berhasil', '2021-04-30 05:10:57', '2021-04-30 05:11:02'),
(3, '6209378415', 'bank_transfer', 'BNI', '9889483749579082', 100000, '2021-04-30 05:11:42', '293980a4-ae88-4bd5-a543-2998a897d958', 'Berhasil', '2021-04-30 05:11:47', '2021-04-30 05:12:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snaps`
--
ALTER TABLE `snaps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `snaps`
--
ALTER TABLE `snaps`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
