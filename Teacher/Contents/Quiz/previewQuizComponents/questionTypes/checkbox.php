<!-- Checkbox -->
<div class="space-y-3">
    <?php foreach ($question['options'] as $optIndex => $option): ?>
        <label class="flex items-center gap-3 mb-3 <?php echo !empty($option['is_correct']) ? 'bg-green-100 border border-green-300 rounded-lg px-3 py-2' : ''; ?>">
            <input 
                type="checkbox" 
                disabled 
                <?php echo !empty($option['is_correct']) ? 'checked' : ''; ?> 
                class="form-checkbox h-5 w-5 text-green-600 border-gray-300 rounded"
            >
            <span class="text-gray-800"><?php echo htmlspecialchars($option['option_text']); ?></span>
            <?php if (!empty($option['is_correct'])): ?>
                <span class="ml-2 text-green-600"><i class="fas fa-check"></i></span>
            <?php endif; ?>
        </label>
    <?php endforeach; ?>
</div>