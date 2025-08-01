<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>

        <?php
        // Check for recent activities
        $hasActivities = false;
        try {
            $query = "SELECT * FROM teacher_activities_tb WHERE th_id = ? ORDER BY activity_date DESC LIMIT 5";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $hasActivities = true;
        ?>
                    <div class="space-y-4">
                        <?php while ($activity = $result->fetch_assoc()): ?>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <?php if ($activity['activity_type'] == 'quiz'): ?>
                                        <i class="fas fa-file-alt text-purple-600"></i>
                                    <?php elseif ($activity['activity_type'] == 'class'): ?>
                                        <i class="fas fa-users text-purple-600"></i>
                                    <?php else: ?>
                                        <i class="fas fa-bell text-purple-600"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($activity['activity_description']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M d, Y h:i A', strtotime($activity['activity_date'])); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
            <?php
                }
                $stmt->close();
            }
        } catch (Exception $e) {
            // Silently handle error
            $hasActivities = false;
        }

        if (!$hasActivities) {
            ?>
            <div class="text-center py-12">
                <i class="fas fa-clock text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent activity to display</p>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Student Engagement -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Engagement</h3>
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-500 mb-2">No student engagement data yet</p>
            <p class="text-sm text-gray-400">Add your first class to get started</p>
        </div>
    </div>
</div>

<script>
    // Make sure the button triggers the add class modal if present
    document.addEventListener('DOMContentLoaded', function() {
        const addFirstClassBtn = document.getElementById('addFirstClassBtn');
        if (addFirstClassBtn) {
            addFirstClassBtn.addEventListener('click', function() {
                if (typeof window.openAddClassModal === 'function') {
                    window.openAddClassModal();
                }
            });
        }
    });
</script>