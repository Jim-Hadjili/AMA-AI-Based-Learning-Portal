<div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-white/50 mb-6">
    <div class="h-2 <?php echo $style['icon_bg']; ?>"></div>
    <div class="bg-white border-b-2 border-gray-200 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-center gap-3">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-xl <?php echo $style['icon_bg']; ?> flex items-center justify-center border-2 border-gray-200">
                        <?php
                        // Choose icon and color based on file type
                        $icon = 'fa-file';
                        $iconColor = 'text-gray-400';
                        if ($extension === 'pdf') {
                            $icon = 'fa-file-pdf';
                            $iconColor = 'text-red-600';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $icon = 'fa-file-image';
                            $iconColor = 'text-yellow-500';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                            $icon = 'fa-file-video';
                            $iconColor = 'text-blue-600';
                        }
                        ?>
                        <i class="fas <?php echo $icon; ?> text-2xl <?php echo $iconColor; ?>"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-600 uppercase tracking-wide ">
                            Material Name
                        </h1>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent capitalize">

                            <?php echo htmlspecialchars($material['material_title']); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-indigo-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-chalkboard text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Class Name</h3>
                <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo htmlspecialchars($material['class_name']); ?></p>
            </div>
        </div>
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-hashtag text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Class Code</h3>
                <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo htmlspecialchars($material['class_code'] ?? ''); ?></p>
            </div>
        </div>
    </div>
</div>