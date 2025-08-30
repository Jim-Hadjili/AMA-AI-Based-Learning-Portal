<div class="bg-blue-100 shadow-lg rounded-xl overflow-hidden mb-8 border-2">
            <div class="bg-white border-b border-blue-100">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between px-6 py-5">
                    <div class="flex items-center gap-4 mb-4 md:mb-0">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">All Student Engagement</h1>
                            <p class="text-sm text-gray-600">Overview of student participation and activity across all classes</p>
                        </div>
                    </div>
                    <!-- Total Students Badge -->
                    <div class="bg-white border-2 px-6 py-3 rounded-xl shadow-sm">
                        <div class="text-center">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Students</p>
                            <p class="text-2xl font-bold text-blue-600"><?php echo isset($uniqueStudents) ? count($uniqueStudents) : 0; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>