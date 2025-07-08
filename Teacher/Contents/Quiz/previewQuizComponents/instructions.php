<!-- Quiz Instructions -->
<div class="border-b border-gray-100 p-6">
    <div class="flex items-center mb-3">
        <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center mr-2">
            <i class="fas fa-info-circle text-yellow-500"></i>
        </div>
        <h2 class="text-lg font-semibold text-gray-800">Instructions</h2>
    </div>
    <p class="text-gray-600 pl-10">
        <?php if (!empty($quiz['instructions'])): ?>
            <?php echo htmlspecialchars($quiz['instructions']); ?>
        <?php else: ?>
            Complete all questions to the best of your ability.
            <?php if ($quiz['time_limit']): ?>
                You have <?php echo $quiz['time_limit']; ?> minutes to complete this quiz.
            <?php endif; ?>
        <?php endif; ?>
    </p>
</div>