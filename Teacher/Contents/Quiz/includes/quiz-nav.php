<?php
// Helper function to get subject from class name
function getSubjectFromClassName($className) {
    $classNameLower = strtolower($className);
    $subjectKeywords = [
        'english' => 'English',
        'math' => 'Math',
        'science' => 'Science',
        'history' => 'History',
        'arts' => 'Arts',
        'pe' => 'PE',
        'ict' => 'ICT',
        'home economics' => 'Home Economics',
    ];
    foreach ($subjectKeywords as $keyword => $subject) {
        if (strpos($classNameLower, $keyword) !== false) {
            return $subject;
        }
    }
    return 'Default';
}
$subject = getSubjectFromClassName($quiz['class_name'] ?? '');
// Subject style array (copy from your subjectSpecificStyles.php)
$subjectStyles = [
    'English' => [
        'icon_bg' => 'bg-blue-100',
        'icon_color' => 'text-blue-600',
        'icon_class' => 'fas fa-book-reader'
    ],
    'Math' => [
        'icon_bg' => 'bg-green-100',
        'icon_color' => 'text-green-600',
        'icon_class' => 'fas fa-calculator'
    ],
    'Science' => [
        'icon_bg' => 'bg-purple-100',
        'icon_color' => 'text-purple-600',
        'icon_class' => 'fas fa-flask'
    ],
    'History' => [
        'icon_bg' => 'bg-yellow-100',
        'icon_color' => 'text-yellow-600',
        'icon_class' => 'fas fa-landmark'
    ],
    'Arts' => [
        'icon_bg' => 'bg-pink-100',
        'icon_color' => 'text-pink-600',
        'icon_class' => 'fas fa-paint-brush'
    ],
    'PE' => [
        'icon_bg' => 'bg-red-100',
        'icon_color' => 'text-red-600',
        'icon_class' => 'fas fa-running'
    ],
    'ICT' => [
        'icon_bg' => 'bg-indigo-100',
        'icon_color' => 'text-indigo-600',
        'icon_class' => 'fas fa-laptop-code'
    ],
    'Home Economics' => [
        'icon_bg' => 'bg-orange-100',
        'icon_color' => 'text-orange-600',
        'icon_class' => 'fas fa-utensils'
    ],
    'Default' => [
        'icon_bg' => 'bg-gray-100',
        'icon_color' => 'text-gray-600',
        'icon_class' => 'fas fa-graduation-cap'
    ]
];
$style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
?>

<!-- Quiz Nav Styled Like Class Details Header -->
<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 my-6 overflow-hidden">
    <!-- Top accent strip (subject color) -->
    <div class="h-1 bg-gradient-to-r <?php echo $style['strip'] ?? 'from-gray-500 to-gray-700'; ?>"></div>
    <div class="p-8">
        <div class="flex items-start justify-between gap-6">
            <!-- Left content -->
            <div class="flex items-start gap-5">
                <!-- Icon container -->
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl <?php echo $style['icon_bg']; ?> flex items-center justify-center">
                    <i class="<?php echo $style['icon_class']; ?> text-xl <?php echo $style['icon_color']; ?>"></i>
                </div>
                <!-- Quiz/Class information -->
                <div class="min-w-0 flex-1">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-2 leading-tight">
                        Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                    </h1>
                    <p class="text-gray-600 text-base mb-2 leading-relaxed">
                        <?php echo htmlspecialchars($quiz['class_name']); ?> • <?php echo htmlspecialchars($quiz['class_code']); ?>
                    </p>
                </div>
            </div>
            <!-- Actions -->
            <div class="flex-shrink-0 flex flex-col items-end gap-2">
                <button id="saveQuizBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>