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

<body class="bg-gray-100 min-h-screen">
    <!-- Notification Container -->
    <div id="notification-container"></div>



    <!-- Main Content -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <?php include 'includes/editQuizBreadcrumb.php'; ?>

        <?php include 'includes/quiz-nav.php'; ?>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- Left Sidebar - Quiz Settings & Question List -->
            <div class="lg:col-span-1 space-y-6">
                <?php include 'includes/quiz-settings-form.php'; ?>
                <?php include 'includes/question-list.php'; ?>
                <?php include 'includes/question-types.php'; ?>
            </div>

            <!-- Right Content - Question Editor -->
            <div class="lg:col-span-3">
                <?php include 'includes/question-editor.php'; ?>
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