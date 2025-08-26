<div class="w-full mb-8">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        <!-- Header Section -->
        <div class="bg-white border-b border-gray-100 px-6 py-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 4a4 4 0 110 8 4 4 0 010-8zm0 0v1m0 8v1m-4-4h1m8 0h1" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Student Engagement Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Monitor student participation and quiz activity across your classes</p>
                </div>

                <?php if (isset($uniqueStudents) && !empty($uniqueStudents)): ?>
                    <a href="../Reports/quizResults.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
                        <span>View All</span>
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

        </div>

        <div class="p-6">

            <?php if (empty($uniqueStudents)): ?>

                <?php include "studentEngagementIncludes/studentEngagementEmptyState.php" ?>

            <?php else: ?>

                <!-- Summary Cards -->
                <?php include "studentEngagementIncludes/studentEngagementSummaryCards.php" ?>

                <!-- Student Performance Table -->
                <?php include "studentEngagementIncludes/studentEngagementTable.php" ?>

                <!-- Student Detail Modals -->
                <?php foreach ($uniqueStudents as $studentId => $student): ?>
                    <?php include "studentEngagementIncludes/studentEngagementModal.php" ?>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
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

    // Close modal when clicking outside of it
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