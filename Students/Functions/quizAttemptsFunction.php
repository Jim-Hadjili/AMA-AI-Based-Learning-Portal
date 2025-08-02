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

// Get all quiz IDs: original and all AI-generated descendants
function getAllRelatedQuizIds($conn, $quiz_id) {
    $ids = [$quiz_id];
    $queue = [$quiz_id];
    while (!empty($queue)) {
        $current = array_shift($queue);
        $stmt = $conn->prepare("SELECT quiz_id FROM quizzes_tb WHERE parent_quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $ids[] = $row['quiz_id'];
            $queue[] = $row['quiz_id'];
        }
    }
    return $ids;
}

// Find the original quiz (root of the chain)
function getRootQuizId($conn, $quiz_id) {
    $current = $quiz_id;
    while (true) {
        $stmt = $conn->prepare("SELECT parent_quiz_id FROM quizzes_tb WHERE quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if ($row['parent_quiz_id']) {
                $current = $row['parent_quiz_id'];
            } else {
                break;
            }
        } else {
            break;
        }
    }
    return $current;
}

// Always start from the original quiz
$root_quiz_id = getRootQuizId($conn, $quiz_id);
$allQuizIds = getAllRelatedQuizIds($conn, $root_quiz_id);
$quizIdsStr = implode(',', array_map('intval', $allQuizIds));

// Fetch all attempts for all related quizzes, ordered chronologically
$stmt = $conn->prepare("SELECT attempt_id, quiz_id, start_time, end_time, score, result, status FROM quiz_attempts_tb WHERE quiz_id IN ($quizIdsStr) AND st_id = ? ORDER BY start_time ASC");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$attempts = [];
while ($row = $result->fetch_assoc()) {
    $attempts[] = $row;
}

// Prepare data for Chart.js (reverse order for chronological graph)
$chartLabels = [];
$chartScores = [];
foreach ($attempts as $index => $attempt) {
    $chartLabels[] = 'Attempt ' . ($index + 1);
    // Get total points for this quiz version
    $pointsStmt = $conn->prepare("SELECT SUM(question_points) AS total_points FROM quiz_questions_tb WHERE quiz_id = ?");
    $pointsStmt->bind_param("i", $attempt['quiz_id']);
    $pointsStmt->execute();
    $pointsRes = $pointsStmt->get_result();
    $pointsRow = $pointsRes->fetch_assoc();
    $total_possible_points = $pointsRow['total_points'] ?? 1;
    if ($total_possible_points == 0) $total_possible_points = 1;
    $percentage_for_chart = round(($attempt['score'] / $total_possible_points) * 100);
    $chartScores[] = $percentage_for_chart;
}
$chartLabelsJson = json_encode($chartLabels);
$chartScoresJson = json_encode($chartScores);

?>