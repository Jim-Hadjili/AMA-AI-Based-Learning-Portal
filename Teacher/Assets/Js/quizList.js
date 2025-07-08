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
  setupDeleteQuizHandlers();
  setupPublishQuizHandlers();
  setupDuplicateQuizHandlers();
  setupAutoSubmitFilters();
});

function setupDeleteQuizHandlers() {
  document.querySelectorAll(".delete-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      const quizTitle = this.dataset.quizTitle;

      if (
        confirm(
          `Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`
        )
      ) {
        deleteQuiz(quizId);
      }
    });
  });
}

function setupPublishQuizHandlers() {
  document.querySelectorAll(".publish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      updateQuizStatus(quizId, "published");
    });
  });

  document.querySelectorAll(".unpublish-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      updateQuizStatus(quizId, "draft");
    });
  });
}

function setupDuplicateQuizHandlers() {
  document.querySelectorAll(".duplicate-quiz-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      duplicateQuiz(quizId);
    });
  });
}

function setupAutoSubmitFilters() {
  // Auto-submit form on filter change (optional)
  const autoSubmitElements = document.querySelectorAll("#status, #sort");
  autoSubmitElements.forEach((element) => {
    element.addEventListener("change", function () {
      // Uncomment the line below to enable auto-submit
      // this.form.submit();
    });
  });
}

function deleteQuiz(quizId) {
  // AJAX call to delete quiz
  // On success, remove the quiz card from DOM or reload page
}

function updateQuizStatus(quizId, status) {
  // AJAX call to update quiz status
  // On success, update the quiz card status or reload page
}

function duplicateQuiz(quizId) {
  // AJAX call to duplicate quiz
  // On success, redirect to the new quiz or reload page
}
