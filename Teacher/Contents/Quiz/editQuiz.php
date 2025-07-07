<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';  // This line was incomplete

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Check if quiz_id is provided
if (!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$quiz_id = intval($_GET['quiz_id']);
$teacher_id = $_SESSION['user_id'];

// Get quiz details with verification that it belongs to current teacher
$quizQuery = "SELECT q.*, tc.class_name, tc.class_code 
              FROM quizzes_tb q 
              JOIN teacher_classes_tb tc ON q.class_id = tc.class_id 
              WHERE q.quiz_id = ? AND q.th_id = ?";

$stmt = $conn->prepare($quizQuery);
$stmt->bind_param("is", $quiz_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$quiz = $result->fetch_assoc();

// Get existing questions and options
$questionsQuery = "SELECT qq.*, 
                   GROUP_CONCAT(
                       CONCAT(qo.option_id, ':', qo.option_text, ':', qo.is_correct, ':', qo.option_order) 
                       ORDER BY qo.option_order SEPARATOR '|'
                   ) as options,
                   sa.correct_answer, sa.case_sensitive
                   FROM quiz_questions_tb qq 
                   LEFT JOIN question_options_tb qo ON qq.question_id = qo.question_id 
                   LEFT JOIN short_answer_tb sa ON qq.question_id = sa.question_id
                   WHERE qq.quiz_id = ? 
                   GROUP BY qq.question_id 
                   ORDER BY qq.question_order";

$stmt = $conn->prepare($questionsQuery);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questionsResult = $stmt->get_result();
$questions = $questionsResult->fetch_all(MYSQLI_ASSOC);

// Process questions data for JavaScript
$processedQuestions = [];
foreach ($questions as $question) {
    $processedQuestion = [
        'id' => 'question_' . $question['question_id'],
        'question_id' => $question['question_id'],
        'type' => $question['question_type'],
        'text' => $question['question_text'],
        'points' => $question['question_points'],
        'order' => $question['question_order'],
        'options' => []
    ];
    
    if ($question['question_type'] === 'short-answer') {
        $processedQuestion['correctAnswer'] = $question['correct_answer'] ?? '';
        $processedQuestion['caseSensitive'] = $question['case_sensitive'] == 1;
    } else if (!empty($question['options'])) {
        $optionsData = explode('|', $question['options']);
        foreach ($optionsData as $optionData) {
            $parts = explode(':', $optionData);
            if (count($parts) >= 4) {
                $processedQuestion['options'][] = [
                    'option_id' => $parts[0],
                    'text' => $parts[1],
                    'isCorrect' => $parts[2] == 1,
                    'order' => $parts[3]
                ];
            }
        }
    }
    
    $processedQuestions[] = $processedQuestion;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?> - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .question-editor {
            min-height: 400px;
        }
        
        .question-list-item.active {
            background-color: #f3f4f6;
            border-left: 4px solid #8b5cf6;
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            padding: 16px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateX(400px);
            transition: transform 0.3s ease-in-out;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success { background-color: #10b981; }
        .notification.error { background-color: #ef4444; }
        .notification.warning { background-color: #f59e0b; }
        .notification.info { background-color: #3b82f6; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Notification Container -->
    <div id="notification-container"></div>

    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="../Contents/Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
                       class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Class
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">
                            Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                        </h1>
                        <p class="text-sm text-gray-500">
                            <?php echo htmlspecialchars($quiz['class_name']); ?> • <?php echo htmlspecialchars($quiz['class_code']); ?>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button id="previewQuizBtn" class="px-4 py-2 text-purple-600 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Preview
                    </button>
                    <button id="saveQuizBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Left Sidebar - Quiz Settings & Question List -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quiz Settings Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quiz Settings</h3>
                    
                    <form id="quizSettingsForm" class="space-y-4">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                        
                        <div>
                            <label for="quiz_title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" id="quiz_title" name="quiz_title" 
                                   value="<?php echo htmlspecialchars($quiz['quiz_title']); ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="quiz_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="quiz_description" name="quiz_description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?php echo htmlspecialchars($quiz['quiz_description'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-1">Time (min)</label>
                                <input type="number" id="time_limit" name="time_limit" min="1" 
                                       value="<?php echo $quiz['time_limit']; ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="status" name="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="draft" <?php echo $quiz['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    <option value="published" <?php echo $quiz['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                    <option value="archived" <?php echo $quiz['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" id="shuffle_questions" name="shuffle_questions" 
                                       <?php echo $quiz['shuffle_questions'] ? 'checked' : ''; ?>
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-gray-700">Shuffle Questions</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center space-x-4 text-sm">
                            <label class="flex items-center">
                                <input type="checkbox" id="allow_retakes" name="allow_retakes" 
                                       <?php echo $quiz['allow_retakes'] ? 'checked' : ''; ?>
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-gray-700">Allow Retakes</span>
                            </label>
                        </div>
                    </form>
                </div>

                <!-- Questions List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Questions</h3>
                        <button id="addQuestionBtn" class="text-purple-600 hover:text-purple-700">
                            <i class="fas fa-plus-circle text-xl"></i>
                        </button>
                    </div>
                    
                    <div id="questionsList" class="space-y-2 max-h-96 overflow-y-auto">
                        <!-- Questions will be populated by JavaScript -->
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <span id="questionCount">0</span> questions
                        </div>
                    </div>
                </div>

                <!-- Question Types -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Question Type</h3>
                    
                    <div class="space-y-2">
                        <button class="question-type-btn w-full text-left px-3 py-2 rounded-md border border-gray-200 hover:bg-gray-50 transition-colors" data-type="multiple-choice">
                            <i class="fas fa-list-ul text-purple-500 mr-2"></i>
                            Multiple Choice
                        </button>
                        
                        <button class="question-type-btn w-full text-left px-3 py-2 rounded-md border border-gray-200 hover:bg-gray-50 transition-colors" data-type="checkbox">
                            <i class="fas fa-check-square text-blue-500 mr-2"></i>
                            Multiple Select
                        </button>
                        
                        <button class="question-type-btn w-full text-left px-3 py-2 rounded-md border border-gray-200 hover:bg-gray-50 transition-colors" data-type="true-false">
                            <i class="fas fa-toggle-on text-green-500 mr-2"></i>
                            True/False
                        </button>
                        
                        <button class="question-type-btn w-full text-left px-3 py-2 rounded-md border border-gray-200 hover:bg-gray-50 transition-colors" data-type="short-answer">
                            <i class="fas fa-pen text-orange-500 mr-2"></i>
                            Short Answer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Content - Question Editor -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Question Editor</h3>
                    </div>
                    
                    <div id="questionEditor" class="p-6 question-editor">
                        <div class="flex flex-col items-center justify-center h-full text-gray-500">
                            <i class="fas fa-edit text-4xl mb-4"></i>
                            <h4 class="text-lg font-medium mb-2">Select a Question to Edit</h4>
                            <p class="text-center">Choose a question from the list on the left, or add a new question to get started.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let questions = <?php echo json_encode($processedQuestions); ?>;
        let currentQuestionId = null;
        let hasUnsavedChanges = false;
        let questionIdCounter = Math.max(...questions.map(q => parseInt(q.question_id) || 0), 0);

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            initializeQuestionsList();
            setupEventListeners();
            updateQuestionCount();
            
            // Load first question if available
            if (questions.length > 0) {
                loadQuestionEditor(questions[0]);
            }
        });

        // Setup event listeners
        function setupEventListeners() {
            // Add question button
            document.getElementById('addQuestionBtn').addEventListener('click', function() {
                addNewQuestion('multiple-choice');
            });

            // Question type buttons
            document.querySelectorAll('.question-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    addNewQuestion(type);
                });
            });

            // Save quiz button
            document.getElementById('saveQuizBtn').addEventListener('click', saveQuiz);

            // Preview quiz button
            document.getElementById('previewQuizBtn').addEventListener('click', function() {
                window.open(`previewQuiz.php?quiz_id=<?php echo $quiz_id; ?>`, '_blank');
            });

            // Quiz settings form changes
            document.getElementById('quizSettingsForm').addEventListener('change', function() {
                hasUnsavedChanges = true;
            });

            // Warn before leaving with unsaved changes
            window.addEventListener('beforeunload', function(e) {
                if (hasUnsavedChanges) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        }

        // Initialize questions list
        function initializeQuestionsList() {
            const questionsList = document.getElementById('questionsList');
            questionsList.innerHTML = '';

            if (questions.length === 0) {
                questionsList.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-question-circle text-2xl mb-2"></i>
                        <p class="text-sm">No questions yet. Add your first question!</p>
                    </div>
                `;
                return;
            }

            questions.forEach((question, index) => {
                const questionItem = createQuestionListItem(question, index + 1);
                questionsList.appendChild(questionItem);
            });
        }

        // Create question list item
        function createQuestionListItem(question, number) {
            const div = document.createElement('div');
            div.className = 'question-list-item p-3 rounded-md border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors';
            div.setAttribute('data-question-id', question.id);

            const icon = getQuestionTypeIcon(question.type);
            const preview = question.text ? question.text.substring(0, 50) + (question.text.length > 50 ? '...' : '') : 'Untitled Question';

            div.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <div class="flex-shrink-0">
                            <i class="${icon.class} ${icon.color}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900">Question ${number}</div>
                            <div class="text-xs text-gray-500 truncate">${preview}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="text-xs text-gray-400">${question.points || 1} pt${(question.points || 1) !== 1 ? 's' : ''}</span>
                        <button class="delete-question-btn text-red-400 hover:text-red-600 p-1" data-question-id="${question.id}">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>
            `;

            // Add click event to load question
            div.addEventListener('click', function(e) {
                if (!e.target.closest('.delete-question-btn')) {
                    loadQuestionEditor(question);
                }
            });

            // Add delete event
            const deleteBtn = div.querySelector('.delete-question-btn');
            deleteBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                deleteQuestion(question.id);
            });

            return div;
        }

        // Get question type icon
        function getQuestionTypeIcon(type) {
            const icons = {
                'multiple-choice': { class: 'fas fa-list-ul', color: 'text-purple-500' },
                'checkbox': { class: 'fas fa-check-square', color: 'text-blue-500' },
                'true-false': { class: 'fas fa-toggle-on', color: 'text-green-500' },
                'short-answer': { class: 'fas fa-pen', color: 'text-orange-500' }
            };
            return icons[type] || icons['multiple-choice'];
        }

        // Add new question
        function addNewQuestion(type) {
            questionIdCounter++;
            const newQuestion = {
                id: `question_new_${questionIdCounter}`,
                question_id: null, // Will be assigned when saved
                type: type,
                text: '',
                points: 1,
                order: questions.length + 1,
                options: type === 'true-false' ? [
                    { text: 'True', isCorrect: false, order: 1 },
                    { text: 'False', isCorrect: false, order: 2 }
                ] : (type === 'short-answer' ? [] : [
                    { text: '', isCorrect: false, order: 1 },
                    { text: '', isCorrect: false, order: 2 },
                    { text: '', isCorrect: false, order: 3 },
                    { text: '', isCorrect: false, order: 4 }
                ]),
                correctAnswer: type === 'short-answer' ? '' : undefined,
                caseSensitive: type === 'short-answer' ? false : undefined
            };

            questions.push(newQuestion);
            initializeQuestionsList();
            loadQuestionEditor(newQuestion);
            updateQuestionCount();
            hasUnsavedChanges = true;
        }

        // Load question editor
        function loadQuestionEditor(question) {
            currentQuestionId = question.id;
            
            // Update active state in list
            document.querySelectorAll('.question-list-item').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-question-id') === question.id) {
                    item.classList.add('active');
                }
            });

            const editor = document.getElementById('questionEditor');
            editor.innerHTML = createQuestionEditorHTML(question);
            setupQuestionEditorEvents(question);
        }

        // Create question editor HTML
        function createQuestionEditorHTML(question) {
            let optionsHTML = '';
            
            if (question.type === 'short-answer') {
                optionsHTML = `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                            <input type="text" id="correctAnswer" value="${question.correctAnswer || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   placeholder="Enter the correct answer">
                        </div>
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" id="caseSensitive" ${question.caseSensitive ? 'checked' : ''} 
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Case sensitive</span>
                            </label>
                        </div>
                    </div>
                `;
            } else {
                const inputType = question.type === 'multiple-choice' ? 'radio' : 'checkbox';
                const inputName = question.type === 'multiple-choice' ? 'correct-option' : '';
                
                optionsHTML = `
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium text-gray-700">Answer Options</label>
                            ${question.type !== 'true-false' ? `
                                <button type="button" id="addOptionBtn" class="text-sm text-purple-600 hover:text-purple-700">
                                    <i class="fas fa-plus-circle mr-1"></i>Add Option
                                </button>
                            ` : ''}
                        </div>
                        <div id="optionsContainer" class="space-y-2">
                `;
                
                question.options.forEach((option, index) => {
                    const isReadonly = question.type === 'true-false' ? 'readonly' : '';
                    const canDelete = question.type !== 'true-false' && question.options.length > 2;
                    
                    optionsHTML += `
                        <div class="option-item flex items-center space-x-3 p-3 border border-gray-200 rounded-md">
                            <input type="${inputType}" name="${inputName}" class="correct-option" ${option.isCorrect ? 'checked' : ''}>
                            <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 ${isReadonly ? 'bg-gray-50' : ''}" 
                                   value="${option.text}" placeholder="Option ${index + 1}" ${isReadonly}>
                            ${canDelete ? `
                                <button type="button" class="delete-option-btn text-red-400 hover:text-red-600 p-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            ` : ''}
                        </div>
                    `;
                });
                
                optionsHTML += `
                        </div>
                    </div>
                `;
            }

            return `
                <div class="space-y-6 fade-in">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-medium text-gray-900">
                            ${getQuestionTypeIcon(question.type).class ? `<i class="${getQuestionTypeIcon(question.type).class} ${getQuestionTypeIcon(question.type).color} mr-2"></i>` : ''}
                            ${question.type.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())} Question
                        </h4>
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-700">Points:</label>
                            <input type="number" id="questionPoints" min="1" value="${question.points || 1}" 
                                   class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="questionText" class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                        <textarea id="questionText" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                  placeholder="Enter your question here...">${question.text}</textarea>
                    </div>
                    
                    ${optionsHTML}
                    
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <button type="button" id="duplicateQuestionBtn" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                            <i class="fas fa-copy mr-2"></i>Duplicate Question
                        </button>
                        <button type="button" id="deleteQuestionBtn" class="px-4 py-2 text-red-600 bg-red-50 rounded-md hover:bg-red-100 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Question
                        </button>
                    </div>
                </div>
            `;
        }

        // Setup question editor events
        function setupQuestionEditorEvents(question) {
            // Question text
            const questionText = document.getElementById('questionText');
            questionText.addEventListener('input', function() {
                question.text = this.value;
                hasUnsavedChanges = true;
                updateQuestionInList(question);
            });

            // Question points
            const questionPoints = document.getElementById('questionPoints');
            questionPoints.addEventListener('input', function() {
                question.points = parseInt(this.value) || 1;
                hasUnsavedChanges = true;
                updateQuestionInList(question);
            });

            // Handle different question types
            if (question.type === 'short-answer') {
                const correctAnswer = document.getElementById('correctAnswer');
                const caseSensitive = document.getElementById('caseSensitive');
                
                correctAnswer.addEventListener('input', function() {
                    question.correctAnswer = this.value;
                    hasUnsavedChanges = true;
                });
                
                caseSensitive.addEventListener('change', function() {
                    question.caseSensitive = this.checked;
                    hasUnsavedChanges = true;
                });
            } else {
                // Options handling
                setupOptionsEvents(question);
                
                // Add option button
                const addOptionBtn = document.getElementById('addOptionBtn');
                if (addOptionBtn) {
                    addOptionBtn.addEventListener('click', function() {
                        addOption(question);
                    });
                }
            }

            // Duplicate question button
            const duplicateBtn = document.getElementById('duplicateQuestionBtn');
            duplicateBtn.addEventListener('click', function() {
                duplicateQuestion(question);
            });

            // Delete question button
            const deleteBtn = document.getElementById('deleteQuestionBtn');
            deleteBtn.addEventListener('click', function() {
                deleteQuestion(question.id);
            });
        }

        // Setup options events
        function setupOptionsEvents(question) {
            const correctOptions = document.querySelectorAll('.correct-option');
            const optionTexts = document.querySelectorAll('.option-text');
            const deleteButtons = document.querySelectorAll('.delete-option-btn');

            correctOptions.forEach((input, index) => {
                input.addEventListener('change', function() {
                    if (question.type === 'multiple-choice') {
                        // For multiple choice, only one can be correct
                        question.options.forEach((opt, i) => {
                            opt.isCorrect = i === index && this.checked;
                        });
                    } else {
                        // For checkbox, multiple can be correct
                        question.options[index].isCorrect = this.checked;
                    }
                    hasUnsavedChanges = true;
                });
            });

            optionTexts.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (question.options[index]) {
                        question.options[index].text = this.value;
                        hasUnsavedChanges = true;
                    }
                });
            });

            deleteButtons.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    deleteOption(question, index);
                });
            });
        }

        // Add option
        function addOption(question) {
            const newOption = {
                text: '',
                isCorrect: false,
                order: question.options.length + 1
            };
            
            question.options.push(newOption);
            loadQuestionEditor(question);
            hasUnsavedChanges = true;
        }

        // Delete option
        function deleteOption(question, index) {
            if (question.options.length <= 2) {
                showNotification('A question must have at least 2 options.', 'warning');
                return;
            }
            
            question.options.splice(index, 1);
            // Reorder remaining options
            question.options.forEach((opt, i) => {
                opt.order = i + 1;
            });
            
            loadQuestionEditor(question);
            hasUnsavedChanges = true;
        }

        // Duplicate question
        function duplicateQuestion(question) {
            questionIdCounter++;
            const duplicatedQuestion = {
                ...JSON.parse(JSON.stringify(question)), // Deep copy
                id: `question_new_${questionIdCounter}`,
                question_id: null,
                order: questions.length + 1,
                text: question.text + ' (Copy)'
            };
            
            questions.push(duplicatedQuestion);
            initializeQuestionsList();
            loadQuestionEditor(duplicatedQuestion);
            updateQuestionCount();
            hasUnsavedChanges = true;
            
            showNotification('Question duplicated successfully!', 'success');
        }

        // Delete question
        function deleteQuestion(questionId) {
            if (questions.length <= 1) {
                showNotification('A quiz must have at least one question.', 'warning');
                return;
            }
            
            if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
                const questionIndex = questions.findIndex(q => q.id === questionId);
                if (questionIndex !== -1) {
                    questions.splice(questionIndex, 1);
                    
                    // Reorder remaining questions
                    questions.forEach((q, i) => {
                        q.order = i + 1;
                    });
                    
                    initializeQuestionsList();
                    updateQuestionCount();
                    hasUnsavedChanges = true;
                    
                    // Load next question or show empty state
                    if (questions.length > 0) {
                        const nextQuestion = questions[Math.min(questionIndex, questions.length - 1)];
                        loadQuestionEditor(nextQuestion);
                    } else {
                        document.getElementById('questionEditor').innerHTML = `
                            <div class="flex flex-col items-center justify-center h-full text-gray-500">
                                <i class="fas fa-edit text-4xl mb-4"></i>
                                <h4 class="text-lg font-medium mb-2">No Questions</h4>
                                <p class="text-center">Add a new question to get started.</p>
                            </div>
                        `;
                    }
                    
                    showNotification('Question deleted successfully!', 'success');
                }
            }
        }

        // Update question in list
        function updateQuestionInList(question) {
            const questionItem = document.querySelector(`[data-question-id="${question.id}"]`);
            if (questionItem) {
                const preview = question.text ? question.text.substring(0, 50) + (question.text.length > 50 ? '...' : '') : 'Untitled Question';
                const previewElement = questionItem.querySelector('.text-xs.text-gray-500');
                const pointsElement = questionItem.querySelector('.text-xs.text-gray-400');
                
                if (previewElement) {
                    previewElement.textContent = preview;
                }
                if (pointsElement) {
                    pointsElement.textContent = `${question.points || 1} pt${(question.points || 1) !== 1 ? 's' : ''}`;
                }
            }
        }

        // Update question count
        function updateQuestionCount() {
            const countElement = document.getElementById('questionCount');
            if (countElement) {
                countElement.textContent = questions.length;
            }
        }

        // Save quiz
        function saveQuiz() {
            const saveBtn = document.getElementById('saveQuizBtn');
            const originalText = saveBtn.innerHTML;
            
            // Validate questions
            if (questions.length === 0) {
                showNotification('Please add at least one question to your quiz.', 'warning');
                return;
            }
            
            let isValid = true;
            let errorMessage = '';
            
            questions.forEach((question, index) => {
                if (!question.text.trim()) {
                    isValid = false;
                    errorMessage = `Question ${index + 1} is missing text.`;
                    return;
                }
                
                if (question.type !== 'short-answer') {
                    const hasCorrectOption = question.options.some(option => option.isCorrect);
                    if (!hasCorrectOption) {
                        isValid = false;
                        errorMessage = `Question ${index + 1} has no correct answer selected.`;
                        return;
                    }
                } else {
                    if (!question.correctAnswer || !question.correctAnswer.trim()) {
                        isValid = false;
                        errorMessage = `Question ${index + 1} is missing a correct answer.`;
                        return;
                    }
                }
            });
            
            if (!isValid) {
                showNotification(errorMessage, 'error');
                return;
            }
            
            // Show loading state
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            saveBtn.disabled = true;
            
            // Prepare data
            const quizSettings = new FormData(document.getElementById('quizSettingsForm'));
            const data = {
                quiz_id: <?php echo $quiz_id; ?>,
                quiz_settings: Object.fromEntries(quizSettings),
                questions: questions
            };
            
            // Send AJAX request
            fetch('../../Controllers/quizController.php?action=updateQuiz', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hasUnsavedChanges = false;
                    showNotification('Quiz updated successfully!', 'success');
                    
                    // Update question IDs for new questions
                    if (data.question_mappings) {
                        Object.entries(data.question_mappings).forEach(([tempId, realId]) => {
                            const question = questions.find(q => q.id === tempId);
                            if (question) {
                                question.question_id = realId;
                                question.id = `question_${realId}`;
                            }
                        });
                        initializeQuestionsList();
                    }
                    
                    // Add a short delay before redirecting
                    setTimeout(() => {
                        // Redirect to classDetails page
                        window.location.href = `../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>`;
                    }, 1500); // 1.5 seconds delay to show the success message
                } else {
                    showNotification(data.message || 'Failed to update quiz', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while saving the quiz.', 'error');
            })
            .finally(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="flex items-center justify-between">
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }
    </script>
</body>
</html>