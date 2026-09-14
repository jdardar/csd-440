<?php
/*
 * Student: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 9.2 Programming Assignment
 * Date: September 14, 2026
 * Purpose: Validate user input and add a video game record to the database.
 */

$serverName = "127.0.0.1";
$port = 3307;
$userName = "student1";
$password = "pass";
$databaseName = "baseball_01";

$title = "";
$platform = "";
$genre = "";
$releaseYear = "";
$rating = "";
$completed = 0;
$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $platform = trim($_POST["platform"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $releaseYear = trim($_POST["release_year"] ?? "");
    $rating = trim($_POST["rating"] ?? "");
    $completed = isset($_POST["completed"]) ? 1 : 0;

    $currentYear = (int) date("Y") + 5;
    $errors = [];

    // Validate every field on the server before attempting the database insert.
    if ($title === "" || strlen($title) > 100) {
        $errors[] = "Title is required and must contain 100 characters or fewer.";
    }
    if ($platform === "" || strlen($platform) > 50) {
        $errors[] = "Platform is required and must contain 50 characters or fewer.";
    }
    if ($genre === "" || strlen($genre) > 50) {
        $errors[] = "Genre is required and must contain 50 characters or fewer.";
    }
    if (filter_var($releaseYear, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1950, "max_range" => $currentYear]]) === false) {
        $errors[] = "Release year must be a whole number from 1950 through " . $currentYear . ".";
    }
    if (!is_numeric($rating) || (float) $rating < 0 || (float) $rating > 10) {
        $errors[] = "Rating must be a number from 0.0 through 10.0.";
    }

    if (count($errors) > 0) {
        $message = implode(" ", $errors);
        $messageClass = "error";
    } else {
        $connection = new mysqli($serverName, $userName, $password, $databaseName, $port);

        if ($connection->connect_error) {
            $message = "Database connection failed: " . $connection->connect_error;
            $messageClass = "error";
        } else {
            // Use a prepared statement to safely store all values supplied through the form.
            $sql = "INSERT INTO video_games (title, platform, genre, release_year, rating, completed)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $connection->prepare($sql);

            if ($statement === false) {
                $message = "The insert statement could not be prepared: " . $connection->error;
                $messageClass = "error";
            } else {
                $releaseYearNumber = (int) $releaseYear;
                $ratingNumber = (float) $rating;
                $statement->bind_param("sssidi", $title, $platform, $genre, $releaseYearNumber, $ratingNumber, $completed);

                if ($statement->execute()) {
                    $newId = $statement->insert_id;
                    $message = "The record was added successfully with ID " . $newId . ".";
                    $messageClass = "success";
                    $title = $platform = $genre = $releaseYear = $rating = "";
                    $completed = 0;
                } else {
                    $message = "The record could not be added: " . $statement->error;
                    $messageClass = "error";
                }

                $statement->close();
            }

            $connection->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Video Game</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; font-family: Arial, sans-serif; color: #1f2933; background: #eef3f7; }
        main { width: min(760px, 100%); margin: auto; padding: 28px; background: white; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, .09); }
        h1 { margin-top: 0; color: #1f4e78; }
        nav { margin-bottom: 22px; }
        nav a { color: #1f4e78; font-weight: bold; text-decoration: none; }
        form { display: grid; gap: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 11px; border: 1px solid #829ab1; border-radius: 5px; font-size: 1rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .checkbox { display: flex; align-items: center; gap: 9px; }
        .checkbox label { margin: 0; }
        button { padding: 12px 20px; color: white; background: #1f4e78; border: 0; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        button:hover, button:focus { background: #163a5b; }
        .message { padding: 12px; border-radius: 5px; }
        .success { color: #176b2c; background: #e9f7ed; }
        .error { color: #9b1c1c; background: #fdecec; }
        @media (max-width: 580px) { .row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<main>
    <nav><a href="JordanIndex.php">&larr; Return to Index</a></nav>
    <h1>Add a Video Game</h1>
    <p>Complete the form to add one record to the video_games table.</p>

    <?php if ($message !== ""): ?>
        <p class="message <?php echo htmlspecialchars($messageClass); ?>"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post" action="JordanForms.php">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" maxlength="100" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="row">
            <div>
                <label for="platform">Platform</label>
                <input type="text" id="platform" name="platform" maxlength="50" value="<?php echo htmlspecialchars($platform); ?>" required>
            </div>
            <div>
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" maxlength="50" value="<?php echo htmlspecialchars($genre); ?>" required>
            </div>
        </div>
        <div class="row">
            <div>
                <label for="release_year">Release Year</label>
                <input type="number" id="release_year" name="release_year" min="1950" max="<?php echo (int) date('Y') + 5; ?>" value="<?php echo htmlspecialchars($releaseYear); ?>" required>
            </div>
            <div>
                <label for="rating">Rating (0.0-10.0)</label>
                <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($rating); ?>" required>
            </div>
        </div>
        <div class="checkbox">
            <input type="checkbox" id="completed" name="completed" value="1" <?php echo $completed ? "checked" : ""; ?>>
            <label for="completed">I have completed this game</label>
        </div>
        <button type="submit">Add Video Game</button>
    </form>
</main>
</body>
</html>
