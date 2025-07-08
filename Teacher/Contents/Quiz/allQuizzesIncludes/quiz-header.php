<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Quizzes - <?php echo htmlspecialchars($classInfo['class_name']); ?> - AMA Learning Platform</title>
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
    .quiz-card {
        transition: all 0.2s ease;
    }
    .quiz-card:hover {
        transform: translateY(-2px);
    }
    .quiz-menu {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .pagination-btn {
        transition: all 0.2s ease;
    }
    .pagination-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }
    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>