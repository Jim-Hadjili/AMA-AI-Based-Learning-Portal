<div id="joinClassModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
        <button id="closeJoinClassModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Join a Class</h2>
        <form id="joinClassForm" method="POST" action="../../Functions/searchClassFunction.php">
            <label for="classCode" class="block text-sm font-medium text-gray-700 mb-2">Enter Class Code</label>
            <input type="text" id="classCode" name="class_code" required class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg font-medium w-full">Search Class</button>
        </form>
        <div id="classPreviewContainer" class="mt-6">
            <!-- Class card will be displayed here -->
        </div>
    </div>
</div>