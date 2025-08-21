<div class="w-full">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8 border border-gray-200">
        <!-- Header Section -->
        <div class="bg-white border-b border-gray-100 px-6 py-6 flex items-center gap-4">
            <div class="p-4 bg-blue-100 rounded-xl">
                <i class="fas fa-clipboard-check text-blue-600 text-3xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1 flex items-center">
                    Student Attempt Analysis
                </h1>
                <p class="text-lg font-medium text-gray-700">
                    <?php echo htmlspecialchars($quiz_title); ?>
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Detailed breakdown of student quiz attempt and performance metrics
                </p>
            </div>
            <div class="ml-auto flex items-center space-x-3 no-print">
                <button onclick="window.print()" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-blue-700 px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm border border-blue-200">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>  
            </div>
        </div>
    </div>
</div>