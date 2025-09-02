<!-- Multiple Choice -->
<div class="space-y-3">
    <?php if (!empty($question['options']) && is_array($question['options'])): ?>
        <?php foreach ($question['options'] as $option): ?>
            <label class="flex items-center p-3 rounded-lg option-hover <?php echo !empty($option['is_correct']) ? 'bg-green-100 border border-green-300' : ''; ?>">
                <input type="radio"
                    name="question_<?php echo $question['question_id']; ?>"
                    id="option_<?php echo $option['option_id']; ?>"
                    value="<?php echo $option['option_id']; ?>"
                    disabled
                    <?php echo !empty($option['is_correct']) ? 'checked' : ''; ?>
                    class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500"
                >
                <span class="ml-3 block text-gray-700 w-full cursor-pointer"><?php echo htmlspecialchars($option['option_text']); ?></span>
                <?php if (!empty($option['is_correct'])): ?>
                    <span class="ml-2 text-green-600"><i class="fas fa-check"></i></span>
                <?php endif; ?>
            </label>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-red-500">No options available for this question.</div>
    <?php endif; ?>
</div>