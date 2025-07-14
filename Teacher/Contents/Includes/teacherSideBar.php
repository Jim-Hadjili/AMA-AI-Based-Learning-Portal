<div id="sidebar" class="fixed left-0 top-0 h-full rounded-tr-[2rem] rounded-br-[2rem] sidebar-base lg:sidebar-base bg-gradient-to-b from-purple-primary to-purple-dark text-white z-50 -translate-x-full lg:translate-x-0 sidebar-mobile">
    <!-- Logo Section -->
    <div class="flex items-center justify-center lg:justify-start h-16 px-4 border-b border-purple-400/20">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-purple-primary font-bold text-lg">A</span>
            </div>
            <span class="font-bold text-lg sidebar-text">AMA Learning</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-8 px-2">
        <ul class="space-y-2">
            <li>
                <a href="../Dashboard/teachersDashboard.php" class="flex items-center px-3 py-3 rounded-lg bg-white/10 text-white hover:bg-white/20 transition-colors duration-200">
                    <i class="fas fa-home w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li>
                <!-- Modified: Added id="searchSidebarBtn" -->
                <a href="#" id="searchSidebarBtn" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-search w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Search</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-users w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Students</span>
                </a>
            </li>
            <li>
                <a href="../Tabs/teacherAllClasses.php" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-book w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Classes</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-envelope w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Messages</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-chart-bar w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">Statistics</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                    <i class="fas fa-newspaper w-5 h-5 text-center flex-shrink-0"></i>
                    <span class="ml-4 sidebar-text">News</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bottom Section -->
    <div class="absolute bottom-4 left-0 right-0 px-2">
        <!-- Modified: href changed to "#", onclick removed. Event listener will be added in JS. -->
        <a href="#" id="logoutSidebarBtn" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
            <i class="fas fa-sign-out-alt w-5 h-5 text-center flex-shrink-0"></i>
            <span class="ml-4 sidebar-text">Logout</span>
        </a>
    </div>
</div>
