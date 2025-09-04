<?php
// Include the dashboard stats function file
require_once __DIR__ . '/../../Functions/dashboardStats.php';

// Get dashboard statistics
$teacherStats = getTeacherDashboardStats($conn, $classes ?? [], $_SESSION['user_id'] ?? '');

// Extract stats into individual variables for easier template usage
extract($teacherStats);
?>

<div class="max-w-8xl mx-auto">
    <!-- Redesigned with modern gradient background and enhanced visual appeal -->
    <div class="bg-white rounded-3xl shadow-lg border border-white/50 backdrop-blur-sm overflow-hidden">
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-blue-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Total Students</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-users text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-2"><?php echo $totalStudents; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Across all your classes</div>
                    </div>
                </div>

                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Active Classes</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-book text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent mb-2"><?php echo $activeClassesCount; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Currently active classes</div>
                    </div>
                </div>

                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-amber-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Total Quizzes</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-tasks text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-amber-800 bg-clip-text text-transparent mb-2"><?php echo $totalQuizzes; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Created for your classes</div>
                    </div>
                </div>

                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-pink-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Total Announcements</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-bell text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-pink-800 bg-clip-text text-transparent mb-2"><?php echo $totalAnnouncements; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Made in your classes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
