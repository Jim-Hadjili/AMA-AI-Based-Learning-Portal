-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 10:58 AM
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
(2, 38, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 09:56:17', 'active', 'Stem', NULL),
(3, 41, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 11:51:05', 'active', 'stem', NULL),
(4, 40, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-23 11:54:05', 'active', 'stem', '12345'),
(5, 32, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-27 08:29:51', 'active', 'stem', '12345'),
(6, 39, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:01', 'active', 'stem', '12345'),
(7, 37, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:18', 'active', 'stem', '12345'),
(8, 36, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:30', 'active', 'stem', '12345'),
(9, 35, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:39', 'active', 'stem', '12345'),
(10, 34, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_11', '2025-07-29 07:53:48', 'active', 'stem', '12345'),
(11, 38, 'ST202508041188', 'Monira Kadil', 'wwwww@gmail.com', 'grade_12', '2025-08-04 07:34:40', 'active', 'stem', 'I Miss You');

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
(771, 413, 'I goed to the store yesterday.', 0, 1),
(772, 413, 'I went to the store yesterday.', 1, 2),
(773, 413, 'I goes to the store yesterday.', 0, 3),
(774, 413, 'I goesed to the store yesterday.', 0, 4),
(775, 414, 'knowt', 0, 1),
(776, 414, 'knouight', 0, 2),
(777, 414, 'nouight', 0, 3),
(778, 414, 'knight', 1, 4),
(779, 416, 'a possessive pronoun, e.g. my, your, her, etc.', 1, 1),
(780, 416, 'a determiner, e.g. the, a, some, etc.', 0, 2),
(781, 416, 'an article, e.g. the, a, an, etc.', 0, 3),
(782, 416, 'an adjective, e.g. big, happy, green, etc.', 0, 4),
(783, 417, 'Present Simple', 0, 1),
(784, 417, 'Present Perfect Simple', 0, 2),
(785, 417, 'Past Simple', 0, 3),
(786, 417, 'Future Perfect Continuous', 0, 4),
(787, 418, 'fight', 0, 1),
(788, 418, 'flight', 0, 2),
(789, 418, 'fright', 0, 3),
(790, 418, 'light', 0, 4),
(791, 420, 'The quick brown fox jumps over the lazy dogs.', 1, 1),
(792, 420, 'The quick, brown fox jumps over the lazy, dogs.', 0, 2),
(793, 420, 'The quick brown fox jumps, over the lazy dogs.', 0, 3),
(794, 420, 'The quick brown fox jumps over the lazy. dogs.', 0, 4),
(795, 421, 'Heros', 0, 1),
(796, 421, 'Heroess', 0, 2),
(797, 421, 'Heroes', 1, 3),
(798, 421, 'Heroys', 0, 4),
(799, 422, 'isn\'t', 0, 1),
(800, 422, 'is', 1, 2),
(801, 422, 'am', 0, 3),
(802, 422, 'are', 0, 4),
(803, 424, 'a) in', 0, 1),
(804, 424, 'b) on', 0, 2),
(805, 424, 'c) at', 0, 3),
(806, 424, 'd) towards', 1, 4),
(807, 425, 'a) If I were a bird, I flew away from you. b) If I were a bird, I could fly away. c) If I were a bird, I would fly away', 0, 1),
(808, 427, 'a) Genuine, b) Insincere, c) Artificially, d) Straightforward', 0, 1),
(809, 428, 'I dont know nothing.', 0, 1),
(810, 428, 'I don\'t know nothing.', 1, 2),
(811, 428, 'I doesn\'t know nothing.', 0, 3),
(812, 428, 'I don\'t know nothings.', 0, 4),
(813, 429, 'laid', 1, 1),
(814, 429, 'lays', 0, 2),
(815, 429, 'layed', 0, 3),
(816, 429, 'laysed', 0, 4),
(817, 431, 'bad', 0, 1),
(818, 431, 'badly', 1, 2),
(819, 431, 'good', 0, 3),
(820, 431, 'well', 0, 4),
(821, 432, 'I am work.', 0, 1),
(822, 432, 'I is working.', 0, 2),
(823, 432, 'I works.', 0, 3),
(824, 432, 'I am working.', 1, 4),
(825, 433, 'Daring', 0, 1),
(826, 433, 'Ordinary', 0, 2),
(827, 433, 'Simple', 0, 3),
(828, 433, 'Refined', 1, 4),
(829, 434, 'Confident', 0, 1),
(830, 434, 'Calm', 1, 2),
(831, 434, 'Anxious', 0, 3),
(832, 434, 'Unhappy', 0, 4),
(833, 436, 'I don\'t feel flowers as beautiful as Rose.', 0, 1),
(834, 436, 'I don\'t feel flowers as beautiful Roses.', 0, 2),
(835, 436, 'Roses don\'t I feel as beautiful as feel flowers.', 0, 3),
(836, 436, 'Roses, I don\'t feel as beautiful as feel flowers.', 0, 4),
(837, 437, 'Her dream was to becomes a doctor.', 0, 1),
(838, 437, 'Her dream was to becomings a doctor.', 0, 2),
(839, 437, 'Her dream was to be a doctor.', 1, 3),
(840, 437, 'Her dream was to becoming a doctor.', 0, 4),
(841, 438, 'hot - cold', 0, 1),
(842, 438, 'quick - slowly', 1, 2),
(843, 438, 'up - down', 0, 3),
(844, 438, 'light - heavy', 0, 4),
(845, 440, 'I can\'t wait for summer, the beach and to read a good book.', 0, 1),
(846, 440, 'I can\'t wait for summerthe beach and to read a good book.', 0, 2),
(847, 440, 'I can\'t wait, for summer, the beach and to read a good book.', 0, 3),
(848, 440, 'I can\'t wait for summer. The beach, and to read a good book.', 1, 4),
(849, 441, 'I feel really embarrassed _______ I tripped on the stairs.', 0, 1),
(850, 441, 'I feel really embarrassed felt I tripped on the stairs.', 1, 2),
(851, 441, 'I feel really embarrassed feeling I tripped on the stairs.', 0, 3),
(852, 441, 'I feel really embarrassed have felt I tripped on the stairs.', 0, 4),
(853, 443, 'dynamite', 0, 1),
(854, 443, 'dynamical', 1, 2),
(855, 443, 'dynamically', 0, 3),
(856, 443, 'dynamism', 0, 4),
(857, 444, 'I am running as fast as I can to catch the bus.', 1, 1),
(858, 444, 'She have dance after school every day.', 0, 2),
(859, 444, 'He doesn\'t likes fruits.', 0, 3),
(860, 444, 'They is going toUSA next month.', 0, 4),
(861, 445, 'bring', 1, 1),
(862, 445, 'bringed', 0, 2),
(863, 445, 'bringing', 0, 3),
(864, 445, 'brought', 0, 4),
(865, 446, 'cheering', 0, 1),
(866, 446, 'encouraging', 0, 2),
(867, 446, 'demotivating', 1, 3),
(868, 446, 'animating', 0, 4),
(869, 448, 'ate', 1, 1),
(870, 448, 'eats', 0, 2),
(871, 448, 'eating', 0, 3),
(872, 448, 'ate to', 0, 4),
(873, 449, 'There are two shoep in the pen.', 0, 1),
(874, 449, 'There are two sheep in the pen.', 1, 2),
(875, 449, 'There are two sheeps in the pen.', 0, 3),
(876, 449, 'There are two sheeps\'s in the pen.', 0, 4),
(877, 450, 'Angry', 0, 1),
(878, 450, 'Upset', 0, 2),
(879, 450, 'Jovial', 1, 3),
(880, 450, 'Sad', 0, 4),
(881, 451, 'The dog is big-er than the cat.', 0, 1),
(882, 451, 'The dog is bigger than the cat.', 1, 2),
(883, 451, 'The dog is bigs than the cat.', 0, 3),
(884, 451, 'The dog is bigerly than the cat.', 0, 4),
(885, 452, 'Sad', 0, 1),
(886, 452, 'Joyful', 1, 2),
(887, 452, 'Sick', 0, 3),
(888, 452, 'Angry', 0, 4),
(889, 453, 'teeth', 0, 1),
(890, 453, 'teeths', 1, 2),
(891, 453, 'teethy', 0, 3),
(892, 453, 'toothers', 0, 4),
(893, 454, 'I\'m = Im', 0, 1),
(894, 454, 'I\'s = Is', 0, 2),
(895, 454, 'It\'s = It', 1, 3),
(896, 454, 'There\'s = Their', 0, 4),
(897, 455, 'captivation', 0, 1),
(898, 455, 'mazel', 0, 2),
(899, 455, 'present', 1, 3),
(900, 455, 'gratitude', 0, 4),
(901, 456, 'I can go\'s to school tomorrow.', 0, 1),
(902, 456, 'I will goes to school tomorrow.', 0, 2),
(903, 456, 'I can go to school tomorrow.', 1, 3),
(904, 456, 'I will go\'s to school tomorrow.', 0, 4),
(905, 457, 'He doesn\'t _______ the book (read).', 0, 1),
(906, 457, 'He don\'t read the book.', 0, 2),
(907, 457, 'He don\'t reads the book.', 0, 3),
(908, 457, 'He doesn\'t reads the book.', 0, 4),
(909, 458, 'I\'ve notes seen.', 0, 1),
(910, 458, 'I\'ve not seen.', 1, 2),
(911, 458, 'I\'ve notes', 0, 3),
(912, 458, 'I\'ve nots', 0, 4),
(913, 459, 'He walks to the school (Present Simple)', 1, 1),
(914, 459, 'He walks\'s to the school (Present Simple)', 0, 2),
(915, 459, 'He walk\'s to the school (Present Simple)', 0, 3),
(916, 459, 'He walks the school to (Present Simple)', 0, 4),
(917, 460, 'Sheep', 1, 1),
(918, 460, 'Sheeps', 0, 2),
(919, 460, 'Sheep\'s', 0, 3),
(920, 460, 'Sheeped', 0, 4),
(921, 461, 'I am reading a book.', 1, 1),
(922, 461, 'I reads a book.', 0, 2),
(923, 461, 'I read a book.', 0, 3),
(924, 461, 'I is reading a book.', 0, 4),
(925, 462, 'Calm', 0, 1),
(926, 462, 'Angry', 0, 2),
(927, 462, 'Joyous', 0, 3),
(928, 462, 'Irate', 1, 4),
(929, 463, 'I amnt', 0, 1),
(930, 463, 'I ain\'t', 1, 2),
(931, 463, 'I haven\'t', 0, 3),
(932, 463, 'I\'m haven\'t', 0, 4),
(933, 464, 'went', 1, 1),
(934, 464, 'going', 0, 2),
(935, 464, 'will go', 0, 3),
(936, 464, 'might go', 0, 4),
(937, 465, 'dont\'ve', 0, 1),
(938, 465, 'dont hav', 0, 2),
(939, 465, 'dont\'v', 0, 3),
(940, 465, 'dont Hav', 0, 4),
(941, 466, 'aggressive', 0, 1),
(942, 466, 'benevolent', 1, 2),
(943, 466, 'oafish', 0, 3),
(944, 466, 'rude', 0, 4),
(945, 467, 'small', 1, 1),
(946, 467, 'big', 0, 2),
(947, 467, 'large', 0, 3),
(948, 467, 'tiny', 0, 4),
(949, 468, 'The fishes swims in the lake.', 1, 1),
(950, 468, 'She cats a mouse.', 0, 2),
(951, 468, 'The boy\'s play in the park.', 0, 3),
(952, 468, 'The men drinks coffee.', 0, 4),
(953, 469, 'Thier', 0, 1),
(954, 469, 'Tougher', 1, 2),
(955, 469, 'Seperate', 0, 3),
(956, 469, 'Enough', 0, 4),
(957, 470, 'I wouldn\'t of went if I knew.', 0, 1),
(958, 470, 'I wouldn\'t have went if I knew.', 0, 2),
(959, 470, 'I would of went if I knew.', 0, 3),
(960, 470, 'I would\'ve gone if I knew.', 1, 4),
(961, 471, 'help', 1, 1),
(962, 471, 'hehelp', 0, 2),
(963, 471, 'healhelp', 0, 3),
(964, 471, 'helpe', 0, 4),
(965, 472, '4', 0, 1),
(966, 472, '5', 1, 2),
(967, 472, '6', 0, 3),
(968, 472, '7', 0, 4),
(969, 473, '3', 0, 1),
(970, 473, '8', 1, 2),
(971, 473, '1', 0, 3),
(972, 473, '7', 0, 4),
(973, 474, '11', 0, 1),
(974, 474, '14', 0, 2),
(975, 474, '21', 0, 3),
(976, 474, '28', 1, 4),
(977, 475, '2', 0, 1),
(978, 475, '4', 1, 2),
(979, 475, '8', 0, 3),
(980, 475, '9', 0, 4),
(981, 476, 'a) Data file', 0, 1),
(982, 476, 'b) System file', 0, 2),
(983, 476, 'c) Executable file', 1, 3),
(984, 476, 'd) Kernel module', 0, 4),
(985, 477, 'a) Running', 1, 1),
(986, 477, 'b) Suspended', 0, 2),
(987, 477, 'c) Ready', 0, 3),
(988, 477, 'd) Terminated', 0, 4),
(989, 478, '7', 1, 1),
(990, 478, '10', 0, 2),
(991, 478, '12', 0, 3),
(992, 478, '8', 0, 4),
(993, 479, '7', 1, 1),
(994, 479, '9', 0, 2),
(995, 479, '11', 0, 3),
(996, 479, '13', 0, 4),
(997, 480, '10', 0, 1),
(998, 480, '14', 0, 2),
(999, 480, '24', 1, 3),
(1000, 480, '30', 0, 4),
(1001, 481, '9', 1, 1),
(1002, 481, '12', 0, 2),
(1003, 481, '25', 0, 3),
(1004, 481, '27', 0, 4),
(1005, 482, '3', 0, 1),
(1006, 482, '4', 1, 2),
(1007, 482, '5', 0, 3),
(1008, 482, '6', 0, 4),
(1009, 483, '4', 1, 1),
(1010, 483, '3', 0, 2),
(1011, 483, '2', 0, 3),
(1012, 483, '6', 0, 4),
(1013, 484, '5', 0, 1),
(1014, 484, '56', 1, 2),
(1015, 484, '49', 0, 3),
(1016, 484, '60', 0, 4),
(1017, 485, 'y = 11', 1, 1),
(1018, 485, 'y = 10', 0, 2),
(1019, 485, 'y = 5', 0, 3),
(1020, 485, 'y = 13', 0, 4),
(1021, 486, '9', 0, 1),
(1022, 486, '10', 0, 2),
(1023, 486, '12', 1, 3),
(1024, 486, '14', 0, 4),
(1025, 487, '21', 0, 1),
(1026, 487, '24', 1, 2),
(1027, 487, '27', 0, 3),
(1028, 487, '32', 0, 4),
(1029, 488, '40', 0, 1),
(1030, 488, '42', 1, 2),
(1031, 488, '49', 0, 3),
(1032, 488, '56', 0, 4),
(1033, 489, '5', 0, 1),
(1034, 489, '25', 1, 2),
(1035, 489, '125', 0, 3),
(1036, 489, '250', 0, 4),
(1037, 490, 'Hydrogen (Hydrogen)', 0, 1),
(1038, 490, 'Oxygen (Oxygen)', 0, 2),
(1039, 490, 'Nitrogen (Nitrogen)', 0, 3),
(1040, 490, 'Helium (Helium)', 1, 4),
(1041, 491, 'George Washington (First President)', 0, 1),
(1042, 491, 'Thomas Jefferson (Founding Father)', 0, 2),
(1043, 491, 'Benjamin Franklin (Inventor & Statesman)', 0, 3),
(1044, 491, 'John Adams (Second President)', 0, 4),
(1061, 497, 'Soccer Application Software', 0, 1),
(1062, 497, 'Statistical Analysis Software', 1, 2),
(1063, 497, 'Software Application System', 0, 3),
(1064, 497, 'Social App Settings', 0, 4),
(1065, 498, 'Data visualization', 0, 1),
(1066, 498, 'Data cleaning', 0, 2),
(1067, 498, 'Data management', 0, 3),
(1068, 498, 'Data generation', 0, 4),
(1069, 498, 'All of the above', 0, 5),
(1070, 499, 'Synthetic Applications System', 0, 1),
(1071, 499, 'Statistical Analysis Software', 1, 2),
(1072, 499, 'Storage Application Server', 0, 3),
(1073, 499, 'Software Application Services', 0, 4),
(1074, 500, 'Data management', 0, 1),
(1075, 500, 'Predictive analytics', 0, 2),
(1076, 500, 'Application development', 0, 3),
(1077, 500, 'Web design', 1, 4),
(1078, 501, 'Data exploration', 1, 1),
(1079, 501, 'Building websites', 0, 2),
(1080, 501, 'Creating artificial intelligence', 0, 3),
(1081, 501, 'Playing music', 0, 4),
(1082, 502, 'Cleaning a house', 0, 1),
(1083, 502, 'Driving a car', 0, 2),
(1084, 502, 'Performing mathematical calculations', 1, 3),
(1085, 502, 'Watering plants', 0, 4),
(1086, 503, 'Reactive Machines', 0, 1),
(1087, 503, 'Limited Memory', 0, 2),
(1088, 503, 'Deterministic', 0, 3),
(1089, 503, 'Pro-Active Machines', 1, 4),
(1090, 504, 'Artificial Intellect', 0, 1),
(1091, 504, 'Artificial Intelligence', 1, 2),
(1092, 504, 'Artificial Ignition', 0, 3),
(1093, 504, 'Artificial Induction', 0, 4),
(1094, 505, 'Solid', 0, 1),
(1095, 505, 'Gas', 0, 2),
(1096, 505, 'Plasma', 1, 3),
(1097, 505, 'Liquid', 0, 4),
(1098, 506, 'Isaac Newton', 0, 1),
(1099, 506, 'Albert Einstein', 0, 2),
(1100, 506, 'Robert Boyle', 0, 3),
(1101, 506, 'James Joule', 1, 4),
(1102, 507, 'Neon', 0, 1),
(1103, 507, 'Argon', 0, 2),
(1104, 507, 'Krypton', 0, 3),
(1105, 507, 'Helium', 1, 4),
(1106, 508, 'Outside the Earth', 0, 1),
(1107, 508, 'Outside the Earth\'s core', 0, 2),
(1108, 508, 'Surrounding the Earth\'s crust', 0, 3),
(1109, 508, 'Inside the Earth between the crust and the core', 1, 4),
(1110, 509, 'Astronomy', 0, 1),
(1111, 509, 'Sociology', 1, 2),
(1112, 509, 'Chemistry', 0, 3),
(1113, 509, 'Biology', 0, 4),
(1114, 510, 'Proton', 0, 1),
(1115, 510, 'Atom', 1, 2),
(1116, 510, 'Electron', 0, 3),
(1117, 510, 'Neutron', 0, 4),
(1118, 511, 'Saturn', 0, 1),
(1119, 511, 'Uranus', 0, 2),
(1120, 511, 'Jupiter', 0, 3),
(1121, 511, 'Mars', 1, 4),
(1122, 512, 'Hydrogen', 0, 1),
(1123, 512, 'Carbon', 1, 2),
(1124, 512, 'Oxygen', 0, 3),
(1125, 512, 'Nitrogen', 0, 4),
(1126, 513, 'New York', 0, 1),
(1127, 513, 'Vermont', 1, 2),
(1128, 513, 'Wyoming', 0, 3),
(1129, 513, 'Colorado', 0, 4),
(1130, 514, 'Earth', 0, 1),
(1131, 514, 'Mars', 0, 2),
(1132, 514, 'Venus', 0, 3),
(1133, 514, 'Jupiter', 1, 4),
(1134, 515, 'Natural Language Processing', 0, 1),
(1135, 515, 'Computer Vision', 0, 2),
(1136, 515, 'Robotics', 0, 3),
(1137, 515, 'Data Mining', 1, 4),
(1138, 516, 'Java', 0, 1),
(1139, 516, 'Python', 1, 2),
(1140, 516, 'C++', 0, 3),
(1141, 516, 'HTML', 0, 4),
(1142, 517, 'Chess', 0, 1),
(1143, 517, 'Checkers', 0, 2),
(1144, 517, 'Bridge', 0, 3),
(1145, 517, 'Go', 1, 4);

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
(177, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:13:51', '2025-08-03 10:13:51', 112, '1'),
(178, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:32:24', '2025-08-03 10:32:24', 177, '1'),
(179, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:33:06', '2025-08-03 10:33:06', 178, '1'),
(180, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:34:07', '2025-08-03 10:34:07', 179, '1'),
(181, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:35:07', '2025-08-03 10:35:07', 180, '1'),
(182, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:36:43', '2025-08-03 10:36:43', 181, '1'),
(183, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:40:01', '2025-08-03 10:40:01', 182, '1'),
(184, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:43:42', '2025-08-03 10:43:42', 183, '1'),
(185, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:46:23', '2025-08-03 10:46:23', 184, '1'),
(186, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:50:38', '2025-08-03 10:50:38', 185, '1'),
(187, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:51:52', '2025-08-03 10:51:52', 186, '1'),
(188, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:53:05', '2025-08-03 10:53:05', 187, '1'),
(189, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:54:38', '2025-08-03 10:54:38', 188, '1'),
(190, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:55:39', '2025-08-03 10:55:39', 189, '1'),
(191, 38, 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', '', NULL, 120, 1, 0, 1, 1, 'published', '2025-08-03 10:57:21', '2025-08-03 10:57:21', 190, '1'),
(192, 38, 'TC202507225654', 'Math (AI Regenerated)', 'fsafasf', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-04 05:59:40', '2025-08-04 05:59:40', 99, '1'),
(193, 38, 'TC202507225654', 'ssssssssss (AI Regenerated)', 'sssssssssssssssss', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-04 07:03:15', '2025-08-04 07:03:15', 102, '1'),
(194, 38, 'TC202507225654', 'Math (AI Regenerated)', 'fsafasf', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-04 10:39:37', '2025-08-04 10:39:37', 99, '1'),
(195, 38, 'TC202507225654', 'Math (AI Regenerated)', 'fsafasf', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-04 10:39:53', '2025-08-04 10:39:53', 194, '1'),
(196, 38, 'TC202507225654', 'Math (AI Regenerated)', 'fsafasf', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-04 10:40:16', '2025-08-04 10:40:16', 195, '1'),
(197, 38, 'TC202507225654', 'ssssssssss (AI Regenerated)', 'sssssssssssssssss', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-06 12:03:16', '2025-08-06 12:03:16', 102, '1'),
(200, 32, 'TC202507225654', 'sas (AI Regenerated)', 'dasdasd', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-06 13:52:51', '2025-08-06 13:52:51', 100, '1'),
(201, 32, 'TC202507225654', 'sas (AI Regenerated)', 'dasdasd', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-06 13:53:53', '2025-08-06 13:53:53', 200, '1'),
(202, 38, 'TC202507225654', 'ssssssssss (AI Regenerated)', 'sssssssssssssssss', NULL, 60, 1, 0, 1, 1, 'published', '2025-08-06 14:02:40', '2025-08-06 14:02:40', 197, '1'),
(203, 32, 'TC202507225654', 'Exploring the Wonders of Science (AI Regenerated)', 'Test your knowledge of biology, chemistry, physics, and earth science with these 10 multiple answer questions. Choose all correct answers for each item!', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-06 14:06:49', '2025-08-06 14:06:49', 89, '1'),
(204, 32, 'TC202507225654', 'Exploring the Wonders of Science (AI Regenerated)', 'Test your knowledge of biology, chemistry, physics, and earth science with these 10 multiple answer questions. Choose all correct answers for each item!', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-06 14:08:06', '2025-08-06 14:08:06', 203, '1'),
(205, 32, 'TC202507225654', 'dddd (AI Regenerated)', 'ddddddddddddddddd', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-14 07:14:38', '2025-08-14 07:14:38', 101, '1'),
(206, 32, 'TC202507225654', 'dddd (AI Regenerated)', 'ddddddddddddddddd', NULL, 30, 1, 0, 1, 1, 'published', '2025-08-14 07:45:11', '2025-08-14 07:45:11', 205, '1');

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
(214, 112, 'ST202507239872', '2025-08-03 10:39:47', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary', NULL, 'manual'),
(225, 177, 'ST202507239872', '2025-08-03 12:32:13', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 112, '1'),
(226, 178, 'ST202507239872', '2025-08-03 12:32:35', NULL, 1, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 177, '1'),
(227, 179, 'ST202507239872', '2025-08-03 12:33:54', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 178, '1'),
(228, 180, 'ST202507239872', '2025-08-03 12:34:51', NULL, 1, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 179, '1'),
(229, 181, 'ST202507239872', '2025-08-03 12:36:23', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 180, '1'),
(230, 182, 'ST202507239872', '2025-08-03 12:38:41', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 181, '1'),
(231, 183, 'ST202507239872', '2025-08-03 12:42:28', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 182, '1'),
(232, 184, 'ST202507239872', '2025-08-03 12:44:39', NULL, 1, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 183, '1'),
(233, 185, 'ST202507239872', '2025-08-03 12:47:22', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 184, '1'),
(234, 186, 'ST202507239872', '2025-08-03 12:51:32', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 185, '1'),
(235, 187, 'ST202507239872', '2025-08-03 12:52:42', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 186, '1'),
(236, 188, 'ST202507239872', '2025-08-03 12:54:19', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 187, '1'),
(237, 189, 'ST202507239872', '2025-08-03 12:55:23', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 188, '1'),
(238, 190, 'ST202507239872', '2025-08-03 12:56:58', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 189, '1'),
(240, 191, 'ST202507239872', '2025-08-04 07:59:07', NULL, 4, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'English Quiz — Basic Grammar & Vocabulary (Regenerated)', 190, '1'),
(241, 99, 'ST202507239872', '2025-08-04 07:59:32', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'Math', NULL, 'manual'),
(242, 192, 'ST202507239872', '2025-08-04 08:00:21', NULL, 3, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'Math (AI Regenerated)', 99, '1'),
(243, 102, 'ST202507239872', '2025-08-04 09:01:18', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'ssssssssss', NULL, 'manual'),
(244, 99, 'ST202508041188', '2025-08-04 12:39:30', NULL, 0, 'failed', 'completed', 'Monira Kadil', 'wwwww@gmail.com', 'grade_12', 'stem', 'I Miss You', 'TC202507225654', 'Math', NULL, 'manual'),
(245, 194, 'ST202508041188', '2025-08-04 12:39:46', NULL, 1, 'failed', 'completed', 'Monira Kadil', 'wwwww@gmail.com', 'grade_12', 'stem', 'I Miss You', 'TC202507225654', 'Math (AI Regenerated)', 99, '1'),
(246, 195, 'ST202508041188', '2025-08-04 12:40:06', NULL, 1, 'failed', 'completed', 'Monira Kadil', 'wwwww@gmail.com', 'grade_12', 'stem', 'I Miss You', 'TC202507225654', 'Math (AI Regenerated)', 194, '1'),
(247, 196, 'ST202508041188', '2025-08-04 12:41:00', NULL, 3, 'passed', 'completed', 'Monira Kadil', 'wwwww@gmail.com', 'grade_12', 'stem', 'I Miss You', 'TC202507225654', 'Math (AI Regenerated)', 195, '1'),
(248, 197, 'ST202507239872', '2025-08-06 15:02:29', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'ssssssssss (AI Regenerated)', 102, '1'),
(252, 89, 'ST202507239872', '2025-08-06 15:45:05', NULL, 5, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'Exploring the Wonders of Science', NULL, 'manual'),
(253, 100, 'ST202507239872', '2025-08-06 15:52:41', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'sas', NULL, 'manual'),
(254, 200, 'ST202507239872', '2025-08-06 15:53:19', NULL, 1, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'sas (AI Regenerated)', 100, '1'),
(255, 201, 'ST202507239872', '2025-08-06 15:54:20', NULL, 2, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'sas (AI Regenerated)', 200, '1'),
(256, 101, 'ST202507239872', '2025-08-06 15:55:41', NULL, 0, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'dddd', NULL, 'manual'),
(257, 202, 'ST202507239872', '2025-08-06 16:03:18', NULL, 2, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'ssssssssss (AI Regenerated)', 197, '1'),
(258, 203, 'ST202507239872', '2025-08-06 16:07:42', NULL, 2, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'Exploring the Wonders of Science (AI Regenerated)', 89, '1'),
(259, 204, 'ST202507239872', '2025-08-06 16:09:37', NULL, 4, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'Exploring the Wonders of Science (AI Regenerated)', 203, '1'),
(260, 205, 'ST202507239872', '2025-08-14 09:45:00', NULL, 1, 'failed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'dddd (AI Regenerated)', 101, '1'),
(261, 206, 'ST202507239872', '2025-08-14 09:49:36', NULL, 2, 'passed', 'completed', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'grade_12', 'stem', '12345', 'TC202507225654', 'dddd (AI Regenerated)', 205, '1');

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
(413, 177, 'multiple-choice', 'Which of the following sentences is correctly written in past tense?', 1, 1, '2025-08-03 10:13:51', '2025-08-03 10:13:51'),
(414, 177, 'multiple-choice', 'Which is the correct spelling of the homophone for \'knight\'?', 1, 2, '2025-08-03 10:13:51', '2025-08-03 10:13:51'),
(415, 177, 'short-answer', 'What is the correct form of the irregular plural for \'child\'?', 1, 3, '2025-08-03 10:13:51', '2025-08-03 10:13:51'),
(416, 178, 'multiple-choice', 'Which of the following should precede \'of\' when used after a noun?', 1, 1, '2025-08-03 10:32:24', '2025-08-03 10:32:24'),
(417, 178, 'multiple-choice', 'Which verb form is used in the continuous tense when the action is happening now?', 1, 2, '2025-08-03 10:32:24', '2025-08-03 10:32:24'),
(418, 178, 'multiple-choice', 'Which of the following is a homophone containing the letters \'ight\' in it?', 1, 3, '2025-08-03 10:32:24', '2025-08-03 10:32:24'),
(419, 178, 'short-answer', 'What is the correct possessive form of the noun \'brother\'?', 1, 4, '2025-08-03 10:32:24', '2025-08-03 10:32:24'),
(420, 179, 'multiple-choice', 'Which of the following sentences is correctly punctuated?', 1, 1, '2025-08-03 10:33:06', '2025-08-03 10:33:06'),
(421, 179, 'multiple-choice', 'Which set of words is correctly spelled?', 1, 2, '2025-08-03 10:33:06', '2025-08-03 10:33:06'),
(422, 179, 'multiple-choice', 'What is the correct form of the verb \'to be\' in the simple present tense for the subject \'she\'?', 1, 3, '2025-08-03 10:33:07', '2025-08-03 10:33:07'),
(423, 179, 'short-answer', 'Write a sentence using the word \'incisive\' in a context that shows your understanding of its meaning.', 1, 4, '2025-08-03 10:33:07', '2025-08-03 10:33:07'),
(424, 180, 'multiple-choice', 'Which of the following is the correct preposition to use with the verb \'approach\': a) in, b) on, c) at, d) towards', 1, 1, '2025-08-03 10:34:07', '2025-08-03 10:34:07'),
(425, 180, 'multiple-choice', 'In which of the following examples is the correct conjunction to use: a) If I were a bird, I _____ away from you. b) If I were a bird, I ______ could fly. c) If I were a bird, I _____ away. ', 1, 2, '2025-08-03 10:34:07', '2025-08-03 10:34:07'),
(426, 180, 'short-answer', 'Rewrite the sentence without changing the meaning: She goes to the school _________ every day.', 1, 3, '2025-08-03 10:34:07', '2025-08-03 10:34:07'),
(427, 180, 'multiple-choice', 'What is the opposite of the word \'sincere\'?', 1, 4, '2025-08-03 10:34:07', '2025-08-03 10:34:07'),
(428, 181, 'multiple-choice', 'Which of the following sentences is grammatically correct?', 1, 1, '2025-08-03 10:35:07', '2025-08-03 10:35:07'),
(429, 181, 'multiple-choice', 'Choose the correct form of the verb \'lay\' when the action is in the past simple tense and the subject is \'he\' or \'she\':', 1, 2, '2025-08-03 10:35:07', '2025-08-03 10:35:07'),
(430, 181, 'short-answer', 'What is the past participle form of the verb \'See\'?', 1, 3, '2025-08-03 10:35:07', '2025-08-03 10:35:07'),
(431, 181, 'multiple-choice', 'Which of the following correctly completes the sentence, \'I felt_______ that I had made a mistake.\'', 1, 4, '2025-08-03 10:35:07', '2025-08-03 10:35:07'),
(432, 182, 'multiple-choice', 'Which of the following is the correct form of the present continuous tense of the verb \'to work\' for the subject \'I\'?', 1, 1, '2025-08-03 10:36:43', '2025-08-03 10:36:43'),
(433, 182, 'multiple-choice', 'Which of the following is the most appropriate synonym for the word \'elegant\' in the context of a fashion show?', 1, 2, '2025-08-03 10:36:43', '2025-08-03 10:36:43'),
(434, 182, 'multiple-choice', 'Choose the correct word to complete the sentence: \'They have never been as _______ as they are now.\'', 1, 3, '2025-08-03 10:36:43', '2025-08-03 10:36:43'),
(435, 182, 'short-answer', 'Rewrite the following sentence in past simple tense: \'The volunteer continues to clean up the park.\'', 1, 4, '2025-08-03 10:36:43', '2025-08-03 10:36:43'),
(436, 183, 'multiple-choice', 'Which of the following sentences is grammatically correct?', 1, 1, '2025-08-03 10:40:01', '2025-08-03 10:40:01'),
(437, 183, 'multiple-choice', 'Choose the correct form of the verb to complete the sentence:', 1, 2, '2025-08-03 10:40:01', '2025-08-03 10:40:01'),
(438, 183, 'multiple-choice', 'Which of the following opposite pairs has a word with a double consonant in the middle?', 1, 3, '2025-08-03 10:40:01', '2025-08-03 10:40:01'),
(439, 183, 'short-answer', 'What is the past tense of the verb \'to work\'?', 1, 4, '2025-08-03 10:40:01', '2025-08-03 10:40:01'),
(440, 184, 'multiple-choice', 'Which of the following sentences is correctly punctuated?', 1, 1, '2025-08-03 10:43:42', '2025-08-03 10:43:42'),
(441, 184, 'multiple-choice', 'Choose the correct form of the verb to complete this sentence:', 1, 2, '2025-08-03 10:43:42', '2025-08-03 10:43:42'),
(442, 184, 'short-answer', 'Rewrite the following sentence, making sure the subject-verb agreement is correct.', 1, 3, '2025-08-03 10:43:42', '2025-08-03 10:43:42'),
(443, 184, 'multiple-choice', 'Which of the following phrases is a proper adjective to describe a person?', 1, 4, '2025-08-03 10:43:42', '2025-08-03 10:43:42'),
(444, 185, 'multiple-choice', 'Which of the following sentences is correctly formed in the present continuous tense?', 1, 1, '2025-08-03 10:46:23', '2025-08-03 10:46:23'),
(445, 185, 'multiple-choice', 'Choose the correct form of the verb to complete the sentence: \'I ___ (always) bring my umbrella when it rains.\'', 1, 2, '2025-08-03 10:46:23', '2025-08-03 10:46:23'),
(446, 185, 'multiple-choice', 'Which word is a synonym for \'discouraging\' as used in the sentence: \'Her silent treatment was quite discouraging, leaving him in low spirits.\'', 1, 3, '2025-08-03 10:46:24', '2025-08-03 10:46:24'),
(447, 185, 'short-answer', 'Fill in the blank with the correct form of the verb: \'If you ___ (not study) for the test, you\'ll fail.\'', 1, 4, '2025-08-03 10:46:24', '2025-08-03 10:46:24'),
(448, 186, 'multiple-choice', 'Which of the following is a past tense verb form of the verb \'to eat\'?', 1, 1, '2025-08-03 10:50:38', '2025-08-03 10:50:38'),
(449, 186, 'multiple-choice', 'Which of these sentences correctly uses the plural form of the noun \'sheep\'?', 1, 2, '2025-08-03 10:50:38', '2025-08-03 10:50:38'),
(450, 186, 'multiple-choice', 'Which of the following words is a synonym for \'happy\'?', 1, 3, '2025-08-03 10:50:38', '2025-08-03 10:50:38'),
(451, 186, 'multiple-choice', 'Which of these sentences correctly uses the correct form of the comparative adjective for \'big\'?', 1, 4, '2025-08-03 10:50:38', '2025-08-03 10:50:38'),
(452, 187, 'multiple-choice', 'Which of the following is a synonym for \'happy\'?', 1, 1, '2025-08-03 10:51:52', '2025-08-03 10:51:52'),
(453, 187, 'multiple-choice', 'Which word is used as the plural form of \'tooth\'?', 1, 2, '2025-08-03 10:51:52', '2025-08-03 10:51:52'),
(454, 187, 'multiple-choice', 'Which of the following is the correct use of the apostrophe?', 1, 3, '2025-08-03 10:51:52', '2025-08-03 10:51:52'),
(455, 187, 'multiple-choice', 'Which word best completes the sentence: The visitor left the office with a__.', 1, 4, '2025-08-03 10:51:52', '2025-08-03 10:51:52'),
(456, 188, 'multiple-choice', 'Which of the following sentences is correct?', 1, 1, '2025-08-03 10:53:05', '2025-08-03 10:53:05'),
(457, 188, 'multiple-choice', 'Fill in the blank with the correct form of the verb in brackets.', 1, 2, '2025-08-03 10:53:05', '2025-08-03 10:53:05'),
(458, 188, 'multiple-choice', 'Which of the following is the correct contraction for \'I have not seen\'?', 1, 3, '2025-08-03 10:53:05', '2025-08-03 10:53:05'),
(459, 188, 'multiple-choice', 'Which of the following is the correct form of the clause?', 1, 4, '2025-08-03 10:53:05', '2025-08-03 10:53:05'),
(460, 189, 'multiple-choice', 'Which of the following is a singular noun?', 1, 1, '2025-08-03 10:54:38', '2025-08-03 10:54:38'),
(461, 189, 'multiple-choice', 'Which of the following sentences is written in the present continuous tense?', 1, 2, '2025-08-03 10:54:38', '2025-08-03 10:54:38'),
(462, 189, 'multiple-choice', 'Which of the following words is a synonym for \'angry\'?', 1, 3, '2025-08-03 10:54:38', '2025-08-03 10:54:38'),
(463, 189, 'multiple-choice', 'Which of the following contractions stands for \'do not have\'?', 1, 4, '2025-08-03 10:54:38', '2025-08-03 10:54:38'),
(464, 190, 'multiple-choice', 'Which of the following is a past tense of the verb \'go\'?', 1, 1, '2025-08-03 10:55:39', '2025-08-03 10:55:39'),
(465, 190, 'multiple-choice', 'Select the correct spelling of the contraction for \'do not have\'.', 1, 2, '2025-08-03 10:55:39', '2025-08-03 10:55:39'),
(466, 190, 'multiple-choice', 'Which of the following words means \'acting friendly and kind towards others\'.', 1, 3, '2025-08-03 10:55:39', '2025-08-03 10:55:39'),
(467, 190, 'multiple-choice', 'Choose the synonym for the word \'slight\'.', 1, 4, '2025-08-03 10:55:39', '2025-08-03 10:55:39'),
(468, 191, 'multiple-choice', 'Which of the following is a correct use of a plural noun?', 1, 1, '2025-08-03 10:57:21', '2025-08-03 10:57:21'),
(469, 191, 'multiple-choice', 'Which word is correctly spelled?', 1, 2, '2025-08-03 10:57:21', '2025-08-03 10:57:21'),
(470, 191, 'multiple-choice', 'Which sentence is grammatically correct?', 1, 3, '2025-08-03 10:57:21', '2025-08-03 10:57:21'),
(471, 191, 'multiple-choice', 'Which word best completes the sentence: \'Please, I need a _____ help.\'', 1, 4, '2025-08-03 10:57:21', '2025-08-03 10:57:21'),
(472, 192, 'multiple-choice', 'What is the result of adding 3 + 2?', 1, 1, '2025-08-04 05:59:40', '2025-08-04 05:59:40'),
(473, 192, 'multiple-choice', 'If a number increased by 5 is 13, what is the original number?', 1, 2, '2025-08-04 05:59:40', '2025-08-04 05:59:40'),
(474, 192, 'multiple-choice', 'What is the product of 7 and 4?', 1, 3, '2025-08-04 05:59:40', '2025-08-04 05:59:40'),
(475, 192, 'multiple-choice', 'What is the square root of 16?', 1, 4, '2025-08-04 05:59:40', '2025-08-04 05:59:40'),
(476, 193, 'multiple-choice', 'What is the executable file of a process in a Unix-like operating system?', 1, 1, '2025-08-04 07:03:15', '2025-08-04 07:03:15'),
(477, 193, 'multiple-choice', 'Which of the following is not a state that a process can be in while it is running?', 1, 2, '2025-08-04 07:03:15', '2025-08-04 07:03:15'),
(478, 194, 'multiple-choice', 'What is the result of adding 3 and 5?', 1, 1, '2025-08-04 10:39:37', '2025-08-04 10:39:37'),
(479, 194, 'multiple-choice', 'Which of the following is a prime number?', 1, 2, '2025-08-04 10:39:37', '2025-08-04 10:39:37'),
(480, 194, 'multiple-choice', 'What is the product of 4 and 6?', 1, 3, '2025-08-04 10:39:37', '2025-08-04 10:39:37'),
(481, 194, 'multiple-choice', 'What is the square of 3?', 1, 4, '2025-08-04 10:39:37', '2025-08-04 10:39:37'),
(482, 195, 'multiple-choice', 'What is the value of x in the equation 2x + 5 = 13?', 1, 1, '2025-08-04 10:39:53', '2025-08-04 10:39:53'),
(483, 195, 'multiple-choice', 'What is the result of 24 divided by 6?', 1, 2, '2025-08-04 10:39:53', '2025-08-04 10:39:53'),
(484, 195, 'multiple-choice', 'What is the product of 7 and 8?', 1, 3, '2025-08-04 10:39:53', '2025-08-04 10:39:53'),
(485, 195, 'multiple-choice', 'Solve for y in the equation y - 3 = 8. The solution is: ', 1, 4, '2025-08-04 10:39:53', '2025-08-04 10:39:53'),
(486, 196, 'multiple-choice', 'What is the sum of 7 and 5?', 1, 1, '2025-08-04 10:40:16', '2025-08-04 10:40:16'),
(487, 196, 'multiple-choice', 'What is the product of 8 and 3?', 1, 2, '2025-08-04 10:40:16', '2025-08-04 10:40:16'),
(488, 196, 'multiple-choice', 'What is the product of 7 and 6 when multiplied?', 1, 3, '2025-08-04 10:40:16', '2025-08-04 10:40:16'),
(489, 196, 'multiple-choice', 'What is the area of a square with a side length of 5 units?', 1, 4, '2025-08-04 10:40:16', '2025-08-04 10:40:16'),
(490, 197, 'multiple-choice', 'Which of the following elements is a member of the noble gases?', 1, 1, '2025-08-06 12:03:16', '2025-08-06 12:03:16'),
(491, 197, 'multiple-choice', 'Who established the United States of America in 1776?', 1, 2, '2025-08-06 12:03:16', '2025-08-06 12:03:16'),
(497, 200, 'multiple-choice', 'What does SAS stand for in the context of information technology?', 1, 1, '2025-08-06 13:52:51', '2025-08-06 13:52:51'),
(498, 200, 'multiple-choice', 'What is the primary purpose of SAS?', 1, 2, '2025-08-06 13:52:51', '2025-08-06 13:52:51'),
(499, 201, 'multiple-choice', 'What does SAS stand for in the context of technology?', 1, 1, '2025-08-06 13:53:54', '2025-08-06 13:53:54'),
(500, 201, 'multiple-choice', 'Which of the following is NOT a primary function of SAS?', 1, 2, '2025-08-06 13:53:54', '2025-08-06 13:53:54'),
(501, 201, 'multiple-choice', 'SAS is often used for ________, among other things.', 1, 3, '2025-08-06 13:53:56', '2025-08-06 13:53:56'),
(502, 202, 'multiple-choice', 'Which of the following is a task commonly performed by Artificial Intelligence?', 1, 1, '2025-08-06 14:02:40', '2025-08-06 14:02:40'),
(503, 202, 'multiple-choice', 'Which of the following is NOT a type of AI used today?', 1, 2, '2025-08-06 14:02:40', '2025-08-06 14:02:40'),
(504, 202, 'multiple-choice', 'What does AI stand for in full?', 1, 3, '2025-08-06 14:02:40', '2025-08-06 14:02:40'),
(505, 203, 'multiple-choice', 'Which of the following is NOT a state of matter?', 1, 1, '2025-08-06 14:06:49', '2025-08-06 14:06:49'),
(506, 203, 'multiple-choice', ' Who proposed the Law of Conservation of Energy?', 1, 2, '2025-08-06 14:06:49', '2025-08-06 14:06:49'),
(507, 203, 'multiple-choice', 'Which of the following elements is NOT a member of the periodic table\'s Noble Gas group?', 1, 3, '2025-08-06 14:06:49', '2025-08-06 14:06:49'),
(508, 203, 'multiple-choice', 'Where would you most likely find the Earth\'s mantle?', 1, 4, '2025-08-06 14:06:49', '2025-08-06 14:06:49'),
(509, 204, 'multiple-choice', 'Which of these is NOT a branch of science?', 1, 1, '2025-08-06 14:08:06', '2025-08-06 14:08:06'),
(510, 204, 'multiple-choice', 'What is the basic unit of matter in the periodic table?', 1, 2, '2025-08-06 14:08:06', '2025-08-06 14:08:06'),
(511, 204, 'multiple-choice', 'Which planet is known as the \'Red Planet\'?', 1, 3, '2025-08-06 14:08:06', '2025-08-06 14:08:06'),
(512, 204, 'multiple-choice', 'Which of these elements is vital for photosynthesis in plants?', 1, 4, '2025-08-06 14:08:06', '2025-08-06 14:08:06'),
(513, 205, 'multiple-choice', 'Which of the following is NOT a U.S. state?', 1, 1, '2025-08-14 07:14:38', '2025-08-14 07:14:38'),
(514, 205, 'multiple-choice', 'What is the largest planet in our solar system?', 1, 2, '2025-08-14 07:14:38', '2025-08-14 07:14:38'),
(515, 206, 'multiple-choice', 'Which of the following is NOT a category of artificial intelligence?', 1, 1, '2025-08-14 07:45:11', '2025-08-14 07:45:11'),
(516, 206, 'multiple-choice', 'Which programming language is commonly used for developing AI algorithms?', 1, 2, '2025-08-14 07:45:11', '2025-08-14 07:45:11'),
(517, 206, 'multiple-choice', 'AI technology is commonly used to beat humans at which of the following strategy games?', 1, 3, '2025-08-14 07:45:11', '2025-08-14 07:45:11');

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
(82, 415, 'children', 0),
(83, 423, 'The editor\'s incisive analysis of the politician\'s speech revealed a lack of substance in his arguments.', 0),
(84, 426, 'She attends school every day.', 0),
(85, 430, 'seen', 0),
(86, 439, 'worked', 0),
(87, 442, 'People don\'t haven\'t seen the movie yet.', 0),
(88, 447, 'don\'t', 0);

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
(5, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$PG82oXpmFrptMFkSeFKLLuPO/e4j2IkMyazbx2TtpjHJe0TNX7CNa', '12345', 'grade_12', 'stem', '2025-07-23 06:32:18', '2025-08-14 08:58:14', 'ST202507239872_689da526e9656.jpeg'),
(6, 'ST202508041188', 'Monira Kadil', 'wwwww@gmail.com', 'student', '$2y$10$Sn3sC/ZRnGn.0xkRDyaP..i1Cf04PZ5RF.n47.8AWrWIOSBPQY.Ee', 'I Miss You', 'grade_12', 'stem', '2025-08-04 07:33:29', '2025-08-04 08:37:14', 'ST202508041188_68906fed2a4c1.jpeg');

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
(714, 214, 172, '123', NULL, 0, 0, '2025-08-03 16:39:47'),
(715, 214, 173, '127', NULL, 0, 0, '2025-08-03 16:39:47'),
(754, 225, 413, '771', NULL, 0, 0, '2025-08-03 18:32:13'),
(755, 225, 414, '775', NULL, 0, 0, '2025-08-03 18:32:13'),
(756, 225, 415, NULL, 'asd', 0, 0, '2025-08-03 18:32:13'),
(757, 226, 416, '779', NULL, 1, 1, '2025-08-03 18:32:35'),
(758, 226, 417, '783', NULL, 0, 0, '2025-08-03 18:32:35'),
(759, 226, 418, '788', NULL, 0, 0, '2025-08-03 18:32:35'),
(760, 226, 419, NULL, 'sdas', 0, 0, '2025-08-03 18:32:35'),
(761, 227, 420, '793', NULL, 0, 0, '2025-08-03 18:33:54'),
(762, 227, 421, '797', NULL, 1, 1, '2025-08-03 18:33:54'),
(763, 227, 422, '800', NULL, 1, 1, '2025-08-03 18:33:54'),
(764, 227, 423, NULL, 's', 0, 0, '2025-08-03 18:33:54'),
(765, 228, 424, '806', NULL, 1, 1, '2025-08-03 18:34:51'),
(766, 228, 425, '807', NULL, 0, 0, '2025-08-03 18:34:51'),
(767, 228, 426, NULL, 'x', 0, 0, '2025-08-03 18:34:51'),
(768, 228, 427, '808', NULL, 0, 0, '2025-08-03 18:34:51'),
(769, 229, 428, '810', NULL, 1, 1, '2025-08-03 18:36:23'),
(770, 229, 429, '813', NULL, 1, 1, '2025-08-03 18:36:23'),
(771, 229, 430, NULL, 'saw', 0, 0, '2025-08-03 18:36:23'),
(772, 229, 431, '817', NULL, 0, 0, '2025-08-03 18:36:23'),
(773, 230, 432, '824', NULL, 1, 1, '2025-08-03 18:38:41'),
(774, 230, 433, '828', NULL, 1, 1, '2025-08-03 18:38:41'),
(775, 230, 434, '831', NULL, 0, 0, '2025-08-03 18:38:41'),
(776, 230, 435, NULL, 'The volunteer continued to clean up the park.', 0, 0, '2025-08-03 18:38:41'),
(777, 231, 436, '834', NULL, 0, 0, '2025-08-03 18:42:28'),
(778, 231, 437, '839', NULL, 1, 1, '2025-08-03 18:42:28'),
(779, 231, 438, '842', NULL, 1, 1, '2025-08-03 18:42:28'),
(780, 231, 439, NULL, 'k', 0, 0, '2025-08-03 18:42:28'),
(781, 232, 440, '848', NULL, 1, 1, '2025-08-03 18:44:39'),
(782, 232, 441, '852', NULL, 0, 0, '2025-08-03 18:44:39'),
(783, 232, 442, NULL, 's', 0, 0, '2025-08-03 18:44:39'),
(784, 232, 443, '853', NULL, 0, 0, '2025-08-03 18:44:39'),
(785, 233, 444, '857', NULL, 1, 1, '2025-08-03 18:47:22'),
(786, 233, 445, '861', NULL, 1, 1, '2025-08-03 18:47:22'),
(787, 233, 446, '866', NULL, 0, 0, '2025-08-03 18:47:22'),
(788, 233, 447, NULL, 'a', 0, 0, '2025-08-03 18:47:22'),
(789, 234, 448, '869', NULL, 1, 1, '2025-08-03 18:51:32'),
(790, 234, 449, '875', NULL, 0, 0, '2025-08-03 18:51:32'),
(791, 234, 450, '880', NULL, 0, 0, '2025-08-03 18:51:32'),
(792, 234, 451, '882', NULL, 1, 1, '2025-08-03 18:51:32'),
(793, 235, 452, '886', NULL, 1, 1, '2025-08-03 18:52:42'),
(794, 235, 453, '889', NULL, 0, 0, '2025-08-03 18:52:42'),
(795, 235, 454, '893', NULL, 0, 0, '2025-08-03 18:52:42'),
(796, 235, 455, '899', NULL, 1, 1, '2025-08-03 18:52:42'),
(797, 236, 456, '903', NULL, 1, 1, '2025-08-03 18:54:19'),
(798, 236, 457, '908', NULL, 0, 0, '2025-08-03 18:54:19'),
(799, 236, 458, '910', NULL, 1, 1, '2025-08-03 18:54:19'),
(800, 236, 459, '914', NULL, 0, 0, '2025-08-03 18:54:19'),
(801, 237, 460, '917', NULL, 1, 1, '2025-08-03 18:55:23'),
(802, 237, 461, '921', NULL, 1, 1, '2025-08-03 18:55:23'),
(803, 237, 462, '926', NULL, 0, 0, '2025-08-03 18:55:23'),
(804, 237, 463, '931', NULL, 0, 0, '2025-08-03 18:55:23'),
(805, 238, 464, '933', NULL, 1, 1, '2025-08-03 18:56:58'),
(806, 238, 465, '937', NULL, 0, 0, '2025-08-03 18:56:58'),
(807, 238, 466, '942', NULL, 1, 1, '2025-08-03 18:56:58'),
(808, 238, 467, '948', NULL, 0, 0, '2025-08-03 18:56:58'),
(813, 240, 468, '949', NULL, 1, 1, '2025-08-04 13:59:07'),
(814, 240, 469, '954', NULL, 1, 1, '2025-08-04 13:59:07'),
(815, 240, 470, '960', NULL, 1, 1, '2025-08-04 13:59:07'),
(816, 240, 471, '961', NULL, 1, 1, '2025-08-04 13:59:07'),
(817, 241, 160, '81', NULL, 0, 0, '2025-08-04 13:59:32'),
(818, 241, 161, '86', NULL, 0, 0, '2025-08-04 13:59:32'),
(819, 241, 162, 'false', NULL, 0, 0, '2025-08-04 13:59:32'),
(820, 241, 163, NULL, 'saas', 0, 0, '2025-08-04 13:59:32'),
(821, 242, 472, '966', NULL, 1, 1, '2025-08-04 14:00:21'),
(822, 242, 473, '970', NULL, 1, 1, '2025-08-04 14:00:21'),
(823, 242, 474, '973', NULL, 0, 0, '2025-08-04 14:00:21'),
(824, 242, 475, '978', NULL, 1, 1, '2025-08-04 14:00:21'),
(825, 243, 166, '99', NULL, 0, 0, '2025-08-04 15:01:18'),
(826, 244, 160, '81', NULL, 0, 0, '2025-08-04 18:39:30'),
(827, 244, 161, '86', NULL, 0, 0, '2025-08-04 18:39:30'),
(828, 244, 162, 'true', NULL, 0, 0, '2025-08-04 18:39:30'),
(829, 244, 163, NULL, 'xasd', 0, 0, '2025-08-04 18:39:30'),
(830, 245, 478, '989', NULL, 1, 1, '2025-08-04 18:39:46'),
(831, 245, 479, '994', NULL, 0, 0, '2025-08-04 18:39:46'),
(832, 245, 480, '998', NULL, 0, 0, '2025-08-04 18:39:46'),
(833, 245, 481, '1002', NULL, 0, 0, '2025-08-04 18:39:46'),
(834, 246, 482, '1005', NULL, 0, 0, '2025-08-04 18:40:06'),
(835, 246, 483, '1011', NULL, 0, 0, '2025-08-04 18:40:06'),
(836, 246, 484, '1014', NULL, 1, 1, '2025-08-04 18:40:06'),
(837, 246, 485, '1018', NULL, 0, 0, '2025-08-04 18:40:06'),
(838, 247, 486, '1023', NULL, 1, 1, '2025-08-04 18:41:00'),
(839, 247, 487, '1028', NULL, 0, 0, '2025-08-04 18:41:00'),
(840, 247, 488, '1030', NULL, 1, 1, '2025-08-04 18:41:00'),
(841, 247, 489, '1034', NULL, 1, 1, '2025-08-04 18:41:00'),
(842, 248, 490, '1038', NULL, 0, 0, '2025-08-06 21:02:29'),
(843, 248, 491, '1041', NULL, 0, 0, '2025-08-06 21:02:29'),
(868, 252, 150, '42', NULL, 0, 0, '2025-08-06 21:45:05'),
(869, 252, 151, '47', NULL, 1, 1, '2025-08-06 21:45:05'),
(870, 252, 152, '51', NULL, 1, 1, '2025-08-06 21:45:05'),
(871, 252, 153, '55', NULL, 1, 1, '2025-08-06 21:45:05'),
(872, 252, 154, '59', NULL, 0, 0, '2025-08-06 21:45:05'),
(873, 252, 155, '63', NULL, 0, 0, '2025-08-06 21:45:05'),
(874, 252, 156, '65', NULL, 1, 1, '2025-08-06 21:45:05'),
(875, 252, 157, '69', NULL, 0, 0, '2025-08-06 21:45:05'),
(876, 252, 158, '74', NULL, 1, 1, '2025-08-06 21:45:05'),
(877, 252, 159, '79', NULL, 0, 0, '2025-08-06 21:45:05'),
(878, 253, 164, '91', NULL, 0, 0, '2025-08-06 21:52:41'),
(879, 254, 497, '1062', NULL, 1, 1, '2025-08-06 21:53:19'),
(880, 254, 498, '1069', NULL, 0, 0, '2025-08-06 21:53:19'),
(881, 255, 499, '1071', NULL, 1, 1, '2025-08-06 21:54:20'),
(882, 255, 500, '1077', NULL, 1, 1, '2025-08-06 21:54:20'),
(883, 255, 501, '1080', NULL, 0, 0, '2025-08-06 21:54:20'),
(884, 256, 165, '95', NULL, 0, 0, '2025-08-06 21:55:41'),
(885, 257, 502, '1084', NULL, 1, 1, '2025-08-06 22:03:18'),
(886, 257, 503, '1087', NULL, 0, 0, '2025-08-06 22:03:18'),
(887, 257, 504, '1091', NULL, 1, 1, '2025-08-06 22:03:18'),
(888, 258, 505, '1096', NULL, 1, 1, '2025-08-06 22:07:42'),
(889, 258, 506, '1100', NULL, 0, 0, '2025-08-06 22:07:42'),
(890, 258, 507, '1104', NULL, 0, 0, '2025-08-06 22:07:42'),
(891, 258, 508, '1109', NULL, 1, 1, '2025-08-06 22:07:42'),
(892, 259, 509, '1111', NULL, 1, 1, '2025-08-06 22:09:37'),
(893, 259, 510, '1115', NULL, 1, 1, '2025-08-06 22:09:37'),
(894, 259, 511, '1121', NULL, 1, 1, '2025-08-06 22:09:37'),
(895, 259, 512, '1123', NULL, 1, 1, '2025-08-06 22:09:37'),
(896, 260, 513, '1127', NULL, 1, 1, '2025-08-14 15:45:00'),
(897, 260, 514, '1130', NULL, 0, 0, '2025-08-14 15:45:00'),
(898, 261, 515, '1136', NULL, 0, 0, '2025-08-14 15:49:36'),
(899, 261, 516, '1139', NULL, 1, 1, '2025-08-14 15:49:36'),
(900, 261, 517, '1145', NULL, 1, 1, '2025-08-14 15:49:36');

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
(26, 'ST202507239872', 'Jim Hadjili', 'jim.hadjili@gmail.com', 'student', '$2y$10$PG82oXpmFrptMFkSeFKLLuPO/e4j2IkMyazbx2TtpjHJe0TNX7CNa', '2025-07-23 06:32:18', '2025-08-01 08:09:33'),
(27, 'ST202508041188', 'Monira Kadil', 'wwwww@gmail.com', 'student', '$2y$10$Sn3sC/ZRnGn.0xkRDyaP..i1Cf04PZ5RF.n47.8AWrWIOSBPQY.Ee', '2025-08-04 07:33:29', '2025-08-04 08:37:14');

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
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `class_enrollments_tb`
--
ALTER TABLE `class_enrollments_tb`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1146;

--
-- AUTO_INCREMENT for table `quizzes_tb`
--
ALTER TABLE `quizzes_tb`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `quiz_attempts_tb`
--
ALTER TABLE `quiz_attempts_tb`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `quiz_questions_tb`
--
ALTER TABLE `quiz_questions_tb`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=518;

--
-- AUTO_INCREMENT for table `short_answer_tb`
--
ALTER TABLE `short_answer_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `students_profiles_tb`
--
ALTER TABLE `students_profiles_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_answers_tb`
--
ALTER TABLE `student_answers_tb`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
