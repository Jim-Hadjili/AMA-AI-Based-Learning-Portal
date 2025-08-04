<?php include "../../Functions/classRosterFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Roster - <?php echo htmlspecialchars($classDetails['class_name']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
    <style>
        .modal-backdrop {
            opacity: 0;
            visibility: hidden;
        }
        .modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            transform: scale(0.95);
            opacity: 0;

        }
        .modal-backdrop.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Main Content Area -->
        <main class="lg:p-6">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
                <a href="../Dashboard/studentDashboard.php" class="hover:text-primary-500 transition">
                    <i class="fas fa-home"></i>
                </a>
                <span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </span>
                <a href="classDetails.php?class_id=<?php echo $class_id; ?>" class="hover:text-primary-500 transition">
                    <?php echo htmlspecialchars($classDetails['class_name']); ?>
                </a>
                <span>
                    <i class="fas fa-chevron-right text-xs"></i>
                </span>
                <span class="text-gray-700 font-medium">Class Roster</span>
            </div>

            <!-- Class Header -->
            <div class="bg-white rounded-2xl shadow-md p-6 mb-6 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            <?php echo htmlspecialchars($classDetails['class_name']); ?> - Student Roster
                        </h1>
                        <p class="text-gray-600 mt-1">
                            Class Code: <span class="font-semibold"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="classDetails.php?class_id=<?php echo $class_id; ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-xl transition-colors duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Class
                        </a>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">
                        <i class="fas fa-users text-blue-500 mr-2"></i>
                        Class Members (<?php echo count($classmates); ?>)
                    </h2>
                </div>

                <?php if (count($classmates) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>

                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID #
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Grade Level
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Strand
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Joined
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($classmates as $index => $student): ?>
                                    <tr class="hover:bg-gray-50 <?php echo ($student['st_id'] === $student_id) ? 'bg-blue-50' : ''; ?> cursor-pointer" 
                                        onclick="openStudentModal('<?php echo $index; ?>')">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-600 font-semibold">
                                                        <?php
                                                        $initials = explode(' ', $student['student_name']);
                                                        echo strtoupper(substr($initials[0] ?? '', 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo htmlspecialchars($student['student_name']); ?>
                                                        <?php if ($student['st_id'] === $student_id): ?>
                                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                You
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php echo htmlspecialchars($student['student_id'] ?? 'Not provided'); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900">
                                                <?php
                                                $grade = str_replace('_', ' ', $student['grade_level'] ?? 'Not specified');
                                                echo ucwords($grade);
                                                ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900">
                                                <?php echo strtoupper($student['strand'] ?? 'N/A'); ?>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php echo htmlspecialchars($student['email']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php
                                            if (!empty($student['enrollment_date'])) {
                                                $enrollDate = new DateTime($student['enrollment_date']);
                                                echo $enrollDate->format('M d, Y');
                                            } else {
                                                echo 'Unknown date';
                                            }
                                            ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <?php echo ucfirst($student['status'] ?? 'Unknown'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-6 text-center">
                        <p class="text-gray-500">No students enrolled in this class yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Student Detail Modal -->
    <?php foreach ($classmates as $index => $student): ?>
    <div id="studentModal-<?php echo $index; ?>" class="modal-backdrop fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="modal-content bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden">
            <!-- Modal Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">
                    Student Information
                </h3>
                <button onclick="closeStudentModal('<?php echo $index; ?>')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Left Column - Basic Info -->
                    <div class="flex-1">
                        <!-- Student Avatar and Name -->
                        <div class="flex items-center mb-6">
                            <div class="h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-2xl">
                                    <?php
                                    $initials = explode(' ', $student['student_name']);
                                    echo strtoupper(substr($initials[0] ?? '', 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                    ?>
                                </span>
                            </div>
                            <div class="ml-6">
                                <h4 class="text-2xl font-bold text-gray-900">
                                    <?php echo htmlspecialchars($student['student_name']); ?>
                                    <?php if ($student['st_id'] === $student_id): ?>
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            You
                                        </span>
                                    <?php endif; ?>
                                </h4>
                                <p class="text-gray-500">
                                    <?php echo htmlspecialchars($student['email']); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Student Basic Info -->
                        <div class="grid grid-cols-1 gap-4">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Student ID</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php echo htmlspecialchars($student['st_id']); ?>
                                </p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Student ID Number</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php echo htmlspecialchars($student['student_id'] ?? 'Not provided'); ?>
                                </p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Enrollment Status</h5>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <?php echo ucfirst($student['status'] ?? 'Unknown'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Academic Info -->
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Academic Information</h4>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Grade Level</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php 
                                        $grade = str_replace('_', ' ', $student['grade_level'] ?? 'Not specified');
                                        echo ucwords($grade); 
                                    ?>
                                </p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Strand</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php echo strtoupper($student['strand'] ?? 'N/A'); ?>
                                </p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Enrollment Date</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php 
                                        if (!empty($student['enrollment_date'])) {
                                            $enrollDate = new DateTime($student['enrollment_date']);
                                            echo $enrollDate->format('F d, Y');
                                        } else {
                                            echo 'Unknown date';
                                        }
                                    ?>
                                </p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h5 class="text-xs uppercase text-gray-500 font-semibold mb-2">Class</h5>
                                <p class="text-gray-900 font-medium">
                                    <?php echo htmlspecialchars($classDetails['class_name']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button onclick="closeStudentModal('<?php echo $index; ?>')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl transition-colors duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- JavaScript for Modal Functionality -->
    <script>
        // Open student modal
        function openStudentModal(index) {
            const modal = document.getElementById(`studentModal-${index}`);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Close student modal
        function closeStudentModal(index) {
            const modal = document.getElementById(`studentModal-${index}`);
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.modal-backdrop.active');
            modals.forEach(modal => {
                if (event.target === modal) {
                    const index = modal.id.replace('studentModal-', '');
                    closeStudentModal(index);
                }
            });
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const activeModal = document.querySelector('.modal-backdrop.active');
                if (activeModal) {
                    const index = activeModal.id.replace('studentModal-', '');
                    closeStudentModal(index);
                }
            }
        });
    </script>

</body>

</html>