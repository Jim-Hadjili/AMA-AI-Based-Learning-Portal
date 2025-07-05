-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2025 at 04:17 PM
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
-- Table structure for table `classes_tb`
--

CREATE TABLE `classes_tb` (
  `class_id` varchar(50) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_subject` varchar(255) NOT NULL,
  `class_description` text DEFAULT NULL,
  `class_code` varchar(10) NOT NULL,
  `class_color` varchar(100) DEFAULT 'bg-gradient-to-br from-blue-500 to-indigo-700',
  `teacher_id` varchar(50) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'ccssssssssssssss', 'scccccccccccccccccccccccccc', 'sadddcssssssssssas@gmail.com', 'student', '$2y$10$AjNjz.djKJPf/Pa23Ubdo.Fc1MWSlJj3OvKF5MvLvfWqLAAbH3iCu', 'ccssssssssssssss', 'grade_11', 'stem', '2025-06-24 14:06:01', '2025-06-24 14:06:01'),
(3, 'ST202507057230', 'fsfsdfsdfsfsdfsdf', 'wwwsdfsdfsdfsdfsdfww@gmail.com', 'student', '$2y$10$RjZfneR9w/WCnqxHsj1z9O.fiYbceQhkSlFggyaE4vnh7dkNAH/YW', 'dsfsfsfsfsdf', 'grade_11', 'stem', '2025-07-05 11:34:44', '2025-07-05 11:34:44');

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
(17, 'dsswwww', 'sss', 'wwwww@gmail.com', 'teacher', '$2y$10$mWvcUJ81oe.gyo8tHMBTPuoWmKWIf5qWNXhV8q.O1GufdV2ydhwZu', NULL, 'pe_health', 'fsdfsdf', '2025-06-24 16:01:09', '2025-06-24 16:01:09'),
(18, 'sdfsdfsdfsdfs', 'sdfsfsdfsf', 'wwwfsfsdfww@gmail.com', 'teacher', '$2y$10$mbyIKlH4Fi2V51.utz/St.m55RQw1CWQSbW7RIxKuq.B3pqB6QBRK', NULL, 'arts', 'sdfsfsfsdfsfs', '2025-07-05 11:34:30', '2025-07-05 11:34:30');

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
(15, 'TC202506245225', 'Math', '1A94WP', 'dsdsd', '11', 'TVL-ICT', 'active', '2025-07-05 13:34:51', '2025-07-05 13:34:51'),
(16, 'TC202506245225', 'dsds', 'QWFES9', 'dsdsd', '11', 'GAS', 'active', '2025-07-05 13:40:34', '2025-07-05 13:40:34'),
(17, 'TC202506245225', 'dsdsdsd', 'QAX2LU', 'dsdsdsds', '11', 'TVL-HE', 'active', '2025-07-05 13:40:43', '2025-07-05 13:40:43'),
(18, 'TC202506245225', 'cxzczczc', 'GPQEOG', 'czxczxczczc', '11', 'TVL-ICT', 'active', '2025-07-05 13:40:51', '2025-07-05 13:40:51'),
(19, 'TC202506245225', 'zxczczxczxcz', '4LQGG4', 'zxczczx', '11', 'TVL-ICT', 'active', '2025-07-05 13:41:02', '2025-07-05 13:41:02'),
(20, 'TC202506245225', 'englihs', 'FEFV7O', 'fsdfdsfsf', '11', 'TVL-ICT', 'active', '2025-07-05 13:41:11', '2025-07-05 13:41:11'),
(21, 'TC202506245225', 'cxvsdsdfsdfs', 'OLEW79', '', '11', 'TVL-ICT', 'active', '2025-07-05 13:41:20', '2025-07-05 13:41:20'),
(22, 'TC202506245225', 'sdsda', 'Y4WPTY', 'dadasda', '11', 'TVL-ICT', 'active', '2025-07-05 14:07:26', '2025-07-05 14:07:26'),
(23, 'TC202506245225', 'dasdasdad', 'DDTH2S', 'dadasdasd', '11', 'TVL-ICT', 'active', '2025-07-05 14:07:35', '2025-07-05 14:07:35'),
(24, 'TC202506245225', 'dsadadasdad', '6U583M', 'sdadad', '11', 'TVL-ICT', 'active', '2025-07-05 14:07:44', '2025-07-05 14:07:44');

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
(19, 'TC202506245225', 'sss', 'wwwww@gmail.com', 'teacher', '$2y$10$mWvcUJ81oe.gyo8tHMBTPuoWmKWIf5qWNXhV8q.O1GufdV2ydhwZu', '2025-06-24 16:01:09', '2025-06-24 16:01:09'),
(20, 'TC202507058635', 'sdfsfsdfsf', 'wwwfsfsdfww@gmail.com', 'teacher', '$2y$10$mbyIKlH4Fi2V51.utz/St.m55RQw1CWQSbW7RIxKuq.B3pqB6QBRK', '2025-07-05 11:34:30', '2025-07-05 11:34:30'),
(21, 'ST202507057230', 'fsfsdfsdfsfsdfsdf', 'wwwsdfsdfsdfsdfsdfww@gmail.com', 'student', '$2y$10$RjZfneR9w/WCnqxHsj1z9O.fiYbceQhkSlFggyaE4vnh7dkNAH/YW', '2025-07-05 11:34:44', '2025-07-05 11:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `session_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes_tb`
--
ALTER TABLE `classes_tb`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

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
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `teachers_profiles_tb`
--
ALTER TABLE `teachers_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes_tb`
--
ALTER TABLE `classes_tb`
  ADD CONSTRAINT `classes_tb_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users_tb` (`user_id`);

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

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_tb` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
