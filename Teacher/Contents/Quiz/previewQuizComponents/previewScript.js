document.addEventListener("DOMContentLoaded", function () {
  // Prevent form submission
  const form = document.getElementById("quiz-preview-form");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      alert("This is a preview. Quiz submission is disabled.");
    });
  }

  // Add subtle animation when scrolling to questions
  const questions = document.querySelectorAll(".quiz-card");
  if (questions.length > 0) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("opacity-100");
            entry.target.classList.remove("opacity-0", "translate-y-4");
          }
        });
      },
      { threshold: 0.1 }
    );

    questions.forEach((question) => {
      question.classList.add(
        "opacity-0",
        "translate-y-4",
        "transition-all",
        "duration-500"
      );
      observer.observe(question);
    });
  }
});
