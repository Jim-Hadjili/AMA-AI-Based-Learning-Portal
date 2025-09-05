<!-- Updated Quiz View All Component -->
<?php if ($hasMoreQuizzes): ?>
    <div class="text-center">
        <button
            type="button"
            onclick="window.location.href='../Quiz/allQuizzes.php?class_id=<?php echo $class_id; ?>'"
            class="group relative inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden mt-4 md:mt-0"
            aria-label="View All Quizzes">
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            <svg class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="relative">View All <?php echo count($quizzes); ?> Quizzes</span>
            <svg class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </button>
    </div>
<?php endif; ?>