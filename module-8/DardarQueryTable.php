<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Video Games Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        main { max-width: 950px; margin: auto; padding: 25px; background: white; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #999; text-align: left; }
        th { background: #1f4e78; color: white; }
        tr:nth-child(even) { background: #eef4f8; }
        .error { color: #b00020; }
    </style>
</head>
<body>
<main>
    <h1>Video Games Table Results</h1>

    <?php
    /*
     * Student: Jordan Dardar
     * Course: CSD440 Server-Side Scripting
     * Assignment: Module 8.2 Programming Assignment
     * Date: September 13, 2026
     * Purpose: Query and display every record in the video_games table.
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

    // Retrieve every record and sort the results by rating from highest to lowest.
    $sql = "SELECT game_id, title, platform, genre, release_year, rating, completed
            FROM video_games
            ORDER BY rating DESC";
    $result = $connection->query($sql);

    if ($result === false) {
        echo '<p class="error">The table must be created and populated before it can be queried: ' . htmlspecialchars($connection->error) . '</p>';
    } elseif ($result->num_rows > 0) {
        echo '<p>The query returned ' . $result->num_rows . ' records.</p>';
        echo '<table>';
        echo '<thead><tr><th>ID</th><th>Title</th><th>Platform</th><th>Genre</th><th>Release Year</th><th>Rating</th><th>Completed</th></tr></thead>';
        echo '<tbody>';

        // Display one HTML table row for every database record.
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["game_id"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["title"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["platform"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["genre"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["release_year"]) . '</td>';
            echo '<td>' . htmlspecialchars(number_format((float) $row["rating"], 1)) . '</td>';
            echo '<td>' . ($row["completed"] ? 'Yes' : 'No') . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>No records were found in the video_games table.</p>';
    }

    // Release the query result and close the database connection.
    if ($result instanceof mysqli_result) {
        $result->free();
    }
    $connection->close();
    ?>
</main>
</body>
</html>
