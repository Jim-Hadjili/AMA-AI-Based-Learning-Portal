// Global variable to store class data for confirmation
let classToEnroll = null;

// Show search modal
function showJoinClassModal() {
  document.getElementById("joinClassModal").classList.remove("hidden");
  document.getElementById("classPreviewContainer").innerHTML = ""; // Clear previous preview
  document.getElementById("classCode").value = ""; // Clear input
}
// Hide search modal
document.getElementById("closeJoinClassModal").onclick = function () {
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
document.getElementById("closeConfirmJoinModal").onclick = function () {
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
document.getElementById("cancelJoinBtn").onclick = function () {
  document.getElementById("confirmJoinModal").classList.add("hidden");
  classToEnroll = null; // Clear stored data
};

// Handle Join Class Form Submission (AJAX to searchClassFunction.php)
document
  .getElementById("joinClassForm")
  .addEventListener("submit", async function (event) {
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
        // Dynamically create and display the class card
        const classCardHtml = `
                        <a href="#" class="group relative overflow-hidden bg-white rounded-xl border border-gray-200 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg class-card"
                            data-class-id="${classData.class_id}"
                            data-class-name="${classData.class_name}">
                            <div class="h-1.5 bg-gradient-to-r from-blue-400 to-indigo-500"></div>
                            <div class="p-5">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 flex-shrink-0 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                                        <i class="fas fa-graduation-cap text-blue-600 text-lg"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-semibold text-gray-900 mb-1 pr-8 line-clamp-2">${
                                              classData.class_name
                                            }</h3>
                                            <span class="text-xs font-medium px-2 py-1 bg-blue-50 text-blue-700 rounded-full flex-shrink-0">
                                                Grade ${classData.grade_level}
                                            </span>
                                        </div>
                                        <p class="text-xs font-medium text-gray-500 mb-3">
                                            <span class="inline-flex items-center space-x-1">
                                                <i class="fas fa-layer-group"></i>
                                                <span>${classData.strand}</span>
                                            </span>
                                        </p>
                                        ${
                                          classData.class_description
                                            ? `<p class="text-sm text-gray-600 mb-3 line-clamp-2">${classData.class_description}</p>`
                                            : ""
                                        }
                                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                            <span class="text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                ${new Date(
                                                  classData.created_at
                                                ).toLocaleDateString("en-US", {
                                                  month: "short",
                                                  day: "numeric",
                                                  year: "numeric",
                                                })}
                                            </span>
                                            <div class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                                Click to Join
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
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
        showNotification(result.message, "error");
      }
    } catch (error) {
      console.error("Error searching for class:", error);
      showNotification(
        "An unexpected error occurred while searching for the class.",
        "error"
      );
    }
  });

// Handle Confirmation Modal "Yes, Join Class" button click (AJAX to enrollClassFunction.php)
document
  .getElementById("confirmJoinBtn")
  .addEventListener("click", async function () {
    if (!classToEnroll) {
      showNotification("No class selected for enrollment.", "error");
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
        showNotification(result.message, "success");
        // Clear the URL parameters after showing the notification
        history.replaceState({}, document.title, window.location.pathname);
        // Optionally, refresh the class list on the dashboard
        setTimeout(() => {
          window.location.reload(); // Reload to show new class in "My Classes"
        }, 1000); // Give time for notification to be seen
      } else {
        showNotification(result.message, "error");
      }
    } catch (error) {
      console.error("Error enrolling in class:", error);
      showNotification(
        "An unexpected error occurred during enrollment.",
        "error"
      );
    } finally {
      classToEnroll = null; // Clear stored data
      document.getElementById("classPreviewContainer").innerHTML = ""; // Clear preview
    }
  });
