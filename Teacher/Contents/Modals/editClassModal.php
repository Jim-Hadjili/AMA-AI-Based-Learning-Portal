<!-- Edit Class Modal -->
<div id="editClassModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-100 to-purple-200 rounded-t-2xl">
            <h3 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-edit text-purple-600"></i>
                </span>
                Edit Class
            </h3>
            <button type="button" onclick="document.getElementById('editClassModal').classList.add('hidden')" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editClassForm" class="px-6 py-6 bg-white rounded-b-2xl">
            <input type="hidden" id="edit_class_id" name="class_id" value="<?php echo $classDetails['class_id']; ?>">
            <div class="space-y-4">
                <div>
                    <label for="edit_class_name" class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                    <input type="text" name="class_name" id="edit_class_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="<?php echo htmlspecialchars($classDetails['class_name']); ?>" required>
                </div>
                <div>
                    <label for="edit_class_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="class_description" id="edit_class_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"><?php echo htmlspecialchars($classDetails['class_description'] ?? ''); ?></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_grade_level" class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                        <select name="grade_level" id="edit_grade_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <?php for ($i = 11; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($classDetails['grade_level']) && $classDetails['grade_level'] == $i) ? 'selected' : ''; ?>>Grade <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label for="edit_strand" class="block text-sm font-medium text-gray-700 mb-1">Strand (Optional)</label>
                        <select name="strand" id="edit_strand" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
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
                    <select name="status" id="edit_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="active" <?php echo ($classDetails['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($classDetails['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('editClassModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-save mr-1.5"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editClassForm = document.getElementById('editClassForm');
    if (editClassForm) {
        editClassForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
            const formData = new FormData(this);
            fetch('../../Controllers/classActionController.php?action=updateClass', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error("Server returned invalid JSON: " + text);
                }
            }))
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                if (data.success) {
                    window.showNotification('Class updated successfully!', 'success');
                    document.getElementById('editClassModal').classList.add('hidden');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    window.showNotification(data.message || 'Failed to update class', 'error');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                window.showNotification('Error: ' + error.message, 'error');
            });
        });
    } else {
        console.error("Edit class form not found!");
    }
});
</script>