<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Confirm Deletion</h3>
            <button type="button" id="closeDeleteModalBtn" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center mb-4 text-red-600">
                <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                <span class="text-lg font-medium">Warning</span>
            </div>
            <p class="text-gray-700">Are you sure you want to delete the material:</p>
            <p class="font-medium text-gray-900 mt-1" id="materialTitleToDelete"></p>
            <p class="text-sm text-gray-500 mt-2">This action cannot be undone.</p>
        </div>
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
            <button type="button" id="cancelDeleteBtn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="confirmDeleteBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Delete
            </button>
        </div>
    </div>
</div>