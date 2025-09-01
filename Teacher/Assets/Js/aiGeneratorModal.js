// Show modal when AI Generator button is clicked
document.addEventListener("DOMContentLoaded", function () {
  const aiQuizBtn = document.getElementById("aiQuizBtn");
  if (aiQuizBtn) {
    aiQuizBtn.addEventListener("click", function () {
      document
        .getElementById("aiQuizGeneratorModal")
        .classList.remove("hidden");
    });
  }
});

// Close modal function
function closeAIQuizGeneratorModal() {
  document.getElementById("aiQuizGeneratorModal").classList.add("hidden");
}

// Show/hide loading modal helpers
function showAIQuizLoadingModal() {
  document.getElementById("aiQuizLoadingModal").classList.remove("hidden");
}
function hideAIQuizLoadingModal() {
  document.getElementById("aiQuizLoadingModal").classList.add("hidden");
}

function showAIQuizFailedModal() {
  document.getElementById("aiQuizFailedModal").classList.remove("hidden");
}
function closeAIQuizFailedModal() {
  document.getElementById("aiQuizFailedModal").classList.add("hidden");
}

// Handle form submission (AJAX to your AI quiz generation endpoint)
document
  .getElementById("aiQuizGeneratorForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    showAIQuizLoadingModal();

    fetch("../../Controllers/aiQuizGeneratorController.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        hideAIQuizLoadingModal();
        if (data.success) {
          closeAIQuizGeneratorModal();
          if (typeof window.showNotification === "function") {
            window.showNotification(
              "AI Quiz generated successfully!",
              "success"
            );
          }
          // Redirect to preview page
          window.location.href = `../Quiz/previewQuiz.php?quiz_id=${data.quiz_id}`;
        } else {
          showAIQuizFailedModal();
          if (typeof window.showNotification === "function") {
            window.showNotification(
              data.message || "Failed to generate quiz",
              "error"
            );
          }
        }
      })
      .catch(() => {
        hideAIQuizLoadingModal();
        showAIQuizFailedModal();
        if (typeof window.showNotification === "function") {
          window.showNotification(
            "An error occurred. Please try again.",
            "error"
          );
        }
      });
  });
