<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modules
        initMaterialModals();
        initFileHandling();
        initFormHandling();
        initMaterialActions();
    });

    // Initialize modal controls
    function initMaterialModals() {
        // Open modal buttons
        const addFirstMaterialBtn = document.getElementById('addFirstMaterialBtn');
        const addMaterialBtn = document.getElementById('addMaterialBtn');
        const materialModal = document.getElementById('materialUploadModal');
        
        // Delete modal elements
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const materialTitleToDelete = document.getElementById('materialTitleToDelete');
        window.materialIdToDelete = null;
        
        // Download modal elements
        const downloadConfirmationModal = document.getElementById('downloadConfirmationModal');
        const closeDownloadModalBtn = document.getElementById('closeDownloadModalBtn');
        const cancelDownloadBtn = document.getElementById('cancelDownloadBtn');
        const confirmDownloadBtn = document.getElementById('confirmDownloadBtn');
        const materialTitleToDownload = document.getElementById('materialTitleToDownload');
        window.materialDownloadPath = null;
        window.materialDownloadFilename = null;
        
        // Close modal buttons
        const closeMaterialModalBtn = document.getElementById('closeMaterialModalBtn');
        const cancelMaterialUploadBtn = document.getElementById('cancelMaterialUploadBtn');
        
        // Functions to open and close modals
        window.openMaterialModal = function() {
            materialModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        window.closeMaterialModal = function() {
            materialModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            resetForm();
        }
        
        window.openDeleteModal = function(materialId, materialTitle) {
            window.materialIdToDelete = materialId;
            materialTitleToDelete.textContent = materialTitle;
            deleteConfirmationModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        window.closeDeleteModal = function() {
            deleteConfirmationModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            window.materialIdToDelete = null;
        }
        
        window.openDownloadModal = function(materialTitle, path, filename) {
            materialTitleToDownload.textContent = materialTitle;
            window.materialDownloadPath = path;
            window.materialDownloadFilename = filename;
            downloadConfirmationModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        window.closeDownloadModal = function() {
            downloadConfirmationModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            window.materialDownloadPath = null;
            window.materialDownloadFilename = null;
        }
        
        // Add click event listeners for material modal
        if (addFirstMaterialBtn) {
            addFirstMaterialBtn.addEventListener('click', window.openMaterialModal);
        }
        
        if (addMaterialBtn) {
            addMaterialBtn.addEventListener('click', window.openMaterialModal);
        }
        
        if (closeMaterialModalBtn) {
            closeMaterialModalBtn.addEventListener('click', window.closeMaterialModal);
        }
        
        if (cancelMaterialUploadBtn) {
            cancelMaterialUploadBtn.addEventListener('click', window.closeMaterialModal);
        }
        
        // Add click event listeners for delete modal
        if (closeDeleteModalBtn) {
            closeDeleteModalBtn.addEventListener('click', window.closeDeleteModal);
        }
        
        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', window.closeDeleteModal);
        }
        
        // Add click event listeners for download modal
        if (closeDownloadModalBtn) {
            closeDownloadModalBtn.addEventListener('click', window.closeDownloadModal);
        }
        
        if (cancelDownloadBtn) {
            cancelDownloadBtn.addEventListener('click', window.closeDownloadModal);
        }
    }

    // Initialize file handling functionality
    function initFileHandling() {
        // File upload related elements
        const materialFileInput = document.getElementById('material_file');
        const fileUploadIcon = document.getElementById('file-upload-icon');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const fileIcon = document.getElementById('file-icon');
        const removeFileBtn = document.getElementById('remove-file-btn');
        const fileError = document.getElementById('file-error');
        
        // Reset form function
        window.resetForm = function() {
            const materialUploadForm = document.getElementById('materialUploadForm');
            if (materialUploadForm) {
                materialUploadForm.reset();
                fileUploadIcon.classList.remove('hidden');
                filePreview.classList.add('hidden');
                fileError.classList.add('hidden');
            }
        }
        
        // Format file size
        window.formatFileSize = function(bytes) {
            if (bytes >= 1073741824) {
                return (bytes / 1073741824).toFixed(2) + ' GB';
            } else if (bytes >= 1048576) {
                return (bytes / 1048576).toFixed(2) + ' MB';
            } else if (bytes >= 1024) {
                return (bytes / 1024).toFixed(2) + ' KB';
            } else {
                return bytes + ' bytes';
            }
        }
        
        // Get file icon based on extension
        window.getFileIcon = function(extension) {
            let icon = 'fa-file';
            
            if (['pdf'].includes(extension)) {
                icon = 'fa-file-pdf';
            } else if (['doc', 'docx'].includes(extension)) {
                icon = 'fa-file-word';
            } else if (['xls', 'xlsx'].includes(extension)) {
                icon = 'fa-file-excel';
            } else if (['ppt', 'pptx'].includes(extension)) {
                icon = 'fa-file-powerpoint';
            } else if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                icon = 'fa-file-image';
            } else if (['mp4', 'avi', 'mov'].includes(extension)) {
                icon = 'fa-file-video';
            }
            
            return icon;
        }
        
        // Handle file selection
        if (materialFileInput) {
            materialFileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const extension = file.name.split('.').pop().toLowerCase();
                    
                    // Validate file type
                    const allowedTypes = [
                        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
                        'jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'
                    ];
                    
                    if (!allowedTypes.includes(extension)) {
                        fileError.textContent = 'Invalid file type. Please upload a supported file format.';
                        fileError.classList.remove('hidden');
                        materialFileInput.value = '';
                        return;
                    }
                    
                    // Validate file size (max 50MB)
                    const maxSize = 50 * 1024 * 1024; // 50MB in bytes
                    if (file.size > maxSize) {
                        fileError.textContent = 'File size exceeds 50MB. Please upload a smaller file.';
                        fileError.classList.remove('hidden');
                        materialFileInput.value = '';
                        return;
                    }
                    
                    // Update preview
                    fileError.classList.add('hidden');
                    fileUploadIcon.classList.add('hidden');
                    filePreview.classList.remove('hidden');
                    fileName.textContent = file.name;
                    fileSize.textContent = window.formatFileSize(file.size);
                    fileIcon.innerHTML = `<i class="fas ${window.getFileIcon(extension)}"></i>`;
                }
            });
        }
        
        // Handle remove file button
        if (removeFileBtn) {
            removeFileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                materialFileInput.value = '';
                fileUploadIcon.classList.remove('hidden');
                filePreview.classList.add('hidden');
            });
        }
    }

    // Initialize form submission handling
    function initFormHandling() {
        const materialUploadForm = document.getElementById('materialUploadForm');
        
        if (materialUploadForm) {
            materialUploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
                
                const formData = new FormData(this);
                
                fetch('../../Controllers/materialController.php?action=upload', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success - show notification
                        window.showNotification('Success', 'Material uploaded successfully!', 'success');
                        window.closeMaterialModal();
                        
                        // Reload page to show new material
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        // Error - show notification
                        window.showNotification('Error', data.message || 'Failed to upload material', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.showNotification('Error', 'An unexpected error occurred', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
        }
    }

    // Initialize material action handlers (delete/download)
    function initMaterialActions() {
        // Handle delete confirmation
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                if (window.materialIdToDelete) {
                    // Show loading state
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
                    
                    fetch('../../Controllers/materialController.php?action=delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `material_id=${window.materialIdToDelete}&class_id=<?php echo $class_id; ?>`
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.closeDeleteModal();
                        
                        if (data.success) {
                            window.showNotification('Success', 'Material deleted successfully!', 'success');
                            
                            // Remove the material element from DOM
                            const deletedMaterial = document.querySelector(`.delete-material-btn[data-material-id="${window.materialIdToDelete}"]`);
                            if (deletedMaterial) {
                                const materialElement = deletedMaterial.closest('.border');
                                if (materialElement) {
                                    materialElement.remove();
                                }
                            }
                            
                            // Reload if no more materials
                            const remainingMaterials = document.querySelectorAll('#materials-tab .grid > div');
                            if (remainingMaterials.length === 0) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        } else {
                            window.showNotification('Error', data.message || 'Failed to delete material', 'error');
                        }
                        
                        // Reset button state
                        this.disabled = false;
                        this.innerHTML = 'Delete';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.showNotification('Error', 'An unexpected error occurred', 'error');
                        window.closeDeleteModal();
                        
                        // Reset button state
                        this.disabled = false;
                        this.innerHTML = 'Delete';
                    });
                }
            });
        }
        
        // Handle download confirmation
        const confirmDownloadBtn = document.getElementById('confirmDownloadBtn');
        if (confirmDownloadBtn) {
            confirmDownloadBtn.addEventListener('click', function() {
                if (window.materialDownloadPath) {
                    // Create a temporary anchor element to trigger the download
                    const downloadLink = document.createElement('a');
                    downloadLink.href = window.materialDownloadPath;
                    downloadLink.download = window.materialDownloadFilename || 'download';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    
                    // Close the modal
                    window.closeDownloadModal();
                    
                    // Show success notification
                    window.showNotification('Success', 'Download started!', 'success');
                }
            });
        }
        
        // Handle delete material buttons
        const deleteMaterialBtns = document.querySelectorAll('.delete-material-btn');
        if (deleteMaterialBtns) {
            deleteMaterialBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const materialId = this.getAttribute('data-material-id');
                    const materialTitle = this.getAttribute('data-material-title');
                    window.openDeleteModal(materialId, materialTitle);
                });
            });
        }
        
        // Handle download material buttons
        const downloadMaterialBtns = document.querySelectorAll('.download-material-btn');
        if (downloadMaterialBtns) {
            downloadMaterialBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const materialTitle = this.getAttribute('data-material-title');
                    const materialPath = this.getAttribute('data-material-path');
                    const materialFilename = this.getAttribute('data-material-filename');
                    window.openDownloadModal(materialTitle, materialPath, materialFilename);
                });
            });
        }
    }

    // Notification function
    window.showNotification = function(title, message, type) {
        const container = document.getElementById('notification-container');
        if (!container) return;
        
        const notificationId = 'notification-' + Date.now();
        const notificationClasses = type === 'success' 
            ? 'bg-green-50 border-green-500 text-green-700'
            : 'bg-red-50 border-red-500 text-red-700';
        
        const notification = document.createElement('div');
        notification.id = notificationId;
        notification.className = `rounded-lg border-l-4 p-4 ${notificationClasses} shadow-md animate-fadeIn`;
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${title}</p>
                    <p class="text-sm mt-1">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button type="button" class="close-notification text-${type === 'success' ? 'green' : 'red'}-500 hover:text-${type === 'success' ? 'green' : 'red'}-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(notification);
        
        // Add click event to close button
        notification.querySelector('.close-notification').addEventListener('click', function() {
            notification.classList.remove('animate-fadeIn');
            notification.classList.add('animate-fadeOut');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (document.getElementById(notificationId)) {
                notification.classList.remove('animate-fadeIn');
                notification.classList.add('animate-fadeOut');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 5000);
    }
</script>