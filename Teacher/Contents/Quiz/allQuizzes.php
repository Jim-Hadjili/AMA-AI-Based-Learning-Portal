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
include_once '../../Functions/quizListFunctions.php';
include_once '../../Controllers/classController.php';

// Check if class_id is provided
if (!isset($_GET['class_id']) || empty($_GET['class_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$class_id = intval($_GET['class_id']);
$teacher_id = $_SESSION['user_id'];

// Get class information
$classInfo = getClassInfo($conn, $class_id, $teacher_id);

// Process pagination, search, and filters
$quizzesPerPage = 9;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Fetch quizzes data
$quizzesData = getQuizzesByFilters(
    $conn, 
    $class_id, 
    $teacher_id, 
    $searchTerm, 
    $statusFilter, 
    $sortBy, 
    $currentPage, 
    $quizzesPerPage
);

// Extract data
$quizzes = $quizzesData['quizzes'];
$totalQuizzes = $quizzesData['total'];
$totalPages = $quizzesData['totalPages'];
$offset = $quizzesData['offset'];

// Stats
$statsData = calculateQuizStats($quizzes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'allQuizzesIncludes/quiz-header.php'; ?>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header Navigation -->
    <?php include 'allQuizzesIncludes/quiz-nav.php'; ?>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <?php if ($totalQuizzes === 0 && empty($searchTerm) && $statusFilter === 'all'): ?>
            <!-- Empty State - No quizzes at all -->
            <?php include 'allQuizzesIncludes/quiz-empty-state.php'; ?>
        <?php else: ?>
            <!-- Stats and Filters -->
            <?php include 'allQuizzesIncludes/quiz-stats.php'; ?>
            <?php include 'allQuizzesIncludes/quiz-filters.php'; ?>

            <?php if ($totalQuizzes === 0): ?>
                <!-- No Results State -->
                <?php include 'allQuizzesIncludes/quiz-no-results.php'; ?>
            <?php else: ?>
                <!-- Results Info -->
                <?php include 'allQuizzesIncludes/quiz-results-info.php'; ?>

                <!-- Quiz Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($quizzes as $quiz): ?>
                        <?php include 'allQuizzesIncludes/quiz-card.php'; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Controls -->
                <?php if ($totalPages > 1): ?>
                    <?php include 'allQuizzesIncludes/quiz-pagination.php'; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script src="../../Assets/Js/quizList.js"></script>
</body>
</html>