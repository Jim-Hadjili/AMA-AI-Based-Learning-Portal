<?php
session_start();
include_once '../../Connection/conn.php';

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$attempt_id = $_GET['attempt_id'] ?? null;

if (!$attempt_id) {
    echo "Invalid request. Attempt ID is required.";
    exit;
}

// Fetch attempt details
$attemptStmt = $conn->prepare("
    SELECT a.*, q.quiz_title, q.class_id, q.time_limit, tc.class_name, tc.strand as subject,
           sp.profile_picture, sp.st_userName as student_name, sp.grade_level, sp.strand
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
$student_id = $attempt['st_id'];
$quiz_title = $attempt['quiz_title'];

// Make $quiz available for breadcrumb and other includes
$quiz = [
    'class_name' => $attempt['class_name'],
    'quiz_title' => $attempt['quiz_title']
];

// Fetch all questions for this quiz
$questionsStmt = $conn->prepare("
    SELECT * FROM quiz_questions_tb 
    WHERE quiz_id = ? 
    ORDER BY question_order
");
$questionsStmt->bind_param("i", $quiz_id);
$questionsStmt->execute();
$questionsResult = $questionsStmt->get_result();
$questions = [];
$totalPossiblePoints = 0;

while ($question = $questionsResult->fetch_assoc()) {
    $questions[$question['question_id']] = $question;
    $totalPossiblePoints += $question['question_points'];
}

// Fetch student answers
$answersStmt = $conn->prepare("
    SELECT * FROM student_answers_tb
    WHERE attempt_id = ?
");
$answersStmt->bind_param("i", $attempt_id);
$answersStmt->execute();
$answersResult = $answersStmt->get_result();
$answers = [];
$totalPointsEarned = 0;

while ($answer = $answersResult->fetch_assoc()) {
    $answers[$answer['question_id']] = $answer;
    $totalPointsEarned += ($answer['is_correct'] ? $questions[$answer['question_id']]['question_points'] : 0);
}

// Calculate time spent
$startTime = new DateTime($attempt['start_time']);
$endTime = new DateTime($attempt['end_time']);
$duration = $startTime->diff($endTime);
$timeSpent = '';

if ($duration->h > 0) {
    $timeSpent .= $duration->h . ' hour' . ($duration->h > 1 ? 's' : '') . ' ';
}
if ($duration->i > 0) {
    $timeSpent .= $duration->i . ' minute' . ($duration->i > 1 ? 's' : '') . ' ';
}
if ($duration->s > 0 || $timeSpent === '') {
    $timeSpent .= $duration->s . ' second' . ($duration->s !== 1 ? 's' : '');
}

// Calculate score percentage
$scorePercentage = $totalPossiblePoints > 0 ? round(($totalPointsEarned / $totalPossiblePoints) * 100) : 0;

// Get average score of all students who took this quiz
$avgScoreStmt = $conn->prepare("
    SELECT AVG(score) as avg_score
    FROM quiz_attempts_tb
    WHERE quiz_id = ? AND status = 'completed'
");
$avgScoreStmt->bind_param("i", $quiz_id);
$avgScoreStmt->execute();
$avgScoreResult = $avgScoreStmt->get_result();
$avgScoreRow = $avgScoreResult->fetch_assoc();
$avgScore = $avgScoreRow['avg_score'] ? round($avgScoreRow['avg_score'], 1) : 0;

// Get class average percentage
$classAvgPercentage = $totalPossiblePoints > 0 ? round(($avgScore / $totalPossiblePoints) * 100) : 0;

// Function to get options for multiple choice and checkbox questions
function getOptions($conn, $question_id)
{
    $optionsStmt = $conn->prepare("
        SELECT * FROM question_options_tb
        WHERE question_id = ?
        ORDER BY option_order
    ");
    $optionsStmt->bind_param("i", $question_id);
    $optionsStmt->execute();
    $result = $optionsStmt->get_result();
    $options = [];

    while ($option = $result->fetch_assoc()) {
        $options[] = $option;
    }

    return $options;
}

// Function to get correct answer for short answer questions
function getShortAnswer($conn, $question_id)
{
    $stmt = $conn->prepare("
        SELECT * FROM short_answer_tb
        WHERE question_id = ?
    ");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row;
    }

    return null;
}
