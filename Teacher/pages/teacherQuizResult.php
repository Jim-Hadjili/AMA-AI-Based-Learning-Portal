<?php
session_start();
include_once '../../Connection/conn.php';
include_once '../Functions/quizHelpers.php'; // Include the helper functions

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "Invalid request. Quiz ID is required.";
    exit;
}

// Fetch quiz info (minimal query just to verify teacher owns this quiz)
$quizStmt = $conn->prepare("
    SELECT q.quiz_id, q.class_id, q.quiz_title
    FROM quizzes_tb q
    WHERE q.quiz_id = ? AND q.th_id = ?
");
$quizStmt->bind_param("is", $quiz_id, $teacher_id);
$quizStmt->execute();
$quizResult = $quizStmt->get_result();

if ($quizResult->num_rows === 0) {
    echo "Quiz not found or you don't have permission to view it.";
    exit;
}

$quiz = $quizResult->fetch_assoc();
$class_id = $quiz['class_id'];

// Get all related quiz IDs (original + AI regenerated versions)
function getAllRelatedQuizIds($conn, $quiz_id) {
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

// Find the original quiz (root of the chain)
function getRootQuizId($conn, $quiz_id) {
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

// Always start from the original quiz
$root_quiz_id = getRootQuizId($conn, $quiz_id);
$allQuizIds = getAllRelatedQuizIds($conn, $root_quiz_id);
$quizIdsStr = implode(',', array_map('intval', $allQuizIds));

// Fetch all attempts for all related quizzes
$stmt = $conn->prepare("
    SELECT a.*, 
           q.quiz_title, 
           q.quiz_type,
           (SELECT COUNT(*) FROM quiz_questions_tb WHERE quiz_id = a.quiz_id) as total_questions,
           CASE 
               WHEN q.parent_quiz_id IS NULL THEN 'Original'
               ELSE 'AI Generated' 
           END as version_type
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    WHERE a.quiz_id IN ($quizIdsStr) AND a.status = 'completed'
    ORDER BY a.student_name, a.end_time DESC
");
$stmt->execute();
$result = $stmt->get_result();
$attempts = [];

while ($row = $result->fetch_assoc()) {
    $attempts[] = $row;
}

// Gather additional student information from class_enrollments_tb
$studentInfo = [];
foreach ($attempts as $attempt) {
    $studentId = $attempt['st_id'];
    
    // Only fetch info if we haven't already
    if (!isset($studentInfo[$studentId])) {
        $studentStmt = $conn->prepare("
            SELECT ce.*, 
                   CASE 
                       WHEN ce.grade_level = 'grade_11' THEN 'Grade 11'
                       WHEN ce.grade_level = 'grade_12' THEN 'Grade 12'
                       ELSE ce.grade_level
                   END AS formatted_grade
            FROM class_enrollments_tb ce 
            WHERE ce.st_id = ? AND ce.class_id = ?
            LIMIT 1
        ");
        $studentStmt->bind_param("si", $studentId, $class_id);
        $studentStmt->execute();
        $studentRes = $studentStmt->get_result();
        
        if ($studentRes->num_rows > 0) {
            $studentInfo[$studentId] = $studentRes->fetch_assoc();
        } else {
            // If not found in this class, try to find in any class
            $anyClassStmt = $conn->prepare("
                SELECT ce.*, 
                       CASE 
                           WHEN ce.grade_level = 'grade_11' THEN 'Grade 11'
                           WHEN ce.grade_level = 'grade_12' THEN 'Grade 12'
                           ELSE ce.grade_level
                       END AS formatted_grade 
                FROM class_enrollments_tb ce 
                WHERE ce.st_id = ? 
                LIMIT 1
            ");
            $anyClassStmt->bind_param("s", $studentId);
            $anyClassStmt->execute();
            $anyClassRes = $anyClassStmt->get_result();
            
            if ($anyClassRes->num_rows > 0) {
                $studentInfo[$studentId] = $anyClassRes->fetch_assoc();
            } else {
                // Fallback if no enrollment record exists
                $studentInfo[$studentId] = [
                    'student_id' => 'Unknown',
                    'grade_level' => 'Unknown',
                    'formatted_grade' => 'Unknown',
                    'strand' => 'Unknown'
                ];
            }
        }
    }
}

// Calculate summary statistics
$totalAttempts = count($attempts);
$totalStudents = count(array_unique(array_column($attempts, 'st_id')));
$scoreSum = array_sum(array_column($attempts, 'score'));
$passingAttempts = count(array_filter($attempts, function($a) { return $a['result'] === 'passed'; }));

$avgScore = $totalAttempts > 0 ? round($scoreSum / $totalAttempts, 1) : 0;
$passRate = $totalAttempts > 0 ? round(($passingAttempts / $totalAttempts) * 100) : 0;

// Group students for chart display - simplified to focus on student data
$studentScores = [];
$uniqueStudents = [];

// Group by student to get their best scores and most recent attempt
foreach ($attempts as $attempt) {
    $studentId = $attempt['st_id'];
    $scorePercent = ($attempt['total_questions'] > 0) ? 
        round(($attempt['score'] / $attempt['total_questions']) * 100) : 0;
    
    if (!isset($studentScores[$studentId]) || $scorePercent > $studentScores[$studentId]['percent']) {
        $studentScores[$studentId] = [
            'name' => $attempt['student_name'],
            'score' => $attempt['score'],
            'total' => $attempt['total_questions'],
            'percent' => $scorePercent,
            'email' => $attempt['student_email'],
            'attempt_id' => $attempt['attempt_id'],
            'result' => $attempt['result'],
            'latest_attempt' => $attempt['end_time']
        ];
    }
    
    // Collect unique students with their most recent attempt
    if (!isset($uniqueStudents[$studentId])) {
        $uniqueStudents[$studentId] = [
            'student_id' => $studentId,
            'name' => $attempt['student_name'],
            'email' => $attempt['student_email'],
            'attempts' => 0, // Will count total attempts below
            'best_score' => 0,
            'best_percent' => 0,
            'latest_attempt_id' => $attempt['attempt_id'],
            'latest_attempt_date' => $attempt['end_time'],
            'latest_result' => $attempt['result']
        ];
    }
    
    // Update best score if this attempt is better
    if ($scorePercent > $uniqueStudents[$studentId]['best_percent']) {
        $uniqueStudents[$studentId]['best_score'] = $attempt['score'];
        $uniqueStudents[$studentId]['best_percent'] = $scorePercent;
    }
    
    // Update latest attempt if this one is more recent
    if (strtotime($attempt['end_time']) > strtotime($uniqueStudents[$studentId]['latest_attempt_date'])) {
        $uniqueStudents[$studentId]['latest_attempt_id'] = $attempt['attempt_id'];
        $uniqueStudents[$studentId]['latest_attempt_date'] = $attempt['end_time'];
        $uniqueStudents[$studentId]['latest_result'] = $attempt['result'];
    }
    
    // Count total attempts for this student
    $uniqueStudents[$studentId]['attempts']++;
}

// Format data for the chart
$chartLabels = array_map(function($s) { return $s['name']; }, array_values($studentScores));
$chartData = array_map(function($s) { return $s['percent']; }, array_values($studentScores));

$chartLabelsJson = json_encode($chartLabels);
$chartDataJson = json_encode($chartData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Quiz Results: <?php echo htmlspecialchars($quiz['quiz_title']); ?></title>
    <link rel="icon" type="image/png" href="../../Assets/Images/Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-[Poppins]">
    <?php include "../Includes/navbar.php"; ?>
    
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
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
                        <a href="../pages/quizzes.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                            Quizzes
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <span class="text-gray-500">Student Results</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Student Quiz Results</h1>
            <p class="mt-2 text-gray-600"><?php echo htmlspecialchars($quiz['quiz_title']); ?></p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Attempts -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Attempts</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?php echo $totalAttempts; ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unique Students -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Unique Students</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?php echo $totalStudents; ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Score -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Average Score</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?php echo $avgScore; ?></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pass Rate -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                            <i class="fas fa-percentage text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pass Rate</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900"><?php echo $passRate; ?>%</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart - Improved to clearly display student scores -->
        <?php if (count($studentScores) > 0): ?>
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Student Performance Comparison</h2>
            <div class="h-80">
                <canvas id="resultsChart"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <!-- Unique Students Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Students
                </h3>
            </div>
            <div class="overflow-x-auto">
                <?php if (empty($uniqueStudents)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">No attempts yet</h3>
                    <p class="text-gray-500 mt-2">Students haven't attempted this quiz yet.</p>
                </div>
                <?php else: ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Strand</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($uniqueStudents as $studentId => $student): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-full">
                                        <span class="text-blue-800 font-medium"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($student['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($studentInfo[$studentId]['student_id'] ?? 'Unknown'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($studentInfo[$studentId]['formatted_grade'] ?? 'Unknown'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars(ucfirst($studentInfo[$studentId]['strand'] ?? 'Unknown')); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $student['attempts']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium <?php echo $student['best_percent'] >= 75 ? 'text-green-600' : 'text-red-600'; ?>">
                                    <?php echo $student['best_percent']; ?>%
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="viewStudentAttempt.php?attempt_id=<?php echo $student['latest_attempt_id']; ?>" class="text-blue-600 hover:text-blue-900">View Latest</a>
                                <a href="studentAllAttempts.php?student_id=<?php echo $studentId; ?>&quiz_id=<?php echo $quiz_id; ?>" class="ml-3 text-purple-600 hover:text-purple-900">All Attempts</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- All Attempts Collapsible Section -->
        <div class="bg-white shadow rounded-lg overflow-hidden" x-data="{ open: false }">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center cursor-pointer" @click="open = !open">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    All Attempts (Details)
                </h3>
                <button class="text-gray-500 hover:text-gray-700">
                    <i class="fas" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>
            <div class="overflow-x-auto" x-show="open" x-transition>
                <?php if (empty($attempts)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">No attempts yet</h3>
                    <p class="text-gray-500 mt-2">Students haven't attempted this quiz yet.</p>
                </div>
                <?php else: ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Completed</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($attempts as $attempt): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-full">
                                        <span class="text-blue-800 font-medium"><?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?></span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($attempt['student_email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M j, Y, g:i a', strtotime($attempt['end_time'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php 
                                    $total = $attempt['total_questions'] ?: 1; // Prevent division by zero
                                    $scorePercent = round(($attempt['score'] / $total) * 100);
                                    echo "{$attempt['score']}/{$total} ({$scorePercent}%)"; 
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="viewStudentAttempt.php?attempt_id=<?php echo $attempt['attempt_id']; ?>" class="text-blue-600 hover:text-blue-900">View Details</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (count($studentScores) > 0): ?>
    <script>
        const ctx = document.getElementById('resultsChart').getContext('2d');
        const chartLabels = <?php echo $chartLabelsJson; ?>;
        const chartData = <?php echo $chartDataJson; ?>;
        
        // Use vibrant colors for better visibility
        const backgroundColors = [
            'rgba(54, 162, 235, 0.6)',
            'rgba(75, 192, 192, 0.6)', 
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(231, 233, 237, 0.6)',
            'rgba(97, 205, 187, 0.6)',
            'rgba(140, 122, 230, 0.6)',
            'rgba(250, 130, 49, 0.6)'
        ];
        
        // Create an array of colors matching the number of students
        const colors = chartLabels.map((_, index) => 
            backgroundColors[index % backgroundColors.length]
        );
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Score (%)',
                    data: chartData,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.6', '1')),
                    borderWidth: 1
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
                                return `Score: ${context.raw}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Score (%)',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Students',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>

    <!-- Alpine.js for collapsible sections -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>