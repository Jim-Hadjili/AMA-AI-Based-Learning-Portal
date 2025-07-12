<?php
/**
 * Format file size to readable format
 *
 * @param int $bytes File size in bytes
 * @return string Formatted file size with appropriate unit
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}

/**
 * Get appropriate Font Awesome icon class for a file type
 *
 * @param string $extension File extension
 * @return string Font Awesome icon class
 */
function getFileIconClass($extension) {
    $icon = 'fa-file';
    
    if (in_array($extension, ['pdf'])) {
        $icon = 'fa-file-pdf';
    } elseif (in_array($extension, ['doc', 'docx'])) {
        $icon = 'fa-file-word';
    } elseif (in_array($extension, ['xls', 'xlsx'])) {
        $icon = 'fa-file-excel';
    } elseif (in_array($extension, ['ppt', 'pptx'])) {
        $icon = 'fa-file-powerpoint';
    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        $icon = 'fa-file-image';
    } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
        $icon = 'fa-file-video';
    }
    
    return $icon;
}