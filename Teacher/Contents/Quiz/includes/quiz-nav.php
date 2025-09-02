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
<div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8 overflow-hidden">
            <div class="h-2 <?php echo $style['icon_bg']; ?>"></div>
            <div class="px-8 py-6 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-xl <?php echo $style['icon_bg']; ?> flex items-center justify-center border-2 border-gray-200">
                        <i class="<?php echo $style['icon_class']; ?> text-2xl <?php echo $style['icon_color']; ?>"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                        <p class="text-gray-600 text-base"><?php echo htmlspecialchars($quiz['class_name']); ?> • <?php echo htmlspecialchars($quiz['class_code']); ?></p>
                    </div>
                </div>
                <div>
                    <button id="saveQuizBtn" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-purple-600 text-white font-semibold shadow hover:bg-purple-700 transition">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>