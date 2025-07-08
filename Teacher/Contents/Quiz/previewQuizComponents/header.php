<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Preview: <?php echo htmlspecialchars($quiz['quiz_title']); ?> - AMA Learning Platform</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="../../Assets/Js/tailwindConfig.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
<style>
    .quiz-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .quiz-card:hover {
        transform: translateY(-2px);
    }
    .option-hover:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .quiz-container {
        max-width: 800px;
    }
    .shadow-soft {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    }
</style>