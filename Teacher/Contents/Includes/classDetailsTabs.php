<?php
include_once "fetch-announcements.php";
?>

<!-- Class Content Tabs -->
<div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
    <!-- Tab Navigation -->
    <div class="grid grid-cols-5 gap-5 p-4 bg-gray-50 border-b border-gray-200">
        <!-- Quizzes Tab: Quiz/Question Icon -->
        <button class="tab-btn active text-indigo-500 bg-white p-4 rounded shadow-md flex items-center justify-center transition-colors border-b-2 border-purple-primary" data-tab="quizzes">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8M8 14h4" />
            </svg>
            Quizzes
        </button>
        <!-- Students Tab: User Group Icon -->
        <button class="tab-btn text-indigo-500 bg-white p-4 rounded shadow-md flex items-center justify-center transition-colors" data-tab="students">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M3 20h5v-2a4 4 0 00-3-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Students
        </button>
        <!-- Materials Tab: Book Icon -->
        <button class="tab-btn text-indigo-500 bg-white p-4 rounded shadow-md flex items-center justify-center transition-colors" data-tab="materials">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 006.5 22h11a2.5 2.5 0 002.5-2.5V6a2 2 0 00-2-2H6a2 2 0 00-2 2v13.5z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6v16" />
            </svg>
            Materials
        </button>
        <!-- Announcements Tab: Megaphone Icon -->
        <button class="tab-btn text-indigo-500 bg-white p-4 rounded shadow-md flex items-center justify-center transition-colors" data-tab="announcements">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8V6a4 4 0 00-8 0v2M5 8v8a2 2 0 002 2h10a2 2 0 002-2V8" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8" />
            </svg>
            Announcements
        </button>
        <!-- Class Info Tab: Info Icon -->
        <button class="tab-btn text-indigo-500 bg-white p-4 rounded shadow-md flex items-center justify-center transition-colors" data-tab="info">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4M12 8h.01" />
            </svg>
            Class Info
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
