-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 12:28 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainmastas_payments`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_payment`
--

CREATE TABLE `course_payment` (
  `payment_ID` varchar(37) NOT NULL,
  `course_ID` varchar(37) NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `Amount` decimal(5,2) NOT NULL,
  `Purpose` varchar(4) NOT NULL,
  `status` enum('success','pending','cancel') DEFAULT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_payment`
--

INSERT INTO `course_payment` (`payment_ID`, `course_ID`, `user_ID`, `Amount`, `Purpose`, `status`, `Date`) VALUES
('644ca795-5b3b-4b83-8532-ff7a9fec1bd7', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7d1fc16e-3549-4de5-a05b-55d2f679e897', '2.50', 'cer', 'success', '2025-04-17 16:27:28'),
('e8bf2c80-bdc4-4872-9fd1-d0ed5629bbf8', '7e11e57a-b0ca-409a-b0aa-04edd5bb4e9a', '7d1fc16e-3549-4de5-a05b-55d2f679e897', '2.50', 'cer', 'success', '2025-04-17 16:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `recharge`
--

CREATE TABLE `recharge` (
  `payment_ID` varchar(37) NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `status` enum('success','pending','failed') NOT NULL,
  `Payment_method` enum('skrill','flutterwave','internal') NOT NULL,
  `Amount` decimal(4,2) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recharge`
--

INSERT INTO `recharge` (`payment_ID`, `user_ID`, `status`, `Payment_method`, `Amount`, `Date`) VALUES
('8273hhhs', '7d1fc16e-3549-4de5-a05b-55d2f679e897', 'success', 'skrill', '10.00', '2025-04-22 22:21:39'),
('8273tejsbdm', '7950d592-fb59-4d03-9f6b-0b4bb35acd5e', 'success', 'flutterwave', '10.00', '2025-04-22 22:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `withdrew_payment`
--

CREATE TABLE `withdrew_payment` (
  `withdrew_ID` varchar(37) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Withdrawal_method` enum('skrill','flutterwave','internal') NOT NULL,
  `user_ID` varchar(37) NOT NULL,
  `requested_date` datetime DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `withdrew_payment`
--

INSERT INTO `withdrew_payment` (`withdrew_ID`, `Amount`, `Withdrawal_method`, `user_ID`, `requested_date`, `approved_date`) VALUES
('01be0a9c-8b06-4e84-b947-ee42d670e0db', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('01be0a9c-8b06-4e84-b947-ysh2d670e0db', '1.00', 'flutterwave', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('01be0a9c-8b06-4e84-uy57-ysh2d670e0db', '1.00', 'flutterwave', '7d1fc16e-3549-4de5-a05b-55d2f679e897', '2025-04-10 00:04:00', '2025-04-01 00:03:53'),
('1dc6ad95-a0fc-406a-957e-208778f9cb2b', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('59145cda-fe0f-42aa-9869-0f7faf1c7346', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('66fe90b5-6446-4076-a5a7-cb544134928b', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('811d2cc1-3385-4392-9b4a-9ab9b603fa1e', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('d3303137-79b6-41f1-9a85-75f1f5a70223', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('d3303137-79b6-41f1-9a85-75f1f5a702b7', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('eefdee66-a476-4c69-b0cb-7a883dedf70b', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL),
('eefdee66-a476-4c69-b0cb-7a883dedf711', '1.00', 'internal', 'a5636c14-1a09-40ab-8863-98253ee2c659', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_payment`
--
ALTER TABLE `course_payment`
  ADD PRIMARY KEY (`payment_ID`,`course_ID`,`user_ID`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`payment_ID`);

--
-- Indexes for table `withdrew_payment`
--
ALTER TABLE `withdrew_payment`
  ADD PRIMARY KEY (`withdrew_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
