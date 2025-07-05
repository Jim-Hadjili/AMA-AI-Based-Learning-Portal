<!-- Edit Class Modal -->
<div id="editClassModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity modal-overlay" data-modal-id="editClassModal" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editClassForm">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Edit Class
                            </h3>
                            
                            <!-- Form inputs - NOTE: Fixed the div closure -->
                            <div class="space-y-4">
                                <input type="hidden" id="edit_class_id" name="class_id" value="<?php echo $classDetails['class_id']; ?>">
                                
                                <div>
                                    <label for="edit_class_name" class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                                    <input type="text" name="class_name" id="edit_class_name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" value="<?php echo htmlspecialchars($classDetails['class_name']); ?>" required>
                                </div>
                                
                                <div>
                                    <label for="edit_class_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="class_description" id="edit_class_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"><?php echo htmlspecialchars($classDetails['class_description'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="edit_grade_level" class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                                        <select name="grade_level" id="edit_grade_level" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                            <?php for ($i = 7; $i <= 12; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php echo (isset($classDetails['grade_level']) && $classDetails['grade_level'] == $i) ? 'selected' : ''; ?>>Grade <?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="edit_strand" class="block text-sm font-medium text-gray-700 mb-1">Strand (Optional)</label>
                                        <select name="strand" id="edit_strand" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                            <option value="" <?php echo empty($classDetails['strand']) ? 'selected' : ''; ?>>None</option>
                                            <option value="STEM" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'STEM') ? 'selected' : ''; ?>>STEM</option>
                                            <option value="HUMSS" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'HUMSS') ? 'selected' : ''; ?>>HUMSS</option>
                                            <option value="ABM" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'ABM') ? 'selected' : ''; ?>>ABM</option>
                                            <option value="GAS" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'GAS') ? 'selected' : ''; ?>>GAS</option>
                                            <option value="TVL-ICT" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'TVL-ICT') ? 'selected' : ''; ?>>TVL-ICT</option>
                                            <option value="TVL-HE" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'TVL-HE') ? 'selected' : ''; ?>>TVL-HE</option>
                                            <option value="SPORTS" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'SPORTS') ? 'selected' : ''; ?>>SPORTS</option>
                                            <option value="ARTS-DESIGN" <?php echo (isset($classDetails['strand']) && $classDetails['strand'] == 'ARTS-DESIGN') ? 'selected' : ''; ?>>ARTS & DESIGN</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="edit_status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                        <option value="active" <?php echo ($classDetails['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($classDetails['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="archived" <?php echo ($classDetails['status'] === 'archived') ? 'selected' : ''; ?>>Archived</option>
                                    </select>
                                </div>
                            </div><!-- Space-y-4 div properly closed here -->
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-primary text-base font-medium text-white hover:bg-purple-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" class="modal-close mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" data-modal-id="editClassModal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    const editClassForm = document.getElementById('editClassForm');
    if (editClassForm) {
        editClassForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
            
            // Get form data
            const formData = new FormData(this);
            
            // Debug: Log form data being sent
            console.log("Submitting form with data:");
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            // Send AJAX request to update class
            fetch('../../Controllers/classActionController.php?action=updateClass', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Response status:", response.status);
                return response.text().then(text => {
                    try {
                        // Try to parse as JSON
                        return JSON.parse(text);
                    } catch (e) {
                        // If not valid JSON, show the raw response
                        console.error("Invalid JSON response:", text);
                        throw new Error("Server returned invalid JSON: " + text);
                    }
                });
            })
            .then(data => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                console.log("Server response:", data);
                
                if (data.success) {
                    // Show success notification
                    window.showNotification('Class updated successfully!', 'success');
                    
                    // Close modal
                    document.getElementById('editClassModal').classList.add('hidden');
                    
                    // Reload page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error notification with specific message
                    window.showNotification(data.message || 'Failed to update class', 'error');
                }
            })
            .catch(error => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                console.error('Error:', error);
                
                // Show detailed error notification
                window.showNotification('Error: ' + error.message, 'error');
            });
        });
    } else {
        console.error("Edit class form not found!");
    }
});
</script>