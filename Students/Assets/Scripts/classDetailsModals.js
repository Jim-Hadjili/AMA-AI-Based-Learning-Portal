function showAnnouncementModal(announcement) {
  // Populate modal content
  document.getElementById("modalAnnouncementTitle").textContent =
    announcement.title;
  document.getElementById("modalAnnouncementContent").textContent =
    announcement.content;

  // Format and set date
  const date = new Date(announcement.created_at);
  const formattedDate = date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
  document.getElementById("modalAnnouncementDate").textContent = formattedDate;

  // Show/hide pinned badge
  const pinnedBadge = document.getElementById("modalPinnedBadge");
  if (announcement.is_pinned == 1) {
    pinnedBadge.classList.remove("hidden");
  } else {
    pinnedBadge.classList.add("hidden");
  }

  // Show modal
  document.getElementById("announcementModal").classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
}

function closeAnnouncementModal() {
  document.getElementById("announcementModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

// Event listeners for closing modal
document
  .getElementById("closeAnnouncementModal")
  .addEventListener("click", closeAnnouncementModal);
document
  .getElementById("closeAnnouncementModalBtn")
  .addEventListener("click", closeAnnouncementModal);

// Close modal when clicking outside
document
  .getElementById("announcementModal")
  .addEventListener("click", function (e) {
    if (e.target === this) {
      closeAnnouncementModal();
    }
  });

// Close modal with Escape key
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    closeAnnouncementModal();
  }
});

// JavaScript for Quiz Details Modal
function showQuizDetailsModal(quiz) {
  document.getElementById("modalQuizTitle").textContent = quiz.quiz_title;
  document.getElementById("modalQuizDescription").textContent =
    quiz.quiz_description || "No description provided.";
  document.getElementById("modalQuizQuestions").textContent =
    quiz.total_questions || "0";
  document.getElementById(
    "modalQuizTimeLimit"
  ).textContent = `${quiz.time_limit} minutes`;
  document.getElementById("modalQuizTotalScore").textContent =
    quiz.total_score || "0";
  document.getElementById("modalQuizStatus").textContent =
    quiz.status.charAt(0).toUpperCase() + quiz.status.slice(1);

  // Set the quiz ID for the "Take Quiz" button
  document.getElementById("takeQuizBtn").dataset.quizId = quiz.quiz_id;

  document.getElementById("quizDetailsModal").classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
}

function closeQuizDetailsModal() {
  document.getElementById("quizDetailsModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

document
  .getElementById("closeQuizDetailsModal")
  .addEventListener("click", closeQuizDetailsModal);
document
  .getElementById("cancelQuizBtn")
  .addEventListener("click", closeQuizDetailsModal);

document
  .getElementById("quizDetailsModal")
  .addEventListener("click", function (e) {
    if (e.target === this) {
      closeQuizDetailsModal();
    }
  });

document.getElementById("takeQuizBtn").addEventListener("click", function () {
  const quizId = this.dataset.quizId;
  if (quizId) {
    // Redirect to the quiz taking page
    window.location.href = `quizPage.php?quiz_id=${quizId}`; // Placeholder URL
  }
});
