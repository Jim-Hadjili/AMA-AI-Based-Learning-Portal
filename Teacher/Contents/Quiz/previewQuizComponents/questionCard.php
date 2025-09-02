<div class="quiz-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-lg transition-shadow hover:shadow-xl">
    <!-- Question Header -->
    <div class="bg-gray-50 px-6 py-3 border-b border-gray-100 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-semibold text-blue-600">
                <?php echo $index + 1; ?>
            </div>
            <span class="text-sm text-gray-500">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></span>
        </div>

    </div>
    
    <!-- Answer Options -->
    <div class="p-6">
        <?php
        $questionType = str_replace('-', '_', $question['question_type']);
        $questionTypeFile = 'questionTypes/' . $questionType . '.php';
        if (file_exists(__DIR__ . '/' . $questionTypeFile)) {
            include $questionTypeFile;
        } else {
            include 'questionTypes/default.php';
        }
        ?>

        <!-- Correct Answer Display -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
            <div class="p-2 bg-green-200 rounded-full">
                <i class="fas fa-check text-green-700"></i>
            </div>
            <div class="text-green-800 font-semibold">
                <?php
                // Multiple Choice & Checkbox
                if (!empty($question['options'])) {
                    $corrects = [];
                    foreach ($question['options'] as $option) {
                        if (!empty($option['is_correct'])) {
                            $corrects[] = htmlspecialchars($option['option_text']);
                        }
                    }
                    if ($questionType === 'checkbox') {
                        echo "Correct Answers: " . implode(', ', $corrects);
                    } else {
                        echo "Correct Answer: " . (count($corrects) ? $corrects[0] : 'None');
                    }
                }
                // Short Answer, etc.
                elseif (!empty($question['correct_answer'])) {
                    echo "Correct Answer: " . htmlspecialchars($question['correct_answer']);
                } else {
                    echo "Correct answer not set.";
                }
                ?>
            </div>
        </div>
    </div>
</div>