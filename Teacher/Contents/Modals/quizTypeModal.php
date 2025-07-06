<!-- Quiz Type Selection Modal -->
<div id="quizTypeModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle max-w-3xl w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Select Quiz Type
                        </h3>
                        
                        <p class="text-sm text-gray-500 mb-6">
                            Choose how you'd like to create your quiz. You can create a quiz manually, generate it with AI, or import questions from a file.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                            
                            <!-- AI Generated Quiz -->
                            <div class="quiz-type-card border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow cursor-pointer" data-quiz-type="ai">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-robot text-blue-600 text-xl"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2">AI Generated</h4>
                                    <p class="text-sm text-gray-500">Let AI generate questions based on your topic or learning materials.</p>
                                </div>
                            </div>
                            
                            <!-- Import Quiz -->
                            <div class="quiz-type-card border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow cursor-pointer" data-quiz-type="import">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-file-import text-green-600 text-xl"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2">Import Questions</h4>
                                    <p class="text-sm text-gray-500">Import questions from CSV, Excel, or Word document.</p>
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
                
                // Handle different quiz types
                switch(quizType) {
                    case 'manual':
                        // Open the quiz editor for manual creation
                        openQuizQuestionsModal(quizId, 'manual');
                        break;
                    case 'ai':
                        // Open the AI generation modal
                        openAiQuizGenerationModal(quizId);
                        break;
                    case 'import':
                        // Open the import quiz modal
                        openImportQuizModal(quizId);
                        break;
                    default:
                        // Redirect to the quiz editor as fallback
                        window.location.href = `../../Quiz/quizEditor.php?quiz_id=${quizId}`;
                }
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
    
    // Function to open the AI quiz generation modal
    function openAiQuizGenerationModal(quizId) {
        // Get the class ID
        const classId = window.currentClassId;
        
        // Redirect to AI generator with both quiz_id and class_id parameters
        window.location.href = `../../Quiz/aiQuizGenerator.php?quiz_id=${quizId}&class_id=${classId}`;
    }
    
    // Function to open the import quiz modal
    function openImportQuizModal(quizId) {
        // Get the class ID
        const classId = window.currentClassId;
        
        // Redirect to import page with both quiz_id and class_id parameters
        window.location.href = `../../Quiz/importQuiz.php?quiz_id=${quizId}&class_id=${classId}`;
    }
</script>