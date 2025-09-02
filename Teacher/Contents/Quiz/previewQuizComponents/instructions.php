<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
        <div class="p-2 bg-yellow-100 rounded-lg">
            <i class="fas fa-info-circle text-yellow-600"></i>
        </div>
        <h2 class="text-lg font-semibold text-gray-900">Instructions</h2>
    </div>
    <div class="p-6">
        <p class="text-gray-600">
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
</div>