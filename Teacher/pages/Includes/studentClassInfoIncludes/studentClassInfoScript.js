document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("quiz-search");
  const statusFilter = document.getElementById("status-filter");
  const resetButton = document.getElementById("reset-filters");
  const quizRows = document.querySelectorAll(".quiz-row");
  const noResultsMessage = document.getElementById("no-results-message");
  const quizTableBody = document.getElementById("quiz-table-body");

  // Function to apply filters
  function applyFilters() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const statusValue = statusFilter.value;

    let visibleCount = 0;

    quizRows.forEach((row) => {
      const title = row.dataset.title;
      const status = row.dataset.status;

      // Check if row matches all current filters
      const matchesSearch = title.includes(searchTerm);
      const matchesStatus = statusValue === "all" || status === statusValue;

      // Show/hide row based on filter matches
      if (matchesSearch && matchesStatus) {
        row.classList.remove("hidden");
        visibleCount++;
      } else {
        row.classList.add("hidden");
      }
    });

    // Show "no results" message if no visible rows
    if (visibleCount === 0) {
      noResultsMessage.classList.remove("hidden");
      quizTableBody.classList.add("hidden");
    } else {
      noResultsMessage.classList.add("hidden");
      quizTableBody.classList.remove("hidden");
    }
  }

  // Add event listeners to all filter inputs
  searchInput.addEventListener("input", applyFilters);
  statusFilter.addEventListener("change", applyFilters);

  // Reset filters
  resetButton.addEventListener("click", function () {
    searchInput.value = "";
    statusFilter.value = "all";
    applyFilters();
  });

  // Initialize filters
  applyFilters();
});
