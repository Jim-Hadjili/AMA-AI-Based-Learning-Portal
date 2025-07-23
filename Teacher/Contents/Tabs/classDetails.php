<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Include required files
include_once '../../Functions/userInfo.php';
include_once '../../Controllers/classController.php';
include_once '../../Controllers/classDetailsController.php';

// Check if class_id is provided
if (!isset($_GET['class_id']) || empty($_GET['class_id'])) {
    // Redirect to dashboard if no class_id is provided
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$class_id = intval($_GET['class_id']);

// Get all class data from the controller
$data = prepareClassDetailsData($conn, $class_id);

// If class not found or doesn't belong to current teacher, redirect to dashboard
if (!$data) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

// Extract the data
$classDetails = $data['classDetails'];
$students = $data['students'];
$quizzes = $data['quizzes'];
$materials = $data['materials'];
$stats = $data['stats'];

// Add this helper function and set class_subject:
function getSubjectFromClassName($className)
{
    $classNameLower = strtolower($className);
    $subjectKeywords = [
        'english' => 'English',
        'math' => 'Math',
        'science' => 'Science',
        'history' => 'History',
        'arts' => 'Arts',
        'pe' => 'PE',
        'ict' => 'ICT',
        'home economics' => 'Home Economics',
    ];
    foreach ($subjectKeywords as $keyword => $subject) {
        if (strpos($classNameLower, $keyword) !== false) {
            return $subject;
        }
    }
    return 'Default';
}
$classDetails['class_subject'] = getSubjectFromClassName($classDetails['class_name']);

// Extract stats for easier access in the view
$activeStudentCount = $stats['activeStudentCount'];
$pendingStudentCount = $stats['pendingStudentCount'];
$activeQuizCount = $stats['activeQuizCount'];

// --- Notification Logic ---
$notification_status = $_GET['status'] ?? '';
$notification_message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($classDetails['class_name']); ?> - Teacher Dashboard - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">

    <!-- Add custom animations for notifications -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        .animate-fadeOut {
            animation: fadeOut 0.3s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <!-- Main Content - Full Width without sidebar -->
    <div class="min-h-screen">

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6">

            <?php include "../Includes/classDetailsBreadcrumb.php"; ?>

            <!-- Class Header -->
            <?php include "../Includes/classDetailsHeader.php"; ?>

            <!-- Class Summary Stats -->
            <?php include "../Includes/classDetailsClassStats.php"; ?>

            <!-- Class Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-8">
                <!-- Main Content - full width on all screens -->
                <div class="space-y-6">
                    <?php include "../Includes/classDetailsTabs.php"; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Include modals -->
    <?php
    // Create the Modals directory if it's not already handled by your project structure
    $modalsDir = __DIR__ . '/../Modals';
    if (!file_exists($modalsDir)) {
        mkdir($modalsDir, 0755, true);
    }

    // Check if the files exist before including
    $editClassModalFile = $modalsDir . '/editClassModal.php';
    $addQuizModalFile = $modalsDir . '/addQuizModal.php';
    $quizTypeModalFile = $modalsDir . '/quizTypeModal.php';
    $quizQuestionsModalFile = $modalsDir . '/quizQuestionsModal.php';

    // Include modal files if they exist, otherwise display inline modals
    if (file_exists($editClassModalFile)) {
        include $editClassModalFile;
    } else {
        // Basic inline edit class modal
        echo '<div id="editClassModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Class</h3>
                    <p class="text-gray-600 mb-4">This is a placeholder. Create the modal file at: ' . htmlspecialchars($editClassModalFile) . '</p>
                    <div class="flex justify-end">
                        <button onclick="document.getElementById(\'editClassModal\').classList.add(\'hidden\')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Close</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    if (file_exists($addQuizModalFile)) {
        include $addQuizModalFile;
    } else {
        // Basic inline add quiz modal
        echo '<div id="addQuizModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Quiz</h3>
                    <p class="text-gray-600 mb-4">This is a placeholder. Create the modal file at: ' . htmlspecialchars($addQuizModalFile) . '</p>
                    <div class="flex justify-end">
                        <button onclick="document.getElementById(\'addQuizModal\').classList.add(\'hidden\')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Close</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    // Include quiz type modal
    if (file_exists($quizTypeModalFile)) {
        include $quizTypeModalFile;
    } else {
        // Basic inline quiz type modal
        echo '<div id="quizTypeModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Quiz Type</h3>
                    <p class="text-gray-600 mb-4">This is a placeholder. Create the modal file at: ' . htmlspecialchars($quizTypeModalFile) . '</p>
                    <div class="flex justify-end">
                        <button onclick="document.getElementById(\'quizTypeModal\').classList.add(\'hidden\')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Close</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    // Include quiz questions modal
    if (file_exists($quizQuestionsModalFile)) {
        include $quizQuestionsModalFile;
    } else {
        // Basic inline quiz questions modal
        echo '<div id="quizQuestionsModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Create Questions</h3>
                    <p class="text-600 mb-4">This is a placeholder. Create the modal file at: ' . htmlspecialchars($quizQuestionsModalFile) . '</p>
                    <div class="flex justify-end">
                        <button onclick="document.getElementById(\'quizQuestionsModal\').classList.add(\'hidden\')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Close</button>
                    </div>
                </div>
            </div>
        </div>';
    }
    ?>

    <script>
        // Basic modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Function to open the edit class modal
            window.openEditClassModal = function() {
                document.getElementById('editClassModal').classList.remove('hidden');
            }

            // Function to open the add quiz modal
            window.openAddQuizModal = function() {
                document.getElementById('addQuizModal').classList.remove('hidden');
            }

            // Add event listeners to buttons
            const editClassBtn = document.getElementById('editClassBtn');
            if (editClassBtn) {
                editClassBtn.addEventListener('click', openEditClassModal);
            }

            const addQuizBtn = document.getElementById('addQuizBtn');
            if (addQuizBtn) {
                addQuizBtn.addEventListener('click', openAddQuizModal);
            }

            // Copy class code functionality
            const copyCodeBtns = document.querySelectorAll('.copy-code-btn');
            copyCodeBtns.forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code)
                        .then(() => {
                            // Use the existing showNotification function
                            window.showNotification("Class code copied to clipboard!", "success");

                            // Change button icon temporarily
                            const originalHTML = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>';
                            setTimeout(() => {
                                this.innerHTML = originalHTML;
                            }, 1500);
                        })
                        .catch(err => {
                            // Use the existing showNotification function
                            window.showNotification("Failed to copy class code", "error");
                            console.error('Could not copy text: ', err);
                        });
                });
            });

            // --- Notification Display Logic for URL Parameters ---
            const notificationStatus = "<?php echo $notification_status; ?>";
            const notificationMessage = "<?php echo htmlspecialchars($notification_message); ?>";

            if (notificationStatus && notificationMessage) {
                // Use the existing showNotification function
                window.showNotification(notificationMessage, notificationStatus);

                // Clean URL parameters after displaying notification
                if (history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('status');
                    url.searchParams.delete('message');
                    history.replaceState(null, '', url.toString());
                }
            }
        });
    </script>

    <script src="../../Assets/Js/teacherDashAnimation.js"></script>
    <script src="../../Assets/Js/classDetails.js"></script>
</body>

</html>