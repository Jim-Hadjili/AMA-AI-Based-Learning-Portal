<div class="max-w-8xl mx-auto">
    <div class="bg-white rounded-3xl shadow-lg border border-white/50 backdrop-blur-sm overflow-hidden">
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Total Classes Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-blue-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex items-center justify-between w-full mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Total Classes</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-chalkboard-teacher text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-2"><?php echo $totalClasses ?? 0; ?></div>
                        <div class="text-xs text-gray-500 font-medium">All classes you manage</div>
                    </div>
                </div>
                <!-- Active Classes Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex items-center justify-between w-full mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Active</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-play text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent mb-2"><?php echo $activeClasses ?? 0; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Currently running</div>
                    </div>
                </div>
                <!-- Inactive Classes Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-amber-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex items-center justify-between w-full mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Inactive</span>
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-pause text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-800 bg-clip-text text-transparent mb-2"><?php echo $inactiveClasses ?? 0; ?></div>
                        <div class="text-xs text-gray-500 font-medium">Not currently active</div>
                    </div>
                </div>
                <!-- Add New Class Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-indigo-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full">
                        <button
                            id="addClassBtn"
                            type="button"
                            onclick="window.openAddClassModal && window.openAddClassModal()"
                            class="group relative inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden"
                            aria-label="Add New Class">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            <span class="relative">Add New Class</span>
                        </button>
                        <div class="text-xs text-gray-500 font-medium mt-2">Action</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>