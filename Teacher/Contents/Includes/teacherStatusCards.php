<?php
// Include the dashboard stats function file
require_once __DIR__ . '/../../Functions/dashboardStats.php';

// Get dashboard statistics
$teacherStats = getTeacherDashboardStats($conn, $classes ?? [], $_SESSION['user_id'] ?? '');

// Extract stats into individual variables for easier template usage
extract($teacherStats);
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Students Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Students</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalStudents; ?></p>
                <p class="text-xs text-gray-500 mt-1">Across all your classes</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Active Classes Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Active Classes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $activeClassesCount; ?></p>
                <p class="text-xs text-gray-500 mt-1">Currently active classes</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Quizzes Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Quizzes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes; ?></p>
                <p class="text-xs text-gray-500 mt-1">Created for your classes</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-tasks text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Unread Messages Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">New Messages</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $pendingMessages; ?></p>
                <p class="text-xs text-gray-500 mt-1">Unread messages</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>