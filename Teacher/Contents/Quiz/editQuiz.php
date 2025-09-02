<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Include helper functions
include_once '../../Functions/quiz-data-processor.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Check if quiz_id is provided
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$quiz_id = intval($_GET['quiz_id']);
$teacher_id = $_SESSION['user_id'];

// Get quiz data and questions
$quiz = getQuizDetails($conn, $quiz_id, $teacher_id);
$questions = getQuizQuestions($conn, $quiz_id);
$processedQuestions = processQuestionsForJavaScript($questions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/quiz-header.php'; ?>
</head>

<body class="bg-gray-100 min-h-screen font-[sans-serif]">

    <!-- Notification Container -->
    <div id="notification-container"></div>

    <div class="max-w-9xl mx-auto px-4 py-6 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <?php include "includes/editQuizBreadcrumb.php" ?>

        <!-- Main Card -->
        <?php include "includes/quiz-nav.php" ?>

        <!-- Main Content: Single Column Layout -->
        <div class="flex flex-col gap-8">

            <!-- Top Row: Quiz Settings & Add Question Type -->
            <div class="flex flex-row gap-8">

                <!-- Quiz Settings Card -->
                <?php include "includes/quiz-settings-form.php"; ?>

                <!-- Add Question Type Card -->
                <?php include "includes/question-types.php"; ?>

                <!-- Quiz Info Card -->
                <?php include "includes/quiz-info-card.php"; ?>

            </div>

            <!-- Bottom Row: Questions & Question Editor -->
            <div class="flex flex-row gap-8">
                <!-- Question Editor Card (Wider) -->
                <?php include "includes/question-editor.php"; ?>

                <!-- Questions List Card -->
                <?php include "includes/question-list.php"; ?>
            </div>
        </div>
    </div>

    <!-- Quiz Editor JS Files -->
    <script src="../../Assets/Js/quizEditor.js"></script>
    <script src="../../Assets/Js/questionManager.js"></script>
    <script src="../../Assets/Js/questionEvents.js"></script>
    <script src="../../Assets/Js/questionOperations.js"></script>
    <script src="../../Assets/Js/quizSave.js"></script>

    <script>
        // Initialize with existing questions data
        document.addEventListener('DOMContentLoaded', function() {
            initializeQuizEditor(
                <?php echo json_encode($processedQuestions); ?>,
                <?php echo $quiz_id; ?>,
                '../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>'
            );
        });
    </script>
</body>

</html>