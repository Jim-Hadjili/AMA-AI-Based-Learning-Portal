<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

include_once '../../Functions/userInfo.php';

// Include function to fetch classes
include_once '../../Functions/fetchClasses.php';

// Get teacher's classes
$teacher_id = $_SESSION['user_id'];
$classes = getTeacherClasses($conn, $teacher_id);

// --- FILTERING & SEARCHING ---

// Search filter
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = strtolower(trim($_GET['search']));
    $classes = array_filter($classes, function($class) use ($search) {
        return (
            strpos(strtolower($class['class_name']), $search) !== false ||
            strpos(strtolower($class['class_code']), $search) !== false ||
            (isset($class['class_description']) && strpos(strtolower($class['class_description']), $search) !== false)
        );
    });
}

// Status filter
if (isset($_GET['status']) && $_GET['status'] !== 'all') {
    $status = $_GET['status'];
    $classes = array_filter($classes, function($class) use ($status) {
        return isset($class['status']) && $class['status'] === $status;
    });
}

// Sorting
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if ($sort === 'newest') {
        usort($classes, function($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });
    } elseif ($sort === 'oldest') {
        usort($classes, function($a, $b) {
            return strtotime($a['created_at']) <=> strtotime($b['created_at']);
        });
    } elseif ($sort === 'name') {
        usort($classes, function($a, $b) {
            return strtolower($a['class_name']) <=> strtolower($b['class_name']);
        });
    }
}

// --- COUNT STATUSES AFTER FILTERING ---
$activeClasses = 0;
$inactiveClasses = 0;
$archivedClasses = 0;
foreach ($classes as $class) {
    if (isset($class['status'])) {
        if ($class['status'] === 'active') {
            $activeClasses++;
        } elseif ($class['status'] === 'inactive') {
            $inactiveClasses++;
        } elseif ($class['status'] === 'archived') {
            $archivedClasses++;
        }
    }
}

// Pagination setup
$itemsPerPage = 9;
$totalClasses = count($classes);
$totalPages = ceil($totalClasses / $itemsPerPage);
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Validate current page
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}

// Get classes for current page
$startIndex = ($currentPage - 1) * $itemsPerPage;
$displayClasses = array_slice($classes, $startIndex, $itemsPerPage);
?>