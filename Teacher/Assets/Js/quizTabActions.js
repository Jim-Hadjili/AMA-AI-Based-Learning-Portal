document.addEventListener("DOMContentLoaded", function () {
  // Quiz menu toggles
  document.querySelectorAll(".quiz-menu-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.stopPropagation();
      const menu = this.nextElementSibling;

      // Close all other menus
      document.querySelectorAll(".quiz-menu").forEach((m) => {
        if (m !== menu) m.classList.add("hidden");
      });

      // Toggle current menu
      menu.classList.toggle("hidden");
    });
  });

  // Close menus when clicking outside
  document.addEventListener("click", function () {
    document.querySelectorAll(".quiz-menu").forEach((menu) => {
      menu.classList.add("hidden");
    });
  });

  // Quiz action handlers
  initializeDeleteQuizButtons();
  initializePublishQuizButtons();
  initializeDuplicateQuizButtons();
  initializeAddQuizButton();
  initializeDeleteQuizModal();
});

// Delete Quiz buttons now open the modal instead of using confirm()
function initializeDeleteQuizButtons() {
  document.querySelectorAll(".delete-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle;

      // Set the quiz title and quiz ID in the modal
      document.getElementById(
        "deleteQuizMessage"
      ).textContent = `Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`;

      // Store the quiz ID in the confirm button's data attribute
      document.getElementById("confirmDeleteQuizBtn").dataset.quizId = quizId;

      // Show the modal
      document.getElementById("deleteQuizModal").classList.remove("hidden");
    });
  });
}

// Initialize delete quiz modal
function initializeDeleteQuizModal() {
  const modal = document.getElementById("deleteQuizModal");
  const backdrop = document.getElementById("deleteQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelDeleteQuizBtn");
  const confirmBtn = document.getElementById("confirmDeleteQuizBtn");

  // Close modal function
  function closeModal() {
    modal.classList.add("hidden");
  }

  // Close on backdrop click
  if (backdrop) {
    backdrop.addEventListener("click", closeModal);
  }

  // Close on cancel button click
  if (cancelBtn) {
    cancelBtn.addEventListener("click", closeModal);
  }

  // Handle confirm delete
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;

      // Show loading state
      this.innerHTML =
        '<i class="fas fa-circle-notch fa-spin mr-2"></i> Deleting...';
      this.disabled = true;

      // Send AJAX request to delete the quiz
      fetch("../../Controllers/quizController.php?action=deleteQuiz", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "quiz_id=" + quizId,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show custom success notification
            showNotification(
              "success",
              "Quiz Deleted",
              data.message || "Quiz was successfully deleted.",
              5000
            );

            // Remove the quiz card from the DOM
            const quizCards = document.querySelectorAll(".quiz-card");
            quizCards.forEach((card) => {
              const deleteBtn = card.querySelector(
                `.delete-quiz-btn[data-quiz-id="${quizId}"]`
              );
              if (deleteBtn) {
                // Find the parent card to remove
                let parentCard = deleteBtn;
                while (
                  parentCard &&
                  !parentCard.classList.contains("quiz-card")
                ) {
                  parentCard = parentCard.parentNode;
                }
                if (parentCard) {
                  parentCard.remove();
                }
              }
            });

            // If we removed all quizzes, reload the page to show empty state
            const remainingCards = document.querySelectorAll(".quiz-card");
            if (remainingCards.length === 0) {
              window.location.reload();
            }

            // Close the modal
            closeModal();
          } else {
            // Show custom error notification
            showNotification(
              "error",
              "Delete Failed",
              data.message || "Failed to delete the quiz. Please try again.",
              8000
            );

            // Reset button
            confirmBtn.innerHTML = "Yes, Delete Quiz";
            confirmBtn.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);

          // Show custom error notification
          showNotification(
            "error",
            "Error",
            "An unexpected error occurred while trying to delete the quiz.",
            8000
          );

          // Reset button
          confirmBtn.innerHTML = "Yes, Delete Quiz";
          confirmBtn.disabled = false;
        });
    });
  }
}

function initializePublishQuizButtons() {
  document.querySelectorAll(".publish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      // Add your publish quiz logic here
      console.log("Publish quiz:", quizId);
    });
  });

  document.querySelectorAll(".unpublish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      // Add your unpublish quiz logic here
      console.log("Unpublish quiz:", quizId);
    });
  });
}

function initializeDuplicateQuizButtons() {
  document.querySelectorAll(".duplicate-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      // Add your duplicate quiz logic here
      console.log("Duplicate quiz:", quizId);
    });
  });
}

function initializeAddQuizButton() {
  const addQuizTabBtn = document.getElementById("addQuizTabBtn");
  if (addQuizTabBtn) {
    addQuizTabBtn.addEventListener("click", function () {
      // Call the global openAddQuizModal function
      if (typeof window.openAddQuizModal === "function") {
        window.openAddQuizModal();
      } else {
        // Fallback if the function isn't available
        document.getElementById("addQuizModal").classList.remove("hidden");
      }
    });
  }
}
