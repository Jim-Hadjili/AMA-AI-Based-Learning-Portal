-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 11:51 AM
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

--
-- Dumping data for table `announcements_tb`
--

INSERT INTO `announcements_tb` (`announcement_id`, `class_id`, `teacher_id`, `title`, `content`, `created_at`, `is_pinned`) VALUES
(1, 32, 'TC202507225654', 'For tommorow', 'Hello students! 🔬\\r\\nDon\\\'t forget to bring your lab notebooks and materials for tomorrow\\\'s experiment on chemical reactions. We\\\'ll be working in groups, so come prepared and ready to explore! See you in class! 👩‍🔬🧪👨‍🔬', '2025-07-23 16:14:48', 0),
(2, 32, 'TC202507225654', 'asd', 'asd', '2025-07-23 16:15:07', 0),
(3, 32, 'TC202507225654', 'sad', 'dasd', '2025-07-23 16:15:11', 0),
(4, 32, 'TC202507225654', 'asda', 'dasdas', '2025-07-23 16:15:15', 0),
(5, 32, 'TC202507225654', 'dasda', 'dsadasd', '2025-07-23 16:15:20', 0),
(6, 32, 'TC202507225654', 'dsad', 'adasd', '2025-07-23 16:15:24', 0),
(7, 32, 'TC202507225654', 'asd', 'dasdad', '2025-07-23 16:15:29', 0),
(8, 38, 'TC202507225654', 'sheshhh', 'sheshhhhhhhhh', '2025-07-28 17:12:16', 0),
(9, 32, 'TC202507225654', 'gg', 'ggggggggggggggggggg', '2025-07-28 18:31:28', 0),
(10, 32, 'TC202507225654', 'g', 'gggggggggggggggggggggggg', '2025-07-28 18:31:35', 0),
(11, 38, 'TC202507225654', 'csac', 'sacasc', '2025-07-29 15:42:05', 0),
(12, 38, 'TC202507225654', 'cascasc', 'casc', '2025-07-29 15:42:09', 0),
(13, 38, 'TC202507225654', 'csacasc', 'cscascasc', '2025-07-29 15:42:13', 1),
(14, 38, 'TC202507225654', 'cascac', 'sacsacascas', '2025-07-29 15:42:17', 0),
(15, 38, 'TC202507225654', 'casca', 'cascacascasc', '2025-07-29 15:42:21', 0),
(16, 38, 'TC202507225654', 'csacac', 'sacascasc', '2025-07-29 15:42:25', 0),
(17, 38, 'TC202507225654', 'csasc', 'ascsacascascasc', '2025-07-29 15:42:29', 0),
(18, 38, 'TC202507225654', 'casc', 'csacascascasc', '2025-07-29 15:42:33', 0),
(19, 38, 'TC202507225654', 'saccccccc', 'ccccccccccccccccccccccccccccc', '2025-07-29 15:42:37', 0),
(20, 38, 'TC202507225654', 'sccccccc', 'cccccccccccccccccccc', '2025-07-29 15:42:41', 0),
(21, 38, 'TC202507225654', 'scccccccc', 'ccccccccccccccccccccccccc', '2025-07-29 15:42:45', 0),
(22, 38, 'TC202507225654', 'csccccccccccccc', 'cccccccccccccccccccccccccccc', '2025-07-29 15:42:51', 0),
(23, 38, 'TC202507225654', 'cscscsc', 'cscscs', '2025-07-29 15:42:56', 0),
(24, 38, 'TC202507225654', 'cs', 'csc', '2025-07-29 15:43:08', 0),
(25, 38, 'TC202507225654', 'dasd', 'sadasd', '2025-07-29 17:54:49', 0);

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
(2, 38, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 09:56:17', 'active', NULL, NULL),
(3, 41, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 11:51:05', 'active', 'stem', NULL),
(4, 40, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 11:54:05', 'active', 'stem', '12345'),
(5, 32, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-27 08:29:51', 'active', 'stem', '12345'),
(6, 39, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:01', 'active', 'stem', '12345'),
(7, 37, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:18', 'active', 'stem', '12345'),
(8, 36, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:30', 'active', 'stem', '12345'),
(9, 35, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:39', 'active', 'stem', '12345'),
(10, 34, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:48', 'active', 'stem', '12345');

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

--
-- Dumping data for table `generated_quizzes_tb`
--

INSERT INTO `generated_quizzes_tb` (`id`, `quiz_id`, `original_quiz_id`, `generation_date`) VALUES
(40, 129, 112, '2025-08-02 09:51:00');

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
(1, 32, 'TC202507225654', 'What is Science', 'Access and review your science lessons, worksheets, and notes anytime! Click on the files below to view or download the materials in PDF format. These resources are provided to help you study and stay prepared for class activities, quizzes, and exams.', 'Uploads/Materials/32/688094de839ce_what_is_science.pdf', 'what_is_science.pdf', 899333, 'pdf', '2025-07-23 15:53:02'),
(2, 32, 'TC202507225654', 'ad', '', 'Uploads/Materials/32/68809a381435f_what_is_science (1).pdf', 'what_is_science (1).pdf', 899333, 'pdf', '2025-07-23 16:15:52'),
(3, 32, 'TC202507225654', 'sadasd', '', 'Uploads/Materials/32/68809a41278fe_what_is_science (2).pdf', 'what_is_science (2).pdf', 899333, 'pdf', '2025-07-23 16:16:01'),
(4, 32, 'TC202507225654', 'asda', 'dsada', 'Uploads/Materials/32/68809a4a897aa_what_is_science (3).pdf', 'what_is_science (3).pdf', 899333, 'pdf', '2025-07-23 16:16:10'),
(5, 32, 'TC202507225654', 'sdad', '', 'Uploads/Materials/32/68809a5289cee_what_is_science (1).pdf', 'what_is_science (1).pdf', 899333, 'pdf', '2025-07-23 16:16:18'),
(6, 32, 'TC202507225654', 'asd', 'sadasdasd', 'Uploads/Materials/32/68809a5c75bf8_what_is_science (3).pdf', 'what_is_science (3).pdf', 899333, 'pdf', '2025-07-23 16:16:28'),
(7, 38, 'TC202507225654', 'ambaw', '', 'Uploads/Materials/38/68873ee299ea1_SYSTEM-SPECS (1) (7) (2).pdf', 'SYSTEM-SPECS (1) (7) (2).pdf', 155094, 'pdf', '2025-07-28 17:12:02'),
(8, 32, 'TC202507225654', 'ddd', 'ddddd', 'Uploads/Materials/32/6887516d34137_SYSTEM-SPECS (1) (3) (1).pdf', 'SYSTEM-SPECS (1) (3) (1).pdf', 155094, 'pdf', '2025-07-28 18:31:09'),
(9, 32, 'TC202507225654', 'dddddddddddddddd', '', 'Uploads/Materials/32/68875179a612e_SYSTEM-SPECS (1) (3) (1).pdf', 'SYSTEM-SPECS (1) (3) (1).pdf', 155094, 'pdf', '2025-07-28 18:31:21'),
(10, 38, 'TC202507225654', 'cscsc', '', 'Uploads/Materials/38/68887b982a13d_SYSTEM-SPECS (1) (7) (3) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1).pdf', 155094, 'pdf', '2025-07-29 15:43:20'),
(11, 38, 'TC202507225654', 'scscsc', '', 'Uploads/Materials/38/68887ba3955aa_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:43:31'),
(12, 38, 'TC202507225654', 'scsc', 'cs', 'Uploads/Materials/38/68887bac0f3cc_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:43:40'),
(13, 38, 'TC202507225654', 'cscdsv', 'sdvsdvsdvsdv', 'Uploads/Materials/38/68887bb4d4eed_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:43:48'),
(14, 38, 'TC202507225654', 'dsfffffffffffffffff', '', 'Uploads/Materials/38/68887bbe78543_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:43:58'),
(15, 38, 'TC202507225654', 'fdsfds', '', 'Uploads/Materials/38/68887bc55c9ed_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:05'),
(16, 38, 'TC202507225654', 'dsfdsf', '', 'Uploads/Materials/38/68887bcdd2a08_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:13'),
(17, 38, 'TC202507225654', 'ddddddddddddddddddddddddd', '', 'Uploads/Materials/38/68887bd568c60_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:21'),
(18, 38, 'TC202507225654', 'fdffffffffffffffffffffff', '', 'Uploads/Materials/38/68887bdeaa9ad_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:30'),
(19, 38, 'TC202507225654', 'dewrwer', '', 'Uploads/Materials/38/68887bec23cfc_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:44'),
(20, 38, 'TC202507225654', 'erwr', '', 'Uploads/Materials/38/68887bf39cec2_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:51'),
(21, 38, 'TC202507225654', 'werwerwer', '', 'Uploads/Materials/38/68887bfba5beb_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:44:59'),
(22, 38, 'TC202507225654', 'ewrwerwer', '', 'Uploads/Materials/38/68887c02b2bcb_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 15:45:06'),
(23, 38, 'TC202507225654', 'sadsad', '', 'Uploads/Materials/38/68889a82cbff0_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 17:55:14'),
(24, 38, 'TC202507225654', 'asdasd', '', 'Uploads/Materials/38/68889a8b15b23_SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 'SYSTEM-SPECS (1) (7) (3) (1) (1).pdf', 155094, 'pdf', '2025-07-29 17:55:23');

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
(41, 150, 'Respiration', 0, 1),
(42, 150, 'Digestion', 0, 2),
(43, 150, 'Photosynthesis ', 1, 3),
(44, 150, 'Fermentation', 0, 4),
(45, 151, 'Venus', 0, 1),
(46, 151, 'Jupiter', 0, 2),
(47, 151, 'Mars ', 1, 3),
(48, 151, 'Saturn', 0, 4),
(49, 152, 'Atom', 0, 1),
(50, 152, 'Molecule', 0, 2),
(51, 152, 'Cell ', 1, 3),
(52, 152, 'Tissue', 0, 4),
(53, 153, 'Carbon dioxide', 0, 1),
(54, 153, 'Nitrogen', 0, 2),
(55, 153, 'Oxygen ', 1, 3),
(56, 153, 'Hydrogen', 0, 4),
(57, 154, 'Water ', 1, 1),
(58, 154, 'Hydrogen peroxide', 0, 2),
(59, 154, 'Oxygen', 0, 3),
(60, 154, 'Salt', 0, 4),
(61, 155, 'Friction', 0, 1),
(62, 155, 'Magnetism', 0, 2),
(63, 155, 'Electricity', 0, 3),
(64, 155, 'Gravity ', 1, 4),
(65, 156, 'Heart ', 1, 1),
(66, 156, 'Lungs', 0, 2),
(67, 156, 'Brain', 0, 3),
(68, 156, 'Stomach', 0, 4),
(69, 157, 'Wind', 0, 1),
(70, 157, ' The Sun', 1, 2),
(71, 157, 'Fossil fuels', 0, 3),
(72, 157, 'The Moon', 0, 4),
(73, 158, 'Flower', 0, 1),
(74, 158, 'Root ', 1, 2),
(75, 158, 'Flower', 0, 3),
(76, 158, 'Stem', 0, 4),
(77, 159, '90°C', 0, 1),
(78, 159, '100°C ', 1, 2),
(79, 159, '110°C', 0, 3),
(80, 159, '120°C', 0, 4),
(81, 160, 'fsafas', 0, 1),
(82, 160, 'fsaf', 0, 2),
(83, 160, 'faf', 1, 3),
(84, 160, 'saf', 0, 4),
(85, 161, 'fasfsa', 0, 1),
(86, 161, 'fsafsf', 0, 2),
(87, 161, 'fsafasf', 1, 3),
(88, 161, 'fsafa', 1, 4),
(89, 162, 'True', 0, 1),
(90, 162, 'False', 1, 2),
(91, 164, 'sssssssssssss', 0, 1),
(92, 164, 'sssssssss', 0, 2),
(93, 164, 'sssssssssss', 1, 3),
(94, 164, 'ssssssssssss', 0, 4),
(95, 165, 'dddddddddd', 0, 1),
(96, 165, 'ddddddddddddd', 0, 2),
(97, 165, 'ddddddddddd', 0, 3),
(98, 165, 'ddddddddd', 1, 4),
(99, 166, 'ss', 0, 1),
(100, 166, 'ss', 0, 2),
(101, 166, 'sss', 1, 3),
(102, 166, 'sss', 0, 4),
(123, 172, 'She go to school every day.', 0, 1),
(124, 172, 'She goes to school every day.', 1, 2),
(125, 172, ' She going to school every day.', 0, 3),
(126, 172, 'She gone to school every day.', 0, 4),
(127, 173, 'Written', 0, 1),
(128, 173, 'Writes', 0, 2),
(129, 173, 'Wrote', 1, 3),
(130, 173, 'Writing', 0, 4),
(312, 244, 'I is eating an apple now.', 0, 1),
(313, 244, 'I am eating an apple now.', 1, 2),
(314, 244, 'I eats an apple now.', 0, 3),
(315, 244, 'I eats apple now.', 0, 4),
(316, 245, 'Favourate', 0, 1),
(317, 245, 'Favorite', 0, 2),
(318, 245, 'Favourit', 0, 3),
(319, 245, 'Favourite', 1, 4),
(320, 246, 'I went', 1, 1),
(321, 246, 'I goes', 0, 2),
(322, 246, 'I gone', 0, 3),
(323, 246, 'I goed', 0, 4);

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
(89, 32, 'TC202507225654', 'Exploring the Wonders of Science', 'Test your knowledge of biology, chemistry, physics, and earth science with these 10 multiple answer questions. Choose all correct answers for each item!', NULL, 30, 1, 0, 1, 1, 'published', '2025-07-23 07:13:53', '2025-07-23 07:50:25', NULL, 'manual'),
(90, 32, 'TC202507225654', 'sdf', 'fdsfsf', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 08:18:54', '2025-07-23 08:18:54', NULL, 'manual'),
(91, 32, 'TC202507225654', 'asdas', 'dsadasdasd', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:04:45', '2025-07-23 09:04:45', NULL, 'manual'),
(92, 32, 'TC202507225654', 'dsadad', 'asd', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:04:51', '2025-07-23 09:04:51', NULL, 'manual'),
(93, 32, 'TC202507225654', 'fsdf', 'sdfsd', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:04:57', '2025-07-23 09:04:57', NULL, 'manual'),
(94, 32, 'TC202507225654', 'sfa', 'fsafafsaf', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:05:03', '2025-07-23 09:05:03', NULL, 'manual'),
(95, 32, 'TC202507225654', 'dcsc', 'fsdfsdfsf', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:05:09', '2025-07-23 09:05:09', NULL, 'manual'),
(96, 32, 'TC202507225654', 'dscs', 'csdcsdc', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:05:15', '2025-07-23 09:05:15', NULL, 'manual'),
(97, 32, 'TC202507225654', 'csdcsdc', 'sdccsdc', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:05:21', '2025-07-23 09:05:21', NULL, 'manual'),
(98, 32, 'TC202507225654', 'dsfsdfsdf', 'dfsdf', NULL, 30, 1, 0, 1, 1, 'draft', '2025-07-23 09:05:29', '2025-07-23 09:05:29', NULL, 'manual'),
(99, 38, 'TC202507225654', 'Math', 'fsafasf', NULL, 30, 1, 0, 1, 1, 'published', '2025-07-28 09:11:08', '2025-07-28 09:11:37', NULL, 'manual'),
(100, 32, 'TC202507225654', 'sas', 'dasdasd', NULL, 30, 1, 0, 1, 1, 'published', '2025-07-28 10:30:32', '2025-07-28 10:30:41', NULL, 'manual'),
(101, 32, 'TC202507225654', 'dddd', 'ddddddddddddddddd', NULL, 30, 1, 0, 1, 1, 'published', '2025-07-28 10:30:47', '2025-07-28 10:30:54', NULL, 'manual'),
(102, 38, 'TC202507225654', 'ssssssssss', 'sssssssssssssssss', NULL, 60, 1, 0, 1, 1, 'published', '2025-07-29 10:40:23', '2025-07-29 10:40:31', NULL, 'manual'),
(112, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-02 08:52:47', '2025-08-02 09:24:36', NULL, 'manual'),
(129, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-02 09:51:00', '2025-08-02 09:51:00', 112, 'manual');

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
  `student_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts_tb`
--

INSERT INTO `quiz_attempts_tb` (`attempt_id`, `quiz_id`, `st_id`, `start_time`, `end_time`, `score`, `result`, `status`, `student_name`, `student_email`, `grade_level`, `strand`, `student_id`) VALUES
(148, 99, 'ST202507239872', '2025-08-02 10:47:43', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(149, 99, 'ST202507239872', '2025-08-02 10:49:25', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(150, 112, 'ST202507239872', '2025-08-02 10:54:14', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(151, 112, 'ST202507239872', '2025-08-02 11:00:19', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(152, 112, 'ST202507239872', '2025-08-02 11:04:12', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(153, 112, 'ST202507239872', '2025-08-02 11:06:56', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(154, 112, 'ST202507239872', '2025-08-02 11:09:17', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(156, 112, 'ST202507239872', '2025-08-02 11:18:57', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(157, 112, 'ST202507239872', '2025-08-02 11:21:12', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(158, 112, 'ST202507239872', '2025-08-02 11:24:48', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(159, 112, 'ST202507239872', '2025-08-02 11:25:45', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(160, 112, 'ST202507239872', '2025-08-02 11:26:13', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(161, 112, 'ST202507239872', '2025-08-02 11:27:25', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(162, 112, 'ST202507239872', '2025-08-02 11:28:48', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(163, 112, 'ST202507239872', '2025-08-02 11:29:11', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(164, 112, 'ST202507239872', '2025-08-02 11:33:47', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(165, 112, 'ST202507239872', '2025-08-02 11:36:51', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(166, 112, 'ST202507239872', '2025-08-02 11:41:32', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(167, 112, 'ST202507239872', '2025-08-02 11:44:22', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(168, 112, 'ST202507239872', '2025-08-02 11:44:48', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(169, 112, 'ST202507239872', '2025-08-02 11:45:15', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(170, 112, 'ST202507239872', '2025-08-02 11:45:47', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(171, 112, 'ST202507239872', '2025-08-02 11:46:17', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(172, 112, 'ST202507239872', '2025-08-02 11:47:05', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(173, 112, 'ST202507239872', '2025-08-02 11:47:56', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(174, 112, 'ST202507239872', '2025-08-02 11:48:35', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(175, 112, 'ST202507239872', '2025-08-02 11:49:05', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(176, 112, 'ST202507239872', '2025-08-02 11:49:45', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345'),
(177, 112, 'ST202507239872', '2025-08-02 11:50:54', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345');

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
(150, 89, 'multiple-choice', '1. What is the process by which plants make their own food?', 1, 1, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(151, 89, 'multiple-choice', '2. Which planet is known as the \"Red Planet\"?\n', 1, 2, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(152, 89, 'multiple-choice', 'What is the smallest unit of life', 1, 3, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(153, 89, 'multiple-choice', '4. Which gas do humans need to breathe in to survive?', 1, 4, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(154, 89, 'multiple-choice', 'What is H₂O commonly known as?', 1, 5, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(155, 89, 'multiple-choice', 'What force keeps us on the ground?', 1, 6, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(156, 89, 'multiple-choice', 'Which organ pumps blood throughout the body?', 1, 7, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(157, 89, 'multiple-choice', 'What is the main source of energy for the Earth?', 1, 8, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(158, 89, 'multiple-choice', 'Which part of the plant absorbs water from the soil?', 1, 9, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(159, 89, 'multiple-choice', 'What is the boiling point of water at sea level?', 1, 10, '2025-07-23 07:50:06', '2025-07-23 07:50:06'),
(160, 99, 'multiple-choice', 'fsaf', 1, 1, '2025-07-28 09:11:37', '2025-07-28 09:11:37'),
(161, 99, 'checkbox', 'asfsa', 1, 2, '2025-07-28 09:11:37', '2025-07-28 09:11:37'),
(162, 99, 'true-false', 'safsafsfsafsafasf', 1, 3, '2025-07-28 09:11:37', '2025-07-28 09:11:37'),
(163, 99, 'short-answer', 'fasffffffffffffffffffff', 5, 4, '2025-07-28 09:11:37', '2025-07-28 09:11:37'),
(164, 100, 'multiple-choice', 'sssssssss', 1, 1, '2025-07-28 10:30:41', '2025-07-28 10:30:41'),
(165, 101, 'multiple-choice', 'dd', 1, 1, '2025-07-28 10:30:54', '2025-07-28 10:30:54'),
(166, 102, 'multiple-choice', 'sss', 1, 1, '2025-07-29 10:40:31', '2025-07-29 10:40:31'),
(172, 112, 'multiple-choice', 'Which sentence is grammatically correct?', 1, 1, '2025-08-02 08:53:59', '2025-08-02 08:53:59'),
(173, 112, 'multiple-choice', 'What is the past tense of \"write\"?', 1, 2, '2025-08-02 08:53:59', '2025-08-02 08:53:59'),
(244, 129, 'multiple-choice', 'Which verb is used correctly in the following sentence to express the present continuous tense?', 1, 1, '2025-08-02 09:51:00', '2025-08-02 09:51:00'),
(245, 129, 'multiple-choice', 'What is the correct spelling of the word that means a strong preference or liking for something?', 1, 2, '2025-08-02 09:51:00', '2025-08-02 09:51:00'),
(246, 129, 'multiple-choice', 'Which one is the correct past simple form of the verb \'to go\'?', 1, 3, '2025-08-02 09:51:00', '2025-08-02 09:51:00'),
(247, 129, 'short-answer', 'What is the adjective that best describes a person who speaks rudely or harshly?', 1, 4, '2025-08-02 09:51:00', '2025-08-02 09:51:00');

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

--
-- Dumping data for table `short_answer_tb`
--

INSERT INTO `short_answer_tb` (`id`, `question_id`, `correct_answer`, `case_sensitive`) VALUES
(14, 163, 'aaa', 0),
(33, 247, 'Rude', 0);

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
(5, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$PG82oXpmFrptMFkSeFKLLuPO/e4j2IkMyazbx2TtpjHJe0TNX7CNa', '12345', 'grade_12', 'stem', '2025-07-23 06:32:18', '2025-08-01 08:09:33');

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
(555, 148, 160, '81', NULL, 0, 0, '2025-08-02 16:47:43'),
(556, 148, 161, '86', NULL, 0, 0, '2025-08-02 16:47:43'),
(557, 148, 162, 'false', NULL, 0, 0, '2025-08-02 16:47:43'),
(558, 148, 163, NULL, 'sasd', 0, 0, '2025-08-02 16:47:43'),
(559, 149, 160, '81', NULL, 0, 0, '2025-08-02 16:49:25'),
(560, 149, 161, '86', NULL, 0, 0, '2025-08-02 16:49:25'),
(561, 149, 162, 'true', NULL, 0, 0, '2025-08-02 16:49:25'),
(562, 149, 163, NULL, 'ss', 0, 0, '2025-08-02 16:49:25'),
(563, 150, 172, '123', NULL, 0, 0, '2025-08-02 16:54:14'),
(564, 150, 173, '127', NULL, 0, 0, '2025-08-02 16:54:14'),
(565, 151, 172, '123', NULL, 0, 0, '2025-08-02 17:00:19'),
(566, 151, 173, '127', NULL, 0, 0, '2025-08-02 17:00:19'),
(567, 152, 172, '123', NULL, 0, 0, '2025-08-02 17:04:12'),
(568, 152, 173, '127', NULL, 0, 0, '2025-08-02 17:04:12'),
(569, 153, 172, '123', NULL, 0, 0, '2025-08-02 17:06:56'),
(570, 153, 173, '127', NULL, 0, 0, '2025-08-02 17:06:56'),
(571, 154, 172, '123', NULL, 0, 0, '2025-08-02 17:09:17'),
(572, 154, 173, '127', NULL, 0, 0, '2025-08-02 17:09:17'),
(583, 156, 172, '123', NULL, 0, 0, '2025-08-02 17:18:57'),
(584, 156, 173, '127', NULL, 0, 0, '2025-08-02 17:18:57'),
(585, 157, 172, '123', NULL, 0, 0, '2025-08-02 17:21:12'),
(586, 157, 173, '127', NULL, 0, 0, '2025-08-02 17:21:12'),
(587, 158, 172, '123', NULL, 0, 0, '2025-08-02 17:24:48'),
(588, 158, 173, '127', NULL, 0, 0, '2025-08-02 17:24:48'),
(589, 159, 172, '123', NULL, 0, 0, '2025-08-02 17:25:45'),
(590, 159, 173, '127', NULL, 0, 0, '2025-08-02 17:25:45'),
(591, 160, 172, '123', NULL, 0, 0, '2025-08-02 17:26:13'),
(592, 160, 173, '127', NULL, 0, 0, '2025-08-02 17:26:13'),
(593, 161, 172, '123', NULL, 0, 0, '2025-08-02 17:27:25'),
(594, 161, 173, '127', NULL, 0, 0, '2025-08-02 17:27:25'),
(595, 162, 172, '123', NULL, 0, 0, '2025-08-02 17:28:48'),
(596, 162, 173, '127', NULL, 0, 0, '2025-08-02 17:28:48'),
(597, 163, 172, '123', NULL, 0, 0, '2025-08-02 17:29:11'),
(598, 163, 173, '127', NULL, 0, 0, '2025-08-02 17:29:11'),
(599, 164, 172, '123', NULL, 0, 0, '2025-08-02 17:33:47'),
(600, 164, 173, '127', NULL, 0, 0, '2025-08-02 17:33:47'),
(601, 165, 172, '123', NULL, 0, 0, '2025-08-02 17:36:51'),
(602, 165, 173, '127', NULL, 0, 0, '2025-08-02 17:36:51'),
(603, 166, 172, '123', NULL, 0, 0, '2025-08-02 17:41:32'),
(604, 166, 173, '127', NULL, 0, 0, '2025-08-02 17:41:32'),
(605, 167, 172, '123', NULL, 0, 0, '2025-08-02 17:44:22'),
(606, 167, 173, '127', NULL, 0, 0, '2025-08-02 17:44:22'),
(607, 168, 172, '123', NULL, 0, 0, '2025-08-02 17:44:48'),
(608, 168, 173, '127', NULL, 0, 0, '2025-08-02 17:44:48'),
(609, 169, 172, '123', NULL, 0, 0, '2025-08-02 17:45:15'),
(610, 169, 173, '127', NULL, 0, 0, '2025-08-02 17:45:15'),
(611, 170, 172, '123', NULL, 0, 0, '2025-08-02 17:45:47'),
(612, 170, 173, '127', NULL, 0, 0, '2025-08-02 17:45:47'),
(613, 171, 172, '123', NULL, 0, 0, '2025-08-02 17:46:17'),
(614, 171, 173, '127', NULL, 0, 0, '2025-08-02 17:46:17'),
(615, 172, 172, '123', NULL, 0, 0, '2025-08-02 17:47:05'),
(616, 172, 173, '127', NULL, 0, 0, '2025-08-02 17:47:05'),
(617, 173, 172, '123', NULL, 0, 0, '2025-08-02 17:47:56'),
(618, 173, 173, '127', NULL, 0, 0, '2025-08-02 17:47:56'),
(619, 174, 172, '123', NULL, 0, 0, '2025-08-02 17:48:35'),
(620, 174, 173, '127', NULL, 0, 0, '2025-08-02 17:48:35'),
(621, 175, 172, '123', NULL, 0, 0, '2025-08-02 17:49:05'),
(622, 175, 173, '127', NULL, 0, 0, '2025-08-02 17:49:05'),
(623, 176, 172, '123', NULL, 0, 0, '2025-08-02 17:49:45'),
(624, 176, 173, '127', NULL, 0, 0, '2025-08-02 17:49:45'),
(625, 177, 172, '123', NULL, 0, 0, '2025-08-02 17:50:54'),
(626, 177, 173, '127', NULL, 0, 0, '2025-08-02 17:50:54');

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
(21, '49050366', 'Jim Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$Otn3g/yM/pGG9mDNRHKjJeOJxUMnCX3yQn593uvZuywjDwGS.HJJi', NULL, 'ict', 'Programming', '2025-07-22 14:48:53', '2025-07-22 14:48:53');

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
(32, 'TC202507225654', 'Science', '1JGHY8', 'Explore the wonders of the natural world in this engaging science class! Students will discover key concepts in biology, chemistry, physics, and earth science through hands-on activities, experiments, and real-world applications. This course encourages curiosity, critical thinking, and a deeper understanding of how science shapes our everyday lives.', '12', 'STEM', 'active', '2025-07-22 14:49:44', '2025-07-23 07:06:07'),
(33, 'TC202507225654', 'Math', '81B2H3', 'sfdsf', '11', 'TVL-HE', 'active', '2025-07-23 08:53:45', '2025-07-23 08:53:45'),
(34, 'TC202507225654', 'fdsf', 'fsdfs', 'fsdfsdf', '11', 'TVL-HE', 'active', '2025-07-23 08:53:53', '2025-07-23 08:53:53'),
(35, 'TC202507225654', 'fsf', 'dsfsdf', 'fdsfsdf', '12', 'TVL-ICT', 'active', '2025-07-23 08:54:01', '2025-07-23 08:54:01'),
(36, 'TC202507225654', 'fdsfsdf', 'fsfsdf', 'fdsfsdf', '12', 'HUMSS', 'active', '2025-07-23 08:54:08', '2025-07-23 08:54:08'),
(37, 'TC202507225654', 'dsvsdfdsd', 'fdsfsdf', 'fdsfsdf', '12', 'TVL-ICT', 'active', '2025-07-23 08:54:16', '2025-07-23 08:54:16'),
(38, 'TC202507225654', 'english', 'LBN6XJ', 'dfgds', '11', 'TVL-HE', 'active', '2025-07-23 08:54:29', '2025-07-23 08:54:29'),
(39, 'TC202507225654', 'gdsgds', 'gsdgsd', 'gsdgdsg', '11', 'TVL-ICT', 'active', '2025-07-23 08:54:36', '2025-07-23 08:54:36'),
(40, 'TC202507225654', 'dsgsdg', 'gdsgsd', 'gdsgsdg', '11', 'TVL-ICT', 'active', '2025-07-23 08:54:44', '2025-07-23 08:54:44'),
(41, 'TC202507225654', 'sdfdsf', 'dsfsdfdddd', 'fdsfsdf', '11', 'TVL-ICT', 'active', '2025-07-23 08:54:58', '2025-07-23 08:54:58'),
(42, 'TC202507225654', 'ambaw', 'WLYH2I', 'ambaw', '12', 'STEM', 'active', '2025-08-01 08:00:44', '2025-08-01 08:00:44');

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
(25, 'TC202507225654', 'Jim Hadjili', 'almujim.hadjili@gmail.com', 'teacher', '$2y$10$Otn3g/yM/pGG9mDNRHKjJeOJxUMnCX3yQn593uvZuywjDwGS.HJJi', '2025-07-22 14:48:53', '2025-07-22 14:48:53'),
(26, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$PG82oXpmFrptMFkSeFKLLuPO/e4j2IkMyazbx2TtpjHJe0TNX7CNa', '2025-07-23 06:32:18', '2025-08-01 08:09:33');

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
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `generated_quizzes_tb`
--
ALTER TABLE `generated_quizzes_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `learning_materials_tb`
--
ALTER TABLE `learning_materials_tb`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications_tb`
--
ALTER TABLE `notifications_tb`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_options_tb`
--
ALTER TABLE `question_options_tb`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `students_profiles_tb`
--
ALTER TABLE `students_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=627;

--
-- AUTO_INCREMENT for table `teachers_profiles_tb`
--
ALTER TABLE `teachers_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `teacher_classes_tb`
--
ALTER TABLE `teacher_classes_tb`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

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
