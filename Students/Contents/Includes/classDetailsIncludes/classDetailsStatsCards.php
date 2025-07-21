<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Students Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-50 to-blue-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border-2 border-blue-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Students</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['student_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Active enrollment</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Quizzes Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-50 to-emerald-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center border-2 border-emerald-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Total Quizzes</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['total_quiz_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Assessments available</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Materials Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-violet-50 to-violet-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 flex items-center justify-center border-2 border-violet-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Materials</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['material_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-violet-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Learning resources</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-50 to-amber-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center border-2 border-amber-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Announcements</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['announcement_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Class updates</span>
                </div>
            </div>
        </div>
    </div>
</div>