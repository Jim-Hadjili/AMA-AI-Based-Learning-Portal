<!-- Mobile Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeMobileMenu()"></div>

<!-- Mobile Menu Button - Outside Header -->
<div onclick="toggleMobileMenu()" class="lg:hidden p-2 fixed left-4 top-4 z-30 rounded-md bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
    <i class="fas fa-bars text-xl"></i>
</div>

<!-- Top Header - Right Side Only -->
<header class="bg-gray-100 sticky top-0 z-20">
    <div class="flex justify-end max-w-screen-2xl mx-auto">
        <div class="flex items-center px-3 lg:px-4 py-2 ml-auto">
            <!-- User Profile and Notifications -->
            <div class="flex items-center space-x-2 bg-white py-1.5 px-3 rounded-lg shadow-sm">
                <button class="p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg relative transition-colors duration-200">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 h-3.5 w-3.5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                </button>

                <div class="h-5 border-r border-gray-200"></div>

                <div class="flex items-center space-x-2">
                    <div class="w-7 h-7 bg-blue-primary rounded-full flex items-center justify-center">
                        <span class="text-white font-medium text-xs"><?php echo strtoupper(substr($user_name, 0, 1)); ?></span>
                    </div>
                    <div class="hidden md:block">
                        <p class="text-xs font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-xs text-gray-500">Student</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>