<!-- Add Class Modal -->
<div id="addClassModal" class="fixed inset-0 z-50 hidden overflow-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Modal Backdrop -->
        <div id="addClassModalBackdrop" class="fixed inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 z-10">
            <div class="h-2 bg-gradient-to-r from-purple-400 to-purple-600 rounded-t-2xl"></div>
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-200 px-6 py-5 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
                <h3 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-purple-500"></i>
                    Add New Class
                </h3>
                <button id="closeAddClassModal" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="addClassForm" class="p-6" method="post">
                <div class="space-y-4">
                    <div>
                        <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">Class Name<span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="class_name" 
                            name="class_name" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                            placeholder="e.g. Mathematics 101"
                            required
                        >
                    </div>
                    
                    <div class="flex space-x-3">
                        <div class="flex-1">
                            <label for="class_code" class="block text-sm font-medium text-gray-700 mb-1">Class Code<span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="class_code" 
                                    name="class_code" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                                    placeholder="e.g. MATH101"
                                    maxlength="10"
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="generateCode"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-xs bg-purple-50 hover:bg-purple-100 text-purple-700 py-1 px-2 rounded-md transition-colors duration-200 shadow"
                                >
                                    Generate
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Students will use this code to join your class</p>
                        </div>
                    </div>
                    
                    <div>
                        <label for="class_description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <textarea 
                            id="class_description" 
                            name="class_description" 
                            rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                            placeholder="Briefly describe your class"
                        ></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-1">Grade Level<span class="text-red-500">*</span></label>
                            <select 
                                id="grade_level" 
                                name="grade_level" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                                required
                            >
                                <option value="">Select grade</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="strand" class="block text-sm font-medium text-gray-700 mb-1">Strand (Optional)</label>
                            <select 
                                id="strand" 
                                name="strand" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm"
                            >
                                <option value="">Select strand</option>
                                <option value="STEM">STEM</option>
                                <option value="ABM">ABM</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="GAS">GAS</option>
                                <option value="TVL-ICT">TVL-ICT</option>
                                <option value="TVL-HE">TVL-HE</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button 
                        type="button" 
                        id="cancelAddClass"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg mr-2 hover:bg-gray-100 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        id="submitAddClass" 
                        class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 shadow"
                    >
                        <i class="fas fa-plus mr-1"></i> Add Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>