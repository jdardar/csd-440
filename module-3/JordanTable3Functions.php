<!--
    Name: Jordan Dardar
    Course: CSD440-308A Server-Side Scripting
    Assignment: Module 3.2 Programming Assignment
    Date: August 15, 2026
    File: JordanTable3Functions.php
    Purpose: Stores the external PHP function used by JordanTable3.php.
-->
<?php
/**
 * Adds two integer values and returns their sum.
 *
 * @param int $numberOne First randomly generated number.
 * @param int $numberTwo Second randomly generated number.
 * @return int Sum of the two numbers.
 */
function addRandomNumbers(int $numberOne, int $numberTwo): int
{
    return $numberOne + $numberTwo;
}
?>
