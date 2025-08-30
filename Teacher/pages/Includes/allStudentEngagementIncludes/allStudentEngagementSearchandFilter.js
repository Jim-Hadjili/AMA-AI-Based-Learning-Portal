function showStudentModal(studentId) {
  document
    .getElementById(`studentModal-${studentId}`)
    .classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
}
function closeStudentModal(studentId) {
  document.getElementById(`studentModal-${studentId}`).classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}
document.addEventListener("click", function (event) {
  const modals = document.querySelectorAll('[id^="studentModal-"]');
  modals.forEach((modal) => {
    if (event.target === modal) {
      modal.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }
  });
});
// Search and filter for student table
(function () {
  const searchInput = document.getElementById("studentSearch");
  const filterSelect = document.getElementById("classFilter");
  const resetButton = document.getElementById("resetFilters");
  const tableBody = document.getElementById("studentTableBody");
  if (!searchInput || !filterSelect || !tableBody || !resetButton) return;
  const rows = tableBody.querySelectorAll("tr");
  function filterRows() {
    const search = searchInput.value.toLowerCase();
    const filter = filterSelect.value;
    rows.forEach((row) => {
      const name = row.getAttribute("data-student-name");
      const email = row.getAttribute("data-student-email");
      const classes = row.getAttribute("data-student-classes");
      const matchesSearch =
        !search ||
        (name && name.toLowerCase().includes(search)) ||
        (email && email.toLowerCase().includes(search));
      const matchesFilter =
        !filter || (classes && classes.split(",").includes(filter));
      if (matchesSearch && matchesFilter) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }
  
  function resetFilters() {
    // Clear input values
    searchInput.value = "";
    filterSelect.value = "";
    
    // Show all rows explicitly
    rows.forEach((row) => {
      row.style.display = "";
    });
    
    // Optional: trigger a change event on the filter select to ensure any other listeners know it changed
    const changeEvent = new Event('change');
    filterSelect.dispatchEvent(changeEvent);
    
    // Optional: focus on the search field after reset
    searchInput.focus();
  }
  
  searchInput.addEventListener("input", filterRows);
  filterSelect.addEventListener("change", filterRows);
  resetButton.addEventListener("click", resetFilters);
})();
