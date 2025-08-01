<?php
include_once "fetch-announcements.php";
?>

<!-- Class Content Tabs -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
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
        <div id="info-tab" class="tab-content p-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-medium text-gray-900">Class Information</h3>
                <button id="editClassInfoBtn" type="button"
                    class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-purple-600 text-sm font-semibold rounded-lg text-purple-700 hover:text-white bg-purple-50 hover:bg-purple-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17.414 2.586a2 2 0 00-2.828 0l-9.192 9.192a2 2 0 00-.516.878l-1.414 4.243a1 1 0 001.272 1.272l4.243-1.414a2 2 0 00.878-.516l9.192-9.192a2 2 0 000-2.828zm-10.607 10.607l7.778-7.778 2.121 2.121-7.778 7.778-2.121-2.121z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">Edit Class</span>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i> Basic Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Class Name</span>
                            <span class="font-medium"><?php echo htmlspecialchars($classDetails['class_name']); ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Subject</span>
                            <span class="font-medium"><?php echo htmlspecialchars($classDetails['subject_name'] ?? 'Not specified'); ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Grade Level</span>
                            <span class="font-medium">Grade <?php echo htmlspecialchars($classDetails['grade_level']); ?><?php echo !empty($classDetails['strand']) ? ' - ' . htmlspecialchars($classDetails['strand']) : ''; ?></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Class Code</span>
                            <div class="flex items-center">
                                <span class="font-mono font-medium mr-2"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                                <button class="copy-code-btn text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Class Schedule Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-green-500 mr-2"></i> Class Schedule
                    </h3>
                    <?php if (!empty($classDetails['schedule']) || !empty($classDetails['time_start']) || !empty($classDetails['time_end'])): ?>
                        <div class="space-y-3">
                            <?php if (!empty($classDetails['schedule'])): ?>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Days</span>
                                    <span class="font-medium"><?php echo htmlspecialchars($classDetails['schedule']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($classDetails['time_start']) && !empty($classDetails['time_end'])): ?>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Time</span>
                                    <span class="font-medium">
                                        <?php 
                                        $timeStart = date("g:i A", strtotime($classDetails['time_start']));
                                        $timeEnd = date("g:i A", strtotime($classDetails['time_end']));
                                        echo "$timeStart - $timeEnd"; 
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-gray-500 italic">No schedule information available</div>
                    <?php endif; ?>
                </div>

                <!-- Description Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm md:col-span-2">
                    <h3 class="font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-align-left text-purple-500 mr-2"></i> Class Description
                    </h3>
                    <?php if (!empty($classDetails['class_description'])): ?>
                        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($classDetails['class_description'])); ?></p>
                    <?php else: ?>
                        <p class="text-gray-500 italic">No description available</p>
                    <?php endif; ?>
                </div>

                <!-- Class Statistics Card -->
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm md:col-span-2">
                    <h3 class="font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-yellow-500 mr-2"></i> Class Statistics
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-100 rounded-lg bg-gray-50 p-4 text-center">
                            <div class="text-3xl font-bold text-purple-primary mb-1"><?php echo count($students); ?></div>
                            <div class="text-sm text-gray-500">Total Students</div>
                        </div>
                        <div class="border border-gray-100 rounded-lg bg-gray-50 p-4 text-center">
                            <div class="text-3xl font-bold text-blue-500 mb-1"><?php echo count($quizzes); ?></div>
                            <div class="text-sm text-gray-500">Total Quizzes</div>
                        </div>
                        <div class="border border-gray-100 rounded-lg bg-gray-50 p-4 text-center">
                            <div class="text-3xl font-bold text-green-500 mb-1"><?php echo count($materials); ?></div>
                            <div class="text-sm text-gray-500">Learning Materials</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener for the Edit Class button in the Class Info tab
    const editClassInfoBtn = document.getElementById('editClassInfoBtn');
    if (editClassInfoBtn) {
        editClassInfoBtn.addEventListener('click', function() {
            // Call the global openEditClassModal function if available
            if (typeof window.openEditClassModal === 'function') {
                window.openEditClassModal();
            } else {
                document.getElementById('editClassModal').classList.remove('hidden');
            }
        });
    }
    
    // Add event listeners for Announcement buttons
    const addFirstAnnouncementBtn = document.getElementById('addFirstAnnouncementBtn');
    const addAnnouncementBtn = document.getElementById('addAnnouncementBtn');
    
    if (addFirstAnnouncementBtn) {
        addFirstAnnouncementBtn.addEventListener('click', function() {
            if (typeof window.openAnnouncementModal === 'function') {
                window.openAnnouncementModal();
            } else {
                document.getElementById('announcementModal').classList.remove('hidden');
            }
        });
    }
    
    if (addAnnouncementBtn) {
        addAnnouncementBtn.addEventListener('click', function() {
            if (typeof window.openAnnouncementModal === 'function') {
                window.openAnnouncementModal();
            } else {
                document.getElementById('announcementModal').classList.remove('hidden');
            }
        });
    }
    
    // Get references to the new modals and their elements
    const editAnnouncementModal = document.getElementById('editAnnouncementModal');
    const editAnnouncementForm = document.getElementById('editAnnouncementForm');
    const editAnnouncementIdInput = document.getElementById('editAnnouncementId');
    const editAnnouncementTitleInput = document.getElementById('editAnnouncementTitle');
    const editAnnouncementContentTextarea = document.getElementById('editAnnouncementContent');
    const editPinAnnouncementCheckbox = document.getElementById('editPinAnnouncement');
    const closeEditAnnouncementModalBtn = editAnnouncementModal.querySelector('.fa-times').closest('button');

    const deleteAnnouncementModal = document.getElementById('deleteAnnouncementModal');
    const announcementTitleToDelete = document.getElementById('announcementTitleToDelete');
    const deleteAnnouncementIdInput = document.getElementById('deleteAnnouncementIdInput'); // NEW: Get the hidden input for ID
    const deleteAnnouncementForm = document.getElementById('deleteAnnouncementForm'); // NEW: Get the delete form
    const cancelDeleteAnnouncementBtn = document.getElementById('cancelDeleteAnnouncementBtn');
    const closeDeleteAnnouncementModalBtn = document.getElementById('closeDeleteAnnouncementModalBtn');

    // Add event listeners for edit and delete announcement buttons
    const editAnnouncementBtns = document.querySelectorAll('.edit-announcement-btn');
    const deleteAnnouncementBtns = document.querySelectorAll('.delete-announcement-btn');
    
    editAnnouncementBtns.forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the parent card's click event from firing
            const card = this.closest('.announcement-card-clickable');
            const announcementId = card.getAttribute('data-announcement-id');
            const title = card.getAttribute('data-announcement-title');
            const content = card.getAttribute('data-announcement-content');
            const isPinned = card.getAttribute('data-announcement-pinned') === 'true';

            editAnnouncementIdInput.value = announcementId;
            editAnnouncementTitleInput.value = title;
            editAnnouncementContentTextarea.value = content;
            editPinAnnouncementCheckbox.checked = isPinned;
            
            editAnnouncementModal.classList.remove('hidden');
        });
    });
    
    deleteAnnouncementBtns.forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the parent card's click event from firing
            const card = this.closest('.announcement-card-clickable');
            const announcementId = card.getAttribute('data-announcement-id');
            const title = card.getAttribute('data-announcement-title');

            deleteAnnouncementIdInput.value = announcementId; // Set the ID in the hidden input
            announcementTitleToDelete.textContent = title;
            
            deleteAnnouncementModal.classList.remove('hidden');
        });
    });

    // No need for a click listener on confirmDeleteAnnouncementBtn anymore,
    // as the form submission handles it directly.

    // Close delete modal buttons
    cancelDeleteAnnouncementBtn.addEventListener('click', () => deleteAnnouncementModal.classList.add('hidden'));
    closeDeleteAnnouncementModalBtn.addEventListener('click', () => deleteAnnouncementModal.classList.add('hidden'));
    deleteAnnouncementModal.addEventListener('click', function(event) {
        if (event.target === deleteAnnouncementModal) {
            deleteAnnouncementModal.classList.add('hidden');
        }
    });

    // Close edit modal button
    closeEditAnnouncementModalBtn.addEventListener('click', () => editAnnouncementModal.classList.add('hidden'));
    editAnnouncementModal.addEventListener('click', function(event) {
        if (event.target === editAnnouncementModal) {
            editAnnouncementModal.classList.add('hidden');
        }
    });

    // Handle clicking on announcement cards to view full content (existing logic)
    const announcementCards = document.querySelectorAll('.announcement-card-clickable');
    const viewAnnouncementModal = document.getElementById('viewAnnouncementModal');
    const viewAnnouncementTitle = document.getElementById('viewAnnouncementTitle');
    const viewAnnouncementContent = document.getElementById('viewAnnouncementContent');
    const viewAnnouncementDate = document.getElementById('viewAnnouncementDate');
    const viewAnnouncementPinned = document.getElementById('viewAnnouncementPinned');

    announcementCards.forEach(card => {
        card.addEventListener('click', function(event) {
            // Prevent opening modal if edit/delete buttons or their icons are clicked
            if (event.target.closest('.edit-announcement-btn') || event.target.closest('.delete-announcement-btn')) {
                return;
            }

            const title = this.getAttribute('data-announcement-title');
            const content = this.getAttribute('data-announcement-content');
            const date = this.getAttribute('data-announcement-date');
            const isPinned = this.getAttribute('data-announcement-pinned') === 'true';

            viewAnnouncementTitle.textContent = title;
            // Replace newlines with <br> tags for proper display in HTML
            viewAnnouncementContent.innerHTML = content.replace(/\n/g, '<br>'); 
            viewAnnouncementDate.textContent = date;

            if (isPinned) {
                viewAnnouncementPinned.classList.remove('hidden');
            } else {
                viewAnnouncementPinned.classList.add('hidden');
            }

            viewAnnouncementModal.classList.remove('hidden');
        });
    });

    // Close view announcement modal when clicking outside
    viewAnnouncementModal.addEventListener('click', function(event) {
        if (event.target === viewAnnouncementModal) {
            viewAnnouncementModal.classList.add('hidden');
        }
    });
});
</script>
<?php include "create-announcement-modal.php"; ?>
