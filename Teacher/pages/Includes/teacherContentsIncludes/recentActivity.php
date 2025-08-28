<div class="w-full mb-8">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

        <!-- Header Section -->
        <div class="bg-white border-b border-gray-100 px-6 py-6">
            <div class="flex items-center gap-4 justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-100 rounded-xl">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">Recent Activity</h1>
                        <p class="text-sm text-gray-500 mt-1">Latest actions and events in your classes</p>
                    </div>
                </div>
                <?php if (isset($totalActivityCount) && $totalActivityCount > 15): ?>
                    <a href="../Reports/recentActivityFull.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
                        <span>View All</span>
                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Timeline Content -->
        <div class="bg-white px-6 py-6">
            <?php if (empty($activities)): ?>
                <div class="text-center py-16">
                    <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-clock text-gray-300 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Recent Activity</h3>
                    <p class="text-gray-500 max-w-md mx-auto">There are no new activities to display. When students interact, their actions will appear here.</p>
                </div>
            <?php else: ?>
                <ul class="timeline space-y-6">
                    <?php foreach ($activities as $index => $act): ?>
                        <li class="flex items-start gap-4">
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