/**
 * Question Operations JavaScript
 *
 * This file contains functions for duplicating, deleting, and updating questions
 */

// Duplicate question
function duplicateQuestion(question) {
  questionIdCounter++;
  const duplicatedQuestion = {
    ...JSON.parse(JSON.stringify(question)), // Deep copy
    id: `question_new_${questionIdCounter}`,
    question_id: null,
    order: questions.length + 1,
    text: question.text + " (Copy)",
  };

  questions.push(duplicatedQuestion);
  initializeQuestionsList();
  loadQuestionEditor(duplicatedQuestion);
  updateQuestionCount();
  hasUnsavedChanges = true;

  showNotification("Question duplicated successfully!", "success");
}

// Delete question
function deleteQuestion(questionId) {
  if (questions.length <= 1) {
    showNotification("A quiz must have at least one question.", "warning");
    return;
  }

  if (
    confirm(
      "Are you sure you want to delete this question? This action cannot be undone."
    )
  ) {
    const questionIndex = questions.findIndex((q) => q.id === questionId);
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
        const nextQuestion =
          questions[Math.min(questionIndex, questions.length - 1)];
        loadQuestionEditor(nextQuestion);
      } else {
        document.getElementById("questionEditor").innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-gray-500">
                        <i class="fas fa-edit text-4xl mb-4"></i>
                        <h4 class="text-lg font-medium mb-2">No Questions</h4>
                        <p class="text-center">Add a new question to get started.</p>
                    </div>
                `;
      }

      showNotification("Question deleted successfully!", "success");
    }
  }
}

// Update question in list
function updateQuestionInList(question) {
  const questionItem = document.querySelector(
    `[data-question-id="${question.id}"]`
  );
  if (questionItem) {
    const preview = question.text
      ? question.text.substring(0, 50) +
        (question.text.length > 50 ? "..." : "")
      : "Untitled Question";
    const previewElement = questionItem.querySelector(".text-xs.text-gray-500");
    const pointsElement = questionItem.querySelector(".text-xs.text-gray-400");

    if (previewElement) {
      previewElement.textContent = preview;
    }
    if (pointsElement) {
      pointsElement.textContent = `${question.points || 1} pt${
        (question.points || 1) !== 1 ? "s" : ""
      }`;
    }
  }
}

// Update question count
function updateQuestionCount() {
  const countElement = document.getElementById("questionCount");
  if (countElement) {
    countElement.textContent = questions.length;
  }
}
