<?php
/*
 * Student: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 10.2 Programming Assignment
 * Date: September 28, 2026
 * Purpose: Display a form that collects ten fields of video game data for JSON encoding.
 */
$pageTitle = "Video Game JSON Form";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 32px 16px; font-family: Arial, sans-serif; color: #1f2933; background: #eef3f7; }
        main { width: min(820px, 100%); margin: auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, .10); }
        h1 { margin-top: 0; color: #1f4e78; }
        .intro { margin-bottom: 24px; color: #52606d; }
        form { display: grid; gap: 18px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 11px; border: 1px solid #829ab1; border-radius: 5px; font: inherit; background: white; }
        textarea { min-height: 100px; resize: vertical; }
        button { padding: 13px 20px; color: white; background: #1f4e78; border: 0; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        button:hover, button:focus { background: #163a5b; }
        .required { color: #a61b1b; }
        footer { margin-top: 24px; text-align: center; color: #617080; font-size: .9rem; }
        @media (max-width: 620px) { .row { grid-template-columns: 1fr; } main { padding: 22px; } }
    </style>
</head>
<body>
<main>
    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    <p class="intro">Enter the information below. The submitted values will be validated and converted into formatted JSON.</p>

    <form method="post" action="JordanJSON.php">
        <div>
            <label for="title">Game Title <span class="required">*</span></label>
            <input type="text" id="title" name="title" maxlength="100" required>
        </div>

        <div class="row">
            <div>
                <label for="platform">Platform <span class="required">*</span></label>
                <select id="platform" name="platform" required>
                    <option value="">Select a platform</option>
                    <option value="PlayStation 5">PlayStation 5</option>
                    <option value="Xbox Series X|S">Xbox Series X|S</option>
                    <option value="Nintendo Switch">Nintendo Switch</option>
                    <option value="PC">PC</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label for="genre">Genre <span class="required">*</span></label>
                <input type="text" id="genre" name="genre" maxlength="50" required>
            </div>
        </div>

        <div class="row">
            <div>
                <label for="developer">Developer <span class="required">*</span></label>
                <input type="text" id="developer" name="developer" maxlength="75" required>
            </div>
            <div>
                <label for="publisher">Publisher <span class="required">*</span></label>
                <input type="text" id="publisher" name="publisher" maxlength="75" required>
            </div>
        </div>

        <div class="row">
            <div>
                <label for="release_year">Release Year <span class="required">*</span></label>
                <input type="number" id="release_year" name="release_year" min="1950" max="2035" required>
            </div>
            <div>
                <label for="rating">Rating (0.0-10.0) <span class="required">*</span></label>
                <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" required>
            </div>
        </div>

        <div class="row">
            <div>
                <label for="completed">Completed? <span class="required">*</span></label>
                <select id="completed" name="completed" required>
                    <option value="">Select an option</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div>
                <label for="hours_played">Hours Played <span class="required">*</span></label>
                <input type="number" id="hours_played" name="hours_played" min="0" max="10000" step="0.1" required>
            </div>
        </div>

        <div>
            <label for="notes">Player Notes</label>
            <textarea id="notes" name="notes" maxlength="500" placeholder="Enter an optional short review or note."></textarea>
        </div>

        <button type="submit">Create JSON</button>
    </form>

    <footer>Jordan Dardar | CSD440 | Module 10.2</footer>
</main>
</body>
</html>
