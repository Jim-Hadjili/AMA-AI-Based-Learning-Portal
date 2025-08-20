<?php include "subjectSpecificStyles.php"; ?>
<!-- Class Header - Sticky -->

<div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 overflow-hidden">
    <!-- Top accent strip (customize color as needed) -->
    <div class="h-1 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
    
    <div class="p-8">
        <div class="flex items-start justify-between gap-6">
            <!-- Left content -->
            <div class="flex items-start gap-5">
                <!-- Icon container (customize icon/color as needed) -->
                <div class="flex-shrink-0 w-14 h-14 rounded-xl <?php echo $style['icon_bg']; ?> flex items-center justify-center">
                    <i class="<?php echo $style['icon_class']; ?> text-xl <?php echo $style['icon_color']; ?>"></i>
                </div>
                
                <!-- Class information -->
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-3 leading-tight">
                        <?php echo htmlspecialchars($classDetails['class_name']); ?>
                    </h1>
                    
                    <?php if (!empty($classDetails['class_description'])): ?>
                    <p class="text-gray-600 text-base mb-4 leading-relaxed">
                        <?php echo htmlspecialchars($classDetails['class_description']); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Status badge -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></div>
                    <?php echo ucfirst($classDetails['status']); ?>
                </span>
            </div>
        </div>
    </div>
</div>