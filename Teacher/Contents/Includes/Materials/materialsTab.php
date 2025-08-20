<div id="materials-tab" class="tab-content p-6 hidden">
    <?php if (empty($materials)): ?>
        <!-- Empty State -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="text-center py-16 px-6">
                <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Learning Materials Yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Upload documents, presentations, videos, and other learning resources to help your students succeed.</p>
                
                <button id="addFirstMaterialBtn" class="inline-flex items-center px-6 py-3 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload First Material
                </button>
            </div>
        </div>
    <?php else: ?>
        <!-- Materials Header -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
            <div class="bg-white border-b border-gray-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Learning Materials</h3>
                            <p class="text-sm text-gray-600">Resources and documents for your students</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white border-2 border-blue-200 px-4 py-2 rounded-xl shadow-sm">
                            <div class="text-center">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Files</p>
                                <p class="text-xl font-bold text-blue-600"><?php echo count($materials); ?></p>
                            </div>
                        </div>
                        <button id="addMaterialBtn" type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Material
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($materials as $material): ?>
                <?php include "materialCard.php"; ?>
            <?php endforeach; ?>
        </div>

        <!-- Materials Summary Cards -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            <?php
            // Calculate file type statistics
            $fileTypes = [];
            $totalSize = 0;
            foreach ($materials as $material) {
                $extension = strtolower(pathinfo($material['file_path'], PATHINFO_EXTENSION));
                $fileTypes[$extension] = ($fileTypes[$extension] ?? 0) + 1;
                $totalSize += $material['file_size'] ?? 0;
            }
            
            // Get most common file types
            arsort($fileTypes);
            $topFileTypes = array_slice($fileTypes, 0, 3, true);
            ?>
            
            <!-- Total Size Card -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Size</p>
                        <p class="text-lg font-bold text-gray-900"><?php echo formatFileSize($totalSize); ?></p>
                    </div>
                </div>
            </div>

            <!-- File Types Cards -->
            <?php foreach ($topFileTypes as $type => $count): ?>
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="p-2 
                            <?php
                            if (in_array($type, ['pdf'])) echo 'bg-red-100';
                            elseif (in_array($type, ['doc', 'docx'])) echo 'bg-blue-100';
                            elseif (in_array($type, ['xls', 'xlsx'])) echo 'bg-green-100';
                            elseif (in_array($type, ['ppt', 'pptx'])) echo 'bg-orange-100';
                            elseif (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) echo 'bg-purple-100';
                            elseif (in_array($type, ['mp4', 'avi', 'mov'])) echo 'bg-indigo-100';
                            else echo 'bg-gray-100';
                            ?> rounded-lg mr-3">
                            <svg class="w-5 h-5 
                                <?php
                                if (in_array($type, ['pdf'])) echo 'text-red-600';
                                elseif (in_array($type, ['doc', 'docx'])) echo 'text-blue-600';
                                elseif (in_array($type, ['xls', 'xlsx'])) echo 'text-green-600';
                                elseif (in_array($type, ['ppt', 'pptx'])) echo 'text-orange-600';
                                elseif (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) echo 'text-purple-600';
                                elseif (in_array($type, ['mp4', 'avi', 'mov'])) echo 'text-indigo-600';
                                else echo 'text-gray-600';
                                ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <?php if (in_array($type, ['pdf'])): ?>
                                    <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    <path d="M16 3v6a2 2 0 002 2h6"/>
                                <?php elseif (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                <?php elseif (in_array($type, ['mp4', 'avi', 'mov'])): ?>
                                    <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                <?php else: ?>
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                <?php endif; ?>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide"><?php echo strtoupper($type); ?> Files</p>
                            <p class="text-lg font-bold text-gray-900"><?php echo $count; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Include modals and scripts -->
<?php include_once "../Modals/materialUploadModal.php"; ?>
<?php include_once "../Modals/materialDeleteModal.php"; ?>
<?php include_once "../Modals/materialDownloadModal.php"; ?>
<?php include_once "materialScripts.js.php"; ?>

<?php
// Helper function for file size formatting
if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
?>