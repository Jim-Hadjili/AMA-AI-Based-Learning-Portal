<div id="confirmModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">
        <div class="mb-4 flex items-center justify-center">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center border border-blue-100">
                <i class="fas fa-exclamation-circle text-blue-600 text-3xl"></i>
            </div>
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-2">Confirm Navigation</h4>
        <p id="confirmMessage" class="text-gray-900 mb-6 font-semibold text-lg bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded">
        </p>
        <div class="flex justify-center gap-3">
            <button id="cancelBtn" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium flex items-center gap-2">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button id="confirmBtn" class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium flex items-center gap-2">
                <i class="fas fa-arrow-right"></i>
                Proceed
            </button>
        </div>
    </div>
</div>