<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jordan Dardar - Module 2 PHP Table</title>
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
    Assignment: Module 2.2 Programming Assignment
    Date: August 17, 2026
    File: JordanTable2.php
    Purpose: Creates a 10-by-10 HTML table using nested PHP loops.
             Each cell displays a PHP-generated random number.
             The actual HTML table tags are written as HTML, not printed by PHP.
*/

$rows = 10;
$columns = 10;
?>

<h1>Module 2 PHP Random Number Table</h1>
<p>Each cell displays a PHP-generated random number.</p>

<table>
    <?php for ($row = 0; $row < $rows; $row++) { ?>
        <tr>
            <?php for ($column = 0; $column < $columns; $column++) { ?>
                <?php
                // Generate one random number for the current table cell.
                $randomNumber = rand(1, 100);
                ?>
                <td><?php echo $randomNumber; ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

</body>
</html>