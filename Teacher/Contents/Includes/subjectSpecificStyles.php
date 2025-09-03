<?php
// Define status colors for the badges
$statusColors = [
    'active' => 'bg-green-100 text-green-800',
    'inactive' => 'bg-gray-100 text-gray-800',
    'archived' => 'bg-red-100 text-red-800',
    'pending' => 'bg-yellow-100 text-yellow-800',
];

// Define subject-specific styles with solid colors
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
    ]
];

// Default style for subjects not explicitly listed - Consistent for all unrecognized classes
$defaultStyle = [
    'strip' => 'bg-gray-500',
    'icon_bg' => 'bg-gray-100',
    'icon_color' => 'text-gray-600',
    'border' => 'border-gray-200',
    'link_color' => 'text-gray-600 hover:text-gray-800',
    'icon_class' => 'fas fa-graduation-cap'
];

$subject = $classDetails['class_subject'] ?? 'Default';
$style = $subjectStyles[$subject] ?? $defaultStyle;