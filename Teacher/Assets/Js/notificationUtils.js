/**
 * Show a custom notification
 *
 * @param {string} type - Type of notification: 'success' or 'error'
 * @param {string} title - Title text for the notification
 * @param {string} message - Message text for the notification
 * @param {number} duration - Time in milliseconds before auto-closing (default: 5000ms)
 */
function showNotification(type, title, message, duration = 5000) {
  // Create notification container if it doesn't exist
  let notificationContainer = document.getElementById("notification-container");
  if (!notificationContainer) {
    notificationContainer = document.createElement("div");
    notificationContainer.id = "notification-container";
    document.body.appendChild(notificationContainer);
  }

  // Create notification element
  const notification = document.createElement("div");
  notification.className = `custom-notification notification-${type}`;

  // Create notification content
  notification.innerHTML = `
        <div class="notification-icon">
            ${
              type === "success"
                ? '<i class="fas fa-check-circle"></i>'
                : '<i class="fas fa-exclamation-circle"></i>'
            }
        </div>
        <div class="notification-content">
            <div class="notification-title">${title}</div>
            <div class="notification-message">${message}</div>
        </div>
        <button class="notification-close" aria-label="Close notification">
            <i class="fas fa-times"></i>
        </button>
        <div class="notification-progress"></div>
    `;

  // Add notification to container
  notificationContainer.appendChild(notification);

  // Set up close button
  const closeButton = notification.querySelector(".notification-close");
  closeButton.addEventListener("click", () => {
    closeNotification(notification);
  });

  // Show notification (delayed to allow for animation)
  setTimeout(() => {
    notification.classList.add("notification-visible");
  }, 10);

  // Auto-close after duration
  const autoCloseTimeout = setTimeout(() => {
    closeNotification(notification);
  }, duration);

  // Store the timeout reference for potential early clearing
  notification.dataset.timeoutId = autoCloseTimeout;

  // Return notification element in case further manipulation is needed
  return notification;
}

/**
 * Close a notification
 *
 * @param {HTMLElement} notification - Notification element to close
 */
function closeNotification(notification) {
  // Clear the auto-close timeout if it exists
  if (notification.dataset.timeoutId) {
    clearTimeout(parseInt(notification.dataset.timeoutId));
  }

  // Start exit animation
  notification.classList.remove("notification-visible");

  // Remove from DOM after animation completes
  setTimeout(() => {
    if (notification.parentNode) {
      notification.parentNode.removeChild(notification);
    }
  }, 300);
}
