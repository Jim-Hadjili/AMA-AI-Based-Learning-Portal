<?php
// Enhanced Quiz Card Component with Modern Design
// This file requires the helper functions to be loaded and expects a $quiz variable to be defined

$statusBadge = getStatusBadge($quiz['status']);
$isAIGenerated = isset($quiz['quiz_type']) && $quiz['quiz_type'] === '1';
$questionCount = $quiz['question_count'] ?? 0;
$attemptCount = $quiz['attempt_count'] ?? 0;
?>

<div class="quiz-card group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1" data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
    
    <!-- Card Header with Gradient Background -->
    <div class="relative p-6  border-b border-gray-300">
        <!-- Status Badge - Positioned absolutely -->
        <div class="absolute top-4 right-4">
            <span class="quiz-status inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm <?php echo $statusBadge; ?>">
                <?php if ($quiz['status'] === 'published'): ?>
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <i class="fas fa-globe mr-1"></i>
                <?php elseif ($quiz['status'] === 'draft'): ?>
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                    <i class="fas fa-pencil-alt mr-1"></i>
                <?php else: ?>
                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                    <i class="fas fa-archive mr-1"></i>
                <?php endif; ?>
                <?php echo ucfirst($quiz['status']); ?>
            </span>
        </div>

        <!-- Title and Topic -->
        <div class="pr-20">
            <h4 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight" title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                <?php echo htmlspecialchars($quiz['quiz_title']); ?>
            </h4>
            
            <?php if (!empty($quiz['quiz_topic'])): ?>
                <div class="flex items-center mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-blue-700 border border-blue-200 shadow-sm">
                        <i class="fas fa-tag mr-2 text-blue-500"></i>
                        <?php echo htmlspecialchars($quiz['quiz_topic']); ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <!-- AI Generated Badge -->
            <?php if ($isAIGenerated): ?>
                <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 border border-purple-200 mb-3">
                    <i class="fas fa-robot mr-1"></i>
                    AI Generated
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Description -->
        <?php if (!empty($quiz['quiz_description'])): ?>
            <p class="text-sm text-gray-700 line-clamp-2 leading-relaxed mt-2">
                <?php echo htmlspecialchars($quiz['quiz_description']); ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Card Body - Enhanced Stats -->
    <div class="p-6">
        <!-- Main Stats Grid -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Questions Count -->
            <div class="relative overflow-hidden rounded-xl p-4 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-blue-900 mb-1">
                            <?php echo $questionCount; ?>
                        </div>
                        <div class="text-xs font-medium text-blue-700 uppercase tracking-wide">
                            Question<?php echo $questionCount != 1 ? 's' : ''; ?>
                        </div>
                    </div>
                    <div class="text-blue-400 opacity-20">
                        <i class="fas fa-question-circle text-3xl"></i>
                    </div>
                </div>
                <?php if ($questionCount === 0): ?>
                    <div class="absolute inset-0 bg-red-50 bg-opacity-90 flex items-center justify-center">
                        <span class="text-xs font-medium text-red-600">No Questions</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Attempts Count -->
            <div class="relative overflow-hidden rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-green-900 mb-1">
                            <?php echo $attemptCount; ?>
                        </div>
                        <div class="text-xs font-medium text-green-700 uppercase tracking-wide">
                            Attempt<?php echo $attemptCount != 1 ? 's' : ''; ?>
                        </div>
                    </div>
                    <div class="text-green-400 opacity-20">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Row -->
        <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
            <!-- Creation Date -->
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                <span>Created <?php echo date('M j, Y', strtotime($quiz['created_at'])); ?></span>
            </div>
            
            <!-- Time Limit -->
            <?php if (!empty($quiz['time_limit'])): ?>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2 text-orange-400"></i>
                    <span class="font-medium text-orange-600"><?php echo formatTimeLimit($quiz['time_limit']); ?></span>
                </div>
            <?php endif; ?>
        </div>


    </div>

    <!-- Card Footer - Enhanced Actions -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        <div class="flex items-center justify-between">
            <!-- Primary Actions -->
            <div class="flex space-x-3">
                <!-- Edit Button -->
                <a href="../Quiz/editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                
                <!-- Results Button -->
                <?php if ($quiz['status'] === 'published' && $attemptCount > 0): ?>
                    <a href="../../pages/teacherQuizResult.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 hover:border-green-300 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-chart-line mr-2"></i>
                        Results
                    </a>
                <?php endif; ?>

                <!-- Quick Preview Button -->
                <a href="../Quiz/previewQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-700 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 hover:border-purple-300 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-eye mr-2"></i>
                    Preview
                </a>
            </div>
            
            <!-- More Actions Dropdown -->
            <div class="relative">
                <button class="quiz-menu-btn inline-flex items-center p-2.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg transition-all duration-200" 
                        data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                    <i class="fas fa-ellipsis-v text-lg"></i>
                </button>
                
                <!-- Enhanced Dropdown Menu -->
                <div class="quiz-menu hidden absolute right-0 bottom-full mb-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200 z-20 overflow-hidden">
                    <div class="py-2">
                        <?php if ($quiz['status'] === 'draft'): ?>
                            <button class="publish-quiz-btn w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center transition-colors duration-200" 
                                    data-quiz-id="<?php echo $quiz['quiz_id']; ?>"
                                    data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>"
                                    data-question-count="<?php echo $questionCount; ?>">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-paper-plane text-green-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Publish Quiz</div>
                                    <div class="text-xs text-gray-500">Make available to students</div>
                                </div>
                            </button>
                        <?php elseif ($quiz['status'] === 'published'): ?>
                            <button class="unpublish-quiz-btn w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 flex items-center transition-colors duration-200" 
                                    data-quiz-id="<?php echo $quiz['quiz_id']; ?>"
                                    data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-pause text-yellow-600"></i>
                                </div>
                                <div>
                                    <div class="font-medium">Unpublish</div>
                                    <div class="text-xs text-gray-500">Hide from students</div>
                                </div>
                            </button>
                        <?php endif; ?>
      
                        <div class="border-t border-gray-100 my-2"></div>
                        
                        <button class="delete-quiz-btn w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center transition-colors duration-200" 
                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>" 
                                data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-trash text-red-600"></i>
                            </div>
                            <div>
                                <div class="font-medium">Delete Quiz</div>
                                <div class="text-xs text-gray-500">Permanently remove</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
