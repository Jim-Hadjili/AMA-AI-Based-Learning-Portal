// Toggle feedback sections
function toggleFeedback(questionId) {
  const feedbackDiv = document.getElementById(`feedback-${questionId}`);
  feedbackDiv.classList.toggle("hidden");
}

// Save feedback for a question
function saveFeedback(questionId) {
  const textarea = document.querySelector(`#feedback-${questionId} textarea`);
  const feedback = textarea.value.trim();

  if (feedback) {
    // Here you would typically send an AJAX request to save the feedback
    console.log(`Saving feedback for question ${questionId}: ${feedback}`);

    // Show success message
    showNotification("Feedback saved successfully!", "success");

    // Hide feedback section
    toggleFeedback(questionId);
  } else {
    showNotification("Please enter feedback before saving.", "warning");
  }
}

// Flag question for review
function flagQuestion(questionId) {
  // Here you would typically send an AJAX request to flag the question
  console.log(`Flagging question ${questionId} for review`);
  showNotification("Question flagged for review.", "info");
}

// Export to PDF
function exportToPDF() {
  window.print();
}

// Show notification
function showNotification(message, type = "info") {
  const colors = {
    success: "bg-green-500",
    error: "bg-red-500",
    warning: "bg-yellow-500",
    info: "bg-blue-500",
  };

  const notification = document.createElement("div");
  notification.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
  notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${
                      type === "success"
                        ? "check"
                        : type === "error"
                        ? "times"
                        : type === "warning"
                        ? "exclamation"
                        : "info"
                    } mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

  document.body.appendChild(notification);

  // Animate in
  setTimeout(() => {
    notification.style.transform = "translateX(0)";
  }, 100);

  // Auto remove
  setTimeout(() => {
    notification.style.transform = "translateX(100%)";
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }, 3000);
}

// Initialize animations on page load
document.addEventListener("DOMContentLoaded", function () {
  // Animate progress rings
  const progressRings = document.querySelectorAll(".progress-ring-circle");
  progressRings.forEach((ring) => {
    const circumference = 2 * Math.PI * 56;
    ring.style.strokeDasharray = circumference;
  });
});
