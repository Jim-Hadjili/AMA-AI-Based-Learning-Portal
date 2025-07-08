/**
 * Quiz Editor JavaScript
 *
 * This file contains the functionality for the quiz editor interface
 */

// Global variables
let questions = [];
let currentQuestionId = null;
let hasUnsavedChanges = false;
let questionIdCounter = 0;

// Initialize the page
function initializeQuizEditor(existingQuestions, quizId, redirectUrl) {
  questions = existingQuestions;
  questionIdCounter = Math.max(
    ...questions.map((q) => parseInt(q.question_id) || 0),
    0
  );

  initializeQuestionsList();
  setupEventListeners(quizId, redirectUrl);
  updateQuestionCount();

  // Load first question if available
  if (questions.length > 0) {
    loadQuestionEditor(questions[0]);
  }
}

// Setup event listeners
function setupEventListeners(quizId, redirectUrl) {
  // Add question button
  document
    .getElementById("addQuestionBtn")
    .addEventListener("click", function () {
      addNewQuestion("multiple-choice");
    });

  // Question type buttons
  document.querySelectorAll(".question-type-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const type = this.getAttribute("data-type");
      addNewQuestion(type);
    });
  });

  // Save quiz button
  document.getElementById("saveQuizBtn").addEventListener("click", function () {
    saveQuiz(quizId, redirectUrl);
  });

  // Preview quiz button
  document
    .getElementById("previewQuizBtn")
    .addEventListener("click", function () {
      window.open(`previewQuiz.php?quiz_id=${quizId}`, "_blank");
    });

  // Quiz settings form changes
  document
    .getElementById("quizSettingsForm")
    .addEventListener("change", function () {
      hasUnsavedChanges = true;
    });

  // Warn before leaving with unsaved changes
  window.addEventListener("beforeunload", function (e) {
    if (hasUnsavedChanges) {
      e.preventDefault();
      e.returnValue = "";
    }
  });
}

// Initialize questions list
function initializeQuestionsList() {
  const questionsList = document.getElementById("questionsList");
  questionsList.innerHTML = "";

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

// Get question type icon
function getQuestionTypeIcon(type) {
  const icons = {
    "multiple-choice": { class: "fas fa-list-ul", color: "text-purple-500" },
    checkbox: { class: "fas fa-check-square", color: "text-blue-500" },
    "true-false": { class: "fas fa-toggle-on", color: "text-green-500" },
    "short-answer": { class: "fas fa-pen", color: "text-orange-500" },
  };
  return icons[type] || icons["multiple-choice"];
}

// Create question list item
function createQuestionListItem(question, number) {
  const div = document.createElement("div");
  div.className =
    "question-list-item p-3 rounded-md border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors";
  div.setAttribute("data-question-id", question.id);

  const icon = getQuestionTypeIcon(question.type);
  const preview = question.text
    ? question.text.substring(0, 50) + (question.text.length > 50 ? "..." : "")
    : "Untitled Question";

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
                <span class="text-xs text-gray-400">${question.points || 1} pt${
    (question.points || 1) !== 1 ? "s" : ""
  }</span>
                <button class="delete-question-btn text-red-400 hover:text-red-600 p-1" data-question-id="${
                  question.id
                }">
                    <i class="fas fa-trash-alt text-xs"></i>
                </button>
            </div>
        </div>
    `;

  // Add click event to load question
  div.addEventListener("click", function (e) {
    if (!e.target.closest(".delete-question-btn")) {
      loadQuestionEditor(question);
    }
  });

  // Add delete event
  const deleteBtn = div.querySelector(".delete-question-btn");
  deleteBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    deleteQuestion(question.id);
  });

  return div;
}
