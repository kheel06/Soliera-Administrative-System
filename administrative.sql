-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2026 at 01:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administrative`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_logs`
--

CREATE TABLE `access_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_logs`
--

INSERT INTO `access_logs` (`id`, `user_id`, `document_id`, `action`, `description`, `metadata`, `created_at`, `updated_at`) VALUES
(754, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-15 16:59:06', '2025-09-15 16:59:06'),
(755, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-15 17:00:00', '2025-09-15 17:00:00'),
(756, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-15 17:00:17', '2025-09-15 17:00:17'),
(757, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-15 17:03:58', '2025-09-15 17:03:58'),
(758, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-15 17:13:07', '2025-09-15 17:13:07'),
(759, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2025-09-15 17:14:06', '2025-09-15 17:14:06'),
(760, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2025-09-15 17:14:09', '2025-09-15 17:14:09'),
(761, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-15 17:14:31', '2025-09-15 17:14:31'),
(762, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-15 17:55:18', '2025-09-15 17:55:18'),
(763, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-15 18:01:43', '2025-09-15 18:01:43'),
(764, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-16 13:16:29', '2025-09-16 13:16:29'),
(765, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-16 19:14:24', '2025-09-16 19:14:24'),
(766, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-16 20:17:51', '2025-09-16 20:17:51'),
(767, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-16 20:24:52', '2025-09-16 20:24:52'),
(768, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:37:51', '2025-09-16 20:37:51'),
(769, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:39:22', '2025-09-16 20:39:22'),
(770, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:40:58', '2025-09-16 20:40:58'),
(771, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:41:08', '2025-09-16 20:41:08'),
(772, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:41:42', '2025-09-16 20:41:42'),
(773, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:43:19', '2025-09-16 20:43:19'),
(774, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:43:36', '2025-09-16 20:43:36'),
(775, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 20:45:41', '2025-09-16 20:45:41'),
(776, '2', NULL, 'approve_legal_case', 'Approved legal case ID 14', NULL, '2025-09-16 21:12:10', '2025-09-16 21:12:10'),
(777, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 1', NULL, '2025-09-16 21:18:05', '2025-09-16 21:18:05'),
(778, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 3', NULL, '2025-09-16 21:18:18', '2025-09-16 21:18:18'),
(779, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 4', NULL, '2025-09-16 21:25:20', '2025-09-16 21:25:20'),
(780, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 7', NULL, '2025-09-16 21:25:22', '2025-09-16 21:25:22'),
(781, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 6', NULL, '2025-09-16 21:25:51', '2025-09-16 21:25:51'),
(782, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 8', NULL, '2025-09-16 21:26:20', '2025-09-16 21:26:20'),
(783, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 10', NULL, '2025-09-16 21:27:05', '2025-09-16 21:27:05'),
(784, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 13', NULL, '2025-09-16 21:27:07', '2025-09-16 21:27:07'),
(785, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 12', NULL, '2025-09-16 21:27:10', '2025-09-16 21:27:10'),
(786, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 15', NULL, '2025-09-16 21:28:28', '2025-09-16 21:28:28'),
(787, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 14', NULL, '2025-09-16 21:29:50', '2025-09-16 21:29:50'),
(788, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-16 21:43:04', '2025-09-16 21:43:04'),
(789, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 22:29:52', '2025-09-16 22:29:52'),
(790, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 16', NULL, '2025-09-16 23:13:30', '2025-09-16 23:13:30'),
(791, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 18', NULL, '2025-09-16 23:13:47', '2025-09-16 23:13:47'),
(792, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 21', NULL, '2025-09-16 23:17:15', '2025-09-16 23:17:15'),
(793, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 20', NULL, '2025-09-16 23:21:49', '2025-09-16 23:21:49'),
(794, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:22:39', '2025-09-16 23:22:39'),
(795, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:22:54', '2025-09-16 23:22:54'),
(796, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:23:21', '2025-09-16 23:23:21'),
(797, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:24:59', '2025-09-16 23:24:59'),
(798, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:25:36', '2025-09-16 23:25:36'),
(799, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:25:44', '2025-09-16 23:25:44'),
(800, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:26:12', '2025-09-16 23:26:12'),
(801, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:28:10', '2025-09-16 23:28:10'),
(802, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:35:18', '2025-09-16 23:35:18'),
(803, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:35:48', '2025-09-16 23:35:48'),
(804, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-16 23:37:03', '2025-09-16 23:37:03'),
(805, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 04:46:04', '2025-09-17 04:46:04'),
(806, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-17 04:46:24', '2025-09-17 04:46:24'),
(807, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-17 04:46:35', '2025-09-17 04:46:35'),
(808, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 04:49:07', '2025-09-17 04:49:07'),
(809, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-17 04:49:12', '2025-09-17 04:49:12'),
(810, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 04:51:34', '2025-09-17 04:51:34'),
(811, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-17 04:51:38', '2025-09-17 04:51:38'),
(812, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 04:51:49', '2025-09-17 04:51:49'),
(813, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 04:54:10', '2025-09-17 04:54:10'),
(814, '2', NULL, 'legal_document_deleted', 'Deleted legal document: Employment Contract Template', NULL, '2025-09-17 04:54:19', '2025-09-17 04:54:19'),
(815, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 07:18:02', '2025-09-17 07:18:02'),
(816, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 07:39:15', '2025-09-17 07:39:15'),
(817, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 07:40:41', '2025-09-17 07:40:41'),
(818, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 07:41:10', '2025-09-17 07:41:10'),
(819, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 07:44:50', '2025-09-17 07:44:50'),
(820, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 07:46:25', '2025-09-17 07:46:25'),
(821, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 11:32:18', '2025-09-17 11:32:18'),
(822, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 15:35:00', '2025-09-17 15:35:00'),
(823, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 15:35:57', '2025-09-17 15:35:57'),
(824, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 15:58:43', '2025-09-17 15:58:43'),
(825, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 16:02:42', '2025-09-17 16:02:42'),
(826, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 16:19:28', '2025-09-17 16:19:28'),
(827, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 16:20:01', '2025-09-17 16:20:01'),
(828, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-17 16:29:53', '2025-09-17 16:29:53'),
(829, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 16:30:28', '2025-09-17 16:30:28'),
(830, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-09-17 17:27:26', '2025-09-17 17:27:26'),
(831, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-09-17 17:29:40', '2025-09-17 17:29:40'),
(832, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 17:33:28', '2025-09-17 17:33:28'),
(833, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 17:35:04', '2025-09-17 17:35:04'),
(834, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2025-09-17 17:35:31', '2025-09-17 17:35:31'),
(835, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 17:53:24', '2025-09-17 17:53:24'),
(836, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-09-17 17:56:21', '2025-09-17 17:56:21'),
(837, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-17 17:59:38', '2025-09-17 17:59:38'),
(838, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-09-17 18:12:04', '2025-09-17 18:12:04'),
(839, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-09-17 18:15:04', '2025-09-17 18:15:04'),
(840, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 18:18:21', '2025-09-17 18:18:21'),
(841, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:27:07', '2025-09-17 19:27:07'),
(842, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:27:12', '2025-09-17 19:27:12'),
(843, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:27:34', '2025-09-17 19:27:34'),
(844, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:27:46', '2025-09-17 19:27:46'),
(845, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:29:33', '2025-09-17 19:29:33'),
(846, '2', NULL, 'document_view', 'Document view: Service Agreement - XYZ Ltd (ID: 294)', NULL, '2025-09-17 19:29:36', '2025-09-17 19:29:36'),
(847, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-17 19:43:01', '2025-09-17 19:43:01'),
(848, '2', NULL, 'save_legal_draft', 'Saved legal document draft: HR Policy Template', NULL, '2025-09-17 21:35:50', '2025-09-17 21:35:50'),
(849, '2', NULL, 'save_legal_draft', 'Saved legal document draft: HR Policy Template', NULL, '2025-09-17 21:36:04', '2025-09-17 21:36:04'),
(850, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-09-18 01:51:52', '2025-09-18 01:51:52'),
(851, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-09-18 01:52:23', '2025-09-18 01:52:23'),
(852, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-09-18 08:30:48', '2025-09-18 08:30:48'),
(853, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-08 10:47:27', '2025-10-08 10:47:27'),
(854, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-09 03:12:27', '2025-10-09 03:12:27'),
(855, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-10-09)', NULL, '2025-10-09 03:30:29', '2025-10-09 03:30:29'),
(856, '2', NULL, 'legal_document_archived', 'Archived legal document: HR Policy Template (Disposal: 2030-10-09)', NULL, '2025-10-09 03:31:04', '2025-10-09 03:31:04'),
(857, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-12 15:50:11', '2025-10-12 15:50:11'),
(858, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-18 10:50:26', '2025-10-18 10:50:26'),
(859, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-19 09:07:58', '2025-10-19 09:07:58'),
(860, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-10-19 09:37:58', '2025-10-19 09:37:58'),
(861, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-20 04:38:11', '2025-10-20 04:38:11'),
(862, '2', NULL, 'document_view', 'Document view: Expired Contract - ABC Corp (ID: 288)', NULL, '2025-10-20 08:01:11', '2025-10-20 08:01:11'),
(863, '2', NULL, 'document_view', 'Document view: Expired Contract - ABC Corp (ID: 290)', NULL, '2025-10-20 08:52:00', '2025-10-20 08:52:00'),
(864, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-10-20 09:16:55', '2025-10-20 09:16:55'),
(865, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-20 14:31:52', '2025-10-20 14:31:52'),
(866, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 06:14:13', '2025-10-22 06:14:13'),
(867, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-22 06:18:30', '2025-10-22 06:18:30'),
(868, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 06:35:38', '2025-10-22 06:35:38'),
(869, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-22 06:35:42', '2025-10-22 06:35:42'),
(870, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-10-22 06:35:50', '2025-10-22 06:35:50'),
(871, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 06:47:00', '2025-10-22 06:47:00'),
(872, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-22 06:47:03', '2025-10-22 06:47:03'),
(873, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 06:54:39', '2025-10-22 06:54:39'),
(874, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-22 06:54:47', '2025-10-22 06:54:47'),
(875, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 07:04:12', '2025-10-22 07:04:12'),
(876, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-22 07:45:23', '2025-10-22 07:45:23'),
(877, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 08:26:01', '2025-10-22 08:26:01'),
(878, '2', NULL, 'document_view', 'Document view: Old Legal Memorandum (ID: 292)', NULL, '2025-10-22 09:45:29', '2025-10-22 09:45:29'),
(879, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 09:52:24', '2025-10-22 09:52:24'),
(880, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 09:54:45', '2025-10-22 09:54:45'),
(881, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 13:56:50', '2025-10-22 13:56:50'),
(882, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 13:56:56', '2025-10-22 13:56:56'),
(883, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 13:57:13', '2025-10-22 13:57:13'),
(884, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 13:59:53', '2025-10-22 13:59:53'),
(885, '2', NULL, 'document_view', 'Document view: Employment Contract Template (ID: 324)', NULL, '2025-10-22 14:00:00', '2025-10-22 14:00:00'),
(886, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 14:10:54', '2025-10-22 14:10:54'),
(888, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 14:27:38', '2025-10-22 14:27:38'),
(889, '2', 324, 'collaborator_added', NULL, '{\"role\": \"editor\", \"added_by\": 12}', '2025-10-22 14:27:46', '2025-10-22 14:27:46'),
(890, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:24:40', '2025-10-22 15:24:40'),
(891, '2', 324, 'collaborator_added', NULL, '{\"role\": \"editor\", \"added_by\": 12}', '2025-10-22 15:24:48', '2025-10-22 15:24:48'),
(892, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:27:09', '2025-10-22 15:27:09'),
(893, '2', 324, 'collaborator_added', NULL, '{\"role\": \"editor\", \"added_by\": 12}', '2025-10-22 15:27:15', '2025-10-22 15:27:15'),
(894, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:27:23', '2025-10-22 15:27:23'),
(895, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:43:50', '2025-10-22 15:43:50'),
(896, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:44:01', '2025-10-22 15:44:01'),
(897, '2', 324, 'collaborator_removed', NULL, '{\"removed_by\": 12, \"original_role\": \"viewer\"}', '2025-10-22 15:44:06', '2025-10-22 15:44:06'),
(898, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:44:09', '2025-10-22 15:44:09'),
(899, '2', 323, 'document_view', 'Document view: HR Policy Template (ID: 323)', '{\"user_role\": \"Administrator\", \"document_id\": 323, \"document_title\": \"HR Policy Template\", \"confidentiality\": null}', '2025-10-22 15:45:29', '2025-10-22 15:45:29'),
(900, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:48:33', '2025-10-22 15:48:33'),
(901, '2', 324, 'collaborator_added', NULL, '{\"role\": \"editor\", \"added_by\": 12}', '2025-10-22 15:48:44', '2025-10-22 15:48:44'),
(902, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:49:58', '2025-10-22 15:49:58'),
(903, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"user_role\": \"Administrator\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-22 15:50:05', '2025-10-22 15:50:05'),
(904, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-22 19:19:58', '2025-10-22 19:19:58'),
(905, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-23 14:51:22', '2025-10-23 14:51:22'),
(906, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-10-24 07:43:23', '2025-10-24 07:43:23'),
(907, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-24 07:43:58', '2025-10-24 07:43:58'),
(908, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-24 09:33:53', '2025-10-24 09:33:53'),
(909, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-24 09:34:51', '2025-10-24 09:34:51'),
(910, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-26 06:27:30', '2025-10-26 06:27:30'),
(911, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 07:25:01', '2025-10-27 07:25:01'),
(912, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 13:07:06', '2025-10-27 13:07:06'),
(913, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"timestamp\": \"2025-10-27T14:22:51.111275Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-10-27 14:22:51', '2025-10-27 14:22:51'),
(914, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-27 16:00:21', '2025-10-27 16:00:21'),
(915, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 16:01:23', '2025-10-27 16:01:23'),
(916, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-27 16:02:35', '2025-10-27 16:02:35'),
(917, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 16:30:37', '2025-10-27 16:30:37'),
(918, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-27 16:31:55', '2025-10-27 16:31:55'),
(919, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 16:33:16', '2025-10-27 16:33:16'),
(920, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-10-27 17:23:48', '2025-10-27 17:23:48'),
(921, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-27 17:24:17', '2025-10-27 17:24:17'),
(922, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-10-28 13:36:53', '2025-10-28 13:36:53'),
(923, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-01 08:23:15', '2025-11-01 08:23:15'),
(924, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-02 01:35:32', '2025-11-02 01:35:32'),
(925, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"timestamp\": \"2025-11-02T02:12:34.919331Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-02 02:12:34', '2025-11-02 02:12:34'),
(926, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-04 09:14:35', '2025-11-04 09:14:35'),
(927, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-05 13:47:13', '2025-11-05 13:47:13'),
(928, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-06 07:20:18', '2025-11-06 07:20:18'),
(929, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-06 10:33:49', '2025-11-06 10:33:49'),
(930, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-07 06:20:39', '2025-11-07 06:20:39'),
(931, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-07 17:09:26', '2025-11-07 17:09:26'),
(932, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-08 07:31:20', '2025-11-08 07:31:20'),
(933, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"timestamp\": \"2025-11-08T12:06:00.117595Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-08 12:06:00', '2025-11-08 12:06:00'),
(934, '2', 324, 'document_view', 'Document view: Employment Contract Template (ID: 324)', '{\"timestamp\": \"2025-11-08T12:11:26.374263Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 324, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-08 12:11:26', '2025-11-08 12:11:26'),
(935, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-09 05:07:07', '2025-11-09 05:07:07'),
(936, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-09 13:50:52', '2025-11-09 13:50:52'),
(937, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-10 08:21:51', '2025-11-10 08:21:51'),
(938, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 39', NULL, '2025-11-10 10:16:55', '2025-11-10 10:16:55'),
(939, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-10)', NULL, '2025-11-10 11:45:38', '2025-11-10 11:45:38'),
(940, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-10)', NULL, '2025-11-10 11:45:51', '2025-11-10 11:45:51'),
(941, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-10 11:46:02', '2025-11-10 11:46:02'),
(942, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-10)', NULL, '2025-11-10 11:46:11', '2025-11-10 11:46:11'),
(943, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-10)', NULL, '2025-11-10 11:46:59', '2025-11-10 11:46:59'),
(944, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-10 11:47:57', '2025-11-10 11:47:57'),
(945, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-10)', NULL, '2025-11-10 11:48:25', '2025-11-10 11:48:25'),
(946, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-10 13:19:24', '2025-11-10 13:19:24'),
(947, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-10)', NULL, '2025-11-10 13:19:53', '2025-11-10 13:19:53'),
(948, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-10 13:45:03', '2025-11-10 13:45:03'),
(949, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-10)', NULL, '2025-11-10 13:45:09', '2025-11-10 13:45:09'),
(950, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-11 19:21:49', '2025-11-11 19:21:49'),
(951, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-11 19:38:39', '2025-11-11 19:38:39'),
(952, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-11 19:39:25', '2025-11-11 19:39:25'),
(953, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-12 04:47:10', '2025-11-12 04:47:10'),
(954, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-12 06:36:57', '2025-11-12 06:36:57'),
(955, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-12 06:37:37', '2025-11-12 06:37:37'),
(956, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-12 08:22:22', '2025-11-12 08:22:22'),
(957, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-12 08:22:52', '2025-11-12 08:22:52'),
(958, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-13 08:40:40', '2025-11-13 08:40:40'),
(959, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-14 04:16:47', '2025-11-14 04:16:47'),
(960, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-14 09:23:26', '2025-11-14 09:23:26'),
(961, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-15 06:08:35', '2025-11-15 06:08:35'),
(962, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-15 17:59:23', '2025-11-15 17:59:23'),
(963, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-16 02:04:14', '2025-11-16 02:04:14'),
(964, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-16 05:43:07', '2025-11-16 05:43:07'),
(965, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-16 06:12:37', '2025-11-16 06:12:37'),
(966, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-16 06:13:11', '2025-11-16 06:13:11'),
(967, '2', NULL, 'legal_document_archived', 'Archived legal document: Service Contract Template (Disposal: 2032-11-16)', NULL, '2025-11-16 07:01:53', '2025-11-16 07:01:53'),
(968, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-11-16 07:02:15', '2025-11-16 07:02:15'),
(969, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-16 08:05:35', '2025-11-16 08:05:35'),
(970, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-16 08:05:40', '2025-11-16 08:05:40'),
(971, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-11-16 08:11:00', '2025-11-16 08:11:00'),
(972, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-16 15:29:12', '2025-11-16 15:29:12'),
(973, '2', NULL, 'legal_document_archived', 'Archived legal document: Service Contract Template (Disposal: 2032-11-16)', NULL, '2025-11-16 15:34:38', '2025-11-16 15:34:38'),
(974, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-17 04:17:33', '2025-11-17 04:17:33'),
(975, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-17 05:09:20', '2025-11-17 05:09:20'),
(976, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-17 05:09:57', '2025-11-17 05:09:57'),
(977, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-17 15:39:12', '2025-11-17 15:39:12'),
(978, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-18 10:59:23', '2025-11-18 10:59:23'),
(979, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-18 11:00:12', '2025-11-18 11:00:12'),
(980, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-18 11:03:00', '2025-11-18 11:03:00'),
(981, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-18 11:04:08', '2025-11-18 11:04:08'),
(982, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-19 01:03:20', '2025-11-19 01:03:20'),
(983, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 02:55:00', '2025-11-19 02:55:00'),
(984, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:00:04', '2025-11-19 03:00:04'),
(985, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:01:03', '2025-11-19 03:01:03'),
(986, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:07:12', '2025-11-19 03:07:12'),
(987, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:12:42', '2025-11-19 03:12:42'),
(988, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-11-19 03:20:52', '2025-11-19 03:20:52'),
(989, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:20:58', '2025-11-19 03:20:58'),
(990, '2', NULL, 'legal_document_archived', 'Archived legal document: Service Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:24:52', '2025-11-19 03:24:52'),
(991, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-19 03:30:28', '2025-11-19 03:30:28'),
(992, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 03:30:35', '2025-11-19 03:30:35'),
(993, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T03:38:15.154361Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 03:38:15', '2025-11-19 03:38:15'),
(994, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T03:48:22.213425Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 03:48:22', '2025-11-19 03:48:22'),
(995, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T03:59:57.172533Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 03:59:57', '2025-11-19 03:59:57'),
(996, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:00:04.196542Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:00:04', '2025-11-19 04:00:04'),
(997, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:07:06.272833Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:07:06', '2025-11-19 04:07:06'),
(998, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:07:19.282933Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:07:19', '2025-11-19 04:07:19'),
(999, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:07:28.625862Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:07:28', '2025-11-19 04:07:28'),
(1000, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:13:01.394465Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:13:01', '2025-11-19 04:13:01'),
(1001, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:13:30.985589Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:13:30', '2025-11-19 04:13:30'),
(1002, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:14:54.848073Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:14:54', '2025-11-19 04:14:54'),
(1003, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:20:15.771248Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:20:15', '2025-11-19 04:20:15'),
(1004, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:20:19.505122Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:20:19', '2025-11-19 04:20:19'),
(1005, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:25:22.788045Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:25:22', '2025-11-19 04:25:22'),
(1006, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:32:05.942554Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:32:05', '2025-11-19 04:32:05'),
(1007, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:32:31.363107Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:32:31', '2025-11-19 04:32:31'),
(1008, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:38:11.508399Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:38:11', '2025-11-19 04:38:11'),
(1009, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:50:01.892906Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:50:01', '2025-11-19 04:50:01'),
(1010, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T04:54:10.378237Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 04:54:10', '2025-11-19 04:54:10'),
(1011, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:01:35.424709Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:01:35', '2025-11-19 05:01:35'),
(1012, '2', 329, 'document_view', 'Document view: Employment Contract Template (ID: 329)', '{\"timestamp\": \"2025-11-19T05:05:11.730415Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 329, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:05:11', '2025-11-19 05:05:11'),
(1013, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:10:05.359381Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:10:05', '2025-11-19 05:10:05'),
(1014, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:20:15.378064Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:20:15', '2025-11-19 05:20:15'),
(1015, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:22:53.151987Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:22:53', '2025-11-19 05:22:53'),
(1016, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:27:16.555388Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:27:16', '2025-11-19 05:27:16'),
(1017, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:28:44.683562Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:28:44', '2025-11-19 05:28:44'),
(1018, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:30:15.470982Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:30:15', '2025-11-19 05:30:15'),
(1019, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:30:35.947647Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:30:35', '2025-11-19 05:30:35'),
(1020, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:39:27.163383Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:39:27', '2025-11-19 05:39:27'),
(1021, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:44:40.468515Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:44:40', '2025-11-19 05:44:40'),
(1022, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:45:15.060624Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:45:15', '2025-11-19 05:45:15'),
(1023, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:45:50.966353Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:45:50', '2025-11-19 05:45:50'),
(1024, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:47:27.728476Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:47:27', '2025-11-19 05:47:27'),
(1025, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:50:17.412120Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:50:17', '2025-11-19 05:50:17'),
(1026, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T05:53:40.371242Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 05:53:40', '2025-11-19 05:53:40'),
(1027, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:00:06.640604Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:00:06', '2025-11-19 06:00:06'),
(1028, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:08:05.807501Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:08:05', '2025-11-19 06:08:05'),
(1029, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:13:36.951859Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:13:36', '2025-11-19 06:13:36'),
(1030, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:28:39.157531Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:28:39', '2025-11-19 06:28:39'),
(1031, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:34:48.701625Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:34:48', '2025-11-19 06:34:48'),
(1032, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:35:29.334589Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:35:29', '2025-11-19 06:35:29'),
(1033, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:36:44.449122Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:36:44', '2025-11-19 06:36:44'),
(1034, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:37:15.737264Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:37:15', '2025-11-19 06:37:15'),
(1035, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T06:37:15.877843Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 06:37:15', '2025-11-19 06:37:15'),
(1036, '2', NULL, 'legal_document_archived', 'Archived legal document: Service Contract Template (Disposal: 2032-11-19)', NULL, '2025-11-19 06:56:08', '2025-11-19 06:56:08'),
(1037, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-11-19 06:56:29', '2025-11-19 06:56:29'),
(1038, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-19)', NULL, '2025-11-19 06:56:35', '2025-11-19 06:56:35'),
(1039, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T06:56:49.785952Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 06:56:49', '2025-11-19 06:56:49');
INSERT INTO `access_logs` (`id`, `user_id`, `document_id`, `action`, `description`, `metadata`, `created_at`, `updated_at`) VALUES
(1040, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T07:39:42.831396Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 07:39:42', '2025-11-19 07:39:42'),
(1041, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T07:39:47.404147Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 07:39:47', '2025-11-19 07:39:47'),
(1042, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T07:51:17.901953Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 07:51:17', '2025-11-19 07:51:17'),
(1043, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T08:09:11.407952Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 08:09:11', '2025-11-19 08:09:11'),
(1044, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T09:09:04.755275Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 09:09:04', '2025-11-19 09:09:04'),
(1045, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:17:32.911730Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:17:32', '2025-11-19 10:17:32'),
(1046, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:17:35.486198Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:17:35', '2025-11-19 10:17:35'),
(1047, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:17:38.236110Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:17:38', '2025-11-19 10:17:38'),
(1048, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:17:41.343347Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:17:41', '2025-11-19 10:17:41'),
(1049, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:18:08.359807Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:18:08', '2025-11-19 10:18:08'),
(1050, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T10:18:10.366026Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 10:18:10', '2025-11-19 10:18:10'),
(1051, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:11:36.527549Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:11:36', '2025-11-19 11:11:36'),
(1052, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:18:19.451963Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:18:19', '2025-11-19 11:18:19'),
(1053, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:18:22.505852Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:18:22', '2025-11-19 11:18:22'),
(1054, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:18:30.091469Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:18:30', '2025-11-19 11:18:30'),
(1055, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:21:47.657932Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:21:47', '2025-11-19 11:21:47'),
(1056, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:22:00.091730Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:22:00', '2025-11-19 11:22:00'),
(1057, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:29:38.094270Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:29:38', '2025-11-19 11:29:38'),
(1058, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:29:45.148484Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:29:45', '2025-11-19 11:29:45'),
(1059, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:34:15.952928Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:34:15', '2025-11-19 11:34:15'),
(1060, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:34:19.367635Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:34:19', '2025-11-19 11:34:19'),
(1061, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:34:21.795936Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:34:21', '2025-11-19 11:34:21'),
(1062, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:34:27.787668Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:34:27', '2025-11-19 11:34:27'),
(1063, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:39:34.476923Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:39:34', '2025-11-19 11:39:34'),
(1064, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T11:39:39.685931Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 11:39:39', '2025-11-19 11:39:39'),
(1065, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:15:56.032842Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:15:56', '2025-11-19 12:15:56'),
(1066, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:16:08.447006Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:16:08', '2025-11-19 12:16:08'),
(1067, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:16:27.561805Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:16:27', '2025-11-19 12:16:27'),
(1068, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:16:43.556539Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:16:43', '2025-11-19 12:16:43'),
(1069, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:16:49.188147Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:16:49', '2025-11-19 12:16:49'),
(1070, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:20:02.659750Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:20:02', '2025-11-19 12:20:02'),
(1071, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:20:09.456197Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:20:09', '2025-11-19 12:20:09'),
(1072, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:20:20.789418Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:20:20', '2025-11-19 12:20:20'),
(1073, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T12:21:50.915544Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 12:21:50', '2025-11-19 12:21:50'),
(1074, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:29:52.914453Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:29:52', '2025-11-19 12:29:52'),
(1075, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:30:12.806430Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:30:12', '2025-11-19 12:30:12'),
(1076, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:36:13.861801Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:36:13', '2025-11-19 12:36:13'),
(1077, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T12:36:17.236866Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 12:36:17', '2025-11-19 12:36:17'),
(1078, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:36:22.802436Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:36:22', '2025-11-19 12:36:22'),
(1079, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:47:01.995465Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:47:02', '2025-11-19 12:47:02'),
(1080, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:48:29.313173Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:48:29', '2025-11-19 12:48:29'),
(1081, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:49:03.409409Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:49:03', '2025-11-19 12:49:03'),
(1082, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:56:26.384574Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:56:26', '2025-11-19 12:56:26'),
(1083, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-19T12:57:11.917581Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 12:57:11', '2025-11-19 12:57:11'),
(1084, '2', 336, 'document_view', 'Document view: Employment Contract Template (ID: 336)', '{\"timestamp\": \"2025-11-19T12:57:14.648602Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 336, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 12:57:14', '2025-11-19 12:57:14'),
(1085, '2', 333, 'document_view', 'Document view: Employment Contract Template (ID: 333)', '{\"timestamp\": \"2025-11-19T12:57:17.441936Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 333, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-19 12:57:17', '2025-11-19 12:57:17'),
(1086, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:57:19.999960Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:57:20', '2025-11-19 12:57:20'),
(1087, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T12:59:52.829412Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 12:59:52', '2025-11-19 12:59:52'),
(1088, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T13:21:26.943551Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 13:21:26', '2025-11-19 13:21:26'),
(1089, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T13:26:56.331982Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 13:26:56', '2025-11-19 13:26:56'),
(1090, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-19T14:25:14.494372Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-19 14:25:14', '2025-11-19 14:25:14'),
(1091, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-20 05:29:09', '2025-11-20 05:29:09'),
(1092, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-20 13:57:37', '2025-11-20 13:57:37'),
(1093, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T13:57:59.451112Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 13:57:59', '2025-11-20 13:57:59'),
(1094, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T13:58:07.150463Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 13:58:07', '2025-11-20 13:58:07'),
(1095, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T14:05:28.540552Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 14:05:28', '2025-11-20 14:05:28'),
(1096, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T14:05:38.363488Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 14:05:38', '2025-11-20 14:05:38'),
(1097, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T14:05:47.542710Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 14:05:47', '2025-11-20 14:05:47'),
(1098, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-20 15:12:27', '2025-11-20 15:12:27'),
(1099, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-20 15:13:23', '2025-11-20 15:13:23'),
(1100, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-20 15:26:02', '2025-11-20 15:26:02'),
(1101, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-20 15:58:31', '2025-11-20 15:58:31'),
(1102, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-20 16:04:43', '2025-11-20 16:04:43'),
(1103, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-20 16:09:55', '2025-11-20 16:09:55'),
(1104, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:40:41.876974Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:40:41', '2025-11-20 16:40:41'),
(1105, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:41:03.778846Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:41:03', '2025-11-20 16:41:03'),
(1106, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:41:10.943735Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:41:10', '2025-11-20 16:41:10'),
(1107, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:41:44.941178Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:41:44', '2025-11-20 16:41:44'),
(1108, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:42:07.376667Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:42:07', '2025-11-20 16:42:07'),
(1109, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:42:21.846654Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:42:21', '2025-11-20 16:42:21'),
(1110, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-20T16:43:37.710280Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-20 16:43:37', '2025-11-20 16:43:37'),
(1111, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:43:47.050022Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:43:47', '2025-11-20 16:43:47'),
(1112, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:44:29.269145Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:44:29', '2025-11-20 16:44:29'),
(1113, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:44:49.322247Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:44:49', '2025-11-20 16:44:49'),
(1114, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:44:52.242762Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:44:52', '2025-11-20 16:44:52'),
(1115, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:45:23.364093Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:45:23', '2025-11-20 16:45:23'),
(1116, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:46:04.148419Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:46:04', '2025-11-20 16:46:04'),
(1117, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:55:57.164634Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:55:57', '2025-11-20 16:55:57'),
(1118, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T16:56:15.015939Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 16:56:15', '2025-11-20 16:56:15'),
(1119, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:38:33.042988Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:38:33', '2025-11-20 17:38:33'),
(1120, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:38:36.054449Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:38:36', '2025-11-20 17:38:36'),
(1121, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:38:41.907782Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:38:41', '2025-11-20 17:38:41'),
(1122, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:38:44.944311Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:38:44', '2025-11-20 17:38:44'),
(1123, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-20T17:38:54.179545Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-20 17:38:54', '2025-11-20 17:38:54'),
(1124, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-20T17:38:56.501749Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-20 17:38:56', '2025-11-20 17:38:56'),
(1125, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:50:23.349866Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:50:23', '2025-11-20 17:50:23'),
(1126, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:50:38.680702Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:50:38', '2025-11-20 17:50:38'),
(1127, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:50:46.810250Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:50:46', '2025-11-20 17:50:46'),
(1128, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:51:02.562733Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:51:02', '2025-11-20 17:51:02'),
(1129, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:51:30.901144Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:51:30', '2025-11-20 17:51:30'),
(1130, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:52:09.895382Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:52:09', '2025-11-20 17:52:09'),
(1131, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:53:50.474532Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:53:50', '2025-11-20 17:53:50'),
(1132, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:53:52.995819Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:53:53', '2025-11-20 17:53:53'),
(1133, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:53:56.526990Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:53:56', '2025-11-20 17:53:56'),
(1134, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:58:36.513857Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:58:36', '2025-11-20 17:58:36'),
(1135, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:58:39.543754Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:58:39', '2025-11-20 17:58:39'),
(1136, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:58:57.996066Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:58:58', '2025-11-20 17:58:58'),
(1137, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T17:59:00.945834Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 17:59:00', '2025-11-20 17:59:00'),
(1138, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:02:39.346389Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:02:39', '2025-11-20 18:02:39'),
(1139, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:02:41.769842Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:02:41', '2025-11-20 18:02:41'),
(1140, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:02:44.731447Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:02:44', '2025-11-20 18:02:44'),
(1141, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:02:48.087457Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:02:48', '2025-11-20 18:02:48'),
(1142, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:02:52.021065Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:02:52', '2025-11-20 18:02:52'),
(1143, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:05:58.854439Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:05:58', '2025-11-20 18:05:58'),
(1144, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:01.359856Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:01', '2025-11-20 18:06:01'),
(1145, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:07.911539Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:07', '2025-11-20 18:06:07'),
(1146, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:18.045180Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:18', '2025-11-20 18:06:18'),
(1147, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:27.519223Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:27', '2025-11-20 18:06:27'),
(1148, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:32.390857Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:32', '2025-11-20 18:06:32'),
(1149, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:06:40.161584Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:06:40', '2025-11-20 18:06:40'),
(1150, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:10:23.377247Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:10:23', '2025-11-20 18:10:23'),
(1151, '2', 339, 'document_view', 'Document view: Guest Agreement Template (ID: 339)', '{\"timestamp\": \"2025-11-20T18:20:22.519502Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 339, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-20 18:20:22', '2025-11-20 18:20:22'),
(1152, '2', 338, 'document_view', 'Document view: Employment Contract Template (ID: 338)', '{\"timestamp\": \"2025-11-20T18:22:12.716837Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 338, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-20 18:22:12', '2025-11-20 18:22:12'),
(1153, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-21 02:27:50', '2025-11-21 02:27:50'),
(1154, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-21)', NULL, '2025-11-21 03:50:56', '2025-11-21 03:50:56'),
(1155, '2', NULL, 'legal_document_archived', 'Archived legal document: Vendor Agreement Template (Disposal: 2032-11-21)', NULL, '2025-11-21 03:51:15', '2025-11-21 03:51:15'),
(1156, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-11-21 03:51:34', '2025-11-21 03:51:34'),
(1157, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-11-21)', NULL, '2025-11-21 03:51:42', '2025-11-21 03:51:42'),
(1158, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-11-21 03:52:07', '2025-11-21 03:52:07'),
(1159, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2032-11-21)', NULL, '2025-11-21 04:01:58', '2025-11-21 04:01:58'),
(1160, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-21T04:24:10.979897Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-21 04:24:10', '2025-11-21 04:24:10'),
(1161, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-21 04:32:33', '2025-11-21 04:32:33'),
(1162, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-21 04:54:04', '2025-11-21 04:54:04'),
(1163, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-21 04:55:07', '2025-11-21 04:55:07'),
(1164, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-21 04:56:50', '2025-11-21 04:56:50'),
(1165, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-21 05:26:26', '2025-11-21 05:26:26'),
(1166, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-21 05:26:58', '2025-11-21 05:26:58'),
(1167, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-21T05:41:41.675876Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-21 05:41:41', '2025-11-21 05:41:41'),
(1168, '2', 340, 'document_view', 'Document view: Employment Contract Template (ID: 340)', '{\"timestamp\": \"2025-11-21T05:41:51.879112Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 340, \"document_title\": \"Employment Contract Template\", \"confidentiality\": null}', '2025-11-21 05:41:51', '2025-11-21 05:41:51'),
(1169, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-22 14:34:36', '2025-11-22 14:34:36'),
(1170, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-23 15:51:54', '2025-11-23 15:51:54'),
(1171, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T15:52:32.161072Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 15:52:32', '2025-11-23 15:52:32'),
(1172, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T15:52:40.869078Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 15:52:40', '2025-11-23 15:52:40'),
(1173, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T15:52:45.433702Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 15:52:45', '2025-11-23 15:52:45'),
(1174, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T15:52:54.590387Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 15:52:54', '2025-11-23 15:52:54'),
(1175, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-23 19:12:19', '2025-11-23 19:12:19'),
(1176, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T19:19:33.778714Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 19:19:33', '2025-11-23 19:19:33'),
(1177, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T19:19:37.189131Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 19:19:37', '2025-11-23 19:19:37'),
(1178, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T19:19:43.162787Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 19:19:43', '2025-11-23 19:19:43'),
(1179, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-23T19:27:27.795894Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-23 19:27:27', '2025-11-23 19:27:27'),
(1180, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-24 09:43:46', '2025-11-24 09:43:46'),
(1181, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-24 10:23:50', '2025-11-24 10:23:50'),
(1182, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-26 03:36:46', '2025-11-26 03:36:46'),
(1183, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-26 08:15:46', '2025-11-26 08:15:46'),
(1184, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-26 13:52:02', '2025-11-26 13:52:02'),
(1185, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-27 13:07:04', '2025-11-27 13:07:04'),
(1186, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 22', NULL, '2025-11-27 19:01:42', '2025-11-27 19:01:42'),
(1187, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-27T19:01:58.031156Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-27 19:01:58', '2025-11-27 19:01:58'),
(1188, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-27T19:02:05.196158Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-27 19:02:05', '2025-11-27 19:02:05'),
(1189, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-27T19:02:09.113783Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-27 19:02:09', '2025-11-27 19:02:09'),
(1190, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-28 14:29:25', '2025-11-28 14:29:25'),
(1191, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-28 15:54:24', '2025-11-28 15:54:24'),
(1192, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-28T15:59:52.482833Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-28 15:59:52', '2025-11-28 15:59:52'),
(1193, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 05:51:17', '2025-11-29 05:51:17'),
(1194, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-29T07:47:53.779037Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-29 07:47:53', '2025-11-29 07:47:53'),
(1195, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-29 10:55:17', '2025-11-29 10:55:17'),
(1196, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 10:56:32', '2025-11-29 10:56:32'),
(1197, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-29 13:34:44', '2025-11-29 13:34:44'),
(1198, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 13:35:39', '2025-11-29 13:35:39'),
(1199, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-29 13:35:47', '2025-11-29 13:35:47'),
(1200, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 13:36:31', '2025-11-29 13:36:31'),
(1201, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-29 17:25:49', '2025-11-29 17:25:49'),
(1202, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 17:26:20', '2025-11-29 17:26:20'),
(1203, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-29 17:26:47', '2025-11-29 17:26:47'),
(1204, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 17:27:33', '2025-11-29 17:27:33'),
(1205, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 18:55:50', '2025-11-29 18:55:50'),
(1206, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-29 20:58:07', '2025-11-29 20:58:07'),
(1207, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 03:00:06', '2025-11-30 03:00:06'),
(1208, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 03:59:13', '2025-11-30 03:59:13'),
(1209, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 03:59:39', '2025-11-30 03:59:39'),
(1210, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 03:59:57', '2025-11-30 03:59:57'),
(1211, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:05:37', '2025-11-30 04:05:37'),
(1212, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:08:59', '2025-11-30 04:08:59'),
(1213, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:09:13', '2025-11-30 04:09:13'),
(1214, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:14:07', '2025-11-30 04:14:07'),
(1215, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:14:27', '2025-11-30 04:14:27'),
(1216, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 04:15:18', '2025-11-30 04:15:18'),
(1217, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 04:18:43', '2025-11-30 04:18:43'),
(1218, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 04:25:35', '2025-11-30 04:25:35'),
(1219, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 04:27:06', '2025-11-30 04:27:06'),
(1220, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 05:35:03', '2025-11-30 05:35:03'),
(1221, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 05:35:46', '2025-11-30 05:35:46'),
(1222, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 05:36:08', '2025-11-30 05:36:08'),
(1223, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 05:36:39', '2025-11-30 05:36:39'),
(1224, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 05:38:14', '2025-11-30 05:38:14'),
(1225, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 05:38:48', '2025-11-30 05:38:48'),
(1226, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 05:39:10', '2025-11-30 05:39:10'),
(1227, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 05:47:38', '2025-11-30 05:47:38'),
(1228, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 13:43:31', '2025-11-30 13:43:31');
INSERT INTO `access_logs` (`id`, `user_id`, `document_id`, `action`, `description`, `metadata`, `created_at`, `updated_at`) VALUES
(1229, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 13:44:19', '2025-11-30 13:44:19'),
(1230, '2', 341, 'document_view', 'Document view: Guest Agreement Template (ID: 341)', '{\"timestamp\": \"2025-11-30T13:52:08.340552Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 341, \"document_title\": \"Guest Agreement Template\", \"confidentiality\": null}', '2025-11-30 13:52:08', '2025-11-30 13:52:08'),
(1231, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 13:52:19', '2025-11-30 13:52:19'),
(1232, '1', NULL, 'Login_failed', 'Invalid password provided', NULL, '2025-11-30 13:52:32', '2025-11-30 13:52:32'),
(1233, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 13:58:43', '2025-11-30 13:58:43'),
(1234, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 16:39:03', '2025-11-30 16:39:03'),
(1235, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 16:41:21', '2025-11-30 16:41:21'),
(1236, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2025-11-30 16:41:41', '2025-11-30 16:41:41'),
(1237, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-11-30 16:42:10', '2025-11-30 16:42:10'),
(1238, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-12-01 07:43:32', '2025-12-01 07:43:32'),
(1239, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2025-12-01 07:46:44', '2025-12-01 07:46:44'),
(1240, '2', NULL, 'legal_document_archived', 'Archived legal document: Service Contract Template (Disposal: 2032-12-01)', NULL, '2025-12-01 07:46:53', '2025-12-01 07:46:53'),
(1241, '1', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-12-04 12:00:52', '2025-12-04 12:00:52'),
(1242, '1', NULL, 'Logout', 'User logged out successfully', NULL, '2025-12-04 12:01:29', '2025-12-04 12:01:29'),
(1243, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2025-12-04 13:27:10', '2025-12-04 13:27:10'),
(1244, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T13:52:01.986562Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 13:52:01', '2025-12-04 13:52:01'),
(1245, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T13:52:06.615286Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 13:52:06', '2025-12-04 13:52:06'),
(1246, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T13:53:23.859107Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 13:53:23', '2025-12-04 13:53:23'),
(1247, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T13:53:35.404783Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 13:53:35', '2025-12-04 13:53:35'),
(1248, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T13:54:14.445008Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 13:54:14', '2025-12-04 13:54:14'),
(1249, '2', 342, 'document_view', 'Document view: Service Contract Template (ID: 342)', '{\"timestamp\": \"2025-12-04T14:05:17.897914Z\", \"user_role\": \"Administrator\", \"action_type\": \"view\", \"document_id\": 342, \"document_title\": \"Service Contract Template\", \"confidentiality\": null}', '2025-12-04 14:05:17', '2025-12-04 14:05:17'),
(1250, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2025-12-04 15:28:57', '2025-12-04 15:28:57'),
(1251, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2025-12-04 15:31:51', '2025-12-04 15:31:51'),
(1252, '2', NULL, 'save_legal_draft', 'Saved legal document draft: hgghj', NULL, '2025-12-04 15:32:18', '2025-12-04 15:32:18'),
(1253, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-08 12:45:23', '2026-01-08 12:45:23'),
(1254, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-08 13:08:38', '2026-01-08 13:08:38'),
(1255, '1', NULL, 'save_legal_draft', 'Saved legal document draft: asdfasdf', NULL, '2026-01-08 15:43:59', '2026-01-08 15:43:59'),
(1256, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-08 23:03:23', '2026-01-08 23:03:23'),
(1257, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 01:14:04', '2026-01-12 01:14:04'),
(1258, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-12 01:17:31', '2026-01-12 01:17:31'),
(1259, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 01:21:25', '2026-01-12 01:21:25'),
(1260, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 01:26:02', '2026-01-12 01:26:02'),
(1261, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 01:45:43', '2026-01-12 01:45:43'),
(1262, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 03:23:48', '2026-01-12 03:23:48'),
(1263, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-12 05:21:22', '2026-01-12 05:21:22'),
(1264, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:39:53', '2026-01-12 06:39:53'),
(1265, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:42:30', '2026-01-12 06:42:30'),
(1266, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-12 06:43:30', '2026-01-12 06:43:30'),
(1267, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:44:24', '2026-01-12 06:44:24'),
(1268, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:45:00', '2026-01-12 06:45:00'),
(1269, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:49:11', '2026-01-12 06:49:11'),
(1270, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-12 06:49:42', '2026-01-12 06:49:42'),
(1271, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-12 06:50:10', '2026-01-12 06:50:10'),
(1272, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-12 06:50:40', '2026-01-12 06:50:40'),
(1273, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-12 06:52:03', '2026-01-12 06:52:03'),
(1274, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 43 from filing to investigation', NULL, '2026-01-12 07:09:43', '2026-01-12 07:09:43'),
(1275, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 43 from investigation to review', NULL, '2026-01-12 07:11:27', '2026-01-12 07:11:27'),
(1276, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 43 from review to resolution', NULL, '2026-01-12 07:11:52', '2026-01-12 07:11:52'),
(1277, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 43 from resolution to closed', NULL, '2026-01-12 07:12:24', '2026-01-12 07:12:24'),
(1278, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-21 17:02:20', '2026-01-21 17:02:20'),
(1279, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 45 from filing to investigation', NULL, '2026-01-21 17:29:24', '2026-01-21 17:29:24'),
(1280, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 17:32:30', '2026-01-21 17:32:30'),
(1281, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 18:53:08', '2026-01-21 18:53:08'),
(1282, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 18:54:38', '2026-01-21 18:54:38'),
(1283, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 18:58:57', '2026-01-21 18:58:57'),
(1284, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-21 19:03:12', '2026-01-21 19:03:12'),
(1285, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-21 19:07:56', '2026-01-21 19:07:56'),
(1286, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 19:12:25', '2026-01-21 19:12:25'),
(1287, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 19:12:56', '2026-01-21 19:12:56'),
(1288, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 19:19:45', '2026-01-21 19:19:45'),
(1289, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-21 19:21:21', '2026-01-21 19:21:21'),
(1290, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-21 19:27:18', '2026-01-21 19:27:18'),
(1291, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:34:05', '2026-01-21 19:34:05'),
(1292, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:34:56', '2026-01-21 19:34:56'),
(1293, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:39:24', '2026-01-21 19:39:24'),
(1294, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:42:17', '2026-01-21 19:42:17'),
(1295, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:42:57', '2026-01-21 19:42:57'),
(1296, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:43:26', '2026-01-21 19:43:26'),
(1297, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-21 19:46:31', '2026-01-21 19:46:31'),
(1298, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Vendor Agreement Template', NULL, '2026-01-21 19:53:30', '2026-01-21 19:53:30'),
(1299, '2', NULL, 'update_investigation_notes', 'Updated investigation notes for legal case ID 45', NULL, '2026-01-21 20:12:26', '2026-01-21 20:12:26'),
(1300, '2', NULL, 'legal_document_declined', 'Declined legal document: Vendor Agreement Template - Reason: fg nfgn', NULL, '2026-01-21 20:14:36', '2026-01-21 20:14:36'),
(1301, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-22 03:28:19', '2026-01-22 03:28:19'),
(1302, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-22 03:39:09', '2026-01-22 03:39:09'),
(1303, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Service Contract Template', NULL, '2026-01-22 03:40:45', '2026-01-22 03:40:45'),
(1304, '2', NULL, 'update_investigation_notes', 'Updated investigation notes for legal case ID 45', NULL, '2026-01-22 04:30:36', '2026-01-22 04:30:36'),
(1305, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 45', NULL, '2026-01-22 04:31:40', '2026-01-22 04:31:40'),
(1306, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 46', NULL, '2026-01-22 04:36:17', '2026-01-22 04:36:17'),
(1307, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 44', NULL, '2026-01-22 05:12:21', '2026-01-22 05:12:21'),
(1308, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 42', NULL, '2026-01-22 05:12:28', '2026-01-22 05:12:28'),
(1309, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 43', NULL, '2026-01-22 05:12:31', '2026-01-22 05:12:31'),
(1310, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 41', NULL, '2026-01-22 05:12:34', '2026-01-22 05:12:34'),
(1311, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 46 from filing to investigation', NULL, '2026-01-22 05:42:53', '2026-01-22 05:42:53'),
(1312, '2', NULL, 'update_investigation_notes', 'Updated investigation notes for legal case ID 46', NULL, '2026-01-22 05:48:38', '2026-01-22 05:48:38'),
(1313, '2', NULL, 'add_legal_case_witness', 'Added witness \'JAY\' to legal case ID 46', NULL, '2026-01-22 05:49:28', '2026-01-22 05:49:28'),
(1314, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 46', NULL, '2026-01-22 05:50:37', '2026-01-22 05:50:37'),
(1315, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 46', NULL, '2026-01-22 05:51:36', '2026-01-22 05:51:36'),
(1316, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 46', NULL, '2026-01-22 05:54:18', '2026-01-22 05:54:18'),
(1317, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 46: 1769061394_visitor violation.docx', NULL, '2026-01-22 05:56:34', '2026-01-22 05:56:34'),
(1318, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 46 from investigation to review', NULL, '2026-01-22 05:56:46', '2026-01-22 05:56:46'),
(1319, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 46 from review to resolution', NULL, '2026-01-22 05:57:49', '2026-01-22 05:57:49'),
(1320, '2', NULL, 'submit_case_resolution', 'Submitted resolution (approved) for legal case ID 46', NULL, '2026-01-22 05:58:09', '2026-01-22 05:58:09'),
(1321, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 46 from resolution to closed', NULL, '2026-01-22 05:58:24', '2026-01-22 05:58:24'),
(1322, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 24', NULL, '2026-01-22 06:07:36', '2026-01-22 06:07:36'),
(1323, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 26', NULL, '2026-01-22 06:07:39', '2026-01-22 06:07:39'),
(1324, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 27', NULL, '2026-01-22 06:07:43', '2026-01-22 06:07:43'),
(1325, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 28', NULL, '2026-01-22 06:07:51', '2026-01-22 06:07:51'),
(1326, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 29', NULL, '2026-01-22 06:07:59', '2026-01-22 06:07:59'),
(1327, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 31', NULL, '2026-01-22 06:08:04', '2026-01-22 06:08:04'),
(1328, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 33', NULL, '2026-01-22 06:08:07', '2026-01-22 06:08:07'),
(1329, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 35', NULL, '2026-01-22 06:08:13', '2026-01-22 06:08:13'),
(1330, '2', NULL, 'delete_legal_case', 'Deleted legal case ID 37', NULL, '2026-01-22 06:08:15', '2026-01-22 06:08:15'),
(1331, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-22 06:45:59', '2026-01-22 06:45:59'),
(1332, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2033-01-22)', NULL, '2026-01-22 06:46:17', '2026-01-22 06:46:17'),
(1333, '2', 377, 'document_view', 'Document view: Guest Agreement Template (ID: 377)', '{\"document_id\":377,\"document_title\":\"Guest Agreement Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-22T06:49:09.841119Z\"}', '2026-01-22 06:49:09', '2026-01-22 06:49:09'),
(1334, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-22 06:53:29', '2026-01-22 06:53:29'),
(1335, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 45 from investigation to review', NULL, '2026-01-22 08:38:06', '2026-01-22 08:38:06'),
(1336, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 45 from review to resolution', NULL, '2026-01-22 08:38:18', '2026-01-22 08:38:18'),
(1337, '2', NULL, 'submit_case_resolution', 'Submitted resolution (approved) for legal case ID 45', NULL, '2026-01-22 08:38:39', '2026-01-22 08:38:39'),
(1338, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 45 from resolution to closed', NULL, '2026-01-22 08:39:06', '2026-01-22 08:39:06'),
(1339, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-22 08:39:45', '2026-01-22 08:39:45'),
(1340, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-22 08:39:45', '2026-01-22 08:39:45'),
(1341, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 47 from filing to investigation', NULL, '2026-01-22 08:41:24', '2026-01-22 08:41:24'),
(1342, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 47: 1769072214_visitor violation.docx', NULL, '2026-01-22 08:56:54', '2026-01-22 08:56:54'),
(1343, '2', NULL, 'add_legal_case_witness', 'Added witness \'REN\' to legal case ID 47', NULL, '2026-01-22 08:57:25', '2026-01-22 08:57:25'),
(1344, '2', NULL, 'update_investigation_notes', 'Updated investigation notes for legal case ID 47', NULL, '2026-01-22 08:57:35', '2026-01-22 08:57:35'),
(1345, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 47 from investigation to review', NULL, '2026-01-22 08:57:44', '2026-01-22 08:57:44'),
(1346, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 48 from filing to investigation', NULL, '2026-01-22 09:10:54', '2026-01-22 09:10:54'),
(1347, '2', NULL, 'update_investigation_notes', 'Updated investigation notes for legal case ID 48', NULL, '2026-01-22 09:16:42', '2026-01-22 09:16:42'),
(1348, '2', NULL, 'add_legal_evidence', 'Added evidence to legal case ID 48: 1769073416_visitor violation.docx', NULL, '2026-01-22 09:16:56', '2026-01-22 09:16:56'),
(1349, '2', NULL, 'add_legal_case_witness', 'Added witness \'awfaw\' to legal case ID 48', NULL, '2026-01-22 09:17:19', '2026-01-22 09:17:19'),
(1350, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 48 from investigation to review', NULL, '2026-01-22 09:17:28', '2026-01-22 09:17:28'),
(1351, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 48 from review to resolution', NULL, '2026-01-22 09:17:50', '2026-01-22 09:17:50'),
(1352, '2', NULL, 'submit_case_resolution', 'Submitted resolution (approved) for legal case ID 48', NULL, '2026-01-22 09:18:17', '2026-01-22 09:18:17'),
(1353, '2', NULL, 'transition_legal_case', 'Transitioned legal case ID 48 from resolution to closed', NULL, '2026-01-22 09:18:23', '2026-01-22 09:18:23'),
(1354, '2', NULL, 'save_legal_draft', 'Saved legal document draft: ABSENT WITHOUT LEAVE POLICY', NULL, '2026-01-22 13:14:18', '2026-01-22 13:14:18'),
(1355, '2', NULL, 'save_legal_draft', 'Saved legal document draft: ABSENT WITHOUT LEAVE POLICY', NULL, '2026-01-22 13:18:47', '2026-01-22 13:18:47'),
(1356, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Guest Agreement Template', NULL, '2026-01-22 13:34:49', '2026-01-22 13:34:49'),
(1357, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-22 13:52:15', '2026-01-22 13:52:15'),
(1358, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-22 13:56:42', '2026-01-22 13:56:42'),
(1359, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-01-22)', NULL, '2026-01-22 13:57:09', '2026-01-22 13:57:09'),
(1360, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-22 14:02:39', '2026-01-22 14:02:39'),
(1361, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-22 14:08:44', '2026-01-22 14:08:44'),
(1362, '2', 383, 'document_view', 'Document view: Employment Contract Template (ID: 383)', '{\"document_id\":383,\"document_title\":\"Employment Contract Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-22T14:38:31.922538Z\"}', '2026-01-22 14:38:31', '2026-01-22 14:38:31'),
(1363, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 04:33:48', '2026-01-23 04:33:48'),
(1364, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-23 05:29:14', '2026-01-23 05:29:14'),
(1365, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 05:30:09', '2026-01-23 05:30:09'),
(1366, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-23 07:30:10', '2026-01-23 07:30:10'),
(1367, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-23 08:39:58', '2026-01-23 08:39:58'),
(1368, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-23 08:40:11', '2026-01-23 08:40:11'),
(1369, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2031-01-23)', NULL, '2026-01-23 08:43:44', '2026-01-23 08:43:44'),
(1370, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-23 08:45:21', '2026-01-23 08:45:21'),
(1371, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-23 08:45:47', '2026-01-23 08:45:47'),
(1372, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2031-01-23)', NULL, '2026-01-23 08:45:52', '2026-01-23 08:45:52'),
(1373, '2', NULL, 'legal_document_approved', 'Approved legal document: Guest Agreement Template', NULL, '2026-01-23 08:46:12', '2026-01-23 08:46:12'),
(1374, '2', NULL, 'legal_document_archived', 'Archived legal document: Guest Agreement Template (Disposal: 2031-01-23)', NULL, '2026-01-23 08:46:18', '2026-01-23 08:46:18'),
(1375, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-23 08:47:46', '2026-01-23 08:47:46'),
(1376, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2032-01-23)', NULL, '2026-01-23 08:47:54', '2026-01-23 08:47:54'),
(1377, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-23 08:48:59', '2026-01-23 08:48:59'),
(1378, '2', NULL, 'legal_document_approved', 'Approved legal document: Employment Contract Template', NULL, '2026-01-23 08:49:21', '2026-01-23 08:49:21'),
(1379, '2', NULL, 'legal_document_archived', 'Archived legal document: Employment Contract Template (Disposal: 2033-01-23)', NULL, '2026-01-23 08:49:49', '2026-01-23 08:49:49'),
(1380, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Employment Contract Template', NULL, '2026-01-23 08:59:33', '2026-01-23 08:59:33'),
(1381, '2', 388, 'document_view', 'Document view: Employment Contract Template (ID: 388)', '{\"document_id\":388,\"document_title\":\"Employment Contract Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T12:59:26.469188Z\"}', '2026-01-23 12:59:26', '2026-01-23 12:59:26'),
(1382, '2', 388, 'document_view', 'Document view: Employment Contract Template (ID: 388)', '{\"document_id\":388,\"document_title\":\"Employment Contract Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T13:05:03.691392Z\"}', '2026-01-23 13:05:03', '2026-01-23 13:05:03'),
(1383, '2', 388, 'document_view', 'Document view: Employment Contract Template (ID: 388)', '{\"document_id\":388,\"document_title\":\"Employment Contract Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T13:05:24.014612Z\"}', '2026-01-23 13:05:24', '2026-01-23 13:05:24'),
(1384, '2', 388, 'document_view', 'Document view: Employment Contract Template (ID: 388)', '{\"document_id\":388,\"document_title\":\"Employment Contract Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T13:05:50.363126Z\"}', '2026-01-23 13:05:50', '2026-01-23 13:05:50'),
(1385, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 390', NULL, '2026-01-23 13:42:14', '2026-01-23 13:42:14'),
(1386, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 391', NULL, '2026-01-23 13:42:14', '2026-01-23 13:42:14'),
(1387, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 392', NULL, '2026-01-23 13:55:56', '2026-01-23 13:55:56'),
(1388, '2', 392, 'document_view', 'Document view: Employee Contract - 69737decb377e (ID: 392)', '{\"document_id\":392,\"document_title\":\"Employee Contract - 69737decb377e\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T14:00:10.607258Z\"}', '2026-01-23 14:00:10', '2026-01-23 14:00:10'),
(1389, '2', 392, 'document_view', 'Document view: Employee Contract - 69737decb377e (ID: 392)', '{\"document_id\":392,\"document_title\":\"Employee Contract - 69737decb377e\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T14:07:29.533882Z\"}', '2026-01-23 14:07:29', '2026-01-23 14:07:29'),
(1390, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 393', NULL, '2026-01-23 14:31:20', '2026-01-23 14:31:20'),
(1391, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 394', NULL, '2026-01-23 14:32:28', '2026-01-23 14:32:28'),
(1392, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 395', NULL, '2026-01-23 14:32:28', '2026-01-23 14:32:28'),
(1393, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 396', NULL, '2026-01-23 14:38:42', '2026-01-23 14:38:42'),
(1394, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 402', NULL, '2026-01-23 14:59:47', '2026-01-23 14:59:47'),
(1395, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 403', NULL, '2026-01-23 15:02:15', '2026-01-23 15:02:15'),
(1396, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 404', NULL, '2026-01-23 15:02:47', '2026-01-23 15:02:47'),
(1397, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-23 15:07:31', '2026-01-23 15:07:31'),
(1398, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 15:08:00', '2026-01-23 15:08:00'),
(1399, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 405', NULL, '2026-01-23 15:08:16', '2026-01-23 15:08:16'),
(1400, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 406', NULL, '2026-01-23 15:08:41', '2026-01-23 15:08:41'),
(1401, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 407', NULL, '2026-01-23 15:12:06', '2026-01-23 15:12:06'),
(1402, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 408', NULL, '2026-01-23 15:13:56', '2026-01-23 15:13:56'),
(1403, '2', NULL, 'document_lifecycle_imported', 'Document lifecycle: imported for document ID 409', NULL, '2026-01-23 15:20:59', '2026-01-23 15:20:59'),
(1404, '2', NULL, 'save_legal_draft', 'Saved legal document draft: HR Policy Template', NULL, '2026-01-23 15:58:20', '2026-01-23 15:58:20'),
(1405, '2', NULL, 'legal_document_approved', 'Approved legal document: HR Policy Template', NULL, '2026-01-23 16:08:59', '2026-01-23 16:08:59'),
(1406, '2', NULL, 'legal_document_archived', 'Archived legal document: HR Policy Template (Disposal: 2033-01-24)', NULL, '2026-01-23 16:09:04', '2026-01-23 16:09:04'),
(1407, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 17:29:50', '2026-01-23 17:29:50'),
(1408, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-23 20:40:47', '2026-01-23 20:40:47'),
(1409, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 20:42:26', '2026-01-23 20:42:26'),
(1410, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-23 20:44:28', '2026-01-23 20:44:28'),
(1411, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:46:20', '2026-01-23 20:46:20'),
(1412, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:46:56', '2026-01-23 20:46:56'),
(1413, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:50:42', '2026-01-23 20:50:42'),
(1414, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:50:54', '2026-01-23 20:50:54'),
(1415, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:51:04', '2026-01-23 20:51:04'),
(1416, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:51:17', '2026-01-23 20:51:17'),
(1417, '2', NULL, 'Login_failed', 'Invalid password provided', NULL, '2026-01-23 20:51:28', '2026-01-23 20:51:28'),
(1418, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-23 23:08:04', '2026-01-23 23:08:04'),
(1419, '2', 412, 'document_view', 'Document view: HR Policy Template (ID: 412)', '{\"document_id\":412,\"document_title\":\"HR Policy Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-23T23:08:35.853467Z\"}', '2026-01-23 23:08:35', '2026-01-23 23:08:35'),
(1420, '2', 412, 'document_download', 'Document download: HR Policy Template (ID: 412)', '{\"document_id\":412,\"document_title\":\"HR Policy Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"download\",\"timestamp\":\"2026-01-23T23:08:42.437234Z\"}', '2026-01-23 23:08:42', '2026-01-23 23:08:42'),
(1421, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-24 00:25:59', '2026-01-24 00:25:59'),
(1422, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 00:33:46', '2026-01-24 00:33:46'),
(1423, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-24 00:49:50', '2026-01-24 00:49:50'),
(1424, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 00:54:40', '2026-01-24 00:54:40'),
(1425, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 01:09:43', '2026-01-24 01:09:43'),
(1426, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-24 01:10:01', '2026-01-24 01:10:01'),
(1427, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 01:13:13', '2026-01-24 01:13:13'),
(1428, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 01:21:49', '2026-01-24 01:21:49'),
(1429, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 01:25:52', '2026-01-24 01:25:52'),
(1430, '2', 412, 'document_view', 'Document view: HR Policy Template (ID: 412)', '{\"document_id\":412,\"document_title\":\"HR Policy Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-24T02:29:29.071672Z\"}', '2026-01-24 02:29:29', '2026-01-24 02:29:29'),
(1431, '2', NULL, 'save_legal_draft', 'Saved legal document draft: Memorandum Template', NULL, '2026-01-24 02:54:14', '2026-01-24 02:54:14'),
(1432, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 08:58:32', '2026-01-24 08:58:32'),
(1433, '2', 412, 'document_view', 'Document view: HR Policy Template (ID: 412)', '{\"document_id\":412,\"document_title\":\"HR Policy Template\",\"confidentiality\":null,\"user_role\":\"Administrator\",\"action_type\":\"view\",\"timestamp\":\"2026-01-24T09:08:02.314326Z\"}', '2026-01-24 09:08:02', '2026-01-24 09:08:02'),
(1434, '2', NULL, 'legal_document_approved', 'Approved legal document: Memorandum Template', NULL, '2026-01-24 09:10:33', '2026-01-24 09:10:33'),
(1435, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-24 09:54:10', '2026-01-24 09:54:10'),
(1436, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-24 11:30:36', '2026-01-24 11:30:36'),
(1437, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-24 12:25:28', '2026-01-24 12:25:28'),
(1438, '2', NULL, 'Login', 'User logged in successfully with OTP', NULL, '2026-01-26 11:46:30', '2026-01-26 11:46:30'),
(1439, '2', NULL, 'Logout', 'User logged out successfully', NULL, '2026-01-26 11:59:39', '2026-01-26 11:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `activity_stream`
--

CREATE TABLE `activity_stream` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `performed_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performed_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('critical','warning','info','success') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('active','acknowledged','resolved') NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `type`, `title`, `message`, `status`, `location`, `created_at`, `updated_at`) VALUES
(1, 'critical', 'Kitchen Freezer Temperature Alert', 'Main kitchen freezer temperature has risen above safe levels (5°F)', 'active', 'Main Kitchen', '2025-07-10 06:57:51', '2025-07-10 06:57:51'),
(2, 'warning', 'High Energy Usage Detected', 'Energy consumption in guest rooms is 15% above normal levels', 'acknowledged', 'Guest Rooms - Floor 3', '2025-07-09 06:57:51', '2025-07-09 06:57:51'),
(3, 'critical', 'Kitchen Freezer Temperature Alert', 'Main kitchen freezer temperature has risen above safe levels (5°F)', 'active', 'Main Kitchen', '2025-08-24 23:17:10', '2025-08-24 23:17:10'),
(4, 'warning', 'High Energy Usage Detected', 'Energy consumption in guest rooms is 15% above normal levels', 'acknowledged', 'Guest Rooms - Floor 3', '2025-08-23 23:17:10', '2025-08-23 23:17:10'),
(5, 'critical', 'Kitchen Freezer Temperature Alert', 'Main kitchen freezer temperature has risen above safe levels (5°F)', 'active', 'Main Kitchen', '2025-09-13 20:10:39', '2025-09-13 20:10:39'),
(6, 'warning', 'High Energy Usage Detected', 'Energy consumption in guest rooms is 15% above normal levels', 'acknowledged', 'Guest Rooms - Floor 3', '2025-09-12 20:10:39', '2025-09-12 20:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `bulk_visit_sessions`
--

CREATE TABLE `bulk_visit_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visit_date` datetime NOT NULL,
  `expected_headcount` int(11) NOT NULL DEFAULT 1,
  `visitor_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `qr_code_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulk_visit_sessions`
--

INSERT INTO `bulk_visit_sessions` (`id`, `group_name`, `host_name`, `department`, `purpose`, `visit_date`, `expected_headcount`, `visitor_data`, `qr_code_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Walk-in Group', 'Reception/Staff', 'core_1', 'Walk-in Visit', '2026-01-23 14:50:00', 3, '[{\"name\":\"sgs\",\"email\":\"seg@gmail.com\",\"phone\":\"345353\",\"company\":\"ghmhg\",\"host\":\"ttnym\"},{\"name\":\"gmghm\",\"email\":\"dfbdf@gmail.com\",\"phone\":\"y5u56568756\",\"company\":\"h56756gjg\",\"host\":\"bnm nbmbn\"},{\"name\":\"sdgshh\",\"email\":\"seg@gmail.com\",\"phone\":\"456456456\",\"company\":\"ghmghm\",\"host\":\"gmg\"}]', 'hzL9zy7rYgy1Uco304U5WTTlVWhUEz9D', 'completed', '2026-01-23 06:50:44', '2026-01-23 06:50:56'),
(2, 'Walk-in Group', 'Reception/Staff', 'core_1', 'Walk-in Visit', '2026-01-23 15:07:00', 3, '[{\"name\":\"erge\",\"email\":null,\"phone\":null,\"company\":null,\"host\":null},{\"name\":\"reger\",\"email\":null,\"phone\":null,\"company\":null,\"host\":null},{\"name\":\"re\",\"email\":null,\"phone\":null,\"company\":null,\"host\":null}]', 'uz2W9lk58I0yKsE6qWX9IgbGDX0lbj03', 'completed', '2026-01-23 07:07:14', '2026-01-23 07:07:21'),
(3, 'Walk-in Group', 'Reception/Staff', 'core_1', 'Walk-in Visit', '2026-01-23 17:00:00', 3, '[{\"name\":\"jane\",\"email\":\"jane@gmail.com\",\"phone\":\"09546564454\",\"company\":\"none\",\"host\":\"jez\"},{\"name\":\"ben\",\"email\":\"ben@gmaill.com\",\"phone\":\"098464648449\",\"company\":\"none\",\"host\":\"carl\"},{\"name\":\"jack froz\",\"email\":\"jack@gmail.com\",\"phone\":\"095545644465\",\"company\":\"none\",\"host\":\"ted\"}]', 'zNIcGpLwKxeuVcWmGkuqvVcDN2JCCbFd', 'completed', '2026-01-23 09:01:39', '2026-01-23 09:01:59'),
(4, 'Walk-in Group', 'Reception/Staff', 'core_1', 'Walk-in Visit', '2026-01-24 00:41:00', 3, '[{\"name\":\"rock leon\",\"email\":\"rock@gmail.com\",\"phone\":\"09245642154\",\"company\":\"consulting\",\"host\":\"jake\"},{\"name\":\"jake cruz\",\"email\":\"jake@gmail.com\",\"phone\":\"09124679223\",\"company\":\"hospital\",\"host\":\"jade\"},{\"name\":\"dave cruz\",\"email\":null,\"phone\":null,\"company\":null,\"host\":null}]', 'TIZFykHuLUZfTDz3hZdFnfE9uICli4gx', 'completed', '2026-01-23 16:42:51', '2026-01-23 16:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `case_activities`
--

CREATE TABLE `case_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_activities`
--

INSERT INTO `case_activities` (`id`, `legal_case_id`, `user_id`, `user_name`, `action_type`, `action_description`, `changes`, `ip_address`, `created_at`, `updated_at`) VALUES
(2, 45, NULL, ' ', 'case_created', 'Case created: Visitor Violation – flora', '{\"case_number\": \"LC-2025-0030\"}', '127.0.0.1', '2025-11-27 17:20:55', '2025-11-27 17:20:55'),
(3, 45, NULL, ' ', 'case_created', 'Violation reported from Visitor Log', '{\"priority\": \"high\", \"visitor_id\": 192, \"visitor_name\": \"flora\", \"violation_type\": \"security_breach\"}', '127.0.0.1', '2025-11-27 17:20:55', '2025-11-27 17:20:55'),
(8, 45, '2', ' ', 'stage_changed', 'Case moved from filing to investigation', '{\"old_stage\":\"filing\",\"new_stage\":\"investigation\",\"notes\":\"kl;kl;\"}', '127.0.0.1', '2026-01-21 17:29:24', '2026-01-21 17:29:24'),
(9, 46, '2', ' ', 'case_created', 'Case created: Visitor Violation – adminneto', '{\"case_number\":\"LC-2026-0001\"}', '127.0.0.1', '2026-01-22 04:34:23', '2026-01-22 04:34:23'),
(10, 46, '2', ' ', 'case_created', 'Violation reported from Visitor Log', '{\"visitor_id\":191,\"visitor_name\":\"adminneto\",\"violation_type\":\"disruptive_behavior\",\"priority\":\"high\"}', '127.0.0.1', '2026-01-22 04:34:23', '2026-01-22 04:34:23'),
(11, 46, '2', 'Michael Petras', 'stage_changed', 'Case moved from filing to investigation', '{\"old_stage\":\"filing\",\"new_stage\":\"investigation\",\"notes\":\"HTRHTR\",\"status\":\"under_investigation\"}', '127.0.0.1', '2026-01-22 05:42:53', '2026-01-22 05:42:53'),
(12, 46, '2', 'Michael Petras', 'evidence_added', 'Evidence file uploaded: thrt', '{\"file_name\":\"1769061394_visitor violation.docx\",\"type\":\"document\"}', '127.0.0.1', '2026-01-22 05:56:34', '2026-01-22 05:56:34'),
(13, 46, '2', 'Michael Petras', 'stage_changed', 'Case moved from investigation to review', '{\"old_stage\":\"investigation\",\"new_stage\":\"review\",\"notes\":null,\"status\":\"awaiting_review\"}', '127.0.0.1', '2026-01-22 05:56:46', '2026-01-22 05:56:46'),
(14, 46, '2', 'Michael Petras', 'stage_changed', 'Case moved from review to resolution', '{\"old_stage\":\"review\",\"new_stage\":\"resolution\",\"notes\":\"ewewe\",\"status\":\"resolved\"}', '127.0.0.1', '2026-01-22 05:57:49', '2026-01-22 05:57:49'),
(15, 46, '2', 'Michael Petras', 'stage_changed', 'Case moved from resolution to closed', '{\"old_stage\":\"resolution\",\"new_stage\":\"closed\",\"notes\":null,\"status\":\"completed\"}', '127.0.0.1', '2026-01-22 05:58:24', '2026-01-22 05:58:24'),
(16, 45, '2', 'Michael Petras', 'stage_changed', 'Case moved from investigation to review', '{\"old_stage\":\"investigation\",\"new_stage\":\"review\",\"notes\":\"fgfdge\",\"status\":\"awaiting_review\"}', '127.0.0.1', '2026-01-22 08:38:06', '2026-01-22 08:38:06'),
(17, 45, '2', 'Michael Petras', 'stage_changed', 'Case moved from review to resolution', '{\"old_stage\":\"review\",\"new_stage\":\"resolution\",\"notes\":\"efvev\",\"status\":\"resolved\"}', '127.0.0.1', '2026-01-22 08:38:18', '2026-01-22 08:38:18'),
(18, 45, '2', 'Michael Petras', 'stage_changed', 'Case moved from resolution to closed', '{\"old_stage\":\"resolution\",\"new_stage\":\"closed\",\"notes\":\"close\",\"status\":\"completed\"}', '127.0.0.1', '2026-01-22 08:39:05', '2026-01-22 08:39:05'),
(19, 47, '2', 'Michael Petras', 'case_created', 'Case created: Trespassing', '{\"case_number\":\"LC-2026-0002\"}', '127.0.0.1', '2026-01-22 08:40:28', '2026-01-22 08:40:28'),
(20, 47, '2', 'Michael Petras', 'case_created', 'Violation reported from Visitor Log', '{\"visitor_id\":187,\"visitor_name\":\"jake\",\"violation_type\":\"trespassing\",\"priority\":\"high\"}', '127.0.0.1', '2026-01-22 08:40:28', '2026-01-22 08:40:28'),
(21, 47, '2', 'Michael Petras', 'stage_changed', 'Case moved from filing to investigation', '{\"old_stage\":\"filing\",\"new_stage\":\"investigation\",\"notes\":\"dfbdfb\",\"status\":\"under_investigation\"}', '127.0.0.1', '2026-01-22 08:41:24', '2026-01-22 08:41:24'),
(22, 47, '2', 'Michael Petras', 'evidence_added', 'Evidence file uploaded: thrt', '{\"file_name\":\"1769072214_visitor violation.docx\",\"type\":\"document\"}', '127.0.0.1', '2026-01-22 08:56:54', '2026-01-22 08:56:54'),
(23, 47, '2', 'Michael Petras', 'stage_changed', 'Case moved from investigation to review', '{\"old_stage\":\"investigation\",\"new_stage\":\"review\",\"notes\":null,\"status\":\"awaiting_review\"}', '127.0.0.1', '2026-01-22 08:57:44', '2026-01-22 08:57:44'),
(24, 48, '2', 'Michael Petras', 'case_created', 'Case created: Security Breach', '{\"case_number\":\"LC-2026-0003\"}', '127.0.0.1', '2026-01-22 09:01:00', '2026-01-22 09:01:00'),
(25, 48, '2', 'Michael Petras', 'case_created', 'Violation reported from Visitor Log', '{\"visitor_id\":185,\"visitor_name\":\"bren\",\"violation_type\":\"security_breach\",\"priority\":\"urgent\"}', '127.0.0.1', '2026-01-22 09:01:00', '2026-01-22 09:01:00'),
(26, 48, '2', 'Michael Petras', 'stage_changed', 'Case moved from filing to investigation', '{\"old_stage\":\"filing\",\"new_stage\":\"investigation\",\"notes\":\"thrthrt\",\"status\":\"under_investigation\"}', '127.0.0.1', '2026-01-22 09:10:54', '2026-01-22 09:10:54'),
(27, 48, '2', 'Michael Petras', 'evidence_added', 'Evidence file uploaded: gfngf', '{\"file_name\":\"1769073416_visitor violation.docx\",\"type\":\"document\"}', '127.0.0.1', '2026-01-22 09:16:56', '2026-01-22 09:16:56'),
(28, 48, '2', 'Michael Petras', 'stage_changed', 'Case moved from investigation to review', '{\"old_stage\":\"investigation\",\"new_stage\":\"review\",\"notes\":null,\"status\":\"awaiting_review\"}', '127.0.0.1', '2026-01-22 09:17:28', '2026-01-22 09:17:28'),
(29, 48, '2', 'Michael Petras', 'stage_changed', 'Case moved from review to resolution', '{\"old_stage\":\"review\",\"new_stage\":\"resolution\",\"notes\":\"rege\",\"status\":\"resolved\"}', '127.0.0.1', '2026-01-22 09:17:50', '2026-01-22 09:17:50'),
(30, 48, '2', 'Michael Petras', 'stage_changed', 'Case moved from resolution to closed', '{\"old_stage\":\"resolution\",\"new_stage\":\"closed\",\"notes\":\"fdbfdb\",\"status\":\"completed\"}', '127.0.0.1', '2026-01-22 09:18:23', '2026-01-22 09:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `case_dockets`
--

CREATE TABLE `case_dockets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `event_date` datetime NOT NULL,
  `event_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filing_party` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `court_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_evidence`
--

CREATE TABLE `case_evidence` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `evidence_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `uploaded_by` varchar(255) DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_evidence`
--

INSERT INTO `case_evidence` (`id`, `legal_case_id`, `evidence_type`, `title`, `description`, `file_path`, `file_name`, `file_type`, `file_size`, `uploaded_by`, `collected_at`, `created_at`, `updated_at`) VALUES
(1, 46, 'document', 'thrt', 'rtjhrtj', 'legal_evidence/1769061394_visitor violation.docx', '1769061394_visitor violation.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 14866, 'Michael Petras', '2026-01-23 00:00:00', '2026-01-22 05:56:34', '2026-01-22 05:56:34'),
(2, 47, 'document', 'thrt', 'hj,jh,', 'legal_evidence/1769072214_visitor violation.docx', '1769072214_visitor violation.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 14866, 'Michael Petras', '2026-01-23 00:00:00', '2026-01-22 08:56:54', '2026-01-22 08:56:54'),
(3, 48, 'document', 'gfngf', 'regre', 'legal_evidence/1769073416_visitor violation.docx', '1769073416_visitor violation.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 14866, 'Michael Petras', '2026-01-23 00:00:00', '2026-01-22 09:16:56', '2026-01-22 09:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `case_witnesses`
--

CREATE TABLE `case_witnesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `witness_name` varchar(255) NOT NULL,
  `witness_department` varchar(255) DEFAULT NULL,
  `witness_position` varchar(255) DEFAULT NULL,
  `witness_contact` varchar(255) DEFAULT NULL,
  `witness_email` varchar(255) DEFAULT NULL,
  `statement` text DEFAULT NULL,
  `statement_date` datetime DEFAULT NULL,
  `statement_type` enum('written','verbal','video','other') NOT NULL DEFAULT 'written',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_witnesses`
--

INSERT INTO `case_witnesses` (`id`, `legal_case_id`, `witness_name`, `witness_department`, `witness_position`, `witness_contact`, `witness_email`, `statement`, `statement_date`, `statement_type`, `created_at`, `updated_at`) VALUES
(1, 46, 'JAY', 'IT', 'DEV', '09911211407', 'pkewgwg@gmail.com', 'ergergergre', '2026-01-23 13:49:00', 'verbal', '2026-01-22 05:49:28', '2026-01-22 05:49:28'),
(2, 47, 'REN', 'DA', 'EGER', 'REGERG', 'JESG@gmail.com', 'dfbdfbdf', '2026-01-23 16:57:00', 'written', '2026-01-22 08:57:25', '2026-01-22 08:57:25'),
(3, 48, 'awfaw', 'rsger', 'erger', 'ergre', 'erger@gmail.com', 'erger', '2026-01-22 17:17:00', 'verbal', '2026-01-22 09:17:19', '2026-01-22 09:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `company_policies`
--

CREATE TABLE `company_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  `effective_date` date NOT NULL,
  `review_date` date DEFAULT NULL,
  `status` enum('active','draft','archived','superseded') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `related_laws` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `applicable_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_policy_versions`
--

CREATE TABLE `company_policy_versions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `change_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachments_snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_accounts`
--

CREATE TABLE `department_accounts` (
  `Dept_no` int(11) NOT NULL,
  `Dept_id` varchar(255) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_accounts`
--

INSERT INTO `department_accounts` (`Dept_no`, `Dept_id`, `dept_name`, `employee_name`, `employee_id`, `role`, `email`, `status`, `password`, `profile_picture`) VALUES
(1, 'AD2505', 'Administrative', 'Ernesto Piquero Jr', 'S250501', 'Super Admin', 'piqs09120@gmail.com', 'Active', '#S0107', NULL),
(2, 'AD2505', 'Administrative', 'Michael Petras', 'A250502', 'Administrator', 'michaelpetras123@gmail.com', 'Active', '#A0207', 'profile_pictures/profile_A250502_1768145838.jpg'),
(3, 'AD2505', 'Administrative', 'Alfred Pasinag', 'L250503', 'Legal officer', 'alfredpasinag6@gmail.com', 'Active', '#L0307', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_logs`
--

CREATE TABLE `department_logs` (
  `dept_logs_id` int(11) NOT NULL,
  `dept_id` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `log_status` varchar(255) NOT NULL,
  `attempt_count` int(11) NOT NULL,
  `failure_reason` varchar(255) DEFAULT NULL,
  `cooldown` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `log_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_table`
--

CREATE TABLE `department_table` (
  `Department_ID` int(11) NOT NULL,
  `Department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dept_audit_trail_&transaction`
--

CREATE TABLE `dept_audit_trail_&transaction` (
  `a&t_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `modules_cover` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposal_history`
--

CREATE TABLE `disposal_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `confidentiality_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retention_until` date DEFAULT NULL,
  `retention_policy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disposal_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disposed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `disposed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `lifecycle_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ai_analysis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_document_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linked_case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extracted_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_start_date` date DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `salary_amount` decimal(12,2) DEFAULT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PHP',
  `responsible_officer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT 1,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `external_reference_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import_source` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'document_management',
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_classification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'AI-detected document category',
  `ai_confidence` decimal(3,2) DEFAULT NULL COMMENT 'AI classification confidence score (0.00-1.00)',
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidentiality_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `retention_period` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retention_until` date DEFAULT NULL,
  `disposal_date` datetime DEFAULT NULL,
  `retention_years` int(11) DEFAULT NULL,
  `can_dispose` tinyint(1) NOT NULL DEFAULT 0,
  `disposal_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editing_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `collaborators` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `last_edited_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_edited_at` timestamp NULL DEFAULT NULL,
  `access_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `previous_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_in_disposal_review` tinyint(1) NOT NULL DEFAULT 0,
  `final_deletion_date` datetime DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `archived_at` timestamp NULL DEFAULT NULL,
  `archive_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `download_count` int(11) NOT NULL DEFAULT 0,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `last_accessed_at` timestamp NULL DEFAULT NULL,
  `last_accessed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_document_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_series` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version_number` int(11) NOT NULL DEFAULT 1,
  `is_latest_version` tinyint(1) NOT NULL DEFAULT 1,
  `approval_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approval_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `declined_by` bigint(20) UNSIGNED DEFAULT NULL,
  `decline_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `requires_signature` tinyint(1) NOT NULL DEFAULT 0,
  `signature_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_legal_document` tinyint(1) NOT NULL DEFAULT 0,
  `legal_classification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence_score` int(11) NOT NULL DEFAULT 50,
  `reasoning` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uncertainties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `executive_summary_purpose` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `executive_summary_obligations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `executive_summary_applicability` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_preview` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_frameworks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `risk_reasoning` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiration_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parties_involved` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `obligations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `document_type_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `context_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `action_item_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `manual_review_recommended` tinyint(1) NOT NULL DEFAULT 0,
  `manual_review_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medium',
  `next_steps` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `requires_legal_review` tinyint(1) NOT NULL DEFAULT 0,
  `requires_visitor_coordination` tinyint(1) NOT NULL DEFAULT 0,
  `legal_risk_score` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Low',
  `violation_score` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Low' COMMENT 'Violation risk score: Low, Medium, High, Critical',
  `violation_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Detailed violation analysis results',
  `flagged_issues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Specific issues flagged by AI analysis',
  `compliance_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unknown' COMMENT 'Compliance status: compliant, non_compliant, review_required, unknown',
  `compliance_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Detailed compliance analysis results',
  `regulatory_standards` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Applicable regulatory standards identified',
  `ai_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'AI-generated tags for document',
  `ai_insights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'AI-generated insights and recommendations',
  `ai_analysis_completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag indicating if AI analysis is complete',
  `ai_analysis_date` timestamp NULL DEFAULT NULL COMMENT 'Timestamp of last AI analysis',
  `requires_immediate_review` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag for high-risk documents requiring immediate attention',
  `alert_reasons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Reasons why document requires immediate review',
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `lifecycle_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Complete document lifecycle tracking',
  `legal_case_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Legal case information for high-risk documents',
  `linked_reservation_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Link to auto-created facility reservation',
  `workflow_stage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uploaded',
  `signature_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signed_at` timestamp NULL DEFAULT NULL,
  `signers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `final_pdf_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature_provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_analysis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `date_submitted` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `archived_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `legal_document_id`, `document_id`, `linked_case_id`, `reference_id`, `title`, `description`, `extracted_text`, `metadata`, `department`, `origin_department`, `employee_name`, `employee_email`, `position_title`, `employment_type`, `contract_start_date`, `contract_end_date`, `salary_amount`, `currency`, `responsible_officer`, `submission_notes`, `version`, `file_path`, `external_reference_id`, `import_source`, `original_filename`, `file_size`, `mime_type`, `status`, `source`, `category`, `ai_classification`, `ai_confidence`, `document_type`, `confidentiality_level`, `retention_period`, `retention_until`, `disposal_date`, `retention_years`, `can_dispose`, `disposal_reason`, `editing_history`, `collaborators`, `last_edited_by`, `last_edited_at`, `access_log`, `previous_status`, `is_in_disposal_review`, `final_deletion_date`, `is_archived`, `archived_at`, `archive_location`, `access_permissions`, `download_count`, `view_count`, `last_accessed_at`, `last_accessed_by`, `parent_document_id`, `document_series`, `version_number`, `is_latest_version`, `approval_status`, `approved_by`, `approved_at`, `approval_notes`, `declined_by`, `decline_reason`, `file_hash`, `tags`, `requires_signature`, `signature_data`, `is_legal_document`, `legal_classification`, `sub_category`, `confidence_score`, `reasoning`, `uncertainties`, `executive_summary_purpose`, `executive_summary_obligations`, `executive_summary_applicability`, `content_preview`, `legal_frameworks`, `risk_reasoning`, `review_reason`, `effective_date`, `expiration_date`, `parties_involved`, `obligations`, `document_type_tags`, `context_tags`, `action_item_tags`, `manual_review_recommended`, `manual_review_reason`, `priority`, `next_steps`, `requires_legal_review`, `requires_visitor_coordination`, `legal_risk_score`, `violation_score`, `violation_details`, `flagged_issues`, `compliance_status`, `compliance_details`, `regulatory_standards`, `ai_tags`, `ai_insights`, `ai_analysis_completed`, `ai_analysis_date`, `requires_immediate_review`, `alert_reasons`, `workflow_log`, `lifecycle_log`, `legal_case_data`, `linked_reservation_id`, `workflow_stage`, `signature_status`, `signed_at`, `signers`, `final_pdf_path`, `signature_provider_id`, `ai_analysis`, `author`, `uploaded_by`, `created_at`, `date_created`, `date_submitted`, `updated_at`, `reviewed_at`, `archived_by`) VALUES
(411, NULL, NULL, NULL, NULL, 'contract', 'Imported from HR3_Microservice microservice', NULL, '{\"simulated\":true,\"created_via\":\"admin_portal\",\"timestamp\":\"2026-01-23T15:49:22.326Z\"}', 'HR3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PHP', NULL, NULL, 1, 'documents/external_import_69739882aaf39.pdf', 'EXT-1769183362326-0osquggqy', 'HR3_Microservice', NULL, NULL, NULL, 'archived', 'external_integration', 'policy', NULL, NULL, NULL, 'confidential', NULL, '2036-01-23', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, '2026-01-23 15:49:22', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Medium', NULL, 0, 0, 'Low', 'Low', NULL, NULL, 'unknown', NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, '[{\"step\":\"imported\",\"timestamp\":\"2026-01-23T15:49:22.703357Z\",\"user_id\":2,\"details\":{\"source_system\":\"HR3_Microservice\",\"external_reference_id\":\"EXT-1769183362326-0osquggqy\",\"import_method\":\"API Integration (Microservice)\"},\"ip_address\":\"127.0.0.1\"}]', NULL, NULL, 'archived', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2026-01-23 15:49:22', NULL, NULL, '2026-01-23 15:49:22', NULL, NULL),
(412, NULL, NULL, NULL, NULL, 'HR Policy Template', 'Draft document created in drafting workspace', NULL, '{\"content\":\"<h1 class=\\\"ql-align-center\\\"><strong>SOLIERA HOTEL<\\/strong><\\/h1><p class=\\\"ql-align-center\\\">[HOTEL ADDRESS]<\\/p><p class=\\\"ql-align-center\\\">[CITY, STATE ZIP]<\\/p><h2 class=\\\"ql-align-center\\\"><strong>HUMAN RESOURCES POLICY<\\/strong><\\/h2><p class=\\\"ql-align-center\\\">Policy Number: <strong>[POLICY_NUMBER]<\\/strong><\\/p><p><strong>Policy Title:<\\/strong><\\/p><p>[POLICY_NAME]<\\/p><p><strong>Effective Date:<\\/strong><\\/p><p>January 23, 2026<\\/p><p><strong>Department:<\\/strong><\\/p><p>[DEPARTMENT]<\\/p><h3><strong>1. PURPOSE<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tThe purpose of this policy is to establish clear guidelines and standards for [POLICY_SUBJECT] within SOLIERA HOTEL. This policy ensures consistency, fairness, and compliance with applicable laws and regulations while promoting a positive work environment for all employees.<\\/p><h3><strong>2. SCOPE<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tThis policy applies to all employees of SOLIERA HOTEL, including full-time, part-time, temporary, and contract workers. It also extends to all departments and levels of management within the organization.<\\/p><h3><strong>3. POLICY STATEMENT<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tSOLIERA HOTEL is committed to [POLICY_COMMITMENT]. All employees are expected to adhere to the following principles and guidelines:<\\/p><ul><li>[PRINCIPLE_1]<\\/li><li>[PRINCIPLE_2]<\\/li><li>[PRINCIPLE_3]<\\/li><li>[PRINCIPLE_4]<\\/li><\\/ul><h3><strong>4. PROCEDURES<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tThe following procedures shall be followed to ensure proper implementation of this policy:<\\/p><ol><li>[PROCEDURE_1]<\\/li><li>[PROCEDURE_2]<\\/li><li>[PROCEDURE_3]<\\/li><li>[PROCEDURE_4]<\\/li><\\/ol><h3><strong>5. COMPLIANCE AND ENFORCEMENT<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tCompliance with this policy is mandatory for all employees. Violations of this policy may result in disciplinary action, up to and including termination of employment. The Human Resources Department is responsible for monitoring compliance and addressing any violations.<\\/p><h3><strong>6. REVIEW AND UPDATES<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\">\\tThis policy will be reviewed annually or as needed to ensure it remains current and effective. Any updates or changes will be communicated to all employees through appropriate channels.<\\/p><p class=\\\"ql-align-center\\\"><strong>[APPROVER_NAME]<\\/strong><\\/p><p class=\\\"ql-align-center\\\">Human Resources Director<\\/p><p class=\\\"ql-align-center\\\">Date: _______________<\\/p><p class=\\\"ql-align-center\\\"><strong>[GENERAL_MANAGER]<\\/strong><\\/p><p class=\\\"ql-align-center\\\">General Manager<\\/p><p class=\\\"ql-align-center\\\">Date: _______________<\\/p>\",\"created_in_workspace\":true,\"last_saved\":\"2026-01-23T15:58:20.683599Z\"}', 'HR1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PHP', NULL, NULL, 1, '', NULL, NULL, NULL, NULL, NULL, 'archived', 'legal_management', 'contract', NULL, NULL, NULL, 'internal', NULL, NULL, '2033-01-24 00:09:04', 7, 0, 'Administrative archive', NULL, NULL, NULL, NULL, '[{\"action\":\"view\",\"user_id\":2,\"user_name\":\"Michael Petras\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\",\"timestamp\":\"2026-01-23T23:08:35.849107Z\"},{\"action\":\"download\",\"user_id\":2,\"user_name\":\"Michael Petras\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\",\"timestamp\":\"2026-01-23T23:08:42.437660Z\"},{\"action\":\"view\",\"user_id\":2,\"user_name\":\"Michael Petras\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\",\"timestamp\":\"2026-01-24T02:29:29.066553Z\"},{\"action\":\"view\",\"user_id\":2,\"user_name\":\"Michael Petras\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\",\"timestamp\":\"2026-01-24T09:08:02.305814Z\"}]', NULL, 0, NULL, 0, '2026-01-23 16:09:04', NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, 1, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Medium', NULL, 0, 0, 'Low', 'Low', NULL, NULL, 'unknown', NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, '[{\"step\":\"archived_with_retention\",\"message\":\"Document archived with retention policy\",\"data\":{\"retention_years\":7,\"disposal_date\":\"2033-01-23T16:09:04.409502Z\",\"reason\":\"Administrative archive\"},\"timestamp\":\"2026-01-23T16:09:04.418962Z\",\"user_id\":2}]', NULL, NULL, NULL, 'uploaded', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2026-01-23 15:58:20', NULL, NULL, '2026-01-24 09:08:02', NULL, NULL),
(413, NULL, NULL, NULL, NULL, 'Memorandum Template', 'Draft document created in drafting workspace', NULL, '{\"content\":\"<p><br><\\/p><p> <\\/p><p class=\\\"ql-align-center\\\"><br><\\/p><h1 class=\\\"ql-align-center\\\"><strong>SOLIERA HOTEL<\\/strong><\\/h1><p class=\\\"ql-align-center\\\"><br><\\/p><p class=\\\"ql-align-center\\\">[HOTEL ADDRESS]<\\/p><p class=\\\"ql-align-center\\\"><br><\\/p><p class=\\\"ql-align-center\\\">[CITY, STATE ZIP]<\\/p><p class=\\\"ql-align-center\\\"><br><\\/p><p class=\\\"ql-align-center\\\"> <\\/p><h2 class=\\\"ql-align-center\\\"><strong>Memorandum Template<\\/strong><\\/h2><p class=\\\"ql-align-center\\\"><br><\\/p><p class=\\\"ql-align-center\\\">Date: <strong>January 24, 2026<\\/strong><\\/p><p class=\\\"ql-align-center\\\"><br><\\/p><p><br><\\/p><p> <\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"> <\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"> <\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"> <strong>TO:<\\/strong>[RECIPIENT_NAME] <strong>FROM:<\\/strong>[SENDER_NAME] <strong>DATE:<\\/strong>January 24, 2026 <strong>SUBJECT:[MEMORANDUM_SUBJECT]<\\/strong> <\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><h3 class=\\\"ql-align-justify\\\"><strong>1. BACKGROUND<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\">\\t[BACKGROUND_INFORMATION_CONTENT]<\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><h3 class=\\\"ql-align-justify\\\"><strong>2. DISCUSSION<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\">\\t[DETAILED_DISCUSSION_POINTS]<\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><h3 class=\\\"ql-align-justify\\\"><strong>3. RECOMMENDATION<\\/strong><\\/h3><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\">\\t[PROPOSED_ACTIONS_OR_SOLUTIONS]<\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\">Please acknowledge receipt of this memorandum and proceed as advised.<\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><strong>[SENDER_NAME]<\\/strong><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"> <span style=\\\"color: rgb(102, 102, 102);\\\">[SENDER_TITLE]<\\/span><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"><br><\\/p><p class=\\\"ql-align-justify\\\"> <\\/p>\",\"created_in_workspace\":true,\"last_saved\":\"2026-01-24T02:54:14.767847Z\"}', 'HR1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PHP', NULL, NULL, 1, '', NULL, NULL, NULL, NULL, NULL, 'approved', 'legal_management', 'memorandum', NULL, NULL, NULL, 'internal', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, 1, 1, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Medium', NULL, 0, 0, 'Low', 'Low', NULL, NULL, 'unknown', NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, 'uploaded', NULL, NULL, NULL, NULL, NULL, '{\"error\":false,\"category\":\"memorandum\",\"ai_classification\":\"memorandum\",\"confidence\":0.7,\"summary\":\"This appears to be a memorandum or internal communication document. Content preview: memorandum template draft document created in drafting workspace...\",\"key_info\":\"Document classified using enhanced fallback analysis with violation detection.\",\"legal_implications\":\"Limited legal implications identified\",\"compliance_status\":\"compliant\",\"tags\":[\"memorandum\",\"fallback_analysis\",\"memo\",\"document\",\"analysis\"],\"violation_analysis\":\"Document analyzed for potential legal violations and risks. No significant violations detected.\",\"violation_score\":\"Low\",\"flagged_issues\":[],\"compliance_details\":\"Document appears to comply with applicable regulations and standards.\",\"regulatory_standards\":[],\"ai_insights\":\"No specific insights generated\",\"suggested_clauses\":[\"Purpose\",\"Effective date\",\"Responsibilities\",\"Approvals\"],\"risky_terms\":[\"None detected\"],\"fallback\":true,\"requires_legal_review\":false,\"requires_visitor_coordination\":false,\"legal_risk_score\":\"Low\",\"requires_immediate_review\":false,\"extraction_quality\":\"medium\"}', NULL, 2, '2026-01-24 02:54:14', NULL, NULL, '2026-01-24 09:12:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `document_access_logs`
--

CREATE TABLE `document_access_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `accessed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_activities`
--

CREATE TABLE `document_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('upload','edit','view','download','restore') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_activities`
--

INSERT INTO `document_activities` (`id`, `document_id`, `user_id`, `action`, `data`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 320, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '84.130.206.152', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-15 13:11:37', '2025-08-15 13:11:37'),
(2, 294, 13, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.1\"}', '24.161.82.120', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-06 07:26:09', '2025-09-06 07:26:09'),
(3, 320, 12, 'view', '{\"duration\": 280, \"page_views\": 2}', '128.226.82.92', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-25 20:41:27', '2025-09-25 20:41:27'),
(4, 311, 13, 'download', '{\"file_size\": 1733540, \"download_method\": \"email\"}', '186.91.32.141', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-28 08:51:38', '2025-09-28 08:51:38'),
(5, 318, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.4\"}', '94.161.38.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-15 11:10:27', '2025-08-15 11:10:27'),
(6, 319, 12, 'view', '{\"duration\": 113, \"page_views\": 7}', '22.11.144.193', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-13 00:54:58', '2025-09-13 00:54:58'),
(7, 325, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '5.1.142.68', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-20 02:31:53', '2025-08-20 02:31:53'),
(8, 323, 12, 'download', '{\"file_size\": 7579862, \"download_method\": \"direct\"}', '117.250.116.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-16 17:26:19', '2025-10-16 17:26:19'),
(9, 318, 13, 'view', '{\"duration\": 268, \"page_views\": 10}', '235.129.168.64', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-07 10:01:31', '2025-10-07 10:01:31'),
(10, 324, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3253245, \"file_type\": \"pdf\"}', '16.35.205.227', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-07-31 10:45:15', '2025-07-31 10:45:15'),
(11, 323, 13, 'download', '{\"file_size\": 4458033, \"download_method\": \"direct\"}', '45.213.205.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-11 05:11:31', '2025-09-11 05:11:31'),
(12, 311, 12, 'download', '{\"file_size\": 1325155, \"download_method\": \"direct\"}', '144.225.153.59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-15 09:37:11', '2025-08-15 09:37:11'),
(13, 289, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 3106009, \"file_type\": \"docx\"}', '118.150.238.97', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-17 06:24:30', '2025-10-17 06:24:30'),
(14, 318, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 6233058, \"file_type\": \"xlsx\"}', '26.196.14.20', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-06 05:42:09', '2025-08-06 05:42:09'),
(15, 320, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '149.68.74.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-29 16:55:57', '2025-09-29 16:55:57'),
(16, 325, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3055944, \"file_type\": \"pptx\"}', '25.39.128.221', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-16 17:15:16', '2025-10-16 17:15:16'),
(17, 314, 12, 'download', '{\"file_size\": 5086201, \"download_method\": \"direct\"}', '126.212.109.119', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-30 15:15:19', '2025-09-30 15:15:19'),
(18, 313, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '33.215.214.41', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-03 08:37:55', '2025-08-03 08:37:55'),
(19, 325, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 9000023, \"file_type\": \"pdf\"}', '14.184.133.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-08 07:11:22', '2025-10-08 07:11:22'),
(20, 322, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 9594570, \"file_type\": \"pptx\"}', '116.36.23.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-31 18:21:00', '2025-08-31 18:21:00'),
(21, 322, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '23.135.228.210', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-18 08:48:04', '2025-10-18 08:48:04'),
(22, 315, 12, 'view', '{\"duration\": 238, \"page_views\": 10}', '176.212.164.46', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-29 19:36:27', '2025-08-29 19:36:27'),
(23, 293, 13, 'download', '{\"file_size\": 8158539, \"download_method\": \"direct\"}', '157.240.213.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-03 07:09:11', '2025-10-03 07:09:11'),
(24, 293, 12, 'view', '{\"duration\": 287, \"page_views\": 9}', '221.130.179.116', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-23 03:26:00', '2025-09-23 03:26:00'),
(25, 290, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '109.228.37.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-07 22:43:17', '2025-09-07 22:43:17'),
(26, 325, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '23.96.188.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-23 01:08:12', '2025-09-23 01:08:12'),
(27, 291, 13, 'view', '{\"duration\": 197, \"page_views\": 7}', '210.48.45.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-18 06:55:13', '2025-09-18 06:55:13'),
(28, 313, 12, 'view', '{\"duration\": 151, \"page_views\": 6}', '40.155.141.249', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-15 23:53:41', '2025-08-15 23:53:41'),
(29, 290, 12, 'view', '{\"duration\": 187, \"page_views\": 6}', '160.86.57.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-11 18:05:12', '2025-09-11 18:05:12'),
(30, 313, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 6796848, \"file_type\": \"pptx\"}', '99.185.218.57', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-28 23:51:39', '2025-08-28 23:51:39'),
(31, 316, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '6.188.217.68', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-08 02:27:10', '2025-09-08 02:27:10'),
(32, 317, 12, 'view', '{\"duration\": 39, \"page_views\": 9}', '126.184.96.92', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-22 12:20:18', '2025-08-22 12:20:18'),
(33, 311, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '46.36.102.255', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-31 10:10:35', '2025-08-31 10:10:35'),
(34, 289, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 8262706, \"file_type\": \"pptx\"}', '165.108.154.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-21 08:01:19', '2025-10-21 08:01:19'),
(35, 316, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '196.116.96.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-07 04:07:07', '2025-09-07 04:07:07'),
(36, 317, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.3\"}', '38.16.2.153', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-01 09:51:26', '2025-09-01 09:51:26'),
(37, 289, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '153.133.23.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-06 00:12:55', '2025-08-06 00:12:55'),
(38, 311, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '98.137.136.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-13 21:53:01', '2025-08-13 21:53:01'),
(39, 319, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '157.32.190.220', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-02 05:37:46', '2025-08-02 05:37:46'),
(40, 311, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '70.96.15.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-23 02:15:58', '2025-09-23 02:15:58'),
(41, 325, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 9946090, \"file_type\": \"xlsx\"}', '61.197.38.22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-11 17:30:18', '2025-10-11 17:30:18'),
(42, 319, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '197.22.37.205', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-15 14:45:09', '2025-08-15 14:45:09'),
(43, 324, 12, 'download', '{\"file_size\": 8259415, \"download_method\": \"direct\"}', '228.119.45.82', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-04 02:10:24', '2025-10-04 02:10:24'),
(44, 320, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 4161054, \"file_type\": \"pdf\"}', '231.63.71.169', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-03 10:09:22', '2025-08-03 10:09:22'),
(45, 318, 12, 'download', '{\"file_size\": 8533078, \"download_method\": \"email\"}', '207.40.101.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-31 11:52:31', '2025-07-31 11:52:31'),
(46, 292, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '161.4.22.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-10 23:02:24', '2025-10-10 23:02:24'),
(47, 314, 13, 'view', '{\"duration\": 25, \"page_views\": 1}', '225.66.72.205', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-28 02:36:56', '2025-08-28 02:36:56'),
(48, 290, 13, 'view', '{\"duration\": 213, \"page_views\": 1}', '121.155.128.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-04 08:15:37', '2025-08-04 08:15:37'),
(49, 290, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '203.161.131.5', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-27 20:50:36', '2025-09-27 20:50:36'),
(50, 325, 13, 'download', '{\"file_size\": 1258741, \"download_method\": \"email\"}', '151.243.49.117', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-06 20:34:44', '2025-10-06 20:34:44'),
(51, 290, 13, 'view', '{\"duration\": 56, \"page_views\": 4}', '179.242.11.211', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-26 03:28:26', '2025-07-26 03:28:26'),
(52, 313, 12, 'download', '{\"file_size\": 199337, \"download_method\": \"email\"}', '106.51.41.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-30 16:28:31', '2025-08-30 16:28:31'),
(53, 293, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '33.150.147.172', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-05 15:07:46', '2025-08-05 15:07:46'),
(54, 323, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 1359631, \"file_type\": \"pdf\"}', '150.218.133.145', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-03 04:43:40', '2025-10-03 04:43:40'),
(55, 316, 12, 'download', '{\"file_size\": 1339334, \"download_method\": \"email\"}', '106.86.220.250', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-24 09:02:49', '2025-09-24 09:02:49'),
(56, 294, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '137.42.80.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-19 20:50:51', '2025-08-19 20:50:51'),
(57, 292, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '48.221.13.217', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-11 13:08:32', '2025-08-11 13:08:32'),
(58, 288, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '80.155.101.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-24 17:41:38', '2025-09-24 17:41:38'),
(59, 292, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '74.138.153.111', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-10 17:25:26', '2025-10-10 17:25:26'),
(60, 289, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '121.24.185.50', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-26 19:09:16', '2025-08-26 19:09:16'),
(61, 325, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '227.108.8.120', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-18 05:16:34', '2025-09-18 05:16:34'),
(62, 316, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '155.242.252.218', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-14 07:46:47', '2025-09-14 07:46:47'),
(63, 323, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '89.230.139.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-13 18:09:04', '2025-10-13 18:09:04'),
(64, 315, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '26.101.164.123', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-23 07:21:48', '2025-08-23 07:21:48'),
(65, 322, 12, 'download', '{\"file_size\": 6618257, \"download_method\": \"email\"}', '16.103.240.176', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-12 09:48:17', '2025-08-12 09:48:17'),
(66, 323, 13, 'view', '{\"duration\": 65, \"page_views\": 5}', '248.71.112.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-23 08:28:41', '2025-08-23 08:28:41'),
(67, 311, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '131.255.20.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-29 06:56:49', '2025-08-29 06:56:49'),
(68, 319, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.4\"}', '178.178.115.214', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-12 17:38:23', '2025-08-12 17:38:23'),
(69, 323, 12, 'download', '{\"file_size\": 5895914, \"download_method\": \"direct\"}', '174.43.69.113', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-21 07:02:45', '2025-08-21 07:02:45'),
(70, 315, 13, 'view', '{\"duration\": 71, \"page_views\": 8}', '82.215.148.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-19 17:18:28', '2025-10-19 17:18:28'),
(71, 293, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '142.194.251.48', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-02 15:25:29', '2025-09-02 15:25:29'),
(72, 320, 13, 'download', '{\"file_size\": 7480485, \"download_method\": \"direct\"}', '100.9.144.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-11 15:24:53', '2025-10-11 15:24:53'),
(73, 290, 13, 'view', '{\"duration\": 205, \"page_views\": 9}', '169.188.25.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-08 04:49:45', '2025-08-08 04:49:45'),
(74, 325, 12, 'download', '{\"file_size\": 1437078, \"download_method\": \"email\"}', '1.76.2.56', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-05 16:39:24', '2025-09-05 16:39:24'),
(75, 314, 12, 'download', '{\"file_size\": 3888354, \"download_method\": \"email\"}', '25.201.222.254', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-04 02:45:26', '2025-08-04 02:45:26'),
(76, 315, 12, 'download', '{\"file_size\": 5444374, \"download_method\": \"email\"}', '154.136.199.23', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-11 03:56:16', '2025-08-11 03:56:16'),
(77, 322, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.4\"}', '130.153.72.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-13 14:11:07', '2025-08-13 14:11:07'),
(78, 317, 13, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.3\"}', '119.136.71.80', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-29 09:58:24', '2025-09-29 09:58:24'),
(79, 290, 13, 'download', '{\"file_size\": 4406971, \"download_method\": \"email\"}', '77.208.151.252', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-05 09:05:03', '2025-09-05 09:05:03'),
(80, 323, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 284159, \"file_type\": \"pdf\"}', '146.170.129.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-16 05:26:14', '2025-09-16 05:26:14'),
(81, 326, 13, 'view', '{\"duration\": 75, \"page_views\": 8}', '189.123.17.56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-19 16:57:23', '2025-09-19 16:57:23'),
(82, 320, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 2047602, \"file_type\": \"pdf\"}', '231.238.98.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-26 03:56:56', '2025-07-26 03:56:56'),
(83, 326, 12, 'download', '{\"file_size\": 7808595, \"download_method\": \"email\"}', '125.4.24.133', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-27 09:19:27', '2025-09-27 09:19:27'),
(84, 324, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 4197792, \"file_type\": \"pptx\"}', '187.229.225.110', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-29 04:35:11', '2025-08-29 04:35:11'),
(85, 291, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '143.212.30.198', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-16 22:23:20', '2025-10-16 22:23:20'),
(86, 292, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '250.40.120.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-19 02:56:23', '2025-08-19 02:56:23'),
(87, 290, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '185.198.248.109', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-15 17:08:15', '2025-08-15 17:08:15'),
(88, 314, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 8008989, \"file_type\": \"xlsx\"}', '64.179.136.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-04 19:23:29', '2025-08-04 19:23:29'),
(89, 325, 12, 'view', '{\"duration\": 191, \"page_views\": 4}', '124.41.75.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-02 17:51:59', '2025-09-02 17:51:59'),
(90, 320, 12, 'download', '{\"file_size\": 9379490, \"download_method\": \"direct\"}', '69.41.139.132', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-02 15:19:07', '2025-08-02 15:19:07'),
(91, 324, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '96.155.158.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-13 21:03:12', '2025-09-13 21:03:12'),
(92, 292, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '43.15.99.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-25 08:13:22', '2025-08-25 08:13:22'),
(93, 322, 13, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.4\"}', '86.2.148.130', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-22 05:14:08', '2025-08-22 05:14:08'),
(94, 292, 12, 'view', '{\"duration\": 55, \"page_views\": 3}', '251.181.45.203', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-28 18:33:17', '2025-08-28 18:33:17'),
(95, 292, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '251.66.128.224', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-15 00:39:55', '2025-08-15 00:39:55'),
(96, 325, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 6395323, \"file_type\": \"pdf\"}', '238.1.130.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-27 06:24:06', '2025-09-27 06:24:06'),
(97, 315, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '39.240.237.231', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-05 22:36:08', '2025-10-05 22:36:08'),
(98, 288, 13, 'view', '{\"duration\": 18, \"page_views\": 9}', '45.2.161.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-28 00:20:29', '2025-09-28 00:20:29'),
(99, 293, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 4783533, \"file_type\": \"pptx\"}', '50.146.255.187', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-12 03:56:14', '2025-10-12 03:56:14'),
(100, 325, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 621969, \"file_type\": \"pptx\"}', '43.246.48.197', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-28 21:12:54', '2025-09-28 21:12:54'),
(101, 290, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 1944399, \"file_type\": \"pdf\"}', '143.96.50.204', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-07-27 07:10:27', '2025-07-27 07:10:27'),
(102, 293, 13, 'view', '{\"duration\": 131, \"page_views\": 5}', '152.24.119.3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-06 01:48:13', '2025-09-06 01:48:13'),
(103, 291, 13, 'view', '{\"duration\": 127, \"page_views\": 10}', '76.251.99.169', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-18 07:11:21', '2025-08-18 07:11:21'),
(104, 316, 12, 'download', '{\"file_size\": 4669375, \"download_method\": \"direct\"}', '201.88.47.175', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-11 16:46:43', '2025-09-11 16:46:43'),
(105, 322, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 2475437, \"file_type\": \"pptx\"}', '37.214.145.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-24 10:25:45', '2025-08-24 10:25:45'),
(106, 318, 13, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.5\"}', '2.199.150.187', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-30 21:29:55', '2025-08-30 21:29:55'),
(107, 313, 13, 'download', '{\"file_size\": 5992158, \"download_method\": \"direct\"}', '246.170.230.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-13 14:47:41', '2025-10-13 14:47:41'),
(108, 322, 12, 'download', '{\"file_size\": 2568346, \"download_method\": \"direct\"}', '91.151.208.65', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-06 11:42:38', '2025-10-06 11:42:38'),
(109, 293, 13, 'download', '{\"file_size\": 4675925, \"download_method\": \"email\"}', '102.67.117.60', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-13 12:30:50', '2025-08-13 12:30:50'),
(110, 292, 13, 'download', '{\"file_size\": 10096268, \"download_method\": \"direct\"}', '117.170.224.230', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-01 04:00:38', '2025-08-01 04:00:38'),
(111, 319, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 3104268, \"file_type\": \"docx\"}', '207.160.85.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-16 02:04:03', '2025-10-16 02:04:03'),
(112, 324, 13, 'view', '{\"duration\": 167, \"page_views\": 7}', '5.101.65.7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-07 19:44:36', '2025-08-07 19:44:36'),
(113, 318, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '124.72.3.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-31 07:40:01', '2025-08-31 07:40:01'),
(114, 324, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '252.79.53.224', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-16 02:44:36', '2025-10-16 02:44:36'),
(115, 320, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '119.193.85.49', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-11 09:18:21', '2025-10-11 09:18:21'),
(116, 291, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 2736338, \"file_type\": \"docx\"}', '172.187.62.27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-23 18:34:40', '2025-09-23 18:34:40'),
(117, 313, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '197.186.159.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-11 22:40:05', '2025-10-11 22:40:05'),
(118, 311, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 1218545, \"file_type\": \"pdf\"}', '169.120.226.250', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-04 07:56:39', '2025-08-04 07:56:39'),
(119, 326, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3699943, \"file_type\": \"pdf\"}', '247.87.37.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-03 08:45:42', '2025-10-03 08:45:42'),
(120, 289, 13, 'view', '{\"duration\": 207, \"page_views\": 1}', '35.241.114.208', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-22 02:45:03', '2025-08-22 02:45:03'),
(121, 322, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '27.96.97.17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 06:03:53', '2025-09-29 06:03:53'),
(122, 325, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 5993218, \"file_type\": \"xlsx\"}', '157.50.87.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-03 22:54:13', '2025-10-03 22:54:13'),
(123, 311, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '173.20.85.252', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-20 21:37:08', '2025-09-20 21:37:08'),
(124, 313, 13, 'view', '{\"duration\": 145, \"page_views\": 3}', '212.15.4.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-01 20:06:01', '2025-08-01 20:06:01'),
(125, 313, 12, 'view', '{\"duration\": 150, \"page_views\": 2}', '57.128.88.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 22:47:19', '2025-09-29 22:47:19'),
(126, 320, 12, 'view', '{\"duration\": 221, \"page_views\": 10}', '190.190.218.114', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-02 08:05:14', '2025-09-02 08:05:14'),
(127, 318, 12, 'view', '{\"duration\": 287, \"page_views\": 5}', '40.199.31.163', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-01 05:06:25', '2025-08-01 05:06:25'),
(128, 322, 12, 'view', '{\"duration\": 275, \"page_views\": 8}', '140.190.45.54', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-13 08:43:28', '2025-09-13 08:43:28'),
(129, 292, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '111.253.145.18', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-02 06:00:22', '2025-10-02 06:00:22'),
(130, 292, 12, 'view', '{\"duration\": 233, \"page_views\": 6}', '98.40.156.74', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-01 02:16:10', '2025-10-01 02:16:10'),
(131, 324, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '80.224.214.234', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-16 16:08:12', '2025-09-16 16:08:12'),
(132, 315, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '255.79.23.38', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-03 01:49:32', '2025-09-03 01:49:32'),
(133, 288, 13, 'view', '{\"duration\": 213, \"page_views\": 1}', '55.168.170.45', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-19 20:54:19', '2025-08-19 20:54:19'),
(134, 313, 12, 'view', '{\"duration\": 101, \"page_views\": 9}', '32.247.36.158', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-07-29 08:01:43', '2025-07-29 08:01:43'),
(135, 293, 12, 'download', '{\"file_size\": 10334908, \"download_method\": \"direct\"}', '194.101.165.149', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-16 20:08:40', '2025-09-16 20:08:40'),
(136, 319, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '32.139.25.7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-22 14:45:23', '2025-09-22 14:45:23'),
(137, 314, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '33.230.181.24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-19 09:03:07', '2025-08-19 09:03:07'),
(138, 293, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '243.165.154.177', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-22 04:47:43', '2025-10-22 04:47:43'),
(139, 321, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '244.165.92.32', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-22 14:25:04', '2025-09-22 14:25:04'),
(140, 311, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3912270, \"file_type\": \"xlsx\"}', '53.81.147.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-18 23:43:24', '2025-08-18 23:43:24'),
(141, 316, 12, 'download', '{\"file_size\": 824051, \"download_method\": \"direct\"}', '201.252.241.96', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-17 01:56:37', '2025-10-17 01:56:37'),
(142, 322, 13, 'download', '{\"file_size\": 6339699, \"download_method\": \"direct\"}', '243.220.219.56', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-05 11:34:10', '2025-09-05 11:34:10'),
(143, 291, 12, 'download', '{\"file_size\": 9519180, \"download_method\": \"email\"}', '158.119.71.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-31 09:21:04', '2025-08-31 09:21:04'),
(144, 316, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 1852824, \"file_type\": \"xlsx\"}', '131.217.241.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-24 15:16:35', '2025-08-24 15:16:35'),
(145, 316, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 2840557, \"file_type\": \"docx\"}', '179.55.5.85', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-08 03:38:22', '2025-10-08 03:38:22'),
(146, 317, 13, 'view', '{\"duration\": 217, \"page_views\": 2}', '156.165.229.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-21 07:09:53', '2025-09-21 07:09:53'),
(147, 288, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 307671, \"file_type\": \"pdf\"}', '48.238.185.101', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-20 00:33:39', '2025-09-20 00:33:39'),
(148, 293, 13, 'download', '{\"file_size\": 6843648, \"download_method\": \"direct\"}', '169.120.142.218', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-07 22:17:53', '2025-10-07 22:17:53'),
(149, 290, 12, 'download', '{\"file_size\": 5630996, \"download_method\": \"direct\"}', '135.244.209.32', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-25 19:11:53', '2025-08-25 19:11:53'),
(150, 320, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '151.75.207.227', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-22 09:45:57', '2025-10-22 09:45:57'),
(151, 326, 13, 'download', '{\"file_size\": 7424583, \"download_method\": \"direct\"}', '16.213.128.28', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-13 02:47:02', '2025-09-13 02:47:02'),
(152, 325, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '180.243.143.75', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-28 22:58:57', '2025-09-28 22:58:57'),
(153, 294, 13, 'download', '{\"file_size\": 4499307, \"download_method\": \"direct\"}', '42.198.158.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-27 18:38:53', '2025-07-27 18:38:53'),
(154, 293, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '18.15.103.231', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-10 16:51:31', '2025-09-10 16:51:31'),
(155, 289, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 6357134, \"file_type\": \"docx\"}', '119.32.29.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-27 18:40:00', '2025-09-27 18:40:00'),
(156, 289, 12, 'view', '{\"duration\": 10, \"page_views\": 4}', '251.182.35.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-28 05:48:54', '2025-08-28 05:48:54'),
(157, 290, 13, 'view', '{\"duration\": 59, \"page_views\": 4}', '145.131.207.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-08 08:12:16', '2025-09-08 08:12:16'),
(158, 325, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '219.1.235.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-14 03:59:21', '2025-09-14 03:59:21'),
(159, 322, 13, 'download', '{\"file_size\": 1652369, \"download_method\": \"email\"}', '174.197.218.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-13 03:46:25', '2025-08-13 03:46:25'),
(160, 317, 12, 'view', '{\"duration\": 173, \"page_views\": 6}', '63.183.78.70', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-22 07:10:08', '2025-09-22 07:10:08'),
(161, 316, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '95.231.82.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-07 14:35:20', '2025-10-07 14:35:20'),
(162, 326, 13, 'download', '{\"file_size\": 826407, \"download_method\": \"email\"}', '180.237.78.215', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-06 22:54:18', '2025-08-06 22:54:18'),
(163, 323, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '211.175.93.93', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-15 19:14:31', '2025-09-15 19:14:31'),
(164, 317, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '192.72.218.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-28 07:27:47', '2025-08-28 07:27:47'),
(165, 326, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 2618184, \"file_type\": \"pptx\"}', '17.128.44.96', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-28 15:36:40', '2025-09-28 15:36:40'),
(166, 316, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 113966, \"file_type\": \"pdf\"}', '38.70.174.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-29 00:45:49', '2025-08-29 00:45:49'),
(167, 291, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.1\"}', '112.98.111.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-07-26 07:57:44', '2025-07-26 07:57:44'),
(168, 290, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 8599840, \"file_type\": \"docx\"}', '177.188.175.163', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-23 15:09:29', '2025-08-23 15:09:29'),
(169, 288, 12, 'view', '{\"duration\": 248, \"page_views\": 6}', '30.120.31.222', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-06 05:16:25', '2025-09-06 05:16:25'),
(170, 288, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 10254533, \"file_type\": \"pptx\"}', '125.111.146.209', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-19 01:00:09', '2025-08-19 01:00:09'),
(171, 311, 13, 'download', '{\"file_size\": 4421659, \"download_method\": \"direct\"}', '84.245.58.203', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-30 15:50:00', '2025-08-30 15:50:00'),
(172, 292, 12, 'download', '{\"file_size\": 1949707, \"download_method\": \"email\"}', '18.205.250.213', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-12 22:20:52', '2025-09-12 22:20:52'),
(173, 322, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '57.238.143.220', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-01 06:58:49', '2025-10-01 06:58:49'),
(174, 319, 13, 'view', '{\"duration\": 29, \"page_views\": 7}', '250.44.208.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-21 14:41:43', '2025-08-21 14:41:43'),
(175, 292, 13, 'view', '{\"duration\": 94, \"page_views\": 4}', '95.94.120.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-05 00:17:13', '2025-10-05 00:17:13'),
(176, 320, 13, 'view', '{\"duration\": 181, \"page_views\": 6}', '232.199.218.155', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-30 09:14:29', '2025-09-30 09:14:29'),
(177, 318, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3130137, \"file_type\": \"xlsx\"}', '112.114.156.99', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-08 02:46:17', '2025-10-08 02:46:17'),
(178, 324, 13, 'view', '{\"duration\": 210, \"page_views\": 7}', '59.59.75.133', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-30 20:55:22', '2025-09-30 20:55:22'),
(179, 289, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '242.92.195.115', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-10 23:24:12', '2025-09-10 23:24:12'),
(180, 318, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 182612, \"file_type\": \"docx\"}', '48.135.6.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-23 02:03:18', '2025-09-23 02:03:18'),
(181, 325, 13, 'download', '{\"file_size\": 1123259, \"download_method\": \"email\"}', '247.164.183.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-04 17:28:08', '2025-09-04 17:28:08'),
(182, 289, 13, 'view', '{\"duration\": 118, \"page_views\": 7}', '20.178.140.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-12 21:25:45', '2025-09-12 21:25:45'),
(183, 315, 12, 'download', '{\"file_size\": 591443, \"download_method\": \"direct\"}', '236.164.57.149', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-09 20:26:11', '2025-09-09 20:26:11'),
(184, 289, 13, 'download', '{\"file_size\": 4652254, \"download_method\": \"email\"}', '239.37.145.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-25 16:06:36', '2025-08-25 16:06:36'),
(185, 290, 13, 'view', '{\"duration\": 139, \"page_views\": 9}', '212.210.175.81', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-25 17:46:16', '2025-09-25 17:46:16'),
(186, 290, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 2358290, \"file_type\": \"xlsx\"}', '178.148.60.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-21 18:53:17', '2025-09-21 18:53:17'),
(187, 318, 13, 'download', '{\"file_size\": 9843458, \"download_method\": \"direct\"}', '73.120.163.126', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-18 17:28:37', '2025-10-18 17:28:37'),
(188, 317, 13, 'view', '{\"duration\": 68, \"page_views\": 10}', '110.171.151.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-06 21:48:22', '2025-09-06 21:48:22'),
(189, 323, 12, 'download', '{\"file_size\": 219399, \"download_method\": \"email\"}', '51.141.51.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-01 12:31:57', '2025-09-01 12:31:57'),
(190, 323, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 2475668, \"file_type\": \"pptx\"}', '187.109.2.47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-30 19:05:20', '2025-09-30 19:05:20'),
(191, 321, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '86.206.194.9', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-28 18:00:50', '2025-09-28 18:00:50'),
(192, 294, 12, 'download', '{\"file_size\": 8704124, \"download_method\": \"email\"}', '85.152.176.197', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-23 15:53:59', '2025-09-23 15:53:59');
INSERT INTO `document_activities` (`id`, `document_id`, `user_id`, `action`, `data`, `ip`, `user_agent`, `created_at`, `updated_at`) VALUES
(193, 316, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 10293705, \"file_type\": \"pdf\"}', '121.150.74.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-16 03:44:45', '2025-08-16 03:44:45'),
(194, 321, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '197.112.200.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-08 14:30:33', '2025-09-08 14:30:33'),
(195, 317, 12, 'view', '{\"duration\": 126, \"page_views\": 3}', '111.172.23.32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-24 18:27:43', '2025-08-24 18:27:43'),
(196, 316, 12, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.4\"}', '103.130.30.206', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-18 17:17:25', '2025-10-18 17:17:25'),
(197, 292, 12, 'view', '{\"duration\": 147, \"page_views\": 10}', '133.133.101.154', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-26 09:42:46', '2025-08-26 09:42:46'),
(198, 323, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 6721607, \"file_type\": \"xlsx\"}', '84.28.230.207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-20 23:59:55', '2025-09-20 23:59:55'),
(199, 311, 12, 'download', '{\"file_size\": 754280, \"download_method\": \"direct\"}', '229.178.48.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-23 06:30:39', '2025-08-23 06:30:39'),
(200, 317, 13, 'download', '{\"file_size\": 8557629, \"download_method\": \"direct\"}', '240.218.17.39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-09 04:06:46', '2025-10-09 04:06:46'),
(201, 313, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.3\"}', '246.122.189.206', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-28 17:20:52', '2025-08-28 17:20:52'),
(202, 324, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '171.75.192.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-17 20:47:55', '2025-08-17 20:47:55'),
(203, 289, 12, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.5\"}', '203.82.102.173', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-23 22:44:21', '2025-08-23 22:44:21'),
(204, 293, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '241.193.246.221', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-10 13:48:43', '2025-08-10 13:48:43'),
(205, 290, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '10.249.18.241', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-04 00:14:44', '2025-09-04 00:14:44'),
(206, 294, 13, 'view', '{\"duration\": 226, \"page_views\": 6}', '136.106.147.27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-08 00:10:06', '2025-10-08 00:10:06'),
(207, 313, 13, 'download', '{\"file_size\": 6465663, \"download_method\": \"email\"}', '3.112.136.126', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-04 18:28:14', '2025-08-04 18:28:14'),
(208, 326, 12, 'download', '{\"file_size\": 2909419, \"download_method\": \"email\"}', '185.56.121.16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-02 00:17:27', '2025-08-02 00:17:27'),
(209, 289, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '124.221.23.69', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-07-31 10:25:58', '2025-07-31 10:25:58'),
(210, 316, 13, 'download', '{\"file_size\": 3235524, \"download_method\": \"email\"}', '14.114.133.131', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-10 01:32:42', '2025-08-10 01:32:42'),
(211, 317, 13, 'download', '{\"file_size\": 6983215, \"download_method\": \"direct\"}', '230.179.75.107', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-28 17:16:37', '2025-09-28 17:16:37'),
(212, 313, 12, 'view', '{\"duration\": 288, \"page_views\": 8}', '222.84.231.118', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-19 15:16:23', '2025-09-19 15:16:23'),
(213, 321, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.1\"}', '166.4.94.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-20 19:03:40', '2025-09-20 19:03:40'),
(214, 294, 12, 'view', '{\"duration\": 288, \"page_views\": 9}', '229.169.239.238', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-18 16:12:24', '2025-10-18 16:12:24'),
(215, 324, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '76.116.161.84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-28 00:22:15', '2025-09-28 00:22:15'),
(216, 316, 13, 'view', '{\"duration\": 269, \"page_views\": 3}', '98.57.250.167', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-20 12:44:39', '2025-09-20 12:44:39'),
(217, 325, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '141.78.244.145', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-09 05:59:03', '2025-09-09 05:59:03'),
(218, 293, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '253.235.224.146', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-29 23:58:51', '2025-09-29 23:58:51'),
(219, 315, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.3\"}', '52.56.101.236', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-05 14:17:10', '2025-09-05 14:17:10'),
(220, 324, 12, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '29.166.151.182', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-01 03:54:17', '2025-10-01 03:54:17'),
(221, 324, 12, 'view', '{\"duration\": 117, \"page_views\": 2}', '37.177.192.42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-09 11:05:26', '2025-08-09 11:05:26'),
(222, 326, 12, 'view', '{\"duration\": 287, \"page_views\": 2}', '88.179.109.234', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-15 21:30:39', '2025-09-15 21:30:39'),
(223, 294, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 8426064, \"file_type\": \"docx\"}', '66.219.13.174', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-23 18:06:22', '2025-09-23 18:06:22'),
(224, 311, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 4323887, \"file_type\": \"xlsx\"}', '176.31.189.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-03 23:43:37', '2025-08-03 23:43:37'),
(225, 316, 13, 'view', '{\"duration\": 294, \"page_views\": 8}', '215.23.10.156', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-08 08:19:03', '2025-08-08 08:19:03'),
(226, 314, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '208.111.84.65', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-07-25 15:24:21', '2025-07-25 15:24:21'),
(227, 316, 13, 'view', '{\"duration\": 66, \"page_views\": 4}', '133.6.68.38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-12 09:12:29', '2025-09-12 09:12:29'),
(228, 322, 13, 'download', '{\"file_size\": 4349136, \"download_method\": \"email\"}', '48.217.143.159', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-17 17:24:12', '2025-09-17 17:24:12'),
(229, 318, 12, 'view', '{\"duration\": 170, \"page_views\": 2}', '165.70.220.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-24 09:59:19', '2025-09-24 09:59:19'),
(230, 326, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.4\"}', '229.244.96.247', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-26 07:36:38', '2025-07-26 07:36:38'),
(231, 294, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 9037613, \"file_type\": \"docx\"}', '51.239.223.66', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-16 21:05:34', '2025-10-16 21:05:34'),
(232, 292, 12, 'download', '{\"file_size\": 943005, \"download_method\": \"email\"}', '161.251.70.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-06 14:48:24', '2025-09-06 14:48:24'),
(233, 313, 13, 'view', '{\"duration\": 212, \"page_views\": 1}', '42.243.80.176', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-11 07:01:59', '2025-08-11 07:01:59'),
(234, 313, 13, 'download', '{\"file_size\": 966041, \"download_method\": \"email\"}', '191.127.176.155', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-20 04:20:23', '2025-08-20 04:20:23'),
(235, 323, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '41.10.43.58', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-02 00:18:37', '2025-08-02 00:18:37'),
(236, 318, 13, 'download', '{\"file_size\": 6973481, \"download_method\": \"direct\"}', '145.219.108.242', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-27 00:51:29', '2025-09-27 00:51:29'),
(237, 321, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 7372072, \"file_type\": \"xlsx\"}', '69.7.161.66', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-01 01:24:24', '2025-08-01 01:24:24'),
(238, 324, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '185.112.109.153', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-19 20:14:49', '2025-09-19 20:14:49'),
(239, 314, 13, 'download', '{\"file_size\": 2129227, \"download_method\": \"email\"}', '117.183.251.141', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-29 03:35:59', '2025-08-29 03:35:59'),
(240, 326, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '3.90.65.149', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-22 19:06:06', '2025-09-22 19:06:06'),
(241, 290, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '168.195.108.243', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-25 17:46:59', '2025-07-25 17:46:59'),
(242, 315, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 1056208, \"file_type\": \"xlsx\"}', '77.36.59.231', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-07-26 00:58:32', '2025-07-26 00:58:32'),
(243, 291, 13, 'view', '{\"duration\": 36, \"page_views\": 4}', '194.126.39.215', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-13 18:52:16', '2025-08-13 18:52:16'),
(244, 311, 12, 'view', '{\"duration\": 159, \"page_views\": 8}', '166.21.26.180', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-11 09:37:29', '2025-10-11 09:37:29'),
(245, 318, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '196.19.72.249', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-09 04:16:53', '2025-10-09 04:16:53'),
(246, 291, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 2675623, \"file_type\": \"xlsx\"}', '237.19.224.207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-08 21:39:15', '2025-08-08 21:39:15'),
(247, 290, 12, 'download', '{\"file_size\": 5579573, \"download_method\": \"direct\"}', '219.71.220.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-28 12:29:13', '2025-09-28 12:29:13'),
(248, 315, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '36.208.29.131', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-09 15:09:46', '2025-08-09 15:09:46'),
(249, 321, 13, 'view', '{\"duration\": 199, \"page_views\": 1}', '251.208.242.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-07-27 11:50:41', '2025-07-27 11:50:41'),
(250, 315, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 7632549, \"file_type\": \"pptx\"}', '121.158.219.144', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-01 02:41:57', '2025-08-01 02:41:57'),
(251, 288, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 5714335, \"file_type\": \"docx\"}', '222.106.252.123', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-14 04:53:57', '2025-09-14 04:53:57'),
(252, 319, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3939325, \"file_type\": \"xlsx\"}', '229.165.90.196', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-13 18:11:00', '2025-10-13 18:11:00'),
(253, 322, 13, 'download', '{\"file_size\": 5013702, \"download_method\": \"direct\"}', '91.239.139.109', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-09 21:34:15', '2025-08-09 21:34:15'),
(254, 290, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.3\"}', '7.54.194.178', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-20 06:09:26', '2025-09-20 06:09:26'),
(255, 290, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '63.59.3.94', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-14 18:40:41', '2025-10-14 18:40:41'),
(256, 293, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '169.9.113.175', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-18 03:29:18', '2025-09-18 03:29:18'),
(257, 313, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '45.10.155.56', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-13 16:36:14', '2025-08-13 16:36:14'),
(258, 311, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 4508855, \"file_type\": \"docx\"}', '194.223.250.72', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-23 04:06:26', '2025-08-23 04:06:26'),
(259, 325, 13, 'restore', '{\"reason\": \"User request\", \"restored_from\": \"archive\"}', '1.203.52.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-03 06:36:24', '2025-09-03 06:36:24'),
(260, 290, 12, 'download', '{\"file_size\": 9212187, \"download_method\": \"email\"}', '144.1.181.93', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-23 14:12:29', '2025-08-23 14:12:29'),
(261, 324, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 8186410, \"file_type\": \"docx\"}', '114.27.215.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-08 23:11:17', '2025-10-08 23:11:17'),
(262, 319, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 8304487, \"file_type\": \"xlsx\"}', '156.171.128.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-15 04:09:41', '2025-08-15 04:09:41'),
(263, 313, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '33.201.99.70', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-14 22:30:23', '2025-08-14 22:30:23'),
(264, 326, 12, 'view', '{\"duration\": 128, \"page_views\": 1}', '82.161.250.186', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-15 06:18:22', '2025-08-15 06:18:22'),
(265, 314, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '150.81.223.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-02 11:12:29', '2025-09-02 11:12:29'),
(266, 319, 13, 'download', '{\"file_size\": 1228970, \"download_method\": \"direct\"}', '159.20.247.190', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-10 01:47:25', '2025-08-10 01:47:25'),
(267, 323, 13, 'download', '{\"file_size\": 771213, \"download_method\": \"email\"}', '94.189.143.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-11 02:27:07', '2025-10-11 02:27:07'),
(268, 321, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '161.235.55.210', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-09 23:59:11', '2025-09-09 23:59:11'),
(269, 315, 13, 'view', '{\"duration\": 27, \"page_views\": 9}', '76.155.57.150', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-01 23:41:53', '2025-10-01 23:41:53'),
(270, 291, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.5\"}', '242.214.152.157', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-05 06:07:23', '2025-10-05 06:07:23'),
(271, 289, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 918578, \"file_type\": \"docx\"}', '137.150.87.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-08-29 03:13:49', '2025-08-29 03:13:49'),
(272, 311, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '39.10.211.93', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-25 12:50:53', '2025-08-25 12:50:53'),
(273, 318, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 10146338, \"file_type\": \"pdf\"}', '57.66.61.192', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-04 23:15:48', '2025-10-04 23:15:48'),
(274, 326, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '18.53.186.49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-04 13:30:42', '2025-08-04 13:30:42'),
(275, 322, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.1\"}', '242.120.70.195', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-23 15:17:02', '2025-09-23 15:17:02'),
(276, 290, 13, 'download', '{\"file_size\": 3314591, \"download_method\": \"email\"}', '7.219.142.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-13 00:34:31', '2025-08-13 00:34:31'),
(277, 316, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 9349138, \"file_type\": \"xlsx\"}', '10.161.147.38', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-15 11:07:15', '2025-10-15 11:07:15'),
(278, 292, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '105.151.234.31', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-16 20:39:27', '2025-08-16 20:39:27'),
(279, 316, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 4042473, \"file_type\": \"pptx\"}', '60.234.143.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-26 08:31:57', '2025-09-26 08:31:57'),
(280, 323, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 2893052, \"file_type\": \"pptx\"}', '241.75.124.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-25 16:17:29', '2025-08-25 16:17:29'),
(281, 317, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 611230, \"file_type\": \"docx\"}', '227.54.63.128', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-19 07:50:33', '2025-10-19 07:50:33'),
(282, 314, 13, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.2\"}', '112.245.143.91', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-10-20 07:18:46', '2025-10-20 07:18:46'),
(283, 313, 12, 'download', '{\"file_size\": 3293088, \"download_method\": \"direct\"}', '149.254.66.195', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-22 23:31:18', '2025-09-22 23:31:18'),
(284, 314, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '171.139.24.105', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-01 04:30:13', '2025-08-01 04:30:13'),
(285, 323, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 3676723, \"file_type\": \"pptx\"}', '31.200.116.227', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-28 02:16:10', '2025-08-28 02:16:10'),
(286, 290, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 5638426, \"file_type\": \"xlsx\"}', '145.56.103.189', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-14 17:41:01', '2025-09-14 17:41:01'),
(287, 325, 12, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.5\"}', '154.187.234.115', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-16 00:54:56', '2025-10-16 00:54:56'),
(288, 294, 13, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '94.147.150.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-09-07 00:05:02', '2025-09-07 00:05:02'),
(289, 311, 12, 'edit', '{\"changes\": \"Metadata modified\", \"version\": \"1.3\"}', '181.89.203.25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-10-10 00:11:17', '2025-10-10 00:11:17'),
(290, 294, 13, 'download', '{\"file_size\": 6098639, \"download_method\": \"direct\"}', '113.27.153.126', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-13 22:51:10', '2025-09-13 22:51:10'),
(291, 323, 12, 'download', '{\"file_size\": 4989406, \"download_method\": \"direct\"}', '140.235.240.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-08-15 11:12:09', '2025-08-15 11:12:09'),
(292, 294, 13, 'view', '{\"duration\": 32, \"page_views\": 1}', '142.12.76.16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-09 11:58:35', '2025-10-09 11:58:35'),
(293, 313, 13, 'upload', '{\"version\": \"1.0\", \"file_size\": 718776, \"file_type\": \"docx\"}', '230.205.53.115', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0', '2025-09-19 22:24:29', '2025-09-19 22:24:29'),
(294, 317, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 5855088, \"file_type\": \"docx\"}', '16.26.150.166', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-07 03:40:35', '2025-10-07 03:40:35'),
(295, 322, 13, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '4.111.153.211', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-04 20:59:30', '2025-09-04 20:59:30'),
(296, 313, 12, 'edit', '{\"changes\": \"Content updated\", \"version\": \"1.4\"}', '227.83.251.164', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.59', '2025-08-07 20:42:04', '2025-08-07 20:42:04'),
(297, 291, 13, 'edit', '{\"changes\": \"Formatting changed\", \"version\": \"1.4\"}', '78.236.93.239', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-10-21 02:52:03', '2025-10-21 02:52:03'),
(298, 316, 12, 'restore', '{\"reason\": \"Audit requirement\", \"restored_from\": \"archive\"}', '207.27.155.239', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-08-18 16:20:05', '2025-08-18 16:20:05'),
(299, 320, 12, 'restore', '{\"reason\": \"System restore\", \"restored_from\": \"archive\"}', '175.244.170.223', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15', '2025-09-24 15:11:38', '2025-09-24 15:11:38'),
(300, 289, 12, 'upload', '{\"version\": \"1.0\", \"file_size\": 5188834, \"file_type\": \"pdf\"}', '223.77.52.185', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-10-09 14:23:53', '2025-10-09 14:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `document_activity_logs`
--

CREATE TABLE `document_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` enum('uploaded','edited','viewed','downloaded','archived','restored','disposed','collaborator_added','collaborator_removed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_collaborators`
--

CREATE TABLE `document_collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('viewer','editor','reviewer','admin') NOT NULL DEFAULT 'viewer',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_import_logs`
--

CREATE TABLE `document_import_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_system` varchar(100) NOT NULL,
  `external_reference_id` varchar(255) NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `import_status` enum('processing','success','failed') NOT NULL DEFAULT 'processing',
  `payload` text DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `processing_time_ms` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_import_logs`
--

INSERT INTO `document_import_logs` (`id`, `source_system`, `external_reference_id`, `document_id`, `import_status`, `payload`, `error_message`, `started_at`, `completed_at`, `processing_time_ms`, `created_at`, `updated_at`) VALUES
(1, 'HR2_Microservice', 'EXT-1769183074615-5otl3wjt2', NULL, 'success', '{\"_token\":\"VwEU8WL9aVzVU7Iz3cLgiUrMek9cLkMRe4bpSpdu\",\"title\":\"d\\\\red\",\"category\":\"policy\",\"department\":\"HR2\",\"confidentiality_level\":\"internal\",\"status\":\"archived\",\"retention_period\":\"10 Years\",\"source_system\":\"HR2_Microservice\",\"external_reference_id\":\"EXT-1769183074615-5otl3wjt2\",\"metadata\":{\"simulated\":true,\"created_via\":\"admin_portal\",\"timestamp\":\"2026-01-23T15:44:34.615Z\"}}', NULL, '2026-01-23 15:44:34', '2026-01-23 15:44:35', 136.85, '2026-01-23 15:44:34', '2026-01-23 15:44:35'),
(2, 'HR3_Microservice', 'EXT-1769183362326-0osquggqy', 411, 'success', '{\"_token\":\"VwEU8WL9aVzVU7Iz3cLgiUrMek9cLkMRe4bpSpdu\",\"title\":\"contract\",\"category\":\"policy\",\"department\":\"HR3\",\"confidentiality_level\":\"confidential\",\"status\":\"archived\",\"retention_period\":\"10 Years\",\"source_system\":\"HR3_Microservice\",\"external_reference_id\":\"EXT-1769183362326-0osquggqy\",\"metadata\":{\"simulated\":true,\"created_via\":\"admin_portal\",\"timestamp\":\"2026-01-23T15:49:22.326Z\"}}', NULL, '2026-01-23 15:49:22', '2026-01-23 15:49:22', 35.93, '2026-01-23 15:49:22', '2026-01-23 15:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`id`, `document_id`, `requested_by`, `approved_by`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'approved', 'yes', '2025-07-10 02:31:02', '2025-07-10 02:31:20'),
(2, 2, 1, NULL, 'pending', NULL, '2025-07-15 12:22:18', '2025-07-15 12:22:18'),
(3, 3, 1, 1, 'approved', 'ssadsa', '2025-07-16 04:17:00', '2025-07-16 04:17:33'),
(4, 5, 1, 1, 'approved', 'wefw', '2025-07-16 08:59:33', '2025-07-16 09:00:12'),
(5, 10, 1, NULL, 'pending', NULL, '2025-07-17 08:51:23', '2025-07-17 08:51:23'),
(6, 14, 1, 1, 'approved', 'sef', '2025-07-17 09:09:22', '2025-07-17 09:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `document_retention_policies`
--

CREATE TABLE `document_retention_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_share_invites`
--

CREATE TABLE `document_share_invites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_versions`
--

CREATE TABLE `document_versions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_workflows`
--

CREATE TABLE `document_workflows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `workflow_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_stage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `source_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `routing_decision` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_analysis_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` enum('pending','in_progress','completed','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `error_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_complaints`
--

CREATE TABLE `employee_complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complainant_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` enum('submitted','under_review','investigation','resolved','dismissed','escalated') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `assigned_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incident_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incident_date` date DEFAULT NULL,
  `incident_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `witnesses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `supporting_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ai_analysis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `applicable_laws` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `resolution_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_logs`
--

CREATE TABLE `employee_logs` (
  `logs_id` int(11) NOT NULL,
  `log_status` varchar(255) NOT NULL,
  `attempt_count` varchar(255) NOT NULL,
  `cooldown` varchar(255) DEFAULT NULL,
  `failure_reason` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `log_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `amenities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `facility_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `operating_hours_start` time DEFAULT NULL,
  `operating_hours_end` time DEFAULT NULL,
  `status` enum('available','unavailable','occupied') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `location`, `description`, `type`, `capacity`, `amenities`, `rating`, `facility_type`, `image_url`, `images`, `hourly_rate`, `operating_hours_start`, `operating_hours_end`, `status`, `created_at`, `updated_at`) VALUES
(30, 'Equipment / Assets', 'caloocan', 'Company equipment and assets available for use to support operations and events. Well-maintained and managed to ensure efficiency, reliability, and convenience for staff and guests.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-08-14 19:54:03', '2025-11-17 06:35:04'),
(31, 'Storage & Warehousing Spaces', 'rizal', 'Secure storage and warehousing spaces designed to keep items safe, organized, and accessible. Ideal for equipment, supplies, or bulk materials requiring temporary or long-term safekeeping.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-09-04 10:34:19', '2025-09-17 05:43:58'),
(35, 'Company Vehicles', 'makati', 'he company vehicles are available for official use, ensuring convenient and reliable transportation for staff and guests. Well-maintained and ready for service, they provide comfort and safety for every trip.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-09-05 09:48:20', '2025-11-17 07:08:55'),
(37, 'Banquet Halls', 'sta.monica', 'The banquet halls are designed for dining events, receptions, and celebrations. Featuring an elegant ambiance and customizable seating, they are perfect for weddings, corporate dinners, and large gatherings.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-09-05 18:43:45', '2025-11-17 05:42:13'),
(40, 'Function Halls', 'caloocan', 'The function halls provide a flexible space ideal for birthdays, seminars, and social events. With spacious interiors and adaptable layouts, they can be arranged to suit both formal and casual occasions.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-09-05 19:10:39', '2025-11-17 07:50:23'),
(43, 'Ballrooms', 'caloocan', 'The ballrooms offer an elegant and spacious venue ideal for weddings, corporate events, parties, and grand celebrations. Designed with a sophisticated ambiance, the space can accommodate large groups and can be customized to suit formal gatherings or social occasions.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available', '2025-09-07 21:15:57', '2025-11-23 19:38:19'),
(44, 'Meeting Rooms', 'quezon city', 'The meeting rooms provide a versatile space for group discussions, client presentations, and collaborative sessions. Each room is designed to support productivity, offering a comfortable and professional atmosphere for both small and medium-sized gatherings. Perfect for team meetings, workshops, and strategic planning.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'occupied', '2025-09-08 10:29:50', '2025-11-18 11:58:37'),
(45, 'Conference Room', 'novaliches', 'The conference room is designed to accommodate meetings, presentations, and team discussions in a professional and comfortable setting. It is equipped with modern amenities including tables, chairs, and sufficient lighting to ensure a productive environment. Ideal for business gatherings, brainstorming sessions, and small seminars.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'occupied', '2025-09-08 10:39:57', '2025-11-17 10:43:33'),
(55, 'Conference', 'afaf', 'sgsgse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unavailable', '2026-01-22 14:39:20', '2026-01-22 14:39:20'),
(56, 'Conference', 'sfsbdfbd', 'bdfbdfb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'occupied', '2026-01-22 14:41:08', '2026-01-22 14:41:08'),
(57, 'Conference', NULL, 'sgs', NULL, 50, NULL, NULL, 'Conference', NULL, NULL, NULL, NULL, NULL, 'unavailable', '2026-01-22 16:26:14', '2026-01-22 16:26:14'),
(58, 'Conference', 'Conference', 'rthtr', NULL, 50, NULL, NULL, 'Conference', '/placeholder.svg', NULL, NULL, NULL, NULL, 'unavailable', '2026-01-22 16:43:52', '2026-01-22 16:43:52'),
(59, 'adf', NULL, 'adf', NULL, 50, NULL, NULL, 'Facility', NULL, NULL, NULL, NULL, NULL, 'available', '2026-01-23 20:28:25', '2026-01-23 20:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `facility_requests`
--

CREATE TABLE `facility_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_type` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requested_datetime` datetime NOT NULL,
  `requested_end_datetime` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facility_requests`
--

INSERT INTO `facility_requests` (`id`, `request_type`, `department`, `priority`, `location`, `facility_id`, `requested_datetime`, `requested_end_datetime`, `description`, `contact_name`, `contact_email`, `status`, `notes`, `assigned_to`, `created_at`, `updated_at`) VALUES
(22, 'reservation', 'Finance', 'low', 'qc', 30, '2025-09-10 08:32:21', NULL, 'Need to reserve facility for meeting.', 'ern', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":45345,\"damage_severity\":\"moderate\",\"damage_description\":\"sfsf\",\"inspection_notes\":\"fdhfd\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 04:04:07\"}}', NULL, '2025-09-09 00:32:21', '2025-11-16 20:04:07'),
(26, 'reservation', 'Logistic', 'medium', 'caloocan', 45, '2025-09-10 08:34:00', '2025-09-13 20:34:00', 'eergegre', 'ern', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-09 00:35:12', '2025-09-09 00:35:51'),
(27, 'reservation', 'Human Resources', 'urgent', 'novaliches', 44, '2025-09-11 08:37:00', '2025-09-20 08:37:00', 'vvegferg', 'ren', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-09 00:37:19', '2025-09-09 00:39:06'),
(28, 'reservation', 'Core 2', 'urgent', 'novaliches', 43, '2025-09-11 08:48:00', '2025-09-17 20:49:00', 'ftjtj', 'john', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-09 00:49:09', '2025-09-09 00:49:31'),
(29, 'reservation', 'Logistic', 'high', 'novaliches', 43, '2025-09-10 08:50:00', '2025-09-26 08:50:00', 'bdfbfdb', 'drake', 'piqs09120@gmail.com', 'completed', NULL, NULL, '2025-09-09 00:50:57', '2025-09-09 01:37:53'),
(30, 'reservation', 'Core 2', 'urgent', 'novaliches', 40, '2025-09-11 09:01:00', '2025-09-25 09:01:00', 'sgsgse', 'jade', 'piqs09120@gmail.com', 'completed', NULL, NULL, '2025-09-09 01:01:26', '2025-09-09 01:36:48'),
(31, 'reservation', 'Logistic', 'urgent', 'novaliches', 43, '2025-09-10 09:48:00', '2025-09-18 09:48:00', 'sdvdsvsd', 'ben', 'piqs09120@gmail.com', 'completed', NULL, NULL, '2025-09-09 01:48:36', '2025-09-09 01:50:55'),
(32, 'reservation', 'Core 1', 'high', 'caloocan', 43, '2025-09-13 22:34:00', '2025-09-27 22:34:00', 'wwgge', 'ern', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-12 14:35:08', '2025-09-12 14:35:46'),
(33, 'reservation', 'Finance', 'low', 'caloocan', 40, '2025-09-14 22:08:00', '2025-09-24 22:08:00', 'dsvs', 'john', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-13 14:08:19', '2025-09-13 14:08:34'),
(34, 'reservation', 'Finance', 'high', 'qc', 37, '2025-09-14 22:17:00', '2025-09-17 22:17:00', 'fgfgnfg', 'john', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-13 14:17:58', '2025-09-13 14:18:10'),
(35, 'reservation', 'Logistic', 'high', 'novaliches', 35, '2025-09-15 20:27:00', '2025-09-24 20:27:00', 'ttht', 'drake', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-14 12:27:17', '2025-09-14 12:27:45'),
(36, 'reservation', 'Core 1', 'low', 'caloocan', 45, '2025-09-18 01:19:00', '2025-09-20 01:19:00', 'afaf', 'ern', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-16 17:20:06', '2025-09-16 17:20:21'),
(37, 'reservation', 'Logistic', 'medium', 'caloocan', 44, '2025-09-17 04:20:00', '2025-09-18 17:20:00', 'sdvvs', 'jane', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-16 20:21:13', '2025-09-16 20:21:28'),
(38, 'reservation', 'Finance', 'high', 'manila', 45, '2025-09-18 13:16:00', '2025-09-30 13:16:00', 'whenever', 'john liz', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-17 05:16:23', '2025-09-17 05:16:38'),
(39, 'reservation', 'Core 1', 'high', 'malabon', 44, '2025-09-19 13:26:00', '2025-09-29 13:26:00', 'just chill', 'john doe', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-17 05:26:23', '2025-09-17 05:26:50'),
(40, 'reservation', 'Logistic', 'urgent', 'cavite', 43, '2025-09-18 15:47:00', '2025-09-26 15:47:00', 'chillin', 'bane', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-09-17 07:48:02', '2025-09-17 07:48:02'),
(41, 'reservation', 'Human Resources', 'high', 'caloocan', 43, '2025-09-18 21:18:00', '2025-09-30 21:18:00', 'just keeping', 'olivia', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-09-17 13:19:54', '2025-09-17 13:19:54'),
(42, 'reservation', 'Logistic', 'high', 'novaliches', 43, '2025-09-18 21:25:00', '2025-09-24 21:25:00', 'wrgwrgw', 'matthew', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-09-17 13:26:10', '2025-09-17 13:26:10'),
(43, 'reservation', 'Logistic', 'high', 'novaliches', 35, '2025-09-18 21:30:00', '2025-09-20 21:30:00', 'dsvsvsd', 'ben', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-09-17 13:30:41', '2025-09-17 13:30:41'),
(44, 'reservation', 'Human Resources', 'low', 'nova', 30, '2025-09-19 21:37:00', '2025-09-29 21:37:00', 'ssdfdbfdb', 'drake', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-09-17 13:37:15', '2025-09-17 13:37:15'),
(45, 'reservation', 'Human Resources', 'medium', 'caloocan', 45, '2025-09-19 21:53:00', '2025-09-26 21:53:00', 'bhjhjhbg', 'drake', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-17 13:54:04', '2025-09-17 13:54:48'),
(46, 'reservation', 'Finance', 'medium', 'caloocan', 43, '2025-09-19 00:05:00', '2025-09-24 00:05:00', 'dfndf', 'ben', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-09-17 16:06:16', '2025-09-17 16:07:17'),
(47, 'reservation', 'Finance', 'low', 'caloocan', 40, '2025-11-08 17:37:00', '2025-11-09 15:37:00', 'trhhe', 'ern', 'piqs09120@gmail.com', 'pending', NULL, NULL, '2025-11-08 07:37:16', '2025-11-08 07:37:16'),
(48, 'reservation', 'Logistic', 'low', 'caloocan', 37, '2025-11-08 15:40:00', '2025-11-08 15:42:00', 'sggeg', 'liza', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-11-08 07:38:52', '2025-11-08 07:39:01'),
(49, 'reservation', 'Core 2', 'medium', 'caloocan', 40, '2025-11-09 15:43:00', '2025-11-10 13:43:00', 'fgnbfgnfg', 'jane', 'piqs09120@gmail.com', 'completed', NULL, NULL, '2025-11-09 05:43:22', '2025-11-14 11:50:18'),
(50, 'reservation', 'Human Resources', 'medium', 'caloocan', 40, '2025-11-15 19:52:00', '2025-11-16 19:52:00', 'szhhsfdh', 'john', 'piqs09120@gmail.com', 'completed', NULL, NULL, '2025-11-14 11:52:21', '2025-11-16 18:09:28'),
(51, 'reservation', 'Finance', 'low', 'qc', 44, '2025-11-17 03:31:00', '2025-11-17 17:19:00', 'dfbdfgdf', 'liza', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":345353,\"damage_severity\":\"moderate\",\"damage_description\":\"dfbfdd\",\"inspection_notes\":\"dfbdf\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 04:00:02\"}}', NULL, '2025-11-16 19:19:31', '2025-11-16 20:00:02'),
(52, 'reservation', 'Finance', 'medium', 'caloocan', 45, '2025-11-17 13:31:00', '2025-11-17 22:31:00', 'dfbdfg', 'drake', 'itadori0912@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":435,\"damage_severity\":\"minor\",\"damage_description\":\"cvbcvb\",\"inspection_notes\":\"sdfsdf\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:04:26\"}}', NULL, '2025-11-17 04:31:40', '2025-11-17 05:04:26'),
(53, 'reservation', 'Human Resources', 'high', 'qc', 44, '2025-11-17 14:59:00', '2025-11-17 17:59:00', 'hmg', 'ern cruz', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":3435,\"damage_severity\":\"minor\",\"damage_description\":\"ssdfsd\",\"inspection_notes\":\"sdsdgsd\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:18:52\"}}', NULL, '2025-11-17 04:59:46', '2025-11-17 05:18:52'),
(54, 'reservation', 'Logistic', 'medium', 'novaliches', 43, '2025-11-17 16:24:00', '2025-11-17 22:25:00', 'sdgsdf', 'jane', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":4353,\"damage_severity\":\"major\",\"damage_description\":\"dfbdfgf\",\"inspection_notes\":\"hrhrhrt\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:25:54\"}}', NULL, '2025-11-17 05:25:11', '2025-11-17 05:25:54'),
(55, 'reservation', 'Finance', 'low', 'nova', 40, '2025-11-17 16:31:00', '2025-11-17 21:31:00', 'fghgfh', 'jane', 'itadori0912@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":54574,\"damage_severity\":\"major\",\"damage_description\":\"erhehre\",\"inspection_notes\":\"fggfhfg\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:32:23\"}}', NULL, '2025-11-17 05:31:46', '2025-11-17 05:32:23'),
(56, 'reservation', 'Core 2', 'high', 'qc', 37, '2025-11-17 16:41:00', '2025-11-17 19:41:00', 'fsdvdfgd', 'ben', 'itadori0912@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":46464,\"damage_severity\":\"moderate\",\"damage_description\":\"hhmgh\",\"inspection_notes\":\"gmtjg\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:42:13\"}}', NULL, '2025-11-17 05:41:37', '2025-11-17 05:42:13'),
(57, 'reservation', 'Logistic', 'urgent', 'nova', 44, '2025-11-17 16:43:00', '2025-11-17 19:43:00', 'advsdv', 'ben', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":345345,\"damage_severity\":\"severe\",\"damage_description\":\"sdvssd\",\"inspection_notes\":\"ghhr\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 13:48:02\"}}', NULL, '2025-11-17 05:44:00', '2025-11-17 05:48:02'),
(58, 'reservation', 'Finance', 'high', 'qc', 30, '2025-11-17 16:34:00', '2025-11-17 19:34:00', 'svsvsd', 'jane', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":4465,\"damage_severity\":\"major\",\"damage_description\":\"bmgmh\",\"inspection_notes\":\"hjtjt\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 14:35:04\"}}', NULL, '2025-11-17 06:34:33', '2025-11-17 06:35:04'),
(59, 'reservation', 'Logistic', 'medium', 'caloocan', 35, '2025-11-17 17:08:00', '2025-11-17 20:08:00', 'nfgngf', 'jane', 'itadori0912@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":4353453,\"damage_severity\":\"moderate\",\"damage_description\":\"xcvfdsg\",\"inspection_notes\":\"dfhdf\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 15:08:55\"}}', NULL, '2025-11-17 07:08:26', '2025-11-17 07:08:55'),
(60, 'reservation', 'Logistic', 'medium', 'qc', 40, '2025-11-17 19:49:00', '2025-11-18 15:49:00', 'ergerg', 'jane', 'itadori0912@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":32432,\"damage_severity\":\"moderate\",\"damage_description\":\"gvwergrew\",\"inspection_notes\":\"fdbfd\",\"inspected_by\":12,\"inspected_at\":\"2025-11-17 15:50:23\"}}', NULL, '2025-11-17 07:49:50', '2025-11-17 07:50:23'),
(61, 'reservation', 'Finance', 'medium', 'qc', 45, '2025-11-17 21:43:00', '2025-11-17 23:43:00', 'fghfg', 'drake', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-11-17 10:43:24', '2025-11-17 10:43:33'),
(62, 'reservation', 'Finance', 'medium', 'qc', 44, '2025-11-18 22:57:00', '2025-11-19 19:57:00', 'zxvdv', 'asfa', 'piqs09120@gmail.com', 'approved', NULL, NULL, '2025-11-18 11:57:33', '2025-11-18 11:58:37'),
(63, 'reservation', 'Finance', 'medium', 'dsgsgs', 43, '2025-11-20 13:16:00', '2025-11-21 23:16:00', 'sdbds', 'sdsdb', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":2342,\"damage_severity\":\"moderate\",\"damage_description\":\"sdvsdv\",\"inspection_notes\":\"fdbfd\",\"inspected_by\":12,\"inspected_at\":\"2025-11-20 23:17:31\"},\"legal\":{\"case_id\":43,\"case_number\":\"LC-2025-0028\",\"case_status\":\"pending\",\"case_priority\":\"medium\",\"created_at\":\"2025-11-20 23:17:32\",\"updated_at\":\"2025-11-20 23:17:32\"}}', NULL, '2025-11-20 15:16:40', '2025-11-20 15:17:32'),
(64, 'reservation', 'Logistic', 'medium', 'qc', 43, '2025-11-24 05:37:00', '2025-11-25 03:37:00', 'geger', 'ern', 'piqs09120@gmail.com', 'completed', '{\"inspection\":{\"damage_flag\":true,\"damage_cost\":43534534,\"damage_severity\":\"major\",\"damage_description\":\"herher\",\"inspection_notes\":\"rhrh\",\"inspected_by\":12,\"inspected_at\":\"2025-11-24 03:38:19\"},\"legal\":{\"case_id\":44,\"case_number\":\"LC-2025-0029\",\"case_status\":\"pending\",\"case_priority\":\"urgent\",\"created_at\":\"2025-11-24 03:38:19\",\"updated_at\":\"2025-11-24 03:38:19\"}}', NULL, '2025-11-23 19:37:47', '2025-11-23 19:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `facility_reservations`
--

CREATE TABLE `facility_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  `facility_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reserved_by` bigint(20) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `purpose` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitor_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `visitor_pass_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_review_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_required',
  `legal_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `auto_approved` tinyint(1) NOT NULL DEFAULT 0,
  `notification_sent_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','denied','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `current_workflow_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `payment_status` enum('pending','paid','failed','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_processed_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `damage_flag` tinyint(1) NOT NULL DEFAULT 0,
  `damage_cost` decimal(12,2) DEFAULT NULL,
  `inspection_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `damage_photos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `checked_out_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `inspected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `inspected_at` timestamp NULL DEFAULT NULL,
  `legal_case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `damage_case_closed_at` timestamp NULL DEFAULT NULL,
  `auto_approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `extracted_requester_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Data extracted from uploaded documents about the requester',
  `has_calendar_conflicts` tinyint(1) NOT NULL DEFAULT 0,
  `conflict_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Details of any scheduling conflicts found',
  `workflow_step` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted' COMMENT 'Current step in approval workflow',
  `workflow_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'History of workflow steps',
  `requester_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workflow_stage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ai_classification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_error` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability_conflicts_new` tinyint(1) NOT NULL DEFAULT 0,
  `conflict_resolution_required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility_reservations`
--

INSERT INTO `facility_reservations` (`id`, `document_id`, `facility_id`, `facility_request_id`, `reserved_by`, `start_time`, `end_time`, `purpose`, `document_path`, `document_name`, `document_type`, `ai_category`, `ai_summary`, `visitor_data`, `visitor_pass_id`, `legal_review_status`, `legal_comments`, `legal_reviewer_id`, `auto_approved`, `notification_sent_at`, `status`, `current_workflow_status`, `payment_status`, `payment_method`, `payment_amount`, `payment_transaction_id`, `payment_processed_at`, `approved_by`, `remarks`, `damage_flag`, `damage_cost`, `inspection_notes`, `damage_photos`, `checked_out_at`, `returned_at`, `inspected_by`, `inspected_at`, `legal_case_id`, `damage_case_closed_at`, `auto_approved_at`, `created_at`, `updated_at`, `extracted_requester_data`, `has_calendar_conflicts`, `conflict_details`, `workflow_step`, `workflow_history`, `requester_name`, `requester_contact`, `workflow_stage`, `workflow_log`, `ai_classification`, `ai_error`, `availability_conflicts_new`, `conflict_resolution_required`) VALUES
(142, NULL, 35, NULL, 12, '2025-11-17 17:08:00', '2025-11-17 20:08:00', 'nfgngf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'not_required', NULL, NULL, 0, NULL, 'approved', 'submitted', 'pending', NULL, NULL, NULL, NULL, NULL, 'Escalated to Legal.', 1, 4353453.00, 'dfhdf\n\nDamage Description: xcvfdsg\n\nDamage Severity: Moderate', NULL, NULL, '2025-11-17 07:08:55', 12, '2025-11-17 07:08:55', 41, NULL, NULL, '2025-11-17 07:08:55', '2025-11-17 07:08:55', NULL, 0, NULL, 'submitted', NULL, 'jane', 'itadori0912@gmail.com', 'submitted', NULL, NULL, NULL, 0, 0),
(143, NULL, 40, NULL, 12, '2025-11-17 19:49:00', '2025-11-18 15:49:00', 'ergerg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'not_required', NULL, NULL, 0, NULL, 'approved', 'submitted', 'pending', NULL, NULL, NULL, NULL, NULL, 'Escalated to Legal.', 1, 32432.00, 'fdbfd\n\nDamage Description: gvwergrew\n\nDamage Severity: Moderate', NULL, NULL, '2025-11-17 07:50:23', 12, '2025-11-17 07:50:23', 42, NULL, NULL, '2025-11-17 07:50:23', '2025-11-17 07:50:23', NULL, 0, NULL, 'submitted', NULL, 'jane', 'itadori0912@gmail.com', 'submitted', NULL, NULL, NULL, 0, 0),
(144, NULL, 43, 63, 12, '2025-11-20 13:16:00', '2025-11-21 23:16:00', 'sdbds', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'not_required', NULL, NULL, 0, NULL, 'approved', 'submitted', 'pending', NULL, NULL, NULL, NULL, NULL, 'Escalated to Legal.', 1, 2342.00, 'fdbfd\n\nDamage Description: sdvsdv\n\nDamage Severity: Moderate', NULL, NULL, '2025-11-20 15:17:31', 12, '2025-11-20 15:17:31', 43, NULL, NULL, '2025-11-20 15:17:31', '2025-11-20 15:17:32', NULL, 0, NULL, 'submitted', NULL, 'sdsdb', 'piqs09120@gmail.com', 'submitted', NULL, NULL, NULL, 0, 0),
(145, NULL, 43, 64, 12, '2025-11-24 05:37:00', '2025-11-25 03:37:00', 'geger', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'not_required', NULL, NULL, 0, NULL, 'approved', 'submitted', 'pending', NULL, NULL, NULL, NULL, NULL, 'Escalated to Legal.', 1, 43534534.00, 'rhrh\n\nDamage Description: herher\n\nDamage Severity: Major', NULL, NULL, '2025-11-23 19:38:19', 12, '2025-11-23 19:38:19', 44, NULL, NULL, '2025-11-23 19:38:19', '2025-11-23 19:38:19', NULL, 0, NULL, 'submitted', NULL, 'ern', 'piqs09120@gmail.com', 'submitted', NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `id_verification_logs`
--

CREATE TABLE `id_verification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `form_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_id_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_id_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_date_of_birth` date DEFAULT NULL,
  `extracted_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extracted_id_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extracted_date_of_birth` date DEFAULT NULL,
  `extracted_nationality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extracted_raw_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parse_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extraction_confidence` decimal(5,2) NOT NULL DEFAULT 0.00,
  `match_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `overall_confidence` decimal(5,2) NOT NULL DEFAULT 0.00,
  `verification_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `quality_passed` tinyint(1) NOT NULL DEFAULT 0,
  `quality_metrics` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `quality_issues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `component_scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `mismatch_reasons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `philid_verified` tinyint(1) NOT NULL DEFAULT 0,
  `philid_verification_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `id_document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_document_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewer_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consent_given` tinyint(1) NOT NULL DEFAULT 0,
  `consent_timestamp` timestamp NULL DEFAULT NULL,
  `data_retention_until` timestamp NULL DEFAULT NULL,
  `data_encrypted` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_ai_analyses`
--

CREATE TABLE `legal_ai_analyses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `analysis_version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  `classification` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `extracted_entities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `risk_assessment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `missing_clauses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `confidence_score` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_ai_results`
--

CREATE TABLE `legal_ai_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `analysis_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ai_result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence` decimal(5,2) DEFAULT NULL,
  `detected_violations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `applicable_laws` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `compliance_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `recommendations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ai_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'gemini-pro',
  `processing_time` decimal(8,3) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_audit_logs`
--

CREATE TABLE `legal_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_document_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_cases`
--

CREATE TABLE `legal_cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `case_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `workflow_stage` enum('filing','investigation','review','resolution','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'filing',
  `assigned_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `investigator_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_involved` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incident_date` datetime DEFAULT NULL,
  `incident_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `filing_date` date DEFAULT NULL,
  `court_date` date DEFAULT NULL,
  `outcome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `investigation_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `linked_case_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `investigation_started_at` datetime DEFAULT NULL,
  `investigation_completed_at` datetime DEFAULT NULL,
  `investigation_findings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution_decision` enum('approved','rejected','dismissed','settled','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disciplinary_actions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preventive_measures` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `stage_changed_at` datetime DEFAULT NULL,
  `days_in_current_stage` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legal_cases`
--

INSERT INTO `legal_cases` (`id`, `case_title`, `case_description`, `case_type`, `priority`, `status`, `source`, `visitor_id`, `amount`, `workflow_stage`, `assigned_to`, `investigator_id`, `employee_involved`, `incident_date`, `incident_location`, `created_by`, `case_number`, `filing_date`, `court_date`, `outcome`, `notes`, `investigation_notes`, `metadata`, `linked_case_id`, `created_at`, `updated_at`, `investigation_started_at`, `investigation_completed_at`, `investigation_findings`, `resolution_decision`, `resolution_notes`, `disciplinary_actions`, `preventive_measures`, `resolved_at`, `stage_changed_at`, `days_in_current_stage`) VALUES
(45, 'Visitor Violation – flora', 'dgfhgdfh', 'visitor_violation', 'high', 'completed', 'VISITOR_SYSTEM', 192, NULL, 'closed', NULL, NULL, NULL, '2025-11-27 00:00:00', 'bdfgdf', NULL, 'LC-2025-0030', NULL, NULL, NULL, 'gbfg', 'ewan', '{\"reported_at\": \"2025-11-28T01:20:55+08:00\", \"reported_by\": \" \", \"visitor_name\": \"flora\", \"visitor_email\": \"itadori0912@gmail.com\", \"violation_type\": \"security_breach\", \"visitor_contact\": \"09985456954\", \"visitor_pass_id\": \"PASS-EB94A8D9\"}', NULL, '2025-11-27 17:20:55', '2026-01-22 08:39:05', '2026-01-22 01:29:24', '2026-01-22 16:38:18', 'walapa', 'approved', 'veveve', 'sfvd', 'fdvdf', '2026-01-22 16:38:39', '2026-01-22 16:39:05', 0),
(46, 'Visitor Violation – adminneto', 'theft', 'visitor_violation', 'high', 'completed', 'VISITOR_SYSTEM', 191, NULL, 'closed', NULL, NULL, NULL, '2026-01-14 12:34:00', 'qc', '2', 'LC-2026-0001', NULL, NULL, NULL, NULL, 'WRGWE', '{\"violation_type\":\"disruptive_behavior\",\"visitor_name\":\"adminneto\",\"visitor_email\":\"admin@gmail.com\",\"visitor_contact\":\"09985456954\",\"visitor_pass_id\":\"PASS-829852CF\",\"reported_by\":\" \",\"reported_at\":\"2026-01-22T12:34:23+08:00\"}', NULL, '2026-01-22 04:34:23', '2026-01-22 05:58:24', '2026-01-22 13:42:53', '2026-01-22 13:57:49', 'WEGWE', 'approved', 'hjmh', ',hj,hj', 'jh,jh', '2026-01-22 13:58:09', '2026-01-22 13:58:24', 0),
(47, 'Trespassing', 'ergerger', 'visitor_violation', 'high', 'awaiting_review', 'VISITOR_SYSTEM', 187, NULL, 'review', NULL, NULL, 'jake', '2026-01-22 16:40:00', 'qc', '2', 'LC-2026-0002', NULL, NULL, NULL, NULL, 'regher', '{\"violation_type\":\"trespassing\",\"visitor_name\":\"jake\",\"visitor_email\":\"premsyt2024@gmail.com\",\"visitor_contact\":\"05950656522\",\"visitor_pass_id\":\"PASS-369B0405\",\"reported_by\":\"Michael Petras\",\"reported_at\":\"2026-01-22T16:40:28+08:00\"}', NULL, '2026-01-22 08:40:28', '2026-01-22 08:57:43', '2026-01-22 16:41:24', NULL, 'erher', NULL, NULL, NULL, NULL, NULL, '2026-01-22 16:57:43', 0),
(48, 'Security Breach', 'fgjfgj', 'visitor_violation', 'urgent', 'completed', 'VISITOR_SYSTEM', 185, NULL, 'closed', NULL, NULL, 'bren', '2026-01-22 17:00:00', 'qc', '2', 'LC-2026-0003', NULL, NULL, NULL, NULL, 'sgsg', '{\"violation_type\":\"security_breach\",\"visitor_name\":\"bren\",\"visitor_email\":\"premsyt2024@gmail.com\",\"visitor_contact\":\"09911211407\",\"visitor_pass_id\":\"PASS-D49A3CAD\",\"reported_by\":\"Michael Petras\",\"reported_at\":\"2026-01-22T17:01:00+08:00\"}', NULL, '2026-01-22 09:01:00', '2026-01-22 09:18:23', '2026-01-22 17:10:54', '2026-01-22 17:17:50', 'sges', 'approved', 'vbdf', 'dbdf', 'fdbfd', '2026-01-22 17:18:17', '2026-01-22 17:18:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `legal_case_policy`
--

CREATE TABLE `legal_case_policy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_case_id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_complaints`
--

CREATE TABLE `legal_complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_encrypted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'filed',
  `workflow_stage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_docs`
--

CREATE TABLE `legal_docs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_documents`
--

CREATE TABLE `legal_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `responsible_officer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `current_reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `retention_until` date DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `ai_summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ai_risk_score` double(8,2) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `legal_documents`
--

INSERT INTO `legal_documents` (`id`, `title`, `file_path`, `case_id`, `department`, `description`, `document_type`, `status`, `responsible_officer_id`, `created_by`, `uploaded_by`, `current_reviewer_id`, `version`, `retention_until`, `archived_at`, `ai_summary`, `ai_tags`, `ai_risk_score`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'red', NULL, NULL, 'hr', NULL, 'legal', 'pending_review', NULL, 10, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-10 08:32:34', '2025-09-10 08:32:41'),
(2, '1754219987_affidavit-GENERATOR', 'legal_documents/1754219987_affidavit-GENERATOR.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(3, '1754254099_affidavit-GENERATOR', 'legal_documents/1754254099_affidavit-GENERATOR.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(4, '1754254318_af', 'legal_documents/1754254318_af.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(5, '1754311188_BusinessMemo', 'legal_documents/1754311188_BusinessMemo.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(6, '1754507335_SampleContract-Shuttle', 'legal_documents/1754507335_SampleContract-Shuttle.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(7, '1754563427_Memo_to_File_Example082018', 'legal_documents/1754563427_Memo_to_File_Example082018.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(8, '1754819220_09. Visitor Information Services', 'legal_documents/1754819220_09. Visitor Information Services.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(9, '1755270391_SampleContract-Shuttle', 'legal_documents/1755270391_SampleContract-Shuttle.pdf', NULL, NULL, 'Imported from existing files', NULL, 'approved', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 12:10:12', '2026-01-22 12:10:12'),
(10, 'ABSENT WITHOUT LEAVE POLICY', NULL, NULL, 'Human Resources', 'Comprehensive policy establishing clear guidelines and procedures for addressing employee absences without prior authorization, including reporting procedures, disciplinary measures, and documentation requirements.', 'Policy', 'draft', NULL, 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-22 13:17:39', '2026-01-22 13:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `legal_document_obligations`
--

CREATE TABLE `legal_document_obligations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `obligation_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pending','completed','overdue','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `responsible_person` bigint(20) UNSIGNED NOT NULL,
  `notification_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_document_submissions`
--

CREATE TABLE `legal_document_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsible_officer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('low','normal','high','urgent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `status` enum('pending_review','under_review','approved','revision_requested','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_review',
  `submitted_by` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `ai_analysis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `review_notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_document_templates`
--

CREATE TABLE `legal_document_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `optional_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_document_versions`
--

CREATE TABLE `legal_document_versions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_document_id` bigint(20) UNSIGNED NOT NULL,
  `version_no` int(10) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_hash` varchar(128) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_document_versions`
--

INSERT INTO `legal_document_versions` (`id`, `legal_document_id`, `version_no`, `file_path`, `file_hash`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'legal-documents/ZuWKWx0SsNKARMXBTBmbWusXFCArmrG6jDvEcVhh.pdf', 'ef0d27c27f756742415b4883409b9fb078ce7b2ae6b738f4620c8cad84d6dac0', 'Initial upload', 10, '2025-09-10 08:32:34', '2025-09-10 08:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `legal_policies`
--

CREATE TABLE `legal_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `content_encrypted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_report_metrics`
--

CREATE TABLE `legal_report_metrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_date` date NOT NULL,
  `metric_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) NOT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_retention_policies`
--

CREATE TABLE `legal_retention_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `retention_years` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `auto_archive` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_review_actions`
--

CREATE TABLE `legal_review_actions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_document_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('approve','reject','request_revision') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ai_insights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_submissions`
--

CREATE TABLE `legal_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `legal_document_id` bigint(20) UNSIGNED NOT NULL,
  `submitted_by` bigint(20) UNSIGNED NOT NULL,
  `source_department` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legal_workflow_logs`
--

CREATE TABLE `legal_workflow_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `performed_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2019_12_14_000001_create_sessions_table', 1),
(5, '2025_07_10_081251_create_documents_table', 2),
(6, '2025_07_10_081301_create_document_requests_table', 2),
(7, '2025_07_10_082652_create_facilities_table', 3),
(8, '2025_07_10_082700_create_facility_reservations_table', 3),
(9, '2025_07_10_084300_create_visitors_table', 4),
(11, '2025_07_10_105228_add_role_to_users_table', 6),
(12, '2025_07_10_120000_create_rooms_table', 7),
(13, '2025_07_10_120010_create_reservations_table', 7),
(14, '2025_07_10_120020_create_orders_table', 7),
(16, '2025_07_10_120040_create_alerts_table', 7),
(18, '2025_07_10_160934_create_notifications_table', 9),
(20, '2025_07_16_160810_add_category_to_documents_table', 10),
(21, '2025_07_16_175239_create_show_table', 11),
(22, '2025_07_16_190653_create', 11),
(23, '2025_07_19_142507_add_company_and_host_to_visitors_table', 11),
(24, '2025_07_28_113440_update_facilities_status_enum', 12),
(25, '2025_07_28_124135_update_facilities_status_enum_add_more_options', 13),
(26, '2025_07_28_132531_add_pending_approved_status_to_facilities_table', 14),
(27, '2025_07_28_143540_add_is_scheduled_to_visitors_table', 15),
(28, '2025_07_29_030516_add_department_category_author_to_documents_table', 16),
(29, '2025_07_10_084838_create_compliances_table', 17),
(30, '2025_08_03_105908_add_original_filename_to_documents_table', 17),
(31, '2025_08_03_183946_add_ai_analysis_to_documents_table', 18),
(32, '2025_08_03_203841_add_source_to_documents_table', 19),
(33, '2025_08_07_112153_add_document_and_ai_fields_to_facility_reservations_table', 20),
(34, '2025_08_09_021822_add_legal_and_indexes_to_facility_reservations_table', 21),
(35, '2025_08_09_022647_create_jobs_table', 22),
(36, '2025_08_10_021432_add_requester_data_to_facility_reservations_table', 23),
(38, '2025_08_10_024543_add_ai_error_to_facility_reservations_table', 24),
(39, '2025_08_10_031918_add_missing_requester_fields_to_facility_reservations_table', 25),
(40, '2024_03_19_000001_remove_security_notification_columns', 26),
(41, '2024_03_19_000002_remove_digital_passes_columns', 27),
(42, '2024_03_19_000003_remove_requester_department_column', 28),
(43, '2024_03_19_000004_remove_extracted_fields', 29),
(44, '2024_03_19_000005_remove_processing_timestamps', 30),
(45, '2025_08_10_040000_ensure_ai_fields_on_facility_reservations_table', 31),
(46, '2025_08_10_041000_ensure_availability_fields_on_facility_reservations_table', 32),
(47, '2025_08_10_050500_add_pass_and_security_fields_to_facility_reservations_table', 33),
(48, '2025_08_15_033259_modify_status_in_facilities_table', 34),
(49, '2025_08_16_023849_create_reservation_tasks_table', 35),
(50, '2025_08_16_023935_update_facility_reservations_table_for_workflow', 36),
(51, '2025_08_16_042945_add_facility_reservation_id_to_visitors_table', 37),
(52, '2025_08_18_144916_add_workflow_fields_to_documents_table', 38),
(53, '2025_08_18_144956_add_document_id_to_facility_reservations_table', 39),
(54, '2025_08_20_000001_create_legal_cases_table', 40),
(55, '2024_01_01_000000_create_document_workflows_table', 41),
(56, '2025_08_23_135611_add_ai_analysis_fields_to_facility_reservations_table', 42),
(57, '2025_08_23_135616_add_ai_analysis_fields_to_facility_reservations_table', 43),
(58, '2025_08_23_144340_add_lifecycle_log_to_documents_table', 44),
(59, '2025_08_23_144558_add_enhanced_fields_to_documents_table', 45),
(60, '2025_08_24_162604_add_timestamps_to_department_accounts_table', 46),
(61, '2025_08_24_162449_create_core1_guest_table', 47),
(65, '2025_08_24_204003_create_legal_cases_table', 48),
(66, '2025_07_10_150000_create_access_logs_table', 49),
(67, '2025_08_25_135731_add_extracted_text_to_documents_table', 50),
(68, '2025_08_26_121702_add_enhanced_ai_fields_to_documents_table', 51),
(69, '2025_09_05_023623_add_enhanced_fields_to_facilities_table', 52),
(70, '2025_09_05_033714_add_payment_fields_to_facility_reservations_table', 53),
(71, '2025_09_07_020932_add_insurance_to_visitors_table', 54),
(72, '2025_09_07_030448_add_pass_issuance_fields_to_visitors_table', 55),
(73, '2025_09_07_035134_add_new_fields_to_visitors_table', 56),
(74, '2025_09_07_055320_create_visitor_checkin_logs_table', 57),
(75, '2025_09_07_062224_make_time_in_and_time_out_nullable_in_visitors_table', 58),
(76, '2025_09_07_080000_add_department_to_visitors_table', 59),
(77, '2025_09_08_033137_create_facility_requests_table', 60),
(78, '2025_09_10_000001_add_requested_end_datetime_to_facility_requests', 61),
(79, '2025_09_10_115209_add_expected_time_out_to_visitors_table', 62),
(80, '2025_09_10_121323_add_expected_date_out_to_visitors_table', 63),
(81, '2025_09_10_124100_add_arrival_date_time_to_visitors_table', 64),
(82, '2025_09_10_153900_create_legal_documents_module', 65),
(83, '2025_09_11_005917_add_metadata_to_documents_table', 66),
(84, '2025_09_11_044444_add_hr_integration_fields_to_documents_table', 67),
(85, '2025_09_11_053421_add_reference_id_to_documents_table', 68),
(86, '2025_09_13_051506_add_violation_fields_to_legal_cases_table', 69),
(87, '2025_09_13_120405_add_linked_case_id_to_documents_table', 70),
(88, '2025_09_13_120438_add_metadata_to_legal_cases_table', 71),
(89, '2025_09_14_033052_add_dms_fields_to_documents_table', 72),
(90, '2025_09_14_033126_create_document_access_logs_table', 73),
(92, '2025_09_14_055506_update_documents_status_enum', 74),
(93, '2025_09_14_122317_add_disposal_tracking_to_documents_table', 75),
(94, '2025_09_14_125553_create_disposal_history_table', 76),
(95, '2025_09_14_170500_alter_status_column_to_string_in_documents_table', 77),
(96, '2025_09_14_180000_create_legal_workflow_tables', 78),
(97, '2025_09_14_144207_add_legal_document_id_to_documents_table', 79),
(98, '2025_09_14_144517_add_approval_fields_to_documents_table', 80),
(99, '2025_09_15_004810_add_pending_exit_to_visitors_table', 81),
(100, '2025_09_15_025409_create_otp_codes_table', 82),
(101, '2025_08_24_162431_create_department_accounts_table', 1),
(102, '2025_08_25_044406_add_missing_fields_to_documents_table', 83),
(103, '2025_08_25_045203_update_documents_table_add_missing_fields', 83),
(104, '2025_09_12_000001_add_esign_fields_to_documents_table', 84),
(105, '2025_09_14_033205_create_document_retention_policies_table', 84),
(106, '2025_09_17_045421_fix_duplicate_legal_case_numbers', 84),
(107, '2025_09_18_045748_add_preschedule_fields_to_visitors_table', 85),
(108, '2025_09_18_050537_add_access_code_to_visitors_table', 86),
(109, '2025_09_18_051142_fix_contact_field_in_visitors_table', 87),
(110, '2025_10_08_000001_create_legal_policies_table', 88),
(111, '2025_10_08_000002_create_legal_complaints_table', 88),
(112, '2025_10_08_000003_create_violation_reports_table', 88),
(113, '2025_10_09_112708_add_retention_policy_fields_to_documents_table', 89),
(114, '2025_10_19_171928_add_ai_enhancement_fields_to_documents_table', 90),
(115, '2025_10_19_184113_create_company_policies_table', 91),
(116, '2025_10_19_184144_create_employee_complaints_table', 91),
(117, '2025_10_19_184311_create_legal_ai_results_table', 92),
(118, '2025_10_20_142711_add_collaboration_fields_to_documents_table', 93),
(119, '2025_10_22_220119_add_document_id_to_access_logs_table', 94),
(120, '2025_10_23_000145_create_document_activities_table', 95),
(121, '2025_10_23_000709_add_department_to_users_table', 96),
(122, '2025_10_24_170608_add_id_verification_fields_to_visitors_table', 97),
(123, '2025_10_26_162714_add_ai_validation_fields_to_visitors_table', 98),
(124, '2025_11_01_225338_create_visitor_violations_table', 99),
(125, '2025_11_01_225349_add_source_fields_to_legal_cases_table', 100),
(126, '2025_11_01_234628_create_visitor_violation_audit_logs_table', 101),
(127, '2025_11_06_000100_create_company_policy_versions_table', 102),
(128, '2025_11_06_000110_create_policy_acknowledgements_table', 103),
(129, '2025_11_06_000120_create_legal_case_policy_table', 104),
(130, '2025_11_06_000130_create_visitor_violation_policy_table', 105),
(131, '2025_07_11_000001_create_id_verification_logs_table', 106),
(132, '2025_07_11_000002_create_visitor_qr_passes_table', 106),
(133, '2025_11_08_000003_add_dm_fields_to_documents', 107),
(134, '2025_11_08_000004_create_document_collaborators', 108),
(135, '2025_11_08_000005_create_document_activity_logs', 109),
(136, '2025_11_08_000006_create_document_versions', 110),
(137, '2025_11_10_000001_create_policies_table', 111),
(138, '2025_11_10_000002_create_user_consents_table', 112),
(139, '2025_11_16_154040_create_activity_stream_table', 113),
(140, '2025_11_08_000001_add_damage_fields_to_facility_reservations_table', 114),
(141, '2025_11_17_175657_add_facility_request_id_to_facility_reservations_table', 115),
(142, '2025_11_21_002559_add_workflow_fields_to_legal_cases_table', 116),
(143, '2025_11_21_002607_create_case_activities_table', 117),
(144, '2025_11_21_002614_create_case_evidence_table', 118),
(145, '2025_11_21_002617_create_case_witnesses_table', 119),
(146, '2025_10_19_184226_create_violation_reports_table', 120),
(147, '2025_10_19_184345_create_legal_audit_logs_table', 121),
(148, '2025_11_01_230000_create_visitor_violation_audit_logs_table', 122),
(149, '2025_11_08_000002_add_amount_to_legal_cases_table', 123),
(150, '2025_11_19_151524_create_document_share_invites_table', 123),
(151, '2025_11_19_233626_add_id_document_path_to_visitors_table', 124),
(152, '2025_11_26_000000_add_profile_photo_url_to_visitors_table', 124),
(153, '2025_11_27_010000_add_rating_fields_to_visitors_table', 125),
(154, '2025_11_28_005428_add_visitor_source_fields_to_legal_cases_table', 126),
(155, '2026_01_08_204914_add_profile_picture_to_users_table', 127),
(156, '2026_01_08_205630_ensure_employee_id_and_department_in_users_table', 128),
(157, '2026_01_08_210123_add_profile_picture_to_department_accounts_table', 129),
(158, '2026_01_08_210626_create_users_table_if_not_exists', 130),
(159, '2026_01_11_133402_add_missing_columns_to_users_table_for_api', 131),
(160, '2026_01_22_134056_change_status_column_type_in_legal_cases_table', 131),
(161, '2026_01_22_160240_create_case_dockets_table', 132),
(162, '2024_01_22_000001_create_visitor_batches_table', 133),
(163, '2026_01_22_195704_create_legal_docs_table', 134),
(164, '2026_01_23_004138_add_image_url_to_facilities_table', 135),
(165, '2026_01_23_014042_create_bulk_visit_sessions_table', 136),
(166, '2026_01_23_014059_add_bulk_session_id_to_visitors_table', 136),
(167, '2026_01_23_124323_add_supporting_document_to_visitors_table', 137),
(168, '2026_01_23_141128_add_visitor_data_to_bulk_visit_sessions_table', 138),
(169, '2026_01_23_143247_rename_visitors_table_to_visitor', 139),
(170, '2026_01_23_144332_create_singular_visitor_table', 140),
(171, '2026_01_23_232247_create_document_import_logs_table', 141),
(172, '2026_01_23_232408_add_import_fields_to_documents_table', 142),
(173, '2026_01_24_082136_add_pass_fields_back_to_visitor_table', 143),
(174, '2026_01_24_000000_add_dashboard_performance_indexes', 144),
(175, '2026_01_24_000002_remove_processing_timestamps', 145);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0022878b-d021-489d-9d84-1abf5e97764f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":11,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-08 20:24:41', '2025-08-08 20:24:41'),
('01542519-d9df-4ad7-9730-a2e672c673a1', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 119, '{\"visitor_id\":119,\"visitor_name\":\"jade\",\"checkout_time\":\"2025-09-14T17:25:00.000000Z\",\"minutes_remaining\":3,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:21:11', '2025-09-14 17:21:11'),
('01f8c02c-7508-4c0e-b54e-966fbcfff1d2', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 05:55:02', '2026-01-08 23:20:25'),
('020507ad-198b-459d-bf52-30ac909cd7ee', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:02:54', '2026-01-08 23:20:25'),
('02d1cfb4-28d1-4cf1-b96b-1253414b811d', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-10 10:12:21', '2025-08-10 10:12:21'),
('03ede6cc-90ec-489c-8990-13162c80e5d7', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":108,\"facility_name\":\"novtel\",\"start_time\":\"2025-08-17 03:42:00\",\"end_time\":\"2025-08-21 03:42:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"cnc\"}', '2026-01-08 23:20:25', '2025-08-15 19:46:17', '2026-01-08 23:20:25'),
('0492d7ad-504d-4d18-bf27-16d2980dcdac', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":29,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:46:37', '2025-08-14 19:46:37'),
('04cfce1c-1aad-40db-8e5e-bed01f6b2e7b', 'App\\Notifications\\NewVisitorIdVerificationNotification', 'App\\Models\\User', 12, '{\"visitor_id\":180,\"visitor_name\":\"gigi\",\"visitor_email\":\"piqs09120@gmail.com\",\"id_type\":\"philsys\",\"id_number\":\"6645445\",\"purpose\":\"tambay\",\"message\":\"New visitor \\\"gigi\\\" requires ID verification\",\"action_url\":\"http:\\/\\/administrative.test\\/visitor\\/id-verification?visitor_id=180\",\"type\":\"visitor_id_verification\"}', '2025-10-27 17:09:41', '2025-10-26 08:03:48', '2025-10-27 17:09:41'),
('09394c38-0cfb-4833-bb73-fe7be63cfe63', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:40:59', '2025-08-10 09:40:59'),
('0a1a281b-713a-467d-a398-5ba02fcf6f78', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":23,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-10 09:15:12', '2025-08-10 09:15:12'),
('0a8f92f1-739e-4970-a7f9-5864e44df2f5', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:09:41', '2026-01-08 23:20:25'),
('0df1841c-6fd6-4aa7-8567-25efc009b576', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 19:46:21', '2026-01-08 23:20:25'),
('0e91d14c-8f3a-4f0f-9fc9-f9fab5f9bf34', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":10,\"status\":\"denied\",\"remarks\":\"wawa\"}', '2026-01-08 23:20:25', '2025-07-15 12:21:39', '2026-01-08 23:20:25'),
('100629d6-f0cf-4209-9ff2-2aa6e2cff9d4', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-18 10:24:26', '2026-01-08 23:20:25'),
('1046ef3d-de36-4412-a4bb-75bc696dc8ee', 'App\\Notifications\\VisitorExceededTimeAlert', 'App\\Models\\User', 10, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"company\":\"rhrth\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_overdue\":23,\"host\":\"ern\",\"department\":\"Information Technology\",\"facility\":\"N\\/A\",\"type\":\"visitor_exceeded_time_alert\",\"priority\":\"critical\",\"alert_level\":\"overdue\",\"status\":\"pending_exit\"}', NULL, '2025-09-14 18:09:30', '2025-09-14 18:09:30'),
('11c07bf1-d271-4431-b596-aa271c0720ef', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-16 08:23:19', '2026-01-08 23:20:25'),
('13137f56-7fe9-4797-9f30-9809239e7444', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:21:46', '2026-01-08 23:20:25'),
('131e4c3f-50a1-4efe-9226-08f8d8ec7933', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-10 09:36:27', '2025-08-10 09:36:27'),
('1623ebef-e8ba-4915-ab8a-d0612e8fe863', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:58:37', '2025-08-10 09:58:37'),
('171d40fd-3c77-4dd8-8105-9e43d5903690', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 21:39:20', '2026-01-08 23:20:25'),
('19fb70ff-3d62-4234-a000-9703345b2bf9', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":22,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:41:40', '2025-08-09 23:41:40'),
('1e21b040-4a6e-420c-92e9-0a81d44c4f93', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":17,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-08 18:36:37', '2026-01-08 23:20:25'),
('1e928056-4df3-4fb5-b23b-a860e01c51ec', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 3, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-26 04:20:21', '2025-08-26 04:20:21'),
('21df8b59-d9e4-4cd4-b28b-5d7204b872e5', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":11,\"status\":\"approved\",\"remarks\":\"sfsef\"}', '2026-01-08 23:20:25', '2025-07-16 01:38:01', '2026-01-08 23:20:25'),
('21e0a5a0-f71e-4703-a93c-8d56dc3c9377', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:16:59', '2025-08-14 19:16:59'),
('23001cb1-97e4-4d43-8424-8e4e1ec7bbd6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:13:13', '2026-01-08 23:20:25'),
('23edd15e-0585-47e7-a7fa-0a7e62ff9035', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-19 11:42:43', '2026-01-08 23:20:25'),
('244e4fa8-55c6-40ed-a7e2-e4af6724c711', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 10:08:44', '2025-08-10 10:08:44'),
('2503a59f-b4f2-4445-ade9-b361691d5ea6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 22:06:02', '2026-01-08 23:20:25'),
('25251164-6da5-46a2-b26d-58d06de37fd6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:10:59', '2026-01-08 23:20:25'),
('267c9e1c-dbe5-44f6-a154-38ba8eaca7cf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 06:43:25', '2026-01-08 23:20:25'),
('28893234-b5df-4db8-833d-7155bc9e674f', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 114, '{\"visitor_id\":114,\"visitor_name\":\"ern\",\"checkout_time\":\"2025-09-14T07:18:00.000000Z\",\"minutes_remaining\":10,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:18:34', '2025-09-14 17:18:34'),
('295256f7-391c-47ca-b508-4d17dc5d7565', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-16 08:36:52', '2026-01-08 23:20:25'),
('2e697093-1755-4574-9f54-6816a3cfe00f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-09 20:21:27', '2026-01-08 23:20:25'),
('2ecf5f99-9920-4d28-bd13-20f74d50cc9d', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":23,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', '2026-01-08 23:20:25', '2025-08-10 09:05:32', '2026-01-08 23:20:25'),
('326e5fca-e1e7-4caa-ac28-e289d88d9d33', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:48:31', '2025-08-10 09:48:31'),
('37b09782-b2af-4f4e-86e7-b03b07c2d9bf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-08 19:13:14', '2025-08-08 19:13:14'),
('38659cf2-1af8-44c1-ae86-a364840500be', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:03:46', '2026-01-08 23:20:25'),
('3913ed4b-9350-4ac2-bcb1-2f46781e6ef6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #133 by Ernesto Piquero from Aug 19, 2025 7:43 PM to Aug 20, 2025 7:40 PM for \'dfwvw\'\"}', '2026-01-08 23:20:25', '2025-08-19 11:41:22', '2026-01-08 23:20:25'),
('3a551b7d-2569-4f83-97e2-928eb8570b5b', 'App\\Notifications\\AdminCheckoutAlert', 'App\\Models\\User', 10, '{\"visitor_id\":119,\"visitor_name\":\"jade\",\"company\":\"rgrh\",\"checkout_time\":\"2025-09-14T17:25:00.000000Z\",\"minutes_remaining\":3,\"host\":\"rehe\",\"department\":\"Information Technology\",\"type\":\"admin_checkout_alert\"}', NULL, '2025-09-14 17:21:11', '2025-09-14 17:21:11'),
('3b3db1c8-d141-43f4-a0ed-fdf1e0ae3269', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-06 22:18:47', '2026-01-08 23:20:25'),
('3badee85-e5ce-47e4-9ccc-283cc2229184', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:54:19', '2026-01-08 23:20:25'),
('3ca17860-fcba-4d21-9905-6aadf970ea9a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-09 20:21:56', '2025-08-09 20:21:56'),
('3d29dc43-3096-4de1-9370-c2f7a80cb5b8', 'App\\Notifications\\VisitorExceededTimeAlert', 'App\\Models\\User', 10, '{\"visitor_id\":126,\"visitor_name\":\"Test Visitor 3 (Overdue)\",\"company\":\"Test Company\",\"checkout_time\":\"2025-09-14T14:09:30.000000Z\",\"minutes_overdue\":240,\"host\":\"Test Host\",\"department\":null,\"facility\":\"Equipment \\/ Assets\",\"type\":\"visitor_exceeded_time_alert\",\"priority\":\"critical\",\"alert_level\":\"overdue\",\"status\":\"pending_exit\"}', NULL, '2025-09-14 18:09:37', '2025-09-14 18:09:37'),
('3d843755-b24b-413f-b975-de7a95c63809', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:48:33', '2025-08-10 09:48:33'),
('3e1f09c8-06e7-44c3-8dac-3a4a62474b02', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":22,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:41:39', '2025-08-09 23:41:39'),
('3f26b904-ac78-4369-bb3c-3df420e20333', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":13,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:10:13', '2025-08-14 19:10:13'),
('3f987b8c-1c52-45c6-ad50-f4db23feb1bb', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 04:11:03', '2026-01-08 23:20:25'),
('3fefb6f0-e936-4716-84fe-fc3b116e1533', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:01:19', '2026-01-08 23:20:25'),
('41bb4c55-0775-48d7-bbf7-43bc86364899', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:29:19', '2025-08-14 19:29:19'),
('41e7a1bb-4aa4-4932-9ab2-99f4bd0b0d50', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:54:37', '2025-08-14 19:54:37'),
('42d50d56-a6f7-4765-b32c-27cd28064857', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:29:35', '2025-08-14 19:29:35'),
('438a0050-cd4d-4ae6-8f4c-2c1aec069419', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:34:22', '2026-01-08 23:20:25'),
('449aeaf1-ebd6-46da-a548-22d1f3055dd0', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":7,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #27 by Gigi Piquero from Aug 9, 2025 12:14 PM to Aug 13, 2025 12:15 PM for \'safaf\'\"}', NULL, '2025-08-09 23:37:13', '2025-08-09 23:37:13'),
('457445cc-ba67-4165-aa1f-5a9e8bbf4ed5', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:54:29', '2025-08-14 19:54:29'),
('45d25c27-e6f5-40e4-a3d5-5f32cd452ed6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":9,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:16:01', '2025-08-09 23:16:01'),
('45e5eb02-496e-44b5-9415-90c2a4dae423', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:02:56', '2026-01-08 23:20:25'),
('46d46212-d9b8-4983-9fe2-c4e2690621b6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:24:53', '2026-01-08 23:20:25'),
('47e303ae-6d5f-4ff5-8072-ab911f8f2e44', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":14,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-07-28 19:48:39', '2026-01-08 23:20:25'),
('49bd25c4-4aa9-4b1e-b7f6-f471c505ba29', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-15 04:11:34', '2025-08-15 04:11:34'),
('4b974974-7b0c-4603-83ec-173852d55080', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 123, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_remaining\":5,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:40:51', '2025-09-14 17:40:51'),
('4cf8a3e7-123b-4320-88dc-03c2546a35ae', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":7,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-08 20:15:12', '2025-08-08 20:15:12'),
('4f8d1483-64c7-4ba7-b004-8f55b62ae4c4', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":9,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:16:03', '2025-08-09 23:16:03'),
('53693f1c-791c-4e49-b560-56561d3e1418', 'App\\Notifications\\VisitorExceededTimeAlert', 'App\\Models\\User', 10, '{\"visitor_id\":124,\"visitor_name\":\"Test Visitor 1 (10min)\",\"company\":\"Test Company\",\"checkout_time\":\"2025-09-14T17:19:30.000000Z\",\"minutes_overdue\":50,\"host\":\"Test Host\",\"department\":null,\"facility\":\"Equipment \\/ Assets\",\"type\":\"visitor_exceeded_time_alert\",\"priority\":\"critical\",\"alert_level\":\"overdue\",\"status\":\"pending_exit\"}', NULL, '2025-09-14 18:09:34', '2025-09-14 18:09:34'),
('54a437d2-627a-4bd3-bcc6-265e4d335b25', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":7,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #27 by Gigi Piquero from Aug 9, 2025 12:14 PM to Aug 13, 2025 12:15 PM for \'safaf\'\"}', NULL, '2025-08-09 23:37:10', '2025-08-09 23:37:10'),
('559edcd8-7b8d-4798-8bbb-fa691c4d5953', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:09:10', '2026-01-08 23:20:25'),
('56a53a03-4907-4c7a-af1f-97f77997913c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Approved after visitor coordination completion\"}', '2026-01-08 23:20:25', '2025-08-14 05:55:25', '2026-01-08 23:20:25'),
('57be4421-6326-4f5d-8a89-0b4338c566aa', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:19:43', '2026-01-08 23:20:25'),
('58ab822f-1355-467d-96ea-af83160f9718', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #45 by Ernesto Piquero from Aug 11, 2025 12:13 PM to Aug 22, 2025 12:13 PM for \'ffw\'\"}', '2026-01-08 23:20:25', '2025-08-09 20:32:30', '2026-01-08 23:20:25'),
('58d9757d-d89a-4c84-a555-4441d2ff4334', 'App\\Notifications\\SystemActionNotification', 'App\\Models\\User', 12, '{\"title\":\"Test Notification\",\"message\":\"This is a test notification to verify the notification system is working!\",\"type\":\"info\",\"action\":\"test\",\"model_type\":\"system\",\"model_id\":null}', '2025-11-21 05:40:47', '2025-11-21 05:25:49', '2025-11-21 05:40:47'),
('59a78c55-40ee-4fb8-8855-bb821c1e428b', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"denied\",\"remarks\":\"Flagged by legal review: wa,al\"}', '2026-01-08 23:20:25', '2025-08-15 20:13:53', '2026-01-08 23:20:25'),
('59e7476d-5faf-4750-95cd-582ae75fd78e', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 123, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_remaining\":5,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:40:29', '2025-09-14 17:40:29'),
('5d7ee53a-5dbe-414b-806d-a0c9b984cba6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:11:00', '2026-01-08 23:20:25'),
('5dc0d3df-1c3b-4067-8a04-ca767d8492b1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:40:27', '2025-08-14 19:40:27'),
('5e27ac0b-743f-4abd-8322-2c6dfe494900', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":23,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', '2026-01-08 23:20:25', '2025-08-10 09:05:31', '2026-01-08 23:20:25'),
('625bf68d-7429-4c44-a6ea-abdbabedfb57', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:58:35', '2025-08-10 09:58:35'),
('639d2ab1-d555-42cb-a031-7b79d7a9bb59', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-08 19:13:14', '2025-08-08 19:13:14'),
('63d22c96-6664-48b8-b7f6-c9f8531eff8e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:08:37', '2026-01-08 23:20:25'),
('66dc64e1-b407-4380-bb77-f205d44c8426', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 20:50:14', '2026-01-08 23:20:25'),
('67f07a07-b3f6-4bd4-9921-233f8f005fcf', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":126,\"facility_name\":\"laire\",\"start_time\":\"2025-08-17 16:22:00\",\"end_time\":\"2025-08-20 16:22:00\",\"visitor_count\":0,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"fuyjf\"}', '2026-01-08 23:20:25', '2025-08-16 08:38:31', '2026-01-08 23:20:25'),
('686be462-a5c6-4e30-8acd-2f8ccc8a0b01', 'App\\Notifications\\AdminCheckoutAlert', 'App\\Models\\User', 10, '{\"visitor_id\":120,\"visitor_name\":\"Test Visitor\",\"company\":\"Test Company\",\"checkout_time\":\"2025-09-14T17:26:54.000000Z\",\"minutes_remaining\":5,\"host\":\"ern\",\"department\":\"IT\",\"type\":\"admin_checkout_alert\"}', NULL, '2025-09-14 17:21:14', '2025-09-14 17:21:14'),
('69271479-3f65-476a-a459-c9e3af2b639e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:21:47', '2026-01-08 23:20:25'),
('69ab9404-a5a1-472b-9aa5-c98fb4105789', 'App\\Notifications\\DocumentRequestStatusNotification', 'App\\Models\\User', 1, '{\"document_id\":5,\"status\":\"approved\",\"remarks\":\"wefw\"}', '2026-01-08 23:20:25', '2025-07-16 09:00:10', '2026-01-08 23:20:25'),
('6ab48c17-5b7b-4185-badb-c4d30a7042ce', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 21:39:00', '2026-01-08 23:20:25'),
('6b07291e-df5b-46af-8e40-b916070beeaf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":16,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:03:54', '2025-08-09 23:03:54'),
('6d11444a-7491-4c9e-b3e2-cd2fc3d2c5f8', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:13:11', '2026-01-08 23:20:25'),
('6e05f791-14b6-4cda-bd52-05d46981d3bf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-08 18:48:44', '2026-01-08 23:20:25'),
('6e9b47d8-4e0a-44ff-a8cc-95064706744b', 'App\\Notifications\\DocumentRequestStatusNotification', 'App\\Models\\User', 1, '{\"document_id\":14,\"status\":\"approved\",\"remarks\":\"sef\"}', '2026-01-08 23:20:25', '2025-07-17 09:09:39', '2026-01-08 23:20:25'),
('70ecfdf9-2ef5-4b9b-bea0-fce9b4f1729e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:17:56', '2025-08-14 19:17:56'),
('71b8b738-27fe-49ac-9ece-c266a0e50629', 'App\\Notifications\\DocumentRequestStatusNotification', 'App\\Models\\User', 1, '{\"document_id\":5,\"status\":\"approved\",\"remarks\":\"wefw\"}', '2026-01-08 23:20:25', '2025-07-16 09:00:12', '2026-01-08 23:20:25'),
('72506d3c-d2c7-4664-84a5-878164e19fe7', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-09 23:21:45', '2025-08-09 23:21:45'),
('73378141-fb30-4ab7-9813-8f9a0a260025', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:38:35', '2026-01-08 23:20:25'),
('733a8cdf-9d5a-477f-b400-16f6a55fc224', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":24,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #63 by Gigi Piquero from Aug 14, 2025 1:21 AM to Aug 25, 2025 1:21 AM for \'tamvbay\'\"}', NULL, '2025-08-10 09:33:52', '2025-08-10 09:33:52'),
('762e5a70-fa77-4cb9-a1d2-5b7dc3777bcf', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":119,\"facility_name\":\"laire\",\"start_time\":\"2025-08-17 05:54:00\",\"end_time\":\"2025-08-18 05:54:00\",\"visitor_count\":0,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"myy\"}', '2026-01-08 23:20:25', '2025-08-15 21:55:23', '2026-01-08 23:20:25'),
('763d6dc0-cbe8-4030-a752-d4b6898387aa', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 120, '{\"visitor_id\":120,\"visitor_name\":\"Test Visitor\",\"checkout_time\":\"2025-09-14T17:26:54.000000Z\",\"minutes_remaining\":5,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:21:14', '2025-09-14 17:21:14'),
('76a8d5ef-73d8-4876-885b-3545ca3ac716', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:10:26', '2025-08-14 19:10:26'),
('76e7b810-8afc-4330-aaf6-ff121fc095a4', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":117,\"facility_name\":\"laire\",\"start_time\":\"2025-08-17 05:38:00\",\"end_time\":\"2025-08-28 05:38:00\",\"visitor_count\":0,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"fdd\"}', '2026-01-08 23:20:25', '2025-08-15 21:39:15', '2026-01-08 23:20:25'),
('78126960-e08f-4e24-a87c-4cd33aafeb78', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":13,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:46:56', '2025-08-10 09:46:56'),
('790688d9-33a0-4716-be0b-e2b5baa2c3de', 'App\\Notifications\\DocumentRequestStatusNotification', 'App\\Models\\User', 1, '{\"document_id\":5,\"status\":\"approved\",\"remarks\":\"wefw\"}', '2026-01-08 23:20:25', '2025-07-16 09:00:11', '2026-01-08 23:20:25'),
('7cb1c16c-5a7a-4e94-8555-a4f3d5e27124', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:19:44', '2026-01-08 23:20:25'),
('7cb6adea-031e-4e59-a1c4-b3bd60d238af', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-07 05:23:11', '2025-08-07 05:23:11'),
('7ccbbe2a-9d1a-4c16-828f-b12040f4b69e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-10 09:41:22', '2025-08-10 09:41:22'),
('7d178117-b815-4f96-af78-8f1bbc7e3c34', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":11,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-08 20:24:39', '2025-08-08 20:24:39'),
('7d939366-52ea-43ac-83df-4261619a51d6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":16,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:03:56', '2025-08-09 23:03:56'),
('80a09270-33a5-4e61-bdf6-1a2d2267ed48', 'App\\Notifications\\VisitorExceededTimeAlert', 'App\\Models\\User', 10, '{\"visitor_id\":125,\"visitor_name\":\"Test Visitor 2 (5min)\",\"company\":\"Test Company\",\"checkout_time\":\"2025-09-14T16:34:30.000000Z\",\"minutes_overdue\":95,\"host\":\"Test Host\",\"department\":null,\"facility\":\"Equipment \\/ Assets\",\"type\":\"visitor_exceeded_time_alert\",\"priority\":\"critical\",\"alert_level\":\"overdue\",\"status\":\"pending_exit\"}', NULL, '2025-09-14 18:09:35', '2025-09-14 18:09:35'),
('83de24d6-0cc1-45a0-abc1-da5269556f59', 'App\\Notifications\\DocumentRequestStatusNotification', 'App\\Models\\User', 1, '{\"document_id\":3,\"status\":\"approved\",\"remarks\":\"ssadsa\"}', '2026-01-08 23:20:25', '2025-07-16 04:17:33', '2026-01-08 23:20:25'),
('83e920ed-b2b9-4f79-bc6d-6bbc2f08900a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":29,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:46:21', '2025-08-14 19:46:21'),
('84c11b98-7c31-4929-adec-571676ac85f3', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":23,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:14:42', '2025-08-10 09:14:42'),
('851703bc-2b77-4626-9048-825047ccab86', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 3, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-26 04:24:58', '2025-08-26 04:24:58'),
('85263b25-b7ec-4328-a683-6c7d5e62e93e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:20:26', '2026-01-08 23:20:25'),
('855c2d09-3601-4fd7-ab0c-ef1ecc72e1ec', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #133 by Ernesto Piquero from Aug 19, 2025 7:43 PM to Aug 20, 2025 7:40 PM for \'dfwvw\'\"}', '2026-01-08 23:20:25', '2025-08-19 11:41:10', '2026-01-08 23:20:25'),
('86ce4874-9ad8-429a-b38b-c34124c81b4c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:24:51', '2026-01-08 23:20:25'),
('87de1c52-3b02-4d4d-a59b-b50a6ccf090c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 19:16:50', '2025-08-14 19:16:50'),
('8846eb29-b1a4-410a-874a-359341fc026a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:20:25', '2026-01-08 23:20:25'),
('8848ce51-d1c8-4220-9237-682db6a4a75e', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":116,\"facility_name\":\"laire\",\"start_time\":\"2025-08-17 04:59:00\",\"end_time\":\"2025-08-20 04:59:00\",\"visitor_count\":0,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"bdbdf\"}', '2026-01-08 23:20:25', '2025-08-15 21:12:48', '2026-01-08 23:20:25'),
('8b12483e-b26d-4364-861f-122b0b9157a1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Approved after visitor coordination completion\"}', '2026-01-08 23:20:25', '2025-08-14 06:43:48', '2026-01-08 23:20:25'),
('8c3a126a-114c-4cfc-a677-d07a567d8a0e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 21:55:27', '2026-01-08 23:20:25'),
('8cb63ebc-7155-4899-8998-ce9f25642ab3', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"denied\",\"remarks\":\"Flagged by legal review: there\'s so much risk\"}', NULL, '2025-08-10 10:31:37', '2025-08-10 10:31:37'),
('8cba3d8d-766a-4e56-a4bb-60efce69b0a6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #73 by Gigi Piquero from Aug 12, 2025 2:05 AM to Aug 28, 2025 2:05 AM for \'assvw\'\"}', NULL, '2025-08-10 10:08:11', '2025-08-10 10:08:11'),
('8e29351e-551b-4d80-b5f2-48f8622302ce', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #133 by Ernesto Piquero from Aug 19, 2025 7:43 PM to Aug 20, 2025 7:40 PM for \'dfwvw\'\"}', '2026-01-08 23:20:25', '2025-08-19 11:41:23', '2026-01-08 23:20:25'),
('8e6726c3-1e1d-4334-854c-12577b99ee41', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":120,\"facility_name\":\"laire\",\"start_time\":\"2025-08-17 06:05:00\",\"end_time\":\"2025-08-19 06:05:00\",\"visitor_count\":0,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"n b\"}', '2026-01-08 23:20:25', '2025-08-15 22:06:13', '2026-01-08 23:20:25'),
('925184ad-298e-4da9-b761-94a1fad24f69', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-09 20:16:14', '2026-01-08 23:20:25'),
('9299bef6-3303-4246-b1b1-f7f14fff6877', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":87,\"facility_name\":\"love\",\"start_time\":\"2025-08-15 21:53:00\",\"end_time\":\"2025-08-20 10:54:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"adcvav\"}', '2026-01-08 23:20:25', '2025-08-14 05:55:21', '2026-01-08 23:20:25'),
('92cd1c9e-1e92-42bf-9b7f-2c1e7c337c33', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 05:43:13', '2026-01-08 23:20:25'),
('938cdcc7-2763-4f82-9875-8a46414672b6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #45 by Ernesto Piquero from Aug 11, 2025 12:13 PM to Aug 22, 2025 12:13 PM for \'ffw\'\"}', '2026-01-08 23:20:25', '2025-08-09 20:32:28', '2026-01-08 23:20:25'),
('94ba32ee-1bfc-4b81-8c8c-889108eb004e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:16:21', '2026-01-08 23:20:25'),
('971192d8-00ae-4acc-8179-70d6610dcd8c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:13:52', '2026-01-08 23:20:25'),
('97ce78a7-7df9-4363-a984-2de3bc85bf36', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-15 04:11:47', '2025-08-15 04:11:47'),
('97e1ad54-c2f5-41b3-b52b-104f6cbeff3c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:03:45', '2026-01-08 23:20:25'),
('99459ebb-a1ba-4a4b-8f65-721dc179dc06', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:18:23', '2026-01-08 23:20:25'),
('99645cb4-58ab-4843-8616-8e8127210f60', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":21,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:46:40', '2025-08-09 23:46:40'),
('9a0177c7-0f73-450a-9ea5-091ee3eb62f8', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":8,\"status\":\"approved\",\"remarks\":\"Approved after visitor coordination completion\"}', '2026-01-08 23:20:25', '2025-08-14 05:43:29', '2026-01-08 23:20:25'),
('9d86b3f0-c9b4-478f-85e2-6974fc967447', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-08 18:48:44', '2026-01-08 23:20:25'),
('9dcd5256-9916-45ea-a423-62e47b8c8d04', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":7,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-08 20:15:14', '2025-08-08 20:15:14'),
('a1a99c29-6e6f-44a2-8cfa-496903a80b72', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":11,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:01:35', '2026-01-08 23:20:25'),
('a2303118-92fa-4d28-9e42-0290ccdc0774', 'App\\Notifications\\AdminCheckoutAlert', 'App\\Models\\User', 10, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"company\":\"rhrth\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_remaining\":5,\"host\":\"ern\",\"department\":\"Information Technology\",\"type\":\"admin_checkout_alert\"}', NULL, '2025-09-14 17:40:29', '2025-09-14 17:40:29'),
('a31e2dd6-4b72-440d-89ee-c127a6167d2f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-19 11:42:41', '2026-01-08 23:20:25'),
('a3f3a604-9279-4568-a1e7-065c5d7cbba5', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":17,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-08 18:36:37', '2026-01-08 23:20:25'),
('a5d0d24d-03f4-40ae-a398-5cca8d740e42', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 10:00:09', '2025-08-10 10:00:09'),
('a72909cc-9d67-435f-b558-062948ab5319', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 05:25:49', '2026-01-08 23:20:25'),
('a739876a-be49-4695-9a06-ef8879cba998', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 05:25:48', '2026-01-08 23:20:25'),
('a80f24e1-1adb-49a9-87b5-1d4ee6c4c894', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:01:20', '2026-01-08 23:20:25'),
('a951223a-e73f-489f-bc5c-830b62a555eb', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-09 20:08:37', '2026-01-08 23:20:25'),
('ab187e23-a466-4075-a382-f16bf4314f7f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:47:58', '2025-08-10 09:47:58'),
('acec7798-6075-4544-9dc5-5a7b241b911a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 20:22:44', '2026-01-08 23:20:25'),
('ad038d9c-b304-4d18-be7e-1e132f227e9e', 'App\\Notifications\\SystemActionNotification', 'App\\Models\\User', 12, '{\"title\":\"Test Facility Created\",\"message\":\"This is a test notification for facility creation\",\"type\":\"success\",\"action\":\"created\",\"model_type\":\"facility\",\"model_id\":999}', '2025-10-27 17:21:55', '2025-10-27 17:13:00', '2025-10-27 17:21:55'),
('adeead01-12a2-410a-942c-8e1c6f99349c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":21,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-09 23:46:38', '2025-08-09 23:46:38'),
('ae080be0-733e-4359-b17f-662a14d30ce8', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":8,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:41:00', '2025-08-10 09:41:00'),
('b09ee7f2-8010-46d2-9589-f4fab8587694', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #133 by Ernesto Piquero from Aug 19, 2025 7:43 PM to Aug 20, 2025 7:40 PM for \'dfwvw\'\"}', '2026-01-08 23:20:25', '2025-08-19 11:41:12', '2026-01-08 23:20:25'),
('b1461158-d889-4292-9835-94470afcb85c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 05:26:18', '2026-01-08 23:20:25'),
('b164bf90-0ab1-4262-b578-d0cc3ce1d7c1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 20:40:41', '2026-01-08 23:20:25'),
('b23b7093-4eb9-455f-9d8e-1b2fa873089d', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:34:20', '2026-01-08 23:20:25'),
('b2e15f44-be93-430d-8327-78cea6833d4d', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 123, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_remaining\":6,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:39:54', '2025-09-14 17:39:54'),
('b3069db0-adc1-447a-8dc5-4e7e787dda94', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 05:08:31', '2026-01-08 23:20:25'),
('b33af392-7cff-4532-bcbb-d6086d9927f6', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":14,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-07-28 09:00:15', '2026-01-08 23:20:25'),
('b3895e99-6d95-40c2-9749-ecb50a7e4302', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":85,\"facility_name\":\"novtel\",\"start_time\":\"2025-08-16 21:42:00\",\"end_time\":\"2025-08-18 09:42:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"svws\"}', '2026-01-08 23:20:25', '2025-08-14 05:43:25', '2026-01-08 23:20:25'),
('b3a26a60-2b0d-4c7f-84fa-0ce6b2170232', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 17:03:34', '2026-01-08 23:20:25'),
('b5292a4a-5b1e-4409-8ad5-de7fa34d4300', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:35:32', '2025-08-10 09:35:32');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('b6919d33-ba12-4eb7-ab7a-d16d1923d1a1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":23,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-10 09:06:13', '2026-01-08 23:20:25'),
('b6974785-40c6-4e2d-8c6c-0d61085b129f', 'App\\Notifications\\AdminCheckoutAlert', 'App\\Models\\User', 10, '{\"visitor_id\":114,\"visitor_name\":\"ern\",\"company\":\"ffbfsd\",\"checkout_time\":\"2025-09-14T07:18:00.000000Z\",\"minutes_remaining\":5,\"host\":\"ernfre\",\"department\":\"Finance\",\"type\":\"admin_checkout_alert\"}', NULL, '2025-09-14 17:18:34', '2025-09-14 17:18:34'),
('b817d95c-595c-4083-aefb-0c15d7e12556', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-18 10:12:35', '2026-01-08 23:20:25'),
('bb94386e-b9b8-48ea-bd9e-239cee7f0c5d', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:39:43', '2026-01-08 23:20:25'),
('bbf6562b-fb4d-49bd-8bae-61d924f36c10', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 18:11:25', '2026-01-08 23:20:25'),
('be260b47-b921-4bce-b3ae-c08a1b376d7b', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 10:11:19', '2025-08-10 10:11:19'),
('bfe7ae2e-5114-4eee-8263-39e9ce6e786b', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":112,\"facility_name\":\"novtel\",\"start_time\":\"2025-08-17 04:22:00\",\"end_time\":\"2025-08-21 04:22:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"dfde\"}', '2026-01-08 23:20:25', '2025-08-15 20:24:16', '2026-01-08 23:20:25'),
('c001fd61-2e1d-4254-9f23-e196d51f90de', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-07-28 03:55:01', '2026-01-08 23:20:25'),
('c1db5f91-4c52-4b42-9b1d-f9f81191c7ea', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 16:14:25', '2026-01-08 23:20:25'),
('c2744d63-b112-4987-bfae-d14e71f46a4e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:35:31', '2025-08-10 09:35:31'),
('c307f290-689e-42b7-bd5f-7f5cdc0310b9', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 10:08:46', '2025-08-10 10:08:46'),
('c3cab1ae-b9cf-4276-a41e-016498e22adf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 20:59:53', '2026-01-08 23:20:25'),
('c6645965-d10b-4844-9b22-a77a08d47c8e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":4,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-09 20:34:06', '2025-08-09 20:34:06'),
('c78e7c89-9749-471e-8d27-795cc7736efc', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 19:43:13', '2026-01-08 23:20:25'),
('c85cdcb2-2fea-48d3-b290-a4426457628b', 'App\\Notifications\\VisitorCheckoutReminder', 'App\\Models\\Visitor', 121, '{\"visitor_id\":121,\"visitor_name\":\"Immediate Test\",\"checkout_time\":\"2025-09-14T17:28:37.000000Z\",\"minutes_remaining\":7,\"type\":\"checkout_reminder\"}', NULL, '2025-09-14 17:21:17', '2025-09-14 17:21:17'),
('c8d2e6ef-67c4-429d-9689-fddd9e1a4a3a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:24:20', '2026-01-08 23:20:25'),
('c9c53cee-465f-411a-b8b6-ba6a25cb2766', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:09:40', '2026-01-08 23:20:25'),
('cc8dc2a0-519d-432c-be39-3e26e74183df', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":23,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:14:40', '2025-08-10 09:14:40'),
('cce67140-6d78-466f-b6fd-67c1b38ab694', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:22:37', '2026-01-08 23:20:25'),
('cd4871d8-543c-4478-b74d-878888132de2', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:54:20', '2026-01-08 23:20:25'),
('d0ce4fbb-641f-40e3-aba3-d0970b30f496', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":26,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-14 19:04:29', '2025-08-14 19:04:29'),
('d1f73d32-e421-4f25-b9ab-f3e30e90e60f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 20:02:16', '2025-08-14 20:02:16'),
('d27c2cdf-ad63-48b6-ae94-a7475c2bcd40', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":26,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-14 19:04:27', '2025-08-14 19:04:27'),
('d46b4ae8-e2ca-43eb-90a2-6e4ac16593ff', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":24,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #63 by Gigi Piquero from Aug 14, 2025 1:21 AM to Aug 25, 2025 1:21 AM for \'tamvbay\'\"}', NULL, '2025-08-10 09:33:51', '2025-08-10 09:33:51'),
('d488ad1f-a0bd-427d-b5e9-bd402b66b58a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":14,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 01:04:40', '2025-08-10 01:04:40'),
('d6159097-613a-4324-8b80-1f033b3bce00', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 10:00:10', '2025-08-10 10:00:10'),
('d617be62-a344-4b21-b6a3-fbb8d2f0bd4c', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:22:35', '2026-01-08 23:20:25'),
('d680680f-0798-4bbf-80ac-5077a787f767', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 21:12:53', '2026-01-08 23:20:25'),
('d7d3a0e9-d4bc-4119-b157-c6ea06ac08d3', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:42:07', '2025-08-10 09:42:07'),
('d96deb6d-dd98-406e-a343-ef8bba8368a1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:42:08', '2025-08-10 09:42:08'),
('dcbb75a2-f37d-47ec-9a5c-bf0ee67e6855', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":11,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-14 04:01:37', '2026-01-08 23:20:25'),
('dd2339b5-90c1-4596-8c74-2b0ab30fbe59', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 10:11:20', '2025-08-10 10:11:20'),
('dfc6f9ae-dd17-4240-93b5-fc1d22be2054', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 21:54:42', '2026-01-08 23:20:25'),
('e10bce0b-74d1-42e7-9f3c-373615b8ed7a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-14 05:25:11', '2026-01-08 23:20:25'),
('e1d551f4-4eaf-4831-bc48-7208da25bc7e', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":15,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:47:59', '2025-08-10 09:47:59'),
('e3bdc03f-9a54-46b3-ba32-2cf84ce9a9d1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 20:39:41', '2026-01-08 23:20:25'),
('e447746d-cf15-4139-8f82-160593432b53', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 18:09:11', '2026-01-08 23:20:25'),
('e44c2e60-a83c-4e22-bbe8-bcd0f0451c0f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 20:04:03', '2026-01-08 23:20:25'),
('e4e8ccf5-37a8-4d04-bf19-a0fa22b82cf0', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:16:20', '2026-01-08 23:20:25'),
('e624473d-b94d-4c5a-af99-356b9a1b7c84', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 16:14:17', '2026-01-08 23:20:25'),
('e66b3fe3-d353-4d21-963f-deda693483c1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-16 08:18:22', '2026-01-08 23:20:25'),
('e97a2545-d460-4ce2-90be-b2294dc229ec', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 3, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-26 04:20:20', '2025-08-26 04:20:20'),
('e9e2417f-2cbe-4a79-8897-1e59541da97b', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":13,\"status\":\"pending\",\"remarks\":\"Facility available but requires \"}', NULL, '2025-08-10 09:46:58', '2025-08-10 09:46:58'),
('eb07554a-47bf-440e-a303-fd4b57b8f78f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"denied\",\"remarks\":\"avav\"}', '2026-01-08 23:20:25', '2025-08-14 05:13:51', '2026-01-08 23:20:25'),
('ecd03569-029f-4952-a5cb-621e00d16058', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', NULL, '2025-08-14 20:02:07', '2025-08-14 20:02:07'),
('efe6b8bd-0640-40eb-87de-51f96f5ec4bf', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":13,\"status\":\"approved\",\"remarks\":\"Approved after visitor coordination completion\"}', '2026-01-08 23:20:25', '2025-08-14 05:26:30', '2026-01-08 23:20:25'),
('f0074034-a6dc-472e-b5fc-b6b7321397ee', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":18,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 19:29:37', '2026-01-08 23:20:25'),
('f051d95e-f6eb-4de4-abb6-c94b4f133b14', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":25,\"status\":\"denied\",\"remarks\":\"Facility not available for requested time period. Conflict with reservation #73 by Gigi Piquero from Aug 12, 2025 2:05 AM to Aug 28, 2025 2:05 AM for \'assvw\'\"}', NULL, '2025-08-10 10:08:09', '2025-08-10 10:08:09'),
('f1cc8231-dced-457b-9fcd-673623ba3f4c', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":84,\"facility_name\":\"love\",\"start_time\":\"2025-08-15 21:26:00\",\"end_time\":\"2025-08-22 21:26:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"kh,h\"}', '2026-01-08 23:20:25', '2025-08-14 05:26:25', '2026-01-08 23:20:25'),
('f23a710d-3ce9-4fca-a8fe-15e820ca6f6f', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-15 21:54:23', '2026-01-08 23:20:25'),
('f4a67e98-fa3b-44f8-96ec-9a0872577989', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 3, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-26 04:25:00', '2025-08-26 04:25:00'),
('f6098d7b-8e75-45dc-b0d2-068a947b0aa1', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":15,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-03 11:59:11', '2026-01-08 23:20:25'),
('f67b01e5-0002-47c0-8187-7d4372fa8bd0', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":4,\"status\":\"approved\",\"remarks\":\"sige\"}', NULL, '2025-08-09 23:38:36', '2025-08-09 23:38:36'),
('f69d7603-b1da-4a6b-bf95-097691a4a0d9', 'App\\Notifications\\SecurityNotification', 'App\\Models\\User', 1, '{\"type\":\"security_alert\",\"reservation_id\":88,\"facility_name\":\"OCADA\",\"start_time\":\"2025-08-15 22:42:00\",\"end_time\":\"2025-08-18 11:43:00\",\"visitor_count\":1,\"reserver_name\":\"Ernesto Piquero\",\"purpose\":\"wala lang\"}', '2026-01-08 23:20:25', '2025-08-14 06:43:44', '2026-01-08 23:20:25'),
('f7443e20-b6ee-4e64-b3a9-2fb24ecef5e4', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":16,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-07 04:34:38', '2026-01-08 23:20:25'),
('f7db5a12-3959-49a0-a876-2ef43d4dec0a', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":30,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', '2026-01-08 23:20:25', '2025-08-15 22:06:17', '2026-01-08 23:20:25'),
('fb6b3a45-7752-40cd-a09f-b9eb477528c7', 'App\\Notifications\\AdminCheckoutAlert', 'App\\Models\\User', 10, '{\"visitor_id\":123,\"visitor_name\":\"laire\",\"company\":\"rhrth\",\"checkout_time\":\"2025-09-14T17:46:00.000000Z\",\"minutes_remaining\":5,\"host\":\"ern\",\"department\":\"Information Technology\",\"type\":\"admin_checkout_alert\"}', NULL, '2025-09-14 17:40:51', '2025-09-14 17:40:51'),
('fbf87f77-d554-4979-aad1-81090abed6e7', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":27,\"status\":\"approved\",\"remarks\":null}', NULL, '2025-08-14 19:18:05', '2025-08-14 19:18:05'),
('fc318c98-26ad-4b86-bcae-47098ff9f334', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":25,\"status\":\"pending\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-08-16 08:52:02', '2026-01-08 23:20:25'),
('fde481f9-9e2e-4236-8cc6-175a8df6cc42', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 2, '{\"facility_id\":14,\"status\":\"approved\",\"remarks\":\"Auto-approved by system - no conflicts and no special requirements\"}', NULL, '2025-08-10 01:04:38', '2025-08-10 01:04:38'),
('fde8880d-21d6-4a03-b753-eb9000c2e8d5', 'App\\Notifications\\FacilityReservationStatusNotification', 'App\\Models\\User', 1, '{\"facility_id\":12,\"status\":\"approved\",\"remarks\":null}', '2026-01-08 23:20:25', '2025-07-16 03:56:11', '2026-01-08 23:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_codes`
--

INSERT INTO `otp_codes` (`id`, `employee_id`, `email`, `otp_code`, `expires_at`, `is_used`, `ip_address`, `created_at`, `updated_at`) VALUES
(32, 'S250501', 'piqs09120@gmail.com', '041068', '2025-09-14 20:11:23', 1, '127.0.0.1', '2025-09-14 20:01:23', '2025-09-14 20:15:39'),
(33, 'S250501', 'piqs09120@gmail.com', '562779', '2025-09-14 20:25:39', 1, '127.0.0.1', '2025-09-14 20:15:39', '2025-09-14 20:21:13'),
(34, 'S250501', 'piqs09120@gmail.com', '158510', '2025-09-14 20:31:13', 1, '127.0.0.1', '2025-09-14 20:21:13', '2025-09-14 20:27:23'),
(35, 'S250501', 'piqs09120@gmail.com', '620602', '2025-09-14 20:37:23', 1, '127.0.0.1', '2025-09-14 20:27:23', '2025-09-14 20:28:47'),
(36, 'S250501', 'piqs09120@gmail.com', '856418', '2025-09-14 20:38:47', 1, '127.0.0.1', '2025-09-14 20:28:47', '2025-09-14 20:34:17'),
(37, 'S250501', 'test@example.com', '735225', '2025-09-14 20:44:17', 1, '127.0.0.1', '2025-09-14 20:34:17', '2025-09-14 20:34:17'),
(38, 'S250501', 'piqs09120@gmail.com', '330525', '2025-09-14 20:45:49', 1, '127.0.0.1', '2025-09-14 20:35:49', '2025-09-14 20:36:12'),
(39, 'S250501', 'piqs09120@gmail.com', '188594', '2025-09-14 20:49:54', 1, '127.0.0.1', '2025-09-14 20:39:54', '2025-09-14 20:45:09'),
(40, 'S250501', 'piqs09120@gmail.com', '451610', '2025-09-14 20:55:09', 1, '127.0.0.1', '2025-09-14 20:45:09', '2025-09-14 20:56:25'),
(41, 'S250501', 'piqs09120@gmail.com', '089875', '2025-09-14 21:06:25', 1, '127.0.0.1', '2025-09-14 20:56:25', '2025-09-14 20:56:45'),
(42, 'S250501', 'piqs09120@gmail.com', '938370', '2025-09-14 21:07:08', 1, '127.0.0.1', '2025-09-14 20:57:08', '2025-09-14 20:57:25'),
(43, 'S250501', 'piqs09120@gmail.com', '370981', '2025-09-14 21:07:36', 1, '127.0.0.1', '2025-09-14 20:57:36', '2025-09-14 21:01:22'),
(44, 'S250501', 'piqs09120@gmail.com', '165443', '2025-09-14 21:11:22', 1, '127.0.0.1', '2025-09-14 21:01:22', '2025-09-14 21:06:27'),
(45, 'S250501', 'piqs09120@gmail.com', '257017', '2025-09-14 21:16:27', 1, '127.0.0.1', '2025-09-14 21:06:27', '2025-09-14 21:07:36'),
(46, 'S250501', 'piqs09120@gmail.com', '038711', '2025-09-14 21:17:36', 1, '127.0.0.1', '2025-09-14 21:07:36', '2025-09-14 21:07:53'),
(47, 'S250501', 'piqs09120@gmail.com', '638746', '2025-09-14 21:18:34', 1, '127.0.0.1', '2025-09-14 21:08:34', '2025-09-14 21:08:51'),
(48, 'S250501', 'piqs09120@gmail.com', '801495', '2025-09-14 21:22:51', 1, '127.0.0.1', '2025-09-14 21:12:51', '2025-09-14 21:13:22'),
(49, 'S250501', 'piqs09120@gmail.com', '302213', '2025-09-14 21:32:21', 1, '127.0.0.1', '2025-09-14 21:22:21', '2025-09-14 21:29:26'),
(50, 'S250501', 'piqs09120@gmail.com', '869395', '2025-09-14 21:39:26', 1, '127.0.0.1', '2025-09-14 21:29:26', '2025-09-14 21:33:10'),
(51, 'S250501', 'piqs09120@gmail.com', '877930', '2025-09-14 21:43:43', 1, '127.0.0.1', '2025-09-14 21:33:43', '2025-09-14 21:34:20'),
(52, 'S250501', 'piqs09120@gmail.com', '120712', '2025-09-14 21:53:40', 1, '127.0.0.1', '2025-09-14 21:43:40', '2025-09-14 21:53:15'),
(53, 'S250501', 'piqs09120@gmail.com', '863470', '2025-09-14 22:03:26', 1, '127.0.0.1', '2025-09-14 21:53:26', '2025-09-14 21:53:42'),
(54, 'S250501', 'piqs09120@gmail.com', '854788', '2025-09-14 22:03:53', 1, '127.0.0.1', '2025-09-14 21:53:53', '2025-09-14 21:55:11'),
(55, 'A250502', 'petrasmichael06@gmail.com', '048022', '2025-09-14 22:05:25', 1, '127.0.0.1', '2025-09-14 21:55:25', '2025-09-14 21:57:40'),
(56, 'A250502', 'petrasmichael06@gmail.com', '744048', '2025-09-15 05:49:51', 1, '127.0.0.1', '2025-09-15 05:39:51', '2025-09-15 05:41:25'),
(57, 'A250502', 'petrasmichael06@gmail.com', '190561', '2025-09-15 08:07:26', 1, '127.0.0.1', '2025-09-15 07:57:26', '2025-09-15 07:59:11'),
(58, 'S250501', 'piqs09120@gmail.com', '516902', '2025-09-15 14:55:33', 1, '127.0.0.1', '2025-09-15 14:45:33', '2025-09-15 14:46:24'),
(59, 'A250502', 'petrasmichael06@gmail.com', '930303', '2025-09-15 14:56:40', 1, '127.0.0.1', '2025-09-15 14:46:40', '2025-09-15 15:10:33'),
(60, 'A250502', 'petrasmichael06@gmail.com', '443660', '2025-09-15 15:20:33', 1, '127.0.0.1', '2025-09-15 15:10:33', '2025-09-15 15:11:42'),
(61, 'A250502', 'petrasmichael06@gmail.com', '159110', '2025-09-15 15:34:04', 1, '127.0.0.1', '2025-09-15 15:24:04', '2025-09-15 15:24:46'),
(62, 'S250501', 'piqs09120@gmail.com', '064044', '2025-09-15 15:37:21', 1, '127.0.0.1', '2025-09-15 15:27:21', '2025-09-15 15:28:07'),
(63, 'A250502', 'petrasmichael06@gmail.com', '799371', '2025-09-15 15:38:28', 1, '127.0.0.1', '2025-09-15 15:28:28', '2025-09-15 15:29:20'),
(64, 'A250502', 'petrasmichael06@gmail.com', '956845', '2025-09-15 15:50:23', 1, '127.0.0.1', '2025-09-15 15:40:23', '2025-09-15 15:40:49'),
(65, 'A250502', 'petrasmichael06@gmail.com', '039257', '2025-09-15 17:10:34', 1, '127.0.0.1', '2025-09-15 17:00:34', '2025-09-15 17:03:58'),
(66, 'A250502', 'petrasmichael06@gmail.com', '475383', '2025-09-15 18:10:40', 1, '127.0.0.1', '2025-09-15 18:00:40', '2025-09-15 18:01:43'),
(67, 'A250502', 'piqs09120@gmail.com', '526882', '2025-09-16 13:26:05', 1, '127.0.0.1', '2025-09-16 13:16:05', '2025-09-16 13:16:29'),
(68, 'A250502', 'piqs09120@gmail.com', '692889', '2025-09-16 19:52:17', 1, '127.0.0.1', '2025-09-16 19:42:17', '2025-09-16 20:09:53'),
(69, 'A250502', 'piqs09120@gmail.com', '776275', '2025-09-16 20:19:53', 1, '127.0.0.1', '2025-09-16 20:09:53', '2025-09-16 20:17:27'),
(70, 'A250502', 'piqs09120@gmail.com', '894063', '2025-09-16 20:27:27', 1, '127.0.0.1', '2025-09-16 20:17:27', '2025-09-16 20:17:51'),
(71, 'A250502', 'piqs09120@gmail.com', '859536', '2025-09-17 04:55:32', 1, '127.0.0.1', '2025-09-17 04:45:32', '2025-09-17 04:46:03'),
(72, 'A250502', 'piqs09120@gmail.com', '906030', '2025-09-17 07:27:03', 1, '127.0.0.1', '2025-09-17 07:17:03', '2025-09-17 07:18:02'),
(73, 'A250502', 'piqs09120@gmail.com', '401015', '2025-09-17 07:48:45', 1, '127.0.0.1', '2025-09-17 07:38:45', '2025-09-17 07:39:15'),
(74, 'A250502', 'piqs09120@gmail.com', '534796', '2025-09-17 07:50:50', 1, '127.0.0.1', '2025-09-17 07:40:50', '2025-09-17 07:41:10'),
(75, 'A250502', 'piqs09120@gmail.com', '558595', '2025-09-17 07:55:00', 1, '127.0.0.1', '2025-09-17 07:45:00', '2025-09-17 07:46:25'),
(76, 'A250502', 'piqs09120@gmail.com', '720484', '2025-09-17 11:41:25', 1, '127.0.0.1', '2025-09-17 11:31:25', '2025-09-17 11:32:18'),
(77, 'S250501', 'piqs09120@gmail.com', '345773', '2025-09-17 15:45:22', 1, '127.0.0.1', '2025-09-17 15:35:22', '2025-09-17 15:35:57'),
(78, 'A250502', 'piqs09120@gmail.com', '285380', '2025-09-17 16:12:15', 1, '127.0.0.1', '2025-09-17 16:02:15', '2025-09-17 16:02:42'),
(79, 'S250501', 'piqs09120@gmail.com', '752868', '2025-09-17 16:29:40', 1, '127.0.0.1', '2025-09-17 16:19:40', '2025-09-17 16:20:00'),
(80, 'A250502', 'piqs09120@gmail.com', '835659', '2025-09-17 16:40:12', 1, '127.0.0.1', '2025-09-17 16:30:12', '2025-09-17 16:30:28'),
(81, 'A250502', 'piqs09120@gmail.com', '918935', '2025-09-17 19:52:46', 1, '127.0.0.1', '2025-09-17 19:42:46', '2025-09-17 19:43:01'),
(82, 'A250502', 'piqs09120@gmail.com', '023612', '2025-09-18 02:02:05', 1, '127.0.0.1', '2025-09-18 01:52:05', '2025-09-18 01:52:23'),
(83, 'A250502', 'piqs09120@gmail.com', '747551', '2025-10-08 10:57:01', 1, '127.0.0.1', '2025-10-08 10:47:01', '2025-10-08 10:47:27'),
(84, 'A250502', 'piqs09120@gmail.com', '987939', '2025-10-09 03:21:58', 1, '127.0.0.1', '2025-10-09 03:11:58', '2025-10-09 03:12:27'),
(85, 'A250502', 'piqs09120@gmail.com', '955103', '2025-10-12 10:33:54', 1, '127.0.0.1', '2025-10-12 10:23:54', '2025-10-12 10:24:23'),
(86, 'A250502', 'piqs09120@gmail.com', '263107', '2025-10-12 10:34:23', 1, '127.0.0.1', '2025-10-12 10:24:23', '2025-10-12 10:27:48'),
(87, 'L250503', 'alfredpasinag6@gmail.com', '395632', '2025-10-12 10:36:26', 0, '127.0.0.1', '2025-10-12 10:26:26', '2025-10-12 10:26:26'),
(88, 'A250502', 'piqs09120@gmail.com', '744389', '2025-10-12 10:37:48', 1, '127.0.0.1', '2025-10-12 10:27:48', '2025-10-12 10:28:12'),
(89, 'A250502', 'piqs09120@gmail.com', '376370', '2025-10-12 10:38:12', 1, '127.0.0.1', '2025-10-12 10:28:12', '2025-10-12 10:52:37'),
(90, 'A250502', 'piqs09120@gmail.com', '226685', '2025-10-12 11:02:37', 1, '127.0.0.1', '2025-10-12 10:52:37', '2025-10-12 11:01:01'),
(91, 'A250502', 'piqs09120@gmail.com', '666468', '2025-10-12 11:11:01', 1, '127.0.0.1', '2025-10-12 11:01:01', '2025-10-12 11:21:30'),
(92, 'A250502', 'piqs09120@gmail.com', '556036', '2025-10-12 11:31:30', 1, '127.0.0.1', '2025-10-12 11:21:30', '2025-10-12 11:22:12'),
(93, 'A250502', 'piqs09120@gmail.com', '000976', '2025-10-12 11:32:12', 1, '127.0.0.1', '2025-10-12 11:22:12', '2025-10-12 11:22:54'),
(94, 'A250502', 'piqs09120@gmail.com', '058217', '2025-10-12 11:32:54', 1, '127.0.0.1', '2025-10-12 11:22:54', '2025-10-12 12:03:39'),
(95, 'A250502', 'piqs09120@gmail.com', '024445', '2025-10-12 12:13:39', 1, '127.0.0.1', '2025-10-12 12:03:39', '2025-10-12 12:35:33'),
(96, 'A250502', 'piqs09120@gmail.com', '767046', '2025-10-12 12:45:33', 1, '127.0.0.1', '2025-10-12 12:35:33', '2025-10-12 15:44:28'),
(97, 'S250501', 'piqs09120@gmail.com', '094117', '2025-10-12 15:53:11', 1, '127.0.0.1', '2025-10-12 15:43:11', '2025-10-12 15:43:17'),
(98, 'A250502', 'piqs09120@gmail.com', '132299', '2025-10-12 15:54:28', 1, '127.0.0.1', '2025-10-12 15:44:28', '2025-10-12 15:46:24'),
(99, 'S250501', 'piqs09120@gmail.com', '347673', '2025-10-12 15:57:37', 1, '127.0.0.1', '2025-10-12 15:47:37', '2025-10-12 15:47:37'),
(100, 'A250502', 'piqs09120@gmail.com', '174254', '2025-10-12 15:59:49', 1, '127.0.0.1', '2025-10-12 15:49:49', '2025-10-12 15:50:11'),
(101, 'A250502', 'piqs09120@gmail.com', '271483', '2025-10-18 10:58:43', 1, '127.0.0.1', '2025-10-18 10:48:43', '2025-10-18 10:50:26'),
(102, 'A250502', 'piqs09120@gmail.com', '606377', '2025-10-19 09:17:26', 1, '127.0.0.1', '2025-10-19 09:07:26', '2025-10-19 09:07:58'),
(103, 'A250502', 'piqs09120@gmail.com', '789933', '2025-10-20 04:47:41', 1, '127.0.0.1', '2025-10-20 04:37:41', '2025-10-20 04:38:10'),
(104, 'A250502', 'piqs09120@gmail.com', '084962', '2025-10-20 14:41:36', 1, '127.0.0.1', '2025-10-20 14:31:36', '2025-10-20 14:31:52'),
(105, 'A250502', 'piqs09120@gmail.com', '389064', '2025-10-22 06:23:47', 1, '127.0.0.1', '2025-10-22 06:13:47', '2025-10-22 06:14:13'),
(106, 'A250502', 'piqs09120@gmail.com', '763770', '2025-10-22 06:28:43', 1, '127.0.0.1', '2025-10-22 06:18:43', '2025-10-22 06:27:11'),
(107, 'A250502', 'piqs09120@gmail.com', '021029', '2025-10-22 06:37:11', 1, '127.0.0.1', '2025-10-22 06:27:11', '2025-10-22 06:35:17'),
(108, 'A250502', 'piqs09120@gmail.com', '504317', '2025-10-22 06:45:17', 1, '127.0.0.1', '2025-10-22 06:35:17', '2025-10-22 06:35:37'),
(109, 'A250502', 'piqs09120@gmail.com', '100622', '2025-10-22 06:46:22', 1, '127.0.0.1', '2025-10-22 06:36:22', '2025-10-22 06:41:55'),
(110, 'A250502', 'piqs09120@gmail.com', '725712', '2025-10-22 06:51:55', 1, '127.0.0.1', '2025-10-22 06:41:55', '2025-10-22 06:45:27'),
(111, 'A250502', 'piqs09120@gmail.com', '146166', '2025-10-22 06:55:28', 1, '127.0.0.1', '2025-10-22 06:45:28', '2025-10-22 06:46:25'),
(112, 'A250502', 'piqs09120@gmail.com', '928848', '2025-10-22 06:56:25', 1, '127.0.0.1', '2025-10-22 06:46:25', '2025-10-22 06:46:59'),
(113, 'A250502', 'piqs09120@gmail.com', '622646', '2025-10-22 06:57:20', 1, '127.0.0.1', '2025-10-22 06:47:20', '2025-10-22 06:54:39'),
(114, 'A250502', 'piqs09120@gmail.com', '619617', '2025-10-22 07:04:59', 1, '127.0.0.1', '2025-10-22 06:54:59', '2025-10-22 06:59:30'),
(115, 'A250502', 'piqs09120@gmail.com', '368443', '2025-10-22 07:09:30', 1, '127.0.0.1', '2025-10-22 06:59:30', '2025-10-22 07:03:12'),
(116, 'A250502', 'piqs09120@gmail.com', '272061', '2025-10-22 07:13:12', 1, '127.0.0.1', '2025-10-22 07:03:12', '2025-10-22 07:04:12'),
(117, 'A250502', 'piqs09120@gmail.com', '556210', '2025-10-22 07:55:36', 1, '127.0.0.1', '2025-10-22 07:45:36', '2025-10-22 08:25:40'),
(118, 'A250502', 'piqs09120@gmail.com', '593536', '2025-10-22 08:35:40', 1, '127.0.0.1', '2025-10-22 08:25:40', '2025-10-22 08:26:01'),
(119, 'A250502', 'piqs09120@gmail.com', '759131', '2025-10-22 19:29:34', 1, '127.0.0.1', '2025-10-22 19:19:34', '2025-10-22 19:19:57'),
(120, 'A250502', 'piqs09120@gmail.com', '643062', '2025-10-23 15:00:47', 1, '127.0.0.1', '2025-10-23 14:50:47', '2025-10-23 14:51:22'),
(121, 'A250502', 'piqs09120@gmail.com', '160349', '2025-10-24 07:53:40', 1, '127.0.0.1', '2025-10-24 07:43:40', '2025-10-24 07:43:58'),
(122, 'A250502', 'piqs09120@gmail.com', '872419', '2025-10-24 09:44:09', 1, '127.0.0.1', '2025-10-24 09:34:09', '2025-10-24 09:34:51'),
(123, 'A250502', 'piqs09120@gmail.com', '849504', '2025-10-26 06:29:46', 1, '127.0.0.1', '2025-10-26 06:19:46', '2025-10-26 06:20:04'),
(124, 'A250502', 'piqs09120@gmail.com', '679154', '2025-10-26 06:30:04', 1, '127.0.0.1', '2025-10-26 06:20:04', '2025-10-26 06:27:07'),
(125, 'TEST123', 'test@example.com', '916544', '2025-10-26 06:35:21', 0, '127.0.0.1', '2025-10-26 06:25:21', '2025-10-26 06:25:21'),
(126, 'S250501', 'piqs09120@gmail.com', '662035', '2025-10-26 06:35:29', 1, '127.0.0.1', '2025-10-26 06:25:29', '2025-11-29 10:56:10'),
(127, 'A250502', 'piqs09120@gmail.com', '213715', '2025-10-26 06:37:07', 1, '127.0.0.1', '2025-10-26 06:27:07', '2025-10-26 06:27:30'),
(128, 'A250502', 'piqs09120@gmail.com', '976283', '2025-10-27 07:34:44', 1, '127.0.0.1', '2025-10-27 07:24:44', '2025-10-27 07:25:01'),
(129, 'A250502', 'piqs09120@gmail.com', '193388', '2025-10-27 13:16:36', 1, '127.0.0.1', '2025-10-27 13:06:36', '2025-10-27 13:07:06'),
(130, 'A250502', 'piqs09120@gmail.com', '329500', '2025-10-27 16:10:50', 1, '127.0.0.1', '2025-10-27 16:00:50', '2025-10-27 16:01:23'),
(131, 'A250502', 'piqs09120@gmail.com', '017963', '2025-10-27 16:13:34', 1, '127.0.0.1', '2025-10-27 16:03:34', '2025-10-27 16:16:38'),
(132, 'A250502', 'piqs09120@gmail.com', '741712', '2025-10-27 16:26:38', 1, '127.0.0.1', '2025-10-27 16:16:38', '2025-10-27 16:21:54'),
(133, 'A250502', 'piqs09120@gmail.com', '753981', '2025-10-27 16:31:54', 1, '127.0.0.1', '2025-10-27 16:21:54', '2025-10-27 16:24:46'),
(134, 'A250502', 'piqs09120@gmail.com', '664614', '2025-10-27 16:34:46', 1, '127.0.0.1', '2025-10-27 16:24:46', '2025-10-27 16:30:11'),
(135, 'A250502', 'piqs09120@gmail.com', '688453', '2025-10-27 16:40:11', 1, '127.0.0.1', '2025-10-27 16:30:11', '2025-10-27 16:30:36'),
(136, 'A250502', 'piqs09120@gmail.com', '163606', '2025-10-27 16:42:07', 1, '127.0.0.1', '2025-10-27 16:32:07', '2025-10-27 16:33:16'),
(137, 'A250502', 'piqs09120@gmail.com', '953036', '2025-10-27 17:33:56', 1, '127.0.0.1', '2025-10-27 17:23:56', '2025-10-27 17:24:17'),
(138, 'A250502', 'piqs09120@gmail.com', '627829', '2025-10-28 13:46:33', 1, '127.0.0.1', '2025-10-28 13:36:33', '2025-10-28 13:36:53'),
(139, 'A250502', 'piqs09120@gmail.com', '900626', '2025-11-01 08:32:53', 1, '127.0.0.1', '2025-11-01 08:22:53', '2025-11-01 08:23:14'),
(140, 'A250502', 'piqs09120@gmail.com', '681914', '2025-11-02 01:44:58', 1, '127.0.0.1', '2025-11-02 01:34:58', '2025-11-02 01:35:32'),
(141, 'A250502', 'piqs09120@gmail.com', '946934', '2025-11-04 09:24:07', 1, '127.0.0.1', '2025-11-04 09:14:07', '2025-11-04 09:14:35'),
(142, 'A250502', 'piqs09120@gmail.com', '336085', '2025-11-05 13:56:50', 1, '127.0.0.1', '2025-11-05 13:46:50', '2025-11-05 13:47:12'),
(143, 'A250502', 'piqs09120@gmail.com', '805591', '2025-11-06 07:29:54', 1, '127.0.0.1', '2025-11-06 07:19:54', '2025-11-06 07:20:18'),
(144, 'A250502', 'piqs09120@gmail.com', '617426', '2025-11-06 10:43:24', 1, '127.0.0.1', '2025-11-06 10:33:24', '2025-11-06 10:33:49'),
(145, 'A250502', 'piqs09120@gmail.com', '043538', '2025-11-07 06:30:14', 1, '127.0.0.1', '2025-11-07 06:20:14', '2025-11-07 06:20:38'),
(146, 'A250502', 'piqs09120@gmail.com', '666894', '2025-11-07 17:19:06', 1, '127.0.0.1', '2025-11-07 17:09:06', '2025-11-07 17:09:26'),
(147, 'A250502', 'piqs09120@gmail.com', '772213', '2025-11-08 07:40:56', 1, '127.0.0.1', '2025-11-08 07:30:56', '2025-11-08 07:31:20'),
(148, 'A250502', 'piqs09120@gmail.com', '729871', '2025-11-09 05:16:45', 1, '127.0.0.1', '2025-11-09 05:06:45', '2025-11-09 05:07:07'),
(149, 'A250502', 'piqs09120@gmail.com', '730966', '2025-11-09 14:00:31', 1, '127.0.0.1', '2025-11-09 13:50:31', '2025-11-09 13:50:52'),
(150, 'A250502', 'piqs09120@gmail.com', '950337', '2025-11-10 08:31:35', 1, '127.0.0.1', '2025-11-10 08:21:35', '2025-11-10 08:21:51'),
(151, 'A250502', 'piqs09120@gmail.com', '149929', '2025-11-11 13:35:46', 1, '127.0.0.1', '2025-11-11 13:25:46', '2025-11-11 14:00:35'),
(152, 'A250502', 'piqs09120@gmail.com', '280445', '2025-11-11 14:10:35', 1, '127.0.0.1', '2025-11-11 14:00:35', '2025-11-11 19:21:24'),
(153, 'A250502', 'piqs09120@gmail.com', '276814', '2025-11-11 19:31:24', 1, '127.0.0.1', '2025-11-11 19:21:24', '2025-11-11 19:21:49'),
(154, 'A250502', 'piqs09120@gmail.com', '356584', '2025-11-11 19:49:09', 1, '127.0.0.1', '2025-11-11 19:39:09', '2025-11-11 19:39:25'),
(155, 'A250502', 'piqs09120@gmail.com', '451487', '2025-11-12 04:56:36', 1, '127.0.0.1', '2025-11-12 04:46:36', '2025-11-12 04:47:10'),
(156, 'A250502', 'piqs09120@gmail.com', '880721', '2025-11-12 06:47:17', 1, '127.0.0.1', '2025-11-12 06:37:17', '2025-11-12 06:37:37'),
(157, 'A250502', 'piqs09120@gmail.com', '405584', '2025-11-12 08:32:32', 1, '127.0.0.1', '2025-11-12 08:22:32', '2025-11-12 08:22:52'),
(158, 'A250502', 'piqs09120@gmail.com', '437063', '2025-11-13 08:50:16', 1, '127.0.0.1', '2025-11-13 08:40:16', '2025-11-13 08:40:39'),
(159, 'A250502', 'piqs09120@gmail.com', '000997', '2025-11-14 04:26:27', 1, '127.0.0.1', '2025-11-14 04:16:27', '2025-11-14 04:16:47'),
(160, 'A250502', 'piqs09120@gmail.com', '685824', '2025-11-14 09:32:55', 1, '127.0.0.1', '2025-11-14 09:22:55', '2025-11-14 09:23:26'),
(161, 'A250502', 'piqs09120@gmail.com', '639329', '2025-11-15 06:18:06', 1, '127.0.0.1', '2025-11-15 06:08:06', '2025-11-15 06:08:35'),
(162, 'A250502', 'piqs09120@gmail.com', '475771', '2025-11-15 18:09:07', 1, '127.0.0.1', '2025-11-15 17:59:07', '2025-11-15 17:59:23'),
(163, 'A250502', 'piqs09120@gmail.com', '531278', '2025-11-16 02:13:54', 1, '127.0.0.1', '2025-11-16 02:03:54', '2025-11-16 02:04:14'),
(164, 'A250502', 'piqs09120@gmail.com', '034047', '2025-11-16 05:52:46', 1, '127.0.0.1', '2025-11-16 05:42:46', '2025-11-16 05:43:07'),
(165, 'A250502', 'piqs09120@gmail.com', '436986', '2025-11-16 06:22:49', 1, '127.0.0.1', '2025-11-16 06:12:49', '2025-11-16 06:13:10'),
(166, 'A250502', 'piqs09120@gmail.com', '397501', '2025-11-16 15:38:53', 1, '127.0.0.1', '2025-11-16 15:28:53', '2025-11-16 15:29:12'),
(167, 'A250502', 'piqs09120@gmail.com', '471598', '2025-11-17 04:27:14', 1, '127.0.0.1', '2025-11-17 04:17:14', '2025-11-17 04:17:32'),
(168, 'A250502', 'piqs09120@gmail.com', '087946', '2025-11-17 05:19:37', 1, '127.0.0.1', '2025-11-17 05:09:37', '2025-11-17 05:09:56'),
(169, 'A250502', 'piqs09120@gmail.com', '659020', '2025-11-17 15:49:29', 1, '127.0.0.1', '2025-11-17 15:39:29', '2025-11-18 10:58:56'),
(170, 'A250502', 'piqs09120@gmail.com', '120174', '2025-11-18 11:08:56', 1, '127.0.0.1', '2025-11-18 10:58:56', '2025-11-18 10:59:23'),
(171, 'A250502', 'piqs09120@gmail.com', '248735', '2025-11-19 01:12:58', 1, '127.0.0.1', '2025-11-19 01:02:58', '2025-11-19 01:03:19'),
(172, 'A250502', 'piqs09120@gmail.com', '958671', '2025-11-20 03:49:38', 1, '127.0.0.1', '2025-11-20 03:39:38', '2025-11-20 05:27:48'),
(173, 'A250502', 'piqs09120@gmail.com', '597696', '2025-11-20 05:37:48', 1, '127.0.0.1', '2025-11-20 05:27:48', '2025-11-20 05:28:48'),
(174, 'A250502', 'piqs09120@gmail.com', '444007', '2025-11-20 05:38:48', 1, '127.0.0.1', '2025-11-20 05:28:48', '2025-11-20 05:29:09'),
(175, 'A250502', 'piqs09120@gmail.com', '976450', '2025-11-20 14:07:10', 1, '127.0.0.1', '2025-11-20 13:57:10', '2025-11-20 13:57:37'),
(176, 'A250502', 'piqs09120@gmail.com', '400275', '2025-11-20 15:22:40', 1, '127.0.0.1', '2025-11-20 15:12:40', '2025-11-20 15:13:23'),
(177, 'A250502', 'piqs09120@gmail.com', '953504', '2025-11-20 16:08:07', 1, '127.0.0.1', '2025-11-20 15:58:07', '2025-11-20 15:58:31'),
(178, 'A250502', 'piqs09120@gmail.com', '962510', '2025-11-20 16:19:31', 1, '127.0.0.1', '2025-11-20 16:09:31', '2025-11-20 16:09:55'),
(179, 'A250502', 'piqs09120@gmail.com', '294561', '2025-11-21 02:36:51', 1, '127.0.0.1', '2025-11-21 02:26:51', '2025-11-21 02:27:50'),
(180, 'A250502', 'piqs09120@gmail.com', '574211', '2025-11-21 05:00:40', 1, '127.0.0.1', '2025-11-21 04:50:40', '2025-11-21 04:54:04'),
(181, 'A250502', 'piqs09120@gmail.com', '737900', '2025-11-21 05:06:29', 1, '127.0.0.1', '2025-11-21 04:56:29', '2025-11-21 04:56:50'),
(182, 'A250502', 'piqs09120@gmail.com', '723799', '2025-11-21 05:36:40', 1, '127.0.0.1', '2025-11-21 05:26:40', '2025-11-21 05:26:58'),
(183, 'A250502', 'piqs09120@gmail.com', '801386', '2025-11-22 14:44:14', 1, '127.0.0.1', '2025-11-22 14:34:14', '2025-11-22 14:34:36'),
(184, 'A250502', 'piqs09120@gmail.com', '518742', '2025-11-23 16:01:27', 1, '127.0.0.1', '2025-11-23 15:51:27', '2025-11-23 15:51:54'),
(185, 'A250502', 'piqs09120@gmail.com', '691864', '2025-11-23 19:21:14', 1, '127.0.0.1', '2025-11-23 19:11:14', '2025-11-23 19:12:19'),
(186, 'A250502', 'piqs09120@gmail.com', '162115', '2025-11-24 09:28:10', 1, '127.0.0.1', '2025-11-24 09:18:10', '2025-11-24 09:40:27'),
(187, 'A250502', 'piqs09120@gmail.com', '539533', '2025-11-24 09:50:27', 1, '127.0.0.1', '2025-11-24 09:40:27', '2025-11-24 09:43:20'),
(188, 'A250502', 'piqs09120@gmail.com', '323376', '2025-11-24 09:53:20', 1, '127.0.0.1', '2025-11-24 09:43:20', '2025-11-24 09:43:46'),
(189, 'A250502', 'piqs09120@gmail.com', '006475', '2025-11-24 10:33:29', 1, '127.0.0.1', '2025-11-24 10:23:29', '2025-11-24 10:23:50'),
(190, 'A250502', 'piqs09120@gmail.com', '669617', '2025-11-26 03:42:03', 1, '127.0.0.1', '2025-11-26 03:32:03', '2025-11-26 03:34:52'),
(191, 'A250502', 'piqs09120@gmail.com', '055012', '2025-11-26 03:44:52', 1, '127.0.0.1', '2025-11-26 03:34:52', '2025-11-26 03:36:13'),
(192, 'A250502', 'piqs09120@gmail.com', '937370', '2025-11-26 03:46:24', 1, '127.0.0.1', '2025-11-26 03:36:24', '2025-11-26 03:36:45'),
(193, 'A250502', 'piqs09120@gmail.com', '256173', '2025-11-26 08:25:28', 1, '127.0.0.1', '2025-11-26 08:15:28', '2025-11-26 08:15:46'),
(194, 'A250502', 'piqs09120@gmail.com', '440346', '2025-11-26 14:01:39', 1, '127.0.0.1', '2025-11-26 13:51:39', '2025-11-26 13:52:02'),
(195, 'A250502', 'piqs09120@gmail.com', '423114', '2025-11-27 13:14:38', 1, '127.0.0.1', '2025-11-27 13:04:38', '2025-11-27 13:07:04'),
(196, 'A250502', 'piqs09120@gmail.com', '081627', '2025-11-28 14:38:14', 1, '127.0.0.1', '2025-11-28 14:28:14', '2025-11-28 14:29:20'),
(197, 'A250502', 'piqs09120@gmail.com', '322520', '2025-11-28 16:03:59', 1, '127.0.0.1', '2025-11-28 15:53:59', '2025-11-28 15:54:23'),
(198, 'A250502', 'piqs09120@gmail.com', '977196', '2025-11-29 06:00:14', 1, '127.0.0.1', '2025-11-29 05:50:14', '2025-11-29 05:51:14'),
(199, 'S250501', 'piqs09120@gmail.com', '641573', '2025-11-29 11:06:10', 1, '127.0.0.1', '2025-11-29 10:56:10', '2025-11-29 10:56:32'),
(200, 'A250502', 'piqs09120@gmail.com', '633239', '2025-11-29 13:45:02', 1, '127.0.0.1', '2025-11-29 13:35:02', '2025-11-29 13:35:39'),
(201, 'S250501', 'piqs09120@gmail.com', '691330', '2025-11-29 13:46:17', 1, '127.0.0.1', '2025-11-29 13:36:17', '2025-11-29 13:36:31'),
(202, 'A250502', 'piqs09120@gmail.com', '889872', '2025-11-29 17:36:02', 1, '127.0.0.1', '2025-11-29 17:26:02', '2025-11-29 17:26:20'),
(203, 'S250501', 'piqs09120@gmail.com', '848032', '2025-11-29 17:37:15', 1, '127.0.0.1', '2025-11-29 17:27:15', '2025-11-29 17:27:33'),
(204, 'A250502', 'piqs09120@gmail.com', '901778', '2025-11-29 19:05:28', 1, '127.0.0.1', '2025-11-29 18:55:28', '2025-11-29 18:55:49'),
(205, 'A250502', 'piqs09120@gmail.com', '949343', '2025-11-29 21:07:31', 1, '127.0.0.1', '2025-11-29 20:57:31', '2025-11-29 20:58:06'),
(206, 'A250502', 'piqs09120@gmail.com', '529363', '2025-11-30 03:09:43', 1, '127.0.0.1', '2025-11-30 02:59:43', '2025-11-30 03:00:06'),
(207, 'A250502', 'piqs09120@gmail.com', '743445', '2025-11-30 04:15:48', 1, '127.0.0.1', '2025-11-30 04:05:48', '2025-11-30 05:35:28'),
(208, 'S250501', 'piqs09120@gmail.com', '257184', '2025-11-30 04:28:19', 1, '127.0.0.1', '2025-11-30 04:18:19', '2025-11-30 04:18:42'),
(209, 'S250501', 'piqs09120@gmail.com', '110734', '2025-11-30 04:36:35', 1, '127.0.0.1', '2025-11-30 04:26:35', '2025-11-30 04:27:06'),
(210, 'A250502', 'piqs09120@gmail.com', '831564', '2025-11-30 05:45:28', 1, '127.0.0.1', '2025-11-30 05:35:28', '2025-11-30 05:35:46'),
(211, 'S250501', 'piqs09120@gmail.com', '292631', '2025-11-30 05:46:25', 1, '127.0.0.1', '2025-11-30 05:36:25', '2025-11-30 05:36:39'),
(212, 'A250502', 'piqs09120@gmail.com', '633565', '2025-11-30 05:48:33', 1, '127.0.0.1', '2025-11-30 05:38:33', '2025-11-30 05:38:48'),
(213, 'S250501', 'piqs09120@gmail.com', '525938', '2025-11-30 05:57:23', 1, '127.0.0.1', '2025-11-30 05:47:23', '2025-11-30 05:47:38'),
(214, 'A250502', 'piqs09120@gmail.com', '686471', '2025-11-30 13:53:56', 1, '127.0.0.1', '2025-11-30 13:43:56', '2025-11-30 13:44:19'),
(215, 'S250501', 'piqs09120@gmail.com', '870587', '2025-11-30 14:08:04', 1, '127.0.0.1', '2025-11-30 13:58:04', '2025-11-30 13:58:43'),
(216, 'A250502', 'piqs09120@gmail.com', '526050', '2025-11-30 16:49:19', 1, '127.0.0.1', '2025-11-30 16:39:19', '2025-11-30 16:41:21'),
(217, 'S250501', 'piqs09120@gmail.com', '510979', '2025-11-30 16:51:54', 1, '127.0.0.1', '2025-11-30 16:41:54', '2025-11-30 16:42:10'),
(218, 'A250502', 'piqs09120@gmail.com', '675116', '2025-12-01 07:52:55', 1, '127.0.0.1', '2025-12-01 07:42:55', '2025-12-01 07:43:32'),
(219, 'S250501', 'piqs09120@gmail.com', '102843', '2025-12-04 12:10:10', 1, '127.0.0.1', '2025-12-04 12:00:10', '2025-12-04 12:00:51'),
(220, 'A250502', 'piqs09120@gmail.com', '851955', '2025-12-04 13:36:42', 1, '127.0.0.1', '2025-12-04 13:26:42', '2025-12-04 13:27:10'),
(221, 'A250502', 'petrasmichael06@gmail.com', '885885', '2026-01-08 12:45:23', 1, '127.0.0.1', '2026-01-08 12:45:01', '2026-01-08 12:45:23'),
(222, 'A250502', 'petrasmichael06@gmail.com', '303788', '2026-01-08 13:08:38', 1, '127.0.0.1', '2026-01-08 13:08:21', '2026-01-08 13:08:38'),
(223, 'A250502', 'petrasmichael06@gmail.com', '198566', '2026-01-08 23:03:23', 1, '127.0.0.1', '2026-01-08 23:02:30', '2026-01-08 23:03:23'),
(224, 'A250502', 'petrasmichael06@gmail.com', '420728', '2026-01-12 01:14:04', 1, '175.158.203.168', '2026-01-12 01:13:31', '2026-01-12 01:14:04'),
(225, 'A250502', 'petrasmichael06@gmail.com', '110636', '2026-01-12 01:21:25', 1, '175.158.203.155', '2026-01-12 01:20:43', '2026-01-12 01:21:25'),
(226, 'A250502', 'petrasmichael06@gmail.com', '387777', '2026-01-12 01:26:02', 1, '175.176.29.177', '2026-01-12 01:25:43', '2026-01-12 01:26:02'),
(227, 'A250502', 'petrasmichael06@gmail.com', '048413', '2026-01-12 01:45:43', 1, '136.158.3.213', '2026-01-12 01:45:29', '2026-01-12 01:45:43'),
(228, 'A250502', 'petrasmichael06@gmail.com', '225428', '2026-01-12 03:23:13', 1, '175.176.29.177', '2026-01-12 02:53:40', '2026-01-12 03:23:13'),
(229, 'A250502', 'petrasmichael06@gmail.com', '521841', '2026-01-12 03:23:48', 1, '175.158.203.155', '2026-01-12 03:23:13', '2026-01-12 03:23:48'),
(230, 'A250502', 'petrasmichael06@gmail.com', '229332', '2026-01-12 05:21:22', 1, '175.158.203.138', '2026-01-12 05:21:05', '2026-01-12 05:21:22'),
(231, 'A250502', 'piqs09120@gmail.com', '730272', '2026-01-21 17:02:20', 1, '127.0.0.1', '2026-01-21 17:01:58', '2026-01-21 17:02:20'),
(232, 'A250502', 'piqs09120@gmail.com', '950743', '2026-01-22 03:28:19', 1, '127.0.0.1', '2026-01-22 03:27:57', '2026-01-22 03:28:19'),
(233, 'A250502', 'piqs09120@gmail.com', '924264', '2026-01-23 04:33:48', 1, '127.0.0.1', '2026-01-23 04:33:01', '2026-01-23 04:33:48'),
(234, 'A250502', 'piqs09120@gmail.com', '094957', '2026-01-23 05:30:09', 1, '127.0.0.1', '2026-01-23 05:29:42', '2026-01-23 05:30:09'),
(235, 'A250502', 'piqs09120@gmail.com', '165602', '2026-01-23 15:08:00', 1, '127.0.0.1', '2026-01-23 15:07:41', '2026-01-23 15:08:00'),
(236, 'A250502', 'michaelpetras123@gmail.com', '645611', '2026-01-23 17:29:50', 1, '127.0.0.1', '2026-01-23 17:29:05', '2026-01-23 17:29:50'),
(237, 'A250502', 'michaelpetras123@gmail.com', '782427', '2026-01-23 20:42:26', 1, '127.0.0.1', '2026-01-23 20:41:57', '2026-01-23 20:42:26'),
(238, 'A250502', 'michaelpetras123@gmail.com', '062434', '2026-01-23 20:52:56', 1, '127.0.0.1', '2026-01-23 20:52:38', '2026-01-23 20:52:56'),
(239, 'A250502', 'michaelpetras123@gmail.com', '544593', '2026-01-23 23:08:04', 1, '127.0.0.1', '2026-01-23 23:07:41', '2026-01-23 23:08:04'),
(240, 'A250502', 'michaelpetras123@gmail.com', '870803', '2026-01-24 00:33:46', 1, '127.0.0.1', '2026-01-24 00:33:27', '2026-01-24 00:33:46'),
(241, 'A250502', 'michaelpetras123@gmail.com', '290437', '2026-01-24 00:54:40', 1, '127.0.0.1', '2026-01-24 00:54:16', '2026-01-24 00:54:40'),
(242, 'A250502', 'michaelpetras123@gmail.com', '770815', '2026-01-24 01:09:43', 1, '127.0.0.1', '2026-01-24 01:08:50', '2026-01-24 01:09:43'),
(243, 'A250502', 'michaelpetras123@gmail.com', '196344', '2026-01-24 01:13:13', 1, '127.0.0.1', '2026-01-24 01:13:00', '2026-01-24 01:13:13'),
(244, 'A250502', 'michaelpetras123@gmail.com', '129271', '2026-01-24 01:21:49', 1, '127.0.0.1', '2026-01-24 01:21:10', '2026-01-24 01:21:49'),
(245, 'A250502', 'michaelpetras123@gmail.com', '992645', '2026-01-24 01:25:52', 1, '127.0.0.1', '2026-01-24 01:25:20', '2026-01-24 01:25:52'),
(246, 'A250502', 'michaelpetras123@gmail.com', '190387', '2026-01-24 08:58:32', 1, '127.0.0.1', '2026-01-24 08:57:49', '2026-01-24 08:58:32'),
(247, 'A250502', 'michaelpetras123@gmail.com', '113885', '2026-01-24 11:30:36', 1, '127.0.0.1', '2026-01-24 11:30:15', '2026-01-24 11:30:36'),
(248, 'A250502', 'michaelpetras123@gmail.com', '698911', '2026-01-26 11:46:30', 1, '127.0.0.1', '2026-01-26 11:46:07', '2026-01-26 11:46:30');

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
(1, 'App\\Models\\DeptAccount', 2, 'API Token - 2026-01-12 00:05:33', '5f052a431e72ed427fc66a5444fed14094fdf8ae15e470d5d3c2f9895d208bc6', '[\"*\"]', '2026-01-11 16:06:01', NULL, '2026-01-11 16:05:33', '2026-01-11 16:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `slug`, `title`, `content`, `version`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'terms', 'General Terms & Conditions', '<div class=\"prose max-w-none\">\r\n                    <h2>General Terms & Conditions</h2>\r\n                    <p>Welcome to Soliera Hotel. By accessing and using our services, you agree to be bound by the following terms and conditions.</p>\r\n                    \r\n                    <h3>1. Acceptance of Terms</h3>\r\n                    <p>By using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</p>\r\n                    \r\n                    <h3>2. Services</h3>\r\n                    <p>Soliera Hotel provides accommodation, dining, and related hospitality services. All services are subject to availability and applicable laws.</p>\r\n                    \r\n                    <h3>3. Reservations and Cancellations</h3>\r\n                    <p>Reservations are subject to our cancellation policy. Please review cancellation terms at the time of booking.</p>\r\n                    \r\n                    <h3>4. Guest Responsibilities</h3>\r\n                    <p>Guests are responsible for their conduct and any damages to hotel property during their stay.</p>\r\n                    \r\n                    <h3>5. Limitation of Liability</h3>\r\n                    <p>Soliera Hotel shall not be liable for any indirect, incidental, or consequential damages arising from the use of our services.</p>\r\n                    \r\n                    <h3>6. Governing Law</h3>\r\n                    <p>These terms are governed by the laws of the Philippines.</p>\r\n                    \r\n                    <p><strong>Last Updated:</strong> November 10, 2025</p>\r\n                </div>', 1, 1, '2025-11-11 19:19:17', '2025-11-11 19:19:17'),
(2, 'privacy', 'Privacy Policy', '<div class=\"prose max-w-none\">\r\n                    <h2>Privacy Policy</h2>\r\n                    <p>Soliera Hotel is committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your personal information.</p>\r\n                    \r\n                    <h3>1. Information We Collect</h3>\r\n                    <p>We collect information that you provide directly to us, including:</p>\r\n                    <ul>\r\n                        <li>Name and contact information</li>\r\n                        <li>Payment information</li>\r\n                        <li>Identification documents</li>\r\n                        <li>Preferences and special requests</li>\r\n                    </ul>\r\n                    \r\n                    <h3>2. How We Use Your Information</h3>\r\n                    <p>We use your information to:</p>\r\n                    <ul>\r\n                        <li>Process reservations and bookings</li>\r\n                        <li>Provide customer service</li>\r\n                        <li>Send important updates and communications</li>\r\n                        <li>Comply with legal obligations</li>\r\n                    </ul>\r\n                    \r\n                    <h3>3. Information Sharing</h3>\r\n                    <p>We do not sell your personal information. We may share information with:</p>\r\n                    <ul>\r\n                        <li>Service providers who assist in our operations</li>\r\n                        <li>Legal authorities when required by law</li>\r\n                    </ul>\r\n                    \r\n                    <h3>4. Data Security</h3>\r\n                    <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or disclosure.</p>\r\n                    \r\n                    <h3>5. Your Rights</h3>\r\n                    <p>You have the right to access, correct, or delete your personal information. Please contact us to exercise these rights.</p>\r\n                    \r\n                    <h3>6. Contact Us</h3>\r\n                    <p>If you have questions about this Privacy Policy, please contact our Data Protection Officer.</p>\r\n                    \r\n                    <p><strong>Last Updated:</strong> November 10, 2025</p>\r\n                </div>', 1, 1, '2025-11-11 19:19:17', '2025-11-11 19:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `policy_acknowledgements`
--

CREATE TABLE `policy_acknowledgements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `required_by` date DEFAULT NULL,
  `acknowledged_at` timestamp NULL DEFAULT NULL,
  `reminder_sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_tasks`
--

CREATE TABLE `reservation_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_reservation_id` bigint(20) UNSIGNED NOT NULL,
  `task_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `assigned_to_module` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `completed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `type`, `status`, `price`, `created_at`, `updated_at`) VALUES
(1, '101', 'Single', 'available', 1200.00, NULL, NULL),
(2, '102', 'Double', 'occupied', 1800.00, NULL, NULL),
(3, '103', 'Suite', 'maintenance', 3500.00, NULL, NULL),
(4, '104', 'Single', 'available', 1200.00, NULL, NULL),
(5, '105', 'Double', 'occupied', 1800.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `show`
--

CREATE TABLE `show` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `employee_id`, `department`, `role`, `profile_picture`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Michael Petras', 'A250502@soliera.local', NULL, 'A250502', 'Administrative', 'Administrator', NULL, '$2y$10$PLQ5LdCL7osXjaiTb11w0OPtcounktNvcqCFLeA0ilt/piFyYCyZK', NULL, '2026-01-08 13:08:38', '2026-01-08 23:03:23'),
(2, 'ern', 'ern@gmail.com', NULL, NULL, NULL, 'user', NULL, '$2y$10$lkn2MzOF7vWslST7ZZjOv.r5EcO21jFPhhw79KKZfQ5MhA1mcI3bm', NULL, '2026-01-23 05:20:48', '2026-01-23 05:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_consents`
--

CREATE TABLE `user_consents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `accepted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_consents`
--

INSERT INTO `user_consents` (`id`, `user_id`, `policy_id`, `version`, `ip_address`, `user_agent`, `accepted_at`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', '2025-11-12 05:36:15', '2025-11-12 05:36:15', '2025-11-12 05:36:15'),
(2, 12, 2, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 OPR/122.0.0.0', '2025-11-12 05:36:15', '2025-11-12 05:36:15', '2025-11-12 05:36:15');

-- --------------------------------------------------------

--
-- Table structure for table `violation_reports`
--

CREATE TABLE `violation_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reporter_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reporter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `case_id` bigint(20) UNSIGNED DEFAULT NULL,
  `violation_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details_encrypted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reported',
  `workflow_stage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workflow_log` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host_employee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facility_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facility_reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bulk_session_id` bigint(20) UNSIGNED DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `expected_time_out` datetime DEFAULT NULL,
  `expected_date_out` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approval_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `pass_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass_validity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pass_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `escort_required` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `special_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_digital_pass` tinyint(1) NOT NULL DEFAULT 0,
  `pass_valid_from` datetime DEFAULT NULL,
  `pass_valid_until` datetime DEFAULT NULL,
  `pass_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `access_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_plate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_exit` tinyint(1) NOT NULL DEFAULT 0,
  `pending_exit_at` datetime DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `scheduled_time` time DEFAULT NULL,
  `expected_duration` int(11) DEFAULT NULL,
  `profile_photo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `rating_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_verified` tinyint(1) NOT NULL DEFAULT 0,
  `id_verified_at` datetime DEFAULT NULL,
  `id_verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `id_verification_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_verification_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_scanned_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `supporting_document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `name`, `email`, `contact`, `phone`, `company`, `purpose`, `department`, `host_employee`, `facility_id`, `facility_reservation_id`, `bulk_session_id`, `time_in`, `time_out`, `expected_time_out`, `expected_date_out`, `arrival_date`, `arrival_time`, `status`, `approval_status`, `pass_type`, `pass_validity`, `pass_id`, `access_level`, `escort_required`, `special_instructions`, `generate_digital_pass`, `pass_valid_from`, `pass_valid_until`, `pass_data`, `access_code`, `id_type`, `id_number`, `id_document_path`, `vehicle_plate`, `pending_exit`, `pending_exit_at`, `scheduled_date`, `scheduled_time`, `expected_duration`, `profile_photo_url`, `rating`, `rating_comment`, `id_verified`, `id_verified_at`, `id_verified_by`, `id_verification_notes`, `id_verification_method`, `id_scanned_data`, `supporting_document`, `created_at`, `updated_at`) VALUES
(7, 'jane', 'jane@gmail.com', '09546564454', NULL, 'none', 'Walk-in Visit', 'core_1', 'jez', NULL, NULL, 3, '2026-01-23 17:01:59', NULL, NULL, NULL, '2026-01-23', '17:01:59', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-HSSWC6WL', 'Standard', 'no', NULL, 0, '2026-01-23 17:01:59', '2026-01-23 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 09:01:59', '2026-01-23 09:01:59'),
(8, 'ben', 'ben@gmaill.com', '098464648449', NULL, 'none', 'Walk-in Visit', 'core_1', 'carl', NULL, NULL, 3, '2026-01-23 17:01:59', NULL, NULL, NULL, '2026-01-23', '17:01:59', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-8CT4XU3V', 'Standard', 'no', NULL, 0, '2026-01-23 17:01:59', '2026-01-23 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 09:01:59', '2026-01-23 09:01:59'),
(9, 'jack froz', 'jack@gmail.com', '095545644465', NULL, 'none', 'Walk-in Visit', 'core_1', 'ted', NULL, NULL, 3, '2026-01-23 17:01:59', NULL, NULL, NULL, '2026-01-23', '17:01:59', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-1YLFS4ZA', 'Standard', 'no', NULL, 0, '2026-01-23 17:01:59', '2026-01-23 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 09:01:59', '2026-01-23 09:01:59'),
(10, 'rock leon', 'rock@gmail.com', '09245642154', NULL, 'consulting', 'Walk-in Visit', 'core_1', 'jake', NULL, NULL, 4, '2026-01-24 00:43:14', NULL, NULL, NULL, '2026-01-24', '00:43:14', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-EFTFQZIJ', 'Standard', 'no', NULL, 0, '2026-01-24 00:43:14', '2026-01-24 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 16:43:14', '2026-01-23 16:43:14'),
(11, 'jake cruz', 'jake@gmail.com', '09124679223', NULL, 'hospital', 'Walk-in Visit', 'core_1', 'jade', NULL, NULL, 4, '2026-01-24 00:43:14', NULL, NULL, NULL, '2026-01-24', '00:43:14', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-WL8NO3VL', 'Standard', 'no', NULL, 0, '2026-01-24 00:43:14', '2026-01-24 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 16:43:14', '2026-01-23 16:43:14'),
(12, 'dave cruz', NULL, NULL, NULL, NULL, 'Walk-in Visit', 'core_1', 'Reception/Staff', NULL, NULL, 4, '2026-01-24 00:43:14', NULL, NULL, NULL, '2026-01-24', '00:43:14', 'active', 'APPROVED', 'Visitor', NULL, 'PASS-NVU3VYIS', 'Standard', 'no', NULL, 0, '2026-01-24 00:43:14', '2026-01-24 23:59:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-23 16:43:14', '2026-01-23 16:43:14'),
(13, 'michael petras', 'michaelpetras123@gmail.com', '09462271060', '09462271060', NULL, 'visit', 'logistic_1', 'agay', NULL, NULL, NULL, NULL, NULL, '2026-01-27 20:18:00', '2026-01-27', '2026-01-25', '08:20:00', 'registered', 'pending', 'visitor', '24_hours', 'PASS-F60290F7', NULL, 'no', NULL, 0, '2026-01-24 08:22:52', '2026-01-27 20:18:00', '{\"pass_id\":\"PASS-F60290F7\",\"visitor_name\":\"michael petras\",\"visitor_id\":13,\"pass_type\":\"visitor\",\"access_level\":null,\"escort_required\":\"no\",\"valid_from\":\"2026-01-24 08:22:52\",\"valid_until\":\"2026-01-27 20:18:00\",\"facility\":\"N\\/A\",\"purpose\":\"visit\",\"special_instructions\":null,\"generated_at\":\"2026-01-24 08:22:52\",\"access_code\":\"530008\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-F60290F7%22%2C%22code%22%3A%22530008%22%7D\",\"profile_photo_url\":null}', '530008', 'passport', NULL, 'id_documents/Q4zDRbmSd6MCAjch3CJHchlufDI9uNbYugjug3da.png', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-24 00:22:52', '2026-01-24 00:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_batches`
--

CREATE TABLE `visitor_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_visitors` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_checkin_logs`
--

CREATE TABLE `visitor_checkin_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitor_id` bigint(20) UNSIGNED NOT NULL,
  `checked_in_by` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitor_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_checkin_logs`
--

INSERT INTO `visitor_checkin_logs` (`id`, `visitor_id`, `checked_in_by`, `action`, `notes`, `visitor_data`, `action_time`, `created_at`, `updated_at`) VALUES
(87, 154, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 154, \"name\": \"gigi\", \"email\": \"piqs09120@gmail.com\", \"phone\": \"091511755772\", \"status\": \"active\", \"company\": \"IT DEPT\", \"contact\": \"091511755772\", \"id_type\": \"Passport\", \"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"time_in\": \"2025-09-17T22:29:30.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"asdf\", \"pass_data\": {\"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-B9C79626\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-09-18 06:29:04\", \"visitor_id\": 154, \"valid_until\": \"2025-09-30 18:32:00\", \"access_level\": null, \"generated_at\": \"2025-09-18 06:29:30\", \"visitor_name\": \"gigi\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-09-17T22:29:04.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-09-17T22:29:30.000000Z\", \"access_code\": null, \"facility_id\": null, \"access_level\": null, \"arrival_date\": \"2025-09-26T16:00:00.000000Z\", \"arrival_time\": \"2025-09-17T22:28:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"ern\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4353453\", \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"insurance_notes\": null, \"pass_valid_from\": \"2025-09-17T22:29:04.000000Z\", \"pending_exit_at\": null, \"pass_valid_until\": \"2025-09-30T10:32:00.000000Z\", \"expected_date_out\": \"2025-09-29T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-09-30T10:32:00.000000Z\", \"insurance_provider\": null, \"special_instructions\": null, \"generate_digital_pass\": 0, \"insurance_expiry_date\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null}', '2025-09-17 22:29:30', '2025-09-17 22:29:30', '2025-09-17 22:29:30'),
(88, 154, 12, 'checkout', 'Visitor checked out', '{\"id\": 154, \"name\": \"gigi\", \"email\": \"piqs09120@gmail.com\", \"phone\": \"091511755772\", \"status\": \"checked_out\", \"company\": \"IT DEPT\", \"contact\": \"091511755772\", \"id_type\": \"Passport\", \"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"time_in\": \"2025-09-17T22:29:30.000000Z\", \"time_out\": \"2025-09-17T22:32:22.000000Z\", \"id_number\": \"asdf\", \"pass_data\": {\"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-B9C79626\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-09-18 06:29:04\", \"visitor_id\": 154, \"valid_until\": \"2025-09-30 18:32:00\", \"access_level\": null, \"generated_at\": \"2025-09-18 06:29:30\", \"visitor_name\": \"gigi\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-09-17T22:29:04.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-09-17T22:32:22.000000Z\", \"access_code\": null, \"facility_id\": null, \"access_level\": null, \"arrival_date\": \"2025-09-26T16:00:00.000000Z\", \"arrival_time\": \"2025-09-17T22:28:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"ern\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4353453\", \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"insurance_notes\": null, \"pass_valid_from\": \"2025-09-17T22:29:04.000000Z\", \"pending_exit_at\": null, \"pass_valid_until\": \"2025-09-30T10:32:00.000000Z\", \"expected_date_out\": \"2025-09-29T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-09-30T10:32:00.000000Z\", \"insurance_provider\": null, \"special_instructions\": null, \"generate_digital_pass\": 0, \"insurance_expiry_date\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null}', '2025-09-17 22:32:22', '2025-09-17 22:32:22', '2025-09-17 22:32:22'),
(89, 154, 12, 'checkout', 'Visitor checked out', '{\"id\": 154, \"name\": \"gigi\", \"email\": \"piqs09120@gmail.com\", \"phone\": \"091511755772\", \"status\": \"checked_out\", \"company\": \"IT DEPT\", \"contact\": \"091511755772\", \"id_type\": \"Passport\", \"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"time_in\": \"2025-09-17T22:29:30.000000Z\", \"time_out\": \"2025-09-17T22:32:29.000000Z\", \"id_number\": \"asdf\", \"pass_data\": {\"pass_id\": \"PASS-B9C79626\", \"purpose\": \"visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-B9C79626\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-09-18 06:29:04\", \"visitor_id\": 154, \"valid_until\": \"2025-09-30 18:32:00\", \"access_level\": null, \"generated_at\": \"2025-09-18 06:29:30\", \"visitor_name\": \"gigi\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-09-17T22:29:04.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-09-17T22:32:29.000000Z\", \"access_code\": null, \"facility_id\": null, \"access_level\": null, \"arrival_date\": \"2025-09-26T16:00:00.000000Z\", \"arrival_time\": \"2025-09-17T22:28:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"ern\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4353453\", \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"insurance_notes\": null, \"pass_valid_from\": \"2025-09-17T22:29:04.000000Z\", \"pending_exit_at\": null, \"pass_valid_until\": \"2025-09-30T10:32:00.000000Z\", \"expected_date_out\": \"2025-09-29T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-09-30T10:32:00.000000Z\", \"insurance_provider\": null, \"special_instructions\": null, \"generate_digital_pass\": 0, \"insurance_expiry_date\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null}', '2025-09-17 22:32:29', '2025-09-17 22:32:29', '2025-09-17 22:32:29'),
(91, 165, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 165, \"name\": \"ryan\", \"email\": \"piqs09120@gmail.com\", \"phone\": \"0956565186\", \"status\": \"active\", \"company\": \"IT company\", \"contact\": \"0956565186\", \"id_type\": \"Driver\'s License\", \"pass_id\": \"PASS-3FD178BD\", \"purpose\": \"visit\", \"time_in\": \"2025-09-18T02:01:37.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"6645445\", \"pass_data\": {\"pass_id\": \"PASS-3FD178BD\", \"purpose\": \"visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-3FD178BD\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-09-18 08:45:48\", \"visitor_id\": 165, \"valid_until\": \"2025-09-18 13:45:00\", \"access_level\": null, \"generated_at\": \"2025-09-18 10:01:37\", \"visitor_name\": \"ryan\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-09-18T00:45:48.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-09-18T02:01:37.000000Z\", \"access_code\": null, \"facility_id\": null, \"access_level\": null, \"arrival_date\": \"2025-09-17T16:00:00.000000Z\", \"arrival_time\": \"2025-09-18T03:45:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"bry\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4534\", \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"insurance_notes\": null, \"pass_valid_from\": \"2025-09-18T00:45:48.000000Z\", \"pending_exit_at\": null, \"pass_valid_until\": \"2025-09-18T05:45:00.000000Z\", \"expected_date_out\": \"2025-09-17T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-09-18T05:45:00.000000Z\", \"insurance_provider\": null, \"special_instructions\": null, \"generate_digital_pass\": 0, \"insurance_expiry_date\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null}', '2025-09-18 02:01:37', '2025-09-18 02:01:37', '2025-09-18 02:01:37'),
(92, 174, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 174, \"name\": \"sogo\", \"email\": \"itadori0912@gmail.com\", \"phone\": \"091511755772\", \"status\": \"active\", \"company\": \"gerger\", \"contact\": \"091511755772\", \"id_type\": \"Driver\'s License\", \"pass_id\": \"PASS-8AB3450A\", \"purpose\": \"visit\", \"time_in\": \"2025-10-22T19:26:06.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"324235\", \"pass_data\": {\"pass_id\": \"PASS-8AB3450A\", \"purpose\": \"visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-8AB3450A\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-10-23 03:25:49\", \"visitor_id\": 174, \"valid_until\": \"2025-10-30 03:25:00\", \"access_level\": null, \"generated_at\": \"2025-10-23 03:26:06\", \"visitor_name\": \"sogo\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-10-22T19:25:49.000000Z\", \"department\": \"logistic_2\", \"updated_at\": \"2025-10-22T19:26:06.000000Z\", \"access_code\": null, \"facility_id\": null, \"access_level\": null, \"arrival_date\": null, \"arrival_time\": \"2025-10-22T21:25:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"ern\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"2342\", \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"insurance_notes\": null, \"pass_valid_from\": \"2025-10-22T19:25:49.000000Z\", \"pending_exit_at\": null, \"pass_valid_until\": \"2025-10-29T19:25:00.000000Z\", \"expected_date_out\": \"2025-10-29T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-10-29T19:25:00.000000Z\", \"insurance_provider\": null, \"special_instructions\": null, \"generate_digital_pass\": 0, \"insurance_expiry_date\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null}', '2025-10-22 19:26:06', '2025-10-22 19:26:06', '2025-10-22 19:26:06'),
(93, 186, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 186, \"name\": \"gigi\", \"email\": \"tiremannn@pm.me\", \"phone\": \"09911211407\", \"status\": \"active\", \"company\": \"fdbdf\", \"contact\": \"09911211407\", \"id_type\": \"barangay_id\", \"pass_id\": \"PASS-BA31106B\", \"purpose\": \"site visit\", \"time_in\": \"2025-11-20T18:48:28.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"fafasf\", \"pass_data\": {\"pass_id\": \"PASS-BA31106B\", \"purpose\": \"site visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-BA31106B\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-21 02:34:13\", \"visitor_id\": 186, \"valid_until\": \"2025-11-22 02:33:00\", \"access_level\": null, \"generated_at\": \"2025-11-21 02:48:28\", \"visitor_name\": \"gigi\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-20T18:34:13.000000Z\", \"department\": \"core_2\", \"updated_at\": \"2025-11-20T18:48:28.000000Z\", \"access_code\": null, \"facility_id\": null, \"id_verified\": true, \"access_level\": null, \"arrival_date\": \"2025-11-20T16:00:00.000000Z\", \"arrival_time\": \"2025-11-20T20:33:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"trrty\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"dfbdf\", \"id_verified_at\": \"2025-11-20T18:48:18.000000Z\", \"id_verified_by\": 12, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-20T18:34:13.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/GjndaQ76xqpH0szK7fvQx0bxWkMN0mOu2yMen4gr.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-21T18:33:00.000000Z\", \"expected_date_out\": \"2025-11-21T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-21T18:33:00.000000Z\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": \"fyess\", \"insurance_expiry_date\": null, \"id_verification_method\": \"manual\", \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-20 18:48:28', '2025-11-20 18:48:28', '2025-11-20 18:48:28'),
(94, 187, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 187, \"name\": \"jake\", \"email\": \"premsyt2024@gmail.com\", \"phone\": \"05950656522\", \"status\": \"active\", \"company\": \"dfdfhd\", \"contact\": \"05950656522\", \"id_type\": \"company_id\", \"pass_id\": \"PASS-369B0405\", \"purpose\": \"new_hire\", \"time_in\": \"2025-11-21T05:22:28.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"4543534\", \"pass_data\": {\"pass_id\": \"PASS-369B0405\", \"purpose\": \"new_hire\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-369B0405\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-21 13:22:01\", \"visitor_id\": 187, \"valid_until\": \"2025-11-22 18:21:00\", \"access_level\": null, \"generated_at\": \"2025-11-21 13:22:28\", \"visitor_name\": \"jake\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-21T05:22:01.000000Z\", \"department\": \"hr4\", \"updated_at\": \"2025-11-21T05:22:28.000000Z\", \"access_code\": null, \"facility_id\": null, \"id_verified\": true, \"access_level\": null, \"arrival_date\": \"2025-11-20T16:00:00.000000Z\", \"arrival_time\": \"2025-11-21T09:21:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"ewgw\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"34535\", \"id_verified_at\": \"2025-11-21T05:22:22.000000Z\", \"id_verified_by\": 12, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-21T05:22:01.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/WipI53quEfCLFrb8Zm0ElLljclVP2ra3TSBnUezZ.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-22T10:21:00.000000Z\", \"expected_date_out\": \"2025-11-21T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-22T10:21:00.000000Z\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": \"dfgfg\", \"insurance_expiry_date\": null, \"id_verification_method\": \"manual\", \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-21 05:22:28', '2025-11-21 05:22:28', '2025-11-21 05:22:28'),
(95, 188, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 188, \"name\": \"SGSG\", \"email\": \"dorothee.collingnon@neuf.fr\", \"phone\": \"FDGDF\", \"status\": \"active\", \"company\": \"HGMGH\", \"contact\": \"FDGDF\", \"id_type\": \"drivers_license\", \"pass_id\": \"PASS-FD6206DC\", \"purpose\": \"54456\", \"time_in\": \"2025-11-23T19:18:57.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"DFGDF\", \"pass_data\": {\"pass_id\": \"PASS-FD6206DC\", \"purpose\": \"54456\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-FD6206DC\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-24 03:18:24\", \"visitor_id\": 188, \"valid_until\": \"2025-11-24 07:18:00\", \"access_level\": null, \"generated_at\": \"2025-11-24 03:18:57\", \"visitor_name\": \"SGSG\", \"escort_required\": \"no\", \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-23T19:18:24.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-11-23T19:18:57.000000Z\", \"access_code\": null, \"facility_id\": null, \"id_verified\": true, \"access_level\": null, \"arrival_date\": \"2025-11-23T16:00:00.000000Z\", \"arrival_time\": \"2025-11-23T20:18:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"TRHRT\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"456456\", \"id_verified_at\": \"2025-11-23T19:18:49.000000Z\", \"id_verified_by\": 12, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-23T19:18:24.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/hz8MBFuzkhvKzl7PrV2FXjSzX2k75gdUAYFudMRE.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-23T23:18:00.000000Z\", \"expected_date_out\": \"2025-11-23T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-23T23:18:00.000000Z\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": \"JTGJ\", \"insurance_expiry_date\": null, \"id_verification_method\": \"manual\", \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-23 19:18:57', '2025-11-23 19:18:57', '2025-11-23 19:18:57'),
(96, 189, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 189, \"name\": \"ernesto\", \"email\": \"genesispiquero799@gmail.com\", \"phone\": \"09985456954\", \"status\": \"active\", \"company\": \"rgedrger\", \"contact\": \"09985456954\", \"id_type\": \"company_id\", \"pass_id\": \"PASS-26C59A22\", \"purpose\": \"erge\", \"time_in\": \"2025-11-26T14:49:52.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"3543453\", \"pass_data\": {\"pass_id\": \"PASS-26C59A22\", \"purpose\": \"erge\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-26C59A22%22%2C%22code%22%3A%22190210%22%7D\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-26 19:47:42\", \"visitor_id\": 189, \"access_code\": \"190210\", \"valid_until\": \"2025-11-28 22:47:00\", \"access_level\": null, \"generated_at\": \"2025-11-26 23:17:03\", \"visitor_name\": \"ernesto\", \"escort_required\": \"no\", \"profile_photo_url\": null, \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-26T11:47:42.000000Z\", \"department\": \"logistic_2\", \"updated_at\": \"2025-11-26T15:17:03.000000Z\", \"access_code\": \"190210\", \"facility_id\": null, \"id_verified\": false, \"access_level\": null, \"arrival_date\": \"2025-11-26T16:00:00.000000Z\", \"arrival_time\": \"2025-11-26T12:47:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"tter\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4543\", \"id_verified_at\": null, \"id_verified_by\": null, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-26T11:47:42.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/3iyuLIhoTmEmMtWJ0vdznq5aLOip7Ea1urefHP2I.png\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-28T14:47:00.000000Z\", \"expected_date_out\": \"2025-11-27T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-28T14:47:00.000000Z\", \"profile_photo_url\": \"/storage/visitor_photos/2b32576a-86f8-46f2-9ff3-0e44099f4dad.jpeg\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": null, \"insurance_expiry_date\": null, \"id_verification_method\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-26 15:17:03', '2025-11-26 15:17:03', '2025-11-26 15:17:03'),
(97, 190, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 190, \"name\": \"zen chan\", \"email\": \"piqs09120@gmail.com\", \"phone\": \"09985456954\", \"status\": \"active\", \"company\": \"thrthr\", \"contact\": \"09985456954\", \"id_type\": \"barangay_id\", \"pass_id\": \"PASS-01A04859\", \"purpose\": \"erge\", \"time_in\": \"2025-11-26T15:54:12.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"345345\", \"pass_data\": {\"pass_id\": \"PASS-01A04859\", \"purpose\": \"erge\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-01A04859%22%2C%22code%22%3A%22887811%22%7D\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-26 23:39:36\", \"visitor_id\": 190, \"access_code\": \"887811\", \"valid_until\": \"2025-11-27 14:39:00\", \"access_level\": null, \"generated_at\": \"2025-11-26 23:54:12\", \"visitor_name\": \"zen chan\", \"escort_required\": \"no\", \"profile_photo_url\": null, \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-26T15:39:36.000000Z\", \"department\": \"hr2\", \"updated_at\": \"2025-11-26T15:54:15.000000Z\", \"access_code\": \"887811\", \"facility_id\": null, \"id_verified\": false, \"access_level\": null, \"arrival_date\": \"2025-11-25T16:00:00.000000Z\", \"arrival_time\": \"2025-11-26T04:39:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"tter\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"43534\", \"id_verified_at\": null, \"id_verified_by\": null, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-26T15:39:36.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/6lj9CkGYdLfBxZEyy91N9bTmfgfXeVMExmrG0eHt.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-27T06:39:00.000000Z\", \"expected_date_out\": \"2025-11-26T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-27T06:39:00.000000Z\", \"profile_photo_url\": \"/storage/visitor_photos/cf4df0c8-b5fe-4957-9d4a-6886711ae571.jpeg\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": null, \"insurance_expiry_date\": null, \"id_verification_method\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-26 15:54:15', '2025-11-26 15:54:15', '2025-11-26 15:54:15'),
(98, 191, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 191, \"name\": \"adminneto\", \"email\": \"admin@gmail.com\", \"phone\": \"09985456954\", \"status\": \"active\", \"company\": \"My Company\", \"contact\": \"09985456954\", \"id_type\": \"pwd_id\", \"pass_id\": \"PASS-829852CF\", \"purpose\": \"erge\", \"time_in\": \"2025-11-26T16:19:42.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"3543453\", \"pass_data\": {\"pass_id\": \"PASS-829852CF\", \"purpose\": \"erge\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-829852CF%22%2C%22code%22%3A%22712095%22%7D\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-27 00:08:26\", \"visitor_id\": 191, \"access_code\": \"712095\", \"valid_until\": \"2025-11-27 02:00:00\", \"access_level\": null, \"generated_at\": \"2025-11-27 00:19:42\", \"visitor_name\": \"adminneto\", \"escort_required\": \"no\", \"profile_photo_url\": null, \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-26T16:08:26.000000Z\", \"department\": \"core_1\", \"updated_at\": \"2025-11-26T16:19:42.000000Z\", \"access_code\": \"712095\", \"facility_id\": null, \"id_verified\": false, \"access_level\": null, \"arrival_date\": \"2025-11-26T16:00:00.000000Z\", \"arrival_time\": \"2025-11-26T17:00:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"tter\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"4543\", \"id_verified_at\": null, \"id_verified_by\": null, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-26T16:08:26.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/otjKENTQecm4FHJjzqqHjC5CwHFQdyis6ZDtuGKN.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-26T18:00:00.000000Z\", \"expected_date_out\": \"2025-11-26T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-26T18:00:00.000000Z\", \"profile_photo_url\": \"/storage/visitor_photos/91094269-76fe-4249-9b7b-2591df7915d9.jpeg\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": null, \"insurance_expiry_date\": null, \"id_verification_method\": null, \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-26 16:19:42', '2025-11-26 16:19:42', '2025-11-26 16:19:42'),
(99, 185, 12, 'checkin', 'Visitor approved and auto-checked in', '{\"id\": 185, \"name\": \"bren\", \"email\": \"premsyt2024@gmail.com\", \"phone\": \"09911211407\", \"status\": \"active\", \"company\": \"dfhdfh\", \"contact\": \"09911211407\", \"id_type\": \"senior_citizen_id\", \"pass_id\": \"PASS-D49A3CAD\", \"purpose\": \"site visit\", \"time_in\": \"2025-11-26T16:33:04.000000Z\", \"facility\": null, \"time_out\": null, \"id_number\": \"43534\", \"pass_data\": {\"pass_id\": \"PASS-D49A3CAD\", \"purpose\": \"site visit\", \"qr_code\": \"https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-D49A3CAD%22%2C%22code%22%3A%22867586%22%7D\", \"facility\": \"N/A\", \"pass_type\": \"visitor\", \"valid_from\": \"2025-11-19 23:43:09\", \"visitor_id\": 185, \"access_code\": \"867586\", \"valid_until\": \"2025-11-20 23:42:00\", \"access_level\": null, \"generated_at\": \"2025-11-27 00:33:04\", \"visitor_name\": \"bren\", \"escort_required\": \"no\", \"profile_photo_url\": null, \"special_instructions\": null}, \"pass_type\": \"visitor\", \"created_at\": \"2025-11-19T15:43:09.000000Z\", \"department\": \"logistic_2\", \"updated_at\": \"2025-11-26T16:33:04.000000Z\", \"access_code\": \"867586\", \"facility_id\": null, \"id_verified\": true, \"access_level\": null, \"arrival_date\": \"2025-11-18T16:00:00.000000Z\", \"arrival_time\": \"2025-11-27T04:42:00.000000Z\", \"is_scheduled\": 0, \"pending_exit\": false, \"host_employee\": \"bry\", \"pass_validity\": \"24_hours\", \"vehicle_plate\": \"3453453\", \"id_verified_at\": \"2025-11-26T11:27:07.000000Z\", \"id_verified_by\": 12, \"scheduled_date\": null, \"scheduled_time\": null, \"escort_required\": \"no\", \"id_scanned_data\": null, \"insurance_notes\": null, \"pass_valid_from\": \"2025-11-19T15:43:09.000000Z\", \"pending_exit_at\": null, \"id_document_path\": \"id_documents/DxRs95W07Z2bg8KtYjti1df6nIc8UlYes1RuUua2.jpg\", \"id_document_size\": null, \"pass_valid_until\": \"2025-11-20T15:42:00.000000Z\", \"expected_date_out\": \"2025-11-19T16:00:00.000000Z\", \"expected_duration\": null, \"expected_time_out\": \"2025-11-20T15:42:00.000000Z\", \"profile_photo_url\": \"/storage/visitor_photos/20d66583-70f2-4182-971b-51045fadf3f8.jpeg\", \"insurance_provider\": null, \"id_validation_error\": null, \"id_validation_status\": \"pending\", \"special_instructions\": null, \"generate_digital_pass\": 0, \"id_document_mime_type\": null, \"id_validation_details\": null, \"id_verification_notes\": null, \"insurance_expiry_date\": null, \"id_verification_method\": \"scan\", \"facility_reservation_id\": null, \"insurance_policy_number\": null, \"id_validation_confidence\": 0, \"id_document_original_name\": null}', '2025-11-26 16:33:06', '2025-11-26 16:33:06', '2025-11-26 16:33:06'),
(100, 192, 1, 'checkin', 'Visitor approved and auto-checked in', '{\"id\":192,\"name\":\"flora\",\"email\":\"itadori0912@gmail.com\",\"phone\":\"09985456954\",\"contact\":\"09985456954\",\"purpose\":\"visit\",\"company\":null,\"department\":\"finance\",\"host_employee\":\"jan\",\"id_type\":\"drivers_license\",\"id_number\":null,\"id_document_path\":\"id_documents\\/KPRVI7ky0qD7kZipQ7TMmeDoRHvRZh3BwSYe66mx.png\",\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":null,\"status\":\"active\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-11-26T17:27:24.000000Z\",\"pass_valid_until\":\"2025-11-27T17:27:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-EB94A8D9\",\"pass_data\":{\"pass_id\":\"PASS-EB94A8D9\",\"visitor_name\":\"flora\",\"visitor_id\":192,\"pass_type\":\"visitor\",\"access_level\":null,\"escort_required\":\"no\",\"valid_from\":\"2025-11-27 01:27:24\",\"valid_until\":\"2025-11-28 01:27:00\",\"facility\":\"N\\/A\",\"purpose\":\"visit\",\"special_instructions\":null,\"generated_at\":\"2026-01-12 10:26:24\",\"access_code\":\"161185\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-EB94A8D9%22%2C%22code%22%3A%22161185%22%7D\",\"profile_photo_url\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":\"2026-01-12T02:26:24.000000Z\",\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-11-27T17:27:00.000000Z\",\"expected_date_out\":\"2025-11-27T16:00:00.000000Z\",\"arrival_date\":\"2025-11-26T16:00:00.000000Z\",\"arrival_time\":\"2026-01-11T20:27:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":\"161185\",\"profile_photo_url\":\"\\/storage\\/visitor_photos\\/d18e9384-f2c7-4fe5-91ae-76b8292a7dd8.jpeg\",\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-11-26T17:27:24.000000Z\",\"updated_at\":\"2026-01-12T02:26:24.000000Z\",\"facility\":null}', '2026-01-12 02:26:24', '2026-01-12 02:26:24', '2026-01-12 02:26:24'),
(101, 175, 1, 'register', 'Visitor declined', '{\"id\":175,\"name\":\"ern\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"091511755772\",\"contact\":\"091511755772\",\"purpose\":\"tambay\",\"company\":\"vsdv\",\"department\":\"logistic_2\",\"host_employee\":\"trrty\",\"id_type\":\"Passport\",\"id_number\":\"32432\",\"id_document_path\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"32423\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-24T08:25:38.000000Z\",\"pass_valid_until\":\"2025-10-25T08:25:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-B79B6955\",\"pass_data\":{\"pass_id\":\"PASS-B79B6955\",\"purpose\":\"tambay\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-B79B6955\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-24 16:25:38\",\"visitor_id\":175,\"valid_until\":\"2025-10-25 16:25:00\",\"access_level\":null,\"generated_at\":\"2025-10-24 16:25:38\",\"visitor_name\":\"ern\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-25T08:25:00.000000Z\",\"expected_date_out\":\"2025-10-24T16:00:00.000000Z\",\"arrival_date\":\"2025-10-23T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T11:25:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-24T08:25:38.000000Z\",\"updated_at\":\"2026-01-22T17:22:59.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null}', '2026-01-22 17:22:59', '2026-01-22 17:22:59', '2026-01-22 17:22:59'),
(102, 184, 1, 'checkin', 'Visitor approved and auto-checked in', '{\"id\":184,\"name\":\"ern\",\"email\":\"gigi@gmail.com\",\"phone\":\"05950656522\",\"contact\":\"05950656522\",\"purpose\":\"site visit\",\"company\":\"dfbdf\",\"department\":\"finance\",\"host_employee\":\"rehe\",\"id_type\":\"school_id\",\"id_number\":\"aefaef\",\"id_document_path\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"3463636\",\"status\":\"active\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-11-19T15:34:31.000000Z\",\"pass_valid_until\":\"2025-11-20T06:34:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-FA0DF8EE\",\"pass_data\":{\"pass_id\":\"PASS-FA0DF8EE\",\"visitor_name\":\"ern\",\"visitor_id\":184,\"pass_type\":\"visitor\",\"access_level\":null,\"escort_required\":\"no\",\"valid_from\":\"2025-11-19 23:34:31\",\"valid_until\":\"2025-11-20 14:34:00\",\"facility\":\"N\\/A\",\"purpose\":\"site visit\",\"special_instructions\":null,\"generated_at\":\"2026-01-23 01:24:41\",\"access_code\":\"068917\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=%7B%22pass_id%22%3A%22PASS-FA0DF8EE%22%2C%22code%22%3A%22068917%22%7D\",\"profile_photo_url\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":\"2026-01-22T17:24:41.000000Z\",\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-11-20T06:34:00.000000Z\",\"expected_date_out\":\"2025-11-19T16:00:00.000000Z\",\"arrival_date\":\"2025-11-18T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T05:34:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":\"068917\",\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-11-19T15:34:31.000000Z\",\"updated_at\":\"2026-01-22T17:24:41.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"facility\":null}', '2026-01-22 17:24:41', '2026-01-22 17:24:41', '2026-01-22 17:24:41'),
(103, 180, 2, 'register', 'Visitor declined', '{\"id\":180,\"name\":\"gigi\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"05950656522\",\"contact\":\"05950656522\",\"purpose\":\"tambay\",\"company\":\"dvws\",\"department\":\"hr2\",\"host_employee\":\"ern\",\"id_type\":\"philsys\",\"id_number\":\"6645445\",\"id_document_path\":null,\"supporting_document\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"4534534\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-26T08:03:48.000000Z\",\"pass_valid_until\":\"2025-10-27T13:03:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-EFB0A429\",\"pass_data\":{\"pass_id\":\"PASS-EFB0A429\",\"purpose\":\"tambay\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-EFB0A429\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-26 16:03:48\",\"visitor_id\":180,\"valid_until\":\"2025-10-27 21:03:00\",\"access_level\":null,\"generated_at\":\"2025-10-26 16:03:48\",\"visitor_name\":\"gigi\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-27T13:03:00.000000Z\",\"expected_date_out\":\"2025-10-26T16:00:00.000000Z\",\"arrival_date\":\"2025-10-25T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T11:03:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-26T08:03:48.000000Z\",\"updated_at\":\"2026-01-23T06:23:58.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:23:58', '2026-01-23 06:23:58', '2026-01-23 06:23:58'),
(104, 176, 2, 'register', 'Visitor declined', '{\"id\":176,\"name\":\"rain\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"09911211407\",\"contact\":\"09911211407\",\"purpose\":\"WALA\",\"company\":\"rgegergerger\",\"department\":\"core_2\",\"host_employee\":\"bry\",\"id_type\":\"National ID\",\"id_number\":\"43543634634\",\"id_document_path\":null,\"supporting_document\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"3443534543\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-24T08:32:17.000000Z\",\"pass_valid_until\":\"2025-10-25T11:32:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-C86047E0\",\"pass_data\":{\"pass_id\":\"PASS-C86047E0\",\"purpose\":\"WALA\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-C86047E0\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-24 16:32:17\",\"visitor_id\":176,\"valid_until\":\"2025-10-25 19:32:00\",\"access_level\":null,\"generated_at\":\"2025-10-24 16:32:17\",\"visitor_name\":\"rain\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-25T11:32:00.000000Z\",\"expected_date_out\":\"2025-10-24T16:00:00.000000Z\",\"arrival_date\":\"2025-10-23T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T13:31:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-24T08:32:17.000000Z\",\"updated_at\":\"2026-01-23T06:24:06.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:06', '2026-01-23 06:24:06', '2026-01-23 06:24:06'),
(105, 178, 2, 'register', 'Visitor declined', '{\"id\":178,\"name\":\"sogo\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"09546546548\",\"contact\":\"09546546548\",\"purpose\":\"visit\",\"company\":\"fsbdsb\",\"department\":\"hr4\",\"host_employee\":\"bry\",\"id_type\":\"National ID\",\"id_number\":\"fbdb\",\"id_document_path\":\"visitor_id_documents\\/id_1761299598_68fb4c8eddf2c.jfif\",\"supporting_document\":null,\"id_document_original_name\":\"eac88a91-bb5f-4a4e-b68f-091d3482c517.jfif\",\"id_document_mime_type\":\"image\\/jpeg\",\"id_document_size\":165269,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"3534543\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-24T09:53:18.000000Z\",\"pass_valid_until\":\"2025-10-25T14:53:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-AD068301\",\"pass_data\":{\"pass_id\":\"PASS-AD068301\",\"purpose\":\"visit\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-AD068301\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-24 17:53:18\",\"visitor_id\":178,\"valid_until\":\"2025-10-25 22:53:00\",\"access_level\":null,\"generated_at\":\"2025-10-24 17:53:18\",\"visitor_name\":\"sogo\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-25T14:53:00.000000Z\",\"expected_date_out\":\"2025-10-24T16:00:00.000000Z\",\"arrival_date\":\"2025-10-23T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T12:53:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-24T09:53:18.000000Z\",\"updated_at\":\"2026-01-23T06:24:10.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:10', '2026-01-23 06:24:10', '2026-01-23 06:24:10'),
(106, 177, 2, 'register', 'Visitor declined', '{\"id\":177,\"name\":\"bren\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"09911211407\",\"contact\":\"09911211407\",\"purpose\":\"tambay\",\"company\":\"egwgwe\",\"department\":\"finance\",\"host_employee\":\"ern\",\"id_type\":\"National ID\",\"id_number\":\"32432\",\"id_document_path\":\"visitor_id_documents\\/id_1761297998_68fb464e0beff.jfif\",\"supporting_document\":null,\"id_document_original_name\":\"eac88a91-bb5f-4a4e-b68f-091d3482c517.jfif\",\"id_document_mime_type\":\"image\\/jpeg\",\"id_document_size\":165269,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"34534543\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-24T09:26:38.000000Z\",\"pass_valid_until\":\"2025-10-25T09:23:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-CBF9BE2A\",\"pass_data\":{\"pass_id\":\"PASS-CBF9BE2A\",\"purpose\":\"tambay\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-CBF9BE2A\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-24 17:26:38\",\"visitor_id\":177,\"valid_until\":\"2025-10-25 17:23:00\",\"access_level\":null,\"generated_at\":\"2025-10-24 17:26:38\",\"visitor_name\":\"bren\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-25T09:23:00.000000Z\",\"expected_date_out\":\"2025-10-24T16:00:00.000000Z\",\"arrival_date\":\"2025-10-23T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T11:22:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-24T09:26:38.000000Z\",\"updated_at\":\"2026-01-23T06:24:12.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:12', '2026-01-23 06:24:12', '2026-01-23 06:24:12'),
(107, 179, 2, 'register', 'Visitor declined', '{\"id\":179,\"name\":\"arjay\",\"email\":\"gigi@gmail.com\",\"phone\":\"05950656522\",\"contact\":\"05950656522\",\"purpose\":\"site visit\",\"company\":\"dbdfb\",\"department\":\"hr1\",\"host_employee\":\"bry\",\"id_type\":\"Company ID\",\"id_number\":\"4363464\",\"id_document_path\":\"visitor_id_documents\\/id_1761300080_68fb4e70e535c.png\",\"supporting_document\":null,\"id_document_original_name\":\"image_2025-10-24_180057539.png\",\"id_document_mime_type\":\"image\\/png\",\"id_document_size\":56367,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"43534\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-10-24T10:01:20.000000Z\",\"pass_valid_until\":\"2025-10-25T13:01:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-E2194C87\",\"pass_data\":{\"pass_id\":\"PASS-E2194C87\",\"purpose\":\"site visit\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-E2194C87\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-10-24 18:01:20\",\"visitor_id\":179,\"valid_until\":\"2025-10-25 21:01:00\",\"access_level\":null,\"generated_at\":\"2025-10-24 18:01:20\",\"visitor_name\":\"arjay\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-10-25T13:01:00.000000Z\",\"expected_date_out\":\"2025-10-24T16:00:00.000000Z\",\"arrival_date\":\"2025-10-23T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T14:01:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-10-24T10:01:20.000000Z\",\"updated_at\":\"2026-01-23T06:24:15.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:15', '2026-01-23 06:24:15', '2026-01-23 06:24:15');
INSERT INTO `visitor_checkin_logs` (`id`, `visitor_id`, `checked_in_by`, `action`, `notes`, `visitor_data`, `action_time`, `created_at`, `updated_at`) VALUES
(108, 181, 2, 'register', 'Visitor declined', '{\"id\":181,\"name\":\"sogo\",\"email\":\"piqs09120@gmail.com\",\"phone\":\"09911211407\",\"contact\":\"09911211407\",\"purpose\":\"visit\",\"company\":\"fdbfdbdf\",\"department\":\"finance\",\"host_employee\":\"ern\",\"id_type\":\"philnational_id\",\"id_number\":\"6645445\",\"id_document_path\":null,\"supporting_document\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"dbdf\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-11-15T18:14:56.000000Z\",\"pass_valid_until\":\"2025-11-16T22:14:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-1677D941\",\"pass_data\":{\"pass_id\":\"PASS-1677D941\",\"purpose\":\"visit\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-1677D941\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-11-16 02:14:56\",\"visitor_id\":181,\"valid_until\":\"2025-11-17 06:14:00\",\"access_level\":null,\"generated_at\":\"2025-11-16 02:14:56\",\"visitor_name\":\"sogo\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-11-16T22:14:00.000000Z\",\"expected_date_out\":\"2025-11-16T16:00:00.000000Z\",\"arrival_date\":\"2025-11-15T16:00:00.000000Z\",\"arrival_time\":\"2026-01-22T20:14:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-11-15T18:14:56.000000Z\",\"updated_at\":\"2026-01-23T06:24:17.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:17', '2026-01-23 06:24:17', '2026-01-23 06:24:17'),
(109, 182, 2, 'register', 'Visitor declined', '{\"id\":182,\"name\":\"gigi\",\"email\":\"tiremannn@pm.me\",\"phone\":\"09911211407\",\"contact\":\"09911211407\",\"purpose\":\"visit\",\"company\":\"gsdgs\",\"department\":\"core_1\",\"host_employee\":\"bry\",\"id_type\":\"sss_id\",\"id_number\":\"6645445\",\"id_document_path\":null,\"supporting_document\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"4353453\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-11-19T14:57:56.000000Z\",\"pass_valid_until\":\"2025-11-19T07:57:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-006F1032\",\"pass_data\":{\"pass_id\":\"PASS-006F1032\",\"purpose\":\"visit\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-006F1032\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-11-19 22:57:56\",\"visitor_id\":182,\"valid_until\":\"2025-11-19 15:57:00\",\"access_level\":null,\"generated_at\":\"2025-11-19 22:57:56\",\"visitor_name\":\"gigi\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-11-19T07:57:00.000000Z\",\"expected_date_out\":\"2025-11-18T16:00:00.000000Z\",\"arrival_date\":\"2025-11-18T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T14:57:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":null,\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-11-19T14:57:56.000000Z\",\"updated_at\":\"2026-01-23T06:24:19.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:19', '2026-01-23 06:24:19', '2026-01-23 06:24:19'),
(110, 183, 2, 'register', 'Visitor declined', '{\"id\":183,\"name\":\"sogo\",\"email\":\"gigi@gmail.com\",\"phone\":\"09911211407\",\"contact\":\"09911211407\",\"purpose\":\"site visit\",\"company\":\"dfbdfb\",\"department\":\"logistic_1\",\"host_employee\":\"ewgw\",\"id_type\":\"postal_id\",\"id_number\":\"53453\",\"id_document_path\":null,\"supporting_document\":null,\"id_document_original_name\":null,\"id_document_mime_type\":null,\"id_document_size\":null,\"id_validation_status\":\"pending\",\"id_validation_confidence\":0,\"id_validation_details\":null,\"id_validation_error\":null,\"id_verified\":false,\"id_verified_at\":null,\"id_verified_by\":null,\"id_verification_notes\":null,\"id_verification_method\":null,\"id_scanned_data\":null,\"vehicle_plate\":\"234543\",\"status\":\"declined\",\"pass_type\":\"visitor\",\"pass_validity\":\"24_hours\",\"pass_valid_from\":\"2025-11-19T15:26:21.000000Z\",\"pass_valid_until\":\"2025-11-20T15:26:00.000000Z\",\"access_level\":null,\"escort_required\":\"no\",\"special_instructions\":null,\"generate_digital_pass\":0,\"pass_id\":\"PASS-5C6AACE4\",\"pass_data\":{\"pass_id\":\"PASS-5C6AACE4\",\"purpose\":\"site visit\",\"qr_code\":\"https:\\/\\/api.qrserver.com\\/v1\\/create-qr-code\\/?size=200x200&data=http%3A%2F%2Fadministrative.test%2Fverify-pass%2FPASS-5C6AACE4\",\"facility\":\"N\\/A\",\"pass_type\":\"visitor\",\"valid_from\":\"2025-11-19 23:26:21\",\"visitor_id\":183,\"valid_until\":\"2025-11-20 23:26:00\",\"access_level\":null,\"generated_at\":\"2025-11-19 23:26:21\",\"visitor_name\":\"sogo\",\"escort_required\":\"no\",\"special_instructions\":null},\"insurance_provider\":null,\"insurance_policy_number\":null,\"insurance_expiry_date\":null,\"insurance_notes\":null,\"facility_id\":null,\"facility_reservation_id\":null,\"time_in\":null,\"time_out\":null,\"pending_exit\":false,\"pending_exit_at\":null,\"expected_time_out\":\"2025-11-20T15:26:00.000000Z\",\"expected_date_out\":\"2025-11-19T16:00:00.000000Z\",\"arrival_date\":\"2025-11-18T16:00:00.000000Z\",\"arrival_time\":\"2026-01-23T06:25:00.000000Z\",\"scheduled_date\":null,\"scheduled_time\":null,\"expected_duration\":null,\"access_code\":\"467957\",\"profile_photo_url\":null,\"rating\":null,\"rating_comment\":null,\"is_scheduled\":0,\"created_at\":\"2025-11-19T15:26:21.000000Z\",\"updated_at\":\"2026-01-23T06:24:21.000000Z\",\"batch_id\":null,\"group_identifier\":null,\"batch_order\":null,\"bulk_session_id\":null}', '2026-01-23 06:24:21', '2026-01-23 06:24:21', '2026-01-23 06:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_qr_passes`
--

CREATE TABLE `visitor_qr_passes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitor_id` bigint(20) UNSIGNED NOT NULL,
  `verification_log_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pass_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_until` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `scanned_at` timestamp NULL DEFAULT NULL,
  `scanned_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_location` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_count` int(11) NOT NULL DEFAULT 0,
  `scan_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `hmac_signature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL DEFAULT 0,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `revoked_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revocation_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent` tinyint(1) NOT NULL DEFAULT 0,
  `email_sent_at` timestamp NULL DEFAULT NULL,
  `email_send_attempts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_violations`
--

CREATE TABLE `visitor_violations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_violation_audit_logs`
--

CREATE TABLE `visitor_violation_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_violation_policy`
--

CREATE TABLE `visitor_violation_policy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visitor_violation_id` bigint(20) UNSIGNED NOT NULL,
  `policy_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_logs`
--
ALTER TABLE `access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_logs_document_id_action_index` (`document_id`,`action`);

--
-- Indexes for table `activity_stream`
--
ALTER TABLE `activity_stream`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_stream_module_created_at_index` (`module`,`created_at`),
  ADD KEY `activity_stream_entity_type_entity_id_index` (`entity_type`,`entity_id`),
  ADD KEY `activity_stream_performed_by_id_created_at_index` (`performed_by_id`,`created_at`),
  ADD KEY `activity_stream_module_index` (`module`),
  ADD KEY `activity_stream_action_index` (`action`),
  ADD KEY `activity_stream_entity_type_index` (`entity_type`),
  ADD KEY `activity_stream_entity_id_index` (`entity_id`),
  ADD KEY `activity_stream_performed_by_id_index` (`performed_by_id`),
  ADD KEY `activity_stream_created_at_index` (`created_at`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulk_visit_sessions`
--
ALTER TABLE `bulk_visit_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bulk_visit_sessions_qr_code_token_unique` (`qr_code_token`);

--
-- Indexes for table `case_activities`
--
ALTER TABLE `case_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_activities_legal_case_id_index` (`legal_case_id`),
  ADD KEY `case_activities_action_type_index` (`action_type`),
  ADD KEY `case_activities_created_at_index` (`created_at`);

--
-- Indexes for table `case_dockets`
--
ALTER TABLE `case_dockets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_dockets_legal_case_id_event_date_index` (`legal_case_id`,`event_date`),
  ADD KEY `case_dockets_event_type_index` (`event_type`);

--
-- Indexes for table `case_evidence`
--
ALTER TABLE `case_evidence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_evidence_legal_case_id_index` (`legal_case_id`),
  ADD KEY `case_evidence_evidence_type_index` (`evidence_type`);

--
-- Indexes for table `case_witnesses`
--
ALTER TABLE `case_witnesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_witnesses_legal_case_id_index` (`legal_case_id`);

--
-- Indexes for table `company_policies`
--
ALTER TABLE `company_policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_policies_policy_code_unique` (`policy_code`),
  ADD KEY `company_policies_category_status_index` (`category`,`status`),
  ADD KEY `company_policies_department_status_index` (`department`,`status`),
  ADD KEY `company_policies_effective_date_index` (`effective_date`);

--
-- Indexes for table `company_policy_versions`
--
ALTER TABLE `company_policy_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_policy_versions_policy_id_version_index` (`policy_id`,`version`);

--
-- Indexes for table `department_accounts`
--
ALTER TABLE `department_accounts`
  ADD PRIMARY KEY (`Dept_no`),
  ADD KEY `idx_department_accounts_status` (`status`);

--
-- Indexes for table `department_logs`
--
ALTER TABLE `department_logs`
  ADD PRIMARY KEY (`dept_logs_id`);

--
-- Indexes for table `department_table`
--
ALTER TABLE `department_table`
  ADD PRIMARY KEY (`Department_ID`);

--
-- Indexes for table `dept_audit_trail_&transaction`
--
ALTER TABLE `dept_audit_trail_&transaction`
  ADD PRIMARY KEY (`a&t_id`);

--
-- Indexes for table `disposal_history`
--
ALTER TABLE `disposal_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposal_history_disposed_at_index` (`disposed_at`),
  ADD KEY `disposal_history_disposal_reason_index` (`disposal_reason`),
  ADD KEY `disposal_history_document_department_index` (`document_department`),
  ADD KEY `disposal_history_confidentiality_level_index` (`confidentiality_level`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_reference_id_unique` (`reference_id`),
  ADD UNIQUE KEY `documents_document_id_unique` (`document_id`),
  ADD UNIQUE KEY `documents_legal_document_id_unique` (`legal_document_id`),
  ADD KEY `documents_linked_reservation_id_index` (`linked_reservation_id`),
  ADD KEY `documents_linked_case_id_index` (`linked_case_id`),
  ADD KEY `documents_document_type_department_index` (`document_type`,`department`),
  ADD KEY `documents_confidentiality_level_index` (`confidentiality_level`),
  ADD KEY `documents_is_archived_archived_at_index` (`is_archived`,`archived_at`),
  ADD KEY `documents_retention_until_index` (`retention_until`),
  ADD KEY `documents_approval_status_index` (`approval_status`),
  ADD KEY `documents_document_series_index` (`document_series`),
  ADD KEY `documents_parent_document_id_index` (`parent_document_id`),
  ADD KEY `documents_last_accessed_by_foreign` (`last_accessed_by`),
  ADD KEY `documents_approved_by_foreign` (`approved_by`),
  ADD KEY `documents_is_in_disposal_review_disposal_date_index` (`is_in_disposal_review`,`disposal_date`),
  ADD KEY `documents_ai_classification_index` (`ai_classification`),
  ADD KEY `documents_violation_score_index` (`violation_score`),
  ADD KEY `documents_compliance_status_index` (`compliance_status`),
  ADD KEY `documents_requires_immediate_review_index` (`requires_immediate_review`),
  ADD KEY `documents_ai_analysis_completed_index` (`ai_analysis_completed`),
  ADD KEY `documents_archived_by_foreign` (`archived_by`),
  ADD KEY `documents_external_reference_id_index` (`external_reference_id`),
  ADD KEY `idx_documents_status` (`status`),
  ADD KEY `idx_documents_archived_at` (`archived_at`),
  ADD KEY `idx_documents_status_archived` (`status`,`archived_at`),
  ADD KEY `idx_documents_created_at` (`created_at`);

--
-- Indexes for table `document_access_logs`
--
ALTER TABLE `document_access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_access_logs_document_id_accessed_at_index` (`document_id`,`accessed_at`),
  ADD KEY `document_access_logs_user_id_accessed_at_index` (`user_id`,`accessed_at`),
  ADD KEY `document_access_logs_action_accessed_at_index` (`action`,`accessed_at`),
  ADD KEY `document_access_logs_accessed_at_index` (`accessed_at`);

--
-- Indexes for table `document_activities`
--
ALTER TABLE `document_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_activities_created_at_index` (`created_at`),
  ADD KEY `document_activities_action_index` (`action`),
  ADD KEY `document_activities_user_id_index` (`user_id`),
  ADD KEY `document_activities_document_id_index` (`document_id`),
  ADD KEY `document_activities_document_id_action_index` (`document_id`,`action`),
  ADD KEY `document_activities_user_id_action_index` (`user_id`,`action`),
  ADD KEY `document_activities_created_at_action_index` (`created_at`,`action`);

--
-- Indexes for table `document_activity_logs`
--
ALTER TABLE `document_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `document_activity_logs_document_id_created_at_index` (`document_id`,`created_at`),
  ADD KEY `document_activity_logs_action_index` (`action`);

--
-- Indexes for table `document_collaborators`
--
ALTER TABLE `document_collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_collaborators_document_id_user_id_unique` (`document_id`,`user_id`),
  ADD KEY `document_collaborators_user_id_foreign` (`user_id`),
  ADD KEY `document_collaborators_document_id_role_index` (`document_id`,`role`);

--
-- Indexes for table `document_import_logs`
--
ALTER TABLE `document_import_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_import` (`source_system`,`external_reference_id`),
  ADD KEY `document_import_logs_source_system_index` (`source_system`),
  ADD KEY `document_import_logs_external_reference_id_index` (`external_reference_id`),
  ADD KEY `document_import_logs_document_id_index` (`document_id`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_retention_policies`
--
ALTER TABLE `document_retention_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_share_invites`
--
ALTER TABLE `document_share_invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_versions`
--
ALTER TABLE `document_versions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_versions_document_id_version_unique` (`document_id`,`version`),
  ADD KEY `document_versions_editor_id_foreign` (`editor_id`);

--
-- Indexes for table `document_workflows`
--
ALTER TABLE `document_workflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_workflows_document_id_status_index` (`document_id`,`status`),
  ADD KEY `document_workflows_workflow_type_status_index` (`workflow_type`,`status`),
  ADD KEY `document_workflows_target_module_status_index` (`target_module`,`status`);

--
-- Indexes for table `employee_complaints`
--
ALTER TABLE `employee_complaints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_complaints_case_id_unique` (`case_id`),
  ADD KEY `employee_complaints_status_priority_index` (`status`,`priority`),
  ADD KEY `employee_complaints_complainant_department_status_index` (`complainant_department`,`status`),
  ADD KEY `employee_complaints_incident_date_index` (`incident_date`);

--
-- Indexes for table `employee_logs`
--
ALTER TABLE `employee_logs`
  ADD PRIMARY KEY (`logs_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facility_requests`
--
ALTER TABLE `facility_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_requests_facility_id_foreign` (`facility_id`),
  ADD KEY `facility_requests_assigned_to_foreign` (`assigned_to`);

--
-- Indexes for table `facility_reservations`
--
ALTER TABLE `facility_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_reservations_reserved_by_foreign` (`reserved_by`),
  ADD KEY `facility_reservations_approved_by_foreign` (`approved_by`),
  ADD KEY `facility_reservations_legal_reviewer_id_foreign` (`legal_reviewer_id`),
  ADD KEY `fr_facility_start_idx` (`facility_id`,`start_time`),
  ADD KEY `fr_facility_end_idx` (`facility_id`,`end_time`),
  ADD KEY `fr_facility_status_idx` (`facility_id`,`status`),
  ADD KEY `facility_reservations_workflow_step_index` (`workflow_step`),
  ADD KEY `facility_reservations_has_calendar_conflicts_index` (`has_calendar_conflicts`),
  ADD KEY `facility_reservations_document_id_foreign` (`document_id`),
  ADD KEY `facility_reservations_inspected_by_foreign` (`inspected_by`),
  ADD KEY `facility_reservations_legal_case_id_foreign` (`legal_case_id`),
  ADD KEY `facility_reservations_facility_request_id_foreign` (`facility_request_id`),
  ADD KEY `idx_facility_reservations_facility_id` (`facility_id`),
  ADD KEY `idx_facility_reservations_created_at` (`created_at`);

--
-- Indexes for table `id_verification_logs`
--
ALTER TABLE `id_verification_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_verification_logs_visitor_id_foreign` (`visitor_id`),
  ADD KEY `id_verification_logs_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `id_verification_logs_verification_status_created_at_index` (`verification_status`,`created_at`),
  ADD KEY `id_verification_logs_form_email_index` (`form_email`),
  ADD KEY `id_verification_logs_verified_at_index` (`verified_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `legal_ai_analyses`
--
ALTER TABLE `legal_ai_analyses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_ai_analyses_document_id_document_type_index` (`document_id`,`document_type`),
  ADD KEY `legal_ai_analyses_confidence_score_index` (`confidence_score`);

--
-- Indexes for table `legal_ai_results`
--
ALTER TABLE `legal_ai_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_ai_results_document_id_analysis_type_index` (`document_id`,`analysis_type`),
  ADD KEY `legal_ai_results_case_id_analysis_type_index` (`case_id`,`analysis_type`),
  ADD KEY `legal_ai_results_report_id_analysis_type_index` (`report_id`,`analysis_type`),
  ADD KEY `legal_ai_results_risk_level_compliance_status_index` (`risk_level`,`compliance_status`);

--
-- Indexes for table `legal_audit_logs`
--
ALTER TABLE `legal_audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_cases`
--
ALTER TABLE `legal_cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_cases_case_number_unique` (`case_number`),
  ADD KEY `legal_cases_workflow_stage_index` (`workflow_stage`),
  ADD KEY `legal_cases_investigator_id_index` (`investigator_id`),
  ADD KEY `legal_cases_visitor_id_foreign` (`visitor_id`),
  ADD KEY `idx_legal_cases_status` (`status`),
  ADD KEY `idx_legal_cases_created_at` (`created_at`),
  ADD KEY `idx_legal_cases_resolved_at` (`resolved_at`);

--
-- Indexes for table `legal_case_policy`
--
ALTER TABLE `legal_case_policy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_case_policy_legal_case_id_policy_id_unique` (`legal_case_id`,`policy_id`),
  ADD KEY `legal_case_policy_policy_id_foreign` (`policy_id`);

--
-- Indexes for table `legal_complaints`
--
ALTER TABLE `legal_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_docs`
--
ALTER TABLE `legal_docs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_docs_file_path_unique` (`file_path`);

--
-- Indexes for table `legal_documents`
--
ALTER TABLE `legal_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_documents_status_department_document_type_index` (`status`,`department`,`document_type`);

--
-- Indexes for table `legal_document_obligations`
--
ALTER TABLE `legal_document_obligations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_document_obligations_responsible_person_foreign` (`responsible_person`),
  ADD KEY `legal_document_obligations_due_date_status_index` (`due_date`,`status`),
  ADD KEY `legal_document_obligations_document_id_document_type_index` (`document_id`,`document_type`);

--
-- Indexes for table `legal_document_submissions`
--
ALTER TABLE `legal_document_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_document_submissions_submission_id_unique` (`submission_id`),
  ADD KEY `legal_document_submissions_submitted_by_foreign` (`submitted_by`),
  ADD KEY `legal_document_submissions_assigned_to_foreign` (`assigned_to`),
  ADD KEY `legal_document_submissions_status_department_index` (`status`,`department`),
  ADD KEY `legal_document_submissions_document_type_priority_index` (`document_type`,`priority`);

--
-- Indexes for table `legal_document_templates`
--
ALTER TABLE `legal_document_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_document_templates_created_by_foreign` (`created_by`),
  ADD KEY `legal_document_templates_category_is_active_index` (`category`,`is_active`);

--
-- Indexes for table `legal_document_versions`
--
ALTER TABLE `legal_document_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_document_versions_legal_document_id_foreign` (`legal_document_id`);

--
-- Indexes for table `legal_policies`
--
ALTER TABLE `legal_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legal_report_metrics`
--
ALTER TABLE `legal_report_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_report_metrics_report_date_metric_type_index` (`report_date`,`metric_type`),
  ADD KEY `legal_report_metrics_category_index` (`category`);

--
-- Indexes for table `legal_retention_policies`
--
ALTER TABLE `legal_retention_policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_retention_policies_document_type_unique` (`document_type`);

--
-- Indexes for table `legal_review_actions`
--
ALTER TABLE `legal_review_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_review_actions_legal_document_id_foreign` (`legal_document_id`);

--
-- Indexes for table `legal_submissions`
--
ALTER TABLE `legal_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_submissions_legal_document_id_foreign` (`legal_document_id`);

--
-- Indexes for table `legal_workflow_logs`
--
ALTER TABLE `legal_workflow_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `legal_workflow_logs_performed_by_foreign` (`performed_by`),
  ADD KEY `legal_workflow_logs_document_id_document_type_index` (`document_id`,`document_type`),
  ADD KEY `legal_workflow_logs_action_created_at_index` (`action`,`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_codes_employee_id_otp_code_index` (`employee_id`,`otp_code`),
  ADD KEY `otp_codes_expires_at_index` (`expires_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `policies_slug_unique` (`slug`);

--
-- Indexes for table `policy_acknowledgements`
--
ALTER TABLE `policy_acknowledgements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_acknowledgements_policy_id_user_id_index` (`policy_id`,`user_id`),
  ADD KEY `policy_acknowledgements_policy_id_role_index` (`policy_id`,`role`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_room_id_foreign` (`room_id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Indexes for table `reservation_tasks`
--
ALTER TABLE `reservation_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_tasks_facility_reservation_id_foreign` (`facility_reservation_id`),
  ADD KEY `reservation_tasks_completed_by_foreign` (`completed_by`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_number_unique` (`number`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `show`
--
ALTER TABLE `show`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_consents`
--
ALTER TABLE `user_consents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_consents_user_id_policy_id_version_unique` (`user_id`,`policy_id`,`version`),
  ADD KEY `user_consents_policy_id_foreign` (`policy_id`);

--
-- Indexes for table `violation_reports`
--
ALTER TABLE `violation_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_visitor_time_in` (`time_in`);

--
-- Indexes for table `visitor_batches`
--
ALTER TABLE `visitor_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_batches_created_by_foreign` (`created_by`);

--
-- Indexes for table `visitor_checkin_logs`
--
ALTER TABLE `visitor_checkin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_checkin_logs_visitor_id_action_time_index` (`visitor_id`,`action_time`),
  ADD KEY `visitor_checkin_logs_checked_in_by_action_time_index` (`checked_in_by`,`action_time`);

--
-- Indexes for table `visitor_qr_passes`
--
ALTER TABLE `visitor_qr_passes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitor_qr_passes_pass_code_unique` (`pass_code`),
  ADD KEY `visitor_qr_passes_visitor_id_foreign` (`visitor_id`),
  ADD KEY `visitor_qr_passes_verification_log_id_foreign` (`verification_log_id`),
  ADD KEY `visitor_qr_passes_pass_code_index` (`pass_code`),
  ADD KEY `visitor_qr_passes_status_valid_from_valid_until_index` (`status`,`valid_from`,`valid_until`),
  ADD KEY `visitor_qr_passes_scanned_at_index` (`scanned_at`);

--
-- Indexes for table `visitor_violations`
--
ALTER TABLE `visitor_violations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_violation_audit_logs`
--
ALTER TABLE `visitor_violation_audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_violation_policy`
--
ALTER TABLE `visitor_violation_policy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitor_violation_policy_visitor_violation_id_policy_id_unique` (`visitor_violation_id`,`policy_id`),
  ADD KEY `visitor_violation_policy_policy_id_foreign` (`policy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_logs`
--
ALTER TABLE `access_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1440;

--
-- AUTO_INCREMENT for table `activity_stream`
--
ALTER TABLE `activity_stream`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bulk_visit_sessions`
--
ALTER TABLE `bulk_visit_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `case_activities`
--
ALTER TABLE `case_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `case_dockets`
--
ALTER TABLE `case_dockets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_evidence`
--
ALTER TABLE `case_evidence`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `case_witnesses`
--
ALTER TABLE `case_witnesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_policies`
--
ALTER TABLE `company_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_policy_versions`
--
ALTER TABLE `company_policy_versions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_accounts`
--
ALTER TABLE `department_accounts`
  MODIFY `Dept_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department_logs`
--
ALTER TABLE `department_logs`
  MODIFY `dept_logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `department_table`
--
ALTER TABLE `department_table`
  MODIFY `Department_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dept_audit_trail_&transaction`
--
ALTER TABLE `dept_audit_trail_&transaction`
  MODIFY `a&t_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposal_history`
--
ALTER TABLE `disposal_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;

--
-- AUTO_INCREMENT for table `document_access_logs`
--
ALTER TABLE `document_access_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_activities`
--
ALTER TABLE `document_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `document_activity_logs`
--
ALTER TABLE `document_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_collaborators`
--
ALTER TABLE `document_collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_import_logs`
--
ALTER TABLE `document_import_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `document_retention_policies`
--
ALTER TABLE `document_retention_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_share_invites`
--
ALTER TABLE `document_share_invites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_versions`
--
ALTER TABLE `document_versions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_workflows`
--
ALTER TABLE `document_workflows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_complaints`
--
ALTER TABLE `employee_complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_logs`
--
ALTER TABLE `employee_logs`
  MODIFY `logs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `facility_requests`
--
ALTER TABLE `facility_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `facility_reservations`
--
ALTER TABLE `facility_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `id_verification_logs`
--
ALTER TABLE `id_verification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `legal_ai_analyses`
--
ALTER TABLE `legal_ai_analyses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_ai_results`
--
ALTER TABLE `legal_ai_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_audit_logs`
--
ALTER TABLE `legal_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_cases`
--
ALTER TABLE `legal_cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `legal_case_policy`
--
ALTER TABLE `legal_case_policy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_complaints`
--
ALTER TABLE `legal_complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_docs`
--
ALTER TABLE `legal_docs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_documents`
--
ALTER TABLE `legal_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `legal_document_obligations`
--
ALTER TABLE `legal_document_obligations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_document_submissions`
--
ALTER TABLE `legal_document_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_document_templates`
--
ALTER TABLE `legal_document_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_document_versions`
--
ALTER TABLE `legal_document_versions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `legal_policies`
--
ALTER TABLE `legal_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_report_metrics`
--
ALTER TABLE `legal_report_metrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_retention_policies`
--
ALTER TABLE `legal_retention_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_review_actions`
--
ALTER TABLE `legal_review_actions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_submissions`
--
ALTER TABLE `legal_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legal_workflow_logs`
--
ALTER TABLE `legal_workflow_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `policy_acknowledgements`
--
ALTER TABLE `policy_acknowledgements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation_tasks`
--
ALTER TABLE `reservation_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `show`
--
ALTER TABLE `show`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_consents`
--
ALTER TABLE `user_consents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `violation_reports`
--
ALTER TABLE `violation_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visitor_batches`
--
ALTER TABLE `visitor_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_checkin_logs`
--
ALTER TABLE `visitor_checkin_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `visitor_qr_passes`
--
ALTER TABLE `visitor_qr_passes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_violations`
--
ALTER TABLE `visitor_violations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_violation_audit_logs`
--
ALTER TABLE `visitor_violation_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_violation_policy`
--
ALTER TABLE `visitor_violation_policy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `case_activities`
--
ALTER TABLE `case_activities`
  ADD CONSTRAINT `case_activities_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_dockets`
--
ALTER TABLE `case_dockets`
  ADD CONSTRAINT `case_dockets_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_evidence`
--
ALTER TABLE `case_evidence`
  ADD CONSTRAINT `case_evidence_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `case_witnesses`
--
ALTER TABLE `case_witnesses`
  ADD CONSTRAINT `case_witnesses_legal_case_id_foreign` FOREIGN KEY (`legal_case_id`) REFERENCES `legal_cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_policy_versions`
--
ALTER TABLE `company_policy_versions`
  ADD CONSTRAINT `company_policy_versions_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `company_policies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_archived_by_foreign` FOREIGN KEY (`archived_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_last_accessed_by_foreign` FOREIGN KEY (`last_accessed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_access_logs`
--
ALTER TABLE `document_access_logs`
  ADD CONSTRAINT `document_access_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_access_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_activity_logs`
--
ALTER TABLE `document_activity_logs`
  ADD CONSTRAINT `document_activity_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_import_logs`
--
ALTER TABLE `document_import_logs`
  ADD CONSTRAINT `document_import_logs_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `visitor_batches`
--
ALTER TABLE `visitor_batches`
  ADD CONSTRAINT `visitor_batches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
