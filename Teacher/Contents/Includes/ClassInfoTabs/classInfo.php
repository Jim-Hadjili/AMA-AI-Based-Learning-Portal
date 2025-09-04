<div id="info-tab" class="tab-content p-6 hidden">
    <!-- Class Info Header -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
        <div class="bg-white border-b border-gray-100 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Class Information</h3>
                        <p class="text-sm text-gray-600">Overview and details about this class</p>
                    </div>
                </div>
                <button id="editClassInfoBtn" type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Class
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 flex flex-col">
            <div class="bg-white border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Basic Information</h4>
                </div>
            </div>
            <div class="p-6 space-y-4 flex-1">
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Class Name</label>
                    <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($classDetails['class_name']); ?></span>
                </div>
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Class Strand</label>
                    <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($classDetails['strand'] ?? 'Not specified'); ?></span>
                </div>
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Grade Level</label>
                    <span class="text-sm font-medium text-gray-900">Grade <?php echo htmlspecialchars($classDetails['grade_level']); ?></span>
                </div>
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Class Code</label>
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-3 flex items-center justify-between">
                        <span class="font-mono font-bold text-lg text-gray-800 tracking-wider"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                        <button class="copy-code-btn p-2 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors duration-200" 
                                data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>"
                                title="Copy class code">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 flex flex-col">
            <div class="bg-white border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Class Description</h4>
                </div>
            </div>
            <div class="p-6 flex-1 flex ">
                <?php if (!empty($classDetails['class_description'])): ?>
                    <div class="prose prose-sm max-w-none w-full">
                        <p class="text-gray-700 leading-relaxed text-justify"><?php echo nl2br(htmlspecialchars($classDetails['class_description'])); ?></p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8 w-full">
                        <div class="p-3 bg-gray-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm text-justify">No description available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

        <!-- Class Statistics Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 lg:col-span-2 mt-8">
            <div class="bg-white border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Class Statistics</h4>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white border-2 border-purple-200 rounded-xl p-6 text-center shadow-sm">
                        <div class="p-3 bg-purple-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-purple-600 mb-2"><?php echo count($students); ?></div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Students</div>
                    </div>
                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center shadow-sm">
                        <div class="p-3 bg-blue-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo count($quizzes); ?></div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Quizzes</div>
                    </div>
                    <div class="bg-white border-2 border-green-200 rounded-xl p-6 text-center shadow-sm">
                        <div class="p-3 bg-green-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-green-600 mb-2"><?php echo count($materials); ?></div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Learning Materials</div>
                    </div>
                    <div class="bg-white border-2 border-yellow-200 rounded-xl p-6 text-center shadow-sm">
                        <div class="p-3 bg-yellow-100 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo count($announcements); ?></div>
                        <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Announcements</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>