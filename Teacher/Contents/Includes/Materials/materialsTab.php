<div id="materials-tab" class="tab-content p-6 hidden">
    <?php if (empty($materials)): ?>
        <div class="text-center py-8">
            <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Materials Yet</h3>
            <p class="text-gray-500 mb-4">You haven't uploaded any learning materials for this class yet.</p>
            <button id="addFirstMaterialBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>Upload Materials
            </button>
        </div>
    <?php else: ?>
        <div class="mb-4 flex justify-between items-center">
            <h3 class="font-medium text-gray-900">Learning Materials (<?php echo count($materials); ?>)</h3>
            <button id="addMaterialBtn" class="px-3 py-1.5 bg-purple-primary text-white rounded-md hover:bg-purple-dark text-sm">
                <i class="fas fa-plus mr-1"></i> Add Material
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($materials as $material): ?>
                <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-200 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <?php
                            $extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);
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
                            ?>
                            <i class="fas <?php echo $icon; ?> text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 mb-1"><?php echo htmlspecialchars($material['material_title']); ?></h4>
                            <p class="text-xs text-gray-500 mb-2"><?php echo date('M d, Y', strtotime($material['upload_date'])); ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500"><?php echo formatFileSize($material['file_size'] ?? 0); ?></span>
                                <div>
                                    <a href="<?php echo htmlspecialchars($material['file_path']); ?>" download class="text-blue-600 hover:text-blue-900 text-sm mr-2">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="delete-material-btn text-red-600 hover:text-red-900 text-sm" data-material-id="<?php echo $material['material_id']; ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Include the material upload modal -->
<?php include_once "../Modals/materialUploadModal.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Open modal buttons
        const addFirstMaterialBtn = document.getElementById('addFirstMaterialBtn');
        const addMaterialBtn = document.getElementById('addMaterialBtn');
        const materialModal = document.getElementById('materialUploadModal');
        
        // Close modal buttons
        const closeMaterialModalBtn = document.getElementById('closeMaterialModalBtn');
        const cancelMaterialUploadBtn = document.getElementById('cancelMaterialUploadBtn');
        
        // File upload related elements
        const materialFileInput = document.getElementById('material_file');
        const fileUploadIcon = document.getElementById('file-upload-icon');
        const filePreview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const fileIcon = document.getElementById('file-icon');
        const removeFileBtn = document.getElementById('remove-file-btn');
        const fileError = document.getElementById('file-error');
        
        // Form element
        const materialUploadForm = document.getElementById('materialUploadForm');
        
        // Functions to open and close modal
        function openMaterialModal() {
            materialModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeMaterialModal() {
            materialModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            resetForm();
        }
        
        // Reset form function
        function resetForm() {
            materialUploadForm.reset();
            fileUploadIcon.classList.remove('hidden');
            filePreview.classList.add('hidden');
            fileError.classList.add('hidden');
        }
        
        // Format file size
        function formatFileSize(bytes) {
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
        function getFileIcon(extension) {
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
        
        // Add click event listeners
        if (addFirstMaterialBtn) {
            addFirstMaterialBtn.addEventListener('click', openMaterialModal);
        }
        
        if (addMaterialBtn) {
            addMaterialBtn.addEventListener('click', openMaterialModal);
        }
        
        if (closeMaterialModalBtn) {
            closeMaterialModalBtn.addEventListener('click', closeMaterialModal);
        }
        
        if (cancelMaterialUploadBtn) {
            cancelMaterialUploadBtn.addEventListener('click', closeMaterialModal);
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
                    fileSize.textContent = formatFileSize(file.size);
                    fileIcon.innerHTML = `<i class="fas ${getFileIcon(extension)}"></i>`;
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
        
        // Handle form submission
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
                        showNotification('Success', 'Material uploaded successfully!', 'success');
                        closeMaterialModal();
                        
                        // Reload page to show new material
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        // Error - show notification
                        showNotification('Error', data.message || 'Failed to upload material', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error', 'An unexpected error occurred', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
        }
        
        // Handle delete material buttons
        const deleteMaterialBtns = document.querySelectorAll('.delete-material-btn');
        if (deleteMaterialBtns) {
            deleteMaterialBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const materialId = this.getAttribute('data-material-id');
                    
                    if (confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
                        fetch('../../Controllers/materialController.php?action=delete', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `material_id=${materialId}&class_id=<?php echo $class_id; ?>`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('Success', 'Material deleted successfully!', 'success');
                                
                                // Remove the material element from DOM
                                const materialElement = btn.closest('.border');
                                if (materialElement) {
                                    materialElement.remove();
                                }
                                
                                // Reload if no more materials
                                const remainingMaterials = document.querySelectorAll('#materials-tab .grid > div');
                                if (remainingMaterials.length === 0) {
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            } else {
                                showNotification('Error', data.message || 'Failed to delete material', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error', 'An unexpected error occurred', 'error');
                        });
                    }
                });
            });
        }
        
        // Notification function
        function showNotification(title, message, type) {
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
    });
</script>