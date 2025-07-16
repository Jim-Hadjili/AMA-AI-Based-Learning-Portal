<?php include "../../Functions/classDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($classDetails['class_name']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Header -->
        <?php include "DashboardsIncludes/studentsHeader.php" ?>

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 pt-6">
            
            <?php
            // Define subject-specific styles
            $subjectStyles = [
                'English' => [
                    'strip' => 'from-blue-500 to-blue-700',
                    'icon_bg' => 'bg-blue-100',
                    'icon_color' => 'text-blue-600',
                    'icon_class' => 'fas fa-book-reader'
                ],
                'Math' => [
                    'strip' => 'from-green-500 to-green-700',
                    'icon_bg' => 'bg-green-100',
                    'icon_color' => 'text-green-600',
                    'icon_class' => 'fas fa-calculator'
                ],
                'Science' => [
                    'strip' => 'from-purple-500 to-purple-700',
                    'icon_bg' => 'bg-purple-100',
                    'icon_color' => 'text-purple-600',
                    'icon_class' => 'fas fa-flask'
                ],
                'History' => [
                    'strip' => 'from-yellow-500 to-yellow-700',
                    'icon_bg' => 'bg-yellow-100',
                    'icon_color' => 'text-yellow-600',
                    'icon_class' => 'fas fa-landmark'
                ],
                'Arts' => [
                    'strip' => 'from-pink-500 to-pink-700',
                    'icon_bg' => 'bg-pink-100',
                    'icon_color' => 'text-pink-600',
                    'icon_class' => 'fas fa-paint-brush'
                ],
                'PE' => [
                    'strip' => 'from-red-500 to-red-700',
                    'icon_bg' => 'bg-red-100',
                    'icon_color' => 'text-red-600',
                    'icon_class' => 'fas fa-running'
                ],
                'ICT' => [
                    'strip' => 'from-indigo-500 to-indigo-700',
                    'icon_bg' => 'bg-indigo-100',
                    'icon_color' => 'text-indigo-600',
                    'icon_class' => 'fas fa-laptop-code'
                ],
                'Home Economics' => [
                    'strip' => 'from-orange-500 to-orange-700',
                    'icon_bg' => 'bg-orange-100',
                    'icon_color' => 'text-orange-600',
                    'icon_class' => 'fas fa-utensils'
                ],
                'Default' => [
                    'strip' => 'from-gray-500 to-gray-700',
                    'icon_bg' => 'bg-gray-100',
                    'icon_color' => 'text-gray-600',
                    'icon_class' => 'fas fa-graduation-cap'
                ]
            ];

            $subject = $classDetails['class_subject'] ?? 'Default';
            $style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
            ?>

            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="studentDashboard.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2"><?php echo htmlspecialchars($classDetails['class_name']); ?></span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Class Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                <div class="h-3 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="inline-block p-4 rounded-full <?php echo $style['icon_bg']; ?> mr-4">
                                <i class="<?php echo $style['icon_class']; ?> text-2xl <?php echo $style['icon_color']; ?>"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($classDetails['class_name']); ?></h1>
                                <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($classDetails['class_description'] ?? 'No description provided.'); ?></p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-key mr-1"></i>Code: <strong><?php echo htmlspecialchars($classDetails['class_code']); ?></strong></span>
                                    <span><i class="fas fa-graduation-cap mr-1"></i>Grade <?php echo htmlspecialchars($classDetails['grade_level']); ?></span>
                                    <span><i class="fas fa-tag mr-1"></i><?php echo htmlspecialchars($classDetails['strand'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                            <?php echo ucfirst($classDetails['status']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
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

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Recent Quizzes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Recent Quizzes</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <?php if (empty($recentQuizzes)): ?>
                            <div class="text-center py-8">
                                <i class="fas fa-question-circle text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No quizzes available yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($recentQuizzes as $quiz): ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 quiz-card"
                                         onclick="showQuizDetailsModal(<?php echo htmlspecialchars(json_encode($quiz)); ?>)">
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                                            <p class="text-sm text-gray-600 break-words line-clamp-2"><?php echo htmlspecialchars(substr($quiz['quiz_description'] ?? 'No description', 0, 100)) . (strlen($quiz['quiz_description'] ?? '') > 100 ? '...' : ''); ?></p>
                                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                                <span class="mr-3"><i class="fas fa-clock mr-1"></i><?php echo $quiz['time_limit']; ?> min</span>
                                                <span class="px-2 py-1 rounded-full <?php echo $quiz['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                                    <?php echo ucfirst($quiz['status']); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <button class="ml-4 text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Recent Announcements</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <?php if (empty($recentAnnouncements)): ?>
                            <div class="text-center py-8">
                                <i class="fas fa-bullhorn text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No announcements yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($recentAnnouncements as $announcement): ?>
                                    <div class="p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors duration-200 announcement-card <?php echo $announcement['is_pinned'] ? 'border-l-4 border-yellow-400' : ''; ?>"
                                         onclick="showAnnouncementModal(<?php echo htmlspecialchars(json_encode($announcement)); ?>)">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-900 flex items-center">
                                                    <?php echo htmlspecialchars($announcement['title']); ?>
                                                    <?php if ($announcement['is_pinned']): ?>
                                                        <i class="fas fa-thumbtack text-yellow-500 ml-2 text-sm"></i>
                                                    <?php endif; ?>
                                                </h3>
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-3 break-words"><?php echo htmlspecialchars(substr($announcement['content'], 0, 150)) . (strlen($announcement['content']) > 150 ? '...' : ''); ?></p>
                                                <p class="text-xs text-gray-500 mt-2"><?php echo date('M j, Y', strtotime($announcement['created_at'])); ?></p>
                                            </div>
                                            <div class="ml-4 text-gray-400">
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Learning Materials -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Learning Materials</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <?php if (empty($recentMaterials)): ?>
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No materials uploaded yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($recentMaterials as $material): ?>
                                    <a href="materialPreview.php?material_id=<?php echo $material['material_id']; ?>" 
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 group">
                        <div class="p-2 rounded-lg bg-blue-100 mr-3 group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-file-<?php echo strtolower($material['file_type']); ?> text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900 truncate group-hover:text-blue-600 transition-colors"><?php echo htmlspecialchars($material['material_title']); ?></h3>
                            <p class="text-sm text-gray-600 truncate"><?php echo htmlspecialchars($material['file_name']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($material['upload_date'])); ?></p>
                        </div>
                        <div class="ml-4 text-gray-400 group-hover:text-blue-600 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

                <!-- Enrolled Students (for teachers only) -->
                <?php if ($user_position === 'teacher'): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Enrolled Students</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <?php if (empty($enrolledStudents)): ?>
                            <div class="text-center py-8">
                                <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No students enrolled yet.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach (array_slice($enrolledStudents, 0, 5) as $student): ?>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-600 font-medium text-sm"><?php echo strtoupper(substr($student['st_userName'], 0, 1)); ?></span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900 truncate"><?php echo htmlspecialchars($student['st_userName']); ?></h3>
                                            <p class="text-sm text-gray-600 truncate"><?php echo htmlspecialchars($student['st_email']); ?></p>
                                            <p class="text-xs text-gray-500 truncate">Grade <?php echo htmlspecialchars($student['grade_level']); ?> - <?php echo htmlspecialchars($student['strand']); ?></p>
                                        </div>
                                        <span class="text-xs text-gray-500"><?php echo date('M j', strtotime($student['enrollment_date'])); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        </main>
    </div>

    <!-- Announcement Modal -->
    <div id="announcementModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg mr-3">
                            <i class="fas fa-bullhorn text-orange-600"></i>
                        </div>
                        <div>
                            <h2 id="modalAnnouncementTitle" class="text-xl font-semibold text-gray-900"></h2>
                            <div class="flex items-center mt-1">
                                <span id="modalAnnouncementDate" class="text-sm text-gray-500"></span>
                                <span id="modalPinnedBadge" class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full hidden">
                                    <i class="fas fa-thumbtack mr-1"></i>Pinned
                                </span>
                            </div>
                        </div>
                    </div>
                    <button id="closeAnnouncementModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="modalAnnouncementContent" class="text-gray-700 leading-relaxed whitespace-pre-wrap"></div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-end">
                    <button id="closeAnnouncementModalBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Details Modal -->
    <div id="quizDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                            <i class="fas fa-question-circle text-green-600"></i>
                        </div>
                        <div>
                            <h2 id="modalQuizTitle" class="text-xl font-semibold text-gray-900"></h2>
                            <p id="modalQuizDescription" class="text-sm text-gray-600 mt-1"></p>
                        </div>
                    </div>
                    <button id="closeQuizDetailsModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div>
                        <p class="font-medium">Questions:</p>
                        <p id="modalQuizQuestions" class="text-lg font-bold"></p>
                    </div>
                    <div>
                        <p class="font-medium">Time Limit:</p>
                        <p id="modalQuizTimeLimit" class="text-lg font-bold"></p>
                    </div>
                    <div>
                        <p class="font-medium">Total Score:</p>
                        <p id="modalQuizTotalScore" class="text-lg font-bold"></p>
                    </div>
                    <div>
                        <p class="font-medium">Status:</p>
                        <p id="modalQuizStatus" class="text-lg font-bold"></p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
                <button id="cancelQuizBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button id="takeQuizBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Take Quiz
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Announcement Modal -->
    <script>
        function showAnnouncementModal(announcement) {
            // Populate modal content
            document.getElementById('modalAnnouncementTitle').textContent = announcement.title;
            document.getElementById('modalAnnouncementContent').textContent = announcement.content;
            
            // Format and set date
            const date = new Date(announcement.created_at);
            const formattedDate = date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalAnnouncementDate').textContent = formattedDate;
            
            // Show/hide pinned badge
            const pinnedBadge = document.getElementById('modalPinnedBadge');
            if (announcement.is_pinned == 1) {
                pinnedBadge.classList.remove('hidden');
            } else {
                pinnedBadge.classList.add('hidden');
            }
            
            // Show modal
            document.getElementById('announcementModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeAnnouncementModal() {
            document.getElementById('announcementModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Event listeners for closing modal
        document.getElementById('closeAnnouncementModal').addEventListener('click', closeAnnouncementModal);
        document.getElementById('closeAnnouncementModalBtn').addEventListener('click', closeAnnouncementModal);

        // Close modal when clicking outside
        document.getElementById('announcementModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAnnouncementModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAnnouncementModal();
            }
        });

        // JavaScript for Quiz Details Modal
        function showQuizDetailsModal(quiz) {
            document.getElementById('modalQuizTitle').textContent = quiz.quiz_title;
            document.getElementById('modalQuizDescription').textContent = quiz.quiz_description || 'No description provided.';
            document.getElementById('modalQuizQuestions').textContent = quiz.total_questions || '0';
            document.getElementById('modalQuizTimeLimit').textContent = `${quiz.time_limit} minutes`;
            document.getElementById('modalQuizTotalScore').textContent = quiz.total_score || '0';
            document.getElementById('modalQuizStatus').textContent = quiz.status.charAt(0).toUpperCase() + quiz.status.slice(1);

            // Set the quiz ID for the "Take Quiz" button
            document.getElementById('takeQuizBtn').dataset.quizId = quiz.quiz_id;

            document.getElementById('quizDetailsModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeQuizDetailsModal() {
            document.getElementById('quizDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.getElementById('closeQuizDetailsModal').addEventListener('click', closeQuizDetailsModal);
        document.getElementById('cancelQuizBtn').addEventListener('click', closeQuizDetailsModal);

        document.getElementById('quizDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuizDetailsModal();
            }
        });

        document.getElementById('takeQuizBtn').addEventListener('click', function() {
            const quizId = this.dataset.quizId;
            if (quizId) {
                // Redirect to the quiz taking page
                window.location.href = `quizPage.php?quiz_id=${quizId}`; // Placeholder URL
            }
        });
    </script>

</body>

</html>
