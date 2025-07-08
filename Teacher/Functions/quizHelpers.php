<?php
// Helper function to get status badge styling
function getStatusBadge($status) {
    switch($status) {
        case 'published':
            return 'bg-green-100 text-green-800 border-green-200';
        case 'draft':
            return 'bg-yellow-100 text-yellow-800 border-yellow-200';
        case 'archived':
            return 'bg-gray-100 text-gray-800 border-gray-200';
        default:
            return 'bg-gray-100 text-gray-800 border-gray-200';
    }
}

// Helper function to format time limit
function formatTimeLimit($minutes) {
    if ($minutes == 0) return 'No limit';
    if ($minutes < 60) return $minutes . ' min';
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours . 'h' . ($mins > 0 ? ' ' . $mins . 'm' : '');
}
?>