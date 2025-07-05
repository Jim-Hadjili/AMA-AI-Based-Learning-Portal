// Initialize event listeners
document.addEventListener("DOMContentLoaded", function () {
  // Initialize modal animations
  const modal = document.getElementById("addClassModal");
  const backdrop = modal;
  const content = modal.querySelector(".modal-content");

  // Show animations when opening modal
  const originalOpenAddClassModal = window.openAddClassModal;
  window.openAddClassModal = function () {
    originalOpenAddClassModal();

    // Trigger animations
    setTimeout(() => {
      backdrop.classList.add("show");
      content.classList.add("show");
    }, 10);
  };

  // Hide animations when closing modal
  const originalCloseAddClassModal = window.closeAddClassModal;
  window.closeAddClassModal = function () {
    backdrop.classList.remove("show");
    content.classList.remove("show");

    // Wait for animation to complete before hiding the modal
    setTimeout(() => {
      originalCloseAddClassModal();
    }, 300);
  };
});
