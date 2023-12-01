-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 24, 2023 at 05:09 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slsu_repo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `logs` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `logs`, `user_id`, `date`) VALUES
(179, 'Administrator is logging out', 22, '2023-11-20 07:50:51'),
(180, 'Administrator is logging in', 22, '2023-11-20 07:50:57'),
(181, 'Sasuke Uchiha is logging in', 20, '2023-11-20 07:53:34'),
(182, 'Sasuke Uchiha liked the file Student-Portfolio.pdf', 20, '2023-11-20 07:53:51'),
(183, 'Sasuke Uchiha liked the file Target Company.docx', 20, '2023-11-20 07:53:57'),
(184, 'Administrator liked the file Student-Portfolio.pdf', 22, '2023-11-20 07:54:03'),
(185, 'Administrator liked the file SYSTEM VISION DOCUMENT.docx', 22, '2023-11-20 07:54:04'),
(186, 'Sasuke Uchiha is rating 4 of the file Target Company.docx', 20, '2023-11-20 07:54:20'),
(193, 'Administrator is downloading Student-Portfolio.pdf', 22, '2023-11-20 07:58:12'),
(194, 'Administrator is downloading Student-Portfolio.pdf', 22, '2023-11-20 07:58:16'),
(195, 'Administrator is downloading SYSTEM VISION DOCUMENT.docx', 22, '2023-11-20 07:58:19'),
(196, 'Administrator is downloading Target Company.docx', 22, '2023-11-20 07:58:25'),
(197, 'Sasuke Uchiha is downloading SYSTEM VISION DOCUMENT.docx', 20, '2023-11-20 07:58:37'),
(198, 'Sasuke Uchiha is downloading Student-Portfolio.pdf', 20, '2023-11-20 07:58:42'),
(199, 'Sasuke Uchiha is downloading Target Company.docx', 20, '2023-11-20 07:58:46'),
(200, 'Sasuke Uchiha is logging out', 20, '2023-11-20 18:43:25'),
(201, 'Administrator is logging in', 22, '2023-11-20 18:43:36'),
(202, 'Administrator is logging in', 22, '2023-11-21 17:05:33'),
(203, 'Administrator is logging out', 22, '2023-11-21 17:05:46'),
(204, 'Administrator is logging in', 22, '2023-11-21 17:06:18'),
(205, 'Administrator is logging in', 22, '2023-11-21 18:28:25'),
(206, 'Administrator liked the file Target Company.docx', 22, '2023-11-21 22:03:38'),
(207, 'Administrator unliked the file Target Company.docx', 22, '2023-11-21 22:03:39'),
(208, 'Administrator unliked the file SYSTEM VISION DOCUMENT.docx', 22, '2023-11-21 22:03:40'),
(209, 'Administrator liked the file SYSTEM VISION DOCUMENT.docx', 22, '2023-11-21 22:03:41'),
(210, 'Administrator is adding new user', 22, '2023-11-21 22:08:38'),
(211, 'Administrator is adding new user', 22, '2023-11-21 22:09:06'),
(212, 'Administrator is updating the user Sample 1', 22, '2023-11-21 22:55:07'),
(213, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:27:52'),
(214, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:28:09'),
(215, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:32:57'),
(216, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:34:09'),
(217, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:35:40'),
(218, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:38:55'),
(219, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:42:48'),
(220, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:44:06'),
(221, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:47:20'),
(222, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:49:37'),
(223, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 07:50:25'),
(224, 'Administrator is updating the user Naruto Uzumaki', 22, '2023-11-23 08:00:06'),
(225, 'Administrator is updating the user Naruto Uzumaki', 22, '2023-11-23 08:03:06'),
(226, 'Administrator is updating the user Naruto Uzumaki', 22, '2023-11-23 08:24:53'),
(227, 'Administrator is updating the user ', 22, '2023-11-23 08:24:53'),
(228, 'Administrator is updating the user ', 22, '2023-11-23 08:25:36'),
(229, 'Administrator is updating the user ', 22, '2023-11-23 08:25:36'),
(230, 'Administrator is updating the user ', 22, '2023-11-23 08:26:20'),
(231, 'Administrator is updating the user ', 22, '2023-11-23 08:26:20'),
(232, 'Administrator is updating the user ', 22, '2023-11-23 08:29:00'),
(233, 'Administrator is updating the user ', 22, '2023-11-23 08:30:15'),
(234, 'Administrator is updating the user Sasuke Uchiha', 22, '2023-11-23 08:31:49'),
(235, 'Administrator is updating the user Naruto Uzumaki', 22, '2023-11-23 10:03:53'),
(236, 'Administrator is deleting user Sample 2', 22, '2023-11-23 10:50:49'),
(237, 'Administrator is deleting user Sample 11', 22, '2023-11-23 11:02:34'),
(238, 'Administrator is adding new user', 22, '2023-11-23 11:44:15'),
(239, 'Administrator is deleting user Sample 1', 22, '2023-11-23 12:44:00'),
(240, 'Administrator is adding new user', 22, '2023-11-23 12:45:42'),
(241, 'Administrator is deleting user Sample 1', 22, '2023-11-23 12:45:47'),
(242, 'Administrator is adding new user', 22, '2023-11-23 12:45:52'),
(243, 'Administrator is deleting user Sample 1', 22, '2023-11-23 12:52:19'),
(244, 'Administrator is adding new user', 22, '2023-11-23 12:53:05'),
(245, 'Administrator is deleting user alsfjs', 22, '2023-11-23 12:53:15'),
(246, 'Administrator is adding new user', 22, '2023-11-23 12:53:58'),
(247, 'Administrator is deleting user alsfjs', 22, '2023-11-23 12:54:05'),
(248, 'Administrator is adding new user', 22, '2023-11-23 12:54:57'),
(249, 'Administrator is deleting user Sample 1', 22, '2023-11-23 12:55:03'),
(250, 'Administrator is adding new user', 22, '2023-11-23 12:55:05'),
(251, 'Administrator is deleting user Sample 1', 22, '2023-11-23 12:55:22'),
(252, 'Sponge Bob is logging in', 21, '2023-11-23 15:48:18'),
(253, 'Sponge Bob is logging in', 21, '2023-11-23 15:49:00'),
(254, 'Administrator is updating the user Naruto Uzumaki', 22, '2023-11-23 16:12:30'),
(255, 'Administrator is logging out', 22, '2023-11-23 16:13:07'),
(256, 'Administrator is logging in', 22, '2023-11-23 16:23:24'),
(257, 'Administrator is logging out', 22, '2023-11-23 16:24:02'),
(258, 'Administrator is logging in', 22, '2023-11-23 16:24:06'),
(259, 'Administrator is adding new user', 22, '2023-11-23 16:56:40'),
(260, 'Administrator is deleting user Sample1', 22, '2023-11-23 16:57:31'),
(261, 'Administrator is deleting user Sample 1', 22, '2023-11-23 16:58:38'),
(262, 'Administrator is deleting user Sample 2', 22, '2023-11-23 17:22:43'),
(263, 'Administrator is deleting user Sample 3', 22, '2023-11-23 17:22:48'),
(264, 'Administrator is deleting user Wordle', 22, '2023-11-23 17:31:41'),
(265, 'Administrator is deleting user Sample 1', 22, '2023-11-23 20:07:36'),
(266, 'Administrator is deleting user Holy 3', 22, '2023-11-23 20:12:56'),
(267, 'Administrator is adding new user', 22, '2023-11-23 21:12:46'),
(268, 'Administrator is adding new user', 22, '2023-11-23 21:16:17'),
(269, 'Administrator is updating the user Administrator', 22, '2023-11-23 22:16:11'),
(270, 'Sponge Bob is logging in', 21, '2023-11-24 05:53:53'),
(271, 'Sponge Bob liked the file Student-Portfolio.pdf', 21, '2023-11-24 06:34:45'),
(272, 'Sponge Bob liked the file Target Company.docx', 21, '2023-11-24 06:34:49'),
(273, 'Admin is updating the user naruto uzumaki', 22, '2023-11-24 08:18:24'),
(274, 'Admin is updating the user naruto uzumaki', 22, '2023-11-24 08:18:55'),
(275, 'Admin is logging in', 22, '2023-11-24 08:30:39'),
(276, 'Admin is updating the user Naruto Uzumaki', 22, '2023-11-24 09:40:12'),
(277, 'Admin is updating the user Sasuke Uchiha', 22, '2023-11-24 09:45:17'),
(278, 'Admin is deleting user Sample 1', 22, '2023-11-24 11:14:10'),
(279, 'Admin is updating the user naruto uzumaki', 22, '2023-11-24 11:18:02'),
(280, 'Admin is downloading SYSTEM VISION DOCUMENT.docx', 22, '2023-11-24 12:09:35'),
(281, 'Admin is downloading Target Company.docx', 22, '2023-11-24 12:32:07'),
(282, 'Admin is downloading Target Company.docx', 22, '2023-11-24 12:51:52'),
(283, 'Admin is downloading SYSTEM VISION DOCUMENT.docx', 22, '2023-11-24 12:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE `download` (
  `id` int(11) NOT NULL,
  `download` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `download`
--

INSERT INTO `download` (`id`, `download`, `user_id`, `file_id`, `date`) VALUES
(9, 1, 22, 4, '2023-11-19 07:58:12'),
(10, 1, 22, 4, '2023-11-19 07:58:16'),
(11, 1, 22, 8, '2023-11-20 07:58:19'),
(12, 1, 22, 1, '2023-11-20 07:58:25'),
(13, 1, 20, 8, '2023-11-20 07:58:37'),
(14, 1, 20, 4, '2023-11-20 07:58:42'),
(15, 1, 20, 1, '2023-11-20 07:58:46'),
(16, 1, 22, 8, '2023-11-24 12:09:35'),
(17, 1, 22, 1, '2023-11-24 12:32:07'),
(18, 1, 22, 1, '2023-11-24 12:51:52'),
(19, 1, 22, 8, '2023-11-24 12:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `id_num` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phoneNumber` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `id_num`, `name`, `phoneNumber`, `email`, `status`, `password`, `date`) VALUES
(18, '20-11', 'Naruto Uzumaki', '0912812221', 'naruto49202@w.com', 'user', '123', '2023-10-25 18:13:05'),
(20, '11-11', 'Sasuke Uchiha', '099811433', 'uchihasasuke@gmail.com', 'user', '123', '2023-10-26 06:28:03'),
(21, '21-11002', 'Sponge Bob', '992299111', 'sponge@patrick.star', 'user', 'sponge', '2023-10-26 21:57:08'),
(22, 'admin', 'Admin', '99122', 'admin@gmail.com', 'admin', 'admin', '2023-10-27 06:42:04'),
(31, '21-10162', 'naruto uzumaki', '09098619685', 'somen49202@wisnick.com', 'user', '123', '2023-11-23 21:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `liked` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `file_id`, `liked`, `date`) VALUES
(35, 20, 4, 1, '2023-11-20 07:53:51'),
(36, 20, 1, 1, '2023-11-20 07:53:57'),
(37, 22, 4, 1, '2023-11-20 07:54:03'),
(38, 22, 8, 1, '2023-11-20 07:54:04'),
(39, 22, 1, 0, '2023-11-21 22:03:38'),
(40, 21, 4, 1, '2023-11-24 06:34:45'),
(41, 21, 1, 1, '2023-11-24 06:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `yr_level` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `about` varchar(255) NOT NULL,
  `image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `yr_level`, `course`, `about`, `image_path`) VALUES
(1, 18, '3rd Year', 'BSBA', 'Hi! I am naruto uzomaki. A hidden leaf ninja', ''),
(2, 20, '3rd Year', 'BSIT-Programming', 'Hi i am Sasuke Uchiha. One of the greatest shinobi in hidden leaf village.', ''),
(3, 21, '', '', '', ''),
(4, 22, '', '', '', ''),
(7, 31, '2nd Year', 'BSIT-Programming', 'Just a normal day, coding and trying to fix the bugs.', '');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `file_id`, `rate`, `date`) VALUES
(5, 20, 1, '4.00', '2023-11-20 07:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `download_count` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `file_name`, `file_type`, `file_path`, `download_count`, `date`) VALUES
(1, 'Target Company.docx', 'docx', 'Target Company.docx', 6, '2023-11-09 06:29:59'),
(4, 'Student-Portfolio.pdf', 'pdf', '1699538160_Student-Portfolio.pdf', 6, '2023-11-09 21:56:18'),
(8, 'SYSTEM VISION DOCUMENT.docx', 'docx', '1699539660_SYSTEM VISION DOCUMENT.docx', 5, '2023-11-09 22:21:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_user_id` (`user_id`);

--
-- Indexes for table `download`
--
ALTER TABLE `download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_uploaded_files` (`file_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_file_id` (`file_id`),
  ADD KEY `rate_user_id` (`user_id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `download`
--
ALTER TABLE `download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_uploaded_files` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `info` (`id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_file_id` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`id`),
  ADD CONSTRAINT `rate_user_id` FOREIGN KEY (`user_id`) REFERENCES `info` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
