<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($extension === 'pdf'): ?>
            // PDF.js viewer code
            const url = '<?php echo $file_path; ?>';

            // Load the PDF
            let pdfDoc = null;
            const container = document.getElementById('pdf-viewer');

            // Create a canvas element for each page
            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                pdfDoc = pdf;

                // Create navigation controls
                const navControls = document.createElement('div');
                navControls.className = 'flex items-center justify-between bg-gray-100 p-2 sticky top-0 z-10';
                navControls.innerHTML = `
                    <div>
                        <span class="text-sm font-medium">Page: <span id="page-num">1</span> / <span id="page-count">${pdf.numPages}</span></span>
                    </div>
                    <div class="flex space-x-2">
                        <button id="prev-page" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button id="next-page" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                `;
                container.appendChild(navControls);

                // Create a container for the PDF pages
                const pagesContainer = document.createElement('div');
                pagesContainer.className = 'pdf-pages overflow-auto h-full';
                pagesContainer.style.height = 'calc(100% - 40px)';
                container.appendChild(pagesContainer);

                // Variables for page navigation
                let currentPage = 1;
                const pageNum = document.getElementById('page-num');
                const pageCount = document.getElementById('page-count');
                const prevButton = document.getElementById('prev-page');
                const nextButton = document.getElementById('next-page');

                // Function to render a specific page
                function renderPage(pageNumber) {
                    pdfDoc.getPage(pageNumber).then(function(page) {
                        const viewport = page.getViewport({
                            scale: 1.5
                        });

                        // Create canvas for this page
                        const canvas = document.createElement('canvas');
                        canvas.className = 'pdf-page mx-auto mb-4';
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        pagesContainer.innerHTML = ''; // Clear previous page
                        pagesContainer.appendChild(canvas);

                        // Render the page
                        const context = canvas.getContext('2d');
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext);
                    });

                    // Update page number display
                    pageNum.textContent = pageNumber;

                    // Update buttons state
                    prevButton.disabled = pageNumber <= 1;
                    nextButton.disabled = pageNumber >= pdfDoc.numPages;
                }

                // Initial page rendering
                renderPage(currentPage);

                // Button event handlers
                prevButton.addEventListener('click', function() {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage(currentPage);
                    }
                });

                nextButton.addEventListener('click', function() {
                    if (currentPage < pdfDoc.numPages) {
                        currentPage++;
                        renderPage(currentPage);
                    }
                });
            });
        <?php endif; ?>

        // Initialize download modal functionality
        const downloadBtn = document.getElementById('downloadBtn');
        const downloadConfirmationModal = document.getElementById('downloadConfirmationModal');
        const closeDownloadModalBtn = document.getElementById('closeDownloadModalBtn');
        const cancelDownloadBtn = document.getElementById('cancelDownloadBtn');
        const confirmDownloadBtn = document.getElementById('confirmDownloadBtn');
        const materialTitleToDownload = document.getElementById('materialTitleToDownload');

        // Open download modal when download button is clicked
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                downloadConfirmationModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                // Set the material title in the modal
                if (materialTitleToDownload) {
                    materialTitleToDownload.textContent = "<?php echo htmlspecialchars($material['material_title']); ?>";
                }
            });
        }

        // Close modal functions
        function closeDownloadModal() {
            downloadConfirmationModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal event handlers
        if (closeDownloadModalBtn) {
            closeDownloadModalBtn.addEventListener('click', closeDownloadModal);
        }

        if (cancelDownloadBtn) {
            cancelDownloadBtn.addEventListener('click', closeDownloadModal);
        }

        // Confirm download
        if (confirmDownloadBtn) {
            confirmDownloadBtn.addEventListener('click', function() {
                // Force download using a temporary anchor
                const link = document.createElement('a');
                link.href = "<?php echo $file_path; ?>";
                link.download = "<?php echo htmlspecialchars($material['file_name']); ?>";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                closeDownloadModal();
            });
        }

        // Initialize delete modal functionality
        const deleteBtn = document.getElementById('deleteBtn');
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const materialTitleToDelete = document.getElementById('materialTitleToDelete');

        // Open delete modal when delete button is clicked
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                materialTitleToDelete.textContent = '<?php echo htmlspecialchars($material['material_title']); ?>';
                window.materialIdToDelete = <?php echo $material_id; ?>;
                deleteConfirmationModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        }

        // Close delete modal function
        function closeDeleteModal() {
            deleteConfirmationModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close delete modal event handlers
        if (closeDeleteModalBtn) {
            closeDeleteModalBtn.addEventListener('click', closeDeleteModal);
        }

        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', closeDeleteModal);
        }

        // Confirm delete
        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function() {
                const formData = new FormData();
                formData.append('material_id', window.materialIdToDelete);
                formData.append('class_id', <?php echo $material['class_id']; ?>);

                // Show loading state
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';

                // Send delete request to server
                fetch('../Controllers/materialController.php?action=delete', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log("Response status:", response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);
                        if (data.success) {
                            // Show success notification
                            showNotification('Success', 'Material deleted successfully', 'success');

                            // Redirect back to class details page after successful deletion
                            setTimeout(() => {
                                window.location.href = './Tabs/classDetails.php?class_id=<?php echo $material['class_id']; ?>';
                            }, 1500);
                        } else {
                            // Show error notification
                            showNotification('Error', data.message || 'Failed to delete material', 'error');
                            closeDeleteModal();

                            // Reset button state
                            this.disabled = false;
                            this.innerHTML = '<i class="fas fa-trash-alt mr-1.5"></i>Delete';
                        }
                    })
                    .catch(error => {
                        console.error('Error details:', error);
                        showNotification('Error', 'An error occurred while deleting material. Check console for details.', 'error');
                        closeDeleteModal();

                        // Reset button state
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-trash-alt mr-1.5"></i>Delete';
                    });
            });
        }

        // Notification function
        window.showNotification = function(title, message, type) {
            const notificationContainer = document.createElement('div');
            notificationContainer.className = `fixed bottom-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md animate-fadeIn ${
                    type === 'success' ? 'bg-green-50 border-l-4 border-green-500' : 
                    type === 'error' ? 'bg-red-50 border-l-4 border-red-500' : 
                    'bg-blue-50 border-l-4 border-blue-500'
                }`;

            notificationContainer.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas ${
                                type === 'success' ? 'fa-check-circle text-green-500' : 
                                type === 'error' ? 'fa-exclamation-circle text-red-500' : 
                                'fa-info-circle text-blue-500'
                            } text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium ${
                                type === 'success' ? 'text-green-800' : 
                                type === 'error' ? 'text-red-800' : 
                                'text-blue-800'
                            }">${title}</h3>
                            <p class="mt-1 text-sm ${
                                type === 'success' ? 'text-green-700' : 
                                type === 'error' ? 'text-red-700' : 
                                'text-blue-700'
                            }">${message}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button class="close-notification">
                                <i class="fas fa-times text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                `;

            // Add to DOM
            document.body.appendChild(notificationContainer);

            // Add click event to close button
            notificationContainer.querySelector('.close-notification').addEventListener('click', function() {
                notificationContainer.classList.replace('animate-fadeIn', 'animate-fadeOut');
                setTimeout(() => {
                    document.body.removeChild(notificationContainer);
                }, 300);
            });

            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (document.body.contains(notificationContainer)) {
                    notificationContainer.classList.replace('animate-fadeIn', 'animate-fadeOut');
                    setTimeout(() => {
                        if (document.body.contains(notificationContainer)) {
                            document.body.removeChild(notificationContainer);
                        }
                    }, 300);
                }
            }, 5000);
        }
    });
</script>