<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

include_once '../../Functions/userInfo.php';
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
    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeMobileMenu()"></div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <!-- Sidebar -->
    <?php include "../Includes/teacherSideBar.php"; ?>

    <!-- Main Content -->
    <div id="main-content" class="lg:ml-16 min-h-screen transition-all duration-300">

        <!-- Top Navigation Bar -->
        <?php include "../Includes/teacherHeader.php"; ?>

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6">
            <!-- All Classes Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">All Your Classes</h2>
                    <a href="../Dashboard/teachersDashboard.php" class="text-sm text-purple-primary hover:text-purple-dark font-medium flex items-center">
                        <i class="fas fa-chevron-left mr-2 text-xs"></i>
                        Back to Dashboard
                    </a>
                </div>

                <?php if (count($classes) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php 
                        foreach ($classes as $class): 
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
                        ?>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <!-- Class Card Header with Color Strip -->
                                <div class="h-2 bg-purple-primary"></div>
                                <div class="p-5">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="font-semibold text-lg text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo $statusColors[$class['status']]; ?>">
                                            <?php echo ucfirst($class['status']); ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($class['class_description'] ?? 'No description available'); ?></p>
                                    
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        <div class="bg-gray-50 p-2 rounded">
                                            <p class="text-xs text-gray-500">Grade</p>
                                            <p class="font-medium text-sm text-gray-800">Grade <?php echo htmlspecialchars($class['grade_level']); ?></p>
                                        </div>
                                        <div class="bg-gray-50 p-2 rounded">
                                            <p class="text-xs text-gray-500">Strand</p>
                                            <p class="font-medium text-sm text-gray-800"><?php echo htmlspecialchars($class['strand']); ?></p>
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
                                        <a href="#" class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                                            View Class <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                        <i class="fas fa-book-open text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
                        <p class="text-gray-500 mb-4">You haven't created any classes yet. Create your first class to get started.</p>
                        <button onclick="openAddClassModal()" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>Add Your First Class
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
<script src="../../Assets/Js/teacherDashAnimation.js"></script>
<script src="../../Assets/Js/generateRandomClassCode.js"></script>

</html>