<div class="overflow-hidden border border-gray-200 rounded-xl shadow-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wide">Student</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Classes</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">Activity</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
            <?php
            foreach ($uniqueStudents as $studentId => &$student) {
                $student['best_quiz_name'] = '';
                $student['needs_improvement_quiz_name'] = '';
                $student['best_score_value'] = 0;
                $student['needs_improvement_score'] = 100;

                if (isset($students) && !empty($students)) {
                    $studentQuizScores = [];
                    foreach ($students as $attempt) {
                        if ($attempt['student_id'] == $studentId) {
                            $quizId = $attempt['quiz_id'];
                            if (
                                !isset($studentQuizScores[$quizId]) ||
                                $attempt['score_percent'] > $studentQuizScores[$quizId]['score']
                            ) {
                                $studentQuizScores[$quizId] = [
                                    'score' => $attempt['score_percent'],
                                    'quiz_title' => $attempt['quiz_title']
                                ];
                            }
                        }
                    }
                    foreach ($studentQuizScores as $quizId => $data) {
                        if ($data['score'] > $student['best_score_value']) {
                            $student['best_score_value'] = $data['score'];
                            $student['best_quiz_name'] = $data['quiz_title'];
                        }
                        if ($data['score'] < $student['needs_improvement_score']) {
                            $student['needs_improvement_score'] = $data['score'];
                            $student['needs_improvement_quiz_name'] = $data['quiz_title'];
                        }
                    }
                }
                if ($student['needs_improvement_score'] == 100) {
                    $student['needs_improvement_score'] = 0;
                }
            }
            unset($student);
            ?>

            <?php foreach (array_slice($uniqueStudents, 0, 10) as $studentId => $student): ?>
                <tr class="hover:bg-indigo-50 cursor-pointer transition-colors duration-150" onclick="showStudentModal('<?php echo $studentId; ?>')">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <?php if (!empty($student['profile_picture'])): ?>
                                    <img class="h-10 w-10 rounded-full border-2 border-blue-100" src="../../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="">
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-200">
                                        <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($student['name']); ?></div>
                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($student['email']); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            <?php echo $student['enrolled_classes']; ?> / <?php echo $totalClassesCount; ?>
                        </span>
                        <div class="text-xs text-gray-400 mt-1">Classes Enrolled</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            <?php echo $student['attempts']; ?>
                        </span>
                        <div class="text-xs text-gray-400 mt-1">Quiz Submissions</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
