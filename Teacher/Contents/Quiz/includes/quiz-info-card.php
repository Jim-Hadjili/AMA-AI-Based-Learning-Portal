<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 flex-1 min-w-[300px]">
    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-info-circle text-blue-500"></i> Quiz Information
    </h3>
    <div class="space-y-4">
        <div>
            <p class="text-sm text-gray-500">Created On</p>
            <p class="font-medium"><?php echo !empty($quiz['created_at']) ? date('F j, Y', strtotime($quiz['created_at'])) : 'Not available'; ?></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Last Modified</p>
            <p class="font-medium"><?php echo !empty($quiz['updated_at']) ? date('F j, Y', strtotime($quiz['updated_at'])) : 'Not available'; ?></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Questions</p>
            <p class="font-medium"><span id="totalQuestionsCount"><?php echo count($questions); ?></span> questions</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Attempts</p>
            <p class="font-medium"><?php echo isset($quiz['attempts_count']) ? intval($quiz['attempts_count']) : 0; ?> submissions</p>
        </div>
    </div>
</div>