document.addEventListener("DOMContentLoaded", function () {
  // Initialize modal functionality
  initQuizMenuToggle();
  initDeleteQuizModal();
  initPublishQuizModal();
  initUnpublishQuizModal();
  initNoQuestionsWarningModal();

  // Connect the empty state "Create Your First Quiz" button
  const addQuizTabBtn = document.getElementById("addQuizTabBtn");
  if (addQuizTabBtn) {
    addQuizTabBtn.addEventListener("click", function () {
      // Directly call openAddQuizModal without checking if it exists first
      openAddQuizModal();
    });
  }
});

// Toggle dropdown menu for quiz actions
function initQuizMenuToggle() {
  const menuButtons = document.querySelectorAll(".quiz-menu-btn");

  menuButtons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.stopPropagation();

      // Close all other menus first
      document.querySelectorAll(".quiz-menu").forEach((menu) => {
        if (menu !== this.nextElementSibling) {
          menu.classList.add("hidden");
        }
      });

      // Toggle this menu
      const menu = this.nextElementSibling;
      menu.classList.toggle("hidden");
    });
  });

  // Close menus when clicking elsewhere
  document.addEventListener("click", function () {
    document.querySelectorAll(".quiz-menu").forEach((menu) => {
      menu.classList.add("hidden");
    });
  });
}

// Delete quiz modal functionality
function initDeleteQuizModal() {
  const modal = document.getElementById("deleteQuizModal");
  if (!modal) return;

  const backdrop = document.getElementById("deleteQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelDeleteQuizBtn");
  const confirmBtn = document.getElementById("confirmDeleteQuizBtn");

  // Open delete modal
  document.querySelectorAll(".delete-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle || "this quiz";

      // Set modal content
      document.getElementById(
        "deleteQuizMessage"
      ).textContent = `Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`;

      // Store quiz ID for confirmation
      confirmBtn.dataset.quizId = quizId;

      // Show modal
      modal.classList.remove("hidden");
    });
  });

  // Close modal handlers
  if (backdrop) backdrop.addEventListener("click", () => closeModal(modal));
  if (cancelBtn) cancelBtn.addEventListener("click", () => closeModal(modal));

  // Handle delete confirmation
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;

      // Show loading state
      this.innerHTML =
        '<i class="fas fa-circle-notch fa-spin mr-2"></i> Deleting...';
      this.disabled = true;

      // Send delete request
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
            // Show success notification
            showNotification("Quiz deleted successfully", "success");

            // Remove quiz card from DOM
            const quizCard = document.querySelector(
              `.quiz-card[data-quiz-id="${quizId}"]`
            );
            if (quizCard) {
              quizCard.classList.add("animate-fadeOut");
              setTimeout(() => {
                quizCard.remove();

                // Check if no quizzes remain
                const remainingCards = document.querySelectorAll(".quiz-card");
                if (remainingCards.length === 0) {
                  location.reload(); // Reload to show empty state
                }
              }, 300);
            }

            closeModal(modal);
          } else {
            // Show error notification
            showNotification(data.message || "Failed to delete quiz", "error");

            // Reset button
            this.innerHTML = "Yes, Delete Quiz";
            this.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showNotification("An error occurred. Please try again.", "error");

          // Reset button
          this.innerHTML = "Yes, Delete Quiz";
          this.disabled = false;
        });
    });
  }
}

// Publish quiz modal functionality
function initPublishQuizModal() {
  const modal = document.getElementById("publishQuizModal");
  if (!modal) return;

  const backdrop = document.getElementById("publishQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelPublishQuizBtn");
  const confirmBtn = document.getElementById("confirmPublishQuizBtn");

  // Open publish modal
  document.querySelectorAll(".publish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle || "this quiz";
      const questionCount = parseInt(this.dataset.questionCount || "0");

      // Check if quiz has questions
      if (questionCount === 0) {
        showNoQuestionsWarningModal(quizId);
        return;
      }

      // Set modal content
      document.getElementById(
        "publishQuizMessage"
      ).textContent = `Are you sure you want to publish "${quizTitle}"? Students will be able to see and take this quiz.`;

      // Store quiz ID for confirmation
      confirmBtn.dataset.quizId = quizId;

      // Show modal
      modal.classList.remove("hidden");
    });
  });

  // Close modal handlers
  if (backdrop) backdrop.addEventListener("click", () => closeModal(modal));
  if (cancelBtn) cancelBtn.addEventListener("click", () => closeModal(modal));

  // Handle publish confirmation
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;

      // Show loading state
      this.innerHTML =
        '<i class="fas fa-circle-notch fa-spin mr-2"></i> Publishing...';
      this.disabled = true;

      // Send publish request
      fetch("../../Controllers/quizController.php?action=publishQuiz", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "quiz_id=" + quizId,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success notification
            showNotification("Quiz published successfully", "success");

            // Update quiz status in DOM
            updateQuizStatus(quizId, "published");

            closeModal(modal);
          } else {
            // Show error notification
            showNotification(data.message || "Failed to publish quiz", "error");

            // Reset button
            this.innerHTML = "Yes, Publish Quiz";
            this.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showNotification("An error occurred. Please try again.", "error");

          // Reset button
          this.innerHTML = "Yes, Publish Quiz";
          this.disabled = false;
        });
    });
  }
}

// Unpublish quiz modal functionality
function initUnpublishQuizModal() {
  const modal = document.getElementById("unpublishQuizModal");
  if (!modal) return;

  const backdrop = document.getElementById("unpublishQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelUnpublishQuizBtn");
  const confirmBtn = document.getElementById("confirmUnpublishQuizBtn");

  // Open unpublish modal
  document.querySelectorAll(".unpublish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle || "this quiz";

      // Set modal content
      document.getElementById(
        "unpublishQuizMessage"
      ).textContent = `Are you sure you want to unpublish "${quizTitle}"? Students will no longer be able to access it.`;

      // Store quiz ID for confirmation
      confirmBtn.dataset.quizId = quizId;

      // Show modal
      modal.classList.remove("hidden");
    });
  });

  // Close modal handlers
  if (backdrop) backdrop.addEventListener("click", () => closeModal(modal));
  if (cancelBtn) cancelBtn.addEventListener("click", () => closeModal(modal));

  // Handle unpublish confirmation
  if (confirmBtn) {
    confirmBtn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;

      // Show loading state
      this.innerHTML =
        '<i class="fas fa-circle-notch fa-spin mr-2"></i> Unpublishing...';
      this.disabled = true;

      // Send unpublish request
      fetch("../../Controllers/quizController.php?action=unpublishQuiz", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "quiz_id=" + quizId,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success notification
            showNotification("Quiz unpublished successfully", "success");

            // Update quiz status in DOM
            updateQuizStatus(quizId, "draft");

            closeModal(modal);
          } else {
            // Show error notification
            showNotification(
              data.message || "Failed to unpublish quiz",
              "error"
            );

            // Reset button
            this.innerHTML = "Yes, Unpublish Quiz";
            this.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showNotification("An error occurred. Please try again.", "error");

          // Reset button
          this.innerHTML = "Yes, Unpublish Quiz";
          this.disabled = false;
        });
    });
  }
}

// No questions warning modal
function initNoQuestionsWarningModal() {
  const modal = document.getElementById("noQuestionsWarningModal");
  if (!modal) return;

  const backdrop = document.getElementById("noQuestionsWarningModalBackdrop");
  const closeBtn = document.getElementById("closeWarningBtn");
  const addQuestionsBtn = document.getElementById("addQuestionsBtn");

  // Close modal handlers
  if (backdrop) backdrop.addEventListener("click", () => closeModal(modal));
  if (closeBtn) closeBtn.addEventListener("click", () => closeModal(modal));
}

function showNoQuestionsWarningModal(quizId) {
  const modal = document.getElementById("noQuestionsWarningModal");
  const addQuestionsBtn = document.getElementById("addQuestionsBtn");

  if (modal && addQuestionsBtn) {
    // Update add questions button link
    addQuestionsBtn.href = `../Quiz/editQuiz.php?quiz_id=${quizId}&section=questions`;

    // Show modal
    modal.classList.remove("hidden");
  } else {
    // Fallback notification
    showNotification("Quiz cannot be published: No questions added", "warning");
  }
}

// Helper function to close any modal
function closeModal(modal) {
  if (modal) modal.classList.add("hidden");
}

// Helper function to update quiz status in DOM
function updateQuizStatus(quizId, newStatus) {
  const quizCard = document.querySelector(
    `.quiz-card[data-quiz-id="${quizId}"]`
  );
  if (!quizCard) return;

  // Update status badge
  const statusBadge = quizCard.querySelector(".quiz-status");
  if (statusBadge) {
    if (newStatus === "published") {
      statusBadge.innerHTML =
        '<i class="fas fa-check-circle mr-1"></i> Published';
      statusBadge.className =
        "quiz-status px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800";
    } else {
      statusBadge.innerHTML = '<i class="fas fa-pencil-alt mr-1"></i> Draft';
      statusBadge.className =
        "quiz-status px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800";
    }
  }

  // Update action menu buttons (replace the publish button with unpublish or vice versa)
  const publishBtn = quizCard.querySelector(".publish-quiz-btn");
  const unpublishBtn = quizCard.querySelector(".unpublish-quiz-btn");

  if (newStatus === "published" && publishBtn) {
    const menuContainer = publishBtn.closest(".py-1");
    if (menuContainer) {
      // Create new unpublish button
      const newBtn = document.createElement("button");
      newBtn.className =
        "unpublish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center";
      newBtn.dataset.quizId = quizId;
      newBtn.dataset.quizTitle = publishBtn.dataset.quizTitle || "";
      newBtn.innerHTML =
        '<i class="fas fa-pause mr-2 text-yellow-500"></i> Unpublish';

      // Replace publish button with unpublish button
      menuContainer.replaceChild(newBtn, publishBtn);

      // Add event listener to the new button
      newBtn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const quizId = this.dataset.quizId;
        const quizTitle = this.dataset.quizTitle || "this quiz";

        // Set modal content
        document.getElementById(
          "unpublishQuizMessage"
        ).textContent = `Are you sure you want to unpublish "${quizTitle}"? Students will no longer be able to access it.`;

        // Store quiz ID for confirmation
        document.getElementById("confirmUnpublishQuizBtn").dataset.quizId =
          quizId;

        // Show modal
        document
          .getElementById("unpublishQuizModal")
          .classList.remove("hidden");
      });
    }
  } else if (newStatus === "draft" && unpublishBtn) {
    const menuContainer = unpublishBtn.closest(".py-1");
    if (menuContainer) {
      // Create new publish button
      const newBtn = document.createElement("button");
      newBtn.className =
        "publish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center";
      newBtn.dataset.quizId = quizId;
      newBtn.dataset.quizTitle = unpublishBtn.dataset.quizTitle || "";
      newBtn.dataset.questionCount = "1"; // Assume at least 1 question (since it was published before)
      newBtn.innerHTML =
        '<i class="fas fa-paper-plane mr-2 text-green-500"></i> Publish Quiz';

      // Replace unpublish button with publish button
      menuContainer.replaceChild(newBtn, unpublishBtn);

      // Add event listener to the new button
      newBtn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const quizId = this.dataset.quizId;
        const quizTitle = this.dataset.quizTitle || "this quiz";

        // Set modal content
        document.getElementById(
          "publishQuizMessage"
        ).textContent = `Are you sure you want to publish "${quizTitle}"? Students will be able to see and take this quiz.`;

        // Store quiz ID for confirmation
        document.getElementById("confirmPublishQuizBtn").dataset.quizId =
          quizId;

        // Show modal
        document.getElementById("publishQuizModal").classList.remove("hidden");
      });
    }
  }

  // Optionally reload the page after a delay to refresh any counts
  setTimeout(() => {
    //window.location.reload();
  }, 1500);
}

// Function to show notifications (in case notificationUtils.js isn't loaded)
function showNotification(message, type = "info") {
  if (window.showNotification) {
    window.showNotification(message, type);
  } else {
    // Fallback notification
    const container =
      document.getElementById("notification-container") || document.body;
    const notification = document.createElement("div");

    // Apply styles based on type
    let bgColor = "bg-blue-600";
    if (type === "success") bgColor = "bg-green-600";
    if (type === "error") bgColor = "bg-red-600";
    if (type === "warning") bgColor = "bg-yellow-500";

    notification.className = `fixed bottom-4 right-4 p-4 rounded-md shadow-lg text-white ${bgColor} animate-fadeIn`;
    notification.innerHTML = message;

    container.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
      notification.classList.replace("animate-fadeIn", "animate-fadeOut");
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification);
        }
      }, 300);
    }, 5000);
  }
}

// Add a local implementation of openAddQuizModal in case the global one is not available
function openAddQuizModal() {
  const modal = document.getElementById("addQuizModal");
  if (modal) {
    modal.classList.remove("hidden");
  } else {
    console.error("Add Quiz Modal not found in the DOM");
  }
}
