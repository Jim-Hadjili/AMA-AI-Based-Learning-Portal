<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Include required files
include_once '../../Functions/userInfo.php';

// Check if quiz_id is provided
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$quiz_id = intval($_GET['quiz_id']);
$teacher_id = $_SESSION['user_id'];

// Fetch quiz data
$quizSql = "SELECT q.*, c.class_name, c.class_id 
           FROM quizzes_tb q
           JOIN teacher_classes_tb c ON q.class_id = c.class_id
           WHERE q.quiz_id = ? AND c.th_id = ?";
$quizStmt = $conn->prepare($quizSql);
$quizStmt->bind_param("is", $quiz_id, $teacher_id);
$quizStmt->execute();
$quizResult = $quizStmt->get_result();

// If quiz not found or doesn't belong to this teacher, redirect
if ($quizResult->num_rows === 0) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$quiz = $quizResult->fetch_assoc();

// Fetch quiz questions
$questionsSql = "SELECT qq.*, 
                (SELECT COUNT(*) FROM question_options_tb qo WHERE qo.question_id = qq.question_id) AS option_count
                FROM quiz_questions_tb qq 
                WHERE qq.quiz_id = ? 
                ORDER BY qq.question_order";
$questionsStmt = $conn->prepare($questionsSql);
$questionsStmt->bind_param("i", $quiz_id);
$questionsStmt->execute();
$questionsResult = $questionsStmt->get_result();
$questions = [];

while ($question = $questionsResult->fetch_assoc()) {
    // Fetch options for each question if it's multiple choice or checkboxes
    if ($question['question_type'] === 'multiple_choice' || $question['question_type'] === 'checkbox') {
        $optionsSql = "SELECT * FROM question_options_tb WHERE question_id = ? ORDER BY option_order";
        $optionsStmt = $conn->prepare($optionsSql);
        $optionsStmt->bind_param("i", $question['question_id']);
        $optionsStmt->execute();
        $optionsResult = $optionsStmt->get_result();
        $options = [];
        
        while ($option = $optionsResult->fetch_assoc()) {
            $options[] = $option;
        }
        
        $question['options'] = $options;
    }
    
    $questions[] = $question;
}

// Calculate total points - fix the field name
$totalPoints = 0;
foreach ($questions as $question) {
    $totalPoints += $question['question_points']; // Changed from 'points' to 'question_points'
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: <?php echo htmlspecialchars($quiz['quiz_title']); ?> - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
    <style>
        .quiz-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .quiz-card:hover {
            transform: translateY(-2px);
        }
        .option-hover:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }
        .quiz-container {
            max-width: 800px;
        }
        .shadow-soft {
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 py-8 quiz-container">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-soft rounded-lg px-6 py-4 mb-8 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <a href="../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
                   class="text-blue-600 hover:text-blue-800 flex items-center group">
                    <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-medium"><?php echo htmlspecialchars($quiz['class_name']); ?></span>
                </a>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">Preview Mode</span>
                <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Quiz
                </a>
            </div>
        </nav>

        <!-- Quiz Header -->
        <div class="bg-white rounded-lg shadow-soft p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
            <p class="text-gray-600"><?php echo htmlspecialchars($quiz['quiz_description'] ?? ''); ?></p>
            
            <div class="flex flex-wrap items-center mt-4 pt-4 border-t border-gray-100 text-sm">
                <div class="flex items-center mr-6 mb-2">
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-2">
                        <i class="fas fa-clock text-blue-500"></i>
                    </div>
                    <span>
                        <span class="font-medium"><?php echo $quiz['time_limit'] ? $quiz['time_limit'].' minutes' : 'No time limit'; ?></span>
                    </span>
                </div>
                
                <div class="flex items-center mr-6 mb-2">
                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center mr-2">
                        <i class="fas fa-question text-green-500"></i>
                    </div>
                    <span>
                        <span class="font-medium"><?php echo count($questions); ?></span> Questions
                    </span>
                </div>
                
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center mr-2">
                        <i class="fas fa-star text-purple-500"></i>
                    </div>
                    <span>
                        <span class="font-medium"><?php echo $totalPoints; ?></span> Points
                    </span>
                </div>
            </div>
        </div>

        <!-- Quiz Content Preview -->
        <div class="bg-white rounded-lg shadow-soft mb-6">
            <!-- Quiz Instructions -->
            <div class="border-b border-gray-100 p-6">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 rounded-full bg-yellow-50 flex items-center justify-center mr-2">
                        <i class="fas fa-info-circle text-yellow-500"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Instructions</h2>
                </div>
                <p class="text-gray-600 pl-10">
                    <?php if (!empty($quiz['instructions'])): ?>
                        <?php echo htmlspecialchars($quiz['instructions']); ?>
                    <?php else: ?>
                        Complete all questions to the best of your ability.
                        <?php if ($quiz['time_limit']): ?>
                            You have <?php echo $quiz['time_limit']; ?> minutes to complete this quiz.
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Questions -->
            <div class="p-6">
                <?php if (empty($questions)): ?>
                    <!-- Empty state for no questions -->
                    <div class="text-center py-10">
                        <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-question-circle text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-800 mb-3">No Questions Added</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            This quiz doesn't have any questions yet. Add questions to complete your quiz setup.
                        </p>
                        <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>&section=questions" 
                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Add Questions
                        </a>
                    </div>
                <?php else: ?>
                    <form id="quiz-preview-form" class="space-y-8">
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="quiz-card bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
                                <!-- Question Header -->
                                <div class="bg-gray-50 px-6 py-3 border-b border-gray-100 flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 font-semibold text-blue-600">
                                            <?php echo $index + 1; ?>
                                        </div>
                                        <span class="text-sm text-gray-500">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></span>
                                    </div>
                                    <div>
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm font-medium rounded-full">
                                            <?php echo $question['question_points']; ?> <?php echo $question['question_points'] == 1 ? 'point' : 'points'; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Question Content -->
                                <div class="p-6">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4"><?php echo htmlspecialchars($question['question_text']); ?></h3>
                                    
                                    <?php if (!empty($question['question_image'])): ?>
                                        <div class="mb-6">
                                            <img src="../../../Assets/Images/quiz/<?php echo $question['question_image']; ?>" 
                                                alt="Question image" 
                                                class="max-w-full h-auto rounded-lg border border-gray-100 shadow-sm">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Answer Options -->
                                    <div class="mt-5">
                                        <?php switch ($question['question_type']): 
                                            case 'multiple_choice': ?>
                                                <!-- Multiple Choice -->
                                                <div class="space-y-3">
                                                    <?php foreach ($question['options'] as $option): ?>
                                                        <div class="flex items-center p-3 rounded-lg option-hover">
                                                            <input type="radio" 
                                                                name="question_<?php echo $question['question_id']; ?>" 
                                                                id="option_<?php echo $option['option_id']; ?>" 
                                                                value="<?php echo $option['option_id']; ?>" 
                                                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                            <label for="option_<?php echo $option['option_id']; ?>" class="ml-3 block text-gray-700 w-full cursor-pointer">
                                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php break; ?>
                                                
                                            <?php case 'checkbox': ?>
                                                <!-- Checkbox -->
                                                <div class="space-y-3">
                                                    <?php foreach ($question['options'] as $option): ?>
                                                        <div class="flex items-center p-3 rounded-lg option-hover">
                                                            <input type="checkbox" 
                                                                name="question_<?php echo $question['question_id']; ?>[]" 
                                                                id="option_<?php echo $option['option_id']; ?>" 
                                                                value="<?php echo $option['option_id']; ?>" 
                                                                class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                            <label for="option_<?php echo $option['option_id']; ?>" class="ml-3 block text-gray-700 w-full cursor-pointer">
                                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php break; ?>
                                                
                                            <?php case 'short_answer': ?>
                                                <!-- Short Answer -->
                                                <div class="mt-2">
                                                    <textarea name="question_<?php echo $question['question_id']; ?>" 
                                                        rows="3" 
                                                        placeholder="Type your answer here..." 
                                                        class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm py-3 px-4 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                                                </div>
                                                <?php break; ?>
                                                
                                            <?php case 'true_false': ?>
                                                <!-- True/False -->
                                                <div class="grid grid-cols-2 gap-4 mt-2">
                                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg option-hover">
                                                        <input type="radio" 
                                                            name="question_<?php echo $question['question_id']; ?>" 
                                                            id="true_<?php echo $question['question_id']; ?>" 
                                                            value="true" 
                                                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                        <label for="true_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">True</label>
                                                    </div>
                                                    <div class="flex items-center p-4 border border-gray-200 rounded-lg option-hover">
                                                        <input type="radio" 
                                                            name="question_<?php echo $question['question_id']; ?>" 
                                                            id="false_<?php echo $question['question_id']; ?>" 
                                                            value="false" 
                                                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                        <label for="false_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700 font-medium w-full cursor-pointer">False</label>
                                                    </div>
                                                </div>
                                                <?php break; ?>
                                            
                                            <?php default: ?>
                                                <p class="text-gray-500 italic">Preview not available for this question type.</p>
                                        <?php endswitch; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Quiz Footer -->
                        <div class="bg-white rounded-lg shadow-soft p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                    </div>
                                    <p class="text-gray-600">
                                        This is a preview mode. Answers are not saved.
                                    </p>
                                </div>
                                <button type="submit" disabled class="w-full sm:w-auto px-6 py-3 bg-gray-500 text-white rounded-lg cursor-not-allowed opacity-75">
                                    Submit Quiz (Preview Only)
                                </button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back to Quiz List Button -->
        <div class="mt-8 text-center">
            <a href="../Quiz/allQuizzes.php?class_id=<?php echo $quiz['class_id']; ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 hover:underline">
                <i class="fas fa-list-ul mr-2"></i>
                View All Quizzes
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent form submission
        const form = document.getElementById('quiz-preview-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('This is a preview. Quiz submission is disabled.');
            });
        }
        
        // Add subtle animation when scrolling to questions
        const questions = document.querySelectorAll('.quiz-card');
        if (questions.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100');
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                    }
                });
            }, { threshold: 0.1 });
            
            questions.forEach(question => {
                question.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-500');
                observer.observe(question);
            });
        }
    });
    </script>
</body>
</html>