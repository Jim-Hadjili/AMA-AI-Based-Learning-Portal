<?php
session_start();
include "Functions/allRecentActivityFunction.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Recent Activity</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../Assets/Images/Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-3xl mx-auto mt-10">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Back Button -->
            <div class="flex items-center px-6 py-4 border-b border-gray-100">
                <a href="../Contents/Dashboard/teachersDashboard.php" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Class</span>
                    </a>
                <h1 class="ml-4 text-2xl font-bold text-gray-900">All Recent Activity</h1>
            </div>
            <!-- Search & Filters -->
            <div class="bg-white px-6 pt-6 flex flex-col md:flex-row gap-4 items-center">
                <input id="activitySearch" type="text" placeholder="Search by student, class, or quiz..." class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                <select id="activityTypeFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">All Types</option>
                    <option value="enrollment">Enrollment</option>
                    <option value="quiz_submission">Quiz Submission</option>
                </select>
                <select id="classFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">All Classes</option>
                    <?php
                    // Output class options
                    if (isset($classNames) && is_array($classNames)) {
                        foreach ($classNames as $cid => $cname) {
                            echo "<option value=\"$cid\">" . htmlspecialchars($cname) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="bg-white px-6 py-6">
                <?php if (empty($activities)): ?>
                    <div class="text-center py-16">
                        <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-clock text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Recent Activity</h3>
                        <p class="text-gray-500 max-w-md mx-auto">There are no new activities to display.</p>
                    </div>
                <?php else: ?>
                    <ul id="activityTimeline" class="timeline space-y-6">
                        <?php foreach ($activities as $index => $act): ?>
                            <li class="flex items-start gap-4 activity-item"
                                data-type="<?= $act['type'] ?>"
                                data-class="<?= $act['class_id'] ?>"
                                data-desc="<?= htmlspecialchars(strip_tags($act['desc'])) ?>"
                                data-student="<?= htmlspecialchars($act['student_name']) ?>"
                                data-quiz="<?= isset($act['quiz_title']) ? htmlspecialchars($act['quiz_title']) : '' ?>"
                            >
                                <span class="flex-shrink-0 p-3 rounded-full
                                    <?php
                                    if ($act['type'] === 'enrollment') echo 'bg-green-100';
                                    elseif ($act['type'] === 'quiz_submission') echo 'bg-blue-100';
                                    else echo 'bg-gray-100';
                                    ?>">
                                    <?php
                                    if ($act['type'] === 'enrollment') echo '<i class="fas fa-user-plus text-green-600 text-xl"></i>';
                                    elseif ($act['type'] === 'quiz_submission') echo '<i class="fas fa-file-alt text-blue-600 text-xl"></i>';
                                    else echo '<i class="fas fa-info-circle text-gray-400 text-xl"></i>';
                                    ?>
                                </span>
                                <div class="w-full">
                                    <div class="text-gray-800 cursor-pointer hover:text-indigo-600 flex justify-between items-center"
                                        onclick="showActivityDetails(<?= $index ?>)">
                                        <span class="font-medium"><?= $act['desc'] ?></span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1"><?= date('M d, Y h:i A', strtotime($act['time'])) ?></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include "Includes/allRecentActivityIncludes/allRecentActivityModal.php" ?>
    <?php include 'Scripts/allrecentActivityScript.php'; ?>

    <script>
    // Simple client-side search & filter
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('activitySearch');
        const typeFilter = document.getElementById('activityTypeFilter');
        const classFilter = document.getElementById('classFilter');
        const timeline = document.getElementById('activityTimeline');
        const items = timeline ? timeline.querySelectorAll('.activity-item') : [];

        function filterActivities() {
            const search = searchInput.value.toLowerCase();
            const type = typeFilter.value;
            const classId = classFilter.value;

            items.forEach(item => {
                const matchesType = !type || item.dataset.type === type;
                const matchesClass = !classId || item.dataset.class === classId;
                const matchesSearch =
                    !search ||
                    item.dataset.desc.toLowerCase().includes(search) ||
                    item.dataset.student.toLowerCase().includes(search) ||
                    item.dataset.quiz.toLowerCase().includes(search);

                if (matchesType && matchesClass && matchesSearch) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        [searchInput, typeFilter, classFilter].forEach(el => {
            el.addEventListener('input', filterActivities);
            el.addEventListener('change', filterActivities);
        });
    });
    </script>
</body>
</html>