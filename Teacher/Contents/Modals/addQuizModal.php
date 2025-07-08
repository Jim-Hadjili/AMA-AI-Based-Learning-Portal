<!-- Add Quiz Modal -->
<div id="addQuizModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="addQuizForm">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Add New Quiz
                            </h3>
                            
                            <!-- Form inputs -->
                            <div class="space-y-4">
                                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                                
                                <div>
                                    <label for="quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title</label>
                                    <input type="text" name="quiz_title" id="quiz_title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                                </div>
                                
                                <div>
                                    <label for="quiz_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="quiz_description" id="quiz_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-1">Time Limit (minutes)</label>
                                        <input type="number" name="time_limit" id="time_limit" min="1" value="30" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    </div>
                                    
                                    <div>
                                        <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-1">Passing Score (%)</label>
                                        <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="70" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date (Optional)</label>
                                        <input type="date" name="due_date" id="due_date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    </div>
                                    
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                You'll be able to add questions after creating the quiz.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-primary text-base font-medium text-white hover:bg-purple-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Create Quiz
                    </button>
                    <button type="button" onclick="closeAddQuizModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Store current class_id in a global variable to use across modals
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const classId = urlParams.get('class_id');
        if (classId) {
            window.currentClassId = classId;
        }
    });

    // Function to open the add quiz modal
    function openAddQuizModal() {
        document.getElementById('addQuizModal').classList.remove('hidden');
    }
    
    // Function to close the add quiz modal
    function closeAddQuizModal() {
        document.getElementById('addQuizModal').classList.add('hidden');
    }
    
    // Make the function available globally
    window.openAddQuizModal = openAddQuizModal;
    
    // Set default due date to 1 week from now
    document.addEventListener('DOMContentLoaded', function() {
        const dueDateInput = document.getElementById('due_date');
        if (dueDateInput) {
            const today = new Date();
            const nextWeek = new Date(today);
            nextWeek.setDate(today.getDate() + 7);
            
            // Format date as YYYY-MM-DD
            const year = nextWeek.getFullYear();
            const month = String(nextWeek.getMonth() + 1).padStart(2, '0');
            const day = String(nextWeek.getDate()).padStart(2, '0');
            
            dueDateInput.value = `${year}-${month}-${day}`;
        }
    });
    
    // Form submission
    document.getElementById('addQuizForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(this);
        
        // Send AJAX request to create quiz
        fetch('../../Controllers/quizController.php?action=createQuiz', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success notification
                if (typeof window.showNotification === 'function') {
                    window.showNotification('Quiz created successfully!', 'success');
                }
                
                // Close first modal
                closeAddQuizModal();
                
                // Store quiz ID and class ID for later use
                window.createdQuizId = data.quiz_id;
                window.currentClassId = window.currentClassId || document.querySelector('input[name="class_id"]').value;
                
                // Open quiz type selection modal instead of redirecting
                setTimeout(() => {
                    openQuizTypeModal();
                }, 500);
            } else {
                // Show error notification
                if (typeof window.showNotification === 'function') {
                    window.showNotification(data.message || 'Failed to create quiz', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Log the error details to the console
            console.log('Error details:', {
                message: error.message,
                stack: error.stack
            });
            
            // Show error notification
            if (typeof window.showNotification === 'function') {
                window.showNotification('An error occurred. Please try again.', 'error');
            }
        });
    });
    
    // Initialize modal behavior with add quiz button
    document.addEventListener('DOMContentLoaded', function() {
        // Only attach to addFirstQuizBtn here since addQuizBtn is handled in allQuizzes.php
        const addFirstQuizBtn = document.getElementById('addFirstQuizBtn');
        if (addFirstQuizBtn) {
            addFirstQuizBtn.addEventListener('click', openAddQuizModal);
        }
    });
    
    /**
     * Get the correct base path for redirections
     * This helps avoid path issues like duplicate "Contents" folder
     */
    function getBasePath() {
        // Check if we're in a development environment (localhost)
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            return '/AMA-AI-Based-Learning-Portal/Teacher';
        }
        
        // For production, get the path relative to domain
        const pathParts = window.location.pathname.split('/');
        const teacherIndex = pathParts.indexOf('Teacher');
        
        if (teacherIndex !== -1) {
            return '/' + pathParts.slice(0, teacherIndex + 1).join('/');
        }
        
        return '';
    }
</script>