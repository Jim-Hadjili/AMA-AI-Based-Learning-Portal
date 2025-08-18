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
  // Get class_id from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const classId = urlParams.get("class_id");

  // Check if student_attempt exists and is passed
  if (quiz.student_attempt && quiz.student_attempt.result === "passed") {
    // Show the "already passed" modal
    document.getElementById("quizPassedModal").classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    // Optionally, show score/result info
    document.getElementById("quizPassedScore").textContent =
      quiz.student_attempt.score || "0";
    document.getElementById("quizPassedAttempts").textContent =
      quiz.student_attempt.attempts || "1";
    document.getElementById("quizPassedViewResultBtn").onclick = function () {
      // Redirect to attempts list for this quiz with class_id
      window.location.href = `quizAttempts.php?quiz_id=${quiz.quiz_id}&class_id=${classId}`;
    };
    return;
  }

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

  // Set the quiz ID and class ID for the "Take Quiz" button
  document.getElementById("takeQuizBtn").dataset.quizId = quiz.quiz_id;
  document.getElementById("takeQuizBtn").dataset.classId = classId;

  document.getElementById("quizDetailsModal").classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
}

function closeQuizDetailsModal() {
  document.getElementById("quizDetailsModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

function closeQuizPassedModal() {
  document.getElementById("quizPassedModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

document
  .getElementById("closeQuizDetailsModal")
  .addEventListener("click", closeQuizDetailsModal);
document
  .getElementById("cancelQuizBtn")
  .addEventListener("click", closeQuizDetailsModal);

// Add event listener for closing quiz passed modal if it exists
const closeQuizPassedModalBtn = document.getElementById("closeQuizPassedModal");
if (closeQuizPassedModalBtn) {
  closeQuizPassedModalBtn.addEventListener("click", closeQuizPassedModal);
}

document
  .getElementById("quizDetailsModal")
  .addEventListener("click", function (e) {
    if (e.target === this) {
      closeQuizDetailsModal();
    }
  });

// Add event listener for quiz passed modal if it exists
const quizPassedModal = document.getElementById("quizPassedModal");
if (quizPassedModal) {
  quizPassedModal.addEventListener("click", function (e) {
    if (e.target === this) {
      closeQuizPassedModal();
    }
  });
}

document.getElementById("takeQuizBtn").addEventListener("click", function () {
  const quizId = this.dataset.quizId;
  const classId = this.dataset.classId;
  if (quizId && classId) {
    // Redirect to the quiz taking page with class_id
    window.location.href = `quizPage.php?quiz_id=${quizId}&class_id=${classId}`;
  }
});
