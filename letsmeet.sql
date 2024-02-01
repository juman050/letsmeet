-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2019 at 01:03 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letsmeet`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL,
  `activity_name` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL,
  `activity_start` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `activity_name`, `location_id`, `activity_start`, `created_at`, `updated_at`) VALUES
(4, 'Laravel open talk', 9, '2018-09-25 00:00:00', '2018-08-10 08:19:18', '2018-09-25 16:58:08'),
(5, 'stackoverflow', 3, '09/27/2018 12:00 AM', '2018-08-10 08:19:18', '2018-09-27 06:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment_text`, `parent_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'fkh', 0, 41, '2018-08-29 12:52:03', '2018-08-29 12:52:03'),
(2, 1, 'dfsdfdsf', 0, 42, '2018-08-29 12:53:09', '2018-08-29 12:53:09'),
(3, 1, 'adasd', 0, 43, '2018-08-29 12:54:48', '2018-08-29 12:54:48'),
(4, 1, 'asdasd', 3, 43, '2018-08-29 12:54:54', '2018-08-29 12:54:54'),
(5, 1, 'sadsad', 0, 43, '2018-08-29 12:54:58', '2018-08-29 12:54:58'),
(6, 1, 'sdfsdfds', 0, 32, '2018-10-07 02:39:45', '2018-10-07 02:39:45'),
(7, 1, 'AASA', 0, 33, '2018-12-24 22:43:38', '2018-12-24 22:43:38'),
(8, 1, 'dfdgdfg', 0, 32, '2019-03-14 06:39:11', '2019-03-14 06:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_one`, `user_two`, `status`, `created_at`) VALUES
(1, 1, 2, 0, '2018-08-23 04:07:10'),
(2, 1, 3, 0, '2018-08-23 05:12:11'),
(3, 1, 4, 0, '2018-12-25 04:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `follow_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `user_id`, `follow_id`, `created_at`, `updated_at`) VALUES
(10, 3, 1, NULL, NULL),
(11, 3, 2, NULL, NULL),
(14, 1, 2, NULL, NULL),
(15, 1, 3, NULL, NULL),
(16, 1, 4, NULL, NULL),
(17, 1, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(17, 1, 12),
(18, 1, 14),
(19, 1, 18),
(21, 1, 24),
(24, 1, 17),
(28, 1, 42),
(29, 1, 43),
(30, 1, 26),
(32, 1, 33),
(35, 1, 31);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `name`, `address`, `city`) VALUES
(1, 'Sylhet metroplitan university', 'zindabazar', 'Sylhet'),
(2, 'Leading University Sylhet', 'Sylhet', 'Sylhet'),
(3, 'Panshi ', 'jollarpar', 'sylhet'),
(4, 'Sust', 'akhalia', 'Sylhet'),
(5, 'Noorjahan ', 'dorga gate', 'sylhet'),
(6, 'Pizza hut', 'sylhet', 'Sylhet'),
(7, 'yummy hut', '', ''),
(8, 'KFC zindabazar', '', ''),
(9, 'Woondal restaurant', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `meetusers`
--

CREATE TABLE `meetusers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about_you` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meetusers`
--

INSERT INTO `meetusers` (`id`, `name`, `email`, `username`, `password`, `user_photo`, `gender`, `about_you`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'juman', 'juman@gmail.com', 'juman', 'e10adc3949ba59abbe56e057f20f883e', '1534106715.jpg', 'male', 'I''m not perfect and I don''t want to try to be perfect. -_-', NULL, '2018-05-22 12:41:16', '2018-08-12 14:45:15'),
(2, 'john', 'john@gmail.com', 'john', 'e10adc3949ba59abbe56e057f20f883e', '', 'male', NULL, NULL, '2018-06-01 06:01:20', '2018-06-01 06:01:20'),
(3, 'adam', 'adam@gmail.com', 'adam', 'e10adc3949ba59abbe56e057f20f883e', '', 'male', 'my name is adam!!!!!', NULL, '2018-08-11 13:29:24', '2018-08-11 13:51:41'),
(4, 'rolf hegdal', 'rolf@info.com', 'rolf123', '123456', '', 'male', NULL, NULL, '2018-08-11 13:29:24', '2018-08-11 13:29:24'),
(5, 'Mr. Ellie Legros', 'Billy@melany.com', 'Billy@melan', 'Billy@melany.com', '', 'male', NULL, NULL, '2018-09-24 23:00:00', '2018-09-24 23:00:00'),
(6, 'Berta Gleason', 'Stephon.Armstrong@lue.biz', 'Stephon.Armstrong', 'Stephon.Armstrong@lue.biz', '', 'male', 'hi i''m Stephon.Armstrong', NULL, '2018-09-24 00:10:00', '2018-09-24 00:10:00'),
(7, 'Alverta Frami', 'Garrett@camden.us', 'Garrett@camden', 'Garrett@camden.us', '', 'male', NULL, NULL, '2018-09-25 01:10:00', '2018-09-25 01:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_from`, `user_to`, `conversation_id`, `msg`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 2, 'hlw adam', 1, '2018-08-23 04:11:11', '2018-08-23 04:11:11'),
(2, 3, 1, 2, 'hi juman', 1, '2018-08-24 01:00:00', '2018-08-24 01:00:00'),
(6, 1, 3, 2, 'You are running Vue in development mode.', 1, '2018-08-24 10:04:02', '2018-08-24 10:04:02'),
(7, 1, 2, 1, 'kaj choliteche', 1, '2018-08-24 02:07:00', '2018-08-24 02:07:00'),
(8, 1, 3, 2, 'hahahha', 1, '2018-09-08 09:33:24', '2018-09-08 09:33:24'),
(9, 1, 3, 2, 'asdasdas', 1, '2018-10-07 08:41:26', '2018-10-07 08:41:26'),
(10, 1, 4, 3, 'HUGYUIN', 1, '2018-12-25 04:46:04', '2018-12-25 04:46:04'),
(11, 1, 4, 3, 'FBFBBF', 1, '2018-12-25 04:46:13', '2018-12-25 04:46:13'),
(12, 1, 4, 3, 'fsfsdfsd', 1, '2019-03-14 12:36:45', '2019-03-14 12:36:45'),
(13, 1, 4, 3, 'fsdf', 1, '2019-03-14 12:36:47', '2019-03-14 12:36:47'),
(14, 1, 3, 2, 'sdfsdfds', 1, '2019-03-14 12:36:51', '2019-03-14 12:36:51'),
(15, 1, 3, 2, 'sdfsdfsd', 1, '2019-03-14 12:36:55', '2019-03-14 12:36:55'),
(16, 1, 2, 1, 'sdfsdf', 1, '2019-03-14 12:37:03', '2019-03-14 12:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2018_05_19_181251_create_meetusers_table', 2),
(11, '2018_05_22_180258_create_users_table', 2),
(12, '2018_05_27_193608_create_posts_table', 3),
(13, '2018_08_10_135821_create_follows_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `post_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `body`, `post_type`, `created_at`, `updated_at`) VALUES
(13, 2, 'user id 2', 'text', '2018-08-10 02:19:18', '2018-08-10 02:19:18'),
(15, 3, 'hi', 'text', '2018-08-11 13:31:37', '2018-08-11 13:31:37'),
(16, 3, 'hlw letsmeet!!!!!!!!!!', 'text', '2018-08-11 13:52:13', '2018-08-11 13:52:13'),
(17, 3, 'i''m happy now.', 'text', '2018-08-11 13:52:23', '2018-08-11 13:52:23'),
(26, 1, 'আমেরিকার এক রেস্তোঁরা ভবন থেকে মেক্সিকোর এক শোবার ঘর পর্যন্ত কাটা হয়েছে মাদক পাচার সুড়ঙ্গ।', 'text', '2018-08-25 00:51:54', '2018-08-25 00:51:54'),
(27, 1, '<div class="feed-info-box"><div class="video-container">\r\n				<iframe width="500" height="300" \r\n				src="//www.youtube.com/embed/VZ_i2yk5kFk?autohide=1" frameborder="0" allowfullscreen></iframe>\r\n				</div></div>', 'link', '2018-10-06 09:34:19', '2018-10-06 09:34:19'),
(31, 1, '<div class="feed-info-box"><div class="url-frame"><b><a href="http://www.w3schools.com/html/html_formatting.asp" target="_blank">HTML Text Formatting</a></b><div class="feed-info-box-url"><p>http://www.w3schools.com/html/html_formatting.asp</p></div> Well organized and easy to understand Web building tutorials with lots of examples of how to use HTML, CSS, JavaScript, SQL, PHP, and XML.</div></div>', 'link', '2018-10-06 10:22:04', '2018-10-06 10:22:04'),
(32, 1, '<div class="feed-info-box"><div class="url-frame"><b><a href="http://www.google.com/search?q=laravel+notification+package&rlz=1C1CHWL_enBD761BD761&oq=larvel+notifica&aqs=chrome.4.69i57j0l5.9012j0j7&sourceid=chrome&ie=UTF-8" target="_blank">laravel notification package - Google &#2488;&#2494;&#2480;&#2509;&#2458;</a></b><div class="feed-info-box-url"><p>http://www.google.com/search?q=laravel+notification+package&rlz=1C1CHWL_enBD761BD761&oq=larvel+notifica&aqs=chrome.4.69i57j0l5.9012j0j7&sourceid=chrome&ie=UTF-8</p></div></div></div>', 'link', '2018-10-06 11:00:04', '2018-10-06 11:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_activity`
--

CREATE TABLE `users_activity` (
  `user_activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `activity_status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_activity`
--

INSERT INTO `users_activity` (`user_activity_id`, `user_id`, `activity_id`, `activity_status`) VALUES
(4, 1, 4, 0),
(5, 2, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_invites`
--

CREATE TABLE `users_invites` (
  `invite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `response` enum('going','not_going','pending') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_invites`
--

INSERT INTO `users_invites` (`invite_id`, `user_id`, `activity_id`, `response`) VALUES
(5, 2, 4, 'not_going'),
(6, 1, 5, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_user_id_foreign` (`user_id`),
  ADD KEY `follows_follow_id_foreign` (`follow_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `meetusers`
--
ALTER TABLE `meetusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meetusers_email_unique` (`email`),
  ADD UNIQUE KEY `meetusers_username_unique` (`username`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `users_activity`
--
ALTER TABLE `users_activity`
  ADD PRIMARY KEY (`user_activity_id`);

--
-- Indexes for table `users_invites`
--
ALTER TABLE `users_invites`
  ADD PRIMARY KEY (`invite_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `meetusers`
--
ALTER TABLE `meetusers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_activity`
--
ALTER TABLE `users_activity`
  MODIFY `user_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users_invites`
--
ALTER TABLE `users_invites`
  MODIFY `invite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_follow_id_foreign` FOREIGN KEY (`follow_id`) REFERENCES `meetusers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `meetusers` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
