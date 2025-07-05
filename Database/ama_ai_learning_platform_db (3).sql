-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2025 at 08:48 AM
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
-- Database: `ama_ai_learning_platform_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_enrollments_tb`
--

CREATE TABLE `class_enrollments_tb` (
  `enrollment_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `st_id` varchar(255) NOT NULL,
  `enrollment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive','completed') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_enrollments_tb`
--

INSERT INTO `class_enrollments_tb` (`enrollment_id`, `class_id`, `st_id`, `enrollment_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'dscscddsds', '2025-06-25 20:48:10', 'active', '2025-06-25 12:48:10', '2025-06-25 12:48:10'),
(2, 4, 'dscscddsds', '2025-06-25 20:50:40', 'active', '2025-06-25 12:50:40', '2025-06-25 12:50:40'),
(3, 2, 'dscscddsds', '2025-06-25 22:04:51', 'active', '2025-06-25 14:04:51', '2025-06-25 14:04:51'),
(4, 3, 'dscscddsds', '2025-06-25 22:05:07', 'active', '2025-06-25 14:05:07', '2025-06-25 14:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `generated_quizzes_tb`
--

CREATE TABLE `generated_quizzes_tb` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `original_quiz_id` int(11) NOT NULL,
  `generation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_options_tb`
--

CREATE TABLE `question_options_tb` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `option_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_options_tb`
--

INSERT INTO `question_options_tb` (`option_id`, `question_id`, `option_text`, `is_correct`, `option_order`) VALUES
(26, 9, 'cdcdc', 1, 0),
(27, 9, 'cdcdcdcd', 0, 1),
(28, 9, 'cdcdcdc', 0, 2),
(29, 10, 'cdcdcdc', 1, 0),
(30, 10, 'cdcd', 0, 1),
(31, 10, 'cdcdc', 0, 2),
(32, 11, 'cdcdc', 1, 0),
(33, 11, 'cdcdccd', 0, 1),
(36, 13, 'ccc', 1, 0),
(37, 13, 'cccc', 0, 1),
(38, 14, 'fefef', 1, 0),
(39, 14, 'efefef', 0, 1),
(40, 15, 'fefefe', 1, 0),
(41, 15, 'fefefe', 0, 1),
(42, 16, 'fefefefefef', 1, 0),
(43, 16, 'fefefefefe', 0, 1),
(90, 40, 'sfsdf', 1, 0),
(91, 40, 'dsfsfsdf', 0, 1),
(92, 41, 'vfvfvf', 1, 0),
(93, 41, 'vfvfvfv', 0, 1),
(94, 42, 'fvfvfv', 1, 0),
(95, 42, 'vfvfvfvfv', 0, 1),
(96, 43, 'ssdd', 1, 0),
(97, 43, 'fsfsf', 0, 1),
(98, 44, 'dsfsdfsdfsdf', 1, 0),
(99, 44, 'dsfsdfsdf', 0, 1),
(220, 85, 'sfsdf', 1, 0),
(221, 85, 'dsfsfsdf', 0, 1),
(222, 86, 'vfvfvf', 1, 0),
(223, 86, 'vfvfvfv', 0, 1),
(224, 87, 'fvfvfv', 1, 0),
(225, 87, 'vfvfvfvfv', 0, 1),
(226, 88, 'ssdd', 1, 0),
(227, 88, 'fsfsf', 0, 1),
(228, 89, 'dsfsdfsdfsdf', 1, 0),
(229, 89, 'dsfsdfsdf', 0, 1),
(230, 90, 'sfsdf', 1, 0),
(231, 90, 'dsfsfsdf', 0, 1),
(232, 91, 'vfvfvf', 1, 0),
(233, 91, 'vfvfvfv', 0, 1),
(234, 92, 'fvfvfv', 1, 0),
(235, 92, 'vfvfvfvfv', 0, 1),
(236, 93, 'ssdd', 1, 0),
(237, 93, 'fsfsf', 0, 1),
(238, 94, 'dsfsdfsdfsdf', 1, 0),
(239, 94, 'dsfsdfsdf', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes_tb`
--

CREATE TABLE `quizzes_tb` (
  `quiz_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `th_id` varchar(255) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `quiz_description` text DEFAULT NULL,
  `quiz_topic` varchar(255) DEFAULT NULL,
  `time_limit` int(11) NOT NULL DEFAULT 30,
  `points_per_question` int(11) NOT NULL DEFAULT 1,
  `shuffle_questions` tinyint(1) NOT NULL DEFAULT 0,
  `show_results` tinyint(1) NOT NULL DEFAULT 1,
  `allow_retakes` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `parent_quiz_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes_tb`
--

INSERT INTO `quizzes_tb` (`quiz_id`, `class_id`, `th_id`, `quiz_title`, `quiz_description`, `quiz_topic`, `time_limit`, `points_per_question`, `shuffle_questions`, `show_results`, `allow_retakes`, `status`, `created_at`, `updated_at`, `parent_quiz_id`) VALUES
(1, 5, 'dsswwww', 'dcdc', 'cdcdc', NULL, 30, 1, 1, 1, 0, 'published', '2025-06-24 17:52:30', '2025-06-24 17:52:30', NULL),
(3, 5, 'dsswwww', 'dcd', 'cdcdcdcdc', NULL, 30, 1, 0, 1, 0, 'published', '2025-06-24 18:08:55', '2025-06-24 18:08:55', NULL),
(4, 4, 'dsswwww', 'dcd', 'cdcdcd', NULL, 30, 1, 0, 1, 0, 'published', '2025-06-24 18:11:08', '2025-06-24 18:11:08', NULL),
(12, 4, 'dsswwww', 'english', 'english', NULL, 30, 1, 0, 1, 1, 'published', '2025-06-26 14:44:30', '2025-06-26 14:44:30', NULL),
(40, 4, 'dsswwww', 'AI Practice: english', 'AI-generated practice quiz based on your previous attempt on \'english\'. This quiz focuses on the concepts you found challenging.', NULL, 30, 1, 0, 1, 0, '', '2025-06-26 16:45:33', '2025-06-26 16:45:33', 12),
(41, 4, 'dsswwww', 'AI Practice: english', 'AI-generated practice quiz based on your previous attempt on \'english\'. This quiz focuses on the concepts you found challenging.', NULL, 30, 1, 0, 1, 0, '', '2025-06-26 16:45:41', '2025-06-26 16:45:41', 12);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts_tb`
--

CREATE TABLE `quiz_attempts_tb` (
  `attempt_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `st_id` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `score` float DEFAULT NULL,
  `status` enum('in-progress','completed','timed-out','abandoned') NOT NULL DEFAULT 'in-progress'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts_tb`
--

INSERT INTO `quiz_attempts_tb` (`attempt_id`, `quiz_id`, `st_id`, `start_time`, `end_time`, `score`, `status`) VALUES
(46, 12, 'dscscddsds', '2025-07-05 14:44:13', '2025-07-05 14:44:22', 0, 'completed'),
(47, 12, 'dscscddsds', '2025-07-05 14:44:32', '2025-07-05 14:44:45', 0, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions_tb`
--

CREATE TABLE `quiz_questions_tb` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_type` enum('multiple-choice','checkbox','true-false','short-answer') NOT NULL,
  `question_text` text NOT NULL,
  `question_points` int(11) NOT NULL DEFAULT 1,
  `question_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions_tb`
--

INSERT INTO `quiz_questions_tb` (`question_id`, `quiz_id`, `question_type`, `question_text`, `question_points`, `question_order`, `created_at`, `updated_at`) VALUES
(9, 3, 'multiple-choice', 'cdcdcd', 1, 0, '2025-06-24 18:08:55', '2025-06-24 18:08:55'),
(10, 3, 'multiple-choice', 'cdcdcd', 1, 1, '2025-06-24 18:08:55', '2025-06-24 18:08:55'),
(11, 1, 'multiple-choice', 'cdcdcd', 1, 0, '2025-06-24 18:09:21', '2025-06-24 18:09:21'),
(13, 4, 'multiple-choice', 'cccc', 1, 0, '2025-06-25 14:33:14', '2025-06-25 14:33:14'),
(14, 4, 'multiple-choice', 'fefefef', 1, 1, '2025-06-25 14:33:14', '2025-06-25 14:33:14'),
(15, 4, 'multiple-choice', 'efefefefefefef', 1, 2, '2025-06-25 14:33:14', '2025-06-25 14:33:14'),
(16, 4, 'multiple-choice', 'fefefef', 1, 3, '2025-06-25 14:33:14', '2025-06-25 14:33:14'),
(40, 12, 'multiple-choice', 'dfs', 1, 0, '2025-06-26 14:44:30', '2025-06-26 14:44:30'),
(41, 12, 'multiple-choice', 'vfvfvfv', 1, 1, '2025-06-26 14:44:30', '2025-06-26 14:44:30'),
(42, 12, 'multiple-choice', 'vfvfvfv', 1, 2, '2025-06-26 14:44:30', '2025-06-26 14:44:30'),
(43, 12, 'multiple-choice', 'ssdsd', 1, 3, '2025-06-26 14:44:30', '2025-06-26 14:44:30'),
(44, 12, 'multiple-choice', 'fdsfsdfsdfsdf', 1, 4, '2025-06-26 14:44:30', '2025-06-26 14:44:30'),
(85, 40, 'multiple-choice', '0', 1, 0, '2025-06-26 16:45:33', '2025-06-26 16:45:33'),
(86, 40, 'multiple-choice', '0', 1, 1, '2025-06-26 16:45:33', '2025-06-26 16:45:33'),
(87, 40, 'multiple-choice', '0', 1, 2, '2025-06-26 16:45:33', '2025-06-26 16:45:33'),
(88, 40, 'multiple-choice', '0', 1, 3, '2025-06-26 16:45:33', '2025-06-26 16:45:33'),
(89, 40, 'multiple-choice', '0', 1, 4, '2025-06-26 16:45:33', '2025-06-26 16:45:33'),
(90, 41, 'multiple-choice', '0', 1, 0, '2025-06-26 16:45:42', '2025-06-26 16:45:42'),
(91, 41, 'multiple-choice', '0', 1, 1, '2025-06-26 16:45:42', '2025-06-26 16:45:42'),
(92, 41, 'multiple-choice', '0', 1, 2, '2025-06-26 16:45:42', '2025-06-26 16:45:42'),
(93, 41, 'multiple-choice', '0', 1, 3, '2025-06-26 16:45:42', '2025-06-26 16:45:42'),
(94, 41, 'multiple-choice', '0', 1, 4, '2025-06-26 16:45:42', '2025-06-26 16:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `short_answer_tb`
--

CREATE TABLE `short_answer_tb` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct_answer` text NOT NULL,
  `case_sensitive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_profiles_tb`
--

CREATE TABLE `students_profiles_tb` (
  `id` int(11) NOT NULL,
  `st_id` varchar(255) NOT NULL,
  `st_userName` varchar(255) NOT NULL,
  `st_email` varchar(255) NOT NULL,
  `st_position` varchar(255) NOT NULL,
  `st_studentdPassword` varchar(255) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `grade_level` varchar(20) NOT NULL,
  `strand` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_profiles_tb`
--

INSERT INTO `students_profiles_tb` (`id`, `st_id`, `st_userName`, `st_email`, `st_position`, `st_studentdPassword`, `student_id`, `grade_level`, `strand`, `created_at`, `updated_at`) VALUES
(1, 'dscscddsds', 'cscsdc', 'sadasss@gmail.com', 'student', '$2y$10$lBBNkD/OnOXeauOOliefhOkgfo0aOOJ57OhFAyxgjp84bK6wOBaLy', 'dscscddsds', 'grade_11', 'stem', '2025-06-24 13:25:01', '2025-06-24 13:25:01'),
(2, 'ccssssssssssssss', 'scccccccccccccccccccccccccc', 'sadddcssssssssssas@gmail.com', 'student', '$2y$10$AjNjz.djKJPf/Pa23Ubdo.Fc1MWSlJj3OvKF5MvLvfWqLAAbH3iCu', 'ccssssssssssssss', 'grade_11', 'stem', '2025-06-24 14:06:01', '2025-06-24 14:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `student_answers_tb`
--

CREATE TABLE `student_answers_tb` (
  `answer_id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_options` text DEFAULT NULL,
  `text_answer` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `points_awarded` float DEFAULT NULL,
  `answered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_answers_tb`
--

INSERT INTO `student_answers_tb` (`answer_id`, `attempt_id`, `question_id`, `selected_options`, `text_answer`, `is_correct`, `points_awarded`, `answered_at`) VALUES
(199, 46, 40, '91', NULL, 0, 0, '2025-07-05 14:44:22'),
(200, 46, 41, '93', NULL, 0, 0, '2025-07-05 14:44:22'),
(201, 46, 42, '95', NULL, 0, 0, '2025-07-05 14:44:22'),
(202, 46, 43, '97', NULL, 0, 0, '2025-07-05 14:44:22'),
(203, 46, 44, '99', NULL, 0, 0, '2025-07-05 14:44:22'),
(204, 47, 40, '91', NULL, 0, 0, '2025-07-05 14:44:45'),
(205, 47, 41, '93', NULL, 0, 0, '2025-07-05 14:44:45'),
(206, 47, 42, '95', NULL, 0, 0, '2025-07-05 14:44:45'),
(207, 47, 43, '97', NULL, 0, 0, '2025-07-05 14:44:45'),
(208, 47, 44, '99', NULL, 0, 0, '2025-07-05 14:44:45');

-- --------------------------------------------------------

--
-- Table structure for table `teachers_profiles_tb`
--

CREATE TABLE `teachers_profiles_tb` (
  `id` int(11) NOT NULL,
  `th_id` varchar(255) NOT NULL,
  `th_userName` varchar(255) NOT NULL,
  `th_Email` varchar(255) NOT NULL,
  `th_position` varchar(255) NOT NULL,
  `th_teacherPasswor` varchar(255) NOT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `subject_expertise` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_profiles_tb`
--

INSERT INTO `teachers_profiles_tb` (`id`, `th_id`, `th_userName`, `th_Email`, `th_position`, `th_teacherPasswor`, `employee_id`, `department`, `subject_expertise`, `created_at`, `updated_at`) VALUES
(1, 'TC202506249196', 'aasd', 'as@gmail.com', 'teacher', '$2y$10$4cbmEBrMPZiycHFxaKt9auvL8AwKuzd7QTEYachQoHC/mh/Ec.hy6', 'dwdwdwed', 'guidance', 'fsdfsdf', '2025-06-24 12:16:14', '2025-06-24 12:16:14'),
(2, 'dwdwdwed', 'aasd', 'sadas@gmail.com', 'teacher', '$2y$10$F2dGhHYD.nrKsYcwYWqzrOcnEC21jC/UzNAMAGvql6pKRdgYgXYBC', NULL, 'guidance', 'fsdfsdf', '2025-06-24 12:38:06', '2025-06-24 12:38:06'),
(3, 'dwdwdwedddd', 'aasd', 'saddddas@gmail.com', 'teacher', '$2y$10$azq7dlEACHMf59.JFGKRA.qH/ZJOtIFBmPDvIsFxB.8Lx8QbG1v02', NULL, 'pe_health', 'c', '2025-06-24 12:44:24', '2025-06-24 12:44:24'),
(4, 'dwdwdwedc', 'aasdc', 'ascc@gmail.com', 'teacher', '$2y$10$sJmmWyh6KLzLDsUH2vaNwuOBUFV3xHa8MgNnW9n.lvCpxddvGqRzO', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:02:55', '2025-06-24 13:02:55'),
(5, 'dwdwdwedee', 'aasd', 'sadddas@gmail.com', 'teacher', '$2y$10$L4zWcx15mguIV7h2DOrkLuUDWzrygOHwPyHR.GPGRL.MOaLcZU6W2', NULL, 'guidance', 'fsdfsdf', '2025-06-24 13:10:54', '2025-06-24 13:10:54'),
(6, 'cscsdcdscsdcs', 'cscsdc', 'addds@gmail.com', 'teacher', '$2y$10$GeyLQDAFDatTiUz/qFqumOCsYtT//P61x3R.dFY7GVMf.KjjPwOjO', NULL, 'arts', 'fsdfsdf', '2025-06-24 13:44:39', '2025-06-24 13:44:39'),
(7, 'cscsdcdscsdcsddd', 'cscsdc', 'adddds@gmail.com', 'teacher', '$2y$10$/331bWfq8cYhJPKrE4.XDOd1s9q//5bWijyx3XHb87xyyW07zS5ue', NULL, 'arts', 'fsdfsdf', '2025-06-24 13:44:53', '2025-06-24 13:44:53'),
(8, 'cscscscscscscs', 'cscscsc', 'sadaccccs@gmail.com', 'teacher', '$2y$10$sqFa5HgtGzsX7Nke7OWIoOJiQQkovjgyWGT2q8vTkPzBVKJ.0cg6O', NULL, 'pe_health', 'scsscs', '2025-06-24 13:45:34', '2025-06-24 13:45:34'),
(9, 'vvvvvvvvvvvv', 'vvvvvvvvvv', 'sadvvvvas@gmail.com', 'teacher', '$2y$10$DNbah9EhjuNyIs0w8unIJerSgjsVQ02F8Y3WderOvPUFzv/VAxT6W', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:48:13', '2025-06-24 13:48:13'),
(10, 'vvvvvvvvvvvvss', 'vvvvvvvvvv', 'sadvvvvssas@gmail.com', 'teacher', '$2y$10$BCJQfZSZ7QrJKO/laEMyguDFi.nKyU1UojheI9jEWk0G3gz9N1r42', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:48:32', '2025-06-24 13:48:32'),
(11, 'vvvvvvvvvvvvssd', 'vvvvvvvvvvd', 'sadvvvvssadds@gmail.com', 'teacher', '$2y$10$wvoyCnSpzlDXbEVyq8YoXu7NWMB0ZXgqpZkMxswC7DKL45mrexkWG', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:48:43', '2025-06-24 13:48:43'),
(12, 'frfrfrfrfrfrf', 'cscsdcfrfrf', 'srrradddas@gmail.com', 'teacher', '$2y$10$R40aogxW3YjSyyqxAlN7zunj2FeV0pzyewBKNy6xdcLaVdfdKfEya', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:51:41', '2025-06-24 13:51:41'),
(13, 'frfrfrfrfrfrfdd', 'cscsdcfrfrfdd', 'srrraddsddas@gmail.com', 'teacher', '$2y$10$tzuHSeegckr5p1HBfq0L3O0uyOeQoSKw0yWyUmyh2aGd.z2fzSmdq', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:51:52', '2025-06-24 13:51:52'),
(14, 'dsssfsdddddddd', 'asdddddddd', 'saddddddddddas@gmail.com', 'teacher', '$2y$10$6.i7yPjLkiLJ3dUJWQgP..umKw6adDWCbCdZtcbFRw.S3eGwYwD/W', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 13:52:07', '2025-06-24 13:52:07'),
(15, 'addddddddddddddd', 'aaaaaaaaaadddddddddddddd', 'saddadddddddas@gmail.com', 'teacher', '$2y$10$xHsAJiUerfG8gZasi5JaE.bu9W4xlpvyWyx3MoTbPN7qONARskfIW', NULL, 'arts', 'fsdfsdf', '2025-06-24 13:53:25', '2025-06-24 13:53:25'),
(16, 'csssssssssssssssssss', 'csssssssssssss', 'sadcssssssssssas@gmail.com', 'teacher', '$2y$10$7d7krp8j9YgG.dOpOYcRNuoHm2EPID2j8NLqGGAprFIIURp2lOthK', NULL, 'arts', 'sccccccccccccc', '2025-06-24 14:05:29', '2025-06-24 14:05:29'),
(17, 'dsswwww', 'sss', 'wwwww@gmail.com', 'teacher', '$2y$10$mWvcUJ81oe.gyo8tHMBTPuoWmKWIf5qWNXhV8q.O1GufdV2ydhwZu', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 16:01:09', '2025-06-24 16:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes_tb`
--

CREATE TABLE `teacher_classes_tb` (
  `class_id` int(11) NOT NULL,
  `th_id` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_code` varchar(10) NOT NULL,
  `class_description` text DEFAULT NULL,
  `grade_level` varchar(20) NOT NULL,
  `strand` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive','archived') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_classes_tb`
--

INSERT INTO `teacher_classes_tb` (`class_id`, `th_id`, `class_name`, `class_code`, `class_description`, `grade_level`, `strand`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dsswwww', 'cscsdcsdc', 'CJ6X2L', 'csdcsdcs', '11', 'TVL-ICT', 'active', '2025-06-24 16:10:32', '2025-06-24 16:10:32'),
(2, 'dsswwww', 'scscsc', 'K4NVYK', 'cscsc', '11', 'TVL-ICT', 'active', '2025-06-24 16:10:51', '2025-06-24 16:10:51'),
(3, 'dsswwww', 'sasa', 'assasasa', 'sasasas', '11', 'TVL-HE', 'active', '2025-06-24 16:11:25', '2025-06-24 16:11:25'),
(4, 'dsswwww', 'ccsc', 'scscsdcsdc', 'dcscsdcsdc', '11', 'HUMSS', 'active', '2025-06-24 16:23:31', '2025-06-24 16:23:31'),
(5, 'dsswwww', 'xcvbn', 'gddfgdf', 'dfgfdgdfg', '11', 'TVL-HE', 'active', '2025-06-24 16:36:57', '2025-06-24 16:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPosition` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`id`, `user_id`, `userName`, `userEmail`, `userPosition`, `userPassword`, `created_at`, `updated_at`) VALUES
(1, 'TC202506249196', 'aasd', 'as@gmail.com', 'teacher', '$2y$10$4cbmEBrMPZiycHFxaKt9auvL8AwKuzd7QTEYachQoHC/mh/Ec.hy6', '2025-06-24 12:16:14', '2025-06-24 12:16:14'),
(2, 'TC202506247915', 'aasd', 'sadas@gmail.com', 'teacher', '$2y$10$F2dGhHYD.nrKsYcwYWqzrOcnEC21jC/UzNAMAGvql6pKRdgYgXYBC', '2025-06-24 12:38:06', '2025-06-24 12:38:06'),
(3, 'TC202506244797', 'aasd', 'saddddas@gmail.com', 'teacher', '$2y$10$azq7dlEACHMf59.JFGKRA.qH/ZJOtIFBmPDvIsFxB.8Lx8QbG1v02', '2025-06-24 12:44:24', '2025-06-24 12:44:24'),
(4, 'TC202506244808', 'aasdc', 'ascc@gmail.com', 'teacher', '$2y$10$sJmmWyh6KLzLDsUH2vaNwuOBUFV3xHa8MgNnW9n.lvCpxddvGqRzO', '2025-06-24 13:02:55', '2025-06-24 13:02:55'),
(5, 'TC202506247865', 'aasd', 'sadddas@gmail.com', 'teacher', '$2y$10$L4zWcx15mguIV7h2DOrkLuUDWzrygOHwPyHR.GPGRL.MOaLcZU6W2', '2025-06-24 13:10:54', '2025-06-24 13:10:54'),
(6, 'ST202506244745', 'cscsdc', 'sadasss@gmail.com', 'student', '$2y$10$lBBNkD/OnOXeauOOliefhOkgfo0aOOJ57OhFAyxgjp84bK6wOBaLy', '2025-06-24 13:25:01', '2025-06-24 13:25:01'),
(7, 'TC202506247295', 'cscsdc', 'addds@gmail.com', 'teacher', '$2y$10$GeyLQDAFDatTiUz/qFqumOCsYtT//P61x3R.dFY7GVMf.KjjPwOjO', '2025-06-24 13:44:39', '2025-06-24 13:44:39'),
(8, 'TC202506248905', 'cscsdc', 'adddds@gmail.com', 'teacher', '$2y$10$/331bWfq8cYhJPKrE4.XDOd1s9q//5bWijyx3XHb87xyyW07zS5ue', '2025-06-24 13:44:53', '2025-06-24 13:44:53'),
(9, 'TC202506246546', 'cscscsc', 'sadaccccs@gmail.com', 'teacher', '$2y$10$sqFa5HgtGzsX7Nke7OWIoOJiQQkovjgyWGT2q8vTkPzBVKJ.0cg6O', '2025-06-24 13:45:34', '2025-06-24 13:45:34'),
(10, 'TC202506245754', 'vvvvvvvvvv', 'sadvvvvas@gmail.com', 'teacher', '$2y$10$DNbah9EhjuNyIs0w8unIJerSgjsVQ02F8Y3WderOvPUFzv/VAxT6W', '2025-06-24 13:48:12', '2025-06-24 13:48:12'),
(11, 'TC202506248325', 'vvvvvvvvvv', 'sadvvvvssas@gmail.com', 'teacher', '$2y$10$BCJQfZSZ7QrJKO/laEMyguDFi.nKyU1UojheI9jEWk0G3gz9N1r42', '2025-06-24 13:48:32', '2025-06-24 13:48:32'),
(12, 'TC202506249325', 'vvvvvvvvvvd', 'sadvvvvssadds@gmail.com', 'teacher', '$2y$10$wvoyCnSpzlDXbEVyq8YoXu7NWMB0ZXgqpZkMxswC7DKL45mrexkWG', '2025-06-24 13:48:43', '2025-06-24 13:48:43'),
(13, 'TC202506248871', 'cscsdcfrfrf', 'srrradddas@gmail.com', 'teacher', '$2y$10$R40aogxW3YjSyyqxAlN7zunj2FeV0pzyewBKNy6xdcLaVdfdKfEya', '2025-06-24 13:51:41', '2025-06-24 13:51:41'),
(14, 'TC202506243617', 'cscsdcfrfrfdd', 'srrraddsddas@gmail.com', 'teacher', '$2y$10$tzuHSeegckr5p1HBfq0L3O0uyOeQoSKw0yWyUmyh2aGd.z2fzSmdq', '2025-06-24 13:51:52', '2025-06-24 13:51:52'),
(15, 'TC202506242260', 'asdddddddd', 'saddddddddddas@gmail.com', 'teacher', '$2y$10$6.i7yPjLkiLJ3dUJWQgP..umKw6adDWCbCdZtcbFRw.S3eGwYwD/W', '2025-06-24 13:52:07', '2025-06-24 13:52:07'),
(16, 'TC202506246112', 'aaaaaaaaaadddddddddddddd', 'saddadddddddas@gmail.com', 'teacher', '$2y$10$xHsAJiUerfG8gZasi5JaE.bu9W4xlpvyWyx3MoTbPN7qONARskfIW', '2025-06-24 13:53:25', '2025-06-24 13:53:25'),
(17, 'TC202506243189', 'csssssssssssss', 'sadcssssssssssas@gmail.com', 'teacher', '$2y$10$7d7krp8j9YgG.dOpOYcRNuoHm2EPID2j8NLqGGAprFIIURp2lOthK', '2025-06-24 14:05:29', '2025-06-24 14:05:29'),
(18, 'ST202506244730', 'scccccccccccccccccccccccccc', 'sadddcssssssssssas@gmail.com', 'student', '$2y$10$AjNjz.djKJPf/Pa23Ubdo.Fc1MWSlJj3OvKF5MvLvfWqLAAbH3iCu', '2025-06-24 14:06:01', '2025-06-24 14:06:01'),
(19, 'TC202506245225', 'sss', 'wwwww@gmail.com', 'teacher', '$2y$10$mWvcUJ81oe.gyo8tHMBTPuoWmKWIf5qWNXhV8q.O1GufdV2ydhwZu', '2025-06-24 16:01:09', '2025-06-24 16:01:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `class_student_unique` (`class_id`,`st_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `original_quiz_id` (`original_quiz_id`);

--
-- Indexes for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `th_id` (`th_id`),
  ADD KEY `parent_quiz_fk` (`parent_quiz_id`);

--
-- Indexes for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `students_profiles_tb`
--
ALTER TABLE `students_profiles_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `st_id` (`st_id`),
  ADD UNIQUE KEY `st_email` (`st_email`);

--
-- Indexes for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `teachers_profiles_tb`
--
ALTER TABLE `teachers_profiles_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `th_id` (`th_id`),
  ADD UNIQUE KEY `th_Email` (`th_Email`);

--
-- Indexes for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `class_code` (`class_code`),
  ADD KEY `th_id` (`th_id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students_profiles_tb`
--
ALTER TABLE `students_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `teachers_profiles_tb`
--
ALTER TABLE `teachers_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD CONSTRAINT `class_enrollments_class_fk` FOREIGN KEY (`class_id`) REFERENCES `teacher_classes_tb` (`class_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_enrollments_student_fk` FOREIGN KEY (`st_id`) REFERENCES `students_profiles_tb` (`st_id`) ON DELETE CASCADE;

--
-- Constraints for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  ADD CONSTRAINT `generated_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes_tb` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `original_quiz_fk` FOREIGN KEY (`original_quiz_id`) REFERENCES `quizzes_tb` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  ADD CONSTRAINT `options_question_fk` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions_tb` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  ADD CONSTRAINT `parent_quiz_fk` FOREIGN KEY (`parent_quiz_id`) REFERENCES `quizzes_tb` (`quiz_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quizzes_class_fk` FOREIGN KEY (`class_id`) REFERENCES `teacher_classes_tb` (`class_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  ADD CONSTRAINT `attempts_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes_tb` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  ADD CONSTRAINT `questions_quiz_fk` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes_tb` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  ADD CONSTRAINT `shortanswer_question_fk` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions_tb` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  ADD CONSTRAINT `answers_attempt_fk` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts_tb` (`attempt_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_question_fk` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions_tb` (`question_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
