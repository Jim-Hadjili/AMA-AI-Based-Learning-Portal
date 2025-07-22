// Notification functions
function showInlineNotification(message, type) {
  const container = document.getElementById("notification-container");

  // Remove existing notification
  const existingNotification = container.querySelector(".inline-notification");
  if (existingNotification) {
    existingNotification.remove();
  }

  // Create new notification
  const notification = document.createElement("div");
  notification.className = `inline-notification inline-notification-${type}`;

  const icon =
    type === "success" ? "fa-check-circle" : "fa-exclamation-triangle";

  notification.innerHTML = `
                <span class="notification-icon">
                    <i class="fas ${icon}"></i>
                </span>
                <span>${message}</span>
                <span class="notification-close" onclick="closeInlineNotification(this)">
                    <i class="fas fa-times"></i>
                </span>
            `;

  container.appendChild(notification);

  // Show notification with animation
  setTimeout(() => {
    notification.classList.add("show");
  }, 10);

  // Auto-hide after 5 seconds
  setTimeout(() => {
    closeInlineNotification(notification.querySelector(".notification-close"));
  }, 5000);
}

function closeInlineNotification(closeBtn) {
  const notification = closeBtn.closest(".inline-notification");
  if (notification) {
    notification.classList.remove("show");
    setTimeout(() => {
      notification.remove();
    }, 300);
  }
}

// Form submission handlers
document
  .getElementById("signinForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector(".signin-btn-text");
    const btnLoading = submitBtn.querySelector(".signin-btn-loading");

    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add("hidden");
    btnLoading.classList.remove("hidden");

    try {
      const response = await fetch("./Assets/Auth/signInFunction.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        showInlineNotification(result.message, "success");

        // Redirect after showing success message
        setTimeout(() => {
          window.location.href = result.redirect;
        }, 1500);
      } else {
        showInlineNotification(result.message, "error");
      }
    } catch (error) {
      showInlineNotification("An error occurred. Please try again.", "error");
    } finally {
      // Reset button state
      submitBtn.disabled = false;
      btnText.classList.remove("hidden");
      btnLoading.classList.add("hidden");
    }
  });

document
  .getElementById("signupStudentForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector(".student-btn-text");
    const btnLoading = submitBtn.querySelector(".student-btn-loading");

    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add("hidden");
    btnLoading.classList.remove("hidden");

    try {
      const response = await fetch("./Assets/Auth/signUpStudentFunction.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        showInlineNotification(result.message, "success");
        // Reset form after successful submission
        setTimeout(() => {
          this.reset();
        }, 1000);
      } else {
        showInlineNotification(result.message, "error");
      }
    } catch (error) {
      showInlineNotification("An error occurred. Please try again.", "error");
    } finally {
      // Reset button state
      submitBtn.disabled = false;
      btnText.classList.remove("hidden");
      btnLoading.classList.add("hidden");
    }
  });

document
  .getElementById("signupTeacherForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector(".teacher-btn-text");
    const btnLoading = submitBtn.querySelector(".teacher-btn-loading");

    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add("hidden");
    btnLoading.classList.remove("hidden");

    try {
      const response = await fetch("./Assets/Auth/signUpTeacherFunction.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        showInlineNotification(result.message, "success");
        // Reset form after successful submission
        setTimeout(() => {
          this.reset();
        }, 1000);
      } else {
        showInlineNotification(result.message, "error");
      }
    } catch (error) {
      showInlineNotification("An error occurred. Please try again.", "error");
    } finally {
      // Reset button state
      submitBtn.disabled = false;
      btnText.classList.remove("hidden");
      btnLoading.classList.add("hidden");
    }
  });
