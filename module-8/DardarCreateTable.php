<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Video Games Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        main { max-width: 800px; margin: auto; padding: 25px; background: white; border-radius: 8px; }
        .success { color: #176b2c; }
        .error { color: #b00020; }
    </style>
</head>
<body>
<main>
    <h1>Create Video Games Table</h1>

    <?php
    /*
     * Student: Jordan Dardar
     * Course: CSD440 Server-Side Scripting
     * Assignment: Module 8.2 Programming Assignment
     * Date: September 13, 2026
     * Purpose: Connect to baseball_01 and create the video_games table.
     */

    $serverName = "127.0.0.1";
    $port = 3307;
    $userName = "student1";
    $password = "pass";
    $databaseName = "baseball_01";

    // Create a connection to the assigned MySQL database.
    $connection = new mysqli(
    $serverName,
    $userName,
    $password,
    $databaseName,
    $port
);

    // Stop the script and display a useful message if the connection fails.
    if ($connection->connect_error) {
        die('<p class="error">Database connection failed: ' . htmlspecialchars($connection->connect_error) . '</p>');
    }

    // Define a table with seven fields and several different MySQL data types.
    $sql = "CREATE TABLE IF NOT EXISTS video_games (
        game_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        platform VARCHAR(50) NOT NULL,
        genre VARCHAR(50) NOT NULL,
        release_year SMALLINT UNSIGNED NOT NULL,
        rating DECIMAL(3,1) NOT NULL,
        completed BOOLEAN NOT NULL DEFAULT FALSE
    )";

    // Execute the CREATE TABLE statement and report the result.
    if ($connection->query($sql) === TRUE) {
        echo '<p class="success">The video_games table was created successfully.</p>';
    } else {
        echo '<p class="error">The table could not be created: ' . htmlspecialchars($connection->error) . '</p>';
    }

    // Close the database connection after the operation is complete.
    $connection->close();
    ?>
</main>
</body>
</html>
