-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 11:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `first_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `roles_name`, `status`) VALUES
(3, 'MMSA', 'admin@admin.com', '$2y$10$UvAsUXeNypbGSO6hlfpsRew1IeLCSgZ19PkpoyZZlLRLtys2LDyyG', '\"admin\"', '1'),
(5, 'mohammed', 'mohammed@gmail.com', '$2y$10$umcEouADALDV4CWmH2BraupE6UB4O6JCB648PjnJhMHyXJ0Bty4mq', '\"\\u0627\\u0636\\u0627\\u0641\\u0629 \\u0637\\u0644\\u0627\\u0628\"', '0');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_23_121011_create_permission_tables', 2),
(11, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(12, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(13, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(14, '2016_06_01_000004_create_oauth_clients_table', 3),
(15, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(8, 'App\\Models\\Dashboard\\Admin', 3),
(9, 'App\\Models\\Dashboard\\Admin', 5);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('8f55f27dcfaeabbcf2bfa64945f42de2bc4d8eafcc8c716199db6310b808c3bf06aba3d2f80c7178', 12, 1, 'm2922822@gmail.com', '[]', 0, '2024-11-30 08:06:21', '2024-11-30 08:06:21', '2025-11-30 10:06:21'),
('c35e921feaafc756ee90679b258dfe52e4f036317fbd7308b873fdc14ff8a834d997602b68aa4d28', 12, 1, 'm2922822@gmail.com', '[]', 1, '2024-11-30 08:01:09', '2024-11-30 08:04:20', '2025-11-30 10:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'fbgUbzwV4orYk4mGS5QieeEWvAikwXvsCKprOSML', NULL, 'http://localhost', 1, 0, 0, '2024-11-30 07:30:40', '2024-11-30 07:30:40'),
(2, NULL, 'Laravel Password Grant Client', 'PKMeSxrVSxaUiSYXhOEaizYzfqJdSCXTD8WlI0JW', 'users', 'http://localhost', 0, 1, 0, '2024-11-30 07:30:40', '2024-11-30 07:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-11-30 07:30:40', '2024-11-30 07:30:40');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `parent`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'الطلاب', 0, 'web', NULL, NULL),
(2, 'اضافة طالب', 1, 'web', NULL, NULL),
(3, 'تعديل طالب', 1, 'web', NULL, NULL),
(4, 'حذف طالب', 1, 'web', NULL, NULL),
(5, 'الصلاحيات', 0, 'web', NULL, NULL),
(6, 'فريق النظام', 0, 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 5, 'm@gmail.com', '310b02abcec5e13862e909d9ad9987bc53fe84d61fe6ec65528144a758fa92fe', '[\"*\"]', NULL, NULL, '2024-11-27 09:44:59', '2024-11-27 09:44:59'),
(2, 'App\\Models\\User', 6, 'm2@gmail.com', '5c14a84ea63bc68cfbdbe1d4987660c78d479da26a1b235a36fc6d9ccd9f3b58', '[\"*\"]', NULL, NULL, '2024-11-27 09:46:56', '2024-11-27 09:46:56'),
(3, 'App\\Models\\User', 7, 'm22@gmail.com', '246ba1da7bb726b0aa5799411733a6736bdcfaf6092aeca49b5573026f574741', '[\"*\"]', NULL, NULL, '2024-11-27 09:50:10', '2024-11-27 09:50:10'),
(4, 'App\\Models\\User', 8, 'm282@gmail.com', 'a016effaaff22225a8e2cc416ef756d98a1f8aa4ea9cd1a496b6cab7ca5222bc', '[\"*\"]', NULL, NULL, '2024-11-27 09:52:00', '2024-11-27 09:52:00'),
(5, 'App\\Models\\User', 9, 'm2282@gmail.com', 'aaa4383bccbcd6494dc0873901aeaa1dbd1dffd18c062f91407e733270ff7d9b', '[\"*\"]', NULL, NULL, '2024-11-27 10:09:45', '2024-11-27 10:09:45'),
(6, 'App\\Models\\User', 9, 'm2282@gmail.com', 'e798aae9810c94e5fbf1b20c2d4dc9f8d2ec7e2c453f339c8ec541e85d9f8019', '[\"*\"]', NULL, NULL, '2024-11-30 06:46:53', '2024-11-30 06:46:53'),
(7, 'App\\Models\\User', 9, 'm2282@gmail.com', '83af14f387c72df6e5c4e8ebb3eecc0323df94ef996b2567cd5e4bf7627ab311', '[\"*\"]', NULL, NULL, '2024-11-30 06:52:07', '2024-11-30 06:52:07'),
(8, 'App\\Models\\User', 9, 'm2282@gmail.com', '8871ee263eea9a5fa1f53861d253b8526af139f84175b678318f04da5adfb754', '[\"*\"]', NULL, NULL, '2024-11-30 07:11:40', '2024-11-30 07:11:40'),
(9, 'App\\Models\\User', 10, 'm22822@gmail.com', '08a6f31711702009683764e3a5f5983a7848b1f4ab78f738d2fe52853988a354', '[\"*\"]', NULL, NULL, '2024-11-30 07:31:51', '2024-11-30 07:31:51'),
(10, 'App\\Models\\User', 11, 'm222822@gmail.com', '9962aae11db899ac34ac68bfd7e862bcc78c6d9e007545705598e988a17e8b48', '[\"*\"]', NULL, NULL, '2024-11-30 07:54:35', '2024-11-30 07:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(8, 'admin', 'web', '2024-11-26 07:07:47', '2024-11-26 07:07:47'),
(9, 'اضافة طلاب', 'web', '2024-11-26 08:40:56', '2024-11-26 08:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 8),
(1, 9),
(2, 8),
(2, 9),
(3, 8),
(4, 8),
(5, 8),
(6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_view` int(5) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `is_view`, `image`) VALUES
(9, 'sdf', 0, '14885073download.png'),
(10, 'بليبل', 0, '839389channels4_profile (1).jpg'),
(21, '4444', 1, '4205952channels4_profile (1).jpg'),
(22, 'ببب', 0, '16781501channels4_profile.jpg'),
(23, 'fdsfs', 1, '15904715download.png'),
(24, 'gg', 1, '14972318channels4_profile (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `fcm_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mohammed', 'mohamed@gmail.com', NULL, '$2y$10$otDDiWHxNPsF3UMYfDjZHu1tRBL8PKvvWRj1RGz5vLv9KBMC9VJjS', NULL, NULL, '2024-11-20 08:21:38', '2024-11-20 08:21:38'),
(2, 'sdfsdfsd', 'asdf@asdf.com', NULL, '$2y$10$FT3hjx3d8BCi3nkhllkWb.iS1FkdDCKSG13DD6f6FsetwYxDvw3Z6', NULL, NULL, '2024-11-20 09:45:21', '2024-11-20 09:45:21'),
(3, 'ahmed', 'ahmed@gmail.com', NULL, '$2y$10$kPVE1wE2QI.zMuuqtGItoOAJDsrB6fdZOUBvJQeGdn541V4HWQIFy', NULL, NULL, '2024-11-20 11:05:16', '2024-11-20 11:05:16'),
(4, 'mohammed', 'mohammed@gmail.com', NULL, '$2y$10$nQ2jzP8qXgn/kt1H6QNmL.8TYy3f85kWvmYycz1sQnFixQp2UX3mS', NULL, NULL, '2024-11-21 06:23:47', '2024-11-21 06:23:47'),
(5, 'محمد', 'm@gmail.com', NULL, '$2y$10$z.apTUzPcNJAPz29KvyAPuWbuH6gRkNXCMUMZFZUnfPAg6CJSCyVi', '34dfg523333e22332', NULL, '2024-11-27 09:44:59', '2024-11-27 09:44:59'),
(6, 'محمد', 'm2@gmail.com', NULL, '$2y$10$eQS7vhjIO/E5TZXIaT1li.8aheUmru3Kuolx1KrTtiRDd3Sn5Mhyu', '34dfg523333e22332', NULL, '2024-11-27 09:46:56', '2024-11-27 09:46:56'),
(7, 'محمد', 'm22@gmail.com', NULL, '$2y$10$XGDoM8BIQQe9Y7uOmVjQtezh7iNrQqCGsFOynkNXJVRXz6Rs6Nta6', '34dfg523333e22332', NULL, '2024-11-27 09:50:10', '2024-11-27 09:50:10'),
(8, 'محمد', 'm282@gmail.com', NULL, '$2y$10$.kkuIDTOMoLnnbZuBuFHHeUNmX44rUO3erIvvprPe/QICS1.b6ICu', '34dfg523333e22332', NULL, '2024-11-27 09:52:00', '2024-11-27 09:52:00'),
(9, 'محمد', 'm2282@gmail.com', NULL, '$2y$10$rWs.gYGc9lAntkCamoBTkuyfVagnFNECPAUHQThs2xTxPxgztTF7.', 'fgsfgsdfg', NULL, '2024-11-27 10:09:45', '2024-11-30 06:46:53'),
(10, 'محمد', 'm22822@gmail.com', NULL, '$2y$10$OpxP1iO1zoU.ExvJs7HjBOSN7BnQHqUCNIseGckT1/3NMnVoAitby', '34dfg523333e22332', NULL, '2024-11-30 07:31:51', '2024-11-30 07:31:51'),
(11, 'محمد', 'm222822@gmail.com', NULL, '$2y$10$hjUUI7lh2dT0RptK7zwhm.3cTeR06aIku7nmnclE1VMomp0mfplfu', '34dfg523333e22332', NULL, '2024-11-30 07:54:35', '2024-11-30 07:54:35'),
(12, 'محمد', 'm2922822@gmail.com', NULL, '$2y$10$OYXCK1D198AvLmy/9KKjsuxhK8PzkGTuc2RNNAp1n4DQabPJkn0hq', 'fgsfgsdfg', NULL, '2024-11-30 08:01:09', '2024-11-30 08:06:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
