<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Student Profile</h3>
    </div>
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <?php if (!empty($student['profile_picture'])): ?>
                    <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200"
                        src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>"
                        alt="<?php echo htmlspecialchars($student['st_userName']); ?>">
                <?php else: ?>
                    <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-gray-300">
                        <span class="text-white font-bold text-lg"><?php echo strtoupper(substr($student['st_userName'], 0, 2)); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ml-6">
                <h2 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($student['st_userName']); ?></h2>
                <p class="text-gray-600"><?php echo htmlspecialchars($student['st_email']); ?></p>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <?php echo htmlspecialchars($student['grade_level'] === 'grade_11' ? 'Grade 11' : 'Grade 12'); ?>
                    </span>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <?php echo htmlspecialchars($student['strand']); ?>
                    </span>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Student ID: <?php echo htmlspecialchars($student['student_id'] ?? 'N/A'); ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Enrolled Since</p>
                <p class="font-semibold text-gray-900"><?php echo date('F j, Y', strtotime($student['enrollment_date'])); ?></p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Class</p>
                <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($classDetails['class_name']); ?></p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Subject Strand</p>
                <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($classDetails['strand']); ?></p>
            </div>
        </div>
    </div>
</div>