function showClassSearchModal() {
  document.getElementById("studentSearchClassModal").classList.remove("hidden");
  document.getElementById("studentClassSearchInput").value = "";
  document.getElementById("studentSearchResults").innerHTML =
    '<div class="p-6 text-center text-gray-500 text-lg">Start typing to search for your classes.</div>';
}
function closeStudentSearchModal() {
  document.getElementById("studentSearchClassModal").classList.add("hidden");
}

// Debounced search
let studentSearchDebounceTimeout;
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("studentClassSearchInput");
  const searchResultsContainer = document.getElementById(
    "studentSearchResults"
  );

  searchInput.addEventListener("input", function () {
    clearTimeout(studentSearchDebounceTimeout);
    const query = this.value;

    if (query.length < 2) {
      searchResultsContainer.innerHTML =
        '<div class="p-6 text-center text-gray-500 text-lg">Type at least 2 characters to search.</div>';
      return;
    }

    searchResultsContainer.innerHTML =
      '<div class="p-6 text-center text-blue-500"><i class="fas fa-spinner fa-spin mr-2"></i> Searching...</div>';

    studentSearchDebounceTimeout = setTimeout(() => {
      fetch(
        `../../Functions/fetchStudentSearchSuggestions.php?query=${encodeURIComponent(
          query
        )}`
      )
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            displayStudentSearchResults(data.data);
          } else {
            searchResultsContainer.innerHTML = `<div class="p-6 text-center text-red-500">Error: ${data.message}</div>`;
          }
        })
        .catch(() => {
          searchResultsContainer.innerHTML =
            '<div class="p-6 text-center text-red-500">Failed to fetch search results.</div>';
        });
    }, 300);
  });

  function displayStudentSearchResults(results) {
    searchResultsContainer.innerHTML = "";
    if (results.length === 0) {
      searchResultsContainer.innerHTML =
        '<div class="p-6 text-center text-gray-500 text-lg">No classes found.</div>';
      return;
    }
    const gridContainer = document.createElement("div");
    gridContainer.className = "grid grid-cols-1 gap-4 p-4";
    results.forEach((classItem) => {
      const statusColors = {
        active: "bg-green-100 text-green-800",
        inactive: "bg-gray-100 text-gray-800",
        archived: "bg-red-100 text-red-800",
      };
      const description =
        classItem.class_description || "No description available";
      const strand = classItem.strand || "N/A";
      const statusClass =
        statusColors[classItem.status] || statusColors.inactive;
      const classCardHtml = `
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                        <div class="h-2 bg-blue-500"></div>
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="font-semibold text-lg text-gray-900">${
                                  classItem.class_name
                                }</h3>
                                <span class="px-2 py-1 text-xs rounded-full ${statusClass}">
                                    ${
                                      classItem.status.charAt(0).toUpperCase() +
                                      classItem.status.slice(1)
                                    }
                            </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">${description}</p>
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div class="bg-gray-50 p-2 rounded">
                                    <p class="text-xs text-gray-500">Grade</p>
                                    <p class="font-medium text-sm text-gray-800">Grade ${
                                      classItem.grade_level
                                    }</p>
                                </div>
                                <div class="bg-gray-50 p-2 rounded">
                                    <p class="text-xs text-gray-500">Strand</p>
                                    <p class="font-medium text-sm text-gray-800">${strand}</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>
                                    <span>${
                                      classItem.student_count
                                    } Students</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-book mr-2 text-blue-500"></i>
                                    <span>${classItem.quiz_count} Quizzes</span>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-key mr-1"></i>
                                    Code: <span class="font-mono font-medium">${
                                      classItem.class_code
                                    }</span>
                                </div>
                                <a href="../Pages/classDetails.php?class_id=${
                                  classItem.class_id
                                }" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Class <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
      gridContainer.insertAdjacentHTML("beforeend", classCardHtml);
    });
    searchResultsContainer.appendChild(gridContainer);
  }
});
