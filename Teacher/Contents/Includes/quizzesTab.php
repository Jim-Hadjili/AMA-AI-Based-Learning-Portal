<?php
// Fetch quizzes for the current class
$quizzes = [];
if (isset($class_id)) {
    $stmt = $conn->prepare("
        SELECT 
            q.*,
            COUNT(qq.question_id) as question_count,
            COUNT(DISTINCT qa.st_id) as attempt_count,
            AVG(qa.score) as avg_score
        FROM quizzes_tb q 
        LEFT JOIN quiz_questions_tb qq ON q.quiz_id = qq.quiz_id 
        LEFT JOIN quiz_attempts_tb qa ON q.quiz_id = qa.quiz_id AND qa.status = 'completed'
        WHERE q.class_id = ? AND q.th_id = ?
        GROUP BY q.quiz_id 
        ORDER BY q.created_at DESC
    ");
    $stmt->bind_param("is", $class_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $quizzes = $result->fetch_all(MYSQLI_ASSOC);
}

// Limit to 6 quizzes for initial display
$displayQuizzes = array_slice($quizzes, 0, 6);
$hasMoreQuizzes = count($quizzes) > 6;

// Helper function to get status badge styling
function getStatusBadge($status) {
    switch($status) {
        case 'published':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'archived':
            return 'bg-gray-100 text-gray-800 border-gray-200';
        default:
            return 'bg-gray-100 text-gray-800 border-gray-200';
    }
}

// Helper function to format time limit
function formatTimeLimit($minutes) {
    if ($minutes == 0) return 'No limit';
    if ($minutes < 60) return $minutes . ' min';
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
}
?>

<!-- Quizzes Tab -->
<div id="quizzes-tab" class="tab-content p-6">
    <?php if (empty($quizzes)): ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-20 h-20 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                <i class="fas fa-clipboard-question text-3xl text-blue-500"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">No Quizzes Yet</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                Start engaging your students by creating your first quiz. You can add questions manually or use AI to generate them automatically.
            </p>
            
            <button id="addQuizTabBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center mx-auto justify-center shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                <span>Create Your First Quiz</span>
            </button>
        </div>
    <?php else: ?>
        <!-- Header with Stats and Actions -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Recent Quizzes</h3>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <span class="flex items-center">
                            <i class="fas fa-clipboard-list mr-2 text-blue-500"></i>
                            <?php echo count($quizzes); ?> Total Quiz<?php echo count($quizzes) != 1 ? 'zes' : ''; ?>
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                            <?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'published'; })); ?> Published
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-edit mr-2 text-yellow-500"></i>
                            <?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'draft'; })); ?> Draft<?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'draft'; })) != 1 ? 's' : ''; ?>
                        </span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Create Quiz Button -->
                    <button id="addQuizTabBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add Quiz</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Quiz Cards Grid (Limited to 6) -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
            <?php foreach ($displayQuizzes as $quiz): ?>
                <div class="quiz-card bg-white rounded-lg border border-gray-400 shadow-sm hover:shadow-md transition-all duration-200 hover:border-blue-200">
                    
                    <!-- Card Header -->
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                </h4>
                                <?php if (!empty($quiz['quiz_topic'])): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fas fa-tag mr-1"></i>
                                        <?php echo htmlspecialchars($quiz['quiz_topic']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border <?php echo getStatusBadge($quiz['status']); ?>">
                                <?php if ($quiz['status'] === 'published'): ?>
                                    <i class="fas fa-globe mr-1"></i>
                                <?php elseif ($quiz['status'] === 'draft'): ?>
                                    <i class="fas fa-edit mr-1"></i>
                                <?php else: ?>
                                    <i class="fas fa-archive mr-1"></i>
                                <?php endif; ?>
                                <?php echo ucfirst($quiz['status']); ?>
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <?php if (!empty($quiz['quiz_description'])): ?>
                            <p class="text-sm text-gray-600 line-clamp-1 mb-1">
                                <?php echo htmlspecialchars($quiz['quiz_description']); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Card Body - Stats -->
                    <div class="p-5">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Questions Count -->
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-gray-900 mb-1">
                                    <?php echo $quiz['question_count']; ?>
                                </div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">
                                    Question<?php echo $quiz['question_count'] != 1 ? 's' : ''; ?>
                                </div>
                            </div>
                            
                            <!-- Attempts Count -->
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-gray-900 mb-1">
                                    <?php echo $quiz['attempt_count']; ?>
                                </div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide">
                                    Attempt<?php echo $quiz['attempt_count'] != 1 ? 's' : ''; ?>
                                </div>
                            </div>
                        </div>

                        
                    </div>

                    <!-- Card Footer - Actions -->
                    <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <!-- View/Edit Button -->
                                <a href="../Quiz/editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 focus:ring-2 focus:ring-blue-500 transition-colors">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                
                                <!-- View Results Button -->
                                <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                                    <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Results
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <!-- More Actions Dropdown -->
                            <div class="relative">
                                <button class="quiz-menu-btn inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md transition-colors" 
                                        data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="quiz-menu hidden absolute right-0 bottom-full mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                    <div class="py-1">
                                        <?php if ($quiz['status'] === 'draft'): ?>
                                            <button class="publish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                    data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                                <i class="fas fa-paper-plane mr-2 text-green-500"></i>
                                                Publish Quiz
                                            </button>
                                        <?php elseif ($quiz['status'] === 'published'): ?>
                                            <button class="unpublish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                    data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                                <i class="fas fa-pause mr-2 text-yellow-500"></i>
                                                Unpublish
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="duplicate-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                            <i class="fas fa-copy mr-2 text-blue-500"></i>
                                            Duplicate
                                        </button>
                                        
                                        <a href="../Quiz/previewQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                            <i class="fas fa-eye mr-2 text-purple-500"></i>
                                            Preview
                                        </a>
                                        
                                        <div class="border-t border-gray-100 my-1"></div>
                                        
                                        <button class="delete-quiz-btn w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>" 
                                                data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                                            <i class="fas fa-trash mr-2"></i>
                                            Delete Quiz
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Button (Show only if there are more than 6 quizzes) -->
        <?php if ($hasMoreQuizzes): ?>
            <div class="text-center py-6 border-t border-gray-200">
                <a href="../Quiz/allQuizzes.php?class_id=<?php echo $class_id; ?>" 
                   class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-th-large mr-2"></i>
                    View All <?php echo count($quizzes); ?> Quizzes
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Custom Styles -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.quiz-card {
    transition: all 0.2s ease;
}

.quiz-card:hover {
    transform: translateY(-2px);
}

.quiz-menu {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
</style>

<!-- JavaScript for Interactive Features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quiz menu toggles
    document.querySelectorAll('.quiz-menu-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            
            // Close all other menus
            document.querySelectorAll('.quiz-menu').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            
            // Toggle current menu
            menu.classList.toggle('hidden');
        });
    });

    // Close menus when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.quiz-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Quiz action handlers
    document.querySelectorAll('.delete-quiz-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const quizId = this.dataset.quizId;
            const quizTitle = this.dataset.quizTitle;
            
            if (confirm(`Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`)) {
                // Add your delete quiz logic here
                console.log('Delete quiz:', quizId);
            }
        });
    });

    document.querySelectorAll('.publish-quiz-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const quizId = this.dataset.quizId;
            // Add your publish quiz logic here
            console.log('Publish quiz:', quizId);
        });
    });

    document.querySelectorAll('.duplicate-quiz-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const quizId = this.dataset.quizId;
            // Add your duplicate quiz logic here
            console.log('Duplicate quiz:', quizId);
        });
    });
    
    // Add event listener for the Add Quiz button in the quizzes tab
    const addQuizTabBtn = document.getElementById('addQuizTabBtn');
    if (addQuizTabBtn) {
        addQuizTabBtn.addEventListener('click', function() {
            // Call the global openAddQuizModal function
            if (typeof window.openAddQuizModal === 'function') {
                window.openAddQuizModal();
            } else {
                // Fallback if the function isn't available
                document.getElementById('addQuizModal').classList.remove('hidden');
            }
        });
    }
});
</script>