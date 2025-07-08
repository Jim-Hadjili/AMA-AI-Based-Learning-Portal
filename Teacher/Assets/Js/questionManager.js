/**
 * Question Manager JavaScript
 *
 * This file contains functions for adding, editing, and deleting questions
 */

// Add new question
function addNewQuestion(type) {
  questionIdCounter++;
  const newQuestion = {
    id: `question_new_${questionIdCounter}`,
    question_id: null, // Will be assigned when saved
    type: type,
    text: "",
    points: 1,
    order: questions.length + 1,
    options:
      type === "true-false"
        ? [
            { text: "True", isCorrect: false, order: 1 },
            { text: "False", isCorrect: false, order: 2 },
          ]
        : type === "short-answer"
        ? []
        : [
            { text: "", isCorrect: false, order: 1 },
            { text: "", isCorrect: false, order: 2 },
            { text: "", isCorrect: false, order: 3 },
            { text: "", isCorrect: false, order: 4 },
          ],
    correctAnswer: type === "short-answer" ? "" : undefined,
    caseSensitive: type === "short-answer" ? false : undefined,
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
  document.querySelectorAll(".question-list-item").forEach((item) => {
    item.classList.remove("active");
    if (item.getAttribute("data-question-id") === question.id) {
      item.classList.add("active");
    }
  });

  const editor = document.getElementById("questionEditor");
  editor.innerHTML = createQuestionEditorHTML(question);
  setupQuestionEditorEvents(question);
}

// Create question editor HTML
function createQuestionEditorHTML(question) {
  let optionsHTML = "";

  if (question.type === "short-answer") {
    optionsHTML = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                    <input type="text" id="correctAnswer" value="${
                      question.correctAnswer || ""
                    }" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                           placeholder="Enter the correct answer">
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" id="caseSensitive" ${
                          question.caseSensitive ? "checked" : ""
                        } 
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Case sensitive</span>
                    </label>
                </div>
            </div>
        `;
  } else {
    const inputType =
      question.type === "multiple-choice" ? "radio" : "checkbox";
    const inputName =
      question.type === "multiple-choice" ? "correct-option" : "";

    optionsHTML = `
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-700">Answer Options</label>
                    ${
                      question.type !== "true-false"
                        ? `
                        <button type="button" id="addOptionBtn" class="text-sm text-purple-600 hover:text-purple-700">
                            <i class="fas fa-plus-circle mr-1"></i>Add Option
                        </button>
                    `
                        : ""
                    }
                </div>
                <div id="optionsContainer" class="space-y-2">
        `;

    question.options.forEach((option, index) => {
      const isReadonly = question.type === "true-false" ? "readonly" : "";
      const canDelete =
        question.type !== "true-false" && question.options.length > 2;

      optionsHTML += `
                <div class="option-item flex items-center space-x-3 p-3 border border-gray-200 rounded-md">
                    <input type="${inputType}" name="${inputName}" class="correct-option" ${
        option.isCorrect ? "checked" : ""
      }>
                    <input type="text" class="option-text flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 ${
                      isReadonly ? "bg-gray-50" : ""
                    }" 
                           value="${option.text}" placeholder="Option ${
        index + 1
      }" ${isReadonly}>
                    ${
                      canDelete
                        ? `
                        <button type="button" class="delete-option-btn text-red-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `
                        : ""
                    }
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
                    ${
                      getQuestionTypeIcon(question.type).class
                        ? `<i class="${
                            getQuestionTypeIcon(question.type).class
                          } ${
                            getQuestionTypeIcon(question.type).color
                          } mr-2"></i>`
                        : ""
                    }
                    ${question.type
                      .replace("-", " ")
                      .replace(/\b\w/g, (l) => l.toUpperCase())} Question
                </h4>
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-700">Points:</label>
                    <input type="number" id="questionPoints" min="1" value="${
                      question.points || 1
                    }" 
                           class="w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            
            <div>
                <label for="questionText" class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                <textarea id="questionText" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                          placeholder="Enter your question here...">${
                            question.text
                          }</textarea>
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
