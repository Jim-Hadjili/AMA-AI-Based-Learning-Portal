<?php
/**
 * Get class information with validation
 */
function getClassInfo($conn, $class_id, $teacher_id) {
    $stmt = $conn->prepare("SELECT * FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?");
    $stmt->bind_param("is", $class_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../Dashboard/teachersDashboard.php");
        exit;
    }

    return $result->fetch_assoc();
}

/**
 * Get quizzes with filtering, sorting, and pagination
 */
function getQuizzesByFilters($conn, $class_id, $teacher_id, $searchTerm = '', $statusFilter = 'all', $sortBy = 'newest', $page = 1, $perPage = 10) {
    // Calculate offset for pagination
    $offset = ($page - 1) * $perPage;
    
    // Build the WHERE clause for filtering
    $whereConditions = ["q.class_id = ? AND q.th_id = ?"];
    $params = [$class_id, $teacher_id];
    $paramTypes = "is";

    // Add condition to exclude AI-generated quizzes (quiz_type = '1')
    $whereConditions[] = "(q.quiz_type = 'manual' OR q.quiz_type IS NULL)";

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
    $orderBy = getOrderByClause($sortBy);

    // Get total count for pagination
    $totalQuizzes = getQuizzesCount($conn, $whereClause, $paramTypes, $params);
    $totalPages = ceil($totalQuizzes / $perPage);

    // Fetch quizzes for current page
    $quizzes = [];
    if ($totalQuizzes > 0) {
        $quizzes = fetchQuizzesWithStats(
            $conn, 
            $whereClause, 
            $orderBy, 
            $perPage, 
            $offset, 
            $paramTypes, 
            $params
        );
    }

    return [
        'quizzes' => $quizzes,
        'total' => $totalQuizzes,
        'totalPages' => $totalPages,
        'offset' => $offset
    ];
}

/**
 * Get ORDER BY clause based on sort parameter
 */
function getOrderByClause($sortBy) {
    switch($sortBy) {
        case 'oldest':
            return "q.created_at ASC";
        case 'title':
            return "q.quiz_title ASC";
        case 'attempts':
            return "attempt_count DESC";
        case 'newest':
        default:
            return "q.created_at DESC";
    }
}

/**
 * Count total quizzes with filters
 */
function getQuizzesCount($conn, $whereClause, $paramTypes, $params) {
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
    return $stmt->get_result()->fetch_assoc()['total'];
}

/**
 * Fetch quizzes with stats and pagination
 */
function fetchQuizzesWithStats($conn, $whereClause, $orderBy, $limit, $offset, $paramTypes, $params) {
    $query = "
        SELECT 
            q.*,
            (SELECT COUNT(*) FROM quiz_questions_tb WHERE quiz_id = q.quiz_id) as question_count,
            COUNT(DISTINCT qa.st_id) as attempt_count,
            AVG(qa.score) as avg_score
        FROM quizzes_tb q 
        LEFT JOIN quiz_attempts_tb qa ON q.quiz_id = qa.quiz_id AND qa.status = 'completed'
        WHERE {$whereClause}
        GROUP BY q.quiz_id 
        ORDER BY {$orderBy}
        LIMIT ? OFFSET ?
    ";
    
    $params[] = $limit;
    $params[] = $offset;
    $paramTypes .= "ii";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param($paramTypes, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Calculate quiz statistics for display
 */
function calculateQuizStats($conn, $class_id, $teacher_id, $searchTerm = '', $statusFilter = 'all') {
    // Start building query and parameters
    $params = [$class_id, $teacher_id];
    $paramTypes = "is";
    $whereConditions = ["q.class_id = ? AND q.th_id = ?"];
    
    // Add condition to exclude AI-generated quizzes
    $whereConditions[] = "(q.quiz_type = 'manual' OR q.quiz_type IS NULL)";
    
    // Add search conditions if provided
    if (!empty($searchTerm)) {
        $whereConditions[] = "(q.quiz_title LIKE ? OR q.quiz_topic LIKE ? OR q.quiz_description LIKE ?)";
        $searchParam = "%{$searchTerm}%";
        $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
        $paramTypes .= "sss";
    }
    
    // Build WHERE clause
    $whereClause = implode(" AND ", $whereConditions);
    
    // Query to get counts by status
    $query = "
        SELECT 
            q.status,
            COUNT(*) as count,
            SUM((SELECT COUNT(*) FROM quiz_attempts_tb qa WHERE qa.quiz_id = q.quiz_id AND qa.status = 'completed')) as attempts
        FROM quizzes_tb q
        WHERE {$whereClause}
        GROUP BY q.status
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param($paramTypes, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Initialize counters
    $stats = [
        'published' => 0,
        'drafts' => 0,
        'archived' => 0,
        'attempts' => 0
    ];
    
    // Process results
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] === 'published') {
            $stats['published'] = $row['count'];
        } else if ($row['status'] === 'draft') {
            $stats['drafts'] = $row['count'];
        } else if ($row['status'] === 'archived') {
            $stats['archived'] = $row['count'];
        }
        $stats['attempts'] += ($row['attempts'] ?: 0);
    }
    
    return $stats;
}

/**
 * Get status badge classes for display
 */
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

/**
 * Format time limit for display
 */
function formatTimeLimit($minutes) {
    if ($minutes == 0) return 'No limit';
    if ($minutes < 60) return $minutes . ' min';
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
}

/**
 * Build URL with current filters
 */
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