<!-- Add Quiz Modal -->
<div id="addQuizModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h3 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-file-alt text-purple-600"></i>
                </span>
                Add New Quiz
            </h3>
            <button type="button" onclick="closeAddQuizModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="addQuizForm" class="px-6 py-6 bg-white">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <div class="space-y-4">
                <div>
                    <label for="quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title<span class="text-red-500">*</span></label>
                    <input type="text" name="quiz_title" id="quiz_title" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                </div>
                <div>
                    <label for="quiz_description" class="block text-sm font-medium text-gray-700 mb-1">Instructions</label>
                    <textarea name="quiz_description" id="quiz_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-1">Time Limit (minutes)</label>
                        <input type="number" name="time_limit" id="time_limit" min="1" value="30" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-1">Passing Score (%)</label>
                        <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="70" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date (Optional)</label>
                        <input type="date" name="due_date" id="due_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                <div class="hidden">
                    <label for="allow_retakes" class="block text-sm font-medium text-gray-700 mb-1">Allow Retake</label>
                    <select name="allow_retakes" id="allow_retakes" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="1" selected>Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    <p class="text-sm text-yellow-700">
                        You'll be able to add questions after creating the quiz.
                    </p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAddQuizModal()" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-plus mr-1.5"></i>Create Quiz
                </button>
            </div>
        </form>
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
    
    // Initialize modal behavior with all potential add quiz buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Connect all the possible "add quiz" buttons
        const addFirstQuizBtn = document.getElementById('addFirstQuizBtn');
        const addQuizTabBtn = document.getElementById('addQuizTabBtn');
        const addQuizBtn = document.getElementById('addQuizBtn');
        
        if (addFirstQuizBtn) {
            addFirstQuizBtn.addEventListener('click', openAddQuizModal);
        }
        
        if (addQuizTabBtn) {
            addQuizTabBtn.addEventListener('click', openAddQuizModal);
        }
        
        if (addQuizBtn) {
            addQuizBtn.addEventListener('click', openAddQuizModal);
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