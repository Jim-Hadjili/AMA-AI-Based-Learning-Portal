<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="h-3 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center">
                <div class="inline-block p-4 rounded-full <?php echo $style['icon_bg']; ?> mr-4">
                    <i class="<?php echo $style['icon_class']; ?> text-2xl <?php echo $style['icon_color']; ?>"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($classDetails['class_name']); ?></h1>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($classDetails['class_description'] ?? 'No description provided.'); ?></p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-key mr-1"></i>Code: <strong><?php echo htmlspecialchars($classDetails['class_code']); ?></strong></span>
                        <span><i class="fas fa-graduation-cap mr-1"></i>Grade <?php echo htmlspecialchars($classDetails['grade_level']); ?></span>
                        <span><i class="fas fa-tag mr-1"></i><?php echo htmlspecialchars($classDetails['strand'] ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>
            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">
                <?php echo ucfirst($classDetails['status']); ?>
            </span>
        </div>
    </div>
</div>