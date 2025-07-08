<!-- Multiple Choice -->
<div class="space-y-3">
    <?php foreach ($question['options'] as $option): ?>
        <div class="flex items-center p-3 rounded-lg option-hover">
            <input type="radio" 
                name="question_<?php echo $question['question_id']; ?>" 
                id="option_<?php echo $option['option_id']; ?>" 
                value="<?php echo $option['option_id']; ?>" 
                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
            <label for="option_<?php echo $option['option_id']; ?>" class="ml-3 block text-gray-700 w-full cursor-pointer">
                <?php echo htmlspecialchars($option['option_text']); ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>