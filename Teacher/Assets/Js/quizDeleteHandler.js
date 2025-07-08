document.addEventListener("DOMContentLoaded", function () {
  // Initialize the delete quiz modal functionality
  initDeleteQuizModal();
});

function initDeleteQuizModal() {
  const modal = document.getElementById("deleteQuizModal");
  const backdrop = document.getElementById("deleteQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelDeleteQuizBtn");
  const confirmBtn = document.getElementById("confirmDeleteQuizBtn");

  // Set up open modal buttons
  document.querySelectorAll(".open-delete-modal-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle;

      // Set the quiz title in the modal message
      document.getElementById(
        "deleteQuizMessage"
      ).textContent = `Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`;

      // Store the quiz ID in the confirm button
      confirmBtn.dataset.quizId = quizId;

      // Show modal
      modal.classList.remove("hidden");
    });
  });

  // Close modal when clicking the backdrop
  if (backdrop) {
    backdrop.addEventListener("click", closeModal);
  }

  // Close modal when clicking cancel button
  if (cancelBtn) {
    cancelBtn.addEventListener("click", closeModal);
  }

  // Handle delete confirmation
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;

      // Show loading state
      this.innerHTML =
        '<i class="fas fa-circle-notch fa-spin mr-2"></i> Deleting...';
      this.disabled = true;

      // Send AJAX request to delete the quiz
      fetch(
        "../../../Teacher/Controllers/quizController.php?action=deleteQuiz",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "quiz_id=" + quizId,
        }
      )
        .then((response) => {
          console.log("Delete Response Status:", response.status);
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            // Show success notification
            window.showNotification("Quiz deleted successfully!", "success");

            // Remove the quiz card from DOM
            const quizCard = document.querySelector(
              `.quiz-card[data-quiz-id="${quizId}"]`
            );
            if (quizCard) {
              quizCard.remove();
            }

            // If no quizzes left, reload the page to show empty state
            const remainingCards = document.querySelectorAll(".quiz-card");
            if (remainingCards.length === 0) {
              setTimeout(() => {
                window.location.reload();
              }, 1500);
            }

            // Close modal
            closeModal();
          } else {
            // Show error notification
            window.showNotification(
              data.message || "Failed to delete quiz",
              "error"
            );

            // Reset button
            this.innerHTML = "Yes, Delete Quiz";
            this.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          window.showNotification(
            "An error occurred. Please try again.",
            "error"
          );

          // Reset button
          this.innerHTML = "Yes, Delete Quiz";
          this.disabled = false;
        });
    });
  }

  function closeModal() {
    modal.classList.add("hidden");
  }
}
