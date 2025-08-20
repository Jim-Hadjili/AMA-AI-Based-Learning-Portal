<!-- Updated Quiz Empty State Component -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
    <div class="text-center py-16 px-6">
        <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Quizzes Created Yet</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">Create engaging quizzes to assess your students' understanding and track their progress.</p>
        
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button id="addQuizTabBtn" class="inline-flex items-center px-6 py-3 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create First Quiz
            </button>
            <button id="aiQuizBtn" class="inline-flex items-center px-6 py-3 border border-purple-300 text-sm font-medium rounded-lg text-purple-700 bg-purple-50 hover:bg-purple-100 hover:border-purple-400 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                AI Quiz Generator
            </button>
        </div>
    </div>
</div>