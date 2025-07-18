<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Students</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $classDetails['student_count']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-question-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Quizzes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $classDetails['total_quiz_count']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-file-alt text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Materials</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $classDetails['material_count']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 mr-4">
                <i class="fas fa-bullhorn text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Announcements</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo $classDetails['announcement_count']; ?></p>
            </div>
        </div>
    </div>
</div>