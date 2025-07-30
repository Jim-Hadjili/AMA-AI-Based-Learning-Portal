<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <!-- Simplified top accent -->
    <div class="h-1 <?php echo $style['strip']; ?>"></div>
    
    <div class="p-8">
        <div class="flex items-start justify-between gap-6">
            <!-- Left content -->
            <div class="flex items-start gap-5">
                <!-- Modern icon container -->
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl <?php echo $style['icon_bg']; ?> flex items-center justify-center">
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
                    
                    <!-- Simplified metadata -->
                    <div class="flex flex-wrap items-center gap-6 text-sm">
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span class="font-medium"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span>Grade <?php echo htmlspecialchars($classDetails['grade_level']); ?></span>
                        </div>
                        
                        <?php if (!empty($classDetails['strand']) && $classDetails['strand'] !== 'N/A'): ?>
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span><?php echo htmlspecialchars($classDetails['strand']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Modern status badge -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></div>
                    <?php echo ucfirst($classDetails['status']); ?>
                </span>
            </div>
        </div>
    </div>
</div>