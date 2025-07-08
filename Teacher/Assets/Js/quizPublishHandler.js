document.addEventListener("DOMContentLoaded", function () {
  // Initialize the publish and unpublish quiz modal functionality
  initPublishQuizModal();
  initUnpublishQuizModal();
  initNoQuestionsWarningModal();
});

function initPublishQuizModal() {
  const modal = document.getElementById("publishQuizModal");
  const backdrop = document.getElementById("publishQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelPublishQuizBtn");
  const confirmBtn = document.getElementById("confirmPublishQuizBtn");

  if (!modal || !confirmBtn) return;

  // Set up open modal buttons
  document.querySelectorAll(".publish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle || "this quiz";
      const questionCount = parseInt(this.dataset.questionCount || "0");

      // Check if quiz has questions
      if (questionCount === 0) {
        // Show warning modal instead
        showNoQuestionsWarningModal(quizId);
        return;
      }

      // Set the quiz title in the modal message if available
      if (quizTitle) {
        document.getElementById(
          "publishQuizMessage"
        ).textContent = `Are you sure you want to publish "${quizTitle}"? Students will be able to see and take this quiz.`;
      }

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

  // Handle publish confirmation
  confirmBtn.addEventListener("click", function () {
    const quizId = this.dataset.quizId;

    // Show loading state
    this.innerHTML =
      '<i class="fas fa-circle-notch fa-spin mr-2"></i> Publishing...';
    this.disabled = true;

    // Send AJAX request to publish the quiz
    fetch(
      "../../../Teacher/Controllers/quizController.php?action=publishQuiz",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "quiz_id=" + quizId,
      }
    )
      .then((response) => {
        console.log("Publish Response Status:", response.status);
        return response.json();
      })
      .then((data) => {
        console.log("Publish Response Data:", data);
        if (data.success) {
          // Show success notification
          window.showNotification("Quiz published successfully!", "success");

          // Update the quiz card to reflect published status
          updateQuizCardStatus(quizId, "published");

          // Close modal
          closeModal();

          // Reload the page if needed to refresh counters
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        } else {
          // Show error notification
          window.showNotification(
            data.message || "Failed to publish quiz",
            "error"
          );

          // Reset button
          this.innerHTML = "Yes, Publish Quiz";
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
        this.innerHTML = "Yes, Publish Quiz";
        this.disabled = false;
      });
  });

  function closeModal() {
    modal.classList.add("hidden");
  }
}

function initUnpublishQuizModal() {
  const modal = document.getElementById("unpublishQuizModal");
  const backdrop = document.getElementById("unpublishQuizModalBackdrop");
  const cancelBtn = document.getElementById("cancelUnpublishQuizBtn");
  const confirmBtn = document.getElementById("confirmUnpublishQuizBtn");

  if (!modal || !confirmBtn) return;

  // Set up open modal buttons
  document.querySelectorAll(".unpublish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle || "this quiz";

      // Set the quiz title in the modal message if available
      if (quizTitle) {
        document.getElementById(
          "unpublishQuizMessage"
        ).textContent = `Are you sure you want to unpublish "${quizTitle}"? Students will no longer be able to access it.`;
      }

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

  // Handle unpublish confirmation
  confirmBtn.addEventListener("click", function () {
    const quizId = this.dataset.quizId;

    // Show loading state
    this.innerHTML =
      '<i class="fas fa-circle-notch fa-spin mr-2"></i> Unpublishing...';
    this.disabled = true;

    // Send AJAX request to unpublish the quiz
    fetch(
      "../../../Teacher/Controllers/quizController.php?action=unpublishQuiz",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "quiz_id=" + quizId,
      }
    )
      .then((response) => {
        console.log("Unpublish Response Status:", response.status);
        return response.json();
      })
      .then((data) => {
        console.log("Unpublish Response Data:", data);
        if (data.success) {
          // Show success notification
          window.showNotification("Quiz unpublished successfully!", "success");

          // Update the quiz card to reflect unpublished status
          updateQuizCardStatus(quizId, "draft");

          // Close modal
          closeModal();

          // Reload the page if needed to refresh counters
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        } else {
          // Show error notification
          window.showNotification(
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
        window.showNotification(
          "An error occurred. Please try again.",
          "error"
        );

        // Reset button
        this.innerHTML = "Yes, Unpublish Quiz";
        this.disabled = false;
      });
  });

  function closeModal() {
    modal.classList.add("hidden");
  }
}

function initNoQuestionsWarningModal() {
  const modal = document.getElementById("noQuestionsWarningModal");
  const backdrop = document.getElementById("noQuestionsWarningModalBackdrop");
  const closeBtn = document.getElementById("closeWarningBtn");
  const addQuestionsBtn = document.getElementById("addQuestionsBtn");

  if (!modal) return;

  // Close modal when clicking the backdrop
  if (backdrop) {
    backdrop.addEventListener("click", closeWarningModal);
  }

  // Close modal when clicking close button
  if (closeBtn) {
    closeBtn.addEventListener("click", closeWarningModal);
  }

  // Add questions button action
  if (addQuestionsBtn) {
    addQuestionsBtn.addEventListener("click", function (e) {
      e.preventDefault();

      const quizId = this.dataset.quizId;
      if (quizId) {
        // Redirect to edit quiz page
        window.location.href = `../Quiz/editQuiz.php?quiz_id=${quizId}&section=questions`;
      }

      closeWarningModal();
    });
  }

  function closeWarningModal() {
    modal.classList.add("hidden");
  }
}

function showNoQuestionsWarningModal(quizId) {
  const modal = document.getElementById("noQuestionsWarningModal");
  const addQuestionsBtn = document.getElementById("addQuestionsBtn");

  if (modal && addQuestionsBtn) {
    // Set the quiz ID in the add questions button
    addQuestionsBtn.dataset.quizId = quizId;
    addQuestionsBtn.href = `../Quiz/editQuiz.php?quiz_id=${quizId}&section=questions`;

    // Show modal
    modal.classList.remove("hidden");
  } else {
    // Fallback if modal elements aren't found
    window.showNotification(
      "Cannot publish quiz: No questions have been added",
      "warning"
    );
  }
}

// Helper function to update the UI after publishing/unpublishing
function updateQuizCardStatus(quizId, newStatus) {
  const quizCard = document.querySelector(
    `.quiz-card[data-quiz-id="${quizId}"]`
  );
  if (!quizCard) return;

  // Update status badge
  const statusBadge = quizCard.querySelector(".quiz-status-badge");
  if (statusBadge) {
    if (newStatus === "published") {
      statusBadge.innerHTML =
        '<i class="fas fa-check-circle mr-1"></i> Published';
      statusBadge.className =
        "quiz-status-badge px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800";
    } else {
      statusBadge.innerHTML = '<i class="fas fa-pencil-alt mr-1"></i> Draft';
      statusBadge.className =
        "quiz-status-badge px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800";
    }
  }

  // Update dropdown menu options
  const menuContainer = quizCard.querySelector(".quiz-menu");
  if (menuContainer) {
    const publishBtn = quizCard.querySelector(".publish-quiz-btn");
    const unpublishBtn = quizCard.querySelector(".unpublish-quiz-btn");

    if (publishBtn && newStatus === "published") {
      // Replace publish button with unpublish button
      const newBtn = document.createElement("button");
      newBtn.className =
        "unpublish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center";
      newBtn.dataset.quizId = quizId;
      newBtn.dataset.quizTitle = publishBtn.dataset.quizTitle || "";
      newBtn.innerHTML =
        '<i class="fas fa-pause mr-2 text-yellow-500"></i> Unpublish';
      publishBtn.parentNode.replaceChild(newBtn, publishBtn);

      // Add event listener to the new button
      newBtn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const modal = document.getElementById("unpublishQuizModal");
        const confirmBtn = document.getElementById("confirmUnpublishQuizBtn");

        if (modal && confirmBtn) {
          const quizTitle = this.dataset.quizTitle || "this quiz";
          if (quizTitle && document.getElementById("unpublishQuizMessage")) {
            document.getElementById(
              "unpublishQuizMessage"
            ).textContent = `Are you sure you want to unpublish "${quizTitle}"? Students will no longer be able to access it.`;
          }

          confirmBtn.dataset.quizId = quizId;
          modal.classList.remove("hidden");
        }
      });
    } else if (unpublishBtn && newStatus === "draft") {
      // Replace unpublish button with publish button
      const newBtn = document.createElement("button");
      newBtn.className =
        "publish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center";
      newBtn.dataset.quizId = quizId;
      newBtn.dataset.quizTitle = unpublishBtn.dataset.quizTitle || "";
      newBtn.innerHTML =
        '<i class="fas fa-paper-plane mr-2 text-green-500"></i> Publish Quiz';
      unpublishBtn.parentNode.replaceChild(newBtn, unpublishBtn);

      // Add event listener to the new button
      newBtn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const modal = document.getElementById("publishQuizModal");
        const confirmBtn = document.getElementById("confirmPublishQuizBtn");

        if (modal && confirmBtn) {
          const quizTitle = this.dataset.quizTitle || "this quiz";
          if (quizTitle && document.getElementById("publishQuizMessage")) {
            document.getElementById(
              "publishQuizMessage"
            ).textContent = `Are you sure you want to publish "${quizTitle}"? Students will be able to see and take this quiz.`;
          }

          confirmBtn.dataset.quizId = quizId;
          modal.classList.remove("hidden");
        }
      });
    }
  }
}
