<?php
session_start();
include_once '../../Connection/conn.php';

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$student_id = $_GET['student_id'] ?? null;
$class_id = $_GET['class_id'] ?? null;

if (!$student_id || !$class_id) {
    echo "Invalid request. Student ID and Class ID are required.";
    exit;
}

// Fetch student details
$studentStmt = $conn->prepare("
    SELECT sp.*, ce.enrollment_date 
    FROM students_profiles_tb sp
    JOIN class_enrollments_tb ce ON sp.st_id = ce.st_id
    WHERE sp.st_id = ? AND ce.class_id = ?
");
$studentStmt->bind_param("si", $student_id, $class_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();

if ($studentResult->num_rows === 0) {
    echo "Student not found or not enrolled in this class.";
    exit;
}

$student = $studentResult->fetch_assoc();

// Fetch class details
$classStmt = $conn->prepare("
    SELECT * FROM teacher_classes_tb 
    WHERE class_id = ? AND th_id = ?
");
$classStmt->bind_param("is", $class_id, $teacher_id);
$classStmt->execute();
$classResult = $classStmt->get_result();

if ($classResult->num_rows === 0) {
    echo "Class not found or you don't have permission to view it.";
    exit;
}

$classDetails = $classResult->fetch_assoc();

// Get all quizzes in this class - MODIFIED to only show manual quizzes
$quizzesStmt = $conn->prepare("
    SELECT q.*, 
           (SELECT COUNT(*) FROM quiz_attempts_tb WHERE quiz_id = q.quiz_id AND st_id = ?) AS attempt_count
    FROM quizzes_tb q
    WHERE q.class_id = ? 
      AND q.status = 'published' 
      AND q.th_id = ?
      AND q.quiz_type = 'manual'  /* Add this line to filter for manual quizzes only */
    ORDER BY q.created_at DESC
");
$quizzesStmt->bind_param("sis", $student_id, $class_id, $teacher_id);
$quizzesStmt->execute();
$quizzesResult = $quizzesStmt->get_result();
$quizzes = [];

while ($quiz = $quizzesResult->fetch_assoc()) {
    // For each quiz, get the latest attempt if it exists
    $attemptStmt = $conn->prepare("
        SELECT * FROM quiz_attempts_tb 
        WHERE quiz_id = ? AND st_id = ? 
        ORDER BY end_time DESC 
        LIMIT 1
    ");
    $attemptStmt->bind_param("is", $quiz['quiz_id'], $student_id);
    $attemptStmt->execute();
    $attemptResult = $attemptStmt->get_result();

    if ($attemptResult->num_rows > 0) {
        $quiz['latest_attempt'] = $attemptResult->fetch_assoc();
    } else {
        $quiz['latest_attempt'] = null;
    }

    // Get question count for this quiz
    $questionCountStmt = $conn->prepare("
        SELECT COUNT(*) as total_questions FROM quiz_questions_tb 
        WHERE quiz_id = ?
    ");
    $questionCountStmt->bind_param("i", $quiz['quiz_id']);
    $questionCountStmt->execute();
    $questionCountResult = $questionCountStmt->get_result();
    $questionCountRow = $questionCountResult->fetch_assoc();
    $quiz['question_count'] = $questionCountRow['total_questions'];

    // Get all AI-generated versions of this quiz (children)
    $aiVersionsStmt = $conn->prepare("
        WITH RECURSIVE quiz_hierarchy AS (
            SELECT quiz_id, parent_quiz_id, quiz_title 
            FROM quizzes_tb 
            WHERE quiz_id = ?
            UNION ALL
            SELECT q.quiz_id, q.parent_quiz_id, q.quiz_title
            FROM quizzes_tb q
            JOIN quiz_hierarchy qh ON q.parent_quiz_id = qh.quiz_id
        )
        SELECT quiz_id FROM quiz_hierarchy WHERE quiz_id != ?
    ");
    $aiVersionsStmt->bind_param("ii", $quiz['quiz_id'], $quiz['quiz_id']);
    $aiVersionsStmt->execute();
    $aiVersionsResult = $aiVersionsStmt->get_result();

    $aiQuizIds = [];
    while ($aiVersion = $aiVersionsResult->fetch_assoc()) {
        $aiQuizIds[] = $aiVersion['quiz_id'];
    }

    // Count attempts on AI-generated versions
    $aiAttemptCount = 0;
    if (!empty($aiQuizIds)) {
        $aiQuizIdsStr = implode(',', $aiQuizIds);
        $aiAttemptsStmt = $conn->prepare("
            SELECT COUNT(*) as ai_attempts 
            FROM quiz_attempts_tb 
            WHERE quiz_id IN ({$aiQuizIdsStr}) AND st_id = ?
        ");
        $aiAttemptsStmt->bind_param("s", $student_id);
        $aiAttemptsStmt->execute();
        $aiAttemptsResult = $aiAttemptsStmt->get_result();
        $aiAttemptsRow = $aiAttemptsResult->fetch_assoc();
        $aiAttemptCount = $aiAttemptsRow['ai_attempts'];
    }

    // Add the AI attempts to the original attempt count
    $quiz['total_attempts'] = $quiz['attempt_count'] + $aiAttemptCount;

    $quizzes[] = $quiz;
}

// Get overall performance metrics
$totalQuizzes = count($quizzes);
$completedQuizzes = 0;
$totalScore = 0;
$totalPossibleScore = 0;

foreach ($quizzes as $quiz) {
    if ($quiz['latest_attempt'] && $quiz['latest_attempt']['status'] === 'completed') {
        $completedQuizzes++;
        $totalScore += $quiz['latest_attempt']['score'];
        $totalPossibleScore += $quiz['question_count'];
    }
}

$averageScore = $totalPossibleScore > 0 ? round(($totalScore / $totalPossibleScore) * 100) : 0;
