function showNotification(message, type) {
  const notification = document.createElement("div");
  notification.className = `px-4 py-2 rounded-lg shadow-lg text-white ${
    type === "success" ? "bg-green-500" : "bg-red-500"
  } flex items-center animate-fadeIn`;
  const icon = document.createElement("i");
  icon.className = `fas ${
    type === "success" ? "fa-check-circle" : "fa-exclamation-circle"
  } mr-2`;
  notification.appendChild(icon);
  notification.appendChild(document.createTextNode(message));

  let container = document.getElementById("notification-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "notification-container";
    document.body.appendChild(container);
  }

  container.appendChild(notification);

  // Add CSS animation
  notification.style.opacity = "0";
  notification.style.transform = "translateY(20px)";

  // Trigger animation
  setTimeout(() => {
    notification.style.transition = "opacity 0.3s ease, transform 0.3s ease";
    notification.style.opacity = "1";
    notification.style.transform = "translateY(0)";
  }, 10);

  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.style.opacity = "0";
    notification.style.transform = "translateY(-20px)";
    setTimeout(() => {
      if (container.contains(notification)) {
        container.removeChild(notification);
      }
    }, 300);
  }, 3000);
}
