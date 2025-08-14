<div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <!-- Subtle top accent line for a touch of modern color -->
    <div class="h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
    
    <div class="p-6 sm:p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <!-- Left section: Icon, Title, Description, and Stats -->
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 flex-1">
                <!-- Clean, simple icon container -->
                <div class="flex-shrink-0 w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-award text-2xl text-blue-600"></i>
                </div>
                
                <!-- Content section for quiz details -->
                <div class="flex-1 min-w-0">
                    <div class="mb-4">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">
                            Quiz Results: <span class="text-indigo-700"><?php echo htmlspecialchars($quizDetails['quiz_title']); ?></span>
                        </h1>
                        <p class="text-gray-600 text-base mt-1">
                            <?php echo htmlspecialchars($quizDetails['quiz_description'] ?? 'No description provided.'); ?>
                        </p>
                    </div>
                    
                    <!-- Simplified Stats layout without individual cards/borders -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-blue-500"></i>
                            <span>Attempt Date: <strong class="font-semibold"><?php echo date('M d, Y H:i', strtotime($quizAttempt['end_time'])); ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-list-ol text-purple-500"></i>
                            <span>Total Questions: <strong class="font-semibold"><?php echo $total_questions; ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Correct Answers: <strong class="font-semibold"><?php echo $correct_answers_count; ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right section: Score and Performance Indicator -->
            <div class="flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                <div class="text-center lg:text-right">
                    <!-- Prominent score display with conditional coloring -->
                    <div class="text-4xl font-extrabold leading-none mb-2 <?php echo ($percentage_score >= 65) ? 'text-green-700' : 'text-red-700'; ?>">
                        <?php echo $quizAttempt['score']; ?> / <?php echo $total_possible_score; ?>
                    </div>
                    <div class="text-xl font-bold text-gray-800 mb-4">
                        (<?php echo $percentage_score; ?>%)
                    </div>
                    
                    <!-- Performance indicator badge -->
                    <div>
                        <?php if ($percentage_score >= 90): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Excellent
                            </span>
                        <?php elseif ($percentage_score >= 65): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-thumbs-up mr-1"></i> Good
                            </span>
                        <?php else: ?>
                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Progress bar at the bottom for visual progress -->
    <div class="px-6 pb-6">
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div class="<?php echo ($percentage_score >= 65) ? 'bg-green-500' : 'bg-red-500'; ?> h-2 rounded-full transition-all duration-1000 ease-out" 
                 style="width: <?php echo $percentage_score; ?>%"></div>
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-500">
            <span>0%</span>
            <span class="font-medium">Progress: <?php echo $percentage_score; ?>%</span>
            <span>100%</span>
        </div>
    </div>
</div>