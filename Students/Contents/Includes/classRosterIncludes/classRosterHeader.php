<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <div class="h-1 bg-blue-500"></div>
    <div class="p-8">
        <div class="flex items-center gap-5">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                    <?php echo htmlspecialchars($classDetails['class_name']); ?> – Student Roster
                </h1>
                <p class="text-gray-600 text-base leading-relaxed">
                    Class Code:
                    <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                </p>
            </div>
        </div>
    </div>
</div>