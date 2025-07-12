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