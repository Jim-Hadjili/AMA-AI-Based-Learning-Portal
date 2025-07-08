<div class="quiz-card bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
    <!-- Question Header -->
    <div class="bg-gray-50 px-6 py-3 border-b border-gray-100 flex justify-between items-center">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 font-semibold text-blue-600">
                <?php echo $index + 1; ?>
            </div>
            <span class="text-sm text-gray-500">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></span>
        </div>
        <div>
            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm font-medium rounded-full">
                <?php echo $question['question_points']; ?> <?php echo $question['question_points'] == 1 ? 'point' : 'points'; ?>
            </span>
        </div>
    </div>
    
    <!-- Question Content -->
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4"><?php echo htmlspecialchars($question['question_text']); ?></h3>
        
        <?php if (!empty($question['question_image'])): ?>
            <div class="mb-6">
                <img src="../../../Assets/Images/quiz/<?php echo $question['question_image']; ?>" 
                    alt="Question image" 
                    class="max-w-full h-auto rounded-lg border border-gray-100 shadow-sm">
            </div>
        <?php endif; ?>
        
        <!-- Answer Options -->
        <div class="mt-5">
            <?php
            // Convert question type format if needed (replace hyphens with underscores)
            $questionType = str_replace('-', '_', $question['question_type']);
            
            // Check if the specific question type file exists
            $questionTypeFile = 'questionTypes/' . $questionType . '.php';
            
            if (file_exists(__DIR__ . '/' . $questionTypeFile)) {
                include $questionTypeFile;
            } else {
                // Fall back to default template if specific type not found
                include 'questionTypes/default.php';
            }
            ?>
        </div>
    </div>
</div>