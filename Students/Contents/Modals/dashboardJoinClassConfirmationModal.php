<div id="confirmJoinModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 relative">
        <button id="closeConfirmJoinModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Confirm Enrollment</h2>
        <p class="text-gray-700 mb-6">Are you sure you want to join "<span id="confirmClassName" class="font-semibold"></span>"?</p>
        <div class="flex justify-end space-x-3">
            <button id="cancelJoinBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium">Cancel</button>
            <button id="confirmJoinBtn" class="bg-blue-primary hover:bg-blue-dark text-white px-4 py-2 rounded-lg font-medium">Yes, Join Class</button>
        </div>
    </div>
</div>