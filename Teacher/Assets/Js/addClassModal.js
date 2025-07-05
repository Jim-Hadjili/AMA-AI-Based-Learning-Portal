document.addEventListener("DOMContentLoaded", function () {
  console.log("addClassModal.js loaded");

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

  // Log element existence for debugging
  console.log("addClassBtn exists:", !!addClassBtn);
  console.log("addClassModal exists:", !!addClassModal);
  console.log("addClassForm exists:", !!addClassForm);

  // Check if elements exist
  if (!addClassBtn || !addClassModal) {
    console.error("Required elements not found for modal functionality");
    return;
  }

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
  addClassBtn.addEventListener("click", function (e) {
    e.preventDefault();
    window.openAddClassModal();
  });

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

      // Show loading state
      const submitBtn = document.getElementById("submitAddClass");
      const originalText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin mr-1"></i> Adding...';

      // Get form data
      const formData = new FormData(addClassForm);

      // AJAX call to submit the form data
      fetch("../../Functions/createClass.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            // Show success notification
            showNotification("Class created successfully!", "success");

            // Close the modal
            window.closeAddClassModal();

            // Reload the page to show the new class
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            // Show error notification
            showNotification(data.message || "Error creating class", "error");

            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          }
        })
        .catch((error) => {
          showNotification("An error occurred. Please try again.", "error");
          console.error("Error:", error);

          // Reset button
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        });
    });
  }

  // Notification function
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

    const container = document.getElementById("notification-container");
    if (container) {
      container.appendChild(notification);

      // Add CSS animation
      notification.style.opacity = "0";
      notification.style.transform = "translateY(20px)";

      // Trigger animation
      setTimeout(() => {
        notification.style.transition =
          "opacity 0.3s ease, transform 0.3s ease";
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
  }

  // Debug check for elements
  console.log("Modal initialization complete");
});
