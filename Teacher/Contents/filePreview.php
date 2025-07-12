<?php
session_start();
include_once '../../Assets/Auth/sessionCheck.php';
include_once '../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Check if material_id is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$material_id = intval($_GET['id']);
$teacher_id = $_SESSION['user_id'];

// Get material details
$stmt = $conn->prepare("SELECT m.*, c.class_name FROM learning_materials_tb m 
                       JOIN teacher_classes_tb c ON m.class_id = c.class_id 
                       WHERE m.material_id = ? AND m.teacher_id = ?");
$stmt->bind_param("is", $material_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Material not found or doesn't belong to this teacher
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$material = $result->fetch_assoc();
$file_path = '../../' . $material['file_path'];
$extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);

// Helper function for file size formatting
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($material['material_title']); ?> - File Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
    
    <!-- PDF.js for PDF preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>
    
    <style>
        .preview-container {
            height: calc(100vh - 180px);
            min-height: 500px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Main Content -->
    <div class="container mx-auto p-4 lg:p-6">
        <!-- Header with Navigation -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-400 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <a href="javascript:history.back()" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"><?php echo htmlspecialchars($material['material_title']); ?></h1>
                    <p class="text-sm text-gray-600">From <?php echo htmlspecialchars($material['class_name']); ?></p>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Change the download button to show the modal instead of directly downloading -->
                    <button id="downloadBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center text-sm font-medium transition-all duration-200">
                        <i class="fas fa-download mr-2"></i> Download File
                    </button>
                    <button id="deleteBtn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center text-sm font-medium transition-all duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Delete Material
                    </button>
                </div>
            </div>
        </div>

        <!-- File Information -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-400 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-4 border-r border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">File Name</h3>
                    <p class="text-base font-medium"><?php echo htmlspecialchars($material['file_name']); ?></p>
                </div>
                <div class="p-4 border-r border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">File Type</h3>
                    <p class="text-base font-medium uppercase"><?php echo $extension; ?></p>
                </div>
                <div class="p-4 border-r border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">File Size</h3>
                    <p class="text-base font-medium"><?php echo formatFileSize($material['file_size']); ?></p>
                </div>
                <div class="p-4">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Upload Date</h3>
                    <p class="text-base font-medium"><?php echo date('F d, Y', strtotime($material['upload_date'])); ?></p>
                </div>
            </div>
            <?php if (!empty($material['material_description'])): ?>
            <div class="mt-4 p-4 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                <p class="text-base"><?php echo nl2br(htmlspecialchars($material['material_description'])); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- File Preview -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-400">
            <h2 class="text-xl font-medium mb-4">File Preview</h2>
            
            <div class="preview-container border border-gray-300 rounded-lg overflow-hidden">
                <?php if ($extension === 'pdf'): ?>
                    <!-- PDF Preview -->
                    <div id="pdf-viewer" class="w-full h-full"></div>
                <?php elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <!-- Image Preview -->
                    <div class="flex items-center justify-center h-full bg-gray-100">
                        <img src="<?php echo $file_path; ?>" alt="<?php echo htmlspecialchars($material['material_title']); ?>" class="max-w-full max-h-full object-contain">
                    </div>
                <?php elseif (in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                    <!-- Video Preview -->
                    <div class="flex items-center justify-center h-full bg-gray-900">
                        <video controls class="max-w-full max-h-full">
                            <source src="<?php echo $file_path; ?>" type="video/<?php echo $extension === 'mov' ? 'quicktime' : $extension; ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php else: ?>
                    <!-- Other File Types -->
                    <div class="flex flex-col items-center justify-center h-full bg-gray-50 text-center p-8">
                        <div class="text-6xl text-gray-400 mb-4">
                            <i class="fas fa-file<?php 
                                if (in_array($extension, ['doc', 'docx'])) echo '-word';
                                elseif (in_array($extension, ['xls', 'xlsx'])) echo '-excel';
                                elseif (in_array($extension, ['ppt', 'pptx'])) echo '-powerpoint';
                                else echo '';
                            ?>"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-700 mb-2">Preview not available</h3>
                        <p class="text-gray-500 mb-6">This file type cannot be previewed directly in the browser.</p>
                        <a href="<?php echo $file_path; ?>" download="<?php echo htmlspecialchars($material['file_name']); ?>" 
                           class="bg-purple-primary hover:bg-purple-dark text-white px-6 py-3 rounded-lg flex items-center text-base font-medium transition-all duration-200">
                            <i class="fas fa-download mr-2"></i> Download to View
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Include the download modal -->
    <?php include_once "./Modals/materialDownloadModal.php"; ?>
        <?php include_once "./Modals/materialDeleteModal.php"; ?>

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
                    materialTitleToDownload.textContent = '<?php echo htmlspecialchars($material['file_name']); ?>';
                    window.materialDownloadPath = '<?php echo $file_path; ?>';
                    window.materialDownloadFilename = '<?php echo htmlspecialchars($material['file_name']); ?>';
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
</body>
</html>
