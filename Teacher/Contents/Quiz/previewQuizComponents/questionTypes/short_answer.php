<!-- Short Answer -->
<div class="mt-2">
    <textarea name="question_<?php echo $question['question_id']; ?>"
        rows="3"
        placeholder="Type your answer here..."
        class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm py-3 px-4 bg-gray-100 text-gray-700"
        readonly
    ><?php echo !empty($question['correct_answer']) ? htmlspecialchars($question['correct_answer']) : ''; ?></textarea>
    <?php if (!empty($question['correct_answer'])): ?>
        <div class="mt-2 flex items-center gap-2 text-green-700">
            <i class="fas fa-check bg-green-100 rounded-full p-1"></i>
            <span class="font-semibold">Correct Answer</span>
        </div>
    <?php endif; ?>
</div>