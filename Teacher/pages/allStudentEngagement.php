<?php
session_start();
include_once "Functions/allStudentEngagementFunction.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Student Engagement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../Assets/Images/Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">All Student Engagement</h1>
            <a href="../Contents/Dashboard/teachersDashboard.php" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                        <i class="fas fa-home mr-2"></i>
                        <span>Back to Class</span>
                    </a>
        </div>
        <?php if (empty($uniqueStudents)): ?>
            <?php include "Includes/teacherContentsIncludes/studentEngagementIncludes/studentEngagementEmptyState.php"; ?>
        <?php else: ?>
            <?php include "Includes/teacherContentsIncludes/studentEngagementIncludes/studentEngagementSummaryCards.php"; ?>
            <!-- Show ALL students in the table -->
            <div class="overflow-hidden border border-gray-200 rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Student</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Classes</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Activity</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php foreach ($uniqueStudents as $studentId => $student): ?>
                            <tr class="hover:bg-indigo-50 cursor-pointer transition-colors duration-150" onclick="showStudentModal('<?php echo $studentId; ?>')">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <?php if (!empty($student['profile_picture'])): ?>
                                                <img class="h-10 w-10 rounded-full border-2 border-blue-100" src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-200">
                                                    <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($student['name']); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo htmlspecialchars($student['email']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                        <?php echo $student['enrolled_classes']; ?> / <?php echo $totalClassesCount; ?>
                                    </span>
                                    <div class="text-xs text-gray-400 mt-1">Classes Enrolled</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <?php echo $student['attempts']; ?>
                                    </span>
                                    <div class="text-xs text-gray-400 mt-1">Quiz Submissions</div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Student Detail Modals -->
            <?php foreach ($uniqueStudents as $studentId => $student): ?>
                <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementModal.php"; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script>
        function showStudentModal(studentId) {
            document.getElementById(`studentModal-${studentId}`).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        function closeStudentModal(studentId) {
            document.getElementById(`studentModal-${studentId}`).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('[id^="studentModal-"]');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
</body>
</html>