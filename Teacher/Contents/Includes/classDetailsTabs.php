<?php
include_once "fetch-announcements.php";
?>

<!-- Class Content Tabs -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200">
        <button class="tab-btn active px-4 py-3 font-medium text-sm text-center flex-1 border-b-2 border-purple-primary text-purple-primary" data-tab="quizzes">
            <i class="fas fa-tasks mr-2"></i> Quizzes
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="students">
            <i class="fas fa-users mr-2"></i> Students
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="materials">
            <i class="fas fa-book mr-2"></i> Materials
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="announcements">
            <i class="fas fa-bullhorn mr-2"></i> Announcements
        </button>
        <button class="tab-btn px-4 py-3 font-medium text-sm text-center flex-1 text-gray-600 hover:text-gray-900" data-tab="info">
            <i class="fas fa-info-circle mr-2"></i> Class Info
        </button>
    </div>

    <!-- Tab Contents -->
    <div>
        <?php include "quizzesTab.php" ?>

        <!-- Students Tab -->
        <?php include "classDetailsStudentsTab.php" ?>

        <!-- Materials Tab -->
        <?php include "Materials/materialsTab.php" ?>

        <!-- Announcements Tab -->
        <?php include "Announcements/announcementsTabs.php" ?>
        <?php include "Announcements/view-announcement-modal.php"; ?>
        <?php include "Announcements/announcement-edit-modal.php"; ?>
        <?php include "Announcements/announcement-delete-modal.php"; ?>

        <!-- Class Info Tab -->
        <?php include "ClassInfoTabs/classInfo.php"; ?>
        
    </div>
</div>

<?php
// Helper function to format file size
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
?>

<script src="../../Assets/Js/classDetailsTabScript.js"></script>
<?php include "create-announcement-modal.php"; ?>
