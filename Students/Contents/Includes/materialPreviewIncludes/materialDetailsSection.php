<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Material Details</h2>
                <p class="text-sm text-gray-600">Complete information about this learning material</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <!-- Main Information Grid -->
        <div class="grid grid-cols-1 gap-6 mb-4"><!-- Changed from grid-cols-1 lg:grid-cols-2 to stack vertically -->
            <!-- Class Information Card -->
            <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 hover:shadow-md transition-all duration-200">
                <div class="absolute top-4 right-4 w-3 h-3 bg-blue-400 rounded-full opacity-60"></div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h4M9 7h6m-6 4h6m-6 4h6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Class Information</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <span class="text-gray-600 font-medium">Class Name</span>
                        <span class="font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg text-sm">
                            <?php echo htmlspecialchars($materialDetails['class_name']); ?>
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-gray-600 font-medium">Class Code</span>
                        <span class="font-mono font-semibold text-blue-700 bg-blue-100 px-3 py-1 rounded-lg text-sm">
                            <?php echo htmlspecialchars($materialDetails['class_code']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- File Information Card -->
            <div class="group relative bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border border-emerald-100 hover:shadow-md transition-all duration-200">
                <div class="absolute top-4 right-4 w-3 h-3 bg-emerald-400 rounded-full opacity-60"></div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">File Information</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <span class="text-gray-600 font-medium">File Type</span>
                        <span class="font-mono font-semibold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-lg text-sm uppercase">
                            <?php echo strtoupper($materialDetails['file_type']); ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <span class="text-gray-600 font-medium">Upload Date</span>
                        <span class="font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg text-sm">
                            <?php echo date('M j, Y', strtotime($materialDetails['upload_date'])); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <?php if (!empty($materialDetails['material_description'])): ?>
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                </div>
                <div class="bg-white rounded-lg p-5 border border-purple-100">
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed text-base m-0">
                            <?php echo nl2br(htmlspecialchars($materialDetails['material_description'])); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Additional Actions -->
        <div class="mt-8 pt-6 border-t border-gray-100">
            <div class="flex flex-wrap gap-3">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <span>Material is ready for viewing</span>
                </div>
            </div>
        </div>
    </div>
</div>