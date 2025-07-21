<?php
// Define modern subject-specific styles with softer colors
$subjectStyles = [
    'English' => [
        'strip' => 'from-blue-400 to-blue-600',
        'icon_bg' => 'bg-blue-50',
        'icon_color' => 'text-blue-600',
        'icon_class' => 'fas fa-book-reader',
        'border_color' => 'border-blue-100'
    ],
    'Math' => [
        'strip' => 'from-emerald-400 to-emerald-600',
        'icon_bg' => 'bg-emerald-50',
        'icon_color' => 'text-emerald-600',
        'icon_class' => 'fas fa-calculator',
        'border_color' => 'border-emerald-100'
    ],
    'Science' => [
        'strip' => 'from-violet-400 to-violet-600',
        'icon_bg' => 'bg-violet-50',
        'icon_color' => 'text-violet-600',
        'icon_class' => 'fas fa-flask',
        'border_color' => 'border-violet-100'
    ],
    'History' => [
        'strip' => 'from-amber-400 to-amber-600',
        'icon_bg' => 'bg-amber-50',
        'icon_color' => 'text-amber-600',
        'icon_class' => 'fas fa-landmark',
        'border_color' => 'border-amber-100'
    ],
    'Arts' => [
        'strip' => 'from-pink-400 to-pink-600',
        'icon_bg' => 'bg-pink-50',
        'icon_color' => 'text-pink-600',
        'icon_class' => 'fas fa-paint-brush',
        'border_color' => 'border-pink-100'
    ],
    'PE' => [
        'strip' => 'from-red-400 to-red-600',
        'icon_bg' => 'bg-red-50',
        'icon_color' => 'text-red-600',
        'icon_class' => 'fas fa-running',
        'border_color' => 'border-red-100'
    ],
    'Physical Education' => [
        'strip' => 'from-red-400 to-red-600',
        'icon_bg' => 'bg-red-50',
        'icon_color' => 'text-red-600',
        'icon_class' => 'fas fa-running',
        'border_color' => 'border-red-100'
    ],
    'ICT' => [
        'strip' => 'from-indigo-400 to-indigo-600',
        'icon_bg' => 'bg-indigo-50',
        'icon_color' => 'text-indigo-600',
        'icon_class' => 'fas fa-laptop-code',
        'border_color' => 'border-indigo-100'
    ],
    'Computer Science' => [
        'strip' => 'from-indigo-400 to-indigo-600',
        'icon_bg' => 'bg-indigo-50',
        'icon_color' => 'text-indigo-600',
        'icon_class' => 'fas fa-laptop-code',
        'border_color' => 'border-indigo-100'
    ],
    'Home Economics' => [
        'strip' => 'from-orange-400 to-orange-600',
        'icon_bg' => 'bg-orange-50',
        'icon_color' => 'text-orange-600',
        'icon_class' => 'fas fa-utensils',
        'border_color' => 'border-orange-100'
    ],
    'Geography' => [
        'strip' => 'from-teal-400 to-teal-600',
        'icon_bg' => 'bg-teal-50',
        'icon_color' => 'text-teal-600',
        'icon_class' => 'fas fa-globe-americas',
        'border_color' => 'border-teal-100'
    ],
    'Chemistry' => [
        'strip' => 'from-purple-400 to-purple-600',
        'icon_bg' => 'bg-purple-50',
        'icon_color' => 'text-purple-600',
        'icon_class' => 'fas fa-atom',
        'border_color' => 'border-purple-100'
    ],
    'Physics' => [
        'strip' => 'from-cyan-400 to-cyan-600',
        'icon_bg' => 'bg-cyan-50',
        'icon_color' => 'text-cyan-600',
        'icon_class' => 'fas fa-magnet',
        'border_color' => 'border-cyan-100'
    ],
    'Biology' => [
        'strip' => 'from-green-400 to-green-600',
        'icon_bg' => 'bg-green-50',
        'icon_color' => 'text-green-600',
        'icon_class' => 'fas fa-dna',
        'border_color' => 'border-green-100'
    ],
    'Music' => [
        'strip' => 'from-rose-400 to-rose-600',
        'icon_bg' => 'bg-rose-50',
        'icon_color' => 'text-rose-600',
        'icon_class' => 'fas fa-music',
        'border_color' => 'border-rose-100'
    ],
    'Literature' => [
        'strip' => 'from-slate-400 to-slate-600',
        'icon_bg' => 'bg-slate-50',
        'icon_color' => 'text-slate-600',
        'icon_class' => 'fas fa-feather-alt',
        'border_color' => 'border-slate-100'
    ],
    'Default' => [
        'strip' => 'from-gray-400 to-gray-600',
        'icon_bg' => 'bg-gray-50',
        'icon_color' => 'text-gray-600',
        'icon_class' => 'fas fa-graduation-cap',
        'border_color' => 'border-gray-100'
    ]
];

// Get the subject and apply appropriate styling
$subject = $materialDetails['class_subject'] ?? 'Default';
$style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
?>