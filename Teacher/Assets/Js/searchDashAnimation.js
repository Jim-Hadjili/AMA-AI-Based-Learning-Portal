// Initialize modal animations specifically for search modal
document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("searchClassModal");
  if (!modal) return; // Exit if modal doesn't exist

  const backdrop = modal;
  const content = modal.querySelector(".modal-content");

  // Global function to open search modal (attached to window for easy access)
  window.openSearchModal = () => {
    modal.classList.remove("hidden");
    // Trigger animations
    setTimeout(() => {
      backdrop.classList.add("show"); // Assuming 'show' class handles opacity transition
      content.classList.add("show"); // Assuming 'show' class handles transform/scale transition
    }, 10); // Small delay to allow 'hidden' to be removed before 'show' is added
  };

  // Global function to close search modal
  window.closeSearchModal = () => {
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
      window.closeSearchModal();
    }
  });
});

// CSS for modal animations (add this to your teacherDashboard.css or a global CSS file)
// .modal-content {
//     transition: transform 0.3s ease-out, opacity 0.3s ease-out;
// }
// .modal-content.show {
//     transform: scale(1) translateX(0);
//     opacity: 1;
// }
// .modal-backdrop { /* If you have a separate backdrop element */
//     transition: opacity 0.3s ease-out;
// }
// .modal-backdrop.show {
//     opacity: 1;
// }
// For the provided HTML, the main modal div acts as backdrop.
// The `opacity-0` and `scale-95` on the modal-content are initial states
// The `show` class will be added to override them.
// Add this to your teacherDashboard.css or a similar CSS file for the transitions:
/*
.modal-content {
    transition: all 0.3s ease-out;
}
.modal-content.show {
    opacity: 1;
    transform: scale(1) translateX(0);
}
#searchClassModal {
    transition: opacity 0.3s ease-out;
}
#searchClassModal.show {
    opacity: 1;
}
*/
