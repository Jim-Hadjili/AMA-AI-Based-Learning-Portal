<?php include "../../Functions/fetchQuizQuestionsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quizDetails['quiz_title']); ?> - Take Quiz</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 pt-6">

            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="studentDashboard.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 quiz-navigation-link">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="classDetails.php?class_id=<?php echo $quizDetails['class_id']; ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600 quiz-navigation-link">
                                Class Details
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2"><?php echo htmlspecialchars($quizDetails['quiz_title']); ?></span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Quiz Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="inline-block p-4 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-question-circle text-2xl text-green-600"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($quizDetails['quiz_title']); ?></h1>
                                <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($quizDetails['quiz_description'] ?? 'No description provided.'); ?></p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-clock mr-1"></i>Time Limit: <strong><?php echo $quizDetails['time_limit']; ?> minutes</strong></span>
                                    <span><i class="fas fa-list-ol mr-1"></i>Questions: <strong><?php echo $quizDetails['total_questions']; ?></strong></span>
                                    <span><i class="fas fa-star mr-1"></i>Total Score: <strong><?php echo $quizDetails['total_score']; ?> points</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span id="quiz-timer" class="px-3 py-1 text-lg font-bold rounded-full bg-blue-100 text-blue-800">
                                <?php echo $quizDetails['time_limit']; ?>:00
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Questions -->
            <form id="quizForm" action="submitQuiz.php" method="POST">
                <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizDetails['quiz_id']); ?>">
                <div class="space-y-6">
                    <?php if (empty($quizQuestions)): ?>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                            <i class="fas fa-exclamation-circle text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No questions found for this quiz.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($quizQuestions as $index => $question): ?>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <div class="flex items-start mb-4">
                                    <div class="w-8 h-8 flex-shrink-0 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold mr-4">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium text-gray-900 mb-2"><?php echo htmlspecialchars($question['question_text']); ?></p>
                                        <p class="text-sm text-gray-600">Points: <?php echo $question['question_points']; ?></p>
                                    </div>
                                </div>

                                <div class="pl-12 space-y-3">
                                    <?php if ($question['question_type'] === 'multiple-choice'): ?>
                                        <?php foreach ($question['options'] as $option): ?>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    <?php elseif ($question['question_type'] === 'checkbox'): ?>
                                        <?php foreach ($question['options'] as $option): ?>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="checkbox" name="answer[<?php echo $question['question_id']; ?>][]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    <?php elseif ($question['question_type'] === 'true-false'): ?>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="true" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-3 text-gray-700">True</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="false" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-3 text-gray-700">False</span>
                                        </label>
                                    <?php elseif ($question['question_type'] === 'short-answer'): ?>
                                        <textarea name="answer[<?php echo $question['question_id']; ?>]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2" placeholder="Type your answer here..."></textarea>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="text-center mt-8">
                            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-lg font-medium shadow-md">
                                Submit Quiz
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </form>

        </main>
    </div>

    <!-- Exit Quiz Confirmation Modal -->
    <div id="exitQuizConfirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center hidden backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 transform transition-all duration-300">
            <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200 bg-gradient-to-r from-red-50 to-white rounded-t-xl">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </span>
                    Confirm Exit
                </h3>
                <button type="button" id="closeExitQuizModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full p-1 hover:bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-door-open text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-red-600 mb-2">Are you sure you want to exit the quiz?</h4>
                        <p class="text-gray-700 mb-3">Your current progress will be lost, and the quiz will be marked as failed/abandoned.</p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-info-circle text-red-400 mr-2"></i>
                            Click "Exit Quiz" to confirm or "Stay in Quiz" to continue.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-200">
                <button type="button" id="stayInQuizBtn" class="px-4 py-2.5 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    <i class="fas fa-arrow-left mr-1.5"></i>Stay in Quiz
                </button>
                <button type="button" id="exitQuizBtn" class="px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-sm text-sm font-medium text-white hover:from-red-600 hover:to-red-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-sign-out-alt mr-1.5"></i>Exit Quiz
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quizId = <?php echo json_encode($quizDetails['quiz_id']); ?>;
            const timeLimitMinutes = <?php echo $quizDetails['time_limit']; ?>;
            const timerDisplay = document.getElementById('quiz-timer');
            const quizForm = document.getElementById('quizForm');
            const questions = <?php echo json_encode($quizQuestions); ?>;

            let timeLeftSeconds;
            let timerInterval;
            let quizSubmitted = false; // Flag to prevent back button modal on submission
            let targetUrlOnExit = null; // Stores the URL to redirect to if user confirms exit via a link

            const TIMER_STORAGE_KEY = `quiz_timer_${quizId}`;
            const ANSWERS_STORAGE_PREFIX = `quiz_answer_${quizId}_`;

            // --- Timer Persistence ---
            function initializeTimer() {
                const storedTime = localStorage.getItem(TIMER_STORAGE_KEY);
                console.log('Initializing timer. Stored time:', storedTime); // Debugging
                if (storedTime !== null && !isNaN(storedTime) && parseInt(storedTime, 10) > 0) {
                    timeLeftSeconds = parseInt(storedTime, 10);
                    console.log('Loaded time from storage:', timeLeftSeconds); // Debugging
                } else {
                    timeLeftSeconds = timeLimitMinutes * 60;
                    console.log('No valid time in storage, setting to default:', timeLeftSeconds); // Debugging
                }
                updateTimerDisplay();
                timerInterval = setInterval(updateTimer, 1000);
            }

            function updateTimerDisplay() {
                const minutes = Math.floor(timeLeftSeconds / 60);
                const seconds = timeLeftSeconds % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeftSeconds <= 60) {
                    timerDisplay.classList.remove('bg-blue-100', 'text-blue-800');
                    timerDisplay.classList.add('bg-red-100', 'text-red-800');
                } else {
                    timerDisplay.classList.remove('bg-red-100', 'text-red-800');
                    timerDisplay.classList.add('bg-blue-100', 'text-blue-800');
                }
            }

            function updateTimer() {
                if (timeLeftSeconds <= 0) {
                    clearInterval(timerInterval);
                    alert('Time is up! Your quiz will be submitted automatically.');
                    quizSubmitted = true; // Mark as submitted to bypass beforeunload/popstate
                    quizForm.submit(); // Automatically submit the form
                } else {
                    timeLeftSeconds--;
                    updateTimerDisplay();
                    localStorage.setItem(TIMER_STORAGE_KEY, timeLeftSeconds);
                }
            }

            // --- Answer Persistence ---
            function saveAnswer(questionId, value) {
                localStorage.setItem(`${ANSWERS_STORAGE_PREFIX}${questionId}`, JSON.stringify(value));
            }

            function loadAnswers() {
                questions.forEach(question => {
                    const storedAnswer = localStorage.getItem(`${ANSWERS_STORAGE_PREFIX}${question.question_id}`);
                    if (storedAnswer) {
                        try {
                            const answerValue = JSON.parse(storedAnswer);
                            if (question.question_type === 'multiple-choice' || question.question_type === 'true-false') {
                                const radio = quizForm.querySelector(`input[name="answer[${question.question_id}]"][value="${answerValue}"]`);
                                if (radio) radio.checked = true;
                            } else if (question.question_type === 'checkbox') {
                                if (Array.isArray(answerValue)) {
                                    answerValue.forEach(val => {
                                        const checkbox = quizForm.querySelector(`input[name="answer[${question.question_id}][]"][value="${val}"]`);
                                        if (checkbox) checkbox.checked = true;
                                    });
                                }
                            } else if (question.question_type === 'short-answer') {
                                const textarea = quizForm.querySelector(`textarea[name="answer[${question.question_id}]"]`);
                                if (textarea) textarea.value = answerValue;
                            }
                        } catch (e) {
                            console.error("Error parsing stored answer for question", question.question_id, ":", e);
                            localStorage.removeItem(`${ANSWERS_STORAGE_PREFIX}${question.question_id}`); // Clear corrupted data
                        }
                    }
                });
            }

            function clearQuizData() {
                localStorage.removeItem(TIMER_STORAGE_KEY);
                questions.forEach(question => {
                    localStorage.removeItem(`${ANSWERS_STORAGE_PREFIX}${question.question_id}`);
                });
                console.log('Quiz data cleared from localStorage.'); // Debugging
            }

            // --- Exit Quiz Confirmation Modal ---
            const exitQuizConfirmationModal = document.getElementById('exitQuizConfirmationModal');
            const closeExitQuizModalBtn = document.getElementById('closeExitQuizModalBtn');
            const stayInQuizBtn = document.getElementById('stayInQuizBtn');
            const exitQuizBtn = document.getElementById('exitQuizBtn');

            function showExitQuizModal() {
                exitQuizConfirmationModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function hideExitQuizModal() {
                exitQuizConfirmationModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                targetUrlOnExit = null; // Reset target URL when modal is hidden
            }

            // Add a dummy state to history to intercept back button
            history.pushState(null, null, location.href);
            console.log('Initial history state pushed.'); // Debugging

            window.addEventListener('popstate', function(event) {
                console.log('Popstate event triggered. Quiz submitted:', quizSubmitted); // Debugging
                if (!quizSubmitted) {
                    // Always push state back to keep the current page in history if user cancels
                    history.pushState(null, null, location.href);
                    console.log('Re-pushed history state to stay on page.'); // Debugging
                    showExitQuizModal();
                }
            });

            closeExitQuizModalBtn.addEventListener('click', hideExitQuizModal);
            stayInQuizBtn.addEventListener('click', hideExitQuizModal);

            exitQuizBtn.addEventListener('click', function() {
                quizSubmitted = true; // Mark as submitted to bypass further popstate/beforeunload
                clearQuizData(); // Clear data as quiz is abandoned
                // Redirect to the stored target URL or default to dashboard
                window.location.href = targetUrlOnExit || 'studentDashboard.php?quiz_abandoned=true';
            });

            // --- Event Listeners for Answer Saving ---
            quizForm.addEventListener('change', function(event) {
                const target = event.target;
                const name = target.name;
                if (name.startsWith('answer[')) {
                    const questionIdMatch = name.match(/answer\[(\d+)\]/);
                    if (questionIdMatch) {
                        const questionId = questionIdMatch[1];
                        if (target.type === 'radio' || target.type === 'textarea') {
                            saveAnswer(questionId, target.value);
                        } else if (target.type === 'checkbox') {
                            const checkboxes = quizForm.querySelectorAll(`input[name="answer[${questionId}][]"]:checked`);
                            const checkedValues = Array.from(checkboxes).map(cb => cb.value);
                            saveAnswer(questionId, checkedValues);
                        }
                    }
                }
            });

            quizForm.addEventListener('submit', function() {
                quizSubmitted = true; // Mark as submitted
                clearInterval(timerInterval); // Stop the timer
                clearQuizData(); // Clear stored data on successful submission
                // The form will now submit to submitQuiz.php
            });

            // Prevent accidental closing of the tab/browser (native browser warning)
            window.addEventListener('beforeunload', function (e) {
                if (!quizSubmitted) {
                    e.preventDefault(); // Standard for most browsers
                    e.returnValue = ''; // For older browsers
                    console.log('Beforeunload event triggered. Preventing navigation.'); // Debugging
                    return 'Are you sure you want to leave? Your quiz progress may be lost.';
                }
            });

            // --- Event Listeners for Breadcrumb Links ---
            const breadcrumbLinks = document.querySelectorAll('.quiz-navigation-link');
            breadcrumbLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    if (!quizSubmitted) {
                        event.preventDefault(); // Prevent default navigation
                        targetUrlOnExit = this.href; // Store the intended destination
                        showExitQuizModal();
                    }
                });
            });

            // Initialize on page load
            initializeTimer();
            loadAnswers();
        });
    </script>

</body>

</html>
