<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Enrolled Classes Card -->
    <a href="../Pages/studentAllClasses.php" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative focus:outline-none focus:ring-2 focus:ring-blue-500">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-50 to-blue-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border-2 border-blue-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-book-open text-2xl text-blue-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Enrolled Classes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($enrolledCount); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Your active courses</span>
                </div>
            </div>
        </div>
    </a>
    <!-- Published Quizzes Card -->
    <a href="../Pages/dashboardAllQuizzes.php" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative focus:outline-none focus:ring-2 focus:ring-green-500">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-50 to-green-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center border-2 border-green-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl text-green-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Published Quizzes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($totalPublishedQuizzes ?? 0); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Test your knowledge</span>
                </div>
            </div>
        </div>
    </a>
    <!-- Materials Card -->
    <a href="../Pages/dashboardAllMaterials.php" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative focus:outline-none focus:ring-2 focus:ring-yellow-500">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-yellow-50 to-yellow-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center border-2 border-yellow-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-yellow-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Materials</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($totalMaterials ?? 0); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Learning resources</span>
                </div>
            </div>
        </div>
    </a>
    <!-- Announcements Card -->
    <a href="../Pages/dashboardAllAnnouncements.php" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative focus:outline-none focus:ring-2 focus:ring-red-500">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-red-50 to-red-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center border-2 border-red-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center">
                    <i class="fas fa-bullhorn text-2xl text-red-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Announcements</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($totalAnnouncements ?? 0); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Latest updates</span>
                </div>
            </div>
        </div>
    </a>
</div>