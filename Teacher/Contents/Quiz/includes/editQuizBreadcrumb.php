<nav class="flex mb-4" aria-label="Breadcrumb">
    <div class="bg-white backdrop-blur-sm rounded-2xl border border-gray-100/60 shadow-sm px-4 py-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li>
                <div class="flex items-center space-x-3">
                    <a href="javascript:history.back()" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to 
                        <?php 
                        // Get the referring page
                        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                        
                        // Extract page name from the URL
                        if (strpos($referer, 'preview') !== false) {
                            echo 'Preview Page';
                        } elseif (strpos($referer, 'class') !== false || strpos($referer, 'classroom') !== false) {
                            echo htmlspecialchars($quiz['class_name']) . ' Class';
                        } elseif (strpos($referer, 'questions') !== false) {
                            echo 'Questions Page';
                        } else {
                            echo htmlspecialchars($quiz['class_name']) . ' Class';
                        }
                        ?>
                        </span>
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-black mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="px-3 py-2 text-gray-900 font-bold bg-gray-100 rounded-xl">
                        <?php echo htmlspecialchars($quiz['quiz_title']); ?> Quiz Edit Menu
                    </span>
                </div>
            </li>
        </ol>
    </div>
</nav>