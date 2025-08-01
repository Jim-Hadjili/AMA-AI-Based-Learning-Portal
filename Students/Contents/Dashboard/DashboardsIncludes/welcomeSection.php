<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p class="text-gray-600">Track your learning progress and assignments here.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="showJoinClassModal()" type="button"
                class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <div class="font-semibold">Join a Class</div>
            </button>
        </div>
    </div>
</div>