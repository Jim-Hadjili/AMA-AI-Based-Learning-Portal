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
  const tableBody = document.getElementById("studentTableBody");
  if (!searchInput || !filterSelect || !tableBody) return;
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
        (name && name.includes(search)) ||
        (email && email.includes(search));
      const matchesFilter =
        !filter || (classes && classes.split(",").includes(filter));
      if (matchesSearch && matchesFilter) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }
  searchInput.addEventListener("input", filterRows);
  filterSelect.addEventListener("change", filterRows);
})();
