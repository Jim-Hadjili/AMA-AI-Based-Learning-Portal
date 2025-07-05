/**
 * Session Confirmation Handler
 *
 * Manages confirmation dialogs for actions that would end the user session
 */

document.addEventListener("DOMContentLoaded", function () {
  // Get modal elements
  const modal = document.getElementById("confirmationModal");
  if (!modal) return; // Exit if modal doesn't exist

  const modalTitle = document.getElementById("modal-title");
  const modalMessage = document.getElementById("modal-message");
  const modalIcon = document.getElementById("modal-icon");
  const cancelBtn = document.getElementById("modal-cancel");
  const confirmBtn = document.getElementById("modal-confirm");

  // Initialize variables to store action information
  let actionCallback = null;
  let isLogoutConfirmed = false; // Track if logout was confirmed by user

  // Setup history state management for back button detection
  const setupHistoryManipulation = () => {
    // Save the current page state with a unique ID
    const currentPageKey = "page_" + Date.now();
    history.replaceState(
      { page: currentPageKey },
      document.title,
      window.location.href
    );

    // Add a dummy history entry that we can go back to
    history.pushState(
      { page: "dummy_state" },
      document.title,
      window.location.href
    );

    // Listen for popstate events (triggered when back/forward buttons are used)
    window.addEventListener("popstate", function (e) {
      // If we're going back from our dummy state
      if (!e.state || e.state.page !== currentPageKey) {
        // Prevent the default navigation by pushing another state
        history.pushState(null, document.title, window.location.href);

        // Show confirmation for back button
        showConfirmation(
          "Navigate Away?",
          "Going back will end your current session. Are you sure you want to continue?",
          "fa-arrow-left",
          function () {
            // Set flag to prevent the beforeunload warning
            isLogoutConfirmed = true;
            // Allow navigation by ending session and redirecting
            window.location.href =
              "../../Functions/Auth/logoutFunction.php?message=You have navigated away from the application.";
          }
        );
      }
    });
  };

  // Initialize the history manipulation
  setupHistoryManipulation();

  // Add event listener to all logout buttons
  document.querySelectorAll(".logout-btn").forEach(function (button) {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      // Get the href from the button
      const logoutUrl = this.getAttribute("href");

      showConfirmation(
        "Confirm Logout",
        "Are you sure you want to log out? This will end your current session.",
        "fa-sign-out-alt",
        function () {
          // Set flag to prevent the beforeunload warning
          isLogoutConfirmed = true;
          // Proceed with logout by redirecting to the logout URL
          window.location.href = logoutUrl;
        }
      );
    });
  });

  // Show confirmation modal
  function showConfirmation(title, message, icon, callback) {
    // Set modal content
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    modalIcon.className = `fas ${icon} text-amber-500 text-4xl mb-4`;

    // Store the callback for later use
    actionCallback = callback;

    // Show the modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");
  }

  // Handle cancel button click
  cancelBtn.addEventListener("click", function () {
    // Hide the modal
    modal.classList.add("hidden");
    modal.classList.remove("flex");

    // Clear callback
    actionCallback = null;
  });

  // Handle confirm button click
  confirmBtn.addEventListener("click", function () {
    // Hide the modal
    modal.classList.add("hidden");
    modal.classList.remove("flex");

    // Execute the callback if it exists
    if (actionCallback) {
      actionCallback();
      actionCallback = null;
    }
  });

  // Handle beforeunload event but only if not confirmed logout
  window.addEventListener("beforeunload", function (e) {
    // Skip showing the confirmation if logout was already confirmed
    if (isLogoutConfirmed) {
      // Remove the event completely
      e.stopPropagation();
      return undefined;
    }

    // Otherwise show the browser's default confirmation dialog
    const confirmationMessage =
      "Are you sure you want to leave? Your session will end.";
    e.returnValue = confirmationMessage;
    return confirmationMessage;
  });
});
