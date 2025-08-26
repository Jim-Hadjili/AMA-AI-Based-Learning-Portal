<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <?php include "studentEngagementIncludes/studentEngagementBreadcrumb.php" ?>

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