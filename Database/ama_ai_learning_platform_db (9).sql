-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 04:51 PM
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
-- Table structure for table `announcements_tb`
--

CREATE TABLE `announcements_tb` (
  `announcement_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `class_enrollments_tb`
--

CREATE TABLE `class_enrollments_tb` (
  `enrollment_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `st_id` varchar(50) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive','pending') DEFAULT 'active'
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
-- Table structure for table `learning_materials_tb`
--

CREATE TABLE `learning_materials_tb` (
  `material_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `material_title` varchar(255) NOT NULL,
  `material_description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `file_type` varchar(20) NOT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learning_materials_tb`
--

INSERT INTO `learning_materials_tb` (`material_id`, `class_id`, `teacher_id`, `material_title`, `material_description`, `file_path`, `file_name`, `file_size`, `file_type`, `upload_date`) VALUES
(17, 26, 'TC202507086492', 'dddddgfgdg', '', 'Uploads/Materials/26/6872652b51f82_SYSTEM-SPECS (1) (4).pdf', 'SYSTEM-SPECS (1) (4).pdf', 155094, 'pdf', '2025-07-12 21:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications_tb`
--

CREATE TABLE `notifications_tb` (
  `notification_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `user_type` enum('student','teacher') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
(5, 123, '1', 0, 1),
(6, 123, '2', 1, 2),
(7, 123, '3', 0, 3),
(8, 123, '4', 0, 4),
(9, 124, 'dsfsd', 0, 1),
(10, 124, 'fdfsd', 0, 2),
(11, 124, 'dfsdf', 0, 3),
(12, 124, 'fsdf', 1, 4);

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
(62, 25, 'TC202506245225', 'Math', 'Example', NULL, 30, 1, 0, 1, 0, 'published', '2025-07-08 13:14:38', '2025-07-08 13:14:38', NULL),
(63, 25, 'TC202506245225', 'Math', 'Example', NULL, 30, 1, 0, 1, 0, 'published', '2025-07-08 13:14:38', '2025-07-08 13:14:38', NULL),
(64, 25, 'TC202506245225', 'Math', 'sss', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:14:58', '2025-07-08 13:14:58', NULL),
(65, 25, 'TC202506245225', 'Math', 'sss', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:14:58', '2025-07-08 13:14:58', NULL),
(66, 26, 'TC202507086492', 'Math', 'Example', NULL, 30, 1, 0, 1, 0, 'published', '2025-07-08 13:30:08', '2025-07-08 13:30:20', NULL),
(67, 26, 'TC202507086492', 'Math', 'fdsfsd', NULL, 30, 1, 0, 1, 0, 'published', '2025-07-08 13:30:38', '2025-07-08 13:30:45', NULL),
(68, 26, 'TC202507086492', 'fsdfs', 'fdsfsdf', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:30:50', '2025-07-08 13:30:50', NULL),
(69, 26, 'TC202507086492', 'cdsc', 'dcsdc', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:30:59', '2025-07-08 13:30:59', NULL),
(70, 26, 'TC202507086492', 'fsdfsdf', 'fsdfsdfsdf', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:05', '2025-07-08 13:31:05', NULL),
(71, 26, 'TC202507086492', 'sdvdsvdvs', 'vsdv', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:11', '2025-07-08 13:31:11', NULL),
(72, 26, 'TC202507086492', 'vdfvdfvdfv', 'vdfvdfv', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:17', '2025-07-08 13:31:17', NULL),
(73, 26, 'TC202507086492', 'vdvd', 'vdvdvdv', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:24', '2025-07-08 13:31:24', NULL),
(74, 26, 'TC202507086492', 'cds', 'dgdsgsdgsd', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:31', '2025-07-08 13:31:31', NULL),
(75, 26, 'TC202507086492', 'fdgdfgdfg', 'gdfgdfg', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:37', '2025-07-08 13:31:37', NULL),
(76, 26, 'TC202507086492', 'sd', 'csdcsdc', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:31:46', '2025-07-08 13:31:46', NULL),
(77, 26, 'TC202507086492', 'dddd', 'dddddddddddddddddddddddddddddd', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:51:21', '2025-07-08 13:51:21', NULL),
(78, 26, 'TC202507086492', 'sssssssssss', 's', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:53:02', '2025-07-08 13:53:02', NULL),
(79, 26, 'TC202507086492', 's', 'sssssssssssss', NULL, 30, 1, 0, 1, 0, 'draft', '2025-07-08 13:53:19', '2025-07-08 13:53:19', NULL);

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

--
-- Dumping data for table `quiz_questions_tb`
--

INSERT INTO `quiz_questions_tb` (`question_id`, `quiz_id`, `question_type`, `question_text`, `question_points`, `question_order`, `created_at`, `updated_at`) VALUES
(123, 66, 'multiple-choice', 'Example', 1, 1, '2025-07-08 13:30:20', '2025-07-08 13:30:20'),
(124, 67, 'multiple-choice', 'fdsfsdf', 1, 1, '2025-07-08 13:30:45', '2025-07-08 13:30:45');

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
(19, 'Test123', 'Jim Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$OejyD15ERiLYWcHBV5jNiOC6I9WSFba.AVlpQ1jFpMMjo3SeyK5ja', NULL, 'ict', 'ICT', '2025-07-08 13:23:49', '2025-07-08 13:23:49');

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
(25, 'TC202506245225', 'Math', '3MBCKJ', 'Example', '12', 'STEM', 'active', '2025-07-08 13:02:55', '2025-07-08 13:02:55'),
(26, 'TC202507086492', 'Math', 'CNG5IB', 'Example', '12', 'TVL-ICT', 'active', '2025-07-08 13:24:23', '2025-07-08 13:24:23');

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
(22, 'TC202507086492', 'Jim Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$OejyD15ERiLYWcHBV5jNiOC6I9WSFba.AVlpQ1jFpMMjo3SeyK5ja', '2025-07-08 13:23:49', '2025-07-08 13:23:49');

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
-- Indexes for table `announcements_tb`
--
ALTER TABLE `announcements_tb`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `classes_tb`
--
ALTER TABLE `classes_tb`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `original_quiz_id` (`original_quiz_id`);

--
-- Indexes for table `learning_materials_tb`
--
ALTER TABLE `learning_materials_tb`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `idx_user` (`user_id`,`user_type`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_read` (`is_read`),
  ADD KEY `idx_created_at` (`created_at`);

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
-- AUTO_INCREMENT for table `announcements_tb`
--
ALTER TABLE `announcements_tb`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `learning_materials_tb`
--
ALTER TABLE `learning_materials_tb`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes_tb`
--
ALTER TABLE `classes_tb`
  ADD CONSTRAINT `classes_tb_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users_tb` (`user_id`);

--
-- Constraints for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD CONSTRAINT `class_enrollments_tb_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `teacher_classes_tb` (`class_id`) ON DELETE CASCADE;

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
