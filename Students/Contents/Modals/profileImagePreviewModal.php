<div id="profileImageModal-<?php echo $index; ?>" class="fixed inset-0 z-[60] bg-black/80 backdrop-blur-sm items-center justify-center p-6 hidden mt-8">
    <div class="relative max-w-4xl mx-auto">
        <!-- Close button -->
        <button onclick="closeProfileImagePreview('<?php echo $index; ?>')" class="absolute -top-12 right-0 text-white hover:text-gray-300 focus:outline-none">
            <i class="fas fa-times text-2xl"></i>
        </button>
        
        <!-- Image container -->
        <div class="bg-white p-2 rounded-lg shadow-2xl overflow-hidden">
            <img src="/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/<?php echo $student['profile_picture']; ?>" 
                 alt="<?php echo htmlspecialchars($student['student_name']); ?>'s Profile" 
                 class="max-h-[80vh] max-w-full object-contain">
        </div>
        
        <!-- Student name caption -->
        <div class="text-center mt-4">
            <p class="text-white text-lg font-medium">
                <?php echo htmlspecialchars($student['student_name']); ?>
            </p>
        </div>
    </div>
</div>