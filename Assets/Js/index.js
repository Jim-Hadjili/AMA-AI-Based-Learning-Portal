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

function switchTab(tab) {
  const signupStudentForm = document.getElementById("signupStudentForm");
  const signupTeacherForm = document.getElementById("signupTeacherForm");
  const signinForm = document.getElementById("signinForm");
  const formTitle = document.getElementById("formTitle");
  const formSubtitle = document.getElementById("formSubtitle");
  const brandTitle = document.getElementById("brandTitle");
  const brandMessage = document.getElementById("brandMessage");
  const brandLogo = document.getElementById("brandLogo");

  // Clear all notifications when switching tabs
  document.querySelectorAll(".inline-notification").forEach((notification) => {
    notification.remove();
  });

  // Hide all forms with fade effect
  const allForms = [signupStudentForm, signupTeacherForm, signinForm];
  allForms.forEach((form) => {
    form.style.opacity = "0";
    form.style.transform = "translateY(20px)";
  });

  setTimeout(() => {
    // Hide all forms
    allForms.forEach((form) => form.classList.add("hidden"));

    // Show the selected form and update content
    if (tab === "signup_student") {
      signupStudentForm.classList.remove("hidden");
      formTitle.textContent = "Student Registration";
      formSubtitle.textContent = "Join our AI-powered learning community";
      brandTitle.textContent = "Start Your Learning Journey";
      brandMessage.textContent =
        "Experience personalized education with our adaptive AI system designed to help you excel in your academic pursuits.";
      brandLogo.src = "./assets/images/student.png";
      brandLogo.alt = "AMA College Logo";
    } else if (tab === "signup_teacher") {
      signupTeacherForm.classList.remove("hidden");
      formTitle.textContent = "Teacher Registration";
      formSubtitle.textContent = "Join our innovative education platform";
      brandTitle.textContent = "Shape the Future of Education";
      brandMessage.textContent =
        "Empower your teaching with AI-driven insights and tools designed to enhance student learning outcomes.";
      brandLogo.src = "./assets/images/teacher.png";
      brandLogo.alt = "AMA College Logo";
    } else {
      signinForm.classList.remove("hidden");
      formTitle.textContent = "Sign In";
      formSubtitle.textContent = "Access your personalized learning dashboard";
      brandTitle.textContent = "Welcome to the Future of Learning";
      brandMessage.textContent =
        "Experience our AI-powered adaptive education platform designed specifically for AMA Senior High School students and educators.";
      brandLogo.src = "./assets/images/logo.png";
      brandLogo.alt = "AMA College Logo";
    }

    // Show the active form with animation
    const activeForm = document.querySelector("form:not(.hidden)");
    if (activeForm) {
      setTimeout(() => {
        activeForm.style.opacity = "1";
        activeForm.style.transform = "translateY(0)";
      }, 50);
    }
  }, 200);
}

// Initialize the page
document.addEventListener("DOMContentLoaded", function () {
  // Set initial state
  switchTab("signin");

  // Add smooth transitions to all forms
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.style.transition = "opacity 0.3s ease, transform 0.3s ease";
  });

  // Add enhanced focus effects
  const inputs = document.querySelectorAll("input, select");
  inputs.forEach((input) => {
    input.addEventListener("focus", function () {
      this.parentElement.classList.add("scale-105");
    });

    input.addEventListener("blur", function () {
      this.parentElement.classList.remove("scale-105");
    });
  });
});
