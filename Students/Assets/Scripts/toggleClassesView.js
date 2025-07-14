// Function to toggle between showing all classes and just the first 3
function toggleClassesView() {
  const classCards = document.querySelectorAll(".class-card");
  const viewMoreBtn = document.getElementById("viewMoreBtn");
  const viewMoreText = document.getElementById("viewMoreText");
  const initialDisplayCount = 3;
  const totalClasses = classCards.length;
  let isExpanded = viewMoreBtn.getAttribute("data-expanded") === "true";

  // Toggle state
  isExpanded = !isExpanded;
  viewMoreBtn.setAttribute("data-expanded", isExpanded);

  classCards.forEach((card, index) => {
    if (index >= initialDisplayCount) {
      if (isExpanded) {
        card.classList.remove("hidden");
      } else {
        card.classList.add("hidden");
      }
    }
  });

  // Update button text and icon
  if (isExpanded) {
    viewMoreText.textContent = "Show Less";
    viewMoreBtn.querySelector("i").classList.remove("fa-chevron-down");
    viewMoreBtn.querySelector("i").classList.add("fa-chevron-up");
  } else {
    viewMoreText.textContent = `View More (${
      totalClasses - initialDisplayCount
    } more)`;
    viewMoreBtn.querySelector("i").classList.remove("fa-chevron-up");
    viewMoreBtn.querySelector("i").classList.add("fa-chevron-down");
  }
}
