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
</div>