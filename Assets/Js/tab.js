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
      brandLogo.src = "./Assets/Images/student.png";
      brandLogo.alt = "AMA College Logo";
    } else if (tab === "signup_teacher") {
      signupTeacherForm.classList.remove("hidden");
      formTitle.textContent = "Teacher Registration";
      formSubtitle.textContent = "Join our innovative education platform";
      brandTitle.textContent = "Shape the Future of Education";
      brandMessage.textContent =
        "Empower your teaching with AI-driven insights and tools designed to enhance student learning outcomes.";
      brandLogo.src = "./Assets/Images/teacher.png";
      brandLogo.alt = "AMA College Logo";
    } else {
      signinForm.classList.remove("hidden");
      formTitle.textContent = "Sign In";
      formSubtitle.textContent = "Access your personalized learning dashboard";
      brandTitle.textContent = "Welcome to the Future of Learning";
      brandMessage.textContent =
        "Experience our AI-powered adaptive education platform designed specifically for AMA Senior High School students and educators.";
      brandLogo.src = "./Assets/Images/Logo.png";
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
