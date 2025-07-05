/**
 * Session Status Checker
 *
 * Periodically checks if the current session is still valid
 */

document.addEventListener("DOMContentLoaded", function () {
  // Check session status every 30 seconds
  setInterval(checkSessionStatus, 30000);

  function checkSessionStatus() {
    fetch("../../Functions/Sessions/checkActiveSession.php")
      .then((response) => response.json())
      .then((data) => {
        if (!data.valid) {
          // Show alert and redirect to login
          alert(data.message || "Your session has ended. Please log in again.");
          window.location.href = "../../index.php";
        }
      })
      .catch((error) => console.error("Error checking session status:", error));
  }
});
