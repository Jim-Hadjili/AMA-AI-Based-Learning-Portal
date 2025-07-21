<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Subject Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br <?php echo $style['icon_bg']; ?> opacity-10 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br <?php echo $style['icon_bg']; ?> flex items-center justify-center border-2 <?php echo str_replace('bg-', 'border-', $style['icon_bg']); ?>-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <i class="<?php echo $style['icon_class']; ?> <?php echo $style['icon_color']; ?> text-xl"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Subject</p>
                <p class="text-lg font-bold text-gray-900 leading-tight"><?php echo htmlspecialchars($materialDetails['class_subject']); ?></p>
            </div>
        </div>
    </div>

    <!-- Grade Level Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-violet-50 to-violet-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 flex items-center justify-center border-2 border-violet-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Grade Level</p>
                <p class="text-lg font-bold text-gray-900 leading-tight">Grade <?php echo htmlspecialchars($materialDetails['grade_level']); ?></p>
            </div>
        </div>
    </div>

    <!-- Strand Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-50 to-amber-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center border-2 border-amber-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Strand</p>
                <p class="text-lg font-bold text-gray-900 leading-tight"><?php echo htmlspecialchars($materialDetails['strand'] ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>

    <!-- Teacher Card -->
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-50 to-emerald-100 opacity-30 rounded-full -mr-10 -mt-10"></div>
        
        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center border-2 border-emerald-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Teacher</p>
                <p class="text-lg font-bold text-gray-900 leading-tight"><?php echo htmlspecialchars($materialDetails['teacher_name'] ?? 'Unknown'); ?></p>
            </div>
        </div>
    </div>
</div>