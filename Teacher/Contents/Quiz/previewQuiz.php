<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Include required files
include_once '../../Functions/userInfo.php';
include_once 'previewQuizComponents/dataLoader.php';

// Check if quiz_id is provided
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

// Load quiz data and questions
$quiz_id = intval($_GET['quiz_id']);
$teacher_id = $_SESSION['user_id'];
$data = loadQuizData($conn, $quiz_id, $teacher_id);

// If quiz not found or doesn't belong to this teacher, redirect
if (!$data) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

// Extract data
$quiz = $data['quiz'];
$questions = $data['questions'];
$totalPoints = $data['totalPoints'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'previewQuizComponents/header.php'; ?>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 py-8 quiz-container">
        <?php include 'previewQuizComponents/navigation.php'; ?>
        <?php include 'previewQuizComponents/quizHeader.php'; ?>
        
        <!-- Quiz Content Preview -->
        <div class="bg-white rounded-lg shadow-soft mb-6">
            <?php include 'previewQuizComponents/instructions.php'; ?>
            <div class="p-6">
                <?php 
                if (empty($questions)) {
                    include 'previewQuizComponents/emptyState.php';
                } else {
                    include 'previewQuizComponents/questionsList.php';
                }
                ?>
            </div>
        </div>

        <?php include 'previewQuizComponents/footer.php'; ?>
    </div>

    <script src="previewQuizComponents/previewScript.js"></script>
</body>
</html>