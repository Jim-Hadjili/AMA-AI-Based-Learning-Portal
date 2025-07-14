// Search Modal Functions
let searchDebounceTimeout;

function openSearchModal() {
  document.getElementById("searchClassModal").classList.remove("hidden");
  // Clear previous results and input on opening
  document.getElementById("classSearchInput").value = "";
  document.getElementById("searchResults").innerHTML =
    '<div class="p-4 text-center text-gray-500">Start typing to search for classes.</div>';
}

function closeSearchModal() {
  // These classes are for animation, handled by searchDashAnimation.js
  document.getElementById("searchClassModal").classList.add("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const searchSidebarBtn = document.getElementById("searchSidebarBtn");
  if (searchSidebarBtn) {
    searchSidebarBtn.addEventListener("click", (event) => {
      event.preventDefault(); // Prevent default link behavior
      openSearchModal(); // Use the global animation function
    });
  }

  const searchInput = document.getElementById("classSearchInput");
  const searchResultsContainer = document.getElementById("searchResults");

  searchInput.addEventListener("input", function () {
    clearTimeout(searchDebounceTimeout);
    const query = this.value;

    if (query.length < 2) {
      // Only search if query has at least 2 characters
      searchResultsContainer.innerHTML =
        '<div class="p-4 text-center text-gray-500">Type at least 2 characters to search.</div>';
      return;
    }

    searchResultsContainer.innerHTML =
      '<div class="p-4 text-center text-purple-primary"><i class="fas fa-spinner fa-spin mr-2"></i> Searching...</div>';

    searchDebounceTimeout = setTimeout(() => {
      fetch(
        `../../Functions/fetchSearchSuggestions.php?query=${encodeURIComponent(
          query
        )}`
      )
        .then((response) => {
          // IMPORTANT: Clone the response so we can read it twice (once as text, once as JSON)
          const clonedResponse = response.clone();
          return response
            .json()
            .then((data) => ({ data, response: clonedResponse }));
        })
        .then(({ data, response }) => {
          if (data.success) {
            displaySearchResults(data.data);
          } else {
            searchResultsContainer.innerHTML = `<div class="p-4 text-center text-red-500">Error: ${data.message}</div>`;
          }
        })
        .catch((error) => {
          // If JSON parsing fails, log the raw response text
          console.error("Error fetching or parsing search results:", error);
          // Try to read the response as text to get more info
          error.response
            ?.text()
            .then((text) => {
              console.error("Raw response text:", text);
              searchResultsContainer.innerHTML = `<div class="p-4 text-center text-red-500">Failed to fetch search results. Check console for details.</div>`;
            })
            .catch(() => {
              searchResultsContainer.innerHTML =
                '<div class="p-4 text-center text-red-500">Failed to fetch search results.</div>';
            });
        });
    }, 300); // Debounce time in ms
  });

  function displaySearchResults(results) {
    const searchResultsContainer = document.getElementById("searchResults");
    searchResultsContainer.innerHTML = ""; // Clear previous results

    if (results.length === 0) {
      searchResultsContainer.innerHTML =
        '<div class="p-4 text-center text-gray-500">No classes found.</div>';
      return;
    }

    // Create a grid container for the cards
    const gridContainer = document.createElement("div");
    gridContainer.className = "grid grid-cols-1 gap-4 p-4"; // Adjust grid columns as needed for modal size

    results.forEach((classItem) => {
      // Define status badge colors in JS
      const statusColors = {
        active: "bg-green-100 text-green-800",
        inactive: "bg-gray-100 text-gray-800",
        archived: "bg-red-100 text-red-800",
      };

      // Default values for missing fields
      const description =
        classItem.class_description || "No description available";
      const strand = classItem.strand || "N/A";
      const statusClass =
        statusColors[classItem.status] || statusColors.inactive;

      const classCardHtml = `
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
            <!-- Class Card Header with Color Strip -->
            <div class="h-2 bg-purple-primary"></div>
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
                        <i class="fas fa-users mr-2 text-purple-primary"></i>
                        <span>${classItem.student_count} Students</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-book mr-2 text-purple-primary"></i>
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
                    <a href="../Tabs/classDetails.php?class_id=${
                      classItem.class_id
                    }" class="text-purple-primary hover:text-purple-dark text-sm font-medium">
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
