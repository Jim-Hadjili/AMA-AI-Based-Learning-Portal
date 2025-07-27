<?php
session_start();
include_once '../../../Connection/conn.php';

// Check login
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'student') {
    header("Location: ../../Auth/login.php");
    exit;
}

$quiz_id = $_GET['quiz_id'] ?? null;
$class_id = $_GET['class_id'] ?? null;
$student_id = $_SESSION['st_id'] ?? null;

if (!$quiz_id || !$student_id) {
    echo "Invalid request.";
    exit;
}

// If class_id is not provided in URL, fetch it from the quiz
if (!$class_id) {
    $classStmt = $conn->prepare("SELECT class_id FROM quizzes_tb WHERE quiz_id = ?");
    $classStmt->bind_param("i", $quiz_id);
    $classStmt->execute();
    $classRes = $classStmt->get_result();
    if ($classRow = $classRes->fetch_assoc()) {
        $class_id = $classRow['class_id'];
    }
}

// Fetch quiz info
$quizStmt = $conn->prepare("SELECT quiz_title FROM quizzes_tb WHERE quiz_id = ?");
$quizStmt->bind_param("i", $quiz_id);
$quizStmt->execute();
$quizRes = $quizStmt->get_result();
$quiz = $quizRes->fetch_assoc();

// --- CORRECTED: Fetch total possible points for the quiz from 'quiz_questions_tb' ---
$totalPointsStmt = $conn->prepare("SELECT SUM(question_points) AS total_points FROM quiz_questions_tb WHERE quiz_id = ?");
$totalPointsStmt->bind_param("i", $quiz_id);
$totalPointsStmt->execute();
$totalPointsRes = $totalPointsStmt->get_result();
$totalPointsRow = $totalPointsRes->fetch_assoc();
// Default to 1 to prevent division by zero if no questions or points are defined
$total_possible_points = $totalPointsRow['total_points'] ?? 1; 
if ($total_possible_points == 0) { // Ensure it's at least 1 if sum is 0
    $total_possible_points = 1;
}

// Fetch attempts
$stmt = $conn->prepare("SELECT attempt_id, start_time, end_time, score, result, status FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? ORDER BY attempt_id DESC");
$stmt->bind_param("is", $quiz_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();
$attempts = [];
while ($row = $result->fetch_assoc()) {
    $attempts[] = $row;
}

// Prepare data for Chart.js (reverse order for chronological graph)
$chartLabels = [];
$chartScores = [];
$reversedAttempts = array_reverse($attempts); // Oldest attempt first

foreach ($reversedAttempts as $index => $attempt) {
    $chartLabels[] = 'Attempt ' . ($index + 1); // Label as Attempt 1, Attempt 2, etc.
    // Calculate percentage for chart
    $percentage_for_chart = round(($attempt['score'] / $total_possible_points) * 100);
    $chartScores[] = $percentage_for_chart;
}

$chartLabelsJson = json_encode($chartLabels);
$chartScoresJson = json_encode($chartScores);

?>