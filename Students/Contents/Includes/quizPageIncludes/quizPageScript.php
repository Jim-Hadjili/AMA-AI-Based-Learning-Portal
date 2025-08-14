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
                timerDisplay.parentElement.classList.remove('bg-blue-600');
                timerDisplay.parentElement.classList.add('bg-red-600');
            } else {
                timerDisplay.parentElement.classList.remove('bg-red-600');
                timerDisplay.parentElement.classList.add('bg-blue-600');
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

        if (closeExitQuizModalBtn) closeExitQuizModalBtn.addEventListener('click', hideExitQuizModal);
        if (stayInQuizBtn) stayInQuizBtn.addEventListener('click', hideExitQuizModal);

        if (exitQuizBtn) {
            exitQuizBtn.addEventListener('click', function() {
                quizSubmitted = true; // Mark as submitted to bypass further popstate/beforeunload
                clearQuizData(); // Clear data as quiz is abandoned
                // Redirect to the stored target URL or default to dashboard
                window.location.href = targetUrlOnExit || 'studentDashboard.php?quiz_abandoned=true';
            });
        }

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
        window.addEventListener('beforeunload', function(e) {
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

    //No Copy, Paste, Cut, View Source, Dev Tools

    // Disable right-click context menu
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Block keyboard shortcuts for copy, paste, cut, view source, dev tools
    document.addEventListener('keydown', function(e) {
        // Block F12, Ctrl+U, Ctrl+Shift+I/J, Ctrl+C/X/V
        if (
            e.key === 'F12' ||
            (e.ctrlKey && (e.key === 'u' || e.key === 'U')) ||
            (e.ctrlKey && e.shiftKey && (e.key.toLowerCase() === 'i' || e.key.toLowerCase() === 'j')) ||
            (e.ctrlKey && (e.key.toLowerCase() === 'c' || e.key.toLowerCase() === 'v' || e.key.toLowerCase() === 'x'))
        ) {
            e.preventDefault();
            return false;
        }
    });

    // Prevent text selection via mouse
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
    });

    // Prevent copy event
    document.addEventListener('copy', function(e) {
        e.preventDefault();
    });

    // Prevent cut event
    document.addEventListener('cut', function(e) {
        e.preventDefault();
    });

    // Prevent paste event
    document.addEventListener('paste', function(e) {
        e.preventDefault();
    });

    // Optional: Add CSS to prevent selection
    document.body.style.userSelect = 'none';
    document.body.style.webkitUserSelect = 'none';
    document.body.style.msUserSelect = 'none';
    document.body.style.mozUserSelect = 'none';
</script>
