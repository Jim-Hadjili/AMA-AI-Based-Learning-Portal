<?php
// Include the dashboard stats function file
require_once __DIR__ . '/../../Functions/dashboardStats.php';

// Get dashboard statistics
$teacherStats = getTeacherDashboardStats($conn, $classes ?? [], $_SESSION['user_id'] ?? '');

// Extract stats into individual variables for easier template usage
extract($teacherStats);
?>

<div class="max-w-8xl mx-auto ">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Top accent strip -->
        <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-600"></div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Students Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                    <div class="flex items-center justify-between w-full mb-1">
                        <span class="text-sm font-medium text-gray-600">Total Students</span>
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900"><?php echo $totalStudents; ?></div>
                    <div class="text-xs text-gray-500 mt-1 text-center">Across all your classes</div>
                </div>

                <!-- Active Classes Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                    <div class="flex items-center justify-between w-full mb-1">
                        <span class="text-sm font-medium text-gray-600">Active Classes</span>
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-book text-green-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900"><?php echo $activeClassesCount; ?></div>
                    <div class="text-xs text-gray-500 mt-1 text-center">Currently active classes</div>
                </div>

                <!-- Total Quizzes Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                    <div class="flex items-center justify-between w-full mb-1">
                        <span class="text-sm font-medium text-gray-600">Total Quizzes</span>
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tasks text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes; ?></div>
                    <div class="text-xs text-gray-500 mt-1 text-center">Created for your classes</div>
                </div>

                <!-- Total Announcements Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                    <div class="flex items-center justify-between w-full mb-1">
                        <span class="text-sm font-medium text-gray-600">Total Announcements</span>
                        <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-bell text-pink-600"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-gray-900"><?php echo $totalAnnouncements; ?></div>
                    <div class="text-xs text-gray-500 mt-1 text-center">Made in your classes</div>
                </div>
            </div>
        </div>
    </div>
</div>