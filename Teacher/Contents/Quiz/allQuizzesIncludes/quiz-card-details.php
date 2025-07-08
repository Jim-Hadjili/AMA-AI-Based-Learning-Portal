<div class="space-y-2 mb-4">
    <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center">
            <i class="fas fa-clock mr-2 text-gray-400"></i>
            Time Limit
        </span>
        <span class="font-medium text-gray-900">
            <?php echo formatTimeLimit($quiz['time_limit']); ?>
        </span>
    </div>
    
    <div class="flex items-center justify-between text-sm">
        <span class="text-gray-500 flex items-center">
            <i class="fas fa-star mr-2 text-gray-400"></i>
            Points per Question
        </span>
        <span class="font-medium text-gray-900">
            <?php echo $quiz['points_per_question']; ?>
        </span>
    </div>
    
    <?php if ($quiz['avg_score'] !== null): ?>
        <div class="flex items-center justify-between text-sm">
            <span class="text-gray-500 flex items-center">
                <i class="fas fa-chart-line mr-2 text-gray-400"></i>
                Average Score
            </span>
            <span class="font-medium text-gray-900">
                <?php echo number_format($quiz['avg_score'], 1); ?>%
            </span>
        </div>
    <?php endif; ?>
</div>