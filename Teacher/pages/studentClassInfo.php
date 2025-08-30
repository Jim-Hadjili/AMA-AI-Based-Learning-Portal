<?php
session_start();
include_once '../../Connection/conn.php';

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$student_id = $_GET['student_id'] ?? null;
$class_id = $_GET['class_id'] ?? null;

if (!$student_id || !$class_id) {
    echo "Invalid request. Student ID and Class ID are required.";
    exit;
}

// Fetch student details
$studentStmt = $conn->prepare("
    SELECT sp.*, ce.enrollment_date 
    FROM students_profiles_tb sp
    JOIN class_enrollments_tb ce ON sp.st_id = ce.st_id
    WHERE sp.st_id = ? AND ce.class_id = ?
");
$studentStmt->bind_param("si", $student_id, $class_id);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();

if ($studentResult->num_rows === 0) {
    echo "Student not found or not enrolled in this class.";
    exit;
}

$student = $studentResult->fetch_assoc();

// Fetch class details
$classStmt = $conn->prepare("
    SELECT * FROM teacher_classes_tb 
    WHERE class_id = ? AND th_id = ?
");
$classStmt->bind_param("is", $class_id, $teacher_id);
$classStmt->execute();
$classResult = $classStmt->get_result();

if ($classResult->num_rows === 0) {
    echo "Class not found or you don't have permission to view it.";
    exit;
}

$classDetails = $classResult->fetch_assoc();

// Get all quizzes in this class - MODIFIED to only show manual quizzes
$quizzesStmt = $conn->prepare("
    SELECT q.*, 
           (SELECT COUNT(*) FROM quiz_attempts_tb WHERE quiz_id = q.quiz_id AND st_id = ?) AS attempt_count
    FROM quizzes_tb q
    WHERE q.class_id = ? 
      AND q.status = 'published' 
      AND q.th_id = ?
      AND q.quiz_type = 'manual'  /* Add this line to filter for manual quizzes only */
    ORDER BY q.created_at DESC
");
$quizzesStmt->bind_param("sis", $student_id, $class_id, $teacher_id);
$quizzesStmt->execute();
$quizzesResult = $quizzesStmt->get_result();
$quizzes = [];

while ($quiz = $quizzesResult->fetch_assoc()) {
    // For each quiz, get the latest attempt if it exists
    $attemptStmt = $conn->prepare("
        SELECT * FROM quiz_attempts_tb 
        WHERE quiz_id = ? AND st_id = ? 
        ORDER BY end_time DESC 
        LIMIT 1
    ");
    $attemptStmt->bind_param("is", $quiz['quiz_id'], $student_id);
    $attemptStmt->execute();
    $attemptResult = $attemptStmt->get_result();
    
    if ($attemptResult->num_rows > 0) {
        $quiz['latest_attempt'] = $attemptResult->fetch_assoc();
    } else {
        $quiz['latest_attempt'] = null;
    }
    
    // Get question count for this quiz
    $questionCountStmt = $conn->prepare("
        SELECT COUNT(*) as total_questions FROM quiz_questions_tb 
        WHERE quiz_id = ?
    ");
    $questionCountStmt->bind_param("i", $quiz['quiz_id']);
    $questionCountStmt->execute();
    $questionCountResult = $questionCountStmt->get_result();
    $questionCountRow = $questionCountResult->fetch_assoc();
    $quiz['question_count'] = $questionCountRow['total_questions'];
    
    // Get all AI-generated versions of this quiz (children)
    $aiVersionsStmt = $conn->prepare("
        WITH RECURSIVE quiz_hierarchy AS (
            SELECT quiz_id, parent_quiz_id, quiz_title 
            FROM quizzes_tb 
            WHERE quiz_id = ?
            UNION ALL
            SELECT q.quiz_id, q.parent_quiz_id, q.quiz_title
            FROM quizzes_tb q
            JOIN quiz_hierarchy qh ON q.parent_quiz_id = qh.quiz_id
        )
        SELECT quiz_id FROM quiz_hierarchy WHERE quiz_id != ?
    ");
    $aiVersionsStmt->bind_param("ii", $quiz['quiz_id'], $quiz['quiz_id']);
    $aiVersionsStmt->execute();
    $aiVersionsResult = $aiVersionsStmt->get_result();
    
    $aiQuizIds = [];
    while($aiVersion = $aiVersionsResult->fetch_assoc()) {
        $aiQuizIds[] = $aiVersion['quiz_id'];
    }
    
    // Count attempts on AI-generated versions
    $aiAttemptCount = 0;
    if (!empty($aiQuizIds)) {
        $aiQuizIdsStr = implode(',', $aiQuizIds);
        $aiAttemptsStmt = $conn->prepare("
            SELECT COUNT(*) as ai_attempts 
            FROM quiz_attempts_tb 
            WHERE quiz_id IN ({$aiQuizIdsStr}) AND st_id = ?
        ");
        $aiAttemptsStmt->bind_param("s", $student_id);
        $aiAttemptsStmt->execute();
        $aiAttemptsResult = $aiAttemptsStmt->get_result();
        $aiAttemptsRow = $aiAttemptsResult->fetch_assoc();
        $aiAttemptCount = $aiAttemptsRow['ai_attempts'];
    }
    
    // Add the AI attempts to the original attempt count
    $quiz['total_attempts'] = $quiz['attempt_count'] + $aiAttemptCount;
    
    $quizzes[] = $quiz;
}

// Get overall performance metrics
$totalQuizzes = count($quizzes);
$completedQuizzes = 0;
$totalScore = 0;
$totalPossibleScore = 0;

foreach ($quizzes as $quiz) {
    if ($quiz['latest_attempt'] && $quiz['latest_attempt']['status'] === 'completed') {
        $completedQuizzes++;
        $totalScore += $quiz['latest_attempt']['score'];
        $totalPossibleScore += $quiz['question_count'];
    }
}

$averageScore = $totalPossibleScore > 0 ? round(($totalScore / $totalPossibleScore) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information | <?php echo htmlspecialchars($student['st_userName']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body class="bg-gray-50 font-[Poppins]">
    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-4 -mt-4" aria-label="Breadcrumb">
            <div class="bg-white backdrop-blur-sm rounded-2xl border border-gray-100/60 shadow-sm px-4 py-3">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li>
                        <div class="flex items-center space-x-3">
                            <a href="../Contents/Tabs/classDetails.php?class_id=<?php echo $class_id; ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span>Back to Class</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-black mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="px-3 py-2 text-gray-900 font-medium bg-gray-50 rounded-xl">
                                Student Information </span>
                        </div>
                    </li>
                </ol>
            </div>
        </nav>
        
        <!-- Student Profile Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Student Profile</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <?php if (!empty($student['profile_picture'])): ?>
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-gray-200"
                                 src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>"
                                 alt="<?php echo htmlspecialchars($student['st_userName']); ?>">
                        <?php else: ?>
                            <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center border-4 border-gray-300">
                                <span class="text-white font-bold text-lg"><?php echo strtoupper(substr($student['st_userName'], 0, 2)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($student['st_userName']); ?></h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($student['st_email']); ?></p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <?php echo htmlspecialchars($student['grade_level'] === 'grade_11' ? 'Grade 11' : 'Grade 12'); ?>
                            </span>
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <?php echo htmlspecialchars($student['strand']); ?>
                            </span>
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Student ID: <?php echo htmlspecialchars($student['student_id'] ?? 'N/A'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Enrolled Since</p>
                        <p class="font-semibold text-gray-900"><?php echo date('F j, Y', strtotime($student['enrollment_date'])); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Class</p>
                        <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($classDetails['class_name']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-1">Subject Strand</p>
                        <p class="font-semibold text-gray-900"><?php echo htmlspecialchars($classDetails['strand']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Performance Overview -->
        <div class="w-full mb-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <!-- Total Quizzes Card -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Quizzes</h3>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Available quizzes</p>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Completed Quizzes Card -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Completed</h3>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $completedQuizzes; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Finished quizzes</p>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Pending Quizzes Card -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
                <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes - $completedQuizzes; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Not yet attempted</p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Search & Filters</h3>
                </div>
            </div>
            <div class="p-4 bg-gray-50">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Quiz</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="quiz-search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Search by quiz title...">
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="w-full md:w-48">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                            <option value="all">All Statuses</option>
                            <option value="completed">Completed</option>
                            <option value="not-attempted">Not Attempted</option>
                        </select>
                    </div>
                    
                    <!-- Reset Button -->
                    <div class="w-full md:w-auto flex items-end">
                        <button id="reset-filters" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-undo mr-2"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quizzes Table -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-lg rounded-xl overflow-hidden border border-blue-200 mb-8">
            <!-- Table Header -->
            <div class="bg-white border-b border-blue-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Class Quizzes</h3>
                            <p class="text-sm text-gray-600">Complete list of all quizzes and student attempts</p>
                        </div>
                    </div>
                    <?php if (!empty($quizzes)): ?>
                        <div class="bg-white px-4 py-2 rounded-xl shadow-sm">
                            <div class="text-center">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Quizzes</p>
                                <p class="text-xl font-bold text-blue-600"><?php echo count($quizzes); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (empty($quizzes)): ?>
                <!-- Empty state - No Quizzes Available -->
                <div class="bg-white p-6 text-center">
                    <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">No Quizzes Available</h4>
                    <p class="text-gray-500 max-w-md mx-auto">There are no quizzes in this class yet.</p>
                </div>
            <?php else: ?>
                <div class="bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Quiz
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                            </svg>
                                            Type
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Questions
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Status
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            Attempts
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="quiz-table-body" class="bg-white divide-y divide-gray-100">
                                <?php foreach ($quizzes as $quiz): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200 quiz-row" 
                                        data-title="<?php echo htmlspecialchars(strtolower($quiz['quiz_title'])); ?>"
                                        data-status="<?php echo !$quiz['latest_attempt'] ? 'not-attempted' : ($quiz['latest_attempt']['status'] === 'completed' ? 'completed' : 'other'); ?>"
                                        data-attempts="<?php echo $quiz['total_attempts'] > 0 ? 'with-attempts' : 'no-attempts'; ?>">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($quiz['quiz_title']); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo date('M j, Y', strtotime($quiz['created_at'])); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <?php if ($quiz['quiz_type'] == 'manual'): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Manual
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    AI Generated
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php echo $quiz['question_count']; ?> questions
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <?php if (!$quiz['latest_attempt']): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Not Attempted
                                                </span>
                                            <?php elseif ($quiz['latest_attempt']['status'] === 'completed'): ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Completed
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <?php echo ucfirst($quiz['latest_attempt']['status']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?php echo $quiz['total_attempts']; ?>
                                            <?php if ($quiz['total_attempts'] > $quiz['attempt_count'] && $quiz['attempt_count'] > 0): ?>
                                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    +<?php echo $quiz['total_attempts'] - $quiz['attempt_count']; ?> AI
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                            <?php if ($quiz['latest_attempt'] && $quiz['latest_attempt']['status'] === 'completed'): ?>
                                                <a href="viewStudentAttempt.php?attempt_id=<?php echo $quiz['latest_attempt']['attempt_id']; ?>" 
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View Attempt
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400">No Attempts</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty Results Message -->
                    <div id="no-results-message" class="hidden p-8 text-center">
                        <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No matching quizzes found</h4>
                        <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('quiz-search');
        const statusFilter = document.getElementById('status-filter');
        const resetButton = document.getElementById('reset-filters');
        const quizRows = document.querySelectorAll('.quiz-row');
        const noResultsMessage = document.getElementById('no-results-message');
        const quizTableBody = document.getElementById('quiz-table-body');
        
        // Function to apply filters
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            
            let visibleCount = 0;
            
            quizRows.forEach(row => {
                const title = row.dataset.title;
                const status = row.dataset.status;
                
                // Check if row matches all current filters
                const matchesSearch = title.includes(searchTerm);
                const matchesStatus = statusValue === 'all' || status === statusValue;
                
                // Show/hide row based on filter matches
                if (matchesSearch && matchesStatus) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });
            
            // Show "no results" message if no visible rows
            if (visibleCount === 0) {
                noResultsMessage.classList.remove('hidden');
                quizTableBody.classList.add('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
                quizTableBody.classList.remove('hidden');
            }
        }
        
        // Add event listeners to all filter inputs
        searchInput.addEventListener('input', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
        
        // Reset filters
        resetButton.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = 'all';
            applyFilters();
        });
        
        // Initialize filters
        applyFilters();
    });
    </script>
</body>
</html>