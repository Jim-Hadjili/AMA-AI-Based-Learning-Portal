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
        
        <?php
        // Try to get student engagement data
        $hasEngagementData = false;
        
        // Check if we have classes to analyze
        if (!empty($classes)) {
            $hasEngagementData = true;
            
            // Get top active class (placeholder - would normally query the database)
            $topClassId = $classes[0]['class_id'] ?? '';
            $topClassName = $classes[0]['class_name'] ?? 'N/A';
            
            // Get completion rates (placeholder - would normally calculate from real data)
            $quizCompletionRate = rand(65, 95); // Just for demonstration
            $recentCompletions = rand(3, 15); // Just for demonstration
            
            // Get student participation trend (placeholder)
            $participationTrend = 'up'; // or 'down' or 'stable'
        }
        
        if ($hasEngagementData):
        ?>
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Quiz Completion -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-tasks text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Quiz Completion</span>
                    </div>
                    <div class="flex items-end">
                        <span class="text-2xl font-bold text-gray-900"><?php echo $quizCompletionRate; ?>%</span>
                        <span class="ml-2 text-xs text-green-600 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> 5%
                        </span>
                    </div>
                </div>
                
                <!-- Recent Submissions -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-file-alt text-purple-600 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Recent Submissions</span>
                    </div>
                    <div class="flex items-end">
                        <span class="text-2xl font-bold text-gray-900"><?php echo $recentCompletions; ?></span>
                        <span class="ml-2 text-xs text-gray-500">this week</span>
                    </div>
                </div>
            </div>
            
            <!-- Most Active Class -->
            <div class="border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-900 mb-2">Most Active Class</h4>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-book text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800"><?php echo htmlspecialchars($topClassName); ?></p>
                            <p class="text-xs text-gray-500">18 active students</p>
                        </div>
                    </div>
                    <a href="../Tabs/classDetails.php?class_id=<?php echo $topClassId; ?>" class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                        View
                    </a>
                </div>
            </div>
            
            <!-- Student Interaction Chart (placeholder) -->
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Weekly Participation</h4>
                <div class="h-16 bg-gray-50 rounded-lg flex items-end justify-between px-2 pb-2">
                    <?php 
                    // Simple bar chart visualization (placeholder)
                    $days = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
                    foreach ($days as $index => $day): 
                        $height = rand(20, 100); // random height for demonstration
                        $activeDay = date('N') - 1; // 0 = Monday, 6 = Sunday
                        $isToday = $index === $activeDay;
                        $barColor = $isToday ? 'bg-purple-primary' : 'bg-gray-300';
                    ?>
                        <div class="flex flex-col items-center">
                            <div class="<?php echo $barColor; ?> rounded-sm w-6" style="height: <?php echo $height; ?>%"></div>
                            <span class="text-xs text-gray-500 mt-1"><?php echo $day; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex justify-between">
                <a href="../Reports/studentPerformance.php" class="text-purple-primary hover:text-purple-dark text-sm flex items-center">
                    <i class="fas fa-chart-line mr-1"></i>
                    Detailed Reports
                </a>
                <a href="../Messages/sendBulkMessage.php" class="text-purple-primary hover:text-purple-dark text-sm flex items-center">
                    <i class="fas fa-paper-plane mr-1"></i>
                    Send Reminder
                </a>
            </div>
            
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500 mb-2">No student engagement data yet</p>
                <p class="text-sm text-gray-400">Add your first class to get started</p>
                <button id="addFirstClassBtn" class="mt-4 px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Class
                </button>
            </div>
        <?php endif; ?>
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