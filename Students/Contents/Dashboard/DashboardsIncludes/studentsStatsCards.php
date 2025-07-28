<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Enrolled Classes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $enrolledCount; ?></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book-open text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Published Quizzes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalPublishedQuizzes ?? 0; ?></p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Materials -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Materials</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalMaterials ?? 0; ?></p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Announcements</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalAnnouncements ?? 0; ?></p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bullhorn text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>