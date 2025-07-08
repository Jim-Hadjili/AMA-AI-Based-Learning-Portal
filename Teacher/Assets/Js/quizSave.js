/**
 * Quiz Save JavaScript
 *
 * This file contains functions for saving quizzes and showing notifications
 */

// Save quiz
function saveQuiz(quizId, redirectUrl) {
  const saveBtn = document.getElementById("saveQuizBtn");
  const originalText = saveBtn.innerHTML;

  // Validate questions
  if (questions.length === 0) {
    showNotification(
      "Please add at least one question to your quiz.",
      "warning"
    );
    return;
  }

  let isValid = true;
  let errorMessage = "";

  questions.forEach((question, index) => {
    if (!question.text.trim()) {
      isValid = false;
      errorMessage = `Question ${index + 1} is missing text.`;
      return;
    }

    if (question.type !== "short-answer") {
      const hasCorrectOption = question.options.some(
        (option) => option.isCorrect
      );
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
    showNotification(errorMessage, "error");
    return;
  }

  // Show loading state
  saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
  saveBtn.disabled = true;

  // Prepare data
  const quizSettings = new FormData(
    document.getElementById("quizSettingsForm")
  );
  const data = {
    quiz_id: quizId,
    quiz_settings: Object.fromEntries(quizSettings),
    questions: questions,
  };

  // Send AJAX request
  fetch("../../Controllers/quizController.php?action=updateQuiz", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        hasUnsavedChanges = false;
        showNotification("Quiz updated successfully!", "success");

        // Update question IDs for new questions
        if (data.question_mappings) {
          Object.entries(data.question_mappings).forEach(([tempId, realId]) => {
            const question = questions.find((q) => q.id === tempId);
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
          window.location.href = redirectUrl;
        }, 1500); // 1.5 seconds delay to show the success message
      } else {
        showNotification(data.message || "Failed to update quiz", "error");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showNotification("An error occurred while saving the quiz.", "error");
    })
    .finally(() => {
      saveBtn.innerHTML = originalText;
      saveBtn.disabled = false;
    });
}

// Show notification
function showNotification(message, type = "info") {
  const container = document.getElementById("notification-container");
  const notification = document.createElement("div");
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
    notification.classList.add("show");
  }, 100);

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentElement) {
      notification.classList.remove("show");
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 300);
    }
  }, 5000);
}
