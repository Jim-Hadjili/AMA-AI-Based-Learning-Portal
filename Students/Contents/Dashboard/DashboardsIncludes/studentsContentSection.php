<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Quizzes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Quizzes</h3>
        <?php if (!empty($recentQuizzes)): ?>
            <ul>
                <?php foreach ($recentQuizzes as $i => $quiz): ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>#quiz-<?php echo $quiz['quiz_id']; ?>"
                           class="flex items-center gap-3 hover:bg-blue-50 rounded-lg p-2 transition relative">
                            <i class="fas fa-clipboard-list text-blue-400 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 flex items-center">
                                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                </div>
                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($quiz['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($quiz['created_at'])); ?></div>
                            </div>
                            <?php if ($i === 0): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold bg-blue-500 text-white rounded shadow">New</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-blue-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent quizzes available</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quiz Results: Only Passed Attempts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quiz Results</h3>
        <?php if (!empty($passedQuizAttempts)): ?>
            <ul>
                <?php foreach ($passedQuizAttempts as $i => $attempt): ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/quizAttempts.php?quiz_id=<?php echo $attempt['quiz_id']; ?>&class_id=<?php echo $attempt['class_id']; ?>"
                           class="flex items-center gap-3 hover:bg-green-50 rounded-lg p-2 transition relative">
                            <i class="fas fa-poll text-green-400 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 flex items-center">
                                    <?php echo htmlspecialchars($attempt['quiz_title']); ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <?php echo htmlspecialchars($attempt['class_name']); ?> &middot;
                                    <?php echo date('M d, Y', strtotime($attempt['end_time'])); ?> &middot;
                                    Score: <?php echo $attempt['score']; ?>
                                </div>
                            </div>
                            <?php if ($i === 0): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold bg-green-500 text-white rounded shadow">New</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-poll text-green-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No passed quiz results to display</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Recent Materials -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Materials</h3>
        <?php if (!empty($recentMaterials)): ?>
            <ul>
                <?php foreach ($recentMaterials as $i => $material): ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $material['class_id']; ?>#material-<?php echo $material['material_id']; ?>"
                           class="flex items-center gap-3 hover:bg-yellow-50 rounded-lg p-2 transition relative">
                            <i class="fas fa-file-alt text-yellow-300 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 flex items-center">
                                    <?php echo htmlspecialchars($material['material_title']); ?>
                                </div>
                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($material['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($material['upload_date'])); ?></div>
                            </div>
                            <?php if ($i === 0): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold bg-yellow-500 text-white rounded shadow">New</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-yellow-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent materials</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Latest Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Latest Announcements</h3>
        <?php if (!empty($recentAnnouncements)): ?>
            <ul>
                <?php foreach ($recentAnnouncements as $i => $announcement): ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $announcement['class_id']; ?>#announcement-<?php echo $announcement['announcement_id']; ?>"
                           class="flex items-center gap-3 hover:bg-red-50 rounded-lg p-2 transition relative">
                            <i class="fas fa-bullhorn text-red-300 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 flex items-center">
                                    <?php echo htmlspecialchars($announcement['title']); ?>
                                </div>
                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($announcement['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?></div>
                            </div>
                            <?php if ($i === 0): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold bg-red-500 text-white rounded shadow">New</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-bullhorn text-red-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No announcements yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>