<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
    <!-- Table Header -->
    <div class="table-header px-6 py-4">
        <h2 class="text-xl font-semibold text-white">Attempt History</h2>
    </div>

    <!-- Table Content -->
    <div class="divide-y divide-gray-100">
        <?php foreach ($attempts as $i => $attempt):
            // Calculate percentage for display
            $display_percentage = round(($attempt['score'] / $total_possible_points) * 100);
            $result = $attempt['result'] ?? $attempt['status'];
            $attemptNumber = count($attempts) - $i;

            // Score classification for badge color
            $scoreClass = 'score-poor';
            if ($display_percentage >= 75) $scoreClass = 'score-passed';
            else $scoreClass = 'score-failed';
        ?>
            <div class="attempt-row attempt-row-<?php echo $result; ?> px-6 py-5 cursor-pointer"
                onclick="window.location.href='attemptsQuizResult.php?attempt_id=<?php echo $attempt['attempt_id']; ?>&class_id=<?php echo $class_id; ?>'">
                <div class="flex items-center justify-between">
                    <!-- Left: Attempt Info -->
                    <div class="flex items-center space-x-4">
                        <div class="score-badge <?php echo $scoreClass; ?> w-16 h-16 rounded-2xl flex items-center justify-center">
                            <?php
                            // Trophy icon for passed, sad face for failed
                            if ($display_percentage >= 75) {
                                // Trophy icon for passed
                                echo '<svg class="w-10 h-10 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 012 0v1h3a1 1 0 011 1v2a5 5 0 01-4 4.9V13h2a1 1 0 110 2H7a1 1 0 110-2h2V8.9A5 5 0 015 6V4a1 1 0 011-1h3V2zm-2 3v1a3 3 0 006 0V5H7z"/></svg>';
                            } else {
                                // Sad face icon for failed
                                echo '<svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path d="M9 15c.5-.667 1.5-1 3-1s2.5.333 3 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="10" r="1" fill="currentColor"/><circle cx="15" cy="10" r="1" fill="currentColor"/></svg>';
                            }
                            ?>
                        </div>
                        <div>
                            <div class="flex items-center space-x-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Attempt #<?php echo $attemptNumber; ?>
                                </h3>
                                <?php if ($i === 0): ?>
                                    <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full uppercase tracking-wide shadow">Latest</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Score & Status -->
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900 mb-1"><?php echo $display_percentage; ?>%</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            <?php echo $display_percentage >= 75 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'; ?>">
                                <?php echo $display_percentage >= 75 ? 'Passed' : 'Failed'; ?>
                            </span>
                        </div>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>