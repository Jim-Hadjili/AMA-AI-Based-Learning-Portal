<div id="joinClassModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-0 relative">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-2xl">
            <h2 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                <i class="fas fa-user-plus text-blue-500"></i>
                Join a Class
            </h2>
            <button id="closeJoinClassModal" class="text-gray-400 hover:text-blue-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-300 text-2xl">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <!-- Form -->
        <form id="joinClassForm" method="POST" action="../../Functions/searchClassFunction.php" class="px-6 py-6 bg-white">
            <label for="classCode" class="block text-sm font-medium text-gray-700 mb-2">Enter Class Code</label>
            <div class="relative mb-4">
                <input type="text" id="classCode" name="class_code" required
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-base shadow-sm transition-all"
                    placeholder="e.g. AMA12345">
                <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-300 text-lg"></i>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold w-full shadow transition-all">
                Search Class
            </button>
        </form>
        <div id="classPreviewContainer" class="px-6 pb-6">
            <!-- Class card will be displayed here -->
        </div>
    </div>
</div>