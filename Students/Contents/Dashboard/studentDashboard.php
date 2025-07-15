<?php include "../../Functions/studentDashboardFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
    <style>
        /* Notification Container */
        #notification-container {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1000;
            display: flex;
            flex-direction: column; /* Stack new notifications on top */
            gap: 0.75rem;
            align-items: flex-end; /* Align notifications to the right */
        }

        /* Basic fade-in/out animation for Tailwind's animate-fadeIn */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    <?php include "DashboardsIncludes/studentsSidebar.php" ?>

    <!-- Main Content -->
    <div id="main-content" class="lg:ml-16 min-h-screen transition-all duration-300">

        <!-- Header -->
        <?php include "DashboardsIncludes/studentsHeader.php" ?>

        <!-- Main Content Area with padding to offset fixed header -->
        <main class="p-4 lg:p-6 pt-6">
            <!-- Welcome Section with Search Button -->
            <?php include "DashboardsIncludes/welcomeSection.php" ?>

            <!-- Stats Cards -->
            <?php include "DashboardsIncludes/studentsStatsCards.php" ?>

            <!-- My Classes Section -->
            <?php include "DashboardsIncludes/studentsClassSection.php" ?>

            <!-- Content Sections -->
            <?php include "DashboardsIncludes/studentsContentSection.php" ?>
        </main>
    </div>

    <!-- Toggle Classe sView -->
    <script src="../../Assets/Scripts/toggleClassesView.js"> </script>

    <!-- Join Class Modal (Search Modal) -->
    <div id="joinClassModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button id="closeJoinClassModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-900">Join a Class</h2>
            <form id="joinClassForm" method="POST" action="../../Functions/searchClassFunction.php">
                <label for="classCode" class="block text-sm font-medium text-gray-700 mb-2">Enter Class Code</label>
                <input type="text" id="classCode" name="class_code" required class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg font-medium w-full">Search Class</button>
            </form>
            <div id="classPreviewContainer" class="mt-6">
                <!-- Class card will be displayed here -->
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmJoinModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 relative">
            <button id="closeConfirmJoinModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-900">Confirm Enrollment</h2>
            <p class="text-gray-700 mb-6">Are you sure you want to join "<span id="confirmClassName" class="font-semibold"></span>"?</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelJoinBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button id="confirmJoinBtn" class="bg-blue-primary hover:bg-blue-dark text-white px-4 py-2 rounded-lg font-medium">Yes, Join Class</button>
            </div>
        </div>
    </div>

    <script>
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

            let container = document.getElementById("notification-container");
            if (!container) {
                container = document.createElement("div");
                container.id = "notification-container";
                document.body.appendChild(container);
            }

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

        // Global variable to store class data for confirmation
        let classToEnroll = null;

        // Show search modal
        function showJoinClassModal() {
            document.getElementById('joinClassModal').classList.remove('hidden');
            document.getElementById('classPreviewContainer').innerHTML = ''; // Clear previous preview
            document.getElementById('classCode').value = ''; // Clear input
        }
        // Hide search modal
        document.getElementById('closeJoinClassModal').onclick = function() {
            document.getElementById('joinClassModal').classList.add('hidden');
            document.getElementById('classPreviewContainer').innerHTML = ''; // Clear preview on close
        };
        // Hide search modal on outside click
        document.getElementById('joinClassModal').onclick = function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.getElementById('classPreviewContainer').innerHTML = ''; // Clear preview on outside click
            }
        };

        // Show confirmation modal
        function showConfirmJoinModal(className, classId) {
            document.getElementById('confirmClassName').textContent = className;
            document.getElementById('confirmJoinModal').classList.remove('hidden');
            classToEnroll = { id: classId, name: className }; // Store class data
        }
        // Hide confirmation modal
        document.getElementById('closeConfirmJoinModal').onclick = function() {
            document.getElementById('confirmJoinModal').classList.add('hidden');
            classToEnroll = null; // Clear stored data
        };
        // Hide confirmation modal on outside click
        document.getElementById('confirmJoinModal').onclick = function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                classToEnroll = null; // Clear stored data
            }
        };
        // Cancel button in confirmation modal
        document.getElementById('cancelJoinBtn').onclick = function() {
            document.getElementById('confirmJoinModal').classList.add('hidden');
            classToEnroll = null; // Clear stored data
        };

        // Handle Join Class Form Submission (AJAX to searchClassFunction.php)
        document.getElementById('joinClassForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent default form submission

            const classCodeInput = document.getElementById('classCode');
            const classCode = classCodeInput.value;
            const classPreviewContainer = document.getElementById('classPreviewContainer');

            // Clear previous preview
            classPreviewContainer.innerHTML = '';

            try {
                const formData = new FormData();
                formData.append('class_code', classCode);

                const response = await fetch('../../Functions/searchClassFunction.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
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
                                            <h3 class="font-semibold text-gray-900 mb-1 pr-8 line-clamp-2">${classData.class_name}</h3>
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
                                        ${classData.class_description ? `<p class="text-sm text-gray-600 mb-3 line-clamp-2">${classData.class_description}</p>` : ''}
                                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                            <span class="text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                ${new Date(classData.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
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
                    const previewCard = classPreviewContainer.querySelector('.class-card');
                    if (previewCard) {
                        previewCard.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent default link behavior
                            const className = this.dataset.className;
                            const classId = this.dataset.classId;
                            showConfirmJoinModal(className, classId);
                        });
                    }

                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error searching for class:', error);
                showNotification('An unexpected error occurred while searching for the class.', 'error');
            }
        });

        // Handle Confirmation Modal "Yes, Join Class" button click (AJAX to enrollClassFunction.php)
        document.getElementById('confirmJoinBtn').addEventListener('click', async function() {
            if (!classToEnroll) {
                showNotification('No class selected for enrollment.', 'error');
                return;
            }

            document.getElementById('confirmJoinModal').classList.add('hidden'); // Hide confirmation modal

            try {
                const formData = new FormData();
                formData.append('class_id', classToEnroll.id);

                const response = await fetch('../../Functions/enrollClassFunction.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showNotification(result.message, 'success');
                    // Clear the URL parameters after showing the notification
                    history.replaceState({}, document.title, window.location.pathname);
                    // Optionally, refresh the class list on the dashboard
                    setTimeout(() => {
                        window.location.reload(); // Reload to show new class in "My Classes"
                    }, 1000); // Give time for notification to be seen
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error enrolling in class:', error);
                showNotification('An unexpected error occurred during enrollment.', 'error');
            } finally {
                classToEnroll = null; // Clear stored data
                document.getElementById('classPreviewContainer').innerHTML = ''; // Clear preview
            }
        });

        <?php
        // Call showNotification based on URL parameters
        if (isset($_GET['error']) || isset($_GET['success'])) {
            $message = '';
            $type = '';

            if (isset($_GET['error'])) {
                $type = 'error';
                switch ($_GET['error']) {
                    case 'missing':
                        $message = 'Class code or student ID missing.';
                        break;
                    case 'invalid':
                        $message = 'Invalid class code. Please try again.';
                        break;
                    case 'already':
                        $message = 'You are already enrolled in this class.';
                        break;
                    default:
                        $message = 'An unknown error occurred.';
                }
            } elseif (isset($_GET['success']) && $_GET['success'] === 'joined') {
                $type = 'success';
                $message = 'You have successfully joined the class.';
            }

            if (!empty($message)) {
                echo "showNotification('" . htmlspecialchars($message) . "', '" . htmlspecialchars($type) . "');";
                // Clear the URL parameters after showing the notification on initial load
                echo "history.replaceState({}, document.title, window.location.pathname);";
            }
        }
        ?>
    </script>

</body>

</html>
