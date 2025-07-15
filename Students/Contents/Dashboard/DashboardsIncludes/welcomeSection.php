<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <p class="text-gray-600">Track your learning progress and assignments here.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="showJoinClassModal()" class="bg-blue-primary hover:bg-blue-dark text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 shadow-md flex items-center">
                <i class="fas fa-search mr-2"></i> Find a Class
            </button>
        </div>
    </div>
</div>