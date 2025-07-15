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
