<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Recent Quizzes -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-50 to-green-50 px-7 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Recent Quizzes</h2>
            </div>
            <a href="classDetailsAllQuizzes.php?class_id=<?php echo urlencode($class_id); ?>" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors px-3 py-2 rounded-lg hover:bg-emerald-100">
                View All →
            </a>
        </div>
        <div class="p-7">
            <?php if (empty($recentQuizzes)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-4 border border-gray-200">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">No quizzes available yet.</p>
                    <p class="text-sm text-gray-400 mt-1">Check back later for new assessments</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentQuizzes as $quiz): ?>
                        <?php
                            $attempt = $quiz['student_attempt'] ?? null;
                            $failed = ($attempt && $attempt['result'] === 'failed');
                        ?>
                        <div class="group p-5 bg-gradient-to-r <?php echo ($quiz['is_personalized'] ?? false) ? 'from-indigo-50 to-blue-50 border-blue-400' : 'from-gray-50 to-gray-25 border-emerald-400'; ?> rounded-xl cursor-pointer hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 hover:border-blue-200 hover:shadow-md border"
                            onclick="handleQuizCardClick(<?php echo htmlspecialchars(json_encode($quiz)); ?>, <?php echo $failed ? 'true' : 'false'; ?>)">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-blue-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                                    <?php if ($quiz['is_personalized'] ?? false): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 mb-2">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            Personalized
                                        </span>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-600 break-words line-clamp-2 mb-3"><?php echo htmlspecialchars(substr($quiz['quiz_description'] ?? 'No description', 0, 100)) . (strlen($quiz['quiz_description'] ?? '') > 100 ? '...' : ''); ?></p>
                                    <div class="flex flex-wrap items-center gap-3 text-xs">
                                        <div class="flex items-center gap-1 text-gray-600 bg-white px-2 py-1 rounded-lg">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span><?php echo $quiz['time_limit']; ?> min</span>
                                        </div>
                                        <span class="px-3 py-1 rounded-full font-medium <?php echo $quiz['status'] === 'published' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200'; ?>">
                                            <?php echo ucfirst($quiz['status']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 w-10 h-10 rounded-xl bg-white flex items-center justify-center group-hover:bg-blue-100 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Announcements -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-7 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Recent Announcements</h2>
            </div>
            <a href="classDetailsAllAnnouncements.php?class_id=<?php echo urlencode($class_id); ?>" class="text-sm font-semibold text-amber-600 hover:text-amber-700 transition-colors px-3 py-2 rounded-lg hover:bg-amber-100">
                View All →
            </a>
        </div>
        <div class="p-7">
            <?php if (empty($recentAnnouncements)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-4 border border-gray-200">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">No announcements yet.</p>
                    <p class="text-sm text-gray-400 mt-1">Stay tuned for class updates</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentAnnouncements as $announcement): ?>
                        <div class="group relative p-5 bg-gradient-to-r from-gray-50 to-gray-25 rounded-xl cursor-pointer hover:from-amber-50 hover:to-yellow-50 transition-all duration-200 border border-amber-400 hover:border-amber-200 hover:shadow-md <?php echo $announcement['is_pinned'] ? 'ring-2 ring-amber-200' : ''; ?>"
                            onclick="showAnnouncementModal(<?php echo htmlspecialchars(json_encode($announcement)); ?>)">
                            <?php if ($announcement['is_pinned']): ?>
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-400 to-orange-400 rounded-l-xl"></div>
                            <?php endif; ?>
                            <div class="flex items-start justify-between <?php echo $announcement['is_pinned'] ? 'pl-3' : ''; ?>">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="font-semibold text-gray-900 truncate group-hover:text-amber-900">
                                            <?php echo htmlspecialchars($announcement['title']); ?>
                                        </h3>
                                        <?php if ($announcement['is_pinned']): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-300 ml-1">
                                                <i class="fas fa-thumbtack mr-1 text-amber-500"></i> Pinned
                                            </span> <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-3 break-words mb-3"><?php echo htmlspecialchars(substr($announcement['content'], 0, 150)) . (strlen($announcement['content']) > 150 ? '...' : ''); ?></p>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 bg-white px-2 py-1 rounded-lg w-fit">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span><?php echo date('M j, Y', strtotime($announcement['created_at'])); ?></span>
                                    </div>
                                </div>
                                <div class="ml-4 w-10 h-10 rounded-xl bg-white flex items-center justify-center group-hover:bg-amber-100 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Learning Materials -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden lg:col-span-2">
        <div class="bg-gradient-to-r from-violet-50 to-purple-50 px-7 py-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-violet-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Learning Materials</h2>
            </div>
            <a href="classDetailsAllMaterials.php?class_id=<?php echo urlencode($class_id); ?>" class="text-sm font-semibold text-violet-600 hover:text-violet-700 transition-colors px-3 py-2 rounded-lg hover:bg-violet-100">
                View All →
            </a>
        </div>
        <div class="p-7">
            <?php if (empty($recentMaterials)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-4 border border-gray-200">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">No materials uploaded yet.</p>
                    <p class="text-sm text-gray-400 mt-1">Learning resources will appear here</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php foreach ($recentMaterials as $material): ?>
                        <a href="materialPreview.php?material_id=<?php echo $material['material_id']; ?>"
                            class="group flex items-center p-5 bg-gradient-to-r from-gray-50 to-gray-25 rounded-xl hover:from-violet-50 hover:to-purple-50 transition-all duration-200 border border-purple-400 hover:border-violet-200 hover:shadow-md">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-sm border-2
                                <?php
                                $fileTypeColors = [
                                    'pdf' => 'bg-gradient-to-br from-red-50 to-red-100 text-red-600 border-red-200',
                                    'doc' => 'bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 border-blue-200',
                                    'ppt' => 'bg-gradient-to-br from-orange-50 to-orange-100 text-orange-600 border-orange-200',
                                    'xls' => 'bg-gradient-to-br from-green-50 to-green-100 text-green-600 border-green-200',
                                    'image' => 'bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 border-purple-200',
                                    'video' => 'bg-gradient-to-br from-pink-50 to-pink-100 text-pink-600 border-pink-200',
                                    'audio' => 'bg-gradient-to-br from-cyan-50 to-cyan-100 text-cyan-600 border-cyan-200',
                                ];
                                $fileType = strtolower($material['file_type']);
                                echo isset($fileTypeColors[$fileType]) ? $fileTypeColors[$fileType] : 'bg-gradient-to-br from-gray-50 to-gray-100 text-gray-600 border-gray-200';
                                ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 truncate group-hover:text-violet-700 transition-colors mb-1"><?php echo htmlspecialchars($material['material_title']); ?></h3>
                                <p class="text-sm text-gray-600 truncate mb-1"><?php echo htmlspecialchars($material['file_name']); ?></p>
                                <div class="flex items-center gap-2 text-xs text-gray-500 bg-white px-2 py-1 rounded-lg w-fit">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span><?php echo date('M j, Y', strtotime($material['upload_date'])); ?></span>
                                </div>
                            </div>
                            <div class="ml-3 w-8 h-8 rounded-full bg-white flex items-center justify-center group-hover:bg-violet-100 transition-colors shadow-sm">
                                <svg class="w-3 h-3 text-gray-400 group-hover:text-violet-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Retake Quiz Modal -->
<?php include "../Modals/retakeQuizModal.php" ?>

<!-- Loading Modal -->
<?php include "../Modals/loadingModal.php" ?>

<script>
let selectedQuiz = null;

function handleQuizCardClick(quiz, failed) {
    if (failed) {
        selectedQuiz = quiz;
        document.getElementById('retakeQuizModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('retakeQuizConfirmBtn').onclick = function() {
            document.getElementById('loadingModal').classList.remove('hidden');
            // Give a short delay for modal to appear before redirect
            setTimeout(function() {
                window.location.href = "../../Functions/regenerateQuiz.php?quiz_id=" + encodeURIComponent(selectedQuiz.quiz_id);
            }, 600);
        };
    } else {
        // Show normal quiz details modal (existing logic)
        showQuizDetailsModal(quiz);
    }
}

function closeRetakeQuizModal() {
    document.getElementById('retakeQuizModal').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>