<?php
// Helper function to get subject from class name
function getSubjectFromClassName($className)
{
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

<div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-white/50 mb-6">
    <div class="h-2 <?php echo $style['icon_bg']; ?>"></div>
    <div class="bg-white border-b-2 border-gray-200 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-center gap-3">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-xl <?php echo $style['icon_bg']; ?> flex items-center justify-center border-2 border-gray-200">
                        <i class="<?php echo $style['icon_class']; ?> text-2xl <?php echo $style['icon_color']; ?>"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-600 uppercase tracking-wide ">Quiz Name</h1>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <button
                    id="saveQuizBtn"
                    type="button"
                    class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden mt-4 md:mt-0"
                    aria-label="Save Changes">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <i class="fas fa-save h-5 w-5 mr-2 pt-[2px] group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="relative">Save Changes</span>
                </button>
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
                <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo htmlspecialchars($quiz['class_name']); ?></p>
            </div>
        </div>
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-hashtag text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Class Code</h3>
                <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo htmlspecialchars($quiz['class_code']); ?></p>
            </div>
        </div>
    </div>
</div>