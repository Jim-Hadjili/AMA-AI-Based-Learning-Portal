// Simple client-side search & filter
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("activitySearch");
  const typeFilter = document.getElementById("activityTypeFilter");
  const classFilter = document.getElementById("classFilter");
  const resetButton = document.getElementById("resetActivityFilters");
  const timeline = document.getElementById("activityTimeline");
  const items = timeline ? timeline.querySelectorAll(".activity-item") : [];

  function filterActivities() {
    const search = searchInput.value.toLowerCase();
    const type = typeFilter.value;
    const classId = classFilter.value;

    items.forEach((item) => {
      const matchesType = !type || item.dataset.type === type;
      const matchesClass = !classId || item.dataset.class === classId;
      const matchesSearch =
        !search ||
        item.dataset.desc.toLowerCase().includes(search) ||
        item.dataset.student.toLowerCase().includes(search) ||
        item.dataset.quiz.toLowerCase().includes(search);

      if (matchesType && matchesClass && matchesSearch) {
        item.style.display = "";
      } else {
        item.style.display = "none";
      }
    });
  }

  function resetFilters() {
    // Clear input values
    searchInput.value = "";
    typeFilter.value = "";
    classFilter.value = "";
    
    // Show all activity items
    items.forEach((item) => {
      item.style.display = "";
    });
    
    // Dispatch change events to ensure any other listeners know the filters have been reset
    [typeFilter, classFilter].forEach(select => {
      const changeEvent = new Event('change');
      select.dispatchEvent(changeEvent);
    });
    
    // Focus on the search field after reset
    searchInput.focus();
  }

  // Add event listeners for filters
  [searchInput, typeFilter, classFilter].forEach((el) => {
    el.addEventListener("input", filterActivities);
    el.addEventListener("change", filterActivities);
  });
  
  // Add event listener for reset button
  if (resetButton) {
    resetButton.addEventListener("click", resetFilters);
  }
});
