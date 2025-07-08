<!-- True/False -->
<div class="grid grid-cols-2 gap-4 mt-2">
    <div class="flex items-center p-4 border border-gray-200 rounded-lg option-hover">
        <input type="radio" 
            name="question_<?php echo $question['question_id']; ?>" 
            id="true_<?php echo $question['question_id']; ?>" 
            value="true" 
            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
        <label for="true_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">True</label>
    </div>
    <div class="flex items-center p-4 border border-gray-200 rounded-lg option-hover">
        <input type="radio" 
            name="question_<?php echo $question['question_id']; ?>" 
            id="false_<?php echo $question['question_id']; ?>" 
            value="false" 
            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
        <label for="false_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">False</label>
    </div>
</div>