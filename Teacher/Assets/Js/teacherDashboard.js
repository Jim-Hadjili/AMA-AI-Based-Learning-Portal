// Enhanced back button prevention
window.addEventListener("pageshow", function (event) {
  if (
    event.persisted ||
    (window.performance && window.performance.navigation.type === 2)
  ) {
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

// Initialize event listeners when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  sidebar.addEventListener("mouseenter", handleSidebarMouseEnter);
  sidebar.addEventListener("mouseleave", handleSidebarMouseLeave);
});

// Add class modal functions
function openAddClassModal() {
  document.getElementById("addClassModal").classList.remove("hidden");
}

function closeAddClassModal() {
  document.getElementById("addClassModal").classList.add("hidden");
  document.getElementById("addClassForm").reset();
}

// Submit add class form via AJAX
function submitAddClassForm(event) {
  event.preventDefault();

  const form = document.getElementById("addClassForm");
  const formData = new FormData(form);
  const submitBtn = form.querySelector('button[type="submit"]');

  // Disable button and show loading state
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';

  fetch("../../functions/classes/addClass.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Show success message
        showNotification("Success! " + data.message, "success");
        closeAddClassModal();

        // Refresh page to show new class
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        // Show error message
        showNotification("Error: " + data.message, "error");
      }
    })
    .catch((error) => {
      showNotification("Error: " + error.message, "error");
    })
    .finally(() => {
      // Reset button state
      submitBtn.disabled = false;
      submitBtn.innerHTML = "Add Class";
    });
}

// Show notification
function showNotification(message, type) {
  const notificationContainer = document.getElementById(
    "notification-container"
  );
  const notification = document.createElement("div");

  notification.className = `fixed bottom-4 right-4 px-5 py-4 rounded-lg shadow-lg text-white ${
    type === "success" ? "bg-green-500" : "bg-red-500"
  } transition-opacity duration-500 flex items-center`;

  notification.innerHTML = `
                <i class="fas ${
                  type === "success"
                    ? "fa-check-circle"
                    : "fa-exclamation-circle"
                } mr-3"></i>
                <span>${message}</span>
                <button class="ml-4 text-white" onclick="this.parentElement.remove();">
                    <i class="fas fa-times"></i>
                </button>
            `;

  notificationContainer.appendChild(notification);

  // Auto dismiss after 5 seconds
  setTimeout(() => {
    notification.classList.add("opacity-0");
    setTimeout(() => {
      notification.remove();
    }, 500);
  }, 5000);
}
