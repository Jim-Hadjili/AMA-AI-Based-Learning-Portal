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
</head>
<body class="bg-gray-50 font-[Poppins]">
    <div class="max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header Card -->
        <div class="bg-blue-100 shadow-lg rounded-xl overflow-hidden mb-8 border-2">
            <div class="bg-white border-b border-blue-100">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between px-6 py-5">
                    <div class="flex items-center gap-4 mb-4 md:mb-0">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">All Student Engagement</h1>
                            <p class="text-sm text-gray-600">Overview of student participation and activity across all classes</p>
                        </div>
                    </div>
                    <!-- Total Students Badge -->
                    <div class="bg-white border-2 px-6 py-3 rounded-xl shadow-sm">
                        <div class="text-center">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Students</p>
                            <p class="text-2xl font-bold text-blue-600"><?php echo isset($uniqueStudents) ? count($uniqueStudents) : 0; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <div class="mb-6">
            <a href="../Contents/Dashboard/teachersDashboard.php" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
        <?php if (empty($uniqueStudents)): ?>
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-12">
                <?php include "Includes/teacherContentsIncludes/studentEngagementIncludes/studentEngagementEmptyState.php"; ?>
            </div>
        <?php else: ?>
            <!-- Summary Cards -->
            <div class="mb-8">
                <?php include "Includes/teacherContentsIncludes/studentEngagementIncludes/studentEngagementSummaryCards.php"; ?>
            </div>
            <!-- Search & Filter Bar -->
            <div class="bg-gray-50 rounded-lg border border-gray-200 px-4 py-3 mb-4 flex flex-col md:flex-row gap-3 items-center">
                <input id="studentSearch" type="text" placeholder="Search student name or email..." class="w-full md:w-1/2 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                <select id="classFilter" class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">All Classes</option>
                    <?php if (isset($classNames) && is_array($classNames)): ?>
                        <?php foreach ($classNames as $cid => $cname): ?>
                            <option value="<?php echo htmlspecialchars($cid); ?>"><?php echo htmlspecialchars($cname); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <!-- Student Table Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Student</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Classes</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Activity</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="studentTableBody">
                        <?php foreach ($uniqueStudents as $studentId => $student): ?>
                            <tr class="hover:bg-indigo-50 cursor-pointer transition-colors duration-150" onclick="showStudentModal('<?php echo $studentId; ?>')" data-student-name="<?php echo strtolower(htmlspecialchars($student['name'])); ?>" data-student-email="<?php echo strtolower(htmlspecialchars($student['email'])); ?>" data-student-classes="<?php echo isset($studentEnrollments[$studentId]) ? implode(',', array_map('htmlspecialchars', array_column($studentEnrollments[$studentId]['classes'], 'class_id'))) : ''; ?>">
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
        // Search and filter for student table
        (function() {
            const searchInput = document.getElementById('studentSearch');
            const filterSelect = document.getElementById('classFilter');
            const tableBody = document.getElementById('studentTableBody');
            if (!searchInput || !filterSelect || !tableBody) return;
            const rows = tableBody.querySelectorAll('tr');
            function filterRows() {
                const search = searchInput.value.toLowerCase();
                const filter = filterSelect.value;
                rows.forEach(row => {
                    const name = row.getAttribute('data-student-name');
                    const email = row.getAttribute('data-student-email');
                    const classes = row.getAttribute('data-student-classes');
                    const matchesSearch = !search || (name && name.includes(search)) || (email && email.includes(search));
                    const matchesFilter = !filter || (classes && classes.split(',').includes(filter));
                    if (matchesSearch && matchesFilter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            searchInput.addEventListener('input', filterRows);
            filterSelect.addEventListener('change', filterRows);
        })();
    </script>
</body>
</html>