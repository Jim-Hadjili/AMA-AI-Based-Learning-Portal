/**
 * Class Details JavaScript - Handles UI interactions on the class details page
 */

document.addEventListener("DOMContentLoaded", function () {
  // Tab switching
  initTabSwitching();

  // Modal functionality
  initModalFunctionality();

  // Copy class code functionality
  initCopyCodeButtons();

  // Search functionality
  initSearchFunctionality();

  // Additional initializations
  initializeModalHandling();
  initializeTabNavigation();
});

/**
 * Initialize tab switching functionality
 */
function initTabSwitching() {
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Remove active class from all buttons
      tabButtons.forEach((btn) => {
        btn.classList.remove("active");
        btn.classList.remove(
          "border-b-2",
          "border-purple-primary",
          "text-purple-primary"
        );
        btn.classList.add("text-gray-600", "hover:text-gray-900");
      });

      // Hide all tab contents
      tabContents.forEach((content) => {
        content.classList.add("hidden");
      });

      // Add active class to clicked button
      this.classList.add("active");
      this.classList.add(
        "border-b-2",
        "border-purple-primary",
        "text-purple-primary"
      );
      this.classList.remove("text-gray-600", "hover:text-gray-900");

      // Show corresponding tab content
      const tabId = this.getAttribute("data-tab");
      document.getElementById(`${tabId}-tab`).classList.remove("hidden");
    });
  });
}

/**
 * Initialize modal functionality
 */
function initModalFunctionality() {
  // Edit class modal
  window.openEditClassModal = function () {
    document.getElementById("editClassModal").classList.remove("hidden");
  };

  window.closeEditClassModal = function () {
    document.getElementById("editClassModal").classList.add("hidden");
  };

  // Add quiz modal
  window.openAddQuizModal = function () {
    document.getElementById("addQuizModal").classList.remove("hidden");
  };

  window.closeAddQuizModal = function () {
    document.getElementById("addQuizModal").classList.add("hidden");
  };

  // Add event listeners to buttons
  const editClassBtn = document.getElementById("editClassBtn");
  if (editClassBtn) {
    editClassBtn.addEventListener("click", window.openEditClassModal);
  }

  const addQuizBtn = document.getElementById("addQuizBtn");
  if (addQuizBtn) {
    addQuizBtn.addEventListener("click", window.openAddQuizModal);
  }

  // Modal close buttons
  const closeButtons = document.querySelectorAll(".modal-close");
  closeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modalId = this.getAttribute("data-modal-id");
      document.getElementById(modalId).classList.add("hidden");
    });
  });

  // Modal background overlays
  const modalOverlays = document.querySelectorAll(".modal-overlay");
  modalOverlays.forEach((overlay) => {
    overlay.addEventListener("click", function (e) {
      if (e.target === this) {
        const modalId = this.getAttribute("data-modal-id");
        document.getElementById(modalId).classList.add("hidden");
      }
    });
  });
}

/**
 * Initialize copy code button functionality
 */
function initCopyCodeButtons() {
  const copyCodeBtns = document.querySelectorAll(".copy-code-btn");
  copyCodeBtns.forEach((button) => {
    button.addEventListener("click", function () {
      const code = this.getAttribute("data-code");
      navigator.clipboard
        .writeText(code)
        .then(() => {
          showNotification("Class code copied to clipboard!", "success");

          // Change button icon temporarily
          const originalHTML = this.innerHTML;
          this.innerHTML = '<i class="fas fa-check"></i>';
          setTimeout(() => {
            this.innerHTML = originalHTML;
          }, 1500);
        })
        .catch((err) => {
          showNotification("Failed to copy class code", "error");
          console.error("Could not copy text: ", err);
        });
    });
  });
}

/**
 * Initialize search functionality
 */
function initSearchFunctionality() {
  // Quiz search
  const quizSearch = document.getElementById("quiz-search");
  if (quizSearch) {
    quizSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase().trim();
      const quizItems = document.querySelectorAll(".quiz-item");

      quizItems.forEach((item) => {
        const quizName = item
          .querySelector(".quiz-name")
          .textContent.toLowerCase();
        if (quizName.includes(searchTerm)) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });
  }

  // Student search
  const studentSearch = document.getElementById("student-search");
  if (studentSearch) {
    studentSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase().trim();
      const studentItems = document.querySelectorAll(".student-item");

      studentItems.forEach((item) => {
        const studentName = item
          .querySelector(".student-name")
          .textContent.toLowerCase();
        const studentEmail = item
          .querySelector(".student-email")
          .textContent.toLowerCase();

        if (
          studentName.includes(searchTerm) ||
          studentEmail.includes(searchTerm)
        ) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });
  }

  // Material search
  const materialSearch = document.getElementById("material-search");
  if (materialSearch) {
    materialSearch.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase().trim();
      const materialItems = document.querySelectorAll(".material-item");

      materialItems.forEach((item) => {
        const materialName = item
          .querySelector(".material-name")
          .textContent.toLowerCase();

        if (materialName.includes(searchTerm)) {
          item.style.display = "";
        } else {
          item.style.display = "none";
        }
      });
    });
  }
}

/**
 * Show a notification message
 *
 * @param {string} message The message to display
 * @param {string} type The notification type (success, error, warning, info)
 */
function showNotification(message, type = "info") {
  const notificationContainer = document.getElementById(
    "notification-container"
  );

  if (!notificationContainer) {
    console.error("Notification container not found");
    alert(message);
    return;
  }

  // Create notification element
  const notification = document.createElement("div");

  // Set notification classes based on type
  let typeClasses = "bg-blue-100 border-blue-500 text-blue-700";
  let icon = "fa-info-circle";

  if (type === "success") {
    typeClasses = "bg-green-100 border-green-500 text-green-700";
    icon = "fa-check-circle";
  } else if (type === "error") {
    typeClasses = "bg-red-100 border-red-500 text-red-700";
    icon = "fa-exclamation-circle";
  } else if (type === "warning") {
    typeClasses = "bg-yellow-100 border-yellow-500 text-yellow-700";
    icon = "fa-exclamation-triangle";
  }

  // Set notification content
  notification.className = `rounded-md border-l-4 p-4 ${typeClasses} flex items-center justify-between shadow-md mb-3 animate-fadeIn`;
  notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span>${message}</span>
        </div>
        <button class="ml-4 text-sm font-medium focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    `;

  // Add close button functionality
  notification.querySelector("button").addEventListener("click", function () {
    notification.classList.add("animate-fadeOut");
    setTimeout(() => {
      notification.remove();
    }, 300);
  });

  // Add to notification container
  notificationContainer.appendChild(notification);

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentNode) {
      notification.classList.add("animate-fadeOut");
      setTimeout(() => {
        if (notification.parentNode) {
          notification.remove();
        }
      }, 300);
    }
  }, 5000);
}

// Make showNotification available globally
window.showNotification = showNotification;

/**
 * Initialize modal handling
 */
function initializeModalHandling() {
  // Modal open buttons
  const modalOpenButtons = document.querySelectorAll("[data-modal-open]");
  modalOpenButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modalId = this.getAttribute("data-modal-open");
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove("hidden");
      }
    });
  });

  // Modal close buttons
  const modalCloseButtons = document.querySelectorAll(".modal-close");
  modalCloseButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const modalId = this.getAttribute("data-modal-id");
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.add("hidden");
      }
    });
  });

  // Modal overlays
  const modalOverlays = document.querySelectorAll(".modal-overlay");
  modalOverlays.forEach((overlay) => {
    overlay.addEventListener("click", function (e) {
      if (e.target === this) {
        const modalId = this.getAttribute("data-modal-id");
        const modal = document.getElementById(modalId);
        if (modal) {
          modal.classList.add("hidden");
        }
      }
    });
  });
}

/**
 * Initialize tab navigation
 */
function initializeTabNavigation() {
  const tabButtons = document.querySelectorAll("[data-tab]");

  tabButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const tabId = this.getAttribute("data-tab");

      // Remove active class from all buttons
      tabButtons.forEach((btn) => {
        btn.classList.remove(
          "border-b-2",
          "border-purple-primary",
          "text-purple-primary",
          "font-medium"
        );
        btn.classList.add("text-gray-500", "hover:text-gray-700");
      });

      // Add active class to clicked button
      this.classList.remove("text-gray-500", "hover:text-gray-700");
      this.classList.add(
        "border-b-2",
        "border-purple-primary",
        "text-purple-primary",
        "font-medium"
      );

      // Hide all tab contents
      const tabContents = document.querySelectorAll("[data-tab-content]");
      tabContents.forEach((content) => {
        content.classList.add("hidden");
      });

      // Show selected tab content
      const selectedTab = document.querySelector(
        `[data-tab-content="${tabId}"]`
      );
      if (selectedTab) {
        selectedTab.classList.remove("hidden");
      }
    });
  });
}
