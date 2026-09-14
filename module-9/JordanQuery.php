<?php
/*
 * Student: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 9.2 Programming Assignment
 * Date: September 14, 2026
 * Purpose: Search the video_games table using text entered by the user.
 */

$serverName = "127.0.0.1";
$port = 3307;
$userName = "student1";
$password = "pass";
$databaseName = "baseball_01";

$searchTerm = trim($_GET["search"] ?? "");
$searchSubmitted = isset($_GET["search"]);
$message = "";
$messageClass = "";
$rows = [];

if ($searchSubmitted) {
    if ($searchTerm === "") {
        $message = "Enter a title, platform, or genre to search.";
        $messageClass = "error";
    } elseif (strlen($searchTerm) > 100) {
        $message = "The search term must contain 100 characters or fewer.";
        $messageClass = "error";
    } else {
        $connection = new mysqli($serverName, $userName, $password, $databaseName, $port);

        if ($connection->connect_error) {
            $message = "Database connection failed: " . $connection->connect_error;
            $messageClass = "error";
        } else {
            // Use a prepared statement so user input is never placed directly into the SQL command.
            $sql = "SELECT game_id, title, platform, genre, release_year, rating, completed
                    FROM video_games
                    WHERE title LIKE ? OR platform LIKE ? OR genre LIKE ?
                    ORDER BY title";
            $statement = $connection->prepare($sql);

            if ($statement === false) {
                $message = "The search could not be prepared: " . $connection->error;
                $messageClass = "error";
            } else {
                $searchPattern = "%" . $searchTerm . "%";
                $statement->bind_param("sss", $searchPattern, $searchPattern, $searchPattern);

                if ($statement->execute()) {
                    $result = $statement->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $rows[] = $row;
                    }
                    $message = count($rows) . " matching record" . (count($rows) === 1 ? " was" : "s were") . " found.";
                    $messageClass = count($rows) > 0 ? "success" : "notice";
                    $result->free();
                } else {
                    $message = "The search could not be completed: " . $statement->error;
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
    <title>Search Video Games</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; font-family: Arial, sans-serif; color: #1f2933; background: #eef3f7; }
        main { width: min(1100px, 100%); margin: auto; padding: 28px; background: white; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, .09); }
        h1 { margin-top: 0; color: #1f4e78; }
        nav { margin-bottom: 22px; }
        nav a { color: #1f4e78; font-weight: bold; text-decoration: none; }
        form { display: flex; gap: 10px; flex-wrap: wrap; margin: 20px 0; }
        label { width: 100%; font-weight: bold; }
        input[type="search"] { flex: 1 1 320px; padding: 11px; border: 1px solid #829ab1; border-radius: 5px; font-size: 1rem; }
        button { padding: 11px 20px; color: white; background: #1f4e78; border: 0; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        button:hover, button:focus { background: #163a5b; }
        .message { padding: 12px; border-radius: 5px; }
        .success { color: #176b2c; background: #e9f7ed; }
        .notice { color: #604800; background: #fff6d8; }
        .error { color: #9b1c1c; background: #fdecec; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #aab7c4; text-align: left; white-space: nowrap; }
        th { color: white; background: #1f4e78; }
        tr:nth-child(even) { background: #eef4f8; }
    </style>
</head>
<body>
<main>
    <nav><a href="JordanIndex.php">&larr; Return to Index</a></nav>
    <h1>Search Video Games</h1>
    <p>Search by any part of a title, platform, or genre.</p>

    <form method="get" action="JordanQuery.php">
        <label for="search">Search term</label>
        <input type="search" id="search" name="search" maxlength="100" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Example: Minecraft, PlayStation 5, or Action" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($message !== ""): ?>
        <p class="message <?php echo htmlspecialchars($messageClass); ?>"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (count($rows) > 0): ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Title</th><th>Platform</th><th>Genre</th><th>Release Year</th><th>Rating</th><th>Completed</th></tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["game_id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["title"]); ?></td>
                        <td><?php echo htmlspecialchars($row["platform"]); ?></td>
                        <td><?php echo htmlspecialchars($row["genre"]); ?></td>
                        <td><?php echo htmlspecialchars($row["release_year"]); ?></td>
                        <td><?php echo htmlspecialchars(number_format((float) $row["rating"], 1)); ?></td>
                        <td><?php echo $row["completed"] ? "Yes" : "No"; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (!$searchSubmitted): ?>
        <p class="message notice">Enter a search term above to view matching records.</p>
    <?php endif; ?>
</main>
</body>
</html>
