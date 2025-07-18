<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a student
checkUserAccess('student');

$user_id = $_SESSION['user_id'];
$student_id = $_SESSION['st_id'] ?? null;
$attempt_id = $_GET['attempt_id'] ?? null;

if (!$student_id || !$attempt_id) {
    header("Location: ../Dashboard/studentDashboard.php?error=missing_attempt_id");
    exit;
}

$quizAttempt = null;
$quizDetails = null;
$quizQuestions = [];
$studentAnswers = [];
$correctAnswersData = []; // To store correct options/answers for review

// Fetch quiz attempt details
$attemptQuery = "SELECT qa.attempt_id, qa.quiz_id, qa.st_id, qa.start_time, qa.end_time, qa.score, qa.status,
                        q.quiz_title, q.quiz_description, q.points_per_question, q.allow_retakes
                 FROM quiz_attempts_tb qa
                 JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
                 WHERE qa.attempt_id = ? AND qa.st_id = ?";
$stmt_attempt = $conn->prepare($attemptQuery);
$stmt_attempt->bind_param("is", $attempt_id, $student_id);
$stmt_attempt->execute();
$result_attempt = $stmt_attempt->get_result();

if ($result_attempt->num_rows > 0) {
    $quizAttempt = $result_attempt->fetch_assoc();
    $quiz_id = $quizAttempt['quiz_id'];
    $quizDetails = [
        'quiz_title' => $quizAttempt['quiz_title'],
        'quiz_description' => $quizAttempt['quiz_description'],
        'points_per_question' => $quizAttempt['points_per_question']
    ];
} else {
    header("Location: ../Dashboard/studentDashboard.php?error=attempt_not_found");
    exit;
}

// Fetch all questions for the quiz
$questionsQuery = "SELECT qq.question_id, qq.question_text, qq.question_type, qq.question_points
                   FROM quiz_questions_tb qq
                   WHERE qq.quiz_id = ?
                   ORDER BY qq.question_order ASC";
$stmt_questions = $conn->prepare($questionsQuery);
$stmt_questions->bind_param("i", $quiz_id);
$stmt_questions->execute();
$result_questions = $stmt_questions->get_result();

$total_questions = 0;
$total_possible_score = 0;
while ($question = $result_questions->fetch_assoc()) {
    $quizQuestions[] = $question;
    $total_questions++;
    $total_possible_score += $question['question_points'];

    // Fetch correct answers for each question for review
    $question_id = $question['question_id'];
    $question_type = $question['question_type'];
    $correct_answer_info = null;

    if ($question_type === 'multiple-choice' || $question_type === 'checkbox' || $question_type === 'true-false') {
        $options_query = "SELECT option_id, option_text, is_correct FROM question_options_tb WHERE question_id = ?";
        $stmt_options = $conn->prepare($options_query);
        $stmt_options->bind_param("i", $question_id);
        $stmt_options->execute();
        $result_options = $stmt_options->get_result();
        $correct_options = [];
        $all_options = [];
        while ($option = $result_options->fetch_assoc()) {
            $all_options[] = $option;
            if ($option['is_correct']) {
                $correct_options[] = $option['option_text'];
            }
        }
        $correct_answer_info = ['options' => $all_options, 'correct_text' => implode(', ', $correct_options)];
    } elseif ($question_type === 'short-answer') {
        $short_answer_query = "SELECT correct_answer FROM short_answer_tb WHERE question_id = ?";
        $stmt_short_answer = $conn->prepare($short_answer_query);
        $stmt_short_answer->bind_param("i", $question_id);
        $stmt_short_answer->execute();
        $result_short_answer = $stmt_short_answer->get_result();
        if ($sa = $result_short_answer->fetch_assoc()) {
            $correct_answer_info = ['correct_text' => $sa['correct_answer']];
        }
    }
    $correctAnswersData[$question_id] = $correct_answer_info;
}

// Fetch student's answers for this attempt
$studentAnswersQuery = "SELECT sa.question_id, sa.selected_options, sa.text_answer, sa.is_correct, sa.points_awarded
                        FROM student_answers_tb sa
                        WHERE sa.attempt_id = ?";
$stmt_student_answers = $conn->prepare($studentAnswersQuery);
$stmt_student_answers->bind_param("i", $attempt_id);
$stmt_student_answers->execute();
$result_student_answers = $stmt_student_answers->get_result();

$correct_answers_count = 0;
while ($answer = $result_student_answers->fetch_assoc()) {
    $studentAnswers[$answer['question_id']] = $answer;
    if ($answer['is_correct']) {
        $correct_answers_count++;
    }
}

$percentage_score = ($total_possible_score > 0) ? round(($quizAttempt['score'] / $total_possible_score) * 100, 2) : 0;

define('PASSING_THRESHOLD', 75);
$has_passed = ($percentage_score >= PASSING_THRESHOLD);
