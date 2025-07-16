<?php include "../../Functions/materialDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($materialDetails['material_title']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <!-- PDF.js for PDF preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>
    
    <style>
        .preview-container {
            height: calc(100vh - 180px); /* Adjust height as needed */
            min-height: 500px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Header -->
        <?php include "DashboardsIncludes/studentsHeader.php" ?>

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 pt-6">
            
            <?php
            // Define subject-specific styles
            $subjectStyles = [
                'English' => [
                    'strip' => 'from-blue-500 to-blue-700',
                    'icon_bg' => 'bg-blue-100',
                    'icon_color' => 'text-blue-600',
                    'icon_class' => 'fas fa-book-reader'
                ],
                'Math' => [
                    'strip' => 'from-green-500 to-green-700',
                    'icon_bg' => 'bg-green-100',
                    'icon_color' => 'text-green-600',
                    'icon_class' => 'fas fa-calculator'
                ],
                'Science' => [
                    'strip' => 'from-purple-500 to-purple-700',
                    'icon_bg' => 'bg-purple-100',
                    'icon_color' => 'text-purple-600',
                    'icon_class' => 'fas fa-flask'
                ],
                'History' => [
                    'strip' => 'from-yellow-500 to-yellow-700',
                    'icon_bg' => 'bg-yellow-100',
                    'icon_color' => 'text-yellow-600',
                    'icon_class' => 'fas fa-landmark'
                ],
                'Arts' => [
                    'strip' => 'from-pink-500 to-pink-700',
                    'icon_bg' => 'bg-pink-100',
                    'icon_color' => 'text-pink-600',
                    'icon_class' => 'fas fa-paint-brush'
                ],
                'PE' => [
                    'strip' => 'from-red-500 to-red-700',
                    'icon_bg' => 'bg-red-100',
                    'icon_color' => 'text-red-600',
                    'icon_class' => 'fas fa-running'
                ],
                'ICT' => [
                    'strip' => 'from-indigo-500 to-indigo-700',
                    'icon_bg' => 'bg-indigo-100',
                    'icon_color' => 'text-indigo-600',
                    'icon_class' => 'fas fa-laptop-code'
                ],
                'Home Economics' => [
                    'strip' => 'from-orange-500 to-orange-700',
                    'icon_bg' => 'bg-orange-100',
                    'icon_color' => 'text-orange-600',
                    'icon_class' => 'fas fa-utensils'
                ],
                'Default' => [
                    'strip' => 'from-gray-500 to-gray-700',
                    'icon_bg' => 'bg-gray-100',
                    'icon_color' => 'text-gray-600',
                    'icon_class' => 'fas fa-graduation-cap'
                ]
            ];

            $subject = $materialDetails['class_subject'] ?? 'Default';
            $style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
            ?>

            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="studentDashboard.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="classDetails.php?class_id=<?php echo $materialDetails['class_id']; ?>" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                                <?php echo htmlspecialchars($materialDetails['class_name']); ?>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Learning Material</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Material Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                <div class="h-3 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="inline-block p-4 rounded-lg bg-blue-100 mr-4">
                                <i class="<?php echo $materialDetails['file_icon']; ?> text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($materialDetails['material_title']); ?></h1>
                                <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($materialDetails['material_description'] ?? 'No description provided.'); ?></p>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-file mr-1"></i><?php echo htmlspecialchars($materialDetails['file_name']); ?></span>
                                    <span><i class="fas fa-hdd mr-1"></i><?php echo $materialDetails['formatted_file_size']; ?></span>
                                    <span><i class="fas fa-calendar mr-1"></i><?php echo date('M j, Y', strtotime($materialDetails['upload_date'])); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                <?php echo strtoupper($materialDetails['file_type']); ?>
                            </span>
                            <?php if ($fileExists): ?>
                                <button id="downloadBtn" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    <i class="fas fa-download mr-2"></i>Download
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full <?php echo $style['icon_bg']; ?> mr-4">
                            <i class="<?php echo $style['icon_class']; ?> <?php echo $style['icon_color']; ?> text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Subject</p>
                            <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['class_subject']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 mr-4">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Grade Level</p>
                            <p class="text-lg font-bold text-gray-900">Grade <?php echo htmlspecialchars($materialDetails['grade_level']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 mr-4">
                            <i class="fas fa-tag text-orange-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Strand</p>
                            <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['strand'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <i class="fas fa-user-tie text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Teacher</p>
                            <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['teacher_name'] ?? 'Unknown'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Preview Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">File Preview</h2>
                </div>
                <div class="p-6">
                    <?php if (!$fileExists): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">File Not Found</h3>
                            <p class="text-gray-500">The requested file could not be found on the server.</p>
                        </div>
                    <?php elseif ($canPreview): ?>
                        <div class="border rounded-lg overflow-hidden">
                            <?php if (strtolower($materialDetails['file_type']) === 'pdf'): ?>
                                <!-- PDF Preview -->
                                <div id="pdf-viewer" class="w-full h-full"></div>
                            <?php elseif (in_array(strtolower($materialDetails['file_type']), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                <img src="<?php echo $webFilePath; ?>" 
                                     alt="<?php echo htmlspecialchars($materialDetails['material_title']); ?>"
                                     class="w-full h-auto max-h-96 object-contain bg-gray-50">
                            <?php elseif (strtolower($materialDetails['file_type']) === 'txt'): ?>
                                <div class="p-4 bg-gray-50 max-h-96 overflow-y-auto">
                                    <pre class="whitespace-pre-wrap text-sm text-gray-800"><?php echo htmlspecialchars(file_get_contents($serverFilePath)); ?></pre>
                                </div>
                            <?php elseif (in_array(strtolower($materialDetails['file_type']), ['mp4', 'avi', 'mov'])): ?>
                                <!-- Video Preview -->
                                <div class="flex items-center justify-center h-full bg-gray-900">
                                    <video controls class="max-w-full max-h-full">
                                        <source src="<?php echo $webFilePath; ?>" type="video/<?php echo strtolower($materialDetails['file_type']) === 'mov' ? 'quicktime' : strtolower($materialDetails['file_type']); ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <i class="<?php echo $materialDetails['file_icon']; ?> text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Not Available</h3>
                            <p class="text-gray-500 mb-4">This file type cannot be previewed in the browser.</p>
                            <p class="text-sm text-gray-400 mb-4">Supported preview formats: PDF, Images (JPG, PNG, GIF), Text files</p>
                            <a href="<?php echo $webFilePath; ?>" 
                               download="<?php echo $materialDetails['file_name']; ?>"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-download mr-2"></i>Download to View
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Material Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Material Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Class Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Class:</span> <?php echo htmlspecialchars($materialDetails['class_name']); ?></p>
                                <p><span class="font-medium">Class Code:</span> <?php echo htmlspecialchars($materialDetails['class_code']); ?></p>
                                <p><span class="font-medium">Subject:</span> <?php echo htmlspecialchars($materialDetails['class_subject']); ?></p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-2">File Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">File Type:</span> <?php echo strtoupper($materialDetails['file_type']); ?></p>
                                <p><span class="font-medium">File Size:</span> <?php echo $materialDetails['formatted_file_size']; ?></p>
                                <p><span class="font-medium">Upload Date:</span> <?php echo date('F j, Y \a\t g:i A', strtotime($materialDetails['upload_date'])); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($materialDetails['material_description'])): ?>
                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($materialDetails['material_description'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>

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
                        const viewport = page.getViewport({ scale: 1.5 });
                        
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

    <!-- Download Confirmation Modal -->
    <div id="downloadConfirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center hidden backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 transform transition-all duration-300">
            <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white rounded-t-xl">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <i class="fas fa-file-download text-blue-600"></i>
                    </span>
                    Confirm Download
                </h3>
                <button type="button" id="closeDownloadModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full p-1 hover:bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-download text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-medium text-blue-600 mb-2">Download Material</h4>
                        <p class="text-gray-700 mb-2">You're about to download:</p>
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg mb-3 flex items-center">
                            <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                            <p class="font-medium text-gray-900" id="materialTitleToDownload"></p>
                        </div>
                        <p class="text-sm text-gray-500 flex items-center">
                            <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                            Click "Download" to continue or "Cancel" to go back.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-200">
                <button type="button" id="cancelDownloadBtn" class="px-4 py-2.5 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    <i class="fas fa-times mr-1.5"></i>Cancel
                </button>
                <button type="button" id="confirmDownloadBtn" class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-600 hover:to-blue-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-1.5"></i>Download
                </button>
            </div>
        </div>
    </div>
</body>

</html>
