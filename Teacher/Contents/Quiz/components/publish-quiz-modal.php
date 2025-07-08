<div id="publishQuizModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" id="publishQuizModalBackdrop"></div>
        
        <!-- Modal content -->
        <div class="bg-white rounded-lg max-w-md w-full z-50 relative shadow-xl">
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-paper-plane text-green-500 text-2xl"></i>
                    </div>
                </div>
                
                <h3 class="text-xl font-semibold text-center mb-2">Publish Quiz</h3>
                
                <p class="text-gray-600 text-center mb-6" id="publishQuizMessage">
                    Are you sure you want to publish this quiz? Students will be able to see and take this quiz.
                </p>
                
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelPublishQuizBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-all duration-200">
                        Cancel
                    </button>
                    
                    <button type="button" id="confirmPublishQuizBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-all duration-200">
                        Yes, Publish Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>