<!-- Quiz Type Selection Modal -->
<div id="quizTypeModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-xl w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Create Quiz
                        </h3>
                        
                        <p class="text-sm text-gray-500 mb-6">
                            Create your quiz by adding questions manually.
                        </p>
                        
                        <div class="flex justify-center">
                            <!-- Manual Quiz Creation -->
                            <div class="quiz-type-card border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow cursor-pointer" data-quiz-type="manual">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-pencil-alt text-purple-600 text-xl"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2">Manual Creation</h4>
                                    <p class="text-sm text-gray-500">Create questions manually with multiple question types.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeQuizTypeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to open the quiz type modal
    function openQuizTypeModal() {
        document.getElementById('quizTypeModal').classList.remove('hidden');
    }
    
    // Function to close the quiz type modal
    function closeQuizTypeModal() {
        document.getElementById('quizTypeModal').classList.add('hidden');
    }
    
    // Make functions available globally
    window.openQuizTypeModal = openQuizTypeModal;
    window.closeQuizTypeModal = closeQuizTypeModal;
    
    // Add event listeners to quiz type cards
    document.addEventListener('DOMContentLoaded', function() {
        const quizTypeCards = document.querySelectorAll('.quiz-type-card');
        
        quizTypeCards.forEach(card => {
            card.addEventListener('click', function() {
                const quizType = this.getAttribute('data-quiz-type');
                const quizId = window.createdQuizId;
                
                if (!quizId) {
                    window.showNotification('Quiz ID not found. Please try again.', 'error');
                    return;
                }
                
                // Close the quiz type modal
                closeQuizTypeModal();
                
                // Since we only have manual option, directly open the quiz questions modal
                openQuizQuestionsModal(quizId, 'manual');
            });
        });
    });
    
    // Function to open the quiz questions modal
    function openQuizQuestionsModal(quizId, mode) {
        // Store quiz mode
        window.quizCreationMode = mode;
        
        // Open the questions modal
        if (document.getElementById('quizQuestionsModal')) {
            document.getElementById('quizQuestionsModal').classList.remove('hidden');
            // Initialize question interface based on mode
            initializeQuestionInterface(quizId, mode);
        } else {
            // If modal doesn't exist yet, redirect to editor
            window.location.href = `../Quiz/quizEditor.php?quiz_id=${quizId}&mode=${mode}`;
        }
    }
</script>