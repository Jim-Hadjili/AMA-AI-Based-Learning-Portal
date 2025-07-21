// All Classes Page JavaScript Functions

document.addEventListener("DOMContentLoaded", function () {
  initializeAllClassesPage();
});

function initializeAllClassesPage() {
  // Initialize search functionality
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", debounce(handleSearch, 300));
  }

  // Initialize filter buttons
  const filterButtons = document.querySelectorAll(".filter-btn");
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const filter = this.getAttribute("onclick").match(/'([^']+)'/)[1];
      filterClasses(filter);
    });
  });

  // Update initial counts
  updateClassCounts();
}

// Debounce function to limit search frequency
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Handle search functionality
function handleSearch() {
  const searchTerm = document
    .getElementById("searchInput")
    .value.toLowerCase()
    .trim();
  const classCards = document.querySelectorAll(".class-card");
  let visibleCount = 0;

  classCards.forEach((card) => {
    const className = card.getAttribute("data-class-name") || "";
    const classSubject = card.getAttribute("data-class-subject") || "";
    const classStrand = card.getAttribute("data-class-strand") || "";

    const isVisible =
      className.includes(searchTerm) ||
      classSubject.includes(searchTerm) ||
      classStrand.includes(searchTerm);

    if (isVisible) {
      card.style.display = "block";
      visibleCount++;
    } else {
      card.style.display = "none";
    }
  });

  // Show/hide no results message
  toggleNoResultsMessage(visibleCount === 0);
  updateVisibleClassCount(visibleCount);
}

// Filter classes by status
function filterClasses(status) {
  // Update active filter button
  const filterButtons = document.querySelectorAll(".filter-btn");
  filterButtons.forEach((btn) => btn.classList.remove("active"));

  const activeButton = document.querySelector(
    `[onclick="filterClasses('${status}')"]`
  );
  if (activeButton) {
    activeButton.classList.add("active");
  }

  const classCards = document.querySelectorAll(".class-card");
  let visibleCount = 0;

  classCards.forEach((card) => {
    const cardStatus = card.getAttribute("data-class-status");
    const searchTerm = document
      .getElementById("searchInput")
      .value.toLowerCase()
      .trim();

    // Check if card matches both filter and search
    const matchesFilter = status === "all" || cardStatus === status;
    const matchesSearch =
      !searchTerm ||
      card.getAttribute("data-class-name").includes(searchTerm) ||
      card.getAttribute("data-class-subject").includes(searchTerm) ||
      card.getAttribute("data-class-strand").includes(searchTerm);

    if (matchesFilter && matchesSearch) {
      card.style.display = "block";
      visibleCount++;
    } else {
      card.style.display = "none";
    }
  });

  // Show/hide no results message
  toggleNoResultsMessage(visibleCount === 0);
  updateVisibleClassCount(visibleCount);
}

// Clear all filters and search
function clearFilters() {
  // Clear search input
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.value = "";
  }

  // Reset to "All Classes" filter
  filterClasses("all");

  // Hide no results message
  toggleNoResultsMessage(false);
}

// Toggle no results message visibility
function toggleNoResultsMessage(show) {
  const noResultsMessage = document.getElementById("noResultsMessage");
  const classesContainer = document.getElementById("classesGrid");

  if (noResultsMessage && classesContainer) {
    if (show) {
      noResultsMessage.classList.remove("hidden");
      classesContainer.style.display = "none";
    } else {
      noResultsMessage.classList.add("hidden");
      classesContainer.style.display = "grid";
    }
  }
}

// Update visible class count in stats
function updateVisibleClassCount(count) {
  const totalClassesElement = document.getElementById("totalClasses");
  if (totalClassesElement) {
    // Only update if we're showing filtered results
    const searchInput = document.getElementById("searchInput");
    const hasSearch = searchInput && searchInput.value.trim() !== "";
    const activeFilter = document.querySelector(".filter-btn.active");
    const isFiltered =
      activeFilter && !activeFilter.textContent.includes("All Classes");

    if (hasSearch || isFiltered) {
      totalClassesElement.textContent = count;
    }
  }
}

// Update class counts based on current data
function updateClassCounts() {
  const classCards = document.querySelectorAll(".class-card");
  const counts = {
    total: classCards.length,
    active: 0,
    inactive: 0,
    archived: 0,
    pending: 0,
  };

  classCards.forEach((card) => {
    const status = card.getAttribute("data-class-status");
    if (counts.hasOwnProperty(status)) {
      counts[status]++;
    }
  });

  // Update count displays
  Object.keys(counts).forEach((status) => {
    const element = document.getElementById(`${status}Classes`);
    if (element) {
      element.textContent = counts[status];
    }
  });
}

// Sort classes functionality
function sortClasses(sortBy) {
  const classesGrid = document.getElementById("classesGrid");
  const classCards = Array.from(document.querySelectorAll(".class-card"));

  classCards.sort((a, b) => {
    switch (sortBy) {
      case "name":
        return a
          .getAttribute("data-class-name")
          .localeCompare(b.getAttribute("data-class-name"));
      case "subject":
        return a
          .getAttribute("data-class-subject")
          .localeCompare(b.getAttribute("data-class-subject"));
      case "status":
        return a
          .getAttribute("data-class-status")
          .localeCompare(b.getAttribute("data-class-status"));
      default:
        return 0;
    }
  });

  // Re-append sorted cards
  classCards.forEach((card) => {
    classesGrid.appendChild(card);
  });
}

// Export class data functionality (optional)
function exportClassData() {
  const classCards = document.querySelectorAll(
    '.class-card:not([style*="display: none"])'
  );
  const classData = [];

  classCards.forEach((card) => {
    const className = card.querySelector("h3").textContent;
    const status = card.querySelector(".px-2.py-1").textContent;
    const students =
      card.querySelector(".fa-users").nextElementSibling.textContent;
    const quizzes =
      card.querySelector(".fa-book").nextElementSibling.textContent;

    classData.push({
      name: className,
      status: status,
      students: students,
      quizzes: quizzes,
    });
  });

  console.log("Class Data:", classData);
  // Here you could implement actual export functionality (CSV, PDF, etc.)
}

// Keyboard shortcuts
document.addEventListener("keydown", function (e) {
  // Ctrl/Cmd + F to focus search
  if ((e.ctrlKey || e.metaKey) && e.key === "f") {
    e.preventDefault();
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
      searchInput.focus();
    }
  }

  // Escape to clear search
  if (e.key === "Escape") {
    const searchInput = document.getElementById("searchInput");
    if (searchInput && searchInput.value) {
      clearFilters();
    }
  }
});

// Responsive grid adjustment
function adjustGridLayout() {
  const classesGrid = document.getElementById("classesGrid");
  const containerWidth = classesGrid.offsetWidth;

  // Adjust grid columns based on container width
  if (containerWidth < 640) {
    classesGrid.className = classesGrid.className.replace(
      /grid-cols-\d+/g,
      "grid-cols-1"
    );
  } else if (containerWidth < 1024) {
    classesGrid.className = classesGrid.className.replace(
      /grid-cols-\d+/g,
      "grid-cols-2"
    );
  } else if (containerWidth < 1280) {
    classesGrid.className = classesGrid.className.replace(
      /grid-cols-\d+/g,
      "grid-cols-3"
    );
  } else {
    classesGrid.className = classesGrid.className.replace(
      /grid-cols-\d+/g,
      "grid-cols-4"
    );
  }
}

// Listen for window resize
window.addEventListener("resize", debounce(adjustGridLayout, 250));

// Initialize grid layout on load
window.addEventListener("load", adjustGridLayout);
