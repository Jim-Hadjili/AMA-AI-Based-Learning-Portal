<?php 
// Add these lines at the top of index.php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

include_once 'connection/conn.php';
session_start();

// Initialize notification variables
$notification = '';
$notificationType = '';

// Handle notification messages
if (isset($_SESSION['success_message'])) {
    $notification = $_SESSION['success_message'];
    $notificationType = 'success';
    unset($_SESSION['success_message']);
} elseif (isset($_SESSION['error_message'])) {
    $notification = $_SESSION['error_message'];
    $notificationType = 'error';
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>AMA College AI Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./Assets/js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Assets/Css/index.css">
    <!-- Add this script to clear history state -->
    <script>
    // Clear any history state when arriving at the login page
    window.addEventListener('DOMContentLoaded', function() {
        // Replace current history state to prevent going back
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, document.title, window.location.href);
        }
    });
    </script>
</head>
<body class="min-h-screen bg-slate-50">
    
    <div class="min-h-screen flex items-center justify-center p-4 lg:p-6">
        <!-- Main Container -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col lg:flex-row slide-up">
            
            <!-- Left Side - Brand Section -->
            <div class="flex-1 bg-ama-navy p-6 lg:p-10 flex flex-col justify-between text-white relative">
                <!-- Header with Logo -->
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 logo-container rounded-xl flex items-center justify-center mr-3 p-2">
                            <img src="./assets/images/logo.png" alt="AMA College Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">AMA College</h1>
                            <p class="text-blue-200 text-xs">Senior High School Portal</p>
                        </div>
                    </div>
                </div>
                
                <!-- Center Content -->
                <div class="flex-1 flex items-center justify-center relative z-10">
                    <div class="text-center max-w-sm">
                        <div class="w-44 h-44 mx-auto mb-6  flex items-center justify-center p-4">
                            <img id="brandLogo" src="logo.png" alt="AMA College Logo" class="w-full h-full object-contain">
                        </div>
                        <h2 id="brandTitle" class="text-2xl lg:text-3xl font-bold mb-4 leading-tight">
                            Welcome to the Future of Learning
                        </h2>
                        <p id="brandMessage" class="text-blue-100 text-sm leading-relaxed">
                            Experience our AI-powered adaptive education platform designed specifically for AMA Senior High School students and educators.
                        </p>
                    </div>
                </div>
                
            </div>
            
            <!-- Right Side - Form Section -->
            <div class="flex-1 p-6 lg:p-8 flex flex-col justify-center bg-white">
                <div class="max-w-md mx-auto w-full">
                    
                    <!-- Form Header -->
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center p-3 shadow-inner">
                            <i class="fas fa-user text-4xl text-ama-blue"></i>
                        </div>
                        <div id="formTitle" class="text-2xl font-bold text-ama-gray mb-2">Sign In</div>
                        <p id="formSubtitle" class="text-gray-600 text-sm">Access your personalized learning dashboard</p>
                    </div>
                    
                    <!-- Notification container below header -->
                    <div id="notification-container"></div>
                    
                    <!-- Sign In Form -->
                    <form id="signinForm" class="space-y-4 fade-in">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        placeholder="Enter your email address"
                                        class="w-full pl-10 pr-3 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-ama-blue focus:bg-white transition-all duration-200 text-sm text-ama-gray input-focus"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        placeholder="Enter your password"
                                        class="w-full pl-10 pr-3 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-ama-blue focus:bg-white transition-all duration-200 text-sm text-ama-gray input-focus"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs">
                            <a href="#" class="text-ama-blue hover:text-ama-navy font-semibold transition-colors">
                                Forgot password?
                            </a>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-ama-blue hover:bg-ama-navy text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        >
                            <span class="signin-btn-text">Sign In to Dashboard</span>
                            <span class="signin-btn-loading hidden"><span class="loading-spinner"></span> Signing In...</span>
                        </button>
                        
                        <!-- Registration Options - Side by Side -->
                        <div class="pt-4 border-t-2 border-gray-100">
                            <p class="text-center text-xs font-semibold text-ama-gray mb-3">
                                New to AMA College?
                            </p>
                            <div class="grid grid-cols-2 gap-2">
                                <button 
                                    type="button"
                                    class="flex flex-col items-center justify-center px-3 py-2.5 bg-white text-emerald-600 border-2 border-emerald-600 rounded-lg hover:bg-emerald-50 transition-all duration-200 font-medium text-xs"
                                    onclick="switchTab('signup_teacher')"
                                >
                                    <i class="fas fa-chalkboard-teacher mb-1 text-emerald-600"></i>
                                    <span>Sign Up as a Teacher</span>
                                </button>
                                <button 
                                    type="button"
                                    class="flex flex-col items-center justify-center px-3 py-2.5 bg-white text-purple-600 border-2 border-purple-600 rounded-lg hover:bg-purple-50 transition-all duration-200 font-medium text-xs"
                                    onclick="switchTab('signup_student')"
                                >
                                    <i class="fas fa-user-graduate mb-1 text-purple-600"></i>
                                    <span>Sign Up as a Student</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Student Sign Up Form -->
                    <form id="signupStudentForm" class="space-y-4 hidden fade-in">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Full Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="text" 
                                        name="fullname" 
                                        placeholder="Enter your complete name"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Student ID</label>
                                <div class="relative">
                                    <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="text" 
                                        name="student_id" 
                                        placeholder="Your student ID"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Grade Level</label>
                                <div class="relative">
                                    <i class="fas fa-layer-group absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <select 
                                        name="grade_level" 
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                                        required
                                    >
                                        <option value="">Select grade</option>
                                        <option value="grade_11">Grade 11</option>
                                        <option value="grade_12">Grade 12</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Strand</label>
                                <div class="relative">
                                    <i class="fas fa-route absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <select 
                                        name="strand" 
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                                        required
                                    >
                                        <option value="">Select strand</option>
                                        <option value="stem">STEM</option>
                                        <option value="abm">ABM</option>
                                        <option value="humss">HUMSS</option>
                                        <option value="gas">GAS</option>
                                        <option value="tvl_ict">TVL-ICT</option>
                                        <option value="tvl_he">TVL-HE</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        placeholder="Your email address"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        placeholder="Create a secure password"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        >
                            <span class="student-btn-text">Create Student Account</span>
                            <span class="student-btn-loading hidden"><span class="loading-spinner"></span> Creating Account...</span>
                        </button>
                        
                        <div class="text-center">
                            <button type="button" class="text-xs text-ama-blue hover:text-ama-navy font-semibold transition-colors" onclick="switchTab('signin')">
                                Already have an account? Sign in here
                            </button>
                        </div>
                    </form>

                    <!-- Teacher Sign Up Form -->
                    <form id="signupTeacherForm" class="space-y-4 hidden fade-in">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Full Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="text" 
                                        name="fullname" 
                                        placeholder="Enter your complete name"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Employee ID</label>
                                <div class="relative">
                                    <i class="fas fa-id-badge absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="text" 
                                        name="employee_id" 
                                        placeholder="Your employee ID"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        placeholder="Your institutional email"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Department</label>
                                <div class="relative">
                                    <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <select 
                                        name="department" 
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                                        required
                                    >
                                        <option value="">Select department</option>
                                        <option value="mathematics">Mathematics</option>
                                        <option value="science">Science</option>
                                        <option value="english">English</option>
                                        <option value="filipino">Filipino</option>
                                        <option value="social_studies">Social Studies</option>
                                        <option value="ict">ICT</option>
                                        <option value="business">Business</option>
                                        <option value="arts">Arts</option>
                                        <option value="pe_health">PE & Health</option>
                                        <option value="guidance">Guidance</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Subject Expertise</label>
                                <div class="relative">
                                    <i class="fas fa-graduation-cap absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="text" 
                                        name="subject_expertise" 
                                        placeholder="e.g., Calculus, Chemistry"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-ama-gray mb-2">Password</label>
                                <div class="relative">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        placeholder="Create a secure password"
                                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        >
                            <span class="teacher-btn-text">Create Teacher Account</span>
                            <span class="teacher-btn-loading hidden"><span class="loading-spinner"></span> Creating Account...</span>
                        </button>
                        
                        <div class="text-center">
                            <button type="button" class="text-xs text-ama-blue hover:text-ama-navy font-semibold transition-colors" onclick="switchTab('signin')">
                                Already have an account? Sign in here
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./Assets/Js/index.js"></script>
</html>