<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Populate Video Games Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        main { max-width: 800px; margin: auto; padding: 25px; background: white; border-radius: 8px; }
        .success { color: #176b2c; }
        .error { color: #b00020; }
    </style>
</head>
<body>
<main>
    <h1>Populate Video Games Table</h1>

    <?php
    /*
     * Student: Jordan Dardar
     * Course: CSD440 Server-Side Scripting
     * Assignment: Module 8.2 Programming Assignment
     * Date: September 13, 2026
     * Purpose: Insert five video game records into the video_games table.
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

    // Remove earlier rows so repeated testing always produces the same five records.
    if ($connection->query("TRUNCATE TABLE video_games") !== TRUE) {
        die('<p class="error">The table must be created before it can be populated: ' . htmlspecialchars($connection->error) . '</p>');
    }

    // Use a prepared statement to safely insert each record.
    $sql = "INSERT INTO video_games (title, platform, genre, release_year, rating, completed)
            VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($sql);

    if ($statement === false) {
        die('<p class="error">The insert statement could not be prepared: ' . htmlspecialchars($connection->error) . '</p>');
    }

    $games = [
        ["Grand Theft Auto V", "PlayStation 5", "Action", 2022, 9.0, 1],
        ["God of War Ragnarök", "PlayStation 5", "Action Adventure", 2022, 9.4, 1],
        ["Minecraft", "PlayStation 5", "Sandbox", 2024, 8.8, 0],
        ["Call of Duty: Black Ops 6", "PlayStation 5", "Shooter", 2024, 8.2, 0],
        ["The Elder Scrolls V: Skyrim", "PlayStation 5", "Role-Playing", 2021, 9.1, 1]
    ];

    $insertedRows = 0;

    // Bind and execute the statement once for each game in the array.
    foreach ($games as $game) {
        [$title, $platform, $genre, $releaseYear, $rating, $completed] = $game;
        $statement->bind_param("sssidi", $title, $platform, $genre, $releaseYear, $rating, $completed);

        if ($statement->execute()) {
            $insertedRows++;
        }
    }

    if ($insertedRows === count($games)) {
        echo '<p class="success">The video_games table was populated successfully with ' . $insertedRows . ' records.</p>';
    } else {
        echo '<p class="error">Only ' . $insertedRows . ' records were inserted.</p>';
    }

    // Release the prepared statement and database connection.
    $statement->close();
    $connection->close();
    ?>
</main>
</body>
</html>
