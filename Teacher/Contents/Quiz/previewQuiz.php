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

<body class="bg-gray-50 font-[Poppins]">
    <div class="max-w-9xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <?php include "previewQuizComponents/navigation.php" ?>

        <!-- Summary Cards -->
        <?php include "./previewQuizComponents/quizHeader.php" ?>

        <!-- Instructions Card -->
        <?php include "./previewQuizComponents/instructions.php" ?>

        <!-- Quiz Questions Preview -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-question-circle text-green-600"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">Questions</h2>
            </div>
            <div class="p-6">
                <?php
                if (empty($questions)) {
                ?>
                    <div class="text-center py-10">
                        <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-question-circle text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-800 mb-3">No Questions Added</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            This quiz doesn't have any questions yet. Add questions to complete your quiz setup.
                        </p>
                        <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>&section=questions"
                            class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Add Questions
                        </a>
                    </div>
                <?php
                } else {
                    include 'previewQuizComponents/questionsList.php';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="previewQuizComponents/previewScript.js"></script>
</body>

</html>