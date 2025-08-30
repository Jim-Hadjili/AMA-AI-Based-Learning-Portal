<div class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-lg rounded-xl overflow-hidden border border-blue-200 mb-8">
    <!-- Table Header -->
    <div class="bg-white border-b border-blue-100 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Class Quizzes</h3>
                    <p class="text-sm text-gray-600">Complete list of all quizzes and student attempts</p>
                </div>
            </div>
            <?php if (!empty($quizzes)): ?>
                <div class="bg-white px-4 py-2 rounded-xl shadow-sm">
                    <div class="text-center">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Quizzes</p>
                        <p class="text-xl font-bold text-blue-600"><?php echo count($quizzes); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($quizzes)): ?>
        <!-- Empty state - No Quizzes Available -->
        <div class="bg-white p-6 text-center">
            <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <h4 class="text-xl font-semibold text-gray-900 mb-2">No Quizzes Available</h4>
            <p class="text-gray-500 max-w-md mx-auto">There are no quizzes in this class yet.</p>
        </div>
    <?php else: ?>
        <div class="bg-white">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Quiz
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                    Type
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Questions
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Status
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                    Attempts
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="quiz-table-body" class="bg-white divide-y divide-gray-100">
                        <?php foreach ($quizzes as $quiz): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200 quiz-row"
                                data-title="<?php echo htmlspecialchars(strtolower($quiz['quiz_title'])); ?>"
                                data-status="<?php echo !$quiz['latest_attempt'] ? 'not-attempted' : ($quiz['latest_attempt']['status'] === 'completed' ? 'completed' : 'other'); ?>"
                                data-attempts="<?php echo $quiz['total_attempts'] > 0 ? 'with-attempts' : 'no-attempts'; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($quiz['created_at'])); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($quiz['quiz_type'] == 'manual'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Manual
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            AI Generated
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <?php echo $quiz['question_count']; ?> questions
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if (!$quiz['latest_attempt']): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Not Attempted
                                        </span>
                                    <?php elseif ($quiz['latest_attempt']['status'] === 'completed'): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <?php echo ucfirst($quiz['latest_attempt']['status']); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <?php echo $quiz['total_attempts']; ?>
                                    <?php if ($quiz['total_attempts'] > $quiz['attempt_count'] && $quiz['attempt_count'] > 0): ?>
                                        <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            +<?php echo $quiz['total_attempts'] - $quiz['attempt_count']; ?> AI
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                    <?php if ($quiz['latest_attempt'] && $quiz['latest_attempt']['status'] === 'completed'): ?>
                                        <a href="viewStudentAttempt.php?attempt_id=<?php echo $quiz['latest_attempt']['attempt_id']; ?>"
                                            class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Attempt
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">No Attempts</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty Results Message -->
            <div id="no-results-message" class="hidden p-8 text-center">
                <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No matching quizzes found</h4>
                <p class="text-gray-500">Try adjusting your search or filter criteria</p>
            </div>
        </div>
    <?php endif; ?>
</div>