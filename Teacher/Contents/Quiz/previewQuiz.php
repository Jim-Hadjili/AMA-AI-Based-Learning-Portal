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
</head>

<body class="bg-gray-100 min-h-screen">


    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Quiz Preview Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 mb-1">
                    <a href="../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" class="text-blue-600 hover:underline flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to <?php echo htmlspecialchars($quiz['class_name']); ?>
                    </a>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Preview: <?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                <p class="text-gray-600 mt-1">This is how students will see your quiz.</p>
            </div>
            <div>
                <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Quiz
                </a>
            </div>
        </div>

        <!-- Quiz Info Panel -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Duration</h3>
                    <p class="text-lg font-semibold"><?php echo $quiz['time_limit'] ? $quiz['time_limit'].' minutes' : 'No time limit'; ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Questions</h3>
                    <p class="text-lg font-semibold"><?php echo count($questions); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total Points</h3>
                    <p class="text-lg font-semibold"><?php echo $totalPoints; ?> points</p>
                </div>
            </div>
            
            <?php if (!empty($quiz['quiz_description'])): ?>
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                    <div class="prose max-w-none text-gray-700">
                        <?php echo htmlspecialchars($quiz['quiz_description']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quiz Content Preview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Quiz Instructions -->
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800">Instructions</h2>
                <p class="text-gray-600 mt-2">
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
                    <div class="text-center py-8">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-exclamation-circle text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 mb-2">No Questions Added</h3>
                        <p class="text-gray-600 mb-4">This quiz doesn't have any questions yet.</p>
                        <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>&section=questions" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Add Questions
                        </a>
                    </div>
                <?php else: ?>
                    <form id="quiz-preview-form" class="space-y-8">
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="quiz-question p-6 border border-gray-200 rounded-lg">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></p>
                                        <h3 class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($question['question_text']); ?></h3>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 text-sm font-medium rounded-full">
                                            <?php echo $question['question_points']; ?> <?php echo $question['question_points'] == 1 ? 'point' : 'points'; ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <?php if (!empty($question['question_image'])): ?>
                                    <div class="mb-4">
                                        <img src="../../../Assets/Images/quiz/<?php echo $question['question_image']; ?>" 
                                            alt="Question image" 
                                            class="max-w-full h-auto rounded-md border border-gray-200">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-4">
                                    <?php switch ($question['question_type']): 
                                        case 'multiple_choice': ?>
                                            <!-- Multiple Choice -->
                                            <div class="space-y-2">
                                                <?php foreach ($question['options'] as $option): ?>
                                                    <div class="flex items-center">
                                                        <input type="radio" 
                                                            name="question_<?php echo $question['question_id']; ?>" 
                                                            id="option_<?php echo $option['option_id']; ?>" 
                                                            value="<?php echo $option['option_id']; ?>" 
                                                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                        <label for="option_<?php echo $option['option_id']; ?>" class="ml-3 block text-gray-700">
                                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'checkbox': ?>
                                            <!-- Checkbox -->
                                            <div class="space-y-2">
                                                <?php foreach ($question['options'] as $option): ?>
                                                    <div class="flex items-center">
                                                        <input type="checkbox" 
                                                            name="question_<?php echo $question['question_id']; ?>[]" 
                                                            id="option_<?php echo $option['option_id']; ?>" 
                                                            value="<?php echo $option['option_id']; ?>" 
                                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                        <label for="option_<?php echo $option['option_id']; ?>" class="ml-3 block text-gray-700">
                                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'short_answer': ?>
                                            <!-- Short Answer -->
                                            <div>
                                                <textarea name="question_<?php echo $question['question_id']; ?>" 
                                                    rows="3" 
                                                    placeholder="Type your answer here..." 
                                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            </div>
                                            <?php break; ?>
                                            
                                        <?php case 'true_false': ?>
                                            <!-- True/False -->
                                            <div class="space-y-2">
                                                <div class="flex items-center">
                                                    <input type="radio" 
                                                        name="question_<?php echo $question['question_id']; ?>" 
                                                        id="true_<?php echo $question['question_id']; ?>" 
                                                        value="true" 
                                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="true_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700">True</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="radio" 
                                                        name="question_<?php echo $question['question_id']; ?>" 
                                                        id="false_<?php echo $question['question_id']; ?>" 
                                                        value="false" 
                                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                    <label for="false_<?php echo $question['question_id']; ?>" class="ml-3 block text-gray-700">False</label>
                                                </div>
                                            </div>
                                            <?php break; ?>
                                        
                                        <?php default: ?>
                                            <p class="text-gray-500 italic">Preview not available for this question type.</p>
                                    <?php endswitch; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <div>
                                <p class="text-gray-600 text-sm">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    This is a preview mode. Answers are not saved.
                                </p>
                            </div>
                            <div>
                                <button type="submit" disabled class="px-6 py-2.5 bg-gray-500 text-white rounded-md cursor-not-allowed">
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
            <a href="../Quiz/allQuizzes.php?class_id=<?php echo $quiz['class_id']; ?>" class="text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to All Quizzes
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // This is just to prevent the form from being submitted
        const form = document.getElementById('quiz-preview-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('This is a preview. Quiz submission is disabled.');
            });
        }
    });
    </script>
</body>
</html>