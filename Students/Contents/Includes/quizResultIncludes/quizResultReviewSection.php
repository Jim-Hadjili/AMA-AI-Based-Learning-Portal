 <div class="space-y-6">
     <?php if (empty($quizQuestions)): ?>
         <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
             <i class="fas fa-exclamation-circle text-gray-400 text-3xl mb-3"></i>
             <p class="text-gray-500">No questions found for this quiz.</p>
         </div>
     <?php else: ?>
         <?php foreach ($quizQuestions as $index => $question):
                $question_id = $question['question_id'];
                $student_answer = $studentAnswers[$question_id] ?? ['selected_options' => null, 'text_answer' => null, 'is_correct' => 0, 'points_awarded' => 0];
                $is_correct = $student_answer['is_correct'];
                $correct_info = $correctAnswersData[$question_id];

                $card_border_class = $is_correct ? 'border-green-300' : 'border-red-300';
                $icon_class = $is_correct ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600';
            ?>
             <div class="bg-white rounded-xl shadow-sm border <?php echo $card_border_class; ?> p-6">
                 <div class="flex items-start mb-4">
                     <div class="w-8 h-8 flex-shrink-0 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold mr-4">
                         <?php echo $index + 1; ?>
                     </div>
                     <div class="flex-1">
                         <p class="text-lg font-medium text-gray-900 mb-2"><?php echo htmlspecialchars($question['question_text']); ?></p>
                         <p class="text-sm text-gray-600">Points: <?php echo $question['question_points']; ?> | Awarded: <?php echo $student_answer['points_awarded']; ?></p>
                     </div>
                     <div class="ml-auto">
                         <i class="fas <?php echo $icon_class; ?> text-2xl"></i>
                     </div>
                 </div>

                 <div class="pl-12 space-y-3">
                     <?php if ($question['question_type'] === 'multiple-choice' || $question['question_type'] === 'true-false' || $question['question_type'] === 'checkbox'):
                            $student_selected_options = explode(',', $student_answer['selected_options']);
                        ?>
                         <p class="text-md font-semibold text-gray-800 mb-2">Your Answer:</p>
                         <?php foreach ($correct_info['options'] as $option):
                                $is_student_selected = in_array($option['option_id'], $student_selected_options);
                                $option_text_class = '';
                                $option_icon = '';

                                if ($option['is_correct']) {
                                    $option_text_class = 'text-green-700 font-bold';
                                    $option_icon = '<i class="fas fa-check ml-2 text-green-500"></i>';
                                } elseif ($is_student_selected && !$option['is_correct']) {
                                    $option_text_class = 'text-red-700 font-bold';
                                    $option_icon = '<i class="fas fa-times ml-2 text-red-500"></i>';
                                }
                            ?>
                             <div class="flex items-center">
                                 <span class="text-gray-700 <?php echo $option_text_class; ?>">
                                     <?php echo htmlspecialchars($option['option_text']); ?>
                                 </span>
                                 <?php echo $option_icon; ?>
                             </div>
                         <?php endforeach; ?>
                         <p class="text-md font-semibold text-gray-800 mt-4">Correct Answer(s):</p>
                         <p class="text-green-600"><?php echo htmlspecialchars($correct_info['correct_text']); ?></p>

                     <?php elseif ($question['question_type'] === 'short-answer'): ?>
                         <p class="text-md font-semibold text-gray-800 mb-2">Your Answer:</p>
                         <p class="text-gray-700 border p-2 rounded-md bg-gray-50"><?php echo htmlspecialchars($student_answer['text_answer'] ?? 'No answer provided.'); ?></p>
                         <p class="text-md font-semibold text-gray-800 mt-4">Correct Answer:</p>
                         <p class="text-green-600 border p-2 rounded-md bg-green-50"><?php echo htmlspecialchars($correct_info['correct_text'] ?? 'N/A'); ?></p>
                     <?php endif; ?>
                 </div>
             </div>
         <?php endforeach; ?>
     <?php endif; ?>

     <div class="text-center mt-8">
         <?php if (!$has_passed && $quizAttempt['allow_retakes']): ?>
             <a href="quizPage.php?quiz_id=<?php echo htmlspecialchars($quiz_id); ?>" class="px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-lg font-medium shadow-md mr-4">
                 Retake Quiz
             </a>
         <?php endif; ?>
         <a href="../Dashboard/studentDashboard.php" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-lg font-medium shadow-md">
             Back to Dashboard
         </a>
     </div>
 </div>