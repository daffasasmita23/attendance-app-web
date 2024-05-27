-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 27, 2024 at 02:02 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `eventId` int(11) NOT NULL,
  `eventType` int(11) DEFAULT NULL,
  `personName` varchar(255) DEFAULT NULL,
  `personCode` varchar(255) DEFAULT NULL,
  `checkIn` datetime DEFAULT NULL,
  `checkOut` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`eventId`, `eventType`, `personName`, `personCode`, `checkIn`, `checkOut`) VALUES
(1, 2001231, 'Albert', '231091029', '2024-01-20 08:00:00', '2024-01-20 17:00:00'),
(2, 2001232, 'Bob', '231091030', '2024-01-21 08:00:00', '2024-01-21 17:00:00'),
(3, 2001233, 'Charlie', '231091031', '2024-01-22 08:00:00', '2024-01-22 17:00:00'),
(4, 2001234, 'David', '231091032', '2024-01-23 08:00:00', '2024-01-23 17:00:00'),
(5, 2001235, 'Edward', '231091033', '2024-01-24 08:00:00', '2024-01-24 17:00:00'),
(6, 2001236, 'Frank', '231091034', '2024-01-25 08:00:00', '2024-01-25 17:00:00'),
(7, 2001237, 'George', '231091035', '2024-01-26 08:00:00', '2024-01-26 17:00:00'),
(8, 2001238, 'Henry', '231091036', '2024-01-27 08:00:00', '2024-01-27 17:00:00'),
(9, 2001239, 'Ian', '231091037', '2024-01-28 08:00:00', '2024-01-28 17:00:00'),
(10, 2001240, 'John', '231091038', '2024-01-29 08:00:00', '2024-01-29 17:00:00'),
(11, 2001241, 'Kevin', '231091039', '2024-01-30 08:00:00', '2024-01-30 17:00:00'),
(12, 2001242, 'Larry', '231091040', '2024-01-31 08:00:00', '2024-01-31 17:00:00'),
(13, 2001243, 'Mike', '231091041', '2024-02-01 08:00:00', '2024-02-01 17:00:00'),
(14, 2001244, 'Nick', '231091042', '2024-02-02 08:00:00', '2024-02-02 17:00:00'),
(15, 2001245, 'Oscar', '231091043', '2024-02-03 08:00:00', '2024-02-03 17:00:00'),
(16, 2001246, 'Paul', '231091044', '2024-02-04 08:00:00', '2024-02-04 17:00:00'),
(17, 2001247, 'Quincy', '231091045', '2024-02-05 08:00:00', '2024-02-05 17:00:00'),
(18, 2001248, 'Robert', '231091046', '2024-02-06 08:00:00', '2024-02-06 17:00:00'),
(19, 2001249, 'Steve', '231091047', '2024-02-07 08:00:00', '2024-02-07 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `namaDepartement` varchar(255) NOT NULL,
  `tanggalPembuatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `namaDepartement`, `tanggalPembuatan`) VALUES
(1, 'HRD', '2022-01-01'),
(2, 'Marketing', '2022-02-01'),
(3, 'Warehouse', '2022-03-01'),
(4, 'Packing', '2022-04-01'),
(5, 'SSL', '2022-05-01'),
(6, 'SHE', '2022-06-01'),
(9, 'QMS', '2023-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `personCode` varchar(255) DEFAULT NULL,
  `personName` varchar(255) DEFAULT NULL,
  `personFamily` varchar(255) DEFAULT NULL,
  `personGivenName` varchar(255) DEFAULT NULL,
  `personId` int(11) NOT NULL,
  `department` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`personCode`, `personName`, `personFamily`, `personGivenName`, `personId`, `department`) VALUES
('20041837', 'Dwi Ridwan Fauzi', 'Fauzi', 'Dwi Ridwan', 910, NULL),
('20040619', 'Sandra Sekarsari', 'Sekarsari', 'Sandra', 911, NULL),
('20040955', 'Ahmad Nurdien .S', 'Nurdien .S', 'Ahmad', 912, NULL),
('20039228', 'Erik Pratama Siregar', 'Siregar', 'Erik Pratama', 913, NULL),
('20041150', 'Maria Adeline', 'Adeline', 'Maria', 914, NULL),
('20042206', 'Amir Syarif', 'Syarif', 'Amir', 915, NULL),
('20041195', 'Pebriana Suseno', 'Suseno', 'Pebriana', 916, NULL),
('20040879', 'Muhammad Adhil Syach', 'Syach', 'Muhammad Adhil', 917, NULL),
('20042281', 'Meiliena', 'Meiliena', 'Meiliena', 918, NULL),
('20039107', 'Albertus Hindrata', 'Hindrata', 'Albertus', 919, NULL),
('2313213131', 'ALBERTIN', 'KENNETH', 'ALBERTIN KENNETH', 930, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventId` int(11) NOT NULL,
  `eventType` varchar(255) NOT NULL,
  `eventTime` datetime NOT NULL,
  `personName` varchar(255) NOT NULL,
  `doorName` varchar(255) NOT NULL,
  `doorIndexCode` varchar(255) NOT NULL,
  `checkInAndOutType` varchar(255) NOT NULL,
  `personId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventId`, `eventType`, `eventTime`, `personName`, `doorName`, `doorIndexCode`, `checkInAndOutType`, `personId`) VALUES
(1, '196893', '2024-01-20 11:00:00', 'SpiderMans', 'ACS Lobby Out', '32', 'check-out', 1),
(2, '196893', '2024-01-21 08:00:00', 'Batman', 'ACS Lobby In', '14', 'check-in', 2),
(3, '196895', '2024-01-22 10:00:00', 'Captain America', 'ACS Lobby Out', '34', 'check-out', 3),
(4, '196896', '2024-01-23 11:00:00', 'Thor', 'ACS Lobby In', '35', 'check-in', 4),
(5, '196897', '2024-01-24 12:00:00', 'Hulk', 'ACS Lobby Out', '36', 'check-out', 5),
(6, '196898', '2024-01-25 13:00:00', 'Black Widow', 'ACS Lobby In', '37', 'check-in', 6),
(7, '196899', '2024-01-26 14:00:00', 'Hawkeye', 'ACS Lobby Out', '38', 'check-out', 7),
(8, '196900', '2024-01-27 15:00:00', 'Falcon', 'ACS Lobby In', '39', 'check-in', 8),
(9, '196901', '2024-01-28 16:00:00', 'Winter Soldier', 'ACS Lobby Out', '40', 'check-out', 9),
(10, '196902', '2024-01-29 17:00:00', 'Ant-Man', 'ACS Lobby In', '41', 'check-in', 10),
(11, '196903', '2024-01-30 18:00:00', 'Doctor Strange', 'ACS Lobby Out', '42', 'check-out', 11),
(12, '196904', '2024-01-31 19:00:00', 'Black Panther', 'ACS Lobby In', '43', 'check-in', 12),
(13, '196905', '2024-02-01 20:00:00', 'Vision', 'ACS Lobby Out', '44', 'check-out', 13),
(14, '196906', '2024-02-02 21:00:00', 'Scarlet Witch', 'ACS Lobby In', '45', 'check-in', 14),
(15, '196907', '2024-02-03 22:00:00', 'Quicksilver', 'ACS Lobby Out', '46', 'check-out', 15),
(16, '196908', '2024-02-04 23:00:00', 'War Machine', 'ACS Lobby In', '47', 'check-in', 16),
(17, '196909', '2024-02-05 00:00:00', 'Star-Lord', 'ACS Lobby Out', '48', 'check-out', 17),
(18, '196910', '2024-02-06 01:00:00', 'Gamora', 'ACS Lobby In', '49', 'check-in', 18),
(19, '196911', '2024-02-07 02:00:00', 'Drax the Destroyer', 'ACS Lobby Out', '50', 'check-out', 19),
(20, '196912', '2024-02-08 03:00:00', 'Groot', 'ACS Lobby In', '51', 'check-in', 20);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `addUser` tinyint(1) NOT NULL DEFAULT 0,
  `editUser` tinyint(1) NOT NULL DEFAULT 0,
  `viewUser` tinyint(1) NOT NULL DEFAULT 0,
  `editEvent` tinyint(1) NOT NULL DEFAULT 0,
  `viewEvent` tinyint(1) NOT NULL DEFAULT 0,
  `addEmployees` tinyint(1) NOT NULL DEFAULT 0,
  `editEmployees` tinyint(1) NOT NULL DEFAULT 0,
  `viewEmployees` tinyint(1) NOT NULL DEFAULT 0,
  `addAttendance` tinyint(1) NOT NULL DEFAULT 0,
  `editAttendance` tinyint(1) NOT NULL DEFAULT 0,
  `viewAttendance` tinyint(1) NOT NULL DEFAULT 0,
  `addEvent` int(11) DEFAULT NULL,
  `addDepartment` tinyint(1) DEFAULT 0,
  `editDepartment` tinyint(1) DEFAULT 0,
  `viewDepartment` tinyint(1) DEFAULT 0,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role`, `addUser`, `editUser`, `viewUser`, `editEvent`, `viewEvent`, `addEmployees`, `editEmployees`, `viewEmployees`, `addAttendance`, `editAttendance`, `viewAttendance`, `addEvent`, `addDepartment`, `editDepartment`, `viewDepartment`, `create_date`) VALUES
(2, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-27 02:06:25'),
(3, 'IT', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2024-05-27 02:06:25'),
(7, 'users', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2024-05-27 02:06:25'),
(17, 'b', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, '2024-05-27 04:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT 'user',
  `avatar` varchar(255) DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `password`, `role`, `avatar`) VALUES
(5, 'brian', 'amber', 'brian123', '$2y$10$jEQoBo4FbgegRca40p9lUuaoT4mJvfTfsl2uL5stkN0965TyLSOPe', 'users', 'avatar.png'),
(44, NULL, NULL, NULL, NULL, 'admin', 'avatar.png'),
(46, 'asdad', 'sadkads', '123', '$2y$10$PP4g3vOV02B7VLG7b4iqeOiJeslujyCmhRNVSXSRfrLLxTz9EzM.2', 'admin', 'avatar.png'),
(47, 'aksndaknd', 'nksadnkdan', 'ksdankand', '$2y$10$9O7x9L03..cxmKHfAiZNXeBpJkY4GQIE/TsVWirBRstd60sXvqBBC', 'admin', 'avatar.png'),
(48, NULL, NULL, NULL, NULL, 'IT', 'avatar.png'),
(49, 'ajsda', 'ndask', 'ksadnka', '$2y$10$Mg8/9304TgUoYh2tukUClO232chbIybIKgz/rJAilnSlrhtxFZwkC', 'admin', 'avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`personId`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
