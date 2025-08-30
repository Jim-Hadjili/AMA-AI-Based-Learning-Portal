// Simple client-side search & filter
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("activitySearch");
  const typeFilter = document.getElementById("activityTypeFilter");
  const classFilter = document.getElementById("classFilter");
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

  [searchInput, typeFilter, classFilter].forEach((el) => {
    el.addEventListener("input", filterActivities);
    el.addEventListener("change", filterActivities);
  });
});
