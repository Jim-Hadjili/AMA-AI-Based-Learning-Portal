<div class="bg-blue-100 shadow-lg rounded-xl overflow-hidden mb-8 border-2">
    <div class="bg-white border-b border-blue-100">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between px-6 py-5">
            <div class="flex items-center gap-4 mb-4 md:mb-0">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422A2 2 0 0120 12.764V17a2 2 0 01-2 2H6a2 2 0 01-2-2v-4.236a2 2 0 011.84-2.186L12 14z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">All Recent Activity</h1>
                    <p class="text-sm text-gray-600">Comprehensive log of all student and class activities</p>
                </div>
            </div>
            <!-- Total Activities Badge -->
            <div class="bg-white border-2 px-6 py-3 rounded-xl shadow-sm">
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Activities</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo isset($activities) ? count($activities) : 0; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>