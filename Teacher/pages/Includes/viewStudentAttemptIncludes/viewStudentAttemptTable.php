<div class="bg-white shadow rounded-lg overflow-hidden mb-8">
    <div class="border-b border-gray-200 px-6 py-5">
        <h2 class="text-lg font-medium text-gray-900">All Attempts</h2>
        <p class="mt-1 text-sm text-gray-500">History of all attempts for this quiz, including AI regenerated versions</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempt #</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($allAttempts as $displayIndex => $attemptItem):
                    // Get total points for this quiz version
                    $quizPointsStmt = $conn->prepare("
            SELECT SUM(question_points) AS total_points 
            FROM quiz_questions_tb 
            WHERE quiz_id = ?
        ");
                    $quizPointsStmt->bind_param("i", $attemptItem['quiz_id']);
                    $quizPointsStmt->execute();
                    $quizPointsResult = $quizPointsStmt->get_result();
                    $quizPointsRow = $quizPointsResult->fetch_assoc();
                    $totalPossiblePoints = $quizPointsRow['total_points'] ?? 0;
                    if ($totalPossiblePoints == 0) $totalPossiblePoints = 1; // Prevent division by zero

                    $attemptPercentage = round(($attemptItem['score'] / $totalPossiblePoints) * 100);
                    $attemptNumber = $attemptItem['attempt_number']; // Use the saved chronological number
                    $isCurrentAttempt = ($attemptItem['attempt_id'] == $attempt_id);
                    $quizType = $attemptItem['parent_quiz_id'] ? 'AI Generated' : 'Original';

                    // Highlight AI-generated attempts with a light accent color
                    $rowClass = $isCurrentAttempt ? 'bg-blue-50' : ($attemptItem['parent_quiz_id'] ? 'bg-indigo-50' : '');
                ?>
                    <tr class="<?php echo $rowClass; ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo $attemptNumber; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo htmlspecialchars($attemptItem['quiz_title']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo date('M j, Y, g:i a', strtotime($attemptItem['end_time'])); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium <?php echo $attemptPercentage >= 65 ? 'text-green-600' : 'text-red-600'; ?>">
                            <?php echo "{$attemptItem['score']}/{$totalPossiblePoints} ({$attemptPercentage}%)"; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo strtolower($attemptItem['result']) === 'passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo ucfirst($attemptItem['result']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $attemptItem['parent_quiz_id'] ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800'; ?>">
                                <?php echo $quizType; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <?php if (!$isCurrentAttempt): ?>
                                <span class="text-blue-600 cursor-default">View</span>
                            <?php else: ?>
                                <span class="text-gray-400">View</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>