<?php include "Functions/viewAttemptDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsHeadTag.php"; ?>

<body class="bg-gray-50 min-h-screen">
    <!-- Enhanced Header -->
    <div class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <!-- Navigation -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <a href="javascript:history.back()" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200 bg-white bg-opacity-10 px-3 py-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Results
                    </a>
                    <div class="h-6 w-px bg-white bg-opacity-30"></div>
                    <a href="../index.php" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </div>
                
                <div class="flex items-center space-x-3 no-print">
                    <button onclick="window.print()" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-white px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm">
                        <i class="fas fa-print mr-2"></i>Print Report
                    </button>
                    <button onclick="exportToPDF()" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-white px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm">
                        <i class="fas fa-file-pdf mr-2"></i>Export PDF
                    </button>
                </div>
            </div>

            <!-- Header Content -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl font-bold mb-2 flex items-center">
                        <i class="fas fa-clipboard-check mr-3 text-blue-200"></i>
                        Student Attempt Analysis
                    </h1>
                    <p class="text-blue-100 text-lg"><?php echo htmlspecialchars($quiz_title); ?></p>
                    <div class="flex items-center mt-2 text-sm text-blue-200">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Completed on <?php echo date('F j, Y \a\t g:i A', strtotime($attempt['end_time'])); ?>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                        <div class="text-2xl font-bold"><?php echo $scorePercentage; ?>%</div>
                        <div class="text-xs text-blue-200 uppercase tracking-wide">Score</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                        <div class="text-2xl font-bold"><?php echo $totalPointsEarned; ?>/<?php echo $totalPossiblePoints; ?></div>
                        <div class="text-xs text-blue-200 uppercase tracking-wide">Points</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                        <div class="text-2xl font-bold"><?php echo count($questions); ?></div>
                        <div class="text-xs text-blue-200 uppercase tracking-wide">Questions</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                        <div class="text-2xl font-bold"><?php echo $timeSpent; ?></div>
                        <div class="text-xs text-blue-200 uppercase tracking-wide">Time</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">


    
        <!-- Student Profile & Performance Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Student Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl card-shadow-lg overflow-hidden animate-fade-in">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            Student Profile
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <!-- Profile Picture and Basic Info -->
                        <div class="flex items-center mb-6">
                            <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 ring-4 ring-indigo-100">
                                <?php if ($attempt['profile_picture']): ?>
                                    <img src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($attempt['profile_picture']); ?>" 
                                         alt="Student" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="ml-4">
                                <h4 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></h4>
                                <p class="text-gray-600"><?php echo ucfirst(str_replace('_', ' ', $attempt['grade_level'])); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($attempt['strand']); ?></p>
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Student ID</span>
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['student_id'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Class</span>
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['class_name']); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Subject</span>
                                <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['subject']); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Attempt ID</span>
                                <span class="text-sm text-gray-900 font-mono">#<?php echo $attempt_id; ?></span>
                            </div>
                        </div>

                        <!-- Performance Badge -->
                        <div class="mt-6 p-4 rounded-xl <?php echo $scorePercentage >= 90 ? 'bg-green-50 border border-green-200' : ($scorePercentage >= 75 ? 'bg-blue-50 border border-blue-200' : ($scorePercentage >= 60 ? 'bg-yellow-50 border border-yellow-200' : 'bg-red-50 border border-red-200')); ?>">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium <?php echo $scorePercentage >= 90 ? 'text-green-800' : ($scorePercentage >= 75 ? 'text-blue-800' : ($scorePercentage >= 60 ? 'text-yellow-800' : 'text-red-800')); ?>">
                                        <?php 
                                        if ($scorePercentage >= 90) echo "Excellent Performance";
                                        elseif ($scorePercentage >= 75) echo "Good Performance";
                                        elseif ($scorePercentage >= 60) echo "Satisfactory";
                                        else echo "Needs Improvement";
                                        ?>
                                    </p>
                                    <p class="text-xs <?php echo $scorePercentage >= 90 ? 'text-green-600' : ($scorePercentage >= 75 ? 'text-blue-600' : ($scorePercentage >= 60 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                        <?php echo $attempt['result'] === 'passed' ? 'Passed' : 'Failed'; ?>
                                    </p>
                                </div>
                                <div class="text-2xl <?php echo $scorePercentage >= 90 ? 'text-green-500' : ($scorePercentage >= 75 ? 'text-blue-500' : ($scorePercentage >= 60 ? 'text-yellow-500' : 'text-red-500')); ?>">
                                    <?php 
                                    if ($scorePercentage >= 90) echo '<i class="fas fa-trophy"></i>';
                                    elseif ($scorePercentage >= 75) echo '<i class="fas fa-medal"></i>';
                                    elseif ($scorePercentage >= 60) echo '<i class="fas fa-thumbs-up"></i>';
                                    else echo '<i class="fas fa-exclamation-triangle"></i>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Analytics -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl card-shadow-lg overflow-hidden animate-fade-in">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-chart-line mr-2"></i>
                            Performance Analytics
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Score Visualization -->
                            <div class="text-center">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Overall Score</h4>
                                <div class="relative inline-flex items-center justify-center">
                                    <svg class="w-32 h-32 progress-ring">
                                        <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="8" fill="transparent"></circle>
                                        <circle cx="64" cy="64" r="56" stroke="<?php echo $scorePercentage >= 75 ? '#10b981' : ($scorePercentage >= 60 ? '#f59e0b' : '#ef4444'); ?>" 
                                                stroke-width="8" fill="transparent" 
                                                stroke-dasharray="<?php echo 2 * pi() * 56; ?>" 
                                                stroke-dashoffset="<?php echo 2 * pi() * 56 * (1 - $scorePercentage / 100); ?>"
                                                class="progress-ring-circle"></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="text-3xl font-bold <?php echo $scorePercentage >= 75 ? 'text-green-600' : ($scorePercentage >= 60 ? 'text-yellow-600' : 'text-red-600'); ?>">
                                                <?php echo $scorePercentage; ?>%
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <?php echo $totalPointsEarned; ?>/<?php echo $totalPossiblePoints; ?> pts
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comparison with Class Average -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Performance Comparison</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-medium text-gray-700">Student Score</span>
                                            <span class="font-bold <?php echo $scorePercentage >= $classAvgPercentage ? 'text-green-600' : 'text-red-600'; ?>">
                                                <?php echo $scorePercentage; ?>%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="<?php echo $scorePercentage >= 75 ? 'bg-green-500' : ($scorePercentage >= 60 ? 'bg-yellow-500' : 'bg-red-500'); ?> h-3 rounded-full transition-all duration-1000" 
                                                 style="width: <?php echo $scorePercentage; ?>%"></div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-medium text-gray-700">Class Average</span>
                                            <span class="font-bold text-gray-600"><?php echo $classAvgPercentage; ?>%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-gray-500 h-3 rounded-full transition-all duration-1000" 
                                                 style="width: <?php echo $classAvgPercentage; ?>%"></div>
                                        </div>
                                    </div>

                                    <!-- Performance Indicator -->
                                    <div class="mt-4 p-3 rounded-lg <?php echo $scorePercentage >= $classAvgPercentage ? 'bg-green-50 border border-green-200' : 'bg-orange-50 border border-orange-200'; ?>">
                                        <div class="flex items-center">
                                            <i class="fas <?php echo $scorePercentage >= $classAvgPercentage ? 'fa-arrow-up text-green-500' : 'fa-arrow-down text-orange-500'; ?> mr-2"></i>
                                            <span class="text-sm font-medium <?php echo $scorePercentage >= $classAvgPercentage ? 'text-green-800' : 'text-orange-800'; ?>">
                                                <?php 
                                                $diff = abs($scorePercentage - $classAvgPercentage);
                                                echo $scorePercentage >= $classAvgPercentage ? 
                                                    ($diff > 0 ? "{$diff}% above class average" : "At class average") : 
                                                    "{$diff}% below class average";
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time Analysis -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Time Analysis</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50 rounded-lg p-4 text-center">
                                    <div class="text-2xl font-bold text-blue-600"><?php echo $timeSpent; ?></div>
                                    <div class="text-sm text-blue-700">Time Spent</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 text-center">
                                    <div class="text-2xl font-bold text-gray-600">
                                        <?php echo $attempt['time_limit'] ? $attempt['time_limit'] . ' min' : 'No Limit'; ?>
                                    </div>
                                    <div class="text-sm text-gray-700">Time Allowed</div>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        <?php 
                                        if ($attempt['time_limit']) {
                                            $timeUsedPercentage = min(100, (($startTime->diff($endTime)->h * 60 + $startTime->diff($endTime)->i) / $attempt['time_limit']) * 100);
                                            echo round($timeUsedPercentage) . '%';
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </div>
                                    <div class="text-sm text-green-700">Time Utilized</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Question Type Performance Analysis -->
        <div class="bg-white rounded-2xl card-shadow-lg overflow-hidden mb-8 animate-fade-in">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
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





        

        <!-- Detailed Question Analysis -->
        <div class="bg-white rounded-2xl card-shadow-lg overflow-hidden mb-8 animate-fade-in">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-microscope mr-2"></i>
                    Detailed Question Analysis
                </h3>
                <p class="text-green-100 text-sm mt-1">Review each question and student response</p>
            </div>
            
            <div class="p-6">
                <?php $questionNumber = 1; ?>
                <?php foreach ($questions as $question): ?>
                    <?php 
                    $answer = $answers[$question['question_id']] ?? null;
                    $isCorrect = $answer ? $answer['is_correct'] : false;
                    $questionPoints = $question['question_points'];
                    $earnedPoints = $isCorrect ? $questionPoints : 0;
                    ?>
                    
                    <div class="mb-8 pb-8 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <!-- Question Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 flex-shrink-0 rounded-xl flex items-center justify-center <?php echo $isCorrect ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'; ?> mr-4">
                                    <?php if ($isCorrect): ?>
                                        <i class="fas fa-check text-xl"></i>
                                    <?php else: ?>
                                        <i class="fas fa-times text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">
                                        Question <?php echo $questionNumber; ?>
                                    </h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-gray-100">
                                            <i class="fas fa-tag mr-1"></i>
                                            <?php echo ucfirst(str_replace('-', ' ', $question['question_type'])); ?>
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full <?php echo $isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <i class="fas fa-coins mr-1"></i>
                                            <?php echo $earnedPoints; ?>/<?php echo $questionPoints; ?> points
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="flex items-center space-x-2 no-print">
                                <button onclick="toggleFeedback(<?php echo $question['question_id']; ?>)" 
                                        class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-comment-alt"></i>
                                </button>
                                <button onclick="flagQuestion(<?php echo $question['question_id']; ?>)" 
                                        class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-50 transition-colors">
                                    <i class="fas fa-flag"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Question Text -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                            <p class="text-gray-800 leading-relaxed"><?php echo nl2br(htmlspecialchars($question['question_text'])); ?></p>
                        </div>
                        
                        <!-- Answer Analysis -->
                        <div class="ml-16">
                            <?php if ($question['question_type'] === 'multiple-choice' || $question['question_type'] === 'checkbox'): ?>
                                <?php 
                                $options = getOptions($conn, $question['question_id']);
                                $selectedOptions = $answer ? explode(',', $answer['selected_options']) : [];
                                ?>
                                
                                <div class="space-y-3">
                                    <?php foreach ($options as $option): ?>
                                        <?php 
                                        $isSelected = in_array($option['option_id'], $selectedOptions);
                                        $isCorrectOption = $option['is_correct'] == 1;
                                        
                                        $bgClass = 'bg-white';
                                        $borderClass = 'border-gray-200';
                                        $textClass = 'text-gray-800';
                                        $iconClass = '';
                                        
                                        if ($isSelected && $isCorrectOption) {
                                            $bgClass = 'bg-green-50';
                                            $borderClass = 'border-green-300';
                                            $textClass = 'text-green-800';
                                            $iconClass = 'fas fa-check-circle text-green-600';
                                        } else if ($isSelected && !$isCorrectOption) {
                                            $bgClass = 'bg-red-50';
                                            $borderClass = 'border-red-300';
                                            $textClass = 'text-red-800';
                                            $iconClass = 'fas fa-times-circle text-red-600';
                                        } else if (!$isSelected && $isCorrectOption) {
                                            $bgClass = 'bg-blue-50';
                                            $borderClass = 'border-blue-300';
                                            $textClass = 'text-blue-800';
                                            $iconClass = 'fas fa-info-circle text-blue-600';
                                        } else {
                                            $iconClass = 'far fa-circle text-gray-400';
                                        }
                                        ?>
                                        
                                        <div class="flex items-center p-4 rounded-xl border-2 <?php echo $borderClass . ' ' . $bgClass; ?> transition-all duration-200">
                                            <div class="mr-4">
                                                <i class="<?php echo $iconClass; ?> text-xl"></i>
                                            </div>
                                            <span class="<?php echo $textClass; ?> font-medium"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                            <?php if ($isSelected && $isCorrectOption): ?>
                                                <span class="ml-auto text-xs bg-green-200 text-green-800 px-2 py-1 rounded-full">Student's Correct Answer</span>
                                            <?php elseif ($isSelected && !$isCorrectOption): ?>
                                                <span class="ml-auto text-xs bg-red-200 text-red-800 px-2 py-1 rounded-full">Student's Incorrect Answer</span>
                                            <?php elseif (!$isSelected && $isCorrectOption): ?>
                                                <span class="ml-auto text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded-full">Correct Answer (Not Selected)</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                            <?php elseif ($question['question_type'] === 'true-false'): ?>
                                <?php 
                                $studentAnswer = $answer ? strtolower($answer['selected_options']) : '';
                                $options = getOptions($conn, $question['question_id']);
                                $correctAnswer = '';
                                
                                foreach ($options as $option) {
                                    if ($option['is_correct'] == 1) {
                                        $correctAnswer = strtolower($option['option_text']);
                                        break;
                                    }
                                }
                                ?>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- True Option -->
                                    <div class="p-4 rounded-xl border-2 <?php 
                                        echo ($studentAnswer === 'true') ? 
                                            (($correctAnswer === 'true') ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50') : 
                                            (($correctAnswer === 'true') ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-white'); 
                                    ?>">
                                        <div class="flex items-center justify-center">
                                            <i class="<?php 
                                                echo ($studentAnswer === 'true') ? 
                                                    (($correctAnswer === 'true') ? 'fas fa-check-circle text-green-600' : 'fas fa-times-circle text-red-600') : 
                                                    (($correctAnswer === 'true') ? 'fas fa-info-circle text-blue-600' : 'far fa-circle text-gray-400'); 
                                            ?> text-2xl mr-3"></i>
                                            <span class="text-lg font-semibold">True</span>
                                        </div>
                                    </div>
                                    
                                    <!-- False Option -->
                                    <div class="p-4 rounded-xl border-2 <?php 
                                        echo ($studentAnswer === 'false') ? 
                                            (($correctAnswer === 'false') ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50') : 
                                            (($correctAnswer === 'false') ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-white'); 
                                    ?>">
                                        <div class="flex items-center justify-center">
                                            <i class="<?php 
                                                echo ($studentAnswer === 'false') ? 
                                                    (($correctAnswer === 'false') ? 'fas fa-check-circle text-green-600' : 'fas fa-times-circle text-red-600') : 
                                                    (($correctAnswer === 'false') ? 'fas fa-info-circle text-blue-600' : 'far fa-circle text-gray-400'); 
                                            ?> text-2xl mr-3"></i>
                                            <span class="text-lg font-semibold">False</span>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php elseif ($question['question_type'] === 'short-answer'): ?>
                                <?php 
                                $studentText = $answer ? $answer['text_answer'] : '';
                                $correctAnswerData = getShortAnswer($conn, $question['question_id']);
                                $correctText = $correctAnswerData ? $correctAnswerData['correct_answer'] : '';
                                ?>
                                
                                <div class="space-y-4">
                                    <!-- Student's Answer -->
                                    <div>
                                        <h5 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                            <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                                            Student's Answer
                                        </h5>
                                        <div class="p-4 rounded-xl border-2 <?php echo $isCorrect ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50'; ?>">
                                            <?php if ($studentText): ?>
                                                <p class="text-gray-800 leading-relaxed"><?php echo nl2br(htmlspecialchars($studentText)); ?></p>
                                            <?php else: ?>
                                                <p class="text-gray-500 italic">No answer provided</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Correct Answer -->
                                    <div>
                                        <h5 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                            Expected Answer
                                        </h5>
                                        <div class="p-4 rounded-xl border-2 border-blue-300 bg-blue-50">
                                            <p class="text-gray-800 leading-relaxed"><?php echo nl2br(htmlspecialchars($correctText)); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Feedback Section -->
                            <div id="feedback-<?php echo $question['question_id']; ?>" class="hidden mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl no-print">
                                <h5 class="text-sm font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-comment-dots mr-2"></i>
                                    Teacher Feedback
                                </h5>
                                <textarea class="w-full p-3 border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" 
                                          rows="3" 
                                          placeholder="Add personalized feedback for this question..."></textarea>
                                <div class="mt-3 flex justify-end space-x-2">
                                    <button onclick="saveFeedback(<?php echo $question['question_id']; ?>)" 
                                            class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors">
                                        <i class="fas fa-save mr-1"></i>Save Feedback
                                    </button>
                                    <button onclick="toggleFeedback(<?php echo $question['question_id']; ?>)" 
                                            class="px-4 py-2 bg-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-400 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php $questionNumber++; ?>
                <?php endforeach; ?>
            </div>
        </div>













        

        <!-- Grade Recording & Actions -->
        <div class="bg-white rounded-2xl card-shadow-lg overflow-hidden mb-8 animate-fade-in no-print">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Grade Recording & Actions
                </h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Grade Recording -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Record Final Grade</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Calculated Score
                                </label>
                                <div class="p-3 bg-gray-50 rounded-lg border">
                                    <span class="text-2xl font-bold <?php echo $scorePercentage >= 75 ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $scorePercentage; ?>%
                                    </span>
                                    <span class="text-gray-600 ml-2">
                                        (<?php echo $totalPointsEarned; ?>/<?php echo $totalPossiblePoints; ?> points)
                                    </span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Adjusted Grade (Optional)
                                </label>
                                <input type="number" 
                                       min="0" 
                                       max="100" 
                                       value="<?php echo $scorePercentage; ?>"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter adjusted grade">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Grade Notes
                                </label>
                                <textarea class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                          rows="3" 
                                          placeholder="Add notes about grade adjustments or special considerations..."></textarea>
                            </div>
                            
                            <button class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Save Grade to Gradebook
                            </button>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h4>
                        <div class="space-y-3">
                            <button onclick="sendFeedbackToStudent()" 
                                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Send Feedback to Student
                            </button>
                            
                            <button onclick="scheduleRetake()" 
                                    class="w-full bg-yellow-600 text-white py-3 px-4 rounded-lg hover:bg-yellow-700 transition-colors font-medium flex items-center justify-center">
                                <i class="fas fa-redo mr-2"></i>
                                Schedule Retake
                            </button>
                            
                            <button onclick="exportDetailedReport()" 
                                    class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 transition-colors font-medium flex items-center justify-center">
                                <i class="fas fa-file-export mr-2"></i>
                                Export Detailed Report
                            </button>
                            
                            <button onclick="compareWithClass()" 
                                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition-colors font-medium flex items-center justify-center">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Compare with Class
                            </button>
                            
                            <button onclick="addToPortfolio()" 
                                    class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg hover:bg-teal-700 transition-colors font-medium flex items-center justify-center">
                                <i class="fas fa-folder-plus mr-2"></i>
                                Add to Student Portfolio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        // Toggle feedback sections
        function toggleFeedback(questionId) {
            const feedbackDiv = document.getElementById(`feedback-${questionId}`);
            feedbackDiv.classList.toggle('hidden');
        }

        // Save feedback for a question
        function saveFeedback(questionId) {
            const textarea = document.querySelector(`#feedback-${questionId} textarea`);
            const feedback = textarea.value.trim();
            
            if (feedback) {
                // Here you would typically send an AJAX request to save the feedback
                console.log(`Saving feedback for question ${questionId}: ${feedback}`);
                
                // Show success message
                showNotification('Feedback saved successfully!', 'success');
                
                // Hide feedback section
                toggleFeedback(questionId);
            } else {
                showNotification('Please enter feedback before saving.', 'warning');
            }
        }

        // Flag question for review
        function flagQuestion(questionId) {
            // Here you would typically send an AJAX request to flag the question
            console.log(`Flagging question ${questionId} for review`);
            showNotification('Question flagged for review.', 'info');
        }

        // Send feedback to student
        function sendFeedbackToStudent() {
            // Collect all feedback and send to student
            showNotification('Feedback sent to student successfully!', 'success');
        }

        // Schedule retake
        function scheduleRetake() {
            if (confirm('Schedule a retake for this student?')) {
                showNotification('Retake scheduled successfully!', 'success');
            }
        }

        // Export detailed report
        function exportDetailedReport() {
            showNotification('Generating detailed report...', 'info');
            // Implement export functionality
        }

        // Compare with class performance
        function compareWithClass() {
            showNotification('Opening class comparison view...', 'info');
            // Implement comparison functionality
        }

        // Add to student portfolio
        function addToPortfolio() {
            showNotification('Added to student portfolio!', 'success');
        }

        // Export to PDF
        function exportToPDF() {
            window.print();
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Initialize animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress rings
            const progressRings = document.querySelectorAll('.progress-ring-circle');
            progressRings.forEach(ring => {
                const circumference = 2 * Math.PI * 56;
                ring.style.strokeDasharray = circumference;
            });
        });
    </script>
</body>
</html>
