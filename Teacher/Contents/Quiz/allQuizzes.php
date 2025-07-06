<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Include required files
include_once '../../Functions/userInfo.php';
include_once '../../Controllers/classController.php';

// Check if class_id is provided
if (!isset($_GET['class_id']) || empty($_GET['class_id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$class_id = intval($_GET['class_id']);

// Get class information for validation and display
$stmt = $conn->prepare("SELECT * FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?");
$stmt->bind_param("is", $class_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$classInfo = $result->fetch_assoc();

// Pagination settings
$quizzesPerPage = 9;
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $quizzesPerPage;

// Get search and filter parameters
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build the WHERE clause for filtering
$whereConditions = ["q.class_id = ? AND q.th_id = ?"];
$params = [$class_id, $_SESSION['user_id']];
$paramTypes = "is";

if (!empty($searchTerm)) {
    $whereConditions[] = "(q.quiz_title LIKE ? OR q.quiz_topic LIKE ? OR q.quiz_description LIKE ?)";
    $searchParam = "%{$searchTerm}%";
    $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
    $paramTypes .= "sss";
}

if ($statusFilter !== 'all') {
    $whereConditions[] = "q.status = ?";
    $params[] = $statusFilter;
    $paramTypes .= "s";
}

$whereClause = implode(" AND ", $whereConditions);

// Build the ORDER BY clause
$orderBy = "q.created_at DESC"; // default
switch($sortBy) {
    case 'oldest':
        $orderBy = "q.created_at ASC";
        break;
    case 'title':
        $orderBy = "q.quiz_title ASC";
        break;
    case 'attempts':
        $orderBy = "attempt_count DESC";
        break;
    case 'newest':
    default:
        $orderBy = "q.created_at DESC";
        break;
}

// Get total count for pagination
$countQuery = "
    SELECT COUNT(DISTINCT q.quiz_id) as total
    FROM quizzes_tb q 
    LEFT JOIN quiz_questions_tb qq ON q.quiz_id = qq.quiz_id 
    LEFT JOIN quiz_attempts_tb qa ON q.quiz_id = qa.quiz_id AND qa.status = 'completed'
    WHERE {$whereClause}
";

$stmt = $conn->prepare($countQuery);
$stmt->bind_param($paramTypes, ...$params);
$stmt->execute();
$totalQuizzes = $stmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalQuizzes / $quizzesPerPage);

// Fetch quizzes for current page
$quizzes = [];
if ($totalQuizzes > 0) {
    $query = "
        SELECT 
            q.*,
            COUNT(qq.question_id) as question_count,
            COUNT(DISTINCT qa.st_id) as attempt_count,
            AVG(qa.score) as avg_score
        FROM quizzes_tb q 
        LEFT JOIN quiz_questions_tb qq ON q.quiz_id = qq.quiz_id 
        LEFT JOIN quiz_attempts_tb qa ON q.quiz_id = qa.quiz_id AND qa.status = 'completed'
        WHERE {$whereClause}
        GROUP BY q.quiz_id 
        ORDER BY {$orderBy}
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $quizzesPerPage;
    $params[] = $offset;
    $paramTypes .= "ii";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param($paramTypes, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $quizzes = $result->fetch_all(MYSQLI_ASSOC);
}

// Helper functions
function getStatusBadge($status) {
    switch($status) {
        case 'published':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'archived':
            return 'bg-gray-100 text-gray-800 border-gray-400';
        default:
            return 'bg-gray-100 text-gray-800 border-gray-400';
    }
}

function formatTimeLimit($minutes) {
    if ($minutes == 0) return 'No limit';
    if ($minutes < 60) return $minutes . ' min';
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
}

// Function to build URL with current filters
function buildUrl($page = null, $search = null, $status = null, $sort = null) {
    global $currentPage, $searchTerm, $statusFilter, $sortBy, $class_id;
    
    $params = ['class_id' => $class_id];
    
    if ($page !== null) $params['page'] = $page;
    elseif ($currentPage > 1) $params['page'] = $currentPage;
    
    if ($search !== null) $params['search'] = $search;
    elseif (!empty($searchTerm)) $params['search'] = $searchTerm;
    
    if ($status !== null) $params['status'] = $status;
    elseif ($statusFilter !== 'all') $params['status'] = $statusFilter;
    
    if ($sort !== null) $params['sort'] = $sort;
    elseif ($sortBy !== 'newest') $params['sort'] = $sortBy;
    
    return 'allQuizzes.php?' . http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Quizzes - <?php echo htmlspecialchars($classInfo['class_name']); ?> - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .quiz-card {
            transition: all 0.2s ease;
        }
        .quiz-card:hover {
            transform: translateY(-2px);
        }
        .quiz-menu {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .pagination-btn {
            transition: all 0.2s ease;
        }
        .pagination-btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }
        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header Navigation -->
    <div class="max-w-7xl sticky top-0 bg-white/95 backdrop-blur-sm rounded-xl z-10 shadow-sm border border-gray-400 mb-4 mt-6 mx-auto">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="../Tabs/classDetails.php?class_id=<?php echo $class_id; ?>" 
                       class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Class</span>
                    </a>

                    <div class="h-4 w-px bg-gray-300"></div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">All Quizzes</h1>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($classInfo['class_name']); ?></p>
                    </div>
                </div>
                
                <a href="../Quiz/createQuiz.php?class_id=<?php echo $class_id; ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    New Quiz
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <?php if ($totalQuizzes === 0 && empty($searchTerm) && $statusFilter === 'all'): ?>
            <!-- Empty State - No quizzes at all -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-question text-4xl text-blue-500"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">No Quizzes Found</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    This class doesn't have any quizzes yet. Create your first quiz to start engaging your students.
                </p>
                <a href="../Quiz/createQuiz.php?class_id=<?php echo $class_id; ?>" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Quiz
                </a>
            </div>
        <?php else: ?>
            <!-- Stats and Filters -->
            <div class="mb-8">
                <!-- Stats Row -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg border border-gray-400">
                        <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $totalQuizzes; ?></div>
                        <div class="text-sm text-gray-500">
                            <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                                Filtered Results
                            <?php else: ?>
                                Total Quizzes
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-400">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                            <?php 
                            $publishedCount = 0;
                            foreach($quizzes as $quiz) {
                                if($quiz['status'] === 'published') $publishedCount++;
                            }
                            echo $publishedCount;
                            ?>
                        </div>
                        <div class="text-sm text-gray-500">Published</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-400">
                        <div class="text-2xl font-bold text-yellow-600 mb-1">
                            <?php 
                            $draftCount = 0;
                            foreach($quizzes as $quiz) {
                                if($quiz['status'] === 'draft') $draftCount++;
                            }
                            echo $draftCount;
                            ?>
                        </div>
                        <div class="text-sm text-gray-500">Drafts</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-400">
                        <div class="text-2xl font-bold text-blue-600 mb-1">
                            <?php echo array_sum(array_column($quizzes, 'attempt_count')); ?>
                        </div>
                        <div class="text-sm text-gray-500">Total Attempts</div>
                    </div>
                </div>
                
                <!-- Search and Filter Form -->
                <form method="GET" action="allQuizzes.php" class="bg-white p-6 rounded-lg border border-gray-400 shadow-sm">
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                    
                    <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Quizzes</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" 
                                       value="<?php echo htmlspecialchars($searchTerm); ?>"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                       placeholder="Search by title, topic, or description...">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Quizzes</option>
                                <option value="published" <?php echo $statusFilter === 'published' ? 'selected' : ''; ?>>Published</option>
                                <option value="draft" <?php echo $statusFilter === 'draft' ? 'selected' : ''; ?>>Drafts</option>
                                <option value="archived" <?php echo $statusFilter === 'archived' ? 'selected' : ''; ?>>Archived</option>
                            </select>
                        </div>
                        
                        <!-- Sort Filter -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select name="sort" id="sort" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="newest" <?php echo $sortBy === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                                <option value="oldest" <?php echo $sortBy === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                                <option value="title" <?php echo $sortBy === 'title' ? 'selected' : ''; ?>>Title A-Z</option>
                                <option value="attempts" <?php echo $sortBy === 'attempts' ? 'selected' : ''; ?>>Most Attempts</option>
                            </select>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                                <i class="fas fa-search mr-2"></i>
                                Filter
                            </button>
                            <a href="<?php echo buildUrl(1, '', 'all', 'newest'); ?>" 
                               class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($totalQuizzes === 0): ?>
                <!-- No Results State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">No quizzes found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria.</p>
                    <a href="<?php echo buildUrl(1, '', 'all', 'newest'); ?>" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Clear Filters
                    </a>
                </div>
            <?php else: ?>
                <!-- Results Info -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <div class="mb-4 sm:mb-0">
                        <p class="text-sm text-gray-600">
                            Showing <?php echo $offset + 1; ?>-<?php echo min($offset + $quizzesPerPage, $totalQuizzes); ?> 
                            of <?php echo $totalQuizzes; ?> quiz<?php echo $totalQuizzes != 1 ? 'zes' : ''; ?>
                            <?php if ($totalPages > 1): ?>
                                (Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                        <div class="flex items-center space-x-2 text-sm">
                            <span class="text-gray-500">Active filters:</span>
                            <?php if (!empty($searchTerm)): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Search: "<?php echo htmlspecialchars($searchTerm); ?>"
                                </span>
                            <?php endif; ?>
                            <?php if ($statusFilter !== 'all'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Status: <?php echo ucfirst($statusFilter); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quiz Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($quizzes as $quiz): ?>
                        <div class="quiz-card bg-white rounded-lg border border-gray-400 shadow-sm hover:shadow-md transition-all duration-200 hover:border-blue-200">
                            
                            <!-- Card Header -->
                            <div class="p-5 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                                            <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                        </h4>
                                        <?php if (!empty($quiz['quiz_topic'])): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-tag mr-1"></i>
                                                <?php echo htmlspecialchars($quiz['quiz_topic']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border <?php echo getStatusBadge($quiz['status']); ?>">
                                        <?php if ($quiz['status'] === 'published'): ?>
                                            <i class="fas fa-globe mr-1"></i>
                                        <?php elseif ($quiz['status'] === 'draft'): ?>
                                            <i class="fas fa-edit mr-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-archive mr-1"></i>
                                        <?php endif; ?>
                                        <?php echo ucfirst($quiz['status']); ?>
                                    </span>
                                </div>
                                
                                <!-- Description -->
                                <?php if (!empty($quiz['quiz_description'])): ?>
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                        <?php echo htmlspecialchars($quiz['quiz_description']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Card Body - Stats -->
                            <div class="p-5">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Questions Count -->
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">
                                            <?php echo $quiz['question_count']; ?>
                                        </div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wide">
                                            Question<?php echo $quiz['question_count'] != 1 ? 's' : ''; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Attempts Count -->
                                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                                        <div class="text-2xl font-bold text-gray-900 mb-1">
                                            <?php echo $quiz['attempt_count']; ?>
                                        </div>
                                        <div class="text-xs text-gray-500 uppercase tracking-wide">
                                            Attempt<?php echo $quiz['attempt_count'] != 1 ? 's' : ''; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quiz Details -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500 flex items-center">
                                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                                            Time Limit
                                        </span>
                                        <span class="font-medium text-gray-900">
                                            <?php echo formatTimeLimit($quiz['time_limit']); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500 flex items-center">
                                            <i class="fas fa-star mr-2 text-gray-400"></i>
                                            Points per Question
                                        </span>
                                        <span class="font-medium text-gray-900">
                                            <?php echo $quiz['points_per_question']; ?>
                                        </span>
                                    </div>
                                    
                                    <?php if ($quiz['avg_score'] !== null): ?>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500 flex items-center">
                                                <i class="fas fa-chart-line mr-2 text-gray-400"></i>
                                                Average Score
                                            </span>
                                            <span class="font-medium text-gray-900">
                                                <?php echo number_format($quiz['avg_score'], 1); ?>%
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Creation Date -->
                                <div class="text-xs text-gray-500 mb-4 flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    Created <?php echo date('M j, Y', strtotime($quiz['created_at'])); ?>
                                </div>
                            </div>

                            <!-- Card Footer - Actions -->
                            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 rounded-b-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <!-- View/Edit Button -->
                                        <a href="../Quiz/editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 focus:ring-2 focus:ring-blue-500 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        
                                        <!-- View Results Button -->
                                        <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                                            <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                                                <i class="fas fa-chart-bar mr-1"></i>
                                                Results
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- More Actions Dropdown -->
                                    <div class="relative">
                                        <button class="quiz-menu-btn inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md transition-colors" 
                                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        
                                        <!-- Dropdown Menu -->
                                        <div class="quiz-menu hidden absolute right-0 bottom-full mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-400 z-10">
                                            <div class="py-1">
                                                <?php if ($quiz['status'] === 'draft'): ?>
                                                    <button class="publish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                            data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                                        <i class="fas fa-paper-plane mr-2 text-green-500"></i>
                                                        Publish Quiz
                                                    </button>
                                                <?php elseif ($quiz['status'] === 'published'): ?>
                                                    <button class="unpublish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                            data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                                        <i class="fas fa-pause mr-2 text-yellow-500"></i>
                                                        Unpublish
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <button class="duplicate-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                                        data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                                                    <i class="fas fa-copy mr-2 text-blue-500"></i>
                                                    Duplicate
                                                </button>
                                                
                                                <a href="../Quiz/previewQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    <i class="fas fa-eye mr-2 text-purple-500"></i>
                                                    Preview
                                                </a>
                                                
                                                <div class="border-t border-gray-100 my-1"></div>
                                                
                                                <button class="delete-quiz-btn w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                                                        data-quiz-id="<?php echo $quiz['quiz_id']; ?>" 
                                                        data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Delete Quiz
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Controls -->
                <?php if ($totalPages > 1): ?>
                    <div class="bg-white border border-gray-400 rounded-lg p-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                            <!-- Pagination Info -->
                            <div class="text-sm text-gray-600">
                                Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?> 
                                (<?php echo $totalQuizzes; ?> total quiz<?php echo $totalQuizzes != 1 ? 'zes' : ''; ?>)
                            </div>
                            
                            <!-- Pagination Buttons -->
                            <div class="flex items-center space-x-1">
                                <!-- Previous Button -->
                                <?php if ($currentPage > 1): ?>
                                    <a href="<?php echo buildUrl($currentPage - 1); ?>" 
                                       class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                                        <i class="fas fa-chevron-left mr-1"></i>
                                        <span class="hidden sm:inline">Previous</span>
                                    </a>
                                <?php else: ?>
                                    <button disabled 
                                            class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg cursor-not-allowed">
                                        <i class="fas fa-chevron-left mr-1"></i>
                                        <span class="hidden sm:inline">Previous</span>
                                    </button>
                                <?php endif; ?>
                                
                                <!-- Page Numbers -->
                                <div class="hidden md:flex">
                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($totalPages, $currentPage + 2);
                                    
                                    // Show first page if not in range
                                    if ($startPage > 1): ?>
                                        <a href="<?php echo buildUrl(1); ?>" 
                                           class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                                            1
                                        </a>
                                        <?php if ($startPage > 2): ?>
                                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">
                                                ...
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <!-- Page range -->
                                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                        <?php if ($i == $currentPage): ?>
                                            <button class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border-t border-b border-blue-600 focus:ring-2 focus:ring-blue-500">
                                                <?php echo $i; ?>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo buildUrl($i); ?>" 
                                               class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                                                <?php echo $i; ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    
                                    <!-- Show last page if not in range -->
                                    <?php if ($endPage < $totalPages): ?>
                                        <?php if ($endPage < $totalPages - 1): ?>
                                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">
                                                ...
                                            </span>
                                        <?php endif; ?>
                                        <a href="<?php echo buildUrl($totalPages); ?>" 
                                           class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                                            <?php echo $totalPages; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Mobile Page Info -->
                                <div class="md:hidden inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300">
                                    <?php echo $currentPage; ?> / <?php echo $totalPages; ?>
                                </div>
                                
                                <!-- Next Button -->
                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="<?php echo buildUrl($currentPage + 1); ?>" 
                                       class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                                        <span class="hidden sm:inline">Next</span>
                                        <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                <?php else: ?>
                                    <button disabled 
                                            class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg cursor-not-allowed">
                                        <span class="hidden sm:inline">Next</span>
                                        <i class="fas fa-chevron-right ml-1"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Quick Jump (Desktop only) -->
                            <div class="hidden lg:flex items-center space-x-2">
                                <span class="text-sm text-gray-600">Go to page:</span>
                                <form method="GET" action="allQuizzes.php" class="flex items-center space-x-2">
                                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                                    <?php if (!empty($searchTerm)): ?>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                                    <?php endif; ?>
                                    <?php if ($statusFilter !== 'all'): ?>
                                        <input type="hidden" name="status" value="<?php echo $statusFilter; ?>">
                                    <?php endif; ?>
                                    <?php if ($sortBy !== 'newest'): ?>
                                        <input type="hidden" name="sort" value="<?php echo $sortBy; ?>">
                                    <?php endif; ?>
                                    <input type="number" name="page" min="1" max="<?php echo $totalPages; ?>" 
                                           value="<?php echo $currentPage; ?>"
                                           class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="submit" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                        Go
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quiz menu toggles
            document.querySelectorAll('.quiz-menu-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const menu = this.nextElementSibling;
                    
                    // Close all other menus
                    document.querySelectorAll('.quiz-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    
                    // Toggle current menu
                    menu.classList.toggle('hidden');
                });
            });

            // Close menus when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.quiz-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });

            // Quiz action handlers
            document.querySelectorAll('.delete-quiz-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const quizId = this.dataset.quizId;
                    const quizTitle = this.dataset.quizTitle;
                    
                    if (confirm(`Are you sure you want to delete "${quizTitle}"? This action cannot be undone.`)) {
                        // Add your delete quiz logic here
                        console.log('Delete quiz:', quizId);
                    }
                });
            });

            document.querySelectorAll('.publish-quiz-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const quizId = this.dataset.quizId;
                    // Add your publish quiz logic here
                    console.log('Publish quiz:', quizId);
                });
            });

            document.querySelectorAll('.duplicate-quiz-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const quizId = this.dataset.quizId;
                    // Add your duplicate quiz logic here
                    console.log('Duplicate quiz:', quizId);
                });
            });

            // Auto-submit form on filter change (optional)
            const autoSubmitElements = document.querySelectorAll('#status, #sort');
            autoSubmitElements.forEach(element => {
                element.addEventListener('change', function() {
                    // Uncomment the line below to enable auto-submit
                    // this.form.submit();
                });
            });
        });
    </script>
</body>
</html>