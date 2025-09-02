<!-- True/False -->
<div class="grid grid-cols-2 gap-4 mt-2">
    <?php
    $correct = isset($question['correct_answer']) ? strtolower(trim($question['correct_answer'])) : '';
    ?>
    <label class="flex items-center p-4 border border-gray-200 rounded-lg option-hover <?php echo $correct === 'true' ? 'bg-green-100 border-green-300' : ''; ?>">
        <input type="radio"
            name="question_<?php echo $question['question_id']; ?>"
            id="true_<?php echo $question['question_id']; ?>"
            value="true"
            disabled
            <?php echo $correct === 'true' ? 'checked' : ''; ?>
            class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500"
        >
        <span class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">True</span>
        <?php if ($correct === 'true'): ?>
            <span class="ml-2 text-green-600"><i class="fas fa-check"></i></span>
        <?php endif; ?>
    </label>
    <label class="flex items-center p-4 border border-gray-200 rounded-lg option-hover <?php echo $correct === 'false' ? 'bg-green-100 border-green-300' : ''; ?>">
        <input type="radio"
            name="question_<?php echo $question['question_id']; ?>"
            id="false_<?php echo $question['question_id']; ?>"
            value="false"
            disabled
            <?php echo $correct === 'false' ? 'checked' : ''; ?>
            class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500"
        >
        <span class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">False</span>
        <?php if ($correct === 'false'): ?>
            <span class="ml-2 text-green-600"><i class="fas fa-check"></i></span>
        <?php endif; ?>
    </label>
</div>