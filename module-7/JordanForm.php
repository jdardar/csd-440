<?php
/**
 * File: JordanForm.php
 * Name: Jordan Dardar
 * Course: CSD440-308A Server-Side Scripting
 * Assignment: Module 7.2 - Forms
 * Date: September 6, 2026
 * Purpose: Collect seven required workshop registration fields, validate them
 *          on the server, and display either errors or a formatted response.
 * Source: PHP Manual, https://www.php.net/manual/en/filter.examples.validation.php
 *         https://www.php.net/manual/en/function.htmlspecialchars.php
 *         https://www.php.net/manual/en/function.checkdate.php
 */

/**
 * Encode a value for safe display in HTML text or quoted HTML attributes.
 * @param string $value The untrusted text to display.
 * @return string HTML-encoded text.
 */
function escapeHtml($value)
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Define the seven fields and the permitted selection values.
$labels = [
    'full_name' => 'Full name',
    'email' => 'Email address',
    'guests' => 'Number of attendees',
    'budget' => 'Total budget',
    'workshop_date' => 'Workshop date',
    'topic' => 'Workshop topic',
    'attendance' => 'Attendance method'
];
$topics = ['PHP Forms', 'Database Basics', 'Web Security'];
$methods = ['In person', 'Online'];
$values = array_fill_keys(array_keys($labels), '');
$errors = [];
$submitted = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($submitted) {
    // Reject missing, blank, or non-string values before type-specific checks.
    foreach ($labels as $key => $label) {
        if (!isset($_POST[$key]) || !is_string($_POST[$key])) {
            $errors[$key] = $label . ' is required and must be a single value.';
        } else {
            $values[$key] = trim($_POST[$key]);
            if ($values[$key] === '') {
                $errors[$key] = $label . ' is required.';
            }
        }
    }

    // Names may contain Unicode letters, spaces, apostrophes, periods, and hyphens.
    if (!isset($errors['full_name']) &&
        (strlen($values['full_name']) > 100 ||
         !preg_match("/^[\p{L}\p{M}][\p{L}\p{M} .'-]*$/u", $values['full_name']))) {
        $errors['full_name'] = 'Enter a name using letters, spaces, apostrophes, periods, or hyphens (maximum 100 bytes).';
    }

    // Validate email syntax; this does not verify that the mailbox exists.
    if (!isset($errors['email']) &&
        (strlen($values['email']) > 254 ||
         filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false)) {
        $errors['email'] = 'Enter a valid email address, such as jordan@example.com.';
    }

    // Attendees must be an integer within the workshop capacity.
    if (!isset($errors['guests']) &&
        filter_var($values['guests'], FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 20]]) === false) {
        $errors['guests'] = 'Number of attendees must be a whole number from 1 to 20.';
    }

    // Accept a positive decimal amount with no more than two decimal places.
    if (!isset($errors['budget']) &&
        (!preg_match('/^\d{1,5}(\.\d{1,2})?$/D', $values['budget']) ||
         (float) $values['budget'] < 0.01 || (float) $values['budget'] > 10000)) {
        $errors['budget'] = 'Enter a budget from 0.01 to 10000.00 with at most two decimal places; omit dollar signs and commas.';
    }

    // Check both the date format and its actual calendar validity.
    if (!isset($errors['workshop_date'])) {
        $dateParts = [];
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/D', $values['workshop_date'], $dateParts) ||
            !checkdate((int) $dateParts[2], (int) $dateParts[3], (int) $dateParts[1])) {
            $errors['workshop_date'] = 'Enter a real calendar date in YYYY-MM-DD format.';
        }
    }

    // Check dropdown and radio values on the server even if a request is altered.
    if (!isset($errors['topic']) && !in_array($values['topic'], $topics, true)) {
        $errors['topic'] = 'Choose PHP Forms, Database Basics, or Web Security.';
    }
    if (!isset($errors['attendance']) && !in_array($values['attendance'], $methods, true)) {
        $errors['attendance'] = 'Choose In person or Online.';
    }
}
$success = $submitted && empty($errors);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jordan Dardar | Module 7.2 PHP Form</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 28px 16px; background: #eef2f6; color: #203047; font: 16px/1.5 Arial, sans-serif; }
        main { max-width: 850px; margin: auto; background: white; border: 1px solid #d5dde6; border-radius: 12px; padding: 30px; }
        h1 { margin: 4px 0 8px; font-size: 28px; line-height: 1.2; }
        h2 { font-size: 21px; margin: 0 0 10px; }
        .meta { color: #536478; font-size: 14px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 24px; }
        label, legend { font-weight: bold; }
        label { display: block; margin-bottom: 5px; }
        input:not([type=radio]), select { width: 100%; padding: 10px; border: 1px solid #8192a6; border-radius: 5px; font: inherit; }
        input:focus, select:focus { outline: 3px solid #b4d8f5; }
        small { display: block; color: #536478; margin-top: 4px; }
        fieldset { border: 1px solid #8192a6; border-radius: 5px; margin: 0; padding: 10px 14px; }
        fieldset label { display: inline-block; margin: 5px 15px 5px 0; font-weight: normal; }
        .full { grid-column: 1 / -1; }
        .notice { padding: 16px 20px; border-radius: 6px; margin: 20px 0; }
        .error { background: #fff2f1; border: 1px solid #ad3434; color: #7a2222; }
        .success { background: #edf8f1; border: 1px solid #33804c; color: #215734; }
        .error a { color: inherit; }
        button, .button { display: inline-block; background: #185987; color: white; border: 0; border-radius: 5px; padding: 11px 20px; font: bold 16px Arial, sans-serif; text-decoration: none; cursor: pointer; }
        .actions { margin-top: 24px; }
        .actions a:not(.button) { color: #185987; margin-left: 18px; }
        table { border-collapse: collapse; width: 100%; }
        caption { text-align: left; font-weight: bold; padding-bottom: 10px; }
        th, td { text-align: left; padding: 12px; border: 1px solid #d5dde6; overflow-wrap: anywhere; }
        th { width: 38%; background: #f3f6f9; }
        footer { border-top: 1px solid #d5dde6; margin-top: 26px; padding-top: 14px; }
        @media (max-width: 600px) { .grid { grid-template-columns: 1fr; } main { padding: 20px; } }
    </style>
</head>
<body>
<main>
    <p class="meta">Jordan Dardar | CSD440-308A | Module 7.2</p>
    <h1>Workshop Registration</h1>
    <?php if ($success): ?>
        <section class="notice success" aria-labelledby="success-title">
            <h2 id="success-title">Registration submitted successfully</h2>
            <p>All seven fields passed validation. Your entered information is shown below.</p>
        </section>
        <table>
            <caption>Submitted registration details</caption>
            <?php foreach ($labels as $key => $label): ?>
                <tr>
                    <th scope="row"><?php echo escapeHtml($label); ?></th>
                    <td><?php
                        // Format the validated currency value; encode every displayed value.
                        $display = $key === 'budget'
                            ? '$' . number_format((float) $values[$key], 2)
                            : $values[$key];
                        echo escapeHtml($display);
                    ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p class="actions"><a class="button" href="JordanForm.php">Enter another registration</a></p>
    <?php else: ?>
        <p>Complete all seven fields. Budget is in US dollars.</p>
        <?php if (!empty($errors)): ?>
            <section class="notice error" role="alert" aria-labelledby="error-title">
                <h2 id="error-title">Please correct the following errors</h2>
                <ul>
                    <?php foreach ($errors as $key => $message): ?>
                        <li><a href="#<?php echo escapeHtml($key); ?>"><?php echo escapeHtml($message); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <p>Your entries remain below so you can correct them and submit again.</p>
            </section>
        <?php endif; ?>
        <!-- novalidate lets PHP demonstrate all validation errors after POST. -->
        <form action="JordanForm.php" method="post" novalidate>
            <div class="grid">
                <div>
                    <label for="full_name">1. Full name</label>
                    <input type="text" id="full_name" name="full_name" maxlength="100" required value="<?php echo escapeHtml($values['full_name']); ?>">
                </div>
                <div>
                    <label for="email">2. Email address</label>
                    <input type="email" id="email" name="email" maxlength="254" required value="<?php echo escapeHtml($values['email']); ?>">
                </div>
                <div>
                    <label for="guests">3. Number of attendees</label>
                    <input type="number" id="guests" name="guests" min="1" max="20" step="1" required value="<?php echo escapeHtml($values['guests']); ?>">
                    <small>Whole number from 1 to 20.</small>
                </div>
                <div>
                    <label for="budget">4. Total budget ($)</label>
                    <input type="number" id="budget" name="budget" min="0.01" max="10000" step="0.01" required value="<?php echo escapeHtml($values['budget']); ?>">
                    <small>0.01 to 10000.00; up to two decimal places.</small>
                </div>
                <div>
                    <label for="workshop_date">5. Workshop date</label>
                    <input type="date" id="workshop_date" name="workshop_date" required value="<?php echo escapeHtml($values['workshop_date']); ?>">
                </div>
                <div>
                    <label for="topic">6. Workshop topic</label>
                    <select id="topic" name="topic" required>
                        <option value="">Choose a topic</option>
                        <?php foreach ($topics as $topic): ?>
                            <option value="<?php echo escapeHtml($topic); ?>" <?php echo $values['topic'] === $topic ? 'selected' : ''; ?>><?php echo escapeHtml($topic); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <fieldset class="full" id="attendance">
                    <legend>7. Attendance method</legend>
                    <?php foreach ($methods as $index => $method): ?>
                        <label for="method-<?php echo $index; ?>">
                            <input type="radio" id="method-<?php echo $index; ?>" name="attendance" value="<?php echo escapeHtml($method); ?>" required <?php echo $values['attendance'] === $method ? 'checked' : ''; ?>>
                            <?php echo escapeHtml($method); ?>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
            </div>
            <div class="actions"><button type="submit">Submit registration</button><a href="JordanForm.php">Clear form</a></div>
        </form>
    <?php endif; ?>
    <footer class="meta">Module 7.2 Programming Assignment | September 6, 2026<br>Class demonstration: information is displayed only and is not saved.</footer>
</main>
</body>
</html>
