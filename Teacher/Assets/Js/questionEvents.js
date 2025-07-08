/**
 * Question Events JavaScript
 *
 * This file contains event handlers for the question editor
 */

// Setup question editor events
function setupQuestionEditorEvents(question) {
  // Question text
  const questionText = document.getElementById("questionText");
  questionText.addEventListener("input", function () {
    question.text = this.value;
    hasUnsavedChanges = true;
    updateQuestionInList(question);
  });

  // Question points
  const questionPoints = document.getElementById("questionPoints");
  questionPoints.addEventListener("input", function () {
    question.points = parseInt(this.value) || 1;
    hasUnsavedChanges = true;
    updateQuestionInList(question);
  });

  // Handle different question types
  if (question.type === "short-answer") {
    const correctAnswer = document.getElementById("correctAnswer");
    const caseSensitive = document.getElementById("caseSensitive");

    correctAnswer.addEventListener("input", function () {
      question.correctAnswer = this.value;
      hasUnsavedChanges = true;
    });

    caseSensitive.addEventListener("change", function () {
      question.caseSensitive = this.checked;
      hasUnsavedChanges = true;
    });
  } else {
    // Options handling
    setupOptionsEvents(question);

    // Add option button
    const addOptionBtn = document.getElementById("addOptionBtn");
    if (addOptionBtn) {
      addOptionBtn.addEventListener("click", function () {
        addOption(question);
      });
    }
  }

  // Duplicate question button
  const duplicateBtn = document.getElementById("duplicateQuestionBtn");
  duplicateBtn.addEventListener("click", function () {
    duplicateQuestion(question);
  });

  // Delete question button
  const deleteBtn = document.getElementById("deleteQuestionBtn");
  deleteBtn.addEventListener("click", function () {
    deleteQuestion(question.id);
  });
}

// Setup options events
function setupOptionsEvents(question) {
  const correctOptions = document.querySelectorAll(".correct-option");
  const optionTexts = document.querySelectorAll(".option-text");
  const deleteButtons = document.querySelectorAll(".delete-option-btn");

  correctOptions.forEach((input, index) => {
    input.addEventListener("change", function () {
      if (question.type === "multiple-choice") {
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
    input.addEventListener("input", function () {
      if (question.options[index]) {
        question.options[index].text = this.value;
        hasUnsavedChanges = true;
      }
    });
  });

  deleteButtons.forEach((btn, index) => {
    btn.addEventListener("click", function () {
      deleteOption(question, index);
    });
  });
}

// Add option
function addOption(question) {
  const newOption = {
    text: "",
    isCorrect: false,
    order: question.options.length + 1,
  };

  question.options.push(newOption);
  loadQuestionEditor(question);
  hasUnsavedChanges = true;
}

// Delete option
function deleteOption(question, index) {
  if (question.options.length <= 2) {
    showNotification("A question must have at least 2 options.", "warning");
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
