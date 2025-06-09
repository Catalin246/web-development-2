-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 09, 2025 at 07:42 AM
-- Server version: 11.7.2-MariaDB-ubu2404
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `type` enum('group','normal') NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_participants`
--

CREATE TABLE `chat_participants` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `status`, `created_at`, `updated_at`) VALUES
(9, 15, 16, 'accepted', '2025-05-29 14:28:24', '2025-05-29 14:28:56'),
(10, 15, 17, 'accepted', '2025-05-29 14:28:26', '2025-05-29 14:29:00'),
(11, 15, 18, 'accepted', '2025-05-29 14:28:28', '2025-05-29 14:29:03'),
(12, 15, 19, 'accepted', '2025-05-29 14:28:29', '2025-05-29 14:29:05'),
(13, 15, 20, 'declined', '2025-05-29 14:28:31', '2025-05-29 14:29:08'),
(15, 21, 15, 'pending', '2025-05-29 14:32:09', '2025-05-29 14:32:09'),
(16, 24, 15, 'pending', '2025-05-29 14:33:27', '2025-05-29 14:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Active',
  `about` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'https://randomuser.me/api/portraits/lego/4.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `status`, `about`, `avatar`) VALUES
(15, 'Alice Johnson', 'alice@example.com', '$2y$12$Lcb1WDhh5fGlrHROwfWGHuaL3xzwWwPjCFyWrlzThf81/l47MA6/u', '2025-05-29 14:16:52', 'Active', 'Loves hiking and outdoor adventures.', 'https://randomuser.me/api/portraits/women/1.jpg'),
(16, 'Bob Smith', 'bob@example.com', '$2y$12$YHgiJvB0upV1snoohc/Scu.7wYuZgntUN8/joJOLaS1.a6XW9K3D.', '2025-05-29 14:17:03', 'Active', 'Avid reader and coffee enthusiast.', 'https://randomuser.me/api/portraits/men/1.jpg'),
(17, 'Charlie Lee', 'charlie@example.com', '$2y$12$H5OO5PX.O7E/Da2Lf0nfp.FEC9iyeyCPdooR..JgMd07HtQzmrD4G', '2025-05-29 14:17:14', 'Active', 'Tech geek and gamer.', 'https://randomuser.me/api/portraits/men/2.jpg'),
(18, 'Diana Prince', 'diana@example.com', '$2y$12$HUGfCjRc71lQgcZihtxAP.oIn09FP1ghm/r9oizBMr0FS1ZGo/hKe', '2025-05-29 14:17:46', 'Active', 'Yoga instructor and wellness advocate.', 'https://randomuser.me/api/portraits/women/2.jpg'),
(19, 'Ethan Hunt', 'ethan@example.com', '$2y$12$41JMGO4OHYnQi.0a0XC02ObRSb6hzEyF8DL6h/kSPe8Gj9DoAJITO', '2025-05-29 14:17:58', 'Active', 'Traveler and photography lover.', 'https://randomuser.me/api/portraits/men/3.jpg'),
(20, 'Fiona Glenanne', 'fiona@example.com', '$2y$12$RC9pA3TJsud5Z5GpCrjxoOvxA9DQcba03rixD/V9fcQ2LNzLE8n6u', '2025-05-29 14:18:32', 'Active', 'Chef and food blogger.', 'https://randomuser.me/api/portraits/women/3.jpg'),
(21, 'George Clooney', 'george@example.com', '$2y$12$rtYXd00cc3GAiv6ViadlVu9EqKyszZBUDAErLfEcce7LCvFFpz1ou', '2025-05-29 14:18:43', 'Active', 'Movie buff and amateur filmmaker.', 'https://randomuser.me/api/portraits/men/4.jpg'),
(22, 'Hannah Montana', 'hannah@example.com', '$2y$12$GyRXAaPC8VOc5ckHEGPRLulOhsH3dbziKz.C6xLlmtpVwG8kbAgCO', '2025-05-29 14:18:50', 'Busy', 'Musician and songwriter.', 'https://randomuser.me/api/portraits/women/4.jpg'),
(23, 'Ian Somerhalder', 'ian@example.com', '$2y$12$/NKmPLwYb.67GRC2rZ1nTu6hRNIw3Lq1nxo/shu1tx4lw/B/gNIj.', '2025-05-29 14:18:59', 'Active', 'Environmental activist.', 'https://randomuser.me/api/portraits/men/5.jpg'),
(24, 'Julia Roberts', 'julia@example.com', '$2y$12$sYkT8XQbpz0N2wc6ES7Yq.gBKqlXgUJxnafN5CtUInhLgGzXR.JW2', '2025-05-29 14:19:09', 'Active', 'Actress and humanitarian.', 'https://randomuser.me/api/portraits/women/5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `user_id` int(11) NOT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT 1,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `privacy_mode` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`user_id`, `notifications`, `dark_mode`, `privacy_mode`, `created_at`, `updated_at`) VALUES
(15, 1, 1, 1, '2025-05-29 15:18:09', '2025-05-29 16:29:26'),
(16, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(17, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(18, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(19, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(20, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(21, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:37:55'),
(22, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(23, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09'),
(24, 1, 0, 0, '2025-05-29 15:18:09', '2025-05-29 15:18:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD PRIMARY KEY (`chat_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_request` (`sender_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD CONSTRAINT `chat_participants_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `friend_requests_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_requests_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
