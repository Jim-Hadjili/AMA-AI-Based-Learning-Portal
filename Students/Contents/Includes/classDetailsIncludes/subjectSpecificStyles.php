<?php
$subjectStyles = [
    'English' => [
        'strip' => 'from-blue-500 to-blue-700',
        'icon_bg' => 'bg-blue-100',
        'icon_color' => 'text-blue-600',
        'icon_class' => 'fas fa-book-reader'
    ],
    'Math' => [
        'strip' => 'from-green-500 to-green-700',
        'icon_bg' => 'bg-green-100',
        'icon_color' => 'text-green-600',
        'icon_class' => 'fas fa-calculator'
    ],
    'Science' => [
        'strip' => 'from-purple-500 to-purple-700',
        'icon_bg' => 'bg-purple-100',
        'icon_color' => 'text-purple-600',
        'icon_class' => 'fas fa-flask'
    ],
    'History' => [
        'strip' => 'from-yellow-500 to-yellow-700',
        'icon_bg' => 'bg-yellow-100',
        'icon_color' => 'text-yellow-600',
        'icon_class' => 'fas fa-landmark'
    ],
    'Arts' => [
        'strip' => 'from-pink-500 to-pink-700',
        'icon_bg' => 'bg-pink-100',
        'icon_color' => 'text-pink-600',
        'icon_class' => 'fas fa-paint-brush'
    ],
    'PE' => [
        'strip' => 'from-red-500 to-red-700',
        'icon_bg' => 'bg-red-100',
        'icon_color' => 'text-red-600',
        'icon_class' => 'fas fa-running'
    ],
    'ICT' => [
        'strip' => 'from-indigo-500 to-indigo-700',
        'icon_bg' => 'bg-indigo-100',
        'icon_color' => 'text-indigo-600',
        'icon_class' => 'fas fa-laptop-code'
    ],
    'Home Economics' => [
        'strip' => 'from-orange-500 to-orange-700',
        'icon_bg' => 'bg-orange-100',
        'icon_color' => 'text-orange-600',
        'icon_class' => 'fas fa-utensils'
    ],
    'Default' => [
        'strip' => 'from-gray-500 to-gray-700',
        'icon_bg' => 'bg-gray-100',
        'icon_color' => 'text-gray-600',
        'icon_class' => 'fas fa-graduation-cap'
    ]
];

$subject = $classDetails['class_subject'] ?? 'Default';
$style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
