<div id="noQuestionsWarningModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" id="noQuestionsWarningModalBackdrop"></div>
        
        <!-- Modal content -->
        <div class="bg-white rounded-lg max-w-md w-full z-50 relative shadow-xl">
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-semibold text-center mb-2">Cannot Publish Quiz</h3>
                
                <p class="text-gray-600 text-center mb-6">
                    This quiz cannot be published because it has no questions. Please add at least one question before publishing.
                </p>
                
                <div class="flex justify-center space-x-4">
                    <button type="button" id="closeWarningBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-all duration-200">
                        Close
                    </button>
                    
                    <a id="addQuestionsBtn" href="#" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200 inline-flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add Questions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>