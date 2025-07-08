<!-- Questions List -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Questions</h3>
        <button id="addQuestionBtn" class="text-purple-600 hover:text-purple-700">
            <i class="fas fa-plus-circle text-xl"></i>
        </button>
    </div>
    
    <div id="questionsList" class="space-y-2 max-h-96 overflow-y-auto">
        <!-- Questions will be populated by JavaScript -->
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="text-sm text-gray-500">
            <span id="questionCount">0</span> questions
        </div>
    </div>
</div>