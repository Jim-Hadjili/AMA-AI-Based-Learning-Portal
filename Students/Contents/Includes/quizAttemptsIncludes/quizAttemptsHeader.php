<div class="bg-white shadow-sm border-b">
    <div class="max-w-6xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between">
            <div>
                <nav class="text-sm text-gray-500 mb-2">
                    <a href="classDetails.php?class_id=<?php echo $class_id; ?>" class="hover:text-accent-600">Class</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">Quiz Attempts</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                <p class="text-gray-600 mt-1">Review your quiz performance and track your progress</p>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-accent-600"><?php echo count($attempts); ?></div>
                <div class="text-sm text-gray-500 uppercase tracking-wide">Attempts</div>
            </div>
        </div>
    </div>
</div>