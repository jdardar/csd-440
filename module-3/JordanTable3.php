<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jordan Dardar - Module 3 PHP Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
            text-align: center;
        }

        h1 {
            margin-bottom: 6px;
        }

        p {
            margin-top: 0;
        }

        table {
            margin: 25px auto;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        td {
            border: 1px solid #333333;
            width: 58px;
            height: 38px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
/*
    Name: Jordan Dardar
    Course: CSD440-308A Server-Side Scripting
    Assignment: Module 3.2 Programming Assignment
    Date: August 15, 2026
    File: JordanTable3.php
    Purpose: Creates a 10-by-10 HTML table. Each cell displays the sum of
             two random numbers passed to a function stored in an external file.
*/

require_once "JordanTable3Functions.php";

$rows = 10;
$columns = 10;
?>

<h1>Module 3 PHP Function Table</h1>
<p>Each cell displays the sum of two randomly generated numbers.</p>

<table>
    <?php
    for ($row = 0; $row < $rows; $row++) {
        echo "<tr>";

        for ($column = 0; $column < $columns; $column++) {
            $numberOne = rand(1, 100);
            $numberTwo = rand(1, 100);
            $sum = addRandomNumbers($numberOne, $numberTwo);

            echo "<td>" . $sum . "</td>";
        }

        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
