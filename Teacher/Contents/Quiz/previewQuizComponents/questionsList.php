<form id="quiz-preview-form" class="space-y-8">
    <?php foreach ($questions as $index => $question): ?>
        <?php include 'questionCard.php'; ?>
    <?php endforeach; ?>
    
    <!-- Quiz Footer -->
    <div class="bg-white rounded-lg shadow-soft p-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <p class="text-gray-600">
                    This is a preview mode. Answers are not saved.
                </p>
            </div>
            <button type="submit" disabled class="w-full sm:w-auto px-6 py-3 bg-gray-500 text-white rounded-lg cursor-not-allowed opacity-75">
                Submit Quiz (Preview Only)
            </button>
        </div>
    </div>
</form>