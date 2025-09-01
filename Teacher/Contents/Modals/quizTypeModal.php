<!-- Quiz Type Selection Modal -->
<div id="quizTypeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h3 class="text-2xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-tasks text-purple-600"></i>
                </span>
                Select Quiz Creation Type
            </h3>
            <button type="button" onclick="closeQuizTypeModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Modal Content -->
        <div class="px-8 py-8 bg-white rounded-b-2xl">
            <p class="text-sm text-gray-500 mb-6 text-center">
                Choose how you want to create your quiz.
            </p>
            <div class="flex justify-center">
                <!-- Manual Quiz Creation -->
                <div class="quiz-type-card border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow cursor-pointer bg-white w-72" data-quiz-type="manual">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-pencil-alt text-purple-600 text-2xl"></i>
                        </div>
                        <h4 class="font-medium text-gray-900 mb-2">Manual Creation</h4>
                        <p class="text-sm text-gray-500">Create questions manually with multiple question types.</p>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-3">
                <button type="button" onclick="closeQuizTypeModal()" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
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