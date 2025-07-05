<!-- Add Class Modal -->
<div id="addClassModal" class="fixed inset-0 z-50 hidden overflow-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Modal Backdrop -->
        <div id="addClassModalBackdrop" class="fixed inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full mx-4 z-10">
            <div class="h-2 bg-purple-primary rounded-t-xl"></div>
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900">Add New Class</h3>
                <button id="closeAddClassModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <form id="addClassForm" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                        <input 
                            type="text" 
                            id="class_name" 
                            name="class_name" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="e.g. Mathematics 101"
                            required
                        >
                    </div>
                    
                    <div class="flex space-x-3">
                        <div class="flex-1">
                            <label for="class_code" class="block text-sm font-medium text-gray-700 mb-1">Class Code</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="class_code" 
                                    name="class_code" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    placeholder="e.g. MATH101"
                                    maxlength="10"
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="generateCode"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 py-1 px-2 rounded-md transition-colors duration-200"
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Briefly describe your class"
                        ></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                            <select 
                                id="grade_level" 
                                name="grade_level" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
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
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg mr-2 hover:bg-gray-50 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        id="submitAddClass" 
                        class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200"
                    >
                        Add Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>