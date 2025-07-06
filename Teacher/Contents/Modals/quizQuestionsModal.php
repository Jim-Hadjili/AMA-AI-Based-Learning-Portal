<!-- Quiz Questions Modal -->
<div id="quizQuestionsModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-0">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">
                    Create Questions
                </h3>
                <button onclick="closeQuizQuestionsModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Left sidebar for question navigation -->
                    <div class="w-full md:w-64 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-gray-700">Questions</h4>
                            <button id="addQuestionBtn" class="text-purple-primary hover:text-purple-dark" title="Add Question">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                        
                        <!-- Question list -->
                        <div class="bg-gray-50 rounded-lg p-4 max-h-[50vh] overflow-y-auto">
                            <ul id="question-list" class="space-y-2">
                                <li class="text-center text-gray-500 py-4 text-sm">
                                    No questions yet. Click the + button to add a question.
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Question type selection -->
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Question Type</h4>
                            <div class="space-y-2">
                                <button class="question-type-btn w-full py-2 px-3 text-left border rounded-md text-sm" data-type="multiple-choice">
                                    <i class="fas fa-list-ul mr-2 text-purple-primary"></i> Multiple Choice
                                </button>
                                <button class="question-type-btn w-full py-2 px-3 text-left border rounded-md text-sm" data-type="checkbox">
                                    <i class="fas fa-check-square mr-2 text-blue-500"></i> Checkbox (Multiple Answers)
                                </button>
                                <button class="question-type-btn w-full py-2 px-3 text-left border rounded-md text-sm" data-type="true-false">
                                    <i class="fas fa-toggle-on mr-2 text-green-500"></i> True/False
                                </button>
                                <button class="question-type-btn w-full py-2 px-3 text-left border rounded-md text-sm" data-type="short-answer">
                                    <i class="fas fa-pen mr-2 text-orange-500"></i> Short Answer
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side for question editing -->
                    <div class="flex-1 bg-white rounded-lg">
                        <!-- Question editor -->
                        <div id="question-editor" class="p-4 border rounded-lg">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-edit text-3xl mb-2"></i>
                                <p>Select or add a question to start editing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between">
                <div>
                    <span id="question-count" class="text-sm text-gray-500">0 questions</span>
                </div>
                <div class="space-x-2">
                    <button onclick="closeQuizQuestionsModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button id="saveQuestionsBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark">
                        Save Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to open the quiz questions modal
    function openQuizQuestionsModal(quizId, mode) {
        document.getElementById('quizQuestionsModal').classList.remove('hidden');
        // Initialize the question editor with the quiz ID
        initializeQuestionInterface(quizId, mode);
    }
    
    // Function to close the quiz questions modal
    function closeQuizQuestionsModal() {
        document.getElementById('quizQuestionsModal').classList.add('hidden');
        
        // Show confirmation dialog if there are unsaved changes
        if (hasUnsavedChanges()) {
            if (confirm('You have unsaved changes. Are you sure you want to leave?')) {
                redirectToQuizDashboard();
            } else {
                document.getElementById('quizQuestionsModal').classList.remove('hidden');
            }
        } else {
            redirectToQuizDashboard();
        }
    }
    
    // Make functions available globally
    window.openQuizQuestionsModal = openQuizQuestionsModal;
    window.closeQuizQuestionsModal = closeQuizQuestionsModal;
    
    // Check if there are unsaved changes
    function hasUnsavedChanges() {
        // Implement logic to check for unsaved changes
        return false; // Placeholder, replace with actual logic
    }
    
    // Redirect to quiz dashboard
    function redirectToQuizDashboard() {
        // Get the class ID from URL or stored variable
        const urlParams = new URLSearchParams(window.location.search);
        const classId = urlParams.get('class_id') || window.currentClassId;
        
        if (classId) {
            // Fix the path to avoid the duplicate "Contents" folder
            window.location.href = `../../Contents/Tabs/classDetails.php?class_id=${classId}`;
        } else {
            window.location.href = `../../Dashboard/teachersDashboard.php`;
        }
    }
    
    // Initialize the question interface
    function initializeQuestionInterface(quizId, mode) {
        // Store quiz information
        window.currentQuizId = quizId;
        window.quizCreationMode = mode;
        window.questions = [];
        
        // Set up event listeners for question type buttons
        const questionTypeBtns = document.querySelectorAll('.question-type-btn');
        questionTypeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const questionType = this.getAttribute('data-type');
                addNewQuestion(questionType);
            });
        });
        
        // Set up add question button
        const addQuestionBtn = document.getElementById('addQuestionBtn');
        if (addQuestionBtn) {
            addQuestionBtn.addEventListener('click', function() {
                // Default to multiple-choice
                addNewQuestion('multiple-choice');
            });
        }
        
        // Set up save questions button
        const saveQuestionsBtn = document.getElementById('saveQuestionsBtn');
        if (saveQuestionsBtn) {
            saveQuestionsBtn.addEventListener('click', function() {
                saveQuestions();
            });
        }
        
        // Update question count
        updateQuestionCount();
    }
    
    // Add a new question
    function addNewQuestion(type) {
        const questionNumber = window.questions.length + 1;
        
        // Create new question object
        const question = {
            id: `question_${Date.now()}`,
            type: type,
            text: '',
            options: [],
            order: questionNumber
        };
        
        // Add to questions array
        window.questions.push(question);
        
        // Update the question list
        updateQuestionList();
        
        // Load the question editor for the new question
        loadQuestionEditor(question);
        
        // Update question count
        updateQuestionCount();
    }
    
    // Update the question list in the sidebar
    function updateQuestionList() {
        const questionList = document.getElementById('question-list');
        if (questionList) {
            if (window.questions.length === 0) {
                questionList.innerHTML = `
                    <li class="text-center text-gray-500 py-4 text-sm">
                        No questions yet. Click the + button to add a question.
                    </li>
                `;
            } else {
                questionList.innerHTML = '';
                window.questions.forEach((question, index) => {
                    const li = document.createElement('li');
                    li.className = 'bg-white border rounded-md p-2 cursor-pointer hover:bg-gray-50 flex justify-between items-center';
                    li.setAttribute('data-question-id', question.id);
                    
                    // Get appropriate icon for question type
                    let icon = 'list-ul';
                    let iconColor = 'text-purple-primary';
                    
                    switch(question.type) {
                        case 'checkbox':
                            icon = 'check-square';
                            iconColor = 'text-blue-500';
                            break;
                        case 'true-false':
                            icon = 'toggle-on';
                            iconColor = 'text-green-500';
                            break;
                        case 'short-answer':
                            icon = 'pen';
                            iconColor = 'text-orange-500';
                            break;
                    }
                    
                    li.innerHTML = `
                        <div>
                            <i class="fas fa-${icon} ${iconColor} mr-2"></i>
                            <span>Question ${index + 1}</span>
                        </div>
                        <button class="delete-question-btn text-red-500 hover:text-red-700" data-question-id="${question.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                    
                    li.addEventListener('click', function(e) {
                        // Ignore if delete button was clicked
                        if (e.target.closest('.delete-question-btn')) return;
                        
                        const questionId = this.getAttribute('data-question-id');
                        const question = window.questions.find(q => q.id === questionId);
                        if (question) {
                            loadQuestionEditor(question);
                        }
                    });
                    
                    questionList.appendChild(li);
                });
                
                // Add event listeners for delete buttons
                const deleteButtons = questionList.querySelectorAll('.delete-question-btn');
                deleteButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const questionId = this.getAttribute('data-question-id');
                        deleteQuestion(questionId);
                    });
                });
            }
        }
    }
    
    // Load question editor for a specific question
    function loadQuestionEditor(question) {
        const editor = document.getElementById('question-editor');
        if (!editor) return;
        
        // Highlight the selected question in the list
        const questionItems = document.querySelectorAll('#question-list li');
        questionItems.forEach(item => {
            item.classList.remove('bg-purple-50', 'border-purple-300');
            if (item.getAttribute('data-question-id') === question.id) {
                item.classList.add('bg-purple-50', 'border-purple-300');
            }
        });
        
        // Create the editor interface based on question type
        let editorHtml = `
            <div class="space-y-4">
                <div>
                    <label for="question-text" class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
                    <textarea id="question-text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" rows="3">${question.text}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Answer Options</label>
                    <div id="options-container" class="space-y-2">
        `;
        
        // Different options based on question type
        switch (question.type) {
            case 'multiple-choice':
                // Create 4 options by default
                for (let i = 0; i < Math.max(4, question.options.length); i++) {
                    const option = question.options[i] || { text: '', isCorrect: false };
                    editorHtml += `
                        <div class="flex items-center">
                            <input type="radio" name="correct-option" class="correct-option mr-2" ${option.isCorrect ? 'checked' : ''}>
                            <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="${option.text}" placeholder="Option ${i + 1}">
                            <button class="delete-option-btn ml-2 text-red-500 hover:text-red-700" title="Delete Option">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                }
                editorHtml += `
                    </div>
                    <button id="add-option-btn" class="mt-2 text-purple-primary hover:text-purple-dark text-sm">
                        <i class="fas fa-plus-circle mr-1"></i> Add Option
                    </button>
                `;
                break;
                
            case 'checkbox':
                // Create 4 options by default for checkbox
                for (let i = 0; i < Math.max(4, question.options.length); i++) {
                    const option = question.options[i] || { text: '', isCorrect: false };
                    editorHtml += `
                        <div class="flex items-center">
                            <input type="checkbox" class="correct-option mr-2" ${option.isCorrect ? 'checked' : ''}>
                            <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="${option.text}" placeholder="Option ${i + 1}">
                            <button class="delete-option-btn ml-2 text-red-500 hover:text-red-700" title="Delete Option">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                }
                editorHtml += `
                    </div>
                    <button id="add-option-btn" class="mt-2 text-purple-primary hover:text-purple-dark text-sm">
                        <i class="fas fa-plus-circle mr-1"></i> Add Option
                    </button>
                `;
                break;
                
            case 'true-false':
                // True/False has only 2 fixed options
                editorHtml += `
                        <div class="flex items-center">
                            <input type="radio" name="correct-option" class="correct-option mr-2" ${question.options[0]?.isCorrect ? 'checked' : ''}>
                            <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" value="True" readonly>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="correct-option" class="correct-option mr-2" ${question.options[1]?.isCorrect ? 'checked' : ''}>
                            <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" value="False" readonly>
                        </div>
                    </div>
                `;
                break;
                
            case 'short-answer':
                // Short answer has a single correct answer field
                editorHtml += `
                        <div class="flex items-center">
                            <input type="text" class="correct-answer flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="${question.correctAnswer || ''}" placeholder="Correct answer">
                        </div>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="case-sensitive form-checkbox h-4 w-4 text-purple-600" ${question.caseSensitive ? 'checked' : ''}>
                                <span class="ml-2 text-sm text-gray-700">Case sensitive</span>
                            </label>
                        </div>
                    </div>
                `;
                break;
        }
        
        // Add points field for all question types
        editorHtml += `
                <div>
                    <label for="question-points" class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                    <input type="number" id="question-points" class="w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" min="1" value="${question.points || 1}">
                </div>
            </div>
        `;
        
        // Set the HTML content
        editor.innerHTML = editorHtml;
        
        // Add event listeners for the editor
        setupEditorEventListeners(question);
    }
    
    // Set up event listeners for the question editor
    function setupEditorEventListeners(question) {
        // Question text
        const questionText = document.getElementById('question-text');
        if (questionText) {
            questionText.addEventListener('input', function() {
                question.text = this.value;
            });
        }
        
        // Question points
        const questionPoints = document.getElementById('question-points');
        if (questionPoints) {
            questionPoints.addEventListener('input', function() {
                question.points = parseInt(this.value) || 1;
            });
        }
        
        // Add option button
        const addOptionBtn = document.getElementById('add-option-btn');
        if (addOptionBtn) {
            addOptionBtn.addEventListener('click', function() {
                const optionsContainer = document.getElementById('options-container');
                const optionCount = optionsContainer.children.length;
                
                const optionDiv = document.createElement('div');
                optionDiv.className = 'flex items-center';
                
                if (question.type === 'multiple-choice') {
                    optionDiv.innerHTML = `
                        <input type="radio" name="correct-option" class="correct-option mr-2">
                        <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" placeholder="Option ${optionCount + 1}">
                        <button class="delete-option-btn ml-2 text-red-500 hover:text-red-700" title="Delete Option">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                } else if (question.type === 'checkbox') {
                    optionDiv.innerHTML = `
                        <input type="checkbox" class="correct-option mr-2">
                        <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" placeholder="Option ${optionCount + 1}">
                        <button class="delete-option-btn ml-2 text-red-500 hover:text-red-700" title="Delete Option">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                }
                
                optionsContainer.appendChild(optionDiv);
                
                // Add event listener for the new delete button
                const deleteBtn = optionDiv.querySelector('.delete-option-btn');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function() {
                        optionDiv.remove();
                        saveOptionsToQuestion(question);
                    });
                }
                
                // Add event listeners for the new inputs
                const correctOption = optionDiv.querySelector('.correct-option');
                const optionText = optionDiv.querySelector('.option-text');
                
                if (correctOption) {
                    correctOption.addEventListener('change', function() {
                        saveOptionsToQuestion(question);
                    });
                }
                
                if (optionText) {
                    optionText.addEventListener('input', function() {
                        saveOptionsToQuestion(question);
                    });
                }
                
                // Save the new options
                saveOptionsToQuestion(question);
            });
        }
        
        // Set up existing option event listeners
        setupOptionEventListeners(question);
        
        // Case sensitive checkbox for short answer
        const caseSensitive = document.querySelector('.case-sensitive');
        if (caseSensitive) {
            caseSensitive.addEventListener('change', function() {
                question.caseSensitive = this.checked;
            });
        }
        
        // Correct answer input for short answer
        const correctAnswer = document.querySelector('.correct-answer');
        if (correctAnswer) {
            correctAnswer.addEventListener('input', function() {
                question.correctAnswer = this.value;
            });
        }
    }
    
    // Set up event listeners for question options
    function setupOptionEventListeners(question) {
        // Delete option buttons
        const deleteOptionBtns = document.querySelectorAll('.delete-option-btn');
        deleteOptionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Don't allow deleting if there are only 2 options for true-false
                if (question.type === 'true-false') {
                    return;
                }
                
                this.closest('div').remove();
                saveOptionsToQuestion(question);
            });
        });
        
        // Correct option inputs
        const correctOptions = document.querySelectorAll('.correct-option');
        correctOptions.forEach(input => {
            input.addEventListener('change', function() {
                saveOptionsToQuestion(question);
            });
        });
        
        // Option text inputs
        const optionTexts = document.querySelectorAll('.option-text');
        optionTexts.forEach(input => {
            input.addEventListener('input', function() {
                saveOptionsToQuestion(question);
            });
        });
    }
    
    // Save options from the UI to the question object
    function saveOptionsToQuestion(question) {
        const options = [];
        const optionsContainer = document.getElementById('options-container');
        
        if (optionsContainer) {
            const optionElements = optionsContainer.querySelectorAll('.flex.items-center');
            
            optionElements.forEach((element, index) => {
                const correctOption = element.querySelector('.correct-option');
                const optionText = element.querySelector('.option-text');
                
                if (optionText) {
                    options.push({
                        text: optionText.value,
                        isCorrect: correctOption ? correctOption.checked : false,
                        order: index + 1
                    });
                }
            });
        }
        
        question.options = options;
    }
    
    // Delete a question
    function deleteQuestion(questionId) {
        if (confirm('Are you sure you want to delete this question?')) {
            window.questions = window.questions.filter(q => q.id !== questionId);
            updateQuestionList();
            updateQuestionCount();
            
            // Clear editor if the current question was deleted
            const editor = document.getElementById('question-editor');
            if (editor) {
                editor.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-edit text-3xl mb-2"></i>
                        <p>Select or add a question to start editing</p>
                    </div>
                `;
            }
        }
    }
    
    // Update the question count display
    function updateQuestionCount() {
        const countElement = document.getElementById('question-count');
        if (countElement) {
            const count = window.questions.length;
            countElement.textContent = `${count} question${count !== 1 ? 's' : ''}`;
        }
    }
    
    // Save all questions
    function saveQuestions() {
        const quizId = window.currentQuizId;
        if (!quizId) {
            window.showNotification('Quiz ID not found. Please try again.', 'error');
            return;
        }
        
        if (window.questions.length === 0) {
            window.showNotification('Please add at least one question to your quiz.', 'warning');
            return;
        }
        
        // Validate questions
        let isValid = true;
        let errorMessage = '';
        
        window.questions.forEach((question, index) => {
            if (!question.text.trim()) {
                isValid = false;
                errorMessage = `Question ${index + 1} is missing text.`;
                return;
            }
            
            if (question.type !== 'short-answer') {
                // Check if options exist and at least one is marked correct
                if (question.options.length === 0) {
                    isValid = false;
                    errorMessage = `Question ${index + 1} has no answer options.`;
                    return;
                }
                
                const hasCorrectOption = question.options.some(option => option.isCorrect);
                if (!hasCorrectOption) {
                    isValid = false;
                    errorMessage = `Question ${index + 1} has no correct answer selected.`;
                    return;
                }
            } else {
                // For short answer, check if correct answer is provided
                if (!question.correctAnswer || !question.correctAnswer.trim()) {
                    isValid = false;
                    errorMessage = `Question ${index + 1} is missing a correct answer.`;
                    return;
                }
            }
        });
        
        if (!isValid) {
            window.showNotification(errorMessage, 'error');
            return;
        }
        
        // Prepare data for saving
        const data = {
            quiz_id: quizId,
            questions: window.questions
        };
        
        // Show loading indicator
        document.getElementById('saveQuestionsBtn').innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        
        // Send AJAX request to save questions
        fetch('../../Controllers/quizController.php?action=saveQuestions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showNotification('Quiz questions saved successfully!', 'success');
                setTimeout(() => {
                    // Get the class ID from URL or from the form
                    const urlParams = new URLSearchParams(window.location.search);
                    const classId = urlParams.get('class_id') || window.currentClassId;
                    
                    // Redirect to the classDetails page with the class_id parameter
                    // Fix the path to avoid the duplicate "Contents" folder
                    window.location.href = `../../Contents/Tabs/classDetails.php?class_id=${classId}`;
                }, 1500);
            } else {
                window.showNotification(data.message || 'Failed to save questions', 'error');
                document.getElementById('saveQuestionsBtn').textContent = 'Save Quiz';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showNotification('An error occurred. Please try again.', 'error');
            document.getElementById('saveQuestionsBtn').textContent = 'Save Quiz';
        });
    }
    
    // Add predefined options for true/false questions
    function addTrueFalseOptions(question) {
        if (question.type === 'true-false' && question.options.length === 0) {
            question.options = [
                { text: 'True', isCorrect: false, order: 1 },
                { text: 'False', isCorrect: false, order: 2 }
            ];
        }
    }
</script>