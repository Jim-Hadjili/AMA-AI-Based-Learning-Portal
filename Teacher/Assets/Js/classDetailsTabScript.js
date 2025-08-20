document.addEventListener("DOMContentLoaded", function () {
  // Add event listener for the Edit Class button in the Class Info tab
  const editClassInfoBtn = document.getElementById("editClassInfoBtn");
  if (editClassInfoBtn) {
    editClassInfoBtn.addEventListener("click", function () {
      // Call the global openEditClassModal function if available
      if (typeof window.openEditClassModal === "function") {
        window.openEditClassModal();
      } else {
        document.getElementById("editClassModal").classList.remove("hidden");
      }
    });
  }

  // Add event listeners for Announcement buttons
  const addFirstAnnouncementBtn = document.getElementById(
    "addFirstAnnouncementBtn"
  );
  const addAnnouncementBtn = document.getElementById("addAnnouncementBtn");

  if (addFirstAnnouncementBtn) {
    addFirstAnnouncementBtn.addEventListener("click", function () {
      if (typeof window.openAnnouncementModal === "function") {
        window.openAnnouncementModal();
      } else {
        document.getElementById("announcementModal").classList.remove("hidden");
      }
    });
  }

  if (addAnnouncementBtn) {
    addAnnouncementBtn.addEventListener("click", function () {
      if (typeof window.openAnnouncementModal === "function") {
        window.openAnnouncementModal();
      } else {
        document.getElementById("announcementModal").classList.remove("hidden");
      }
    });
  }

  // Get references to the new modals and their elements
  const editAnnouncementModal = document.getElementById(
    "editAnnouncementModal"
  );
  const editAnnouncementForm = document.getElementById("editAnnouncementForm");
  const editAnnouncementIdInput = document.getElementById("editAnnouncementId");
  const editAnnouncementTitleInput = document.getElementById(
    "editAnnouncementTitle"
  );
  const editAnnouncementContentTextarea = document.getElementById(
    "editAnnouncementContent"
  );
  const editPinAnnouncementCheckbox = document.getElementById(
    "editPinAnnouncement"
  );
  const closeEditAnnouncementModalBtn = editAnnouncementModal
    .querySelector(".fa-times")
    .closest("button");

  const deleteAnnouncementModal = document.getElementById(
    "deleteAnnouncementModal"
  );
  const announcementTitleToDelete = document.getElementById(
    "announcementTitleToDelete"
  );
  const deleteAnnouncementIdInput = document.getElementById(
    "deleteAnnouncementIdInput"
  ); // NEW: Get the hidden input for ID
  const deleteAnnouncementForm = document.getElementById(
    "deleteAnnouncementForm"
  ); // NEW: Get the delete form
  const cancelDeleteAnnouncementBtn = document.getElementById(
    "cancelDeleteAnnouncementBtn"
  );
  const closeDeleteAnnouncementModalBtn = document.getElementById(
    "closeDeleteAnnouncementModalBtn"
  );

  // Add event listeners for edit and delete announcement buttons
  const editAnnouncementBtns = document.querySelectorAll(
    ".edit-announcement-btn"
  );
  const deleteAnnouncementBtns = document.querySelectorAll(
    ".delete-announcement-btn"
  );

  editAnnouncementBtns.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent the parent card's click event from firing
      const card = this.closest(".announcement-card-clickable");
      const announcementId = card.getAttribute("data-announcement-id");
      const title = card.getAttribute("data-announcement-title");
      const content = card.getAttribute("data-announcement-content");
      const isPinned = card.getAttribute("data-announcement-pinned") === "true";

      editAnnouncementIdInput.value = announcementId;
      editAnnouncementTitleInput.value = title;
      editAnnouncementContentTextarea.value = content;
      editPinAnnouncementCheckbox.checked = isPinned;

      editAnnouncementModal.classList.remove("hidden");
    });
  });

  deleteAnnouncementBtns.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent the parent card's click event from firing
      const card = this.closest(".announcement-card-clickable");
      const announcementId = card.getAttribute("data-announcement-id");
      const title = card.getAttribute("data-announcement-title");

      deleteAnnouncementIdInput.value = announcementId; // Set the ID in the hidden input
      announcementTitleToDelete.textContent = title;

      deleteAnnouncementModal.classList.remove("hidden");
    });
  });

  // No need for a click listener on confirmDeleteAnnouncementBtn anymore,
  // as the form submission handles it directly.

  // Close delete modal buttons
  cancelDeleteAnnouncementBtn.addEventListener("click", () =>
    deleteAnnouncementModal.classList.add("hidden")
  );
  closeDeleteAnnouncementModalBtn.addEventListener("click", () =>
    deleteAnnouncementModal.classList.add("hidden")
  );
  deleteAnnouncementModal.addEventListener("click", function (event) {
    if (event.target === deleteAnnouncementModal) {
      deleteAnnouncementModal.classList.add("hidden");
    }
  });

  // Close edit modal button
  closeEditAnnouncementModalBtn.addEventListener("click", () =>
    editAnnouncementModal.classList.add("hidden")
  );
  editAnnouncementModal.addEventListener("click", function (event) {
    if (event.target === editAnnouncementModal) {
      editAnnouncementModal.classList.add("hidden");
    }
  });

  // Handle clicking on announcement cards to view full content (existing logic)
  const announcementCards = document.querySelectorAll(
    ".announcement-card-clickable"
  );
  const viewAnnouncementModal = document.getElementById(
    "viewAnnouncementModal"
  );
  const viewAnnouncementTitle = document.getElementById(
    "viewAnnouncementTitle"
  );
  const viewAnnouncementContent = document.getElementById(
    "viewAnnouncementContent"
  );
  const viewAnnouncementDate = document.getElementById("viewAnnouncementDate");
  const viewAnnouncementPinned = document.getElementById(
    "viewAnnouncementPinned"
  );

  announcementCards.forEach((card) => {
    card.addEventListener("click", function (event) {
      // Prevent opening modal if edit/delete buttons or their icons are clicked
      if (
        event.target.closest(".edit-announcement-btn") ||
        event.target.closest(".delete-announcement-btn")
      ) {
        return;
      }

      const title = this.getAttribute("data-announcement-title");
      const content = this.getAttribute("data-announcement-content");
      const date = this.getAttribute("data-announcement-date");
      const isPinned = this.getAttribute("data-announcement-pinned") === "true";

      viewAnnouncementTitle.textContent = title;
      // Replace newlines with <br> tags for proper display in HTML
      viewAnnouncementContent.innerHTML = content.replace(/\n/g, "<br>");
      viewAnnouncementDate.textContent = date;

      if (isPinned) {
        viewAnnouncementPinned.classList.remove("hidden");
      } else {
        viewAnnouncementPinned.classList.add("hidden");
      }

      viewAnnouncementModal.classList.remove("hidden");
    });
  });

  // Close view announcement modal when clicking outside
  viewAnnouncementModal.addEventListener("click", function (event) {
    if (event.target === viewAnnouncementModal) {
      viewAnnouncementModal.classList.add("hidden");
    }
  });
});
