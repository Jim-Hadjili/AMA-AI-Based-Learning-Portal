<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Material Details</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Class Information</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Class:</span> <?php echo htmlspecialchars($materialDetails['class_name']); ?></p>
                    <p><span class="font-medium">Class Code:</span> <?php echo htmlspecialchars($materialDetails['class_code']); ?></p>
                    <p><span class="font-medium">Subject:</span> <?php echo htmlspecialchars($materialDetails['class_subject']); ?></p>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">File Information</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">File Type:</span> <?php echo strtoupper($materialDetails['file_type']); ?></p>
                    <p><span class="font-medium">File Size:</span> <?php echo $materialDetails['formatted_file_size']; ?></p>
                    <p><span class="font-medium">Upload Date:</span> <?php echo date('F j, Y \a\t g:i A', strtotime($materialDetails['upload_date'])); ?></p>
                </div>
            </div>
        </div>
        <?php if (!empty($materialDetails['material_description'])): ?>
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($materialDetails['material_description'])); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>