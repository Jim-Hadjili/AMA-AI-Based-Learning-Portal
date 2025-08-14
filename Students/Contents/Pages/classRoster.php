<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include "../../Functions/classRosterFunction.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../Includes/classRosterIncludes/classRosterHead.php"; ?>

<body class="bg-gray-100 min-h-screen m-3 lg:-mt-2">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">
        <main class="lg:p-6">

            <?php include "../Includes/classRosterIncludes/classRosterBreadcrumb.php" ?>

            <div class="max-w-9xl mx-auto space-y-6">

                <!-- Class Header -->
                <?php include "../Includes/classRosterIncludes/classRosterHeader.php"; ?>

                <!-- Students List -->
                <?php include "../Includes/classRosterIncludes/classRosterStudentsList.php" ?>

            </div>

        </main>
    </div>

    <!-- Student Detail Modals -->
    <?php foreach ($classmates as $index => $student): ?>
        <?php include "../Modals/studentInfoCardModal.php"; ?>
    <?php endforeach; ?>

    <script src="../Includes/classRosterIncludes/classRosterScript.js"></script>

</body>

</html>