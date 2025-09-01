<!-- AI Quiz Generator Modal -->
<div id="aiQuizGeneratorModal" class="fixed rounded-2xl inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h2 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-robot text-purple-600"></i>
                </span>
                AI Quiz Generator
            </h2>
            <button type="button" onclick="closeAIQuizGeneratorModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Form -->
        <form id="aiQuizGeneratorForm" class="px-6 py-6 bg-white rounded-b-2xl" onsubmit="submitAIQuizGeneratorForm(event)">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <div class="space-y-4">
                <div>
                    <label for="ai_quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title<span class="text-red-500">*</span></label>
                    <input type="text" name="ai_quiz_title" id="ai_quiz_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                </div>
                <div>
                    <label for="ai_quiz_topic" class="block text-sm font-medium text-gray-700 mb-1">Quiz Topic / Objectives<span class="text-red-500">*</span></label>
                    <input type="text" name="ai_quiz_topic" id="ai_quiz_topic" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                </div>
                <div>
                    <label for="ai_num_questions" class="block text-sm font-medium text-gray-700 mb-1">Number of Questions<span class="text-red-500">*</span></label>
                    <input type="number" name="ai_num_questions" id="ai_num_questions" min="1" max="20" value="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                </div>
                <div>
                    <label for="ai_difficulty" class="block text-sm font-medium text-gray-700 mb-1">Difficulty Level</label>
                    <select name="ai_difficulty" id="ai_difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div>
                    <label for="ai_quiz_instructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions (Optional)</label>
                    <textarea name="ai_quiz_instructions" id="ai_quiz_instructions" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAIQuizGeneratorModal()" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-magic mr-1.5"></i>Generate Quiz
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Modal -->
<div id="aiQuizLoadingModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl p-8 flex flex-col items-center gap-4">
        <span class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
            <i class="fas fa-spinner fa-spin text-3xl text-purple-600"></i>
        </span>
        <span class="text-lg font-semibold text-purple-900">Generating quiz with AI...</span>
        <span class="text-sm text-gray-500">This may take a few seconds.</span>
    </div>
</div>

<!-- Failed to Generate Modal -->
<div id="aiQuizFailedModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-xl p-8 flex flex-col items-center gap-4">
        <span class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
        </span>
        <span class="text-lg font-semibold text-red-900">Failed to generate quiz with AI.</span>
        <span class="text-sm text-gray-500">Please try again or adjust your inputs.</span>
        <button type="button" onclick="closeAIQuizFailedModal()" class="mt-4 px-6 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-semibold shadow transition-colors">
            Close
        </button>
    </div>
</div>