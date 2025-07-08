<!-- Quiz Header -->
<div class="bg-white rounded-lg shadow-soft p-6 mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
    <p class="text-gray-600"><?php echo htmlspecialchars($quiz['quiz_description'] ?? ''); ?></p>
    
    <div class="flex flex-wrap items-center mt-4 pt-4 border-t border-gray-100 text-sm">
        <div class="flex items-center mr-6 mb-2">
            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-2">
                <i class="fas fa-clock text-blue-500"></i>
            </div>
            <span>
                <span class="font-medium"><?php echo $quiz['time_limit'] ? $quiz['time_limit'].' minutes' : 'No time limit'; ?></span>
            </span>
        </div>
        
        <div class="flex items-center mr-6 mb-2">
            <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center mr-2">
                <i class="fas fa-question text-green-500"></i>
            </div>
            <span>
                <span class="font-medium"><?php echo count($questions); ?></span> Questions
            </span>
        </div>
        
        <div class="flex items-center mb-2">
            <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center mr-2">
                <i class="fas fa-star text-purple-500"></i>
            </div>
            <span>
                <span class="font-medium"><?php echo $totalPoints; ?></span> Points
            </span>
        </div>
    </div>
</div>