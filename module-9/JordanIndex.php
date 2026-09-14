<?php
/*
 * Student: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 9.2 Programming Assignment
 * Date: September 14, 2026
 * Purpose: Provide a home page with links to the Module 9 forms and Module 8 utilities.
 */
$pageTitle = "Video Game Database";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; color: #1f2933; background: #eef3f7; }
        header { padding: 42px 20px; color: white; text-align: center; background: #1f4e78; }
        header h1 { margin: 0 0 10px; font-size: 2.2rem; }
        header p { margin: 0; }
        main { width: min(1000px, calc(100% - 32px)); margin: 32px auto; }
        h2 { color: #1f4e78; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; }
        .card { padding: 24px; background: white; border-radius: 10px; box-shadow: 0 3px 12px rgba(0, 0, 0, .09); }
        .card h3 { margin-top: 0; color: #1f4e78; }
        .button { display: inline-block; margin-top: 8px; padding: 10px 16px; color: white; text-decoration: none; background: #1f4e78; border-radius: 5px; }
        .button:hover, .button:focus { background: #163a5b; }
        .utility-list { padding-left: 20px; line-height: 2; }
        .utility-list a { color: #1f4e78; }
        .warning { padding: 12px; color: #7a4b00; background: #fff4d6; border-left: 4px solid #d99a00; border-radius: 4px; }
        footer { padding: 20px; text-align: center; color: #52606d; }
    </style>
</head>
<body>
<header>
    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    <p>Module 9 database forms and Module 8 table utilities</p>
</header>

<main>
    <section aria-labelledby="module-nine-heading">
        <h2 id="module-nine-heading">Module 9 Pages</h2>
        <div class="grid">
            <article class="card">
                <h3>Search Video Games</h3>
                <p>Search the database by a game's title, platform, or genre.</p>
                <a class="button" href="JordanQuery.php">Open Search Page</a>
            </article>
            <article class="card">
                <h3>Add a Video Game</h3>
                <p>Use a validated form to add a new record to the database.</p>
                <a class="button" href="JordanForms.php">Open Add Record Form</a>
            </article>
        </div>
    </section>

    <section class="card" aria-labelledby="module-eight-heading" style="margin-top: 24px;">
        <h2 id="module-eight-heading">Module 8 Utilities</h2>
        <p>These files are included as required and can rebuild, populate, display, or remove the table.</p>
        <ul class="utility-list">
            <li><a href="DardarCreateTable.php">Create the video_games table</a></li>
            <li><a href="DardarPopulateTable.php">Populate the table with five records</a></li>
            <li><a href="DardarQueryTable.php">Display all table records</a></li>
            <li><a href="DardarDropTable.php">Drop the video_games table</a></li>
        </ul>
        <p class="warning"><strong>Warning:</strong> The Drop Table page deletes the video_games table. Run Create and Populate afterward if you test it.</p>
    </section>
</main>

<footer>
    <p>Jordan Dardar | CSD440 | Module 9.2</p>
</footer>
</body>
</html>
