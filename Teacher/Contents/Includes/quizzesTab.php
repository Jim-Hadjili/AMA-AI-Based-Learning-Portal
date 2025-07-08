<?php
// Include helper functions and data fetching
require_once __DIR__ . '/../../Functions/quizHelpers.php';
require_once __DIR__ . '/../../Functions/fetchQuizzes.php';

// Fetch quizzes for the current class
$quizzes = fetchQuizzes($conn, $class_id, $_SESSION['user_id']);

// Limit to 6 quizzes for initial display
$displayQuizzes = array_slice($quizzes, 0, 6);
$hasMoreQuizzes = count($quizzes) > 6;
?>

<!-- Include CSS -->
<link rel="stylesheet" href="../../Assets/Css/quizTab.css">
<link rel="stylesheet" href="../../Assets/Css/notifications.css">

<!-- Quizzes Tab -->
<div id="quizzes-tab" class="tab-content p-6">
    <?php if (empty($quizzes)): ?>
        <!-- Empty State -->
        <?php include __DIR__ . '/../Quiz/components/quiz-empty-state.php'; ?>
    <?php else: ?>
        <!-- Header with Stats and Actions -->
        <?php include __DIR__ . '/../Quiz/components/quiz-tab-header.php'; ?>

        <!-- Quiz Cards Grid (Limited to 6) -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
            <?php foreach ($displayQuizzes as $quiz): ?>
                <?php include __DIR__ . '/../Quiz/components/quiz-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- View All Button -->
        <?php include __DIR__ . '/../Quiz/components/quiz-view-all.php'; ?>
    <?php endif; ?>
</div>

<!-- Quiz Modals -->
<?php include __DIR__ . '/../Quiz/components/delete-quiz-modal.php'; ?>
<?php include __DIR__ . '/../Quiz/components/publish-quiz-modal.php'; ?>
<?php include __DIR__ . '/../Quiz/components/unpublish-quiz-modal.php'; ?>
<?php include __DIR__ . '/../Quiz/components/no-questions-warning-modal.php'; ?>

<!-- Include JavaScript -->
<script src="../../Assets/Js/notificationUtils.js"></script>
<script src="../../Assets/Js/quizTabActions.js"></script>