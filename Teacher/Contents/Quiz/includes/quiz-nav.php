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
        'literature' => 'Literature',
        'filipino' => 'Filipino',
        'music' => 'Music',
        'computer' => 'Computer',
        'programming' => 'Programming',
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
        'strip' => 'bg-blue-500',
        'icon_bg' => 'bg-blue-100',
        'icon_color' => 'text-blue-600',
        'border' => 'border-blue-200',
        'link_color' => 'text-blue-600 hover:text-blue-800',
        'icon_class' => 'fas fa-book-reader'
    ],
    'Math' => [
        'strip' => 'bg-green-500',
        'icon_bg' => 'bg-green-100',
        'icon_color' => 'text-green-600',
        'border' => 'border-green-200',
        'link_color' => 'text-green-600 hover:text-green-800',
        'icon_class' => 'fas fa-calculator'
    ],
    'Science' => [
        'strip' => 'bg-purple-500',
        'icon_bg' => 'bg-purple-100',
        'icon_color' => 'text-purple-600',
        'border' => 'border-purple-200',
        'link_color' => 'text-purple-600 hover:text-purple-800',
        'icon_class' => 'fas fa-flask'
    ],
    'History' => [
        'strip' => 'bg-yellow-500',
        'icon_bg' => 'bg-yellow-100',
        'icon_color' => 'text-yellow-600',
        'border' => 'border-yellow-200',
        'link_color' => 'text-yellow-600 hover:text-yellow-800',
        'icon_class' => 'fas fa-landmark'
    ],
    'Arts' => [
        'strip' => 'bg-pink-500',
        'icon_bg' => 'bg-pink-100',
        'icon_color' => 'text-pink-600',
        'border' => 'border-pink-200',
        'link_color' => 'text-pink-600 hover:text-pink-800',
        'icon_class' => 'fas fa-paint-brush'
    ],
    'PE' => [
        'strip' => 'bg-red-500',
        'icon_bg' => 'bg-red-100',
        'icon_color' => 'text-red-600',
        'border' => 'border-red-200',
        'link_color' => 'text-red-600 hover:text-red-800',
        'icon_class' => 'fas fa-running'
    ],
    'ICT' => [
        'strip' => 'bg-indigo-500',
        'icon_bg' => 'bg-indigo-100',
        'icon_color' => 'text-indigo-600',
        'border' => 'border-indigo-200',
        'link_color' => 'text-indigo-600 hover:text-indigo-800',
        'icon_class' => 'fas fa-laptop-code'
    ],
    'Home Economics' => [
        'strip' => 'bg-orange-500',
        'icon_bg' => 'bg-orange-100',
        'icon_color' => 'text-orange-600',
        'border' => 'border-orange-200',
        'link_color' => 'text-orange-600 hover:text-orange-800',
        'icon_class' => 'fas fa-utensils'
    ],
    'Filipino' => [
        'strip' => 'bg-rose-500',
        'icon_bg' => 'bg-rose-100',
        'icon_color' => 'text-rose-600',
        'border' => 'border-rose-200',
        'link_color' => 'text-rose-600 hover:text-rose-800',
        'icon_class' => 'fas fa-book'
    ],
    'Literature' => [
        'strip' => 'bg-amber-500',
        'icon_bg' => 'bg-amber-100',
        'icon_color' => 'text-amber-600',
        'border' => 'border-amber-200',
        'link_color' => 'text-amber-600 hover:text-amber-800',
        'icon_class' => 'fas fa-feather'
    ],
    'Music' => [
        'strip' => 'bg-violet-500',
        'icon_bg' => 'bg-violet-100',
        'icon_color' => 'text-violet-600',
        'border' => 'border-violet-200',
        'link_color' => 'text-violet-600 hover:text-violet-800',
        'icon_class' => 'fas fa-music'
    ],
    'Computer' => [
        'strip' => 'bg-cyan-500',
        'icon_bg' => 'bg-cyan-100',
        'icon_color' => 'text-cyan-600',
        'border' => 'border-cyan-200',
        'link_color' => 'text-cyan-600 hover:text-cyan-800',
        'icon_class' => 'fas fa-desktop'
    ],
    'Programming' => [
        'strip' => 'bg-slate-500',
        'icon_bg' => 'bg-slate-100',
        'icon_color' => 'text-slate-600',
        'border' => 'border-slate-200',
        'link_color' => 'text-slate-600 hover:text-slate-800',
        'icon_class' => 'fas fa-code'
    ],
    'Default' => [
        'strip' => 'bg-gray-500',
    'icon_bg' => 'bg-gray-100',
    'icon_color' => 'text-gray-600',
    'border' => 'border-gray-200',
    'link_color' => 'text-gray-600 hover:text-gray-800',
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