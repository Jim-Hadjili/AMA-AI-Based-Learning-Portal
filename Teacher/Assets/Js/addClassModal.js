document.addEventListener("DOMContentLoaded", function () {
  // Elements
  const addClassBtn = document.getElementById("addClassBtn");
  const addClassModal = document.getElementById("addClassModal");
  const closeAddClassModal = document.getElementById("closeAddClassModal");
  const cancelAddClass = document.getElementById("cancelAddClass");
  const addClassModalBackdrop = document.getElementById(
    "addClassModalBackdrop"
  );
  const generateCodeBtn = document.getElementById("generateCode");
  const courseCodeInput = document.getElementById("class_code");
  const addClassForm = document.getElementById("addClassForm");

  // Make these functions global so they can be called from HTML onclick if needed
  window.openAddClassModal = function () {
    if (addClassModal) {
      addClassModal.classList.remove("hidden");
      document.body.classList.add("overflow-hidden");
      console.log("Modal opened");
    } else {
      console.error("Modal element not found");
    }
  };

  window.closeAddClassModal = function () {
    if (addClassModal) {
      addClassModal.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
      if (addClassForm) addClassForm.reset();
      console.log("Modal closed");
    }
  };

  window.generateClassCode = function () {
    // Generate a random 6-character alphanumeric code
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    let code = "";
    for (let i = 0; i < 6; i++) {
      code += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    if (courseCodeInput) courseCodeInput.value = code;
  };

  // Add event listeners if elements exist
  if (addClassBtn) {
    addClassBtn.addEventListener("click", function (e) {
      e.preventDefault();
      window.openAddClassModal();
    });
    console.log("Add Class button event listener added");
  } else {
    console.error("Add Class button not found");
  }

  if (closeAddClassModal) {
    closeAddClassModal.addEventListener("click", window.closeAddClassModal);
  }

  if (cancelAddClass) {
    cancelAddClass.addEventListener("click", window.closeAddClassModal);
  }

  if (addClassModalBackdrop) {
    addClassModalBackdrop.addEventListener("click", window.closeAddClassModal);
  }

  if (generateCodeBtn) {
    generateCodeBtn.addEventListener("click", window.generateClassCode);
  }

  // Form submission
  if (addClassForm) {
    addClassForm.addEventListener("submit", function (e) {
      e.preventDefault();
      window.submitAddClassForm(e);
    });
  }

  // Form submission handler
  window.submitAddClassForm = function (e) {
    e.preventDefault();
    console.log("Form submitted");

    // Get form data
    const formData = new FormData(addClassForm);

    // AJAX call to submit the form data
    fetch("../../Functions/addClass.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Show success notification
          window.showNotification("Class created successfully!", "success");

          // Close the modal
          window.closeAddClassModal();

          // Reload the page to show the new class
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        } else {
          // Show error notification
          window.showNotification(
            data.message || "Error creating class",
            "error"
          );
        }
      })
      .catch((error) => {
        window.showNotification(
          "An error occurred. Please try again.",
          "error"
        );
        console.error("Error:", error);
      });
  };

  // Notification function
  window.showNotification = function (message, type) {
    const notification = document.createElement("div");
    notification.className = `px-4 py-2 rounded-lg shadow-lg text-white ${
      type === "success" ? "bg-green-500" : "bg-red-500"
    } flex items-center animate-fade-in`;

    const icon = document.createElement("i");
    icon.className = `fas ${
      type === "success" ? "fa-check-circle" : "fa-exclamation-circle"
    } mr-2`;

    notification.appendChild(icon);
    notification.appendChild(document.createTextNode(message));

    const container = document.getElementById("notification-container");
    if (container) {
      container.appendChild(notification);

      // Remove notification after 3 seconds
      setTimeout(() => {
        notification.classList.add("animate-fade-out");
        setTimeout(() => {
          container.removeChild(notification);
        }, 300);
      }, 3000);
    }
  };

  // Debug check for elements
  console.log("Modal initialization complete");
  console.log("Modal element exists:", !!addClassModal);
  console.log("Add Class button exists:", !!addClassBtn);
});
