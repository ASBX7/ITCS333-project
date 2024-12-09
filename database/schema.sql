-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 04:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itcollege`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_type`
--

CREATE TABLE `class_type` (
  `type` varchar(100) NOT NULL,
  `capacity` int(2) NOT NULL,
  `equipments` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_type`
--

INSERT INTO `class_type` (`type`, `capacity`, `equipments`) VALUES
('Class', 40, '41 chairs, 1 PC, white board, smart board, and a table.'),
('Lab', 30, '31 chairs, 31 PC, white board, smart board, and a table.');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_rooms`
--

CREATE TABLE `deleted_rooms` (
  `transaction_num` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dep_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dep_name`) VALUES
('Computer Engineering (CE)'),
('Computer Science (CS)'),
('Information System (IS)');

-- --------------------------------------------------------

--
-- Table structure for table `reserved_rooms`
--

CREATE TABLE `reserved_rooms` (
  `reserve_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL,
  `time_slot` varchar(60) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(10) NOT NULL,
  `location` varchar(30) NOT NULL,
  `firstSlot` tinyint(1) NOT NULL DEFAULT 1,
  `secondSlot` tinyint(1) NOT NULL DEFAULT 1,
  `thirdSlot` tinyint(1) NOT NULL DEFAULT 1,
  `fourthSlot` tinyint(1) NOT NULL DEFAULT 1,
  `fifthSlot` tinyint(1) NOT NULL DEFAULT 1,
  `sixthSlot` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(30) NOT NULL,
  `today_date` date NOT NULL DEFAULT current_timestamp(),
  `department` varchar(100) NOT NULL,
  `room_pic` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `location`, `firstSlot`, `secondSlot`, `thirdSlot`, `fourthSlot`, `fifthSlot`, `sixthSlot`, `type`, `today_date`, `department`, `room_pic`) VALUES
(2, '1011', 1, 1, 0, 1, 1, 1, 'Class', '2024-12-05', 'Information System (IS)', ''),
(4, '333', 0, 0, 0, 0, 1, 1, 'Class', '2024-12-05', 'Computer Science (CS)', ''),
(5, '2043', 1, 1, 1, 1, 1, 1, 'Lab', '2024-12-07', 'Computer Science (CS)', ''),
(6, '1045', 1, 1, 1, 1, 1, 1, 'Class', '2024-12-08', 'Computer Engineering (CE)', 'class.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_Id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL COMMENT 'unique',
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `remember_me` tinyint(1) DEFAULT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_pic` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_Id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `remember_me`, `user_type`, `user_pic`) VALUES
(15, 'Zain', 'Hasan', 'zain@admin.it', '$2y$10$x8KoQQ7j6h5/Q0x3RRILnuTaQGykEhXDZUcukCJA6szepXW30x42q', '38888888', NULL, 'admin', 'profileimg.jpg'),
(18, 'Zainab', 'Naser', '202107088@stu.uob.edu.bh', '$2y$10$Nhmt.AmlcFqOAgfoNSrTAea9ytNHzftF0f.Bde/22XzxFdlz.e1M6', '39977197', NULL, 'user', NULL),
(19, 'Ahmed', 'Salman', '20201111@stu.uob.edu.bh', '$2y$10$Bo8hL6M1K/x3v2cfpF4AD.TskpWgSSqiLu5FE3ZUaBrw.WqhpGEa2', '39676768', NULL, 'user', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_type`
--
ALTER TABLE `class_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `deleted_rooms`
--
ALTER TABLE `deleted_rooms`
  ADD PRIMARY KEY (`transaction_num`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dep_name`);

--
-- Indexes for table `reserved_rooms`
--
ALTER TABLE `reserved_rooms`
  ADD PRIMARY KEY (`reserve_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `location` (`location`),
  ADD KEY `type` (`type`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deleted_rooms`
--
ALTER TABLE `deleted_rooms`
  MODIFY `transaction_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserved_rooms`
--
ALTER TABLE `reserved_rooms`
  MODIFY `reserve_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deleted_rooms`
--
ALTER TABLE `deleted_rooms`
  ADD CONSTRAINT `deleted_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `deleted_rooms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_Id`);

--
-- Constraints for table `reserved_rooms`
--
ALTER TABLE `reserved_rooms`
  ADD CONSTRAINT `reserved_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  ADD CONSTRAINT `reserved_rooms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_Id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`type`) REFERENCES `class_type` (`type`),
  ADD CONSTRAINT `room_ibfk_2` FOREIGN KEY (`department`) REFERENCES `departments` (`dep_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
