// Global variable to store class data for confirmation
let classToEnroll = null;

// Define status colors for the badges (JavaScript equivalent)
const statusColors = {
  active: "bg-green-100 text-green-800",
  inactive: "bg-red-100 text-red-800",
  archived: "bg-gray-100 text-gray-800",
  pending: "bg-yellow-100 text-yellow-800",
};

// Define subject-specific styles (JavaScript equivalent)
const subjectStyles = {
  English: {
    strip: "from-blue-500 to-blue-700",
    icon_bg: "bg-blue-100",
    icon_color: "text-blue-600",
    icon_class: "fas fa-book-reader",
  },
  Math: {
    strip: "from-green-500 to-green-700",
    icon_bg: "bg-green-100",
    icon_color: "text-green-600",
    icon_class: "fas fa-calculator",
  },
  Science: {
    strip: "from-purple-500 to-purple-700",
    icon_bg: "bg-purple-100",
    icon_color: "text-purple-600",
    icon_class: "fas fa-flask",
  },
  History: {
    strip: "from-yellow-500 to-yellow-700",
    icon_bg: "bg-yellow-100",
    icon_color: "text-yellow-600",
    icon_class: "fas fa-landmark",
  },
  Arts: {
    strip: "from-pink-500 to-pink-700",
    icon_bg: "bg-pink-100",
    icon_color: "text-pink-600",
    icon_class: "fas fa-paint-brush",
  },
  PE: {
    strip: "from-red-500 to-red-700",
    icon_bg: "bg-red-100",
    icon_color: "text-red-600",
    icon_class: "fas fa-running",
  },
  ICT: {
    strip: "from-indigo-500 to-indigo-700",
    icon_bg: "bg-indigo-100",
    icon_color: "text-indigo-600",
    icon_class: "fas fa-laptop-code",
  },
  "Home Economics": {
    strip: "from-orange-500 to-orange-700",
    icon_bg: "bg-orange-100",
    icon_color: "text-orange-600",
    icon_class: "fas fa-utensils",
  },
  Default: {
    strip: "from-gray-500 to-gray-700",
    icon_bg: "bg-gray-100",
    icon_color: "text-gray-600",
    icon_class: "fas fa-graduation-cap",
  },
};

// Helper function to determine subject from class name
function getSubjectFromClassName(className) {
  const classNameLower = className.toLowerCase();
  const subjectKeywords = {
    english: "English",
    math: "Math",
    science: "Science",
    history: "History",
    arts: "Arts",
    pe: "PE",
    ict: "ICT",
    "home economics": "Home Economics",
  };

  for (const keyword in subjectKeywords) {
    if (classNameLower.includes(keyword)) {
      return subjectKeywords[keyword];
    }
  }
  return "Default";
}

// IMPORTANT: The showNotification function is now expected to be defined globally
// by Assets/Scripts/notif.js. Do NOT redefine it here.

// Show search modal
function showJoinClassModal() {
  document.getElementById("joinClassModal").classList.remove("hidden");
  document.getElementById("classPreviewContainer").innerHTML = ""; // Clear previous preview
  document.getElementById("classCode").value = ""; // Clear input
}
// Hide search modal
document.getElementById("closeJoinClassModal").onclick = () => {
  document.getElementById("joinClassModal").classList.add("hidden");
  document.getElementById("classPreviewContainer").innerHTML = ""; // Clear preview on close
};
// Hide search modal on outside click
document.getElementById("joinClassModal").onclick = function (e) {
  if (e.target === this) {
    this.classList.add("hidden");
    document.getElementById("classPreviewContainer").innerHTML = ""; // Clear preview on outside click
  }
};

// Show confirmation modal
function showConfirmJoinModal(className, classId) {
  document.getElementById("confirmClassName").textContent = className;
  document.getElementById("confirmJoinModal").classList.remove("hidden");
  classToEnroll = { id: classId, name: className }; // Store class data
}
// Hide confirmation modal
document.getElementById("closeConfirmJoinModal").onclick = () => {
  document.getElementById("confirmJoinModal").classList.add("hidden");
  classToEnroll = null; // Clear stored data
};
// Hide confirmation modal on outside click
document.getElementById("confirmJoinModal").onclick = function (e) {
  if (e.target === this) {
    this.classList.add("hidden");
    classToEnroll = null; // Clear stored data
  }
};
// Cancel button in confirmation modal
document.getElementById("cancelJoinBtn").onclick = () => {
  document.getElementById("confirmJoinModal").classList.add("hidden");
  classToEnroll = null; // Clear stored data
};

// Handle Join Class Form Submission (AJAX to searchClassFunction.php)
document
  .getElementById("joinClassForm")
  .addEventListener("submit", async (event) => {
    event.preventDefault(); // Prevent default form submission

    const classCodeInput = document.getElementById("classCode");
    const classCode = classCodeInput.value;
    const classPreviewContainer = document.getElementById(
      "classPreviewContainer"
    );

    // Clear previous preview
    classPreviewContainer.innerHTML = "";

    try {
      const formData = new FormData();
      formData.append("class_code", classCode);

      const response = await fetch("../../Functions/searchClassFunction.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.status === "success") {
        const classData = result.class;
        const description =
          classData.class_description || "No description provided.";
        const strand = classData.strand || "N/A";
        const studentCount = classData.student_count || 0;
        const quizCount = classData.quiz_count || 0;
        const statusClass =
          statusColors[classData.status] || statusColors.inactive;

        // Determine subject-specific styles using the derived class_subject
        const subject = getSubjectFromClassName(classData.class_name);
        const style = subjectStyles[subject] || subjectStyles.Default;

        // Dynamically create and display the class card
        const classCardHtml = `
          <a href="#" class="group relative overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 class-card"
              data-class-id="${classData.class_id}"
              data-class-name="${classData.class_name}">
              <!-- Class Card Header with Color Strip -->
              <div class="h-2 bg-gradient-to-r ${style.strip}"></div>
              <div class="p-5">
                  <div class="flex justify-between items-start mb-4">
                      <h3 class="font-semibold text-lg text-gray-900">${
                        classData.class_name
                      }</h3>
                      <span class="px-2 py-1 text-xs rounded-full ${statusClass}">
                          ${
                            classData.status.charAt(0).toUpperCase() +
                            classData.status.slice(1)
                          }
                      </span>
                  </div>
                  <p class="text-sm text-gray-600 mb-4 line-clamp-2">${description}</p>
                  <div class="grid grid-cols-2 gap-2 mb-4">
                      <div class="bg-gray-50 p-2 rounded">
                          <p class="text-xs text-gray-500">Grade</p>
                          <p class="font-medium text-sm text-gray-800">Grade ${
                            classData.grade_level
                          }</p>
                      </div>
                      <div class="bg-gray-50 p-2 rounded">
                          <p class="text-xs text-gray-500">Strand</p>
                          <p class="font-medium text-sm text-gray-800">${strand}</p>
                      </div>
                  </div>
                  <div class="flex justify-between text-sm">
                      <div class="flex items-center text-gray-600">
                          <i class="fas fa-users mr-2 ${style.icon_color}"></i>
                          <span>${studentCount} Students</span>
                      </div>
                      <div class="flex items-center text-gray-600">
                          <i class="fas fa-book mr-2 ${style.icon_color}"></i>
                          <span>${quizCount} Quizzes</span>
                      </div>
                  </div>
                  <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                      <div class="text-xs text-gray-500">
                          <i class="fas fa-key mr-1"></i>
                          Code: <span class="font-mono font-medium">${
                            classData.class_code
                          }</span>
                      </div>
                      <div class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                          Click to Join <i class="fas fa-arrow-right ml-1"></i>
                      </div>
                  </div>
              </div>
          </a>
        `;
        classPreviewContainer.innerHTML = classCardHtml;

        // Add event listener to the dynamically created card
        const previewCard = classPreviewContainer.querySelector(".class-card");
        if (previewCard) {
          previewCard.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default link behavior
            const className = this.dataset.className;
            const classId = this.dataset.classId;
            showConfirmJoinModal(className, classId);
          });
        }
      } else {
        // Use the global showNotification function
        window.showNotification(result.message, "error");
      }
    } catch (error) {
      console.error("Error searching for class:", error);
      // Use the global showNotification function
      window.showNotification(
        "An unexpected error occurred while searching for the class.",
        "error"
      );
    }
  });

// Handle Confirmation Modal "Yes, Join Class" button click (AJAX to enrollClassFunction.php)
document
  .getElementById("confirmJoinBtn")
  .addEventListener("click", async () => {
    if (!classToEnroll) {
      // Use the global showNotification function
      window.showNotification("No class selected for enrollment.", "error");
      return;
    }

    document.getElementById("confirmJoinModal").classList.add("hidden"); // Hide confirmation modal

    try {
      const formData = new FormData();
      formData.append("class_id", classToEnroll.id);

      const response = await fetch("../../Functions/enrollClassFunction.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.status === "success") {
        // Use the global showNotification function
        window.showNotification(result.message, "success");
        // Clear the URL parameters after showing the notification
        history.replaceState({}, document.title, window.location.pathname);
        // Optionally, refresh the class list on the dashboard
        setTimeout(() => {
          window.location.reload(); // Reload to show new class in "My Classes"
        }, 1000); // Give time for notification to be seen
      } else {
        // Use the global showNotification function
        window.showNotification(result.message, "error");
      }
    } catch (error) {
      console.error("Error enrolling in class:", error);
      // Use the global showNotification function
      window.showNotification(
        "An unexpected error occurred during enrollment.",
        "error"
      );
    } finally {
      classToEnroll = null; // Clear stored data
      document.getElementById("classPreviewContainer").innerHTML = ""; // Clear preview
    }
  });
