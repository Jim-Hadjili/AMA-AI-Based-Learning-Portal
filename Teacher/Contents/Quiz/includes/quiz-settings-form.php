<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 flex-1 min-w-[300px]">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-cog text-purple-500"></i> Quiz Settings
    </h3>
    <form id="quizSettingsForm" class="space-y-4">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

        <div>
            <label for="quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" id="quiz_title" name="quiz_title"
                value="<?php echo htmlspecialchars($quiz['quiz_title']); ?>"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>

        <div>
            <label for="quiz_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="quiz_description" name="quiz_description" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?php echo htmlspecialchars($quiz['quiz_description'] ?? ''); ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-1">Time (min)</label>
                <input type="number" id="time_limit" name="time_limit" min="1"
                    value="<?php echo $quiz['time_limit']; ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="draft" <?php echo $quiz['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo $quiz['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="archived" <?php echo $quiz['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                </select>
            </div>
        </div>
    </form>
</div>