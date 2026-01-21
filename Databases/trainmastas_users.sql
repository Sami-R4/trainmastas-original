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
-- Database: `trainmastas_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_ID` varchar(37) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(260) NOT NULL,
  `action` varchar(1) NOT NULL,
  `Type` varchar(6) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_ID`, `Name`, `Email`, `Password`, `action`, `Type`, `Date`) VALUES
('1236be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin 12', 'admin12@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('aa2f6be1-11a5-4e0f-8a82-0c3d3c1236f2', 'Admin5', 'admin5@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('adm126be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin Master 17', 'admin17@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('adm16be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin 16', 'admin16@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('adm184be1-11a5-4e0f-8a82-0c3d3c1236f2', 'Admin18', 'admin18@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('adm196be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin19', 'admin19@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('adm20be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin20', 'admin20@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('adm21be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin User 21', 'admin21@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'lower', '2025-01-13 07:43:31'),
('adm22be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin 22', 'admin22@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('adm23be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin23', 'admin23@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('adm24f6be1-11a5-4e0f-8a82-0c3d3c1236f', 'Admin 24', 'admin24@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('admin_67bc49244599d', 'Admin 34', 'admin123@gmail.com', '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2', 'n', 'middle', '2025-02-24 11:25:40'),
('admin_67bc4a8915950', 'Admin 11', 'admin12sss3@gmail.com', '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2', 'b', 'lower', '2025-02-24 11:31:37'),
('admin_67bc4a89396fe', 'Admin 31', 'admin12a3@gmail.com', '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2', 'b', 'lower', '2025-02-24 11:31:37'),
('admin_67bc4a893f60d', 'Admin 378', 'admin2223@gmail.com', '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2', 'n', 'middle', '2025-02-24 11:31:37'),
('admin_67bc4bdaa2cca', 'Admin 34', 'admin987@gmail.com', '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2', 'b', 'middle', '2025-02-24 11:37:14'),
('ffs46be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin Master 9', 'admin9@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('kkk46be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Admin Master', 'admin6@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('llof6be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin User 15', 'admin15@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'lower', '2025-01-13 07:43:31'),
('m32f6be1-11a5-4e0f-8a82-0c3d3c1236f2', 'Mireille', 'admin2@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('mnoe6be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Habil Salim 34\n', 'admin13@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'super', '2025-01-13 07:43:31'),
('oooo3be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin14', 'admin14@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('ryehd4be1-11a5-4e0f-8a82-0c3d3c1236f2', 'Admin9', 'admin9@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('tabc16be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin11', 'admin11@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('tt216be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin8', 'admin8@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('tytf6be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin User 7', 'admin7@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'lower', '2025-01-13 07:43:31'),
('u23f6be1-11a5-4e0f-8a82-0c3d3c1236b0', 'Ruby', 'admin3@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31'),
('u42f6be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Habil Salim', 'admin@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'super', '2025-01-13 07:43:31'),
('uu3f6be1-11a5-4e0f-8a82-0c3d3c1176f2', 'Admin4', 'admin4@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-13 07:43:31'),
('uud2f6be1-11a5-4e0f-8a82-0c3d3c1236f2', 'Mireille', 'admin10@gmail.com', '$2y$10$WNlLTVGmHmSGvOUs2JT5o.fPvjYqWifapq8HV7IXnrub4pxiStkVC', 'n', 'middle', '2025-01-25 07:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `admin_deleted`
--

CREATE TABLE `admin_deleted` (
  `user_ID` varchar(37) NOT NULL,
  `email` varchar(100) NOT NULL,
  `deleted_by` varchar(37) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `user_ID` varchar(37) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`user_ID`, `Email`, `Password`) VALUES
('06a7ed26-c01a-4746-9723-e3f534c790ba', 'student2@gmail.com', '$2y$10$9DFN5oOaZDN9Q7kR0NWLuuBrB6fMxr0an/oJOnc4Qm5VOEGMmyyrm'),
('7950d592-fb59-4d03-9f6b-0b4bb35acd5e', 'student1@gmail.com', '$2y$10$vDOqOlIR9G0By.hthsu1Uuv98d1Ox.oBdp04oTnaRAKly6XvH6cTq'),
('7d1fc16e-3549-4de5-a05b-55d2f679e897', 'teacher1@gmail.com', '$2y$10$s1MUO0U5p19hDz5.uw3rdOUI0U4n6HVxL8yNS2eALLRsarirOQQRC'),
('a5636c14-1a09-40ab-8863-98253ee2c659', 'ngoupayouhabil@gmail.com', '$2y$10$sYlIhh2m.g0KXs3v/CnA8.4Xd2KTydmvtfGvJbQU/CLjAVQm0.pFe');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `user_ID` varchar(37) NOT NULL,
  `field_num` varchar(2) NOT NULL,
  `Field` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`user_ID`, `field_num`, `Field`) VALUES
('7d1fc16e-3549-4de5-a05b-55d2f679e897', '1', 'Web Development'),
('7d1fc16e-3549-4de5-a05b-55d2f679e897', '2', 'Frontend Development'),
('7d1fc16e-3549-4de5-a05b-55d2f679e897', '3', 'Backend Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '1', 'Web Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '2', 'Frontend Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '3', 'Backend Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '4', 'Full Stack Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '5', 'Mobile App Development'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '6', 'Software Engineering'),
('a5636c14-1a09-40ab-8863-98253ee2c659', '7', 'Database Management');

-- --------------------------------------------------------

--
-- Table structure for table `refresh_tokens`
--

CREATE TABLE `refresh_tokens` (
  `refresh_tokens_id` char(37) NOT NULL,
  `user_id` char(37) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `refresh_tokens`
--

INSERT INTO `refresh_tokens` (`refresh_tokens_id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
('420ef608-14ee-4785-a380-99e681634320', '3e93c124-36c8-4131-bbc4-fc97ba426430', '592e7619bfedbb7f8ca40bc5e1d4989c51a234cc0d2410c4fa2a323b72db3384419226d7ee8ef0d980bf8d2c7aa9c041729c425d4123384700299b541ebf4127', '2025-05-24 22:37:25', '2025-04-24 20:37:25'),
('47395acc-3a25-4e74-b8a3-33a0e72e6e13', '7846c441-b0d2-448d-9586-0165f7706e8c', '295adf047b53974846f799a0d84a16bd510057c08d299cb77159c9d4f55745c3ace70bc2621a306454b7bb99df7a864810883987d4d97461ad2ffb2bb59d8cd7', '2025-05-24 22:33:22', '2025-04-24 20:33:22'),
('77b7d98b-a5c2-43ce-ac5a-f4fd15a851d5', '793b0f72-862d-488f-9a1a-5ca0c4f2d132', '6ce3941d30beb491bab78ad9d10a498b634432c1c7ca099c7be1639dcdce1d145e0124de4150f1b902848ea3f6a55a0c769bb5d579c151dca170edfd10751c24', '2025-05-24 22:36:03', '2025-04-24 20:36:03'),
('9cef917d-f821-446e-aea4-0322ea362190', '7d1fc16e-3549-4de5-a05b-55d2f679e897', 'e607d32ac08576757b6853516b66ecee445f027426c5e55f152cefcc4f509aa718667a13e7f709143c92b5756944e2af7d33d66e3111d678cef908e61b9482c2', '2025-05-25 02:38:44', '2025-04-25 00:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `teachers_rejected`
--

CREATE TABLE `teachers_rejected` (
  `user_ID` varchar(37) NOT NULL,
  `Reason` varchar(210) NOT NULL,
  `reapplied` tinyint(1) DEFAULT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers_rejected`
--

INSERT INTO `teachers_rejected` (`user_ID`, `Reason`, `reapplied`, `Date`) VALUES
('7d1fc16e-3549-4de5-a05b-55d2f679e897', 'Rejected. You don\'t have the quality needed.', 0, '2025-04-21 18:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_extra`
--

CREATE TABLE `teacher_extra` (
  `user_ID` varchar(37) NOT NULL,
  `Career` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `cv` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` varchar(37) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `type` varchar(1) NOT NULL,
  `Image` varchar(50) DEFAULT NULL,
  `Balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fund` decimal(10,2) DEFAULT NULL,
  `action` varchar(1) NOT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `verified_submitted_date` datetime DEFAULT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `Name`, `Description`, `type`, `Image`, `Balance`, `fund`, `action`, `verified`, `verified_submitted_date`, `Date`) VALUES
('06a7ed26-c01a-4746-9723-e3f534c790ba', 'student two', NULL, 's', NULL, '0.00', NULL, '', NULL, NULL, '2025-04-24 21:38:13'),
('7950d592-fb59-4d03-9f6b-0b4bb35acd5e', 'student one', NULL, 's', NULL, '0.00', NULL, '', NULL, NULL, '2025-04-22 15:29:54'),
('7d1fc16e-3549-4de5-a05b-55d2f679e897', 'Teacher 1', 'Hard working!', 'c', 'profile_6806217b31cd85.53267211.jpg', '0.00', NULL, '', 0, '2025-04-21 18:41:20', '2025-04-17 11:03:48'),
('a5636c14-1a09-40ab-8863-98253ee2c659', 'Ngoupayou Habil Salim', 'I&#039;m a hard working and serious teacher. Trust me, i will revolutionalize your learning experience. Trust me', 'c', 'profile_67f53fcbcfeef0.42004369.png', '9.00', '2.50', '', NULL, NULL, '2025-04-08 16:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_deleted`
--

CREATE TABLE `user_deleted` (
  `user_ID` varchar(37) NOT NULL,
  `email` varchar(100) NOT NULL,
  `admin_ID` varchar(1) NOT NULL,
  `type` varchar(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_link`
--

CREATE TABLE `user_link` (
  `user_ID` varchar(37) NOT NULL,
  `type` varchar(1) NOT NULL,
  `link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_link`
--

INSERT INTO `user_link` (`user_ID`, `type`, `link`) VALUES
('7d1fc16e-3549-4de5-a05b-55d2f679e897', 'c', 'cv_6805f9af2f0f41.39003193.pdf'),
('7d1fc16e-3549-4de5-a05b-55d2f679e897', 'p', 'https://habilsalim.netlify.app/'),
('a5636c14-1a09-40ab-8863-98253ee2c659', 'l', 'https://linkedin.com/ngoupayouhabil/'),
('a5636c14-1a09-40ab-8863-98253ee2c659', 'p', 'https://habilsalim.netlify.app/');

-- --------------------------------------------------------

--
-- Table structure for table `user_verification`
--

CREATE TABLE `user_verification` (
  `verification_ID` varchar(11) NOT NULL,
  `user_ID` varchar(37) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `action_type` enum('login','payment','password') NOT NULL,
  `verification_code` varchar(6) NOT NULL,
  `attempt_count` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `max_attempts` tinyint(3) UNSIGNED NOT NULL DEFAULT 3,
  `expires_at` datetime NOT NULL,
  `status` enum('pending','verified','expired','locked') DEFAULT 'pending',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `admin_deleted`
--
ALTER TABLE `admin_deleted`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`user_ID`,`field_num`);

--
-- Indexes for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  ADD PRIMARY KEY (`refresh_tokens_id`);

--
-- Indexes for table `teachers_rejected`
--
ALTER TABLE `teachers_rejected`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `teacher_extra`
--
ALTER TABLE `teacher_extra`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `user_deleted`
--
ALTER TABLE `user_deleted`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `user_link`
--
ALTER TABLE `user_link`
  ADD PRIMARY KEY (`user_ID`,`type`);

--
-- Indexes for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD PRIMARY KEY (`verification_ID`),
  ADD UNIQUE KEY `user_ID_2` (`user_ID`),
  ADD KEY `user_action_index` (`user_ID`,`action_type`),
  ADD KEY `user_ID` (`user_ID`);
ALTER TABLE `user_verification` ADD FULLTEXT KEY `user_ID_3` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
