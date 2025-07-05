<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

include_once '../../Functions/userInfo.php';

// Include function to fetch classes
include_once '../../Functions/fetchClasses.php';

// Get teacher's classes
$teacher_id = $_SESSION['user_id'];
$classes = getTeacherClasses($conn, $teacher_id);

// Pagination setup
$itemsPerPage = 9;
$totalClasses = count($classes);
$totalPages = ceil($totalClasses / $itemsPerPage);
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Validate current page
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}

// Get classes for current page
$startIndex = ($currentPage - 1) * $itemsPerPage;
$displayClasses = array_slice($classes, $startIndex, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Classes - Teacher Dashboard - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <script src="../../Assets/Js/teacherDashboard.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 max-w-7xl mx-auto">
            <!-- All Classes Section -->
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h2 class="text-xl font-bold text-gray-900">All Your Classes</h2>
                    <div class="flex items-center gap-3">
                        <button id="addClassBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center shadow-sm hover:shadow">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Add New Class</span>
                        </button>
                        
                        <button 
                        onclick="window.location.href='../Dashboard/teachersDashboard.php'"
                        class="bg-white/80 hover:bg-white text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200/50"
                    >
                        <i class="fas fa-arrow-left mr-2"></i> Dashboard
                    </button>
                    </div>
                </div>

                <?php if (isset($classes) && count($classes) > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php 
                        foreach ($displayClasses as $class): 
                            // Count enrolled students for this class
                            $enrollmentQuery = "SELECT COUNT(*) as student_count FROM class_enrollments_tb WHERE class_id = ? AND status = 'active'";
                            $enrollmentStmt = $conn->prepare($enrollmentQuery);
                            $enrollmentStmt->bind_param("i", $class['class_id']);
                            $enrollmentStmt->execute();
                            $enrollmentResult = $enrollmentStmt->get_result();
                            $studentCount = $enrollmentResult->fetch_assoc()['student_count'];
                            
                            // Get quiz count for this class
                            $quizQuery = "SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ? AND status = 'published'";
                            $quizStmt = $conn->prepare($quizQuery);
                            $quizStmt->bind_param("i", $class['class_id']);
                            $quizStmt->execute();
                            $quizResult = $quizStmt->get_result();
                            $quizCount = $quizResult->fetch_assoc()['quiz_count'];

                            // Define status badge colors
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-800',
                                'inactive' => 'bg-gray-100 text-gray-800',
                                'archived' => 'bg-red-100 text-red-800'
                            ];
                            
                            // Default values for missing fields
                            $description = !empty($class['class_description']) ? $class['class_description'] : 'No description available';
                            $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
                        ?>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <!-- Class Card Header with Color Strip -->
                                <div class="h-2 bg-purple-primary"></div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="font-semibold text-lg text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo isset($statusColors[$class['status']]) ? $statusColors[$class['status']] : $statusColors['inactive']; ?>">
                                            <?php echo ucfirst($class['status']); ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($description); ?></p>
                                    
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        <div class="bg-gray-50 p-2 rounded">
                                            <p class="text-xs text-gray-500">Grade</p>
                                            <p class="font-medium text-sm text-gray-800">Grade <?php echo htmlspecialchars($class['grade_level']); ?></p>
                                        </div>
                                        <div class="bg-gray-50 p-2 rounded">
                                            <p class="text-xs text-gray-500">Strand</p>
                                            <p class="font-medium text-sm text-gray-800"><?php echo htmlspecialchars($strand); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-users mr-2 text-purple-primary"></i>
                                            <span><?php echo $studentCount; ?> Students</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-book mr-2 text-purple-primary"></i>
                                            <span><?php echo $quizCount; ?> Quizzes</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-key mr-1"></i>
                                            Code: <span class="font-mono font-medium"><?php echo htmlspecialchars($class['class_code']); ?></span>
                                        </div>
                                        <a href="../Class/classDetails.php?class_id=<?php echo $class['class_id']; ?>" class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                                            View Class <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php include "../Modals/pagination.php" ?>

                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center max-w-2xl mx-auto">
                        <i class="fas fa-book-open text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
                        <p class="text-gray-500 mb-4">You haven't created any classes yet. Create your first class to get started.</p>
                        <button id="addEmptyClassBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>Add Your First Class
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Include Add Class Modal -->
    <?php include "../Modals/addClassModal.php"; ?>

</body>
<script src="../../Assets/Js/teacherDashAnimation.js"></script>
<script src="../../Assets/Js/addClassModal.js"></script>
<script>
// Make sure the empty state button also triggers the modal
document.addEventListener('DOMContentLoaded', function() {
    const addEmptyClassBtn = document.getElementById('addEmptyClassBtn');
    if (addEmptyClassBtn) {
        addEmptyClassBtn.addEventListener('click', function() {
            if (typeof window.openAddClassModal === 'function') {
                window.openAddClassModal();
            } else {
                console.error("openAddClassModal function not found");
            }
        });
    }
});
</script>
</html>