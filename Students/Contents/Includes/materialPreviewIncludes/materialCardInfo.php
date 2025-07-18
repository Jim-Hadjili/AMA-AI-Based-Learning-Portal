<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full <?php echo $style['icon_bg']; ?> mr-4">
                <i class="<?php echo $style['icon_class']; ?> <?php echo $style['icon_color']; ?> text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Subject</p>
                <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['class_subject']); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Grade Level</p>
                <p class="text-lg font-bold text-gray-900">Grade <?php echo htmlspecialchars($materialDetails['grade_level']); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 mr-4">
                <i class="fas fa-tag text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Strand</p>
                <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['strand'] ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-user-tie text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Teacher</p>
                <p class="text-lg font-bold text-gray-900"><?php echo htmlspecialchars($materialDetails['teacher_name'] ?? 'Unknown'); ?></p>
            </div>
        </div>
    </div>
</div>