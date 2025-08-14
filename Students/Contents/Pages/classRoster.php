<?php
// Add cache control headers at the very top of the file
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include "../../Functions/classRosterFunction.php";
?>

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
        <main class="lg:p-6">

            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
                <a href="../Dashboard/studentDashboard.php" class="hover:text-blue-600 transition">
                    <i class="fas fa-home"></i>
                </a>
                <span><i class="fas fa-chevron-right text-xs"></i></span>
                <a href="classDetails.php?class_id=<?php echo $class_id; ?>" class="hover:text-blue-600 transition">
                    <?php echo htmlspecialchars($classDetails['class_name']); ?>
                </a>
                <span><i class="fas fa-chevron-right text-xs"></i></span>
                <span class="text-gray-700 font-medium">Class Roster</span>
            </div>

            <div class="max-w-9xl mx-auto space-y-6">

                <!-- Class Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                    <div class="absolute inset-0 pointer-events-none opacity-5 bg-[radial-gradient(circle_at_30%_20%,#3b82f6,transparent_60%)]"></div>
                    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow">
                                    <i class="fas fa-users"></i>
                                </span>
                                <?php echo htmlspecialchars($classDetails['class_name']); ?> – Student Roster
                            </h1>
                            <p class="text-gray-600 mt-2 text-sm">
                                Class Code:
                                <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="classDetails.php?class_id=<?php echo $class_id; ?>"
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
                                <i class="fas fa-arrow-left mr-2"></i> Back to Class
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user-graduate text-blue-500"></i>
                            Class Members
                            <span class="ml-1 text-sm font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                <?php echo count($classmates); ?>
                            </span>
                        </h2>
                        <?php if (count($classmates) > 0): ?>
                            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                                <div class="relative flex-1 min-w-[220px]">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input id="rosterSearch" type="text" placeholder="Search students..."
                                        class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring focus:ring-blue-100 text-sm transition bg-gray-50 focus:bg-white">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (count($classmates) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Student</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Student ID #</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Grade Level</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Strand</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Joined</th>
                                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="rosterTableBody" class="bg-white divide-y divide-gray-100 text-sm">
                                    <?php foreach ($classmates as $index => $student):
                                        $status = strtolower($student['status'] ?? 'unknown');
                                        $statusColors = match ($status) {
                                            'active'   => 'bg-green-100 text-green-700',
                                            'inactive' => 'bg-gray-200 text-gray-700',
                                            'pending'  => 'bg-yellow-100 text-yellow-700',
                                            default    => 'bg-gray-100 text-gray-600'
                                        };
                                    ?>
                                        <tr class="student-row hover:bg-blue-50/40 transition cursor-pointer <?php echo ($student['st_id'] === $student_id) ? 'bg-blue-50/60 ring-1 ring-blue-100' : ''; ?>"
                                            data-name="<?php echo htmlspecialchars(strtolower($student['student_name'])); ?>"
                                            data-status="<?php echo htmlspecialchars($status); ?>"
                                            onclick="openStudentModal('<?php echo $index; ?>')">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="relative">
                                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center overflow-hidden border border-blue-100">
                                                            <?php if (!empty($student['profile_picture']) && file_exists('../../../Uploads/ProfilePictures/' . $student['profile_picture'])): ?>
                                                                <img src="../../../Uploads/ProfilePictures/<?php echo $student['profile_picture']; ?>" alt="Profile" class="w-full h-full object-cover">
                                                            <?php else: ?>
                                                                <span class="text-blue-600 font-semibold">
                                                                    <?php
                                                                    $initials = explode(' ', trim($student['student_name']));
                                                                    echo strtoupper(substr($initials[0] ?? '', 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                                                    ?>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900 flex items-center gap-2">
                                                            <?php echo htmlspecialchars($student['student_name']); ?>
                                                            <?php if ($student['st_id'] === $student_id): ?>
                                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[11px] font-semibold">You</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            <?php echo strtoupper($student['strand'] ?? ''); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-600">
                                                <?php echo htmlspecialchars($student['student_id'] ?? '—'); ?>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-700">
                                                <?php
                                                $grade = str_replace('_', ' ', $student['grade_level'] ?? 'Not specified');
                                                echo ucwords($grade);
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-700">
                                                <?php echo strtoupper($student['strand'] ?? 'N/A'); ?>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-gray-600"><?php echo htmlspecialchars($student['email']); ?></span>
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-600">
                                                <?php
                                                if (!empty($student['enrollment_date'])) {
                                                    $enrollDate = new DateTime($student['enrollment_date']);
                                                    echo $enrollDate->format('M d, Y');
                                                } else {
                                                    echo '—';
                                                }
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold <?php echo $statusColors; ?>">
                                                    <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                                    <?php echo ucfirst($student['status'] ?? 'Unknown'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-10 text-center">
                            <p class="text-gray-500 text-sm">No students enrolled in this class yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <!-- Student Detail Modals -->
    <?php foreach ($classmates as $index => $student): ?>
        <?php include "../Modals/studentInfoCardModal.php"; ?>
    <?php endforeach; ?>

    <script>
        // Filtering
        const searchInput = document.getElementById('rosterSearch');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.student-row');

        function applyFilters() {
            const q = (searchInput?.value || '').trim().toLowerCase();
            const status = (statusFilter?.value || '').toLowerCase();

            rows.forEach(r => {
                const name = r.dataset.name;
                const st = r.dataset.status;
                const matchName = !q || name.includes(q);
                const matchStatus = !status || st === status;
                r.classList.toggle('hidden', !(matchName && matchStatus));
            });
        }

        searchInput?.addEventListener('input', applyFilters);
        statusFilter?.addEventListener('change', applyFilters);

        // Modal functions (existing)
        function openStudentModal(index) {
            const modal = document.getElementById(`studentModal-${index}`);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeStudentModal(index) {
            const modal = document.getElementById(`studentModal-${index}`);
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('click', e => {
            document.querySelectorAll('.modal-backdrop.active').forEach(modal => {
                if (e.target === modal) {
                    const i = modal.id.replace('studentModal-', '');
                    closeStudentModal(i);
                }
            });
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.modal-backdrop.active');
                if (activeModal) {
                    const i = activeModal.id.replace('studentModal-', '');
                    closeStudentModal(i);
                }
            }
        });

        // Profile image preview (existing)
        function openProfileImagePreview(index) {
            const modal = document.getElementById(`profileImageModal-${index}`);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeProfileImagePreview(index) {
            const modal = document.getElementById(`profileImageModal-${index}`);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('click', e => {
            document.querySelectorAll('[id^="profileImageModal-"]').forEach(modal => {
                if (e.target === modal) {
                    const i = modal.id.replace('profileImageModal-', '');
                    closeProfileImagePreview(i);
                }
            });
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                const activeProfileImageModal = document.querySelector('[id^="profileImageModal-"].flex');
                if (activeProfileImageModal) {
                    const i = activeProfileImageModal.id.replace('profileImageModal-', '');
                    closeProfileImagePreview(i);
                }
            }
        });
    </script>

</body>

</html>