<div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 flex-1 min-w-[350px] max-w-[550px] flex flex-col h-[600px]">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <i class="fas fa-question-circle text-blue-500"></i> Questions
        </h3>
        <button id="addQuestionBtn" class="text-purple-600 hover:text-purple-700">
            <i class="fas fa-plus-circle text-xl"></i>
        </button>
    </div>
    <div id="questionsList" class="space-y-2 overflow-y-auto flex-grow">
        <!-- Questions will be populated here -->
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200 text-sm text-gray-500">
        <span id="questionCount">0</span> questions
    </div>
</div>