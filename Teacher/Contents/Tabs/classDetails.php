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

// Extract stats for easier access in the view
$activeStudentCount = $stats['activeStudentCount'];
$pendingStudentCount = $stats['pendingStudentCount'];
$activeQuizCount = $stats['activeQuizCount'];
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
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
            <!-- Class Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <a href="../Dashboard/teachersDashboard.php" class="bg-white/80 hover:bg-white text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200/50">
                            <i class="fas fa-arrow-left mr-2"></i> Dashboard
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($classDetails['class_name']); ?></h1>
                        <span class="px-2.5 py-1 text-xs rounded-full <?php echo $classDetails['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?>">
                            <?php echo ucfirst($classDetails['status']); ?>
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 ml-1"><?php echo htmlspecialchars($classDetails['class_description'] ?? 'No description available'); ?></p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button id="editClassBtn" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all duration-300 flex items-center shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Edit Class</span>
                    </button>
                    <button id="addQuizBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center shadow-sm">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add Quiz</span>
                    </button>
                </div>
            </div>

            <!-- Class Summary Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <!-- Students Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-600">Students</span>
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <span class="text-xl font-bold text-gray-900"><?php echo $activeStudentCount; ?></span>
                        <?php if ($pendingStudentCount > 0): ?>
                        <span class="ml-1 text-xs text-gray-500">+ <?php echo $pendingStudentCount; ?> pending</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Quizzes Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-600">Quizzes</span>
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tasks text-purple-600"></i>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <span class="text-xl font-bold text-gray-900"><?php echo count($quizzes); ?></span>
                        <?php if ($activeQuizCount > 0): ?>
                        <span class="ml-1 text-xs text-gray-500">(<?php echo $activeQuizCount; ?> active)</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Class Code Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-600">Class Code</span>
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-key text-green-600"></i>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-base font-mono font-medium text-gray-900"><?php echo htmlspecialchars($classDetails['class_code'] ?? 'N/A'); ?></span>
                        <?php if (isset($classDetails['class_code'])): ?>
                        <button class="copy-code-btn ml-2 text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                            <i class="fas fa-copy"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Grade Level Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-600">Grade Level</span>
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <span class="text-xl font-bold text-gray-900">Grade <?php echo htmlspecialchars($classDetails['grade_level'] ?? 'N/A'); ?></span>
                        <?php if (!empty($classDetails['strand'])): ?>
                        <span class="ml-1 text-xs text-gray-500">(<?php echo htmlspecialchars($classDetails['strand']); ?>)</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Class Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Main Content - 2/3 width on large screens -->
                <div class="lg:col-span-2 space-y-6">
                    <?php include "../Includes/classDetailsTabs.php"; ?>
                </div>
                
                <!-- Sidebar - 1/3 width on large screens -->
                <div class="space-y-6">
                    <?php include "../Includes/classDetailsSidebar.php"; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Include modals -->
    <?php 
    // Create the Modals directory if it doesn't exist
    $modalsDir = __DIR__ . '/../Modals';
    if (!file_exists($modalsDir)) {
        mkdir($modalsDir, 0755, true);
    }
    
    // Check if the files exist before including
    $editClassModalFile = $modalsDir . '/editClassModal.php';
    $addQuizModalFile = $modalsDir . '/addQuizModal.php';
    
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
                            alert('Class code copied to clipboard!');
                        })
                        .catch(err => {
                            console.error('Could not copy text: ', err);
                        });
                });
            });
        });
    </script>

    <script src="../../Assets/Js/teacherDashAnimation.js"></script>
    <script src="../../Assets/Js/classDetails.js"></script>
</body>
</html>