<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a student
checkUserAccess('student');

// Get user information
$user_id = $_SESSION['user_id'];
$student_id = $_SESSION['st_id'] ?? null;

// Get quiz ID from URL parameter
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    header("Location: ../Dashboard/studentDashboard.php"); // Redirect if no quiz ID
    exit;
}

$quizDetails = null;
$quizQuestions = [];

// Fetch quiz details
$quizQuery = "SELECT q.quiz_id, q.quiz_title, q.quiz_description, q.time_limit, q.status, q.class_id,
                     (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
                     (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
              FROM quizzes_tb q
              WHERE q.quiz_id = ? AND q.status = 'published'"; // Only published quizzes for students

$stmt = $conn->prepare($quizQuery);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $quizDetails = $result->fetch_assoc();
} else {
    header("Location: ../Dashboard/studentDashboard.php?error=quiz_not_found"); // Quiz not found or not published
    exit;
}

// Check if student is enrolled in the class associated with the quiz
$class_id = $quizDetails['class_id'];
$enrollmentCheck = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ? AND status = 'active'");
if ($student_id) {
    $enrollmentCheck->bind_param("is", $class_id, $student_id);
    $enrollmentCheck->execute();
    if ($enrollmentCheck->get_result()->num_rows === 0) {
        header("Location: ../Dashboard/studentDashboard.php?error=not_enrolled"); // Not enrolled in class
        exit;
    }
} else {
    header("Location: ../../Auth/login.php"); // Student ID not in session
    exit;
}

// Fetch quiz questions and their options
$questionsQuery = "SELECT qq.question_id, qq.question_text, qq.question_type, qq.question_points
                   FROM quiz_questions_tb qq
                   WHERE qq.quiz_id = ?
                   ORDER BY qq.question_order ASC";
$questionsStmt = $conn->prepare($questionsQuery);
$questionsStmt->bind_param("i", $quiz_id);
$questionsStmt->execute();
$questionsResult = $questionsStmt->get_result();

while ($question = $questionsResult->fetch_assoc()) {
    $question_id = $question['question_id'];
    $options = [];

    // Fetch options for multiple-choice and checkbox questions
    if ($question['question_type'] === 'multiple-choice' || $question['question_type'] === 'checkbox') {
        $optionsQuery = "SELECT option_id, option_text FROM question_options_tb WHERE question_id = ? ORDER BY option_order ASC";
        $optionsStmt = $conn->prepare($optionsQuery);
        $optionsStmt->bind_param("i", $question_id);
        $optionsStmt->execute();
        $optionsResult = $optionsStmt->get_result();
        while ($option = $optionsResult->fetch_assoc()) {
            $options[] = $option;
        }
    }
    $question['options'] = $options;
    $quizQuestions[] = $question;
}
?>
