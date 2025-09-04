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
$statsData = calculateQuizStats($conn, $class_id, $teacher_id, $searchTerm, $statusFilter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'allQuizzesIncludes/quiz-header.php'; ?>
</head>

<body class="bg-gray-100 min-h-screen font-[sans-serif]">
    

    <!-- Main Content -->
    <div class="max-w-9xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
<!-- Header Navigation -->
    <?php include 'allQuizzesIncludes/quiz-nav.php'; ?>

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

                <!-- Quiz Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8 bg-white rounded-2xl shadow-sm border p-8">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the Add Quiz button
        const addQuizBtn = document.getElementById('addQuizBtn');
        if (addQuizBtn) {
            addQuizBtn.addEventListener('click', function() {
                if (typeof window.openAddQuizModal === 'function') {
                    window.openAddQuizModal();
                } else {
                    console.error('openAddQuizModal function not found');
                }
            });
        }
    });
    </script>

    <!-- Include modals -->
    <?php
    // Create the Modals directory if it doesn't exist
    $modalsDir = __DIR__ . '/../../Contents/Modals';
    if (!file_exists($modalsDir)) {
        mkdir($modalsDir, 0755, true);
    }

    // Include modal files
    $addQuizModalFile = $modalsDir . '/addQuizModal.php';
    $quizTypeModalFile = $modalsDir . '/quizTypeModal.php';
    $quizQuestionsModalFile = $modalsDir . '/quizQuestionsModal.php';

    // Include each modal if it exists
    if (file_exists($addQuizModalFile)) {
        include $addQuizModalFile;
    } else {
        echo "<!-- Modal file not found: $addQuizModalFile -->";
    }

    if (file_exists($quizTypeModalFile)) {
        include $quizTypeModalFile;
    } else {
        echo "<!-- Modal file not found: $quizTypeModalFile -->";
    }

    if (file_exists($quizQuestionsModalFile)) {
        include $quizQuestionsModalFile;
    } else {
        echo "<!-- Modal file not found: $quizQuestionsModalFile -->";
    }
    ?>

    <!-- Add notification functionality -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <script>
    // Add notification function
    function showNotification(message, type = 'info') {
        const container = document.getElementById('notification-container');
        const notification = document.createElement('div');
        
        // Set classes based on notification type
        const baseClasses = 'p-4 rounded-md shadow-lg flex items-center justify-between max-w-md animate-fadeIn';
        let typeClasses = '';
        
        switch(type) {
            case 'success':
                typeClasses = 'bg-green-600 text-white';
                break;
            case 'error':
                typeClasses = 'bg-red-600 text-white';
                break;
            case 'warning':
                typeClasses = 'bg-yellow-500 text-white';
                break;
            default:
                typeClasses = 'bg-blue-600 text-white';
        }
        
        notification.className = `${baseClasses} ${typeClasses}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span>${message}</span>
            </div>
            <button class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add click event to close button
        const closeBtn = notification.querySelector('button');
        closeBtn.addEventListener('click', () => {
            notification.classList.add('animate-fadeOut');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        });
        
        container.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.add('animate-fadeOut');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    // Make showNotification available globally
    window.showNotification = showNotification;

    // Initialize the Add Quiz button
    document.addEventListener('DOMContentLoaded', function() {
        const addQuizBtn = document.getElementById('addQuizBtn');
        
        if (addQuizBtn) {
            addQuizBtn.addEventListener('click', function() {
                if (typeof window.openAddQuizModal === 'function') {
                    window.openAddQuizModal();
                } else {
                    console.error('openAddQuizModal function not found');
                    showNotification('Error: Could not open quiz modal. Please refresh the page.', 'error');
                }
            });
        }
    });
    </script>

    <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(10px); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fadeOut {
        animation: fadeOut 0.3s ease-out forwards;
    }
    </style>

    <!-- Include delete quiz modal -->
    <?php include 'allQuizzesIncludes/delete-quiz-modal.php'; ?>

    <!-- Add the delete handler script -->
    <script src="../../Assets/Js/quizDeleteHandler.js"></script>

    <!-- Include publish/unpublish quiz modals -->
    <?php include 'allQuizzesIncludes/publish-quiz-modal.php'; ?>

    <!-- Add the publish handler script -->
    <script src="../../Assets/Js/quizPublishHandler.js"></script>

    <!-- Include no questions warning modal -->
    <?php include 'allQuizzesIncludes/no-questions-warning-modal.php'; ?>
</body>
</html>