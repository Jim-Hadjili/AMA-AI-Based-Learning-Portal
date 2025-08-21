<div class="bg-white rounded-2xl card-shadow-lg overflow-hidden mb-8 animate-fade-in">
    <div class="bg-blue-500 px-6 py-4">
        <h3 class="text-lg font-semibold text-white flex items-center">
            <i class="fas fa-chart-pie mr-2"></i>
            Question Type Performance
        </h3>
    </div>

    <div class="p-6">
        <?php
        // Calculate performance metrics by question type
        $totalCorrect = 0;
        $totalIncorrect = 0;
        $questionTypeCorrect = [
            'multiple-choice' => 0,
            'true-false' => 0,
            'checkbox' => 0,
            'short-answer' => 0
        ];
        $questionTypeCount = [
            'multiple-choice' => 0,
            'true-false' => 0,
            'checkbox' => 0,
            'short-answer' => 0
        ];

        foreach ($questions as $question) {
            $type = $question['question_type'];
            $questionTypeCount[$type]++;

            $answer = $answers[$question['question_id']] ?? null;
            if ($answer && $answer['is_correct']) {
                $totalCorrect++;
                $questionTypeCorrect[$type]++;
            } else {
                $totalIncorrect++;
            }
        }

        // Calculate percentages for question types
        $typePerformance = [];
        foreach ($questionTypeCount as $type => $count) {
            if ($count > 0) {
                $correct = $questionTypeCorrect[$type];
                $percentage = round(($correct / $count) * 100);
                $typePerformance[$type] = [
                    'count' => $count,
                    'correct' => $correct,
                    'percentage' => $percentage
                ];
            }
        }
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($typePerformance as $type => $data): ?>
                <?php if ($data['count'] > 0): ?>
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center <?php echo $data['percentage'] >= 75 ? 'bg-green-100 text-green-600' : ($data['percentage'] >= 60 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600'); ?>">
                            <?php
                            $icons = [
                                'multiple-choice' => 'fa-list-ul',
                                'true-false' => 'fa-check-double',
                                'checkbox' => 'fa-check-square',
                                'short-answer' => 'fa-edit'
                            ];
                            ?>
                            <i class="fas <?php echo $icons[$type]; ?> text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-2"><?php echo ucwords(str_replace('-', ' ', $type)); ?></h4>
                        <div class="text-3xl font-bold <?php echo $data['percentage'] >= 75 ? 'text-green-600' : ($data['percentage'] >= 60 ? 'text-yellow-600' : 'text-red-600'); ?> mb-1">
                            <?php echo $data['percentage']; ?>%
                        </div>
                        <div class="text-sm text-gray-600">
                            <?php echo $data['correct']; ?>/<?php echo $data['count']; ?> correct
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="<?php echo $data['percentage'] >= 75 ? 'bg-green-500' : ($data['percentage'] >= 60 ? 'bg-yellow-500' : 'bg-red-500'); ?> h-2 rounded-full transition-all duration-1000"
                                style="width: <?php echo $data['percentage']; ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Recommendations -->
        <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
            <h4 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                <i class="fas fa-lightbulb mr-2"></i>
                Performance Insights & Recommendations
            </h4>
            <div class="text-blue-700">
                <?php if ($scorePercentage >= 90): ?>
                    <p class="mb-2"><strong>Excellent mastery!</strong> The student demonstrates comprehensive understanding across all question types.</p>
                    <p><strong>Recommendation:</strong> Consider advanced or enrichment activities to further challenge this student.</p>
                <?php elseif ($scorePercentage >= 75): ?>
                    <p class="mb-2"><strong>Good performance overall.</strong> The student shows solid understanding with room for improvement.</p>
                    <?php
                    $weakestType = '';
                    $lowestPercentage = 100;
                    foreach ($typePerformance as $type => $data) {
                        if ($data['percentage'] < $lowestPercentage) {
                            $lowestPercentage = $data['percentage'];
                            $weakestType = $type;
                        }
                    }
                    ?>
                    <p><strong>Focus Area:</strong> Additional practice with <?php echo ucwords(str_replace('-', ' ', $weakestType)); ?> questions (<?php echo $lowestPercentage; ?>% accuracy).</p>
                <?php elseif ($scorePercentage >= 60): ?>
                    <p class="mb-2"><strong>Satisfactory performance.</strong> The student meets basic requirements but needs targeted improvement.</p>
                    <p><strong>Recommendation:</strong> Review fundamental concepts and provide additional practice materials.</p>
                <?php else: ?>
                    <p class="mb-2"><strong>Needs significant improvement.</strong> The student requires additional support and intervention.</p>
                    <p><strong>Recommendation:</strong> Schedule one-on-one tutoring sessions and consider alternative learning approaches.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>