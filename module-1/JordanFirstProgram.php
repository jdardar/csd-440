<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jordan's First PHP Program</title>
</head>
<body>

    <h1>CSD 440 - Server-Side Scripting</h1>
    <h2>Jordan Dardar - First PHP Program</h2>

    <?php
        // Display a welcome message using PHP.
        echo "<p>Hello! My first PHP program is working successfully.</p>";
    ?>

    <h3>Program Information</h3>

    <?php
        // Create variables containing information about this assignment.
        $studentName = "Jordan Dardar";
        $course = "CSD 440 Server-Side Scripting";

        // Display the variables on the webpage.
        echo "<p><strong>Student:</strong> $studentName</p>";
        echo "<p><strong>Course:</strong> $course</p>";
    ?>

    <p>This page combines standard HTML with server-side PHP code.</p>

</body>
</html>