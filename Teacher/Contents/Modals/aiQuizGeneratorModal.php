<!-- AI Quiz Generator Modal -->
<!-- filepath: c:\xampp\htdocs\AMA-AI-Based-Learning-Portal\Teacher\Contents\Modals\aiQuizGeneratorModal.php -->
<div id="aiQuizGeneratorModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-0 relative">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h2 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <i class="fas fa-robot text-purple-500"></i>
                AI Quiz Generator
            </h2>
            <button onclick="closeAIQuizGeneratorModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300 text-2xl">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <!-- Form -->
        <form id="aiQuizGeneratorForm" class="px-6 py-6 bg-white">
            <div class="space-y-4">
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                <div>
                    <label for="ai_quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title</label>
                    <input type="text" name="ai_quiz_title" id="ai_quiz_title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label for="ai_quiz_topic" class="block text-sm font-medium text-gray-700 mb-1">Quiz Topic / Objectives</label>
                    <input type="text" name="ai_quiz_topic" id="ai_quiz_topic" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label for="ai_num_questions" class="block text-sm font-medium text-gray-700 mb-1">Number of Questions</label>
                    <input type="number" name="ai_num_questions" id="ai_num_questions" min="1" max="20" value="5" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
                </div>
                <div>
                    <label for="ai_difficulty" class="block text-sm font-medium text-gray-700 mb-1">Difficulty Level</label>
                    <select name="ai_difficulty" id="ai_difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div>
                    <label for="ai_quiz_instructions" class="block text-sm font-medium text-gray-700 mb-1">Instructions (Optional)</label>
                    <textarea name="ai_quiz_instructions" id="ai_quiz_instructions" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="submit" class="bg-purple-primary hover:bg-purple-dark text-white px-6 py-2 rounded-lg font-semibold shadow transition-all">
                    Generate Quiz
                </button>
                <button type="button" onclick="closeAIQuizGeneratorModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold shadow transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Modal -->
<div id="aiQuizLoadingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-xl shadow-xl p-8 flex flex-col items-center gap-4">
        <i class="fas fa-spinner fa-spin text-3xl text-purple-600"></i>
        <span class="text-lg font-semibold text-purple-900">Generating quiz with AI...</span>
        <span class="text-sm text-gray-500">This may take a few seconds.</span>
    </div>
</div>

<!-- Failed to Generate Modal -->
<div id="aiQuizFailedModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-xl shadow-xl p-8 flex flex-col items-center gap-4">
        <i class="fas fa-exclamation-triangle text-3xl text-red-600"></i>
        <span class="text-lg font-semibold text-red-900">Failed to generate quiz with AI.</span>
        <span class="text-sm text-gray-500">Please try again or adjust your inputs.</span>
        <button onclick="closeAIQuizFailedModal()" class="mt-4 bg-red-100 hover:bg-red-200 text-red-700 px-6 py-2 rounded-lg font-semibold shadow transition-all">
            Close
        </button>
    </div>
</div>

<script>
// Show modal when AI Generator button is clicked
document.addEventListener('DOMContentLoaded', function() {
    const aiQuizBtn = document.getElementById('aiQuizBtn');
    if (aiQuizBtn) {
        aiQuizBtn.addEventListener('click', function() {
            document.getElementById('aiQuizGeneratorModal').classList.remove('hidden');
        });
    }
});

// Close modal function
function closeAIQuizGeneratorModal() {
    document.getElementById('aiQuizGeneratorModal').classList.add('hidden');
}

// Show/hide loading modal helpers
function showAIQuizLoadingModal() {
    document.getElementById('aiQuizLoadingModal').classList.remove('hidden');
}
function hideAIQuizLoadingModal() {
    document.getElementById('aiQuizLoadingModal').classList.add('hidden');
}

function showAIQuizFailedModal() {
    document.getElementById('aiQuizFailedModal').classList.remove('hidden');
}
function closeAIQuizFailedModal() {
    document.getElementById('aiQuizFailedModal').classList.add('hidden');
}

// Handle form submission (AJAX to your AI quiz generation endpoint)
document.getElementById('aiQuizGeneratorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    showAIQuizLoadingModal();

    fetch('../../Controllers/aiQuizGeneratorController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        hideAIQuizLoadingModal();
        if (data.success) {
            closeAIQuizGeneratorModal();
            if (typeof window.showNotification === 'function') {
                window.showNotification('AI Quiz generated successfully!', 'success');
            }
            // Redirect to preview page
            window.location.href = `../Quiz/previewQuiz.php?quiz_id=${data.quiz_id}`;
        } else {
            showAIQuizFailedModal();
            if (typeof window.showNotification === 'function') {
                window.showNotification(data.message || 'Failed to generate quiz', 'error');
            }
        }
    })
    .catch(() => {
        hideAIQuizLoadingModal();
        showAIQuizFailedModal();
        if (typeof window.showNotification === 'function') {
            window.showNotification('An error occurred. Please try again.', 'error');
        }
    });
});
</script>