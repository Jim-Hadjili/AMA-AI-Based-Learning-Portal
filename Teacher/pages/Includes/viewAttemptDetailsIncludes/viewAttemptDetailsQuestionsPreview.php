<div class="bg-white rounded-2xl card-shadow-lg overflow-hidden mb-8 animate-fade-in">
    <div class="bg-blue-500 px-6 py-4">
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
                                                                    (($correctAnswer === 'true') ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50') : (($correctAnswer === 'true') ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-white');
                                                                ?>">
                                <div class="flex items-center justify-center">
                                    <i class="<?php
                                                echo ($studentAnswer === 'true') ?
                                                    (($correctAnswer === 'true') ? 'fas fa-check-circle text-green-600' : 'fas fa-times-circle text-red-600') : (($correctAnswer === 'true') ? 'fas fa-info-circle text-blue-600' : 'far fa-circle text-gray-400');
                                                ?> text-2xl mr-3"></i>
                                    <span class="text-lg font-semibold">True</span>
                                </div>
                            </div>

                            <!-- False Option -->
                            <div class="p-4 rounded-xl border-2 <?php
                                                                echo ($studentAnswer === 'false') ?
                                                                    (($correctAnswer === 'false') ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50') : (($correctAnswer === 'false') ? 'border-blue-300 bg-blue-50' : 'border-gray-200 bg-white');
                                                                ?>">
                                <div class="flex items-center justify-center">
                                    <i class="<?php
                                                echo ($studentAnswer === 'false') ?
                                                    (($correctAnswer === 'false') ? 'fas fa-check-circle text-green-600' : 'fas fa-times-circle text-red-600') : (($correctAnswer === 'false') ? 'fas fa-info-circle text-blue-600' : 'far fa-circle text-gray-400');
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