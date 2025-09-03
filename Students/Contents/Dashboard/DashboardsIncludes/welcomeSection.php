<!-- Welcome Section -->
<div class="pb-6">
    <div class="relative bg-white rounded-3xl p-8 border border-blue-100/50 shadow-lg hover:shadow-xl transition-all duration-500 overflow-hidden">
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-3">
                <h1 class="text-3xl lg:text-4xl font-bold text-black leading-tight">
                    Welcome, <?php echo htmlspecialchars($user_name); ?>!
                    <span class="inline-block animate-bounce">👋</span>
                </h1>
                <p class="text-gray-600 text-lg font-medium">Track your learning progress and assignments here.</p>
            </div>
            <button
                type="button"
                onclick="showJoinClassModal()"
                class="group relative inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden"
                aria-label="Join a Class">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <span class="relative">Join a Class</span>
            </button>
        </div>
    </div>
</div>