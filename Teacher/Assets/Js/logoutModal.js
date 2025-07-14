// Logout Confirmation Modal Functions
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("logoutConfirmationModal");
  if (!modal) return; // Exit if modal doesn't exist

  const backdrop = modal;
  const content = modal.querySelector(".modal-content");
  const logoutSidebarBtn = document.getElementById("logoutSidebarBtn"); // Get the logout button

  // Global function to open logout modal
  window.openLogoutConfirmationModal = () => {
    modal.classList.remove("hidden");
    // Trigger animations
    setTimeout(() => {
      backdrop.classList.add("show");
      content.classList.add("show");
    }, 10); // Small delay to allow 'hidden' to be removed before 'show' is added
  };

  // Global function to close logout modal
  window.closeLogoutConfirmationModal = () => {
    backdrop.classList.remove("show");
    content.classList.remove("show");

    // Wait for animation to complete before hiding the modal
    setTimeout(() => {
      modal.classList.add("hidden");
    }, 300); // Matches the transition duration in CSS
  };

  // Close modal when clicking outside of the content area
  backdrop.addEventListener("click", (event) => {
    if (event.target === backdrop) {
      window.closeLogoutConfirmationModal();
    }
  });

  // Add event listener to the logout button to prevent default behavior
  if (logoutSidebarBtn) {
    logoutSidebarBtn.addEventListener("click", (event) => {
      event.preventDefault(); // THIS IS THE KEY: Prevents the default link navigation
      window.openLogoutConfirmationModal();
    });
  }
});
