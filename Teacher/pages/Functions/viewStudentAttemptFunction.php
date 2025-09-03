<?php
session_start();
include_once '../../Connection/conn.php';

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$attempt_id = $_GET['attempt_id'] ?? null;

if (!$attempt_id) {
    echo "Invalid request. Attempt ID is required.";
    exit;
}

// Fetch attempt details - updated to use teacher_classes_tb instead of class_tb
$attemptStmt = $conn->prepare("
    SELECT a.*, q.quiz_title, q.class_id, tc.class_name, tc.strand as subject,
           sp.profile_picture
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
    LEFT JOIN students_profiles_tb sp ON a.st_id = sp.st_id
    WHERE a.attempt_id = ? AND q.th_id = ?
");
$attemptStmt->bind_param("is", $attempt_id, $teacher_id);
$attemptStmt->execute();
$attemptResult = $attemptStmt->get_result();

if ($attemptResult->num_rows === 0) {
    echo "Attempt not found or you don't have permission to view it.";
    exit;
}

$attempt = $attemptResult->fetch_assoc();
$quiz_id = $attempt['quiz_id'];
$class_id = $attempt['class_id'];
$student_id = $attempt['st_id'];

// Make $quiz available for breadcrumb and other includes
$quiz = [
    'class_name' => $attempt['class_name'],
    'quiz_title' => $attempt['quiz_title']
];

// Fetch student answers
$answersStmt = $conn->prepare("
    SELECT sa.*, 
           qq.question_text, 
           qq.question_type,
           qq.question_points
    FROM student_answers_tb sa
    JOIN quiz_questions_tb qq ON sa.question_id = qq.question_id
    WHERE sa.attempt_id = ?
    ORDER BY qq.question_order
");
$answersStmt->bind_param("i", $attempt_id);
$answersStmt->execute();
$answersResult = $answersStmt->get_result();
$answers = [];

while ($row = $answersResult->fetch_assoc()) {
    $answers[] = $row;
}

// Calculate summary
$totalPoints = array_sum(array_column($answers, 'question_points'));
$earnedPoints = array_sum(array_column($answers, 'points_earned'));
$scorePercent = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;

// Format timestamps
$startTime = new DateTime($attempt['start_time']);
$endTime = new DateTime($attempt['end_time']);
$duration = $startTime->diff($endTime);
$durationStr = '';

if ($duration->h > 0) {
    $durationStr .= $duration->h . ' hour' . ($duration->h > 1 ? 's' : '') . ' ';
}
if ($duration->i > 0) {
    $durationStr .= $duration->i . ' minute' . ($duration->i > 1 ? 's' : '') . ' ';
}
if ($duration->s > 0 || $durationStr === '') {
    $durationStr .= $duration->s . ' second' . ($duration->s !== 1 ? 's' : '');
}

// ==================== Get all related quizzes for this student ====================
// Helper function to get the root quiz (original teacher-created quiz)
function getRootQuizId($conn, $quiz_id)
{
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

// Helper function to get all related quizzes (original + AI-generated versions)
function getAllRelatedQuizIds($conn, $quiz_id)
{
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

// Find the root quiz ID
$root_quiz_id = getRootQuizId($conn, $quiz_id);

// Get all related quiz IDs
$all_quiz_ids = getAllRelatedQuizIds($conn, $root_quiz_id);
$quiz_ids_str = implode(',', array_map('intval', $all_quiz_ids));

// Fetch all attempts for this student on any version of this quiz
// Fetch all attempts in chronological order (oldest first)
$allAttemptsStmt = $conn->prepare("
    SELECT a.attempt_id, a.quiz_id, a.start_time, a.end_time, a.score, 
           a.result, q.quiz_title, q.parent_quiz_id
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    WHERE a.st_id = ? AND a.quiz_id IN ($quiz_ids_str)
    ORDER BY a.start_time ASC
");
$allAttemptsStmt->bind_param("s", $student_id);
$allAttemptsStmt->execute();
$allAttemptsResult = $allAttemptsStmt->get_result();
$allAttempts = [];

while ($row = $allAttemptsResult->fetch_assoc()) {
    $allAttempts[] = $row;
}

// Assign chronological attempt numbers (1 for oldest, higher numbers for newer)
$totalAttempts = count($allAttempts);
foreach ($allAttempts as $index => $a) {
    // Add the chronological attempt number (counting from 1)
    $allAttempts[$index]['attempt_number'] = $index + 1;

    if ($a['attempt_id'] == $attempt_id) {
        $currentAttemptIndex = $index;
    }
}

// Create a copy of the original chronological array for the chart
$chronologicalAttempts = $allAttempts;

// Now sort the display array to show AI-generated ones first, then original ones
// But preserve the original attempt numbers
usort($allAttempts, function ($a, $b) {
    // If one is AI-generated and the other isn't, prioritize AI-generated
    if ($a['parent_quiz_id'] && !$b['parent_quiz_id']) {
        return -1; // a comes first
    }
    if (!$a['parent_quiz_id'] && $b['parent_quiz_id']) {
        return 1; // b comes first
    }

    // If both are the same type, sort by attempt number in DESCENDING order (newest first)
    return $b['attempt_number'] - $a['attempt_number'];
});
