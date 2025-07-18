    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize download modal functionality
            const downloadBtn = document.getElementById('downloadBtn');
            const downloadConfirmationModal = document.getElementById('downloadConfirmationModal');
            const closeDownloadModalBtn = document.getElementById('closeDownloadModalBtn');
            const cancelDownloadBtn = document.getElementById('cancelDownloadBtn');
            const confirmDownloadBtn = document.getElementById('confirmDownloadBtn');
            const materialTitleToDownload = document.getElementById('materialTitleToDownload');

            // Open download modal when download button is clicked
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function() {
                    materialTitleToDownload.textContent = '<?php echo htmlspecialchars($materialDetails['file_name']); ?>';
                    window.materialDownloadPath = '<?php echo $webFilePath; ?>';
                    window.materialDownloadFilename = '<?php echo htmlspecialchars($materialDetails['file_name']); ?>';
                    downloadConfirmationModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
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
                    // Create a temporary anchor element to trigger the download
                    const downloadLink = document.createElement('a');
                    downloadLink.href = window.materialDownloadPath;
                    downloadLink.download = window.materialDownloadFilename;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);

                    // Close the modal
                    closeDownloadModal();
                });
            }
            <?php if (strtolower($materialDetails['file_type']) === 'pdf'): ?>
                // PDF.js viewer code
                const url = '<?php echo $webFilePath; ?>';

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
                    pagesContainer.style.height = 'calc(100% - 40px)'; // Adjust height to account for nav controls
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
        });
    </script>