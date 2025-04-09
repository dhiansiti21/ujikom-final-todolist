-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 21, 2025 at 12:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `history_id` int NOT NULL,
  `task_id` int NOT NULL,
  `task_label` varchar(255) DEFAULT NULL,
  `previous_status` varchar(255) DEFAULT NULL,
  `new_status` varchar(255) DEFAULT NULL,
  `change_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `task_id`, `task_label`, `previous_status`, `new_status`, `change_at`) VALUES
(7, 39, '', 'open', 'close', '2025-02-14 02:30:48'),
(8, 40, '', 'open', 'close', '2025-02-18 01:45:07'),
(9, 41, '', 'open', 'close', '2025-02-18 01:45:31'),
(10, 42, '', 'open', 'close', '2025-02-18 01:47:57'),
(11, 43, '', 'open', 'close', '2025-02-19 04:42:11'),
(12, 43, '', 'close', 'open', '2025-02-19 05:06:41'),
(13, 43, '', 'open', 'close', '2025-02-19 05:06:45'),
(14, 44, 'tes lah', 'open', 'close', '2025-02-19 05:22:23'),
(15, 45, 'bangun tidur', 'open', 'close', '2025-02-19 05:31:08'),
(16, 45, 'bangun tidur', 'close', 'open', '2025-02-19 05:31:09'),
(17, 46, 'mandi', 'open', 'close', '2025-02-19 05:31:27'),
(18, 46, 'mandi', 'close', 'open', '2025-02-19 05:31:28'),
(19, 47, 'bangun tidur', 'open', 'close', '2025-02-19 05:33:02'),
(20, 47, 'bangun tidur', 'close', 'open', '2025-02-19 05:33:03'),
(21, 47, 'bangun tidur', 'open', 'close', '2025-02-19 05:33:22'),
(22, 47, 'bangun tidur', 'close', 'open', '2025-02-19 05:33:23'),
(23, 48, 'sarapan', 'open', 'close', '2025-02-19 08:07:57'),
(24, 48, 'sarapan', 'close', 'open', '2025-02-19 08:07:58'),
(25, 51, 'lari pagi', 'open', 'close', '2025-02-21 01:56:25'),
(26, 49, 'dinner', 'open', 'close', '2025-02-21 01:57:13'),
(27, 52, 'olahraga', 'open', 'close', '2025-02-21 06:13:37'),
(28, 52, 'olahraga', 'close', 'open', '2025-02-21 06:13:53'),
(29, 53, 'makan malam', 'open', 'close', '2025-02-21 06:34:52'),
(30, 53, 'makan malam', 'close', 'open', '2025-02-21 06:35:10'),
(31, 53, 'makan malam', 'open', 'close', '2025-02-21 06:35:35'),
(32, 52, 'olahraga', 'open', 'close', '2025-02-21 06:35:37'),
(33, 53, 'makan malam', 'close', 'open', '2025-02-21 06:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `subtaskid` int NOT NULL,
  `taskid` int DEFAULT NULL,
  `subtasklabel` varchar(255) DEFAULT NULL,
  `subtaskstatus` enum('open','close') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`subtaskid`, `taskid`, `subtasklabel`, `subtaskstatus`) VALUES
(3, 27, 'tes', 'open'),
(4, 27, 'makan siang', 'open'),
(6, 30, 'makan siang', 'open'),
(7, 30, 'tes', 'open'),
(8, 27, 'mandi', 'open'),
(11, 43, 'tes coba', 'close'),
(12, 45, 'makan malam', 'open'),
(15, 47, 'yyy', 'close'),
(16, 48, 'yyy', 'open'),
(17, 49, 'makan malam', 'open'),
(18, 50, 'tes', 'close'),
(19, 50, 'makan malam', 'close'),
(20, 52, 'lari pagi', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskid` int NOT NULL,
  `user_id` int NOT NULL,
  `tasklabel` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `taskstatus` enum('open','close') COLLATE utf8_general_ci NOT NULL,
  `createdat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` enum('rendah','tinggi') COLLATE utf8_general_ci DEFAULT 'rendah',
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskid`, `user_id`, `tasklabel`, `taskstatus`, `createdat`, `priority`, `deadline`) VALUES
(27, 0, 'ngoding todolist', 'close', '2025-02-09 06:03:25', 'tinggi', '2025-02-12'),
(30, 0, 'sarapan', 'close', '2025-02-11 07:29:18', 'rendah', '2025-02-05'),
(33, 0, 'jo ', 'close', '2025-02-14 02:00:10', 'rendah', '2025-02-22'),
(34, 0, 'kkkk', 'close', '2025-02-14 02:04:19', 'rendah', '2025-02-15'),
(43, 0, 'makan malam', 'close', '2025-02-18 01:53:25', 'tinggi', '2025-02-05'),
(44, 6, 'tes lah', 'close', '2025-02-19 05:22:19', 'rendah', '2025-02-21'),
(45, 1, 'bangun tidur', 'open', '2025-02-19 05:28:57', 'tinggi', '2025-02-06'),
(46, 1, 'mandi', 'open', '2025-02-19 05:31:24', 'rendah', '2025-02-06'),
(47, 1, 'bangun tidur', 'open', '2025-02-19 05:33:00', 'rendah', '2025-01-30'),
(48, 7, 'sarapan', 'open', '2025-02-19 08:07:50', 'rendah', '2025-02-06'),
(49, 1, 'dinner', 'close', '2025-02-19 12:13:02', 'rendah', '2025-02-07'),
(50, 1, 'ngoding todolist', 'open', '2025-02-19 13:19:18', 'tinggi', '2025-02-20'),
(51, 1, 'lari pagi', 'close', '2025-02-21 01:55:06', 'tinggi', '2025-02-28'),
(52, 8, 'olahraga', 'close', '2025-02-21 06:11:47', 'rendah', '2025-02-13'),
(53, 8, 'makan malam', 'open', '2025-02-21 06:34:48', 'tinggi', '2025-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'dhian', 'dian@gmail.com', '$2y$10$9biqHT2PTpLZhEGt2miCAuP43NSSk9yc3QCow6lPt.c3Xczmdw9J.'),
(2, 'asep', 'asep@kkk', '$2y$10$ZKQb5IyC081qQCV34XcdnuC8alUc/Jp.ynhcnqKEPsvVBvycNEmwa'),
(3, 'dania', 'dania@gmail.com', '$2y$10$Soyph325V94btSNayJ7jCeCzES5VCvUMmol8vjW3r2sZobEfwVIV6'),
(4, 'arka', 'arka@gmail.com', '$2y$10$ZoervcjhYMjFLTpvPDCG9.O9sUF3HeUZisqGvBp99eFkT6vbgSOvW'),
(5, 'tess', 'tess12345@gmail.com', '$2y$10$oYqOwCZrLr7ukPcz98P68ORj99eOwaFFvNmrJWHJrP45Hab/vEJVq'),
(6, 'tes1', 'tes1@gmail.com', '$2y$10$mOIi1iYNVFGX1fSE1eBTC.YUngRfXGHa8Kfi8sZSpRXp9e8SdM4da'),
(7, 'erni', 'erni@gmail.com', '$2y$10$48/NWqrt6tSz.ZFqlnx70eUwNTqDcctSaNm.t8nB/POCvuPUZIT/6'),
(8, 'dian', 'dyn@gmail.com', '$2y$10$WMhRbyOhiqX/QaBRtE692.giGt2Hu/9VkgXvF6jUnVmMMvF29JT/O'),
(9, 'chalista', 'chalista@gmail.com', '$2y$10$e.lxpbXXEAF2RVANPyOGHOkUaqM4iAZydrpRa1e6CrOeml0f03pLu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`subtaskid`),
  ADD KEY `taskid` (`taskid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskid`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `history_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `subtaskid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`taskid`) REFERENCES `tasks` (`taskid`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
