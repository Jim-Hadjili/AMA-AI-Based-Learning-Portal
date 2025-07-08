<div class="mb-8">
    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border border-gray-400">
            <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $totalQuizzes; ?></div>
            <div class="text-sm text-gray-500">
                <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                    Filtered Results
                <?php else: ?>
                    Total Quizzes
                <?php endif; ?>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-400">
            <div class="text-2xl font-bold text-green-600 mb-1">
                <?php echo $statsData['published']; ?>
            </div>
            <div class="text-sm text-gray-500">Published</div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-400">
            <div class="text-2xl font-bold text-yellow-600 mb-1">
                <?php echo $statsData['drafts']; ?>
            </div>
            <div class="text-sm text-gray-500">Drafts</div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-400">
            <div class="text-2xl font-bold text-blue-600 mb-1">
                <?php echo $statsData['attempts']; ?>
            </div>
            <div class="text-sm text-gray-500">Total Attempts</div>
        </div>
    </div>
</div>