<head>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Roster - <?php echo htmlspecialchars($classDetails['class_name']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
    <style>
        .modal-backdrop {
            opacity: 0;
            visibility: hidden;
        }

        .modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            transform: scale(0.95);
            opacity: 0;

        }

        .modal-backdrop.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }
    </style>
</head>