<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module 4.2 - Palindrome Checker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #e8e8e8;
        }

        .palindrome {
            font-weight: bold;
        }

        .not-palindrome {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Palindrome Checker</h1>
        <h2>CSD440 Module 4.2</h2>

        <!--
            Name: Jordan Dardar
            Course: CSD440-308A Server-Side Scripting
            Assignment: Module 4.2 Programming Assignment
            Date: August 23, 2026
            File: JordanPalindrome.php
            Purpose: Test six strings to determine whether each string is a palindrome.
                     The program displays each string in its original and reversed order.
        -->

        <table>
            <tr>
                <th>Original String</th>
                <th>Reversed String</th>
                <th>Result</th>
            </tr>

            <?php
            /**
             * Tests a string to determine whether it is a palindrome.
             *
             * @param string $text The string being tested.
             * @return void
             */
            function testPalindrome(string $text): void
            {
                // Reverse the original string.
                $reversed = strrev($text);

                // Compare lowercase versions so capitalization does not affect the result.
                $isPalindrome = strtolower($text) === strtolower($reversed);

                // Select the result text and CSS class for the output.
                $result = $isPalindrome ? "Palindrome" : "Not a Palindrome";
                $resultClass = $isPalindrome ? "palindrome" : "not-palindrome";

                // Display the original string, reversed string, and test result.
                echo "<tr>";
                echo "<td>" . htmlspecialchars($text) . "</td>";
                echo "<td>" . htmlspecialchars($reversed) . "</td>";
                echo "<td class=\"" . $resultClass . "\">" . $result . "</td>";
                echo "</tr>";
            }

            // Six test strings: three palindromes and three non-palindromes.
            $examples = [
                "racecar",
                "level",
                "madam",
                "hello",
                "computer",
                "jordan"
            ];

            // Test and display each string by calling the function.
            foreach ($examples as $example) {
                testPalindrome($example);
            }
            ?>
        </table>
    </div>
</body>
</html>
