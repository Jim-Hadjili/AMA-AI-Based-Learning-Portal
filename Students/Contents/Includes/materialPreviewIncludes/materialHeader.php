<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
    <!-- Simplified top accent -->
    <div class="h-1 <?php echo $style['strip']; ?>"></div>
    
    <div class="p-8">
        <div class="flex items-start justify-between gap-6">
            <!-- Left content -->
            <div class="flex items-start gap-5">
                <!-- Dynamic file type icon container -->
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center
                    <?php 
                    $fileTypeColors = [
                        'pdf' => 'bg-red-50 border-red-100',
                        'doc' => 'bg-blue-50 border-blue-100',
                        'docx' => 'bg-blue-50 border-blue-100',
                        'ppt' => 'bg-orange-50 border-orange-100',
                        'pptx' => 'bg-orange-50 border-orange-100',
                        'xls' => 'bg-green-50 border-green-100',
                        'xlsx' => 'bg-green-50 border-green-100',
                        'jpg' => 'bg-purple-50 border-purple-100',
                        'jpeg' => 'bg-purple-50 border-purple-100',
                        'png' => 'bg-purple-50 border-purple-100',
                        'mp4' => 'bg-pink-50 border-pink-100',
                        'mp3' => 'bg-cyan-50 border-cyan-100',
                    ];
                    $fileType = strtolower($materialDetails['file_type']);
                    echo isset($fileTypeColors[$fileType]) ? $fileTypeColors[$fileType] : 'bg-gray-50 border-gray-100';
                    ?> border">
                    <i class="<?php echo $materialDetails['file_icon']; ?> text-xl 
                        <?php 
                        $iconColors = [
                            'pdf' => 'text-red-600',
                            'doc' => 'text-blue-600',
                            'docx' => 'text-blue-600',
                            'ppt' => 'text-orange-600',
                            'pptx' => 'text-orange-600',
                            'xls' => 'text-green-600',
                            'xlsx' => 'text-green-600',
                            'jpg' => 'text-purple-600',
                            'jpeg' => 'text-purple-600',
                            'png' => 'text-purple-600',
                            'mp4' => 'text-pink-600',
                            'mp3' => 'text-cyan-600',
                        ];
                        echo isset($iconColors[$fileType]) ? $iconColors[$fileType] : 'text-gray-600';
                        ?>"></i>
                </div>
                
                <!-- Material information -->
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-semibold text-gray-900 mb-3 leading-tight">
                        <?php echo htmlspecialchars($materialDetails['material_title']); ?>
                    </h1>
                    
                    <?php if (!empty($materialDetails['material_description'])): ?>
                    <p class="text-gray-600 text-base mb-4 leading-relaxed">
                        <?php echo htmlspecialchars($materialDetails['material_description']); ?>
                    </p>
                    <?php endif; ?>
                    
                    <!-- Simplified metadata -->
                    <div class="flex flex-wrap items-center gap-6 text-sm">
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span class="font-medium"><?php echo htmlspecialchars($materialDetails['file_name']); ?></span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span><?php echo $materialDetails['formatted_file_size']; ?></span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-gray-700">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <span><?php echo date('M j, Y', strtotime($materialDetails['upload_date'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right actions -->
            <div class="flex flex-col items-end gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium 
                    <?php 
                    $badgeColors = [
                        'pdf' => 'bg-red-50 text-red-700 border border-red-200',
                        'doc' => 'bg-blue-50 text-blue-700 border border-blue-200',
                        'docx' => 'bg-blue-50 text-blue-700 border border-blue-200',
                        'ppt' => 'bg-orange-50 text-orange-700 border border-orange-200',
                        'pptx' => 'bg-orange-50 text-orange-700 border border-orange-200',
                        'xls' => 'bg-green-50 text-green-700 border border-green-200',
                        'xlsx' => 'bg-green-50 text-green-700 border border-green-200',
                        'jpg' => 'bg-purple-50 text-purple-700 border border-purple-200',
                        'jpeg' => 'bg-purple-50 text-purple-700 border border-purple-200',
                        'png' => 'bg-purple-50 text-purple-700 border border-purple-200',
                        'mp4' => 'bg-pink-50 text-pink-700 border border-pink-200',
                        'mp3' => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                    ];
                    echo isset($badgeColors[$fileType]) ? $badgeColors[$fileType] : 'bg-gray-50 text-gray-700 border border-gray-200';
                    ?>">
                    <?php echo strtoupper($materialDetails['file_type']); ?>
                </span>
                
                <?php if ($fileExists): ?>
                    <button id="downloadBtn" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all duration-200 font-medium shadow-sm">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>