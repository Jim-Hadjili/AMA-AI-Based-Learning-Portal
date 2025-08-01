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
            <button id="addMaterialBtn" type="button"
                class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-purple-600 text-sm font-semibold rounded-lg text-purple-700 hover:text-white bg-purple-50 hover:bg-purple-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <div class="font-semibold">Add Material</div>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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