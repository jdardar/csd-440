<?php
/*
 * Student: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 10.2 Programming Assignment
 * Date: September 28, 2026
 * Purpose: Validate submitted form data, encode it with json_encode(), and display the JSON result.
 */

$errors = [];
$jsonOutput = "";

// Only accept data submitted by the Module 10 form using the POST method.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $errors[] = "No form submission was received. Please complete the video game form first.";
} else {
    $title = trim($_POST["title"] ?? "");
    $platform = trim($_POST["platform"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $developer = trim($_POST["developer"] ?? "");
    $publisher = trim($_POST["publisher"] ?? "");
    $releaseYearInput = trim($_POST["release_year"] ?? "");
    $ratingInput = trim($_POST["rating"] ?? "");
    $completedInput = trim($_POST["completed"] ?? "");
    $hoursPlayedInput = trim($_POST["hours_played"] ?? "");
    $notes = trim($_POST["notes"] ?? "");

    // Validate the five text fields and enforce the same limits used by the HTML form.
    $textFields = [
        "Game title" => [$title, 100],
        "Platform" => [$platform, 50],
        "Genre" => [$genre, 50],
        "Developer" => [$developer, 75],
        "Publisher" => [$publisher, 75]
    ];

    foreach ($textFields as $fieldName => [$fieldValue, $maximumLength]) {
        if ($fieldValue === "") {
            $errors[] = $fieldName . " is required.";
        } elseif (strlen($fieldValue) > $maximumLength) {
            $errors[] = $fieldName . " must contain " . $maximumLength . " characters or fewer.";
        }
    }

    $releaseYear = filter_var(
        $releaseYearInput,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1950, "max_range" => 2035]]
    );
    if ($releaseYear === false) {
        $errors[] = "Release year must be a whole number from 1950 through 2035.";
    }

    $rating = filter_var($ratingInput, FILTER_VALIDATE_FLOAT);
    if ($rating === false || $rating < 0 || $rating > 10) {
        $errors[] = "Rating must be a number from 0.0 through 10.0.";
    }

    if (!in_array($completedInput, ["true", "false"], true)) {
        $errors[] = "A completed status must be selected.";
    }

    $hoursPlayed = filter_var($hoursPlayedInput, FILTER_VALIDATE_FLOAT);
    if ($hoursPlayed === false || $hoursPlayed < 0 || $hoursPlayed > 10000) {
        $errors[] = "Hours played must be a number from 0 through 10000.";
    }

    if (strlen($notes) > 500) {
        $errors[] = "Player notes must contain 500 characters or fewer.";
    }

    if (count($errors) === 0) {
        // Preserve appropriate JSON types: text, integers, decimals, and a Boolean value.
        $gameData = [
            "title" => $title,
            "platform" => $platform,
            "genre" => $genre,
            "developer" => $developer,
            "publisher" => $publisher,
            "releaseYear" => (int) $releaseYear,
            "rating" => round((float) $rating, 1),
            "completed" => $completedInput === "true",
            "hoursPlayed" => round((float) $hoursPlayed, 1),
            "notes" => $notes
        ];

        try {
            // JSON_PRETTY_PRINT creates a readable, indented output for the result page.
            $jsonOutput = json_encode(
                $gameData,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            $errors[] = "The submitted data could not be encoded as JSON: " . $exception->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Game JSON Result</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; font-family: Arial, sans-serif; color: #1f2933; background: #eef3f7; }
        main { width: min(820px, 100%); margin: auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, .10); }
        h1 { margin-top: 0; color: #1f4e78; }
        .success { padding: 13px; color: #176b2c; background: #e9f7ed; border-left: 4px solid #2b8a3e; border-radius: 5px; }
        .error { padding: 16px; color: #9b1c1c; background: #fdecec; border-left: 4px solid #c92a2a; border-radius: 5px; }
        .error h2 { margin-top: 0; font-size: 1.15rem; }
        .error ul { margin-bottom: 0; }
        pre { overflow-x: auto; padding: 20px; color: #f8fafc; background: #172b3a; border-radius: 7px; font: 1rem/1.5 Consolas, "Courier New", monospace; white-space: pre-wrap; word-break: break-word; }
        a { display: inline-block; margin-top: 18px; padding: 11px 17px; color: white; text-decoration: none; background: #1f4e78; border-radius: 5px; font-weight: bold; }
        a:hover, a:focus { background: #163a5b; }
        footer { margin-top: 24px; text-align: center; color: #617080; font-size: .9rem; }
    </style>
</head>
<body>
<main>
    <h1>Video Game JSON Result</h1>

    <?php if (count($errors) > 0): ?>
        <section class="error" aria-labelledby="error-heading">
            <h2 id="error-heading">The JSON output could not be created.</h2>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php else: ?>
        <p class="success">The ten submitted fields were validated and encoded successfully with json_encode().</p>
        <pre><?php echo htmlspecialchars($jsonOutput, ENT_QUOTES, "UTF-8"); ?></pre>
    <?php endif; ?>

    <a href="JordanJSONForm.php">Return to Form</a>
    <footer>Jordan Dardar | CSD440 | Module 10.2</footer>
</main>
</body>
</html>
