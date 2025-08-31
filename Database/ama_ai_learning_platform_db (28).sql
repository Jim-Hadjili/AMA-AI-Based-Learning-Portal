-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2025 at 04:53 PM
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
-- Table structure for table `class_enrollments_tb`
--

CREATE TABLE `class_enrollments_tb` (
  `enrollment_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `st_id` varchar(50) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `grade_level` varchar(50) DEFAULT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive','pending') DEFAULT 'active',
  `strand` varchar(50) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_enrollments_tb`
--

INSERT INTO `class_enrollments_tb` (`enrollment_id`, `class_id`, `st_id`, `student_name`, `student_email`, `grade_level`, `enrollment_date`, `status`, `strand`, `student_id`) VALUES
(1, 1, 'ST202508319422', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', '2025-08-31 14:17:19', 'active', 'STEM', '12345');

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
(1, 1, 'Run', 0, 1),
(2, 1, 'Happy', 0, 2),
(3, 1, 'Book', 1, 3),
(4, 1, 'Quickly', 0, 4),
(5, 2, 'Went', 1, 1),
(6, 2, 'Goed', 0, 2),
(7, 2, 'Going', 0, 3),
(8, 2, 'Goes', 0, 4),
(9, 3, 'She play football.', 0, 1),
(10, 3, 'She plays football.', 1, 2),
(11, 3, 'She playing football.', 0, 3),
(12, 3, 'She played footballs.', 0, 4),
(13, 4, 'Dog', 0, 1),
(14, 4, 'Fast', 1, 2),
(15, 4, 'Eat', 0, 3),
(16, 4, 'Run', 0, 4),
(17, 5, 'Warm', 0, 1),
(18, 5, 'Cold', 0, 2),
(19, 5, 'Heat', 0, 3),
(20, 5, 'Cold', 1, 4),
(21, 6, 'childen', 0, 1),
(22, 6, 'children', 1, 2),
(23, 6, 'childs', 0, 3),
(24, 6, 'childs\'s', 0, 4),
(25, 7, 'At the beginning of a sentence', 0, 1),
(26, 7, 'In the middle of a sentence', 0, 2),
(27, 7, 'At the end of a sentence', 1, 3),
(28, 7, 'After a comma', 0, 4),
(29, 8, 'I love', 0, 1),
(30, 8, 'I love reading books', 1, 2),
(31, 8, 'Love reading', 0, 3),
(32, 8, 'Reading', 0, 4),
(33, 9, 'Does', 0, 1),
(34, 9, 'Do', 1, 2),
(35, 9, 'Does do', 0, 3),
(36, 9, 'Do\'s', 0, 4),
(37, 10, 'Table', 0, 1),
(38, 10, 'Walk', 1, 2),
(39, 10, 'Red', 0, 3),
(40, 10, 'Smile', 0, 4),
(41, 11, 'I am eating an apple.', 1, 1),
(42, 11, 'I eats an apple.', 0, 2),
(43, 11, 'I eated an apple.', 0, 3),
(44, 11, 'I eats an apple.', 0, 4),
(45, 12, 'cats', 1, 1),
(46, 12, 'catss', 0, 2),
(47, 12, 'cat', 0, 3),
(48, 12, 'cat,s', 0, 4),
(49, 13, 'She', 0, 1),
(50, 13, 'In', 1, 2),
(51, 13, 'The', 0, 3),
(52, 13, 'Book', 0, 4),
(53, 14, 'Subject', 0, 1),
(54, 14, 'Verb', 0, 2),
(55, 14, 'Article', 1, 3),
(56, 14, 'Noun', 0, 4),
(57, 15, 'If', 0, 1),
(58, 15, 'If am', 0, 2),
(59, 15, 'I\'m', 1, 3),
(60, 15, 'Im', 0, 4),
(61, 16, 'The dogs barks.', 0, 1),
(62, 16, 'The dogs bark.', 1, 2),
(63, 16, 'The dog barks.', 0, 3),
(64, 16, 'The dogs are barks.', 0, 4),
(65, 17, 'I want fall asleep.', 0, 1),
(66, 17, 'I want falls asleep.', 0, 2),
(67, 17, 'I want falling asleep.', 0, 3),
(68, 17, 'I want to fall asleep.', 1, 4),
(69, 18, 'Noun', 0, 1),
(70, 18, 'Verb', 1, 2),
(71, 18, 'Adjective', 0, 3),
(72, 18, 'Adverb', 0, 4),
(73, 19, 'I eat apples', 0, 1),
(74, 19, 'She runs', 1, 2),
(75, 19, 'They study', 0, 3),
(76, 19, 'He sings', 0, 4),
(77, 20, 'Penguins', 1, 1),
(78, 20, 'Twinkle', 0, 2),
(79, 20, 'Quick', 0, 3),
(80, 20, 'Denominator', 0, 4),
(81, 21, 'Conjunction', 1, 1),
(82, 21, 'Preposition', 0, 2),
(83, 21, 'Pronoun', 0, 3),
(84, 21, 'Interjection', 0, 4);

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
  `parent_quiz_id` int(11) DEFAULT NULL,
  `quiz_type` varchar(50) DEFAULT 'manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes_tb`
--

INSERT INTO `quizzes_tb` (`quiz_id`, `class_id`, `th_id`, `quiz_title`, `quiz_description`, `quiz_topic`, `time_limit`, `points_per_question`, `shuffle_questions`, `show_results`, `allow_retakes`, `status`, `created_at`, `updated_at`, `parent_quiz_id`, `quiz_type`) VALUES
(1, 1, 'TC202508316068', 'Basics of English', 'Answer all the questions carefully by choosing the best option or writing the correct response, use proper grammar, and review your work before submitting.', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-31 14:33:41', '2025-08-31 14:37:12', NULL, 'manual'),
(2, 1, 'TC202508316068', 'Basics of English (AI Regenerated)', 'Answer all the questions carefully by choosing the best option or writing the correct response, use proper grammar, and review your work before submitting.', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-31 14:43:45', '2025-08-31 14:43:45', 1, '1'),
(3, 1, 'TC202508316068', 'Basics of English (AI Regenerated)', 'Answer all the questions carefully by choosing the best option or writing the correct response, use proper grammar, and review your work before submitting.', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-31 14:44:07', '2025-08-31 14:44:07', 2, '1'),
(4, 1, 'TC202508316068', 'Basics of English (AI Regenerated)', 'Answer all the questions carefully by choosing the best option or writing the correct response, use proper grammar, and review your work before submitting.', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-31 14:44:31', '2025-08-31 14:44:31', 3, '1'),
(5, 1, 'TC202508316068', 'Basics of English (AI Regenerated)', 'Answer all the questions carefully by choosing the best option or writing the correct response, use proper grammar, and review your work before submitting.', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-31 14:45:44', '2025-08-31 14:45:44', 4, '1');

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
  `result` enum('passed','failed') DEFAULT NULL,
  `status` enum('in-progress','completed','timed-out','abandoned') NOT NULL DEFAULT 'in-progress',
  `student_name` varchar(255) DEFAULT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `grade_level` varchar(50) DEFAULT NULL,
  `strand` varchar(50) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `th_id` varchar(255) DEFAULT NULL,
  `quiz_title` varchar(255) DEFAULT NULL,
  `parent_quiz_id` int(11) DEFAULT NULL,
  `quiz_type` varchar(50) DEFAULT 'manual'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts_tb`
--

INSERT INTO `quiz_attempts_tb` (`attempt_id`, `quiz_id`, `st_id`, `start_time`, `end_time`, `score`, `result`, `status`, `student_name`, `student_email`, `grade_level`, `strand`, `student_id`, `th_id`, `quiz_title`, `parent_quiz_id`, `quiz_type`) VALUES
(1, 1, 'ST202508319422', '2025-08-31 22:43:28', '2025-08-31 22:43:28', 1, 'failed', 'completed', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', 'STEM', '12345', 'TC202508316068', 'Basics of English', NULL, 'manual'),
(2, 2, 'ST202508319422', '2025-08-31 22:43:56', '2025-08-31 22:43:56', 1, 'failed', 'completed', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', 'STEM', '12345', 'TC202508316068', 'Basics of English (AI Regenerated)', 1, '1'),
(3, 3, 'ST202508319422', '2025-08-31 22:44:22', '2025-08-31 22:44:22', 1, 'failed', 'completed', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', 'STEM', '12345', 'TC202508316068', 'Basics of English (AI Regenerated)', 2, '1'),
(4, 4, 'ST202508319422', '2025-08-31 22:44:52', '2025-08-31 22:44:52', 1, 'failed', 'completed', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', 'STEM', '12345', 'TC202508316068', 'Basics of English (AI Regenerated)', 3, '1'),
(5, 5, 'ST202508319422', '2025-08-31 22:48:01', '2025-08-31 22:48:01', 3, 'passed', 'completed', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'Grade 12', 'STEM', '12345', 'TC202508316068', 'Basics of English (AI Regenerated)', 4, '1');

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
(1, 1, 'multiple-choice', 'Which one is a noun?', 1, 1, '2025-08-31 14:37:12', '2025-08-31 14:37:12'),
(2, 1, 'multiple-choice', 'What is the past tense of go?', 1, 2, '2025-08-31 14:37:12', '2025-08-31 14:37:12'),
(3, 1, 'multiple-choice', 'Choose the correct sentence.', 1, 3, '2025-08-31 14:37:12', '2025-08-31 14:37:12'),
(4, 1, 'multiple-choice', 'Which word is an adjective?', 1, 4, '2025-08-31 14:37:12', '2025-08-31 14:37:12'),
(5, 1, 'multiple-choice', 'What is the opposite of hot?', 1, 5, '2025-08-31 14:37:12', '2025-08-31 14:37:12'),
(6, 2, 'multiple-choice', 'What is the correct plural form of the word \'child\'?', 1, 1, '2025-08-31 14:43:45', '2025-08-31 14:43:45'),
(7, 2, 'multiple-choice', 'Where does the question mark (?) go in a sentence?', 1, 2, '2025-08-31 14:43:45', '2025-08-31 14:43:45'),
(8, 2, 'multiple-choice', 'Which of the following is a complete sentence?', 1, 3, '2025-08-31 14:43:45', '2025-08-31 14:43:45'),
(9, 2, 'multiple-choice', 'Which verb is used to communicate a habit or regular action?', 1, 4, '2025-08-31 14:43:45', '2025-08-31 14:43:45'),
(10, 3, 'multiple-choice', 'Which of the following is a verb in English?', 1, 1, '2025-08-31 14:44:07', '2025-08-31 14:44:07'),
(11, 3, 'multiple-choice', 'Which of the following sentences is in present simple tense?', 1, 2, '2025-08-31 14:44:07', '2025-08-31 14:44:07'),
(12, 3, 'multiple-choice', 'What is the plural form of \'cat\'?', 1, 3, '2025-08-31 14:44:07', '2025-08-31 14:44:07'),
(13, 3, 'multiple-choice', 'Which of the following is a preposition?', 1, 4, '2025-08-31 14:44:07', '2025-08-31 14:44:07'),
(14, 4, 'multiple-choice', 'Which of the following is NOT a part of a complete sentence?', 1, 1, '2025-08-31 14:44:31', '2025-08-31 14:44:31'),
(15, 4, 'multiple-choice', 'Which of these words is a contraction of \'I am\'?', 1, 2, '2025-08-31 14:44:31', '2025-08-31 14:44:31'),
(16, 4, 'multiple-choice', 'Which of these phrases uses the correct subject-verb agreement?', 1, 3, '2025-08-31 14:44:31', '2025-08-31 14:44:31'),
(17, 4, 'multiple-choice', 'What word correctly completes this sentence to make it a question?', 1, 4, '2025-08-31 14:44:31', '2025-08-31 14:44:31'),
(18, 5, 'multiple-choice', 'Which of the following is a part of speech that expresses action, occurrence, or existence?', 1, 1, '2025-08-31 14:45:44', '2025-08-31 14:45:44'),
(19, 5, 'multiple-choice', 'Which sentence remains unchanged in past tense, regardless of the subject?', 1, 2, '2025-08-31 14:45:44', '2025-08-31 14:45:44'),
(20, 5, 'multiple-choice', 'Which of these is a collective noun that refers to a group of people, animals, or things?', 1, 3, '2025-08-31 14:45:44', '2025-08-31 14:45:44'),
(21, 5, 'multiple-choice', 'What should you use when you want to express a similarity or contrast about two things?', 1, 4, '2025-08-31 14:45:44', '2025-08-31 14:45:44');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_profiles_tb`
--

INSERT INTO `students_profiles_tb` (`id`, `st_id`, `st_userName`, `st_email`, `st_position`, `st_studentdPassword`, `student_id`, `grade_level`, `strand`, `created_at`, `updated_at`, `profile_picture`) VALUES
(1, 'ST202508319422', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$1HAk4cUssRRfPsbq10s0legFX0PvwWjiZnM4foW8qBojG0pXoiEim', '12345', 'Grade 12', 'STEM', '2025-08-31 14:07:55', '2025-08-31 14:14:39', 'ST202508319422_68b4576502665.jpeg');

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
(1, 1, 1, '3', NULL, 1, 1, '2025-08-31 22:43:28'),
(2, 1, 2, '8', NULL, 0, 0, '2025-08-31 22:43:28'),
(3, 1, 3, '12', NULL, 0, 0, '2025-08-31 22:43:28'),
(4, 1, 4, '15', NULL, 0, 0, '2025-08-31 22:43:28'),
(5, 1, 5, '19', NULL, 0, 0, '2025-08-31 22:43:28'),
(6, 2, 6, '23', NULL, 0, 0, '2025-08-31 22:43:56'),
(7, 2, 7, '26', NULL, 0, 0, '2025-08-31 22:43:56'),
(8, 2, 8, '30', NULL, 1, 1, '2025-08-31 22:43:56'),
(9, 2, 9, '36', NULL, 0, 0, '2025-08-31 22:43:56'),
(10, 3, 10, '39', NULL, 0, 0, '2025-08-31 22:44:22'),
(11, 3, 11, '44', NULL, 0, 0, '2025-08-31 22:44:22'),
(12, 3, 12, '47', NULL, 0, 0, '2025-08-31 22:44:22'),
(13, 3, 13, '50', NULL, 1, 1, '2025-08-31 22:44:22'),
(14, 4, 14, '55', NULL, 1, 1, '2025-08-31 22:44:52'),
(15, 4, 15, '58', NULL, 0, 0, '2025-08-31 22:44:52'),
(16, 4, 16, '63', NULL, 0, 0, '2025-08-31 22:44:52'),
(17, 4, 17, '67', NULL, 0, 0, '2025-08-31 22:44:52'),
(18, 5, 18, '72', NULL, 0, 0, '2025-08-31 22:48:01'),
(19, 5, 19, '74', NULL, 1, 1, '2025-08-31 22:48:01'),
(20, 5, 20, '77', NULL, 1, 1, '2025-08-31 22:48:01'),
(21, 5, 21, '81', NULL, 1, 1, '2025-08-31 22:48:01');

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
  `th_teacherPassword` varchar(255) NOT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `subject_expertise` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_profiles_tb`
--

INSERT INTO `teachers_profiles_tb` (`id`, `th_id`, `th_userName`, `th_Email`, `th_position`, `th_teacherPassword`, `employee_id`, `department`, `subject_expertise`, `created_at`, `updated_at`) VALUES
(1, 'TC202508316068', 'Almujim M. Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$sXJcjhj3xQG6YVeaLVMmuelZJRfxG0tFt8yvzn0PlH6erN8IqsRtW', '49050366', 'ICT', 'Programming', '2025-08-31 13:59:41', '2025-08-31 14:07:35');

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
(1, 'TC202508316068', 'English', 'AO32JQ', 'This class focuses on improving students’ reading, writing, speaking, and listening skills in English. Lessons include grammar, vocabulary, comprehension, and communication practice to build confidence and fluency. Students will engage in activities such as discussions, essays, and presentations to strengthen both academic and everyday language use.', '12', 'STEM', 'active', '2025-08-31 14:16:09', '2025-08-31 14:16:09'),
(2, 'TC202508316068', 'Science', 'HHZUJT', 'This class explores the world of science through experiments, observations, and discussions. Students will learn key concepts in life science, physical science, and earth science while developing critical thinking and problem-solving skills. The course encourages curiosity, discovery, and applying scientific knowledge to real-life situations.', '12', 'STEM', 'active', '2025-08-31 14:19:26', '2025-08-31 14:19:26'),
(3, 'TC202508316068', 'Math', 'CYXOIQ', 'This class develops problem-solving and analytical skills through the study of numbers, patterns, and relationships. Students will explore topics such as arithmetic, algebra, geometry, and data analysis while learning to apply mathematical concepts to real-life situations. The course encourages logical thinking, accuracy, and confidence in using math.', '12', 'STEM', 'active', '2025-08-31 14:20:03', '2025-08-31 14:20:03'),
(4, 'TC202508316068', 'History', '93C7BX', 'This class examines past events, people, and cultures to understand how they shaped the world today. Students will explore significant periods in history, analyze causes and effects, and learn to think critically about sources and perspectives. The course encourages connections between the past and present to build a deeper understanding of society and human development.', '12', 'STEM', 'active', '2025-08-31 14:22:59', '2025-08-31 14:22:59'),
(5, 'TC202508316068', 'Arts', '8P4WMO', 'This class encourages creativity and self-expression through different forms of visual and performing arts. Students will explore drawing, painting, music, drama, and other creative activities while learning about artistic techniques and cultural influences. The course helps develop imagination, appreciation of the arts, and confidence in sharing creative work.', '12', 'STEM', 'active', '2025-08-31 14:23:34', '2025-08-31 14:23:34'),
(6, 'TC202508316068', 'Programming', '9C5G55', 'This class introduces students to the fundamentals of computer programming and problem-solving. Students will learn how to write, test, and debug code using different programming languages while developing logical thinking and creativity. The course focuses on building real-world applications, enhancing computational skills, and preparing students for advanced studies in technology and software development.', '12', 'TVL-ICT', 'active', '2025-08-31 14:24:16', '2025-08-31 14:24:16'),
(7, 'TC202508316068', 'Computer', 'JVR022', 'This class helps students develop essential computer skills for both academic and practical use. Lessons include basic operations, word processing, spreadsheets, presentations, internet use, and digital safety. The course builds confidence in using technology effectively and prepares students for future learning and workplace needs.', '12', 'TVL-ICT', 'active', '2025-08-31 14:25:02', '2025-08-31 14:25:02'),
(8, 'TC202508316068', 'Music', 'RGTD1X', 'This class develops students’ understanding and appreciation of music through listening, singing, and performing. Students will learn basic music theory, rhythm, melody, and harmony while exploring different musical styles and instruments. The course encourages creativity, self-expression, and teamwork through individual and group performances.', '12', 'TVL-HE', 'active', '2025-08-31 14:25:34', '2025-08-31 14:25:34'),
(9, 'TC202508316068', 'Literature', 'AR9I2X', 'This class explores a variety of literary works such as poems, short stories, novels, and plays. Students will analyze themes, characters, and writing styles while learning to appreciate the power of language and storytelling. The course encourages critical thinking, interpretation, and self-expression through reading, discussion, and writing.', '12', 'TVL-HE', 'active', '2025-08-31 14:25:59', '2025-08-31 14:25:59'),
(10, 'TC202508316068', 'Filipino', 'ORVCEV', 'This class develops students’ skills in reading, writing, speaking, and understanding the Filipino language. Lessons cover grammar, vocabulary, literature, and communication to strengthen both academic and everyday use of Filipino. The course also promotes appreciation of Filipino culture, history, and identity through language and literature.', '12', 'HUMSS', 'active', '2025-08-31 14:26:25', '2025-08-31 14:26:25'),
(11, 'TC202508316068', 'Home Economics', 'REAVAM', 'This class teaches practical life skills in areas such as cooking, nutrition, sewing, budgeting, and household management. Students will learn how to make responsible decisions, develop self-sufficiency, and apply these skills to everyday life. The course also promotes creativity, responsibility, and healthy living.', '12', 'TVL-HE', 'active', '2025-08-31 14:26:52', '2025-08-31 14:26:52'),
(12, 'TC202508316068', 'ICT', '8E76E8', 'This class introduces students to digital tools and technologies for communication, information management, and problem-solving. Lessons include computer applications, internet use, multimedia, and basic programming. The course develops digital literacy, creativity, and critical thinking to prepare students for academic, professional, and real-world technology use.', '12', 'TVL-ICT', 'active', '2025-08-31 14:27:38', '2025-08-31 14:27:38'),
(13, 'TC202508316068', 'PE', 'Z2AACG', 'This class promotes physical fitness, health, and teamwork through various sports, exercises, and recreational activities. Students will develop strength, coordination, and endurance while learning the value of discipline, cooperation, and healthy living. The course encourages an active lifestyle and a positive attitude toward physical well-being.', '12', 'ABM', 'active', '2025-08-31 14:28:13', '2025-08-31 14:30:49');

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
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`id`, `user_id`, `userName`, `userEmail`, `userPosition`, `userPassword`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'TC202508316068', 'Almujim M. Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$sXJcjhj3xQG6YVeaLVMmuelZJRfxG0tFt8yvzn0PlH6erN8IqsRtW', NULL, '2025-08-31 13:59:41', '2025-08-31 14:07:28'),
(2, 'ST202508319422', 'Jim M. Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$1HAk4cUssRRfPsbq10s0legFX0PvwWjiZnM4foW8qBojG0pXoiEim', 'ST202508319422_68b4576502665.jpeg', '2025-08-31 14:07:55', '2025-08-31 14:14:39');

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
-- Indexes for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `class_id` (`class_id`);

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
  ADD KEY `parent_quiz_fk` (`parent_quiz_id`),
  ADD KEY `parent_quiz_id` (`parent_quiz_id`);

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
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `learning_materials_tb`
--
ALTER TABLE `learning_materials_tb`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_profiles_tb`
--
ALTER TABLE `students_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teachers_profiles_tb`
--
ALTER TABLE `teachers_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  ADD CONSTRAINT `class_enrollments_tb_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `teacher_classes_tb` (`class_id`) ON DELETE CASCADE;

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
