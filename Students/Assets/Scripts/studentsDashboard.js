// Enhanced back button prevention
window.addEventListener("pageshow", function (event) {
  if (
    event.persisted ||
    (window.performance && window.performance.navigation.type === 2)
  ) {
    // Page was restored from back/forward cache
    window.location.href = "../../functions/auth/logout.php";
  }
});

history.pushState(null, null, location.href);
window.onpopstate = function () {
  window.location.href = "../../functions/auth/logout.php";
};

// Mobile menu toggle
function toggleMobileMenu() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const body = document.body;

  sidebar.classList.toggle("-translate-x-full");
  overlay.classList.toggle("hidden");

  // Prevent body scroll when sidebar is open on mobile
  if (!sidebar.classList.contains("-translate-x-full")) {
    body.classList.add("overflow-hidden");
  } else {
    body.classList.remove("overflow-hidden");
  }
}

// Close sidebar when clicking outside on mobile
function closeMobileMenu() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const body = document.body;

  sidebar.classList.add("-translate-x-full");
  overlay.classList.add("hidden");
  body.classList.remove("overflow-hidden");
}

// Desktop sidebar hover functionality
let sidebarTimeout;
let isSidebarExpanded = false;

function handleSidebarMouseEnter() {
  if (window.innerWidth >= 1024) {
    // Only on desktop
    clearTimeout(sidebarTimeout);
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");

    sidebar.classList.add("sidebar-expanded");
    mainContent.classList.remove("lg:ml-16");
    mainContent.classList.add("lg:ml-64");
    isSidebarExpanded = true;
  }
}

function handleSidebarMouseLeave() {
  if (window.innerWidth >= 1024) {
    // Only on desktop
    sidebarTimeout = setTimeout(() => {
      const sidebar = document.getElementById("sidebar");
      const mainContent = document.getElementById("main-content");

      sidebar.classList.remove("sidebar-expanded");
      mainContent.classList.remove("lg:ml-64");
      mainContent.classList.add("lg:ml-16");
      isSidebarExpanded = false;
    }, 100);
  }
}

// Function to open the class search modal
function openClassSearchModal() {
  document.getElementById("classSearchModal").classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
  setTimeout(() => {
    document.getElementById("classCode").focus();
  }, 100);
}

// Function to close the class search modal
function closeClassSearchModal() {
  document.getElementById("classSearchModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
  document.getElementById("classCode").value = "";
  document.getElementById("searchError").textContent = "";
  document.getElementById("searchError").classList.add("hidden");
}

// Function to search for and enroll in a class
function searchAndEnrollClass() {
  const classCode = document.getElementById("classCode").value.trim();
  const errorElement = document.getElementById("searchError");
  const submitButton = document.getElementById("searchButton");
  const loadingIcon = document.getElementById("loadingIcon");

  // Clear previous errors
  errorElement.textContent = "";
  errorElement.classList.add("hidden");

  // Validate input
  if (!classCode) {
    errorElement.textContent = "Please enter a class code";
    errorElement.classList.remove("hidden");
    return;
  }

  // Show loading state
  submitButton.disabled = true;
  loadingIcon.classList.remove("hidden");

  // Create form data
  const formData = new FormData();
  formData.append("class_code", classCode);

  // Send AJAX request
  fetch("../../api/classes/enrollClass.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Show success message
        showNotification(data.message, "success");

        // Close modal
        closeClassSearchModal();

        // Reload page after brief delay
        setTimeout(() => {
          window.location.reload();
        }, 1500);
      } else {
        // Show error
        errorElement.textContent = data.message;
        errorElement.classList.remove("hidden");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      errorElement.textContent = "An error occurred. Please try again.";
      errorElement.classList.remove("hidden");
    })
    .finally(() => {
      // Reset button state
      submitButton.disabled = false;
      loadingIcon.classList.add("hidden");
    });
}

// Notification function
function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.className = `fixed bottom-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium transform translate-x-full transition-transform duration-300 ${
    type === "success"
      ? "bg-green-500"
      : type === "error"
      ? "bg-red-500"
      : type === "warning"
      ? "bg-yellow-500"
      : "bg-blue-500"
  }`;
  notification.textContent = message;

  document.body.appendChild(notification);

  // Slide in
  setTimeout(() => {
    notification.classList.remove("translate-x-full");
  }, 100);

  // Slide out and remove
  setTimeout(() => {
    notification.classList.add("translate-x-full");
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

// Initialize event listeners when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  sidebar.addEventListener("mouseenter", handleSidebarMouseEnter);
  sidebar.addEventListener("mouseleave", handleSidebarMouseLeave);

  // Add Enter key support for class code input
  document
    .getElementById("classCode")
    .addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        searchAndEnrollClass();
      }
    });
});
