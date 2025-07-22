<?php
include_once 'Connection/conn.php';

include_once './Assets/php/notifications.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMA College - New-Generation Adaptive Education Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Assets/Css/index.css">

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
                            <img src="Assets/Images/Logo.png" alt="AMA College Logo" class="w-full h-full object-contain">
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
                            <img id="brandLogo" src="Assets/Images/Logo.png" alt="AMA College Logo" class="w-full h-full object-contain">
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
                    <?php include_once './Assets/php/signInForm.php'; ?>

                    <!-- Student Sign Up Form -->
                    <?php include_once './Assets/php/studentSignUpForm.php'; ?>

                    <!-- Teacher Sign Up Form -->
                    <?php include_once './Assets/php/teacherSignUpForm.php'; ?>

                </div>
            </div>
        </div>
    </div>
</body>

<script src="./Assets/Js/index.js"></script>

</html>

<script src="Assets/Js/tab.js"></script>