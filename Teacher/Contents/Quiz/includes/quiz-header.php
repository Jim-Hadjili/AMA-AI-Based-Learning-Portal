<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?> - AMA Learning Platform</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="../../Assets/Js/tailwindConfig.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .question-editor {
        min-height: 400px;
    }
    
    .question-list-item.active {
        background-color: #f3f4f6;
        border-left: 4px solid #8b5cf6;
    }
    
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        min-width: 300px;
        padding: 16px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateX(400px);
        transition: transform 0.3s ease-in-out;
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification.success { background-color: #10b981; }
    .notification.error { background-color: #ef4444; }
    .notification.warning { background-color: #f59e0b; }
    .notification.info { background-color: #3b82f6; }
</style>