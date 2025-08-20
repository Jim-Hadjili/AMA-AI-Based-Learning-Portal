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