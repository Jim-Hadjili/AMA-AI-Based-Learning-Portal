<div id="studentModal-<?php echo $index; ?>" class="modal-backdrop fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="modal-content bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden">
        <!-- Modal Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">
                Student Information
            </h3>
            <button onclick="closeStudentModal('<?php echo $index; ?>')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Column - Basic Info -->
                <div class="flex-1">
                    <!-- Student Avatar and Name -->
                    <div class="flex items-center mb-6">
                        <div class="h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center overflow-hidden cursor-pointer" 
                             onclick="openProfileImagePreview('<?php echo $index; ?>')">
                            <?php if (!empty($student['profile_picture']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/' . $student['profile_picture'])): ?>
                                <img src="/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/<?php echo $student['profile_picture']; ?>" alt="Profile" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-blue-600 font-bold text-2xl">
                                    <?php
                                    $initials = explode(' ', $student['student_name']);
                                    echo strtoupper(substr($initials[0] ?? '', 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="ml-6">
                            <h4 class="text-2xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($student['student_name']); ?>
                                <?php if ($student['st_id'] === $student_id): ?>
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        You
                                    </span>
                                <?php endif; ?>
                            </h4>
                            <p class="text-gray-500">
                                <?php echo htmlspecialchars($student['email']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Student Basic Info -->
                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Student ID</h5>
                            <p class="text-gray-900 font-medium">
                                <?php echo htmlspecialchars($student['st_id']); ?>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Student ID Number</h5>
                            <p class="text-gray-900 font-medium">
                                <?php echo htmlspecialchars($student['student_id'] ?? 'Not provided'); ?>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Enrollment Status</h5>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <?php echo ucfirst($student['status'] ?? 'Unknown'); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Academic Info -->
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Academic Information</h4>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Grade Level</h5>
                            <p class="text-gray-900 font-medium">
                                <?php
                                $grade = str_replace('_', ' ', $student['grade_level'] ?? 'Not specified');
                                echo ucwords($grade);
                                ?>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Strand</h5>
                            <p class="text-gray-900 font-medium">
                                <?php echo strtoupper($student['strand'] ?? 'N/A'); ?>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Enrollment Date</h5>
                            <p class="text-gray-900 font-medium">
                                <?php
                                if (!empty($student['enrollment_date'])) {
                                    $enrollDate = new DateTime($student['enrollment_date']);
                                    echo $enrollDate->format('F d, Y');
                                } else {
                                    echo 'Unknown date';
                                }
                                ?>
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Class</h5>
                            <p class="text-gray-900 font-medium">
                                <?php echo htmlspecialchars($classDetails['class_name']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <button onclick="closeStudentModal('<?php echo $index; ?>')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl transition-colors duration-300">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Profile Image Preview Modal -->
<?php if (!empty($student['profile_picture']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/' . $student['profile_picture'])): ?>
<div id="profileImageModal-<?php echo $index; ?>" class="fixed inset-0 z-[60] bg-black/80 backdrop-blur-sm items-center justify-center p-6 hidden">
    <div class="relative max-w-4xl mx-auto">
        <!-- Close button -->
        <button onclick="closeProfileImagePreview('<?php echo $index; ?>')" class="absolute -top-12 right-0 text-white hover:text-gray-300 focus:outline-none">
            <i class="fas fa-times text-2xl"></i>
        </button>
        
        <!-- Image container -->
        <div class="bg-white p-2 rounded-lg shadow-2xl overflow-hidden">
            <img src="/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/<?php echo $student['profile_picture']; ?>" 
                 alt="<?php echo htmlspecialchars($student['student_name']); ?>'s Profile" 
                 class="max-h-[80vh] max-w-full object-contain">
        </div>
        
        <!-- Student name caption -->
        <div class="text-center mt-4">
            <p class="text-white text-lg font-medium">
                <?php echo htmlspecialchars($student['student_name']); ?>
            </p>
        </div>
    </div>
</div>
<?php endif; ?>