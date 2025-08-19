<?php
session_start();
include_once '../../Connection/conn.php';

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$attempt_id = $_GET['attempt_id'] ?? null;

if (!$attempt_id) {
    echo "Invalid request. Attempt ID is required.";
    exit;
}

// Fetch attempt details - updated to use teacher_classes_tb instead of class_tb
$attemptStmt = $conn->prepare("
    SELECT a.*, q.quiz_title, q.class_id, tc.class_name, tc.strand as subject
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
    WHERE a.attempt_id = ? AND q.th_id = ?
");
$attemptStmt->bind_param("is", $attempt_id, $teacher_id);
$attemptStmt->execute();
$attemptResult = $attemptStmt->get_result();

if ($attemptResult->num_rows === 0) {
    echo "Attempt not found or you don't have permission to view it.";
    exit;
}

$attempt = $attemptResult->fetch_assoc();
$quiz_id = $attempt['quiz_id'];
$class_id = $attempt['class_id'];
$student_id = $attempt['st_id'];

// Fetch student answers
$answersStmt = $conn->prepare("
    SELECT sa.*, 
           qq.question_text, 
           qq.question_type,
           qq.question_points
    FROM student_answers_tb sa
    JOIN quiz_questions_tb qq ON sa.question_id = qq.question_id
    WHERE sa.attempt_id = ?
    ORDER BY qq.question_order
");
$answersStmt->bind_param("i", $attempt_id);
$answersStmt->execute();
$answersResult = $answersStmt->get_result();
$answers = [];

while ($row = $answersResult->fetch_assoc()) {
    $answers[] = $row;
}

// Calculate summary
$totalPoints = array_sum(array_column($answers, 'question_points'));
$earnedPoints = array_sum(array_column($answers, 'points_earned'));
$scorePercent = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;

// Format timestamps
$startTime = new DateTime($attempt['start_time']);
$endTime = new DateTime($attempt['end_time']);
$duration = $startTime->diff($endTime);
$durationStr = '';

if ($duration->h > 0) {
    $durationStr .= $duration->h . ' hour' . ($duration->h > 1 ? 's' : '') . ' ';
}
if ($duration->i > 0) {
    $durationStr .= $duration->i . ' minute' . ($duration->i > 1 ? 's' : '') . ' ';
}
if ($duration->s > 0 || $durationStr === '') {
    $durationStr .= $duration->s . ' second' . ($duration->s !== 1 ? 's' : '');
}

// ==================== Get all related quizzes for this student ====================
// Helper function to get the root quiz (original teacher-created quiz)
function getRootQuizId($conn, $quiz_id)
{
    $current = $quiz_id;
    while (true) {
        $stmt = $conn->prepare("SELECT parent_quiz_id FROM quizzes_tb WHERE quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if ($row['parent_quiz_id']) {
                $current = $row['parent_quiz_id'];
            } else {
                break;
            }
        } else {
            break;
        }
    }
    return $current;
}

// Helper function to get all related quizzes (original + AI-generated versions)
function getAllRelatedQuizIds($conn, $quiz_id)
{
    $ids = [$quiz_id];
    $queue = [$quiz_id];
    while (!empty($queue)) {
        $current = array_shift($queue);
        $stmt = $conn->prepare("SELECT quiz_id FROM quizzes_tb WHERE parent_quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $ids[] = $row['quiz_id'];
            $queue[] = $row['quiz_id'];
        }
    }
    return $ids;
}

// Find the root quiz ID
$root_quiz_id = getRootQuizId($conn, $quiz_id);

// Get all related quiz IDs
$all_quiz_ids = getAllRelatedQuizIds($conn, $root_quiz_id);
$quiz_ids_str = implode(',', array_map('intval', $all_quiz_ids));

// Fetch all attempts for this student on any version of this quiz
// Fetch all attempts in chronological order (oldest first)
$allAttemptsStmt = $conn->prepare("
    SELECT a.attempt_id, a.quiz_id, a.start_time, a.end_time, a.score, 
           a.result, q.quiz_title, q.parent_quiz_id
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    WHERE a.st_id = ? AND a.quiz_id IN ($quiz_ids_str)
    ORDER BY a.start_time ASC
");
$allAttemptsStmt->bind_param("s", $student_id);
$allAttemptsStmt->execute();
$allAttemptsResult = $allAttemptsStmt->get_result();
$allAttempts = [];

while ($row = $allAttemptsResult->fetch_assoc()) {
    $allAttempts[] = $row;
}

// Assign chronological attempt numbers (1 for oldest, higher numbers for newer)
$totalAttempts = count($allAttempts);
foreach ($allAttempts as $index => $a) {
    // Add the chronological attempt number (counting from 1)
    $allAttempts[$index]['attempt_number'] = $index + 1;

    if ($a['attempt_id'] == $attempt_id) {
        $currentAttemptIndex = $index;
    }
}

// Create a copy of the original chronological array for the chart
$chronologicalAttempts = $allAttempts;

// Now sort the display array to show AI-generated ones first, then original ones
// But preserve the original attempt numbers
usort($allAttempts, function ($a, $b) {
    // If one is AI-generated and the other isn't, prioritize AI-generated
    if ($a['parent_quiz_id'] && !$b['parent_quiz_id']) {
        return -1; // a comes first
    }
    if (!$a['parent_quiz_id'] && $b['parent_quiz_id']) {
        return 1; // b comes first
    }

    // If both are the same type, sort by attempt number in DESCENDING order (newest first)
    return $b['attempt_number'] - $a['attempt_number'];
});
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attempt Details</title>
    <link rel="icon" type="image/png" href="../../Assets/Images/Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 font-[Poppins]">

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="../index.php" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <a href="../pages/manageCourses.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                            <?php echo htmlspecialchars($attempt['class_name']); ?>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <a href="../pages/quizzes.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                            Quizzes
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <a href="../pages/teacherQuizResult.php?quiz_id=<?php echo $quiz_id; ?>" class="text-gray-700 hover:text-blue-600">
                            Quiz Results
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <span class="text-gray-500">Student Attempt</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Student and Quiz Information -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200 px-6 py-5">
                <h1 class="text-xl font-bold text-gray-900">Student Quiz Attempt</h1>
            </div>
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Student</h3>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-full">
                                <span class="text-blue-800 font-medium"><?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?></span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></p>
                                <p class="text-sm text-gray-500"><?php echo htmlspecialchars($attempt['student_email']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Quiz</h3>
                        <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($attempt['quiz_title']); ?></p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Attempt Date</h3>
                        <p class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y, g:i a', strtotime($attempt['end_time'])); ?></p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Duration</h3>
                        <p class="mt-1 text-sm text-gray-900"><?php echo $durationStr; ?></p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Score</h3>
                        <p class="mt-1 text-sm font-medium <?php echo strtolower($attempt['result']) === 'passed' ? 'text-green-600' : 'text-red-600'; ?>">
                            <?php echo "{$earnedPoints}/{$totalPoints} ({$scorePercent}%)"; ?>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Result</h3>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo strtolower($attempt['result']) === 'passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                            <?php echo ucfirst($attempt['result']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Trend -->
        <?php if (count($allAttempts) > 1): ?>
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="border-b border-gray-200 px-6 py-5">
                    <h2 class="text-xl font-semibold text-gray-900">Performance Trend</h2>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('performanceChart').getContext('2d');
                    
                    // Prepare data for the chart - sort by attempt number for chronological display
                    const chartData = <?php 
                        // Create an array with attempt numbers and scores in chronological order
                        $chronologicalAttempts = array_values($allAttempts);
                        usort($chronologicalAttempts, function($a, $b) {
                            return $a['attempt_number'] - $b['attempt_number'];
                        });
                        
                        $chartData = array_map(function($attemptItem) use ($conn, $attempt_id) {
                            // Get total points for this quiz
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
                            if ($totalPossiblePoints == 0) $totalPossiblePoints = 1;
                            
                            return [
                                'label' => "Attempt " . $attemptItem['attempt_number'],
                                'score' => round(($attemptItem['score'] / $totalPossiblePoints) * 100),
                                'isAI' => !empty($attemptItem['parent_quiz_id']),
                                'isCurrent' => ($attemptItem['attempt_id'] == $attempt_id)
                            ];
                        }, $chronologicalAttempts);
                        
                        echo json_encode($chartData);
                    ?>;
                    
                    // Extract labels and scores
                    const chartLabels = chartData.map(item => item.label);
                    const chartScores = chartData.map(item => item.score);
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: 'Score (%)',
                                data: chartScores,
                                borderColor: '#0ea5e9', // accent-500
                                backgroundColor: 'rgba(14, 165, 233, 0.1)', // accent-500 with transparency
                                borderWidth: 2,
                                tension: 0.4, // Smooth the line
                                pointBackgroundColor: chartData.map(item => 
                                    item.isAI ? '#8b5cf6' : '#0ea5e9' // purple for AI, blue for original
                                ),
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                fill: true // Fill area under the line
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false // Hide legend since we only have one data series
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = `Score: ${context.raw}%`;
                                            if (chartData[context.dataIndex].isAI) {
                                                label += ' (AI Generated)';
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false // Hide x-axis grid lines
                                    },
                                    title: {
                                        display: true,
                                        text: 'Attempt Number',
                                        color: '#4b5563', // gray-600
                                        font: {
                                            size: 14
                                        }
                                    },
                                    ticks: {
                                        color: '#4b5563' // gray-600
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: {
                                        stepSize: 20,
                                        callback: function(value) {
                                            return value + '%';
                                        },
                                        color: '#4b5563' // gray-600
                                    },
                                    grid: {
                                        color: '#e5e7eb' // gray-200
                                    },
                                    title: {
                                        display: true,
                                        text: 'Score (%)',
                                        color: '#4b5563', // gray-600
                                        font: {
                                            size: 14
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <!-- All Attempts -->
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

        <!-- Answers Review section removed as requested -->

    </div>

    <?php if (count($allAttempts) > 1): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('performanceChart').getContext('2d');
                
                // Prepare data for the chart - sort by attempt number for chronological display
                const chartData = <?php 
                    // Create an array with attempt numbers and scores in chronological order
                    $chronologicalAttempts = array_values($allAttempts);
                    usort($chronologicalAttempts, function($a, $b) {
                        return $a['attempt_number'] - $b['attempt_number'];
                    });
                    
                    $chartData = array_map(function($attemptItem) use ($conn, $attempt_id) {
                        // Get total points for this quiz
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
                        if ($totalPossiblePoints == 0) $totalPossiblePoints = 1;
                        
                        return [
                            'label' => "Attempt " . $attemptItem['attempt_number'],
                            'score' => round(($attemptItem['score'] / $totalPossiblePoints) * 100),
                            'isAI' => !empty($attemptItem['parent_quiz_id']),
                            'isCurrent' => ($attemptItem['attempt_id'] == $attempt_id)
                        ];
                    }, $chronologicalAttempts);
                    
                    echo json_encode($chartData);
                ?>;
                
                // Extract labels and scores
                const chartLabels = chartData.map(item => item.label);
                const chartScores = chartData.map(item => item.score);
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Score (%)',
                            data: chartScores,
                            borderColor: '#0ea5e9', // accent-500
                            backgroundColor: 'rgba(14, 165, 233, 0.1)', // accent-500 with transparency
                            borderWidth: 2,
                            tension: 0.4, // Smooth the line
                            pointBackgroundColor: chartData.map(item => 
                                item.isAI ? '#8b5cf6' : '#0ea5e9' // purple for AI, blue for original
                            ),
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true // Fill area under the line
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Hide legend since we only have one data series
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = `Score: ${context.raw}%`;
                                        if (chartData[context.dataIndex].isAI) {
                                            label += ' (AI Generated)';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false // Hide x-axis grid lines
                                },
                                title: {
                                    display: true,
                                    text: 'Attempt Number',
                                    color: '#4b5563', // gray-600
                                    font: {
                                        size: 14
                                    }
                                },
                                ticks: {
                                    color: '#4b5563' // gray-600
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    stepSize: 20,
                                    callback: function(value) {
                                        return value + '%';
                                    },
                                    color: '#4b5563' // gray-600
                                },
                                grid: {
                                    color: '#e5e7eb' // gray-200
                                },
                                title: {
                                    display: true,
                                    text: 'Score (%)',
                                    color: '#4b5563', // gray-600
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    <?php endif; ?>
</body>

</html>