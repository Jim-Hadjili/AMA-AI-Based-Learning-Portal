<!-- Class Content Tabs -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200">
        <button class="tab-btn active px-4 py-3 font-medium text-sm text-center flex-1 border-b-2 border-purple-primary text-purple-primary" data-tab="quizzes">
            <i class="fas fa-tasks mr-2"></i> Quizzes
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="students">
            <i class="fas fa-users mr-2"></i> Students
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="materials">
            <i class="fas fa-book mr-2"></i> Materials
        </button>
    </div>

    <!-- Tab Contents -->
    <div>
        <!-- Quizzes Tab -->
        <div id="quizzes-tab" class="tab-content p-6">
            <?php if (empty($quizzes)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-tasks text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Quizzes Yet</h3>
                    <p class="text-gray-500 mb-4">You haven't created any quizzes for this class yet.</p>
                    <button id="addFirstQuizBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Create Your First Quiz
                    </button>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">All Quizzes (<?php echo count($quizzes); ?>)</h3>
                    <div class="flex items-center">
                        <div class="relative text-gray-500">
                            <input type="text" id="quiz-search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-60 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Search quizzes...">
                            <i class="fas fa-search absolute left-3 top-2.5"></i>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php 
                                        $statusClasses = [
                                            'published' => 'bg-green-100 text-green-800',
                                            'draft' => 'bg-gray-100 text-gray-800',
                                            'completed' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $statusClass = isset($statusClasses[$quiz['status']]) ? $statusClasses[$quiz['status']] : 'bg-gray-100 text-gray-800';
                                        ?>
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($quiz['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $quiz['question_count'] ?? 'N/A'; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($quiz['date_created'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="../Quiz/quizDetails.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" class="text-purple-primary hover:text-purple-dark mr-3">
                                            View
                                        </a>
                                        <button class="edit-quiz-btn text-blue-600 hover:text-blue-900 mr-3" data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                            Edit
                                        </button>
                                        <button class="delete-quiz-btn text-red-600 hover:text-red-900" data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Students Tab -->
        <div id="students-tab" class="tab-content p-6 hidden">
            <?php if (empty($students)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Enrolled</h3>
                    <p class="text-gray-500 mb-4">Share your class code with students to get them enrolled.</p>
                    <div class="max-w-xs mx-auto p-3 bg-gray-50 rounded-lg flex items-center justify-between mb-4">
                        <span class="font-mono font-medium text-gray-800"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                        <button class="copy-code-btn text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">Enrolled Students (<?php echo count($students); ?>)</h3>
                    <div class="flex items-center">
                        <div class="relative text-gray-500">
                            <input type="text" id="student-search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-60 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Search students...">
                            <i class="fas fa-search absolute left-3 top-2.5"></i>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <?php if (!empty($student['st_profile_img'])): ?>
                                                    <img class="h-10 w-10 rounded-full" src="<?php echo htmlspecialchars($student['st_profile_img']); ?>" alt="<?php echo htmlspecialchars($student['st_name']); ?>">
                                                <?php else: ?>
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <i class="fas fa-user text-gray-400"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['st_name']); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($student['st_email']); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php 
                                        $statusClasses = [
                                            'active' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'declined' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusClass = isset($statusClasses[$student['status']]) ? $statusClasses[$student['status']] : 'bg-gray-100 text-gray-800';
                                        ?>
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($student['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="view-student-btn text-purple-primary hover:text-purple-dark mr-3" data-student-id="<?php echo $student['st_id']; ?>">
                                            View Progress
                                        </button>
                                        <button class="message-student-btn text-blue-600 hover:text-blue-900" data-student-id="<?php echo $student['st_id']; ?>">
                                            Message
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Materials Tab -->
        <div id="materials-tab" class="tab-content p-6 hidden">
            <?php if (empty($materials)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Materials Yet</h3>
                    <p class="text-gray-500 mb-4">You haven't uploaded any learning materials for this class yet.</p>
                    <button id="addFirstMaterialBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Upload Materials
                    </button>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">Learning Materials (<?php echo count($materials); ?>)</h3>
                    <button id="addMaterialBtn" class="px-3 py-1.5 bg-purple-primary text-white rounded-md hover:bg-purple-dark text-sm">
                        <i class="fas fa-plus mr-1"></i> Add Material
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($materials as $material): ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-200 transition-colors">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <?php
                                    $extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);
                                    $icon = 'fa-file';
                                    
                                    if (in_array($extension, ['pdf'])) {
                                        $icon = 'fa-file-pdf';
                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                        $icon = 'fa-file-word';
                                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                        $icon = 'fa-file-excel';
                                    } elseif (in_array($extension, ['ppt', 'pptx'])) {
                                        $icon = 'fa-file-powerpoint';
                                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $icon = 'fa-file-image';
                                    } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                        $icon = 'fa-file-video';
                                    }
                                    ?>
                                    <i class="fas <?php echo $icon; ?> text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 mb-1"><?php echo htmlspecialchars($material['material_title']); ?></h4>
                                    <p class="text-xs text-gray-500 mb-2"><?php echo date('M d, Y', strtotime($material['upload_date'])); ?></p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500"><?php echo formatFileSize($material['file_size'] ?? 0); ?></span>
                                        <div>
                                            <a href="<?php echo htmlspecialchars($material['file_path']); ?>" download class="text-blue-600 hover:text-blue-900 text-sm mr-2">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button class="delete-material-btn text-red-600 hover:text-red-900 text-sm" data-material-id="<?php echo $material['material_id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Helper function to format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}
?>