<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
    <div class="text-center py-16 px-6">
        <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Quizzes Found</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">Try adjusting your search or filter criteria to find quizzes.</p>
        <a href="<?php echo buildUrl(1, '', 'all', 'newest'); ?>"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Clear Filters
        </a>
    </div>
</div>