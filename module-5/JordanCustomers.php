<?php
/**
 * File: JordanCustomers.php
 * Name: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 5.2 Programming Assignment
 * Date: August 30, 2026
 * Purpose: Create an array of customers and demonstrate how PHP array
 * methods can find, filter, sort, and display customer records by field.
 * Source: Original code written by Jordan Dardar for this assignment.
 */

// Create an indexed array containing 12 associative customer arrays.
$customers = [
    ["firstName" => "Avery", "lastName" => "Brooks", "age" => 24, "phone" => "(479) 555-0101"],
    ["firstName" => "Marcus", "lastName" => "Johnson", "age" => 41, "phone" => "(479) 555-0102"],
    ["firstName" => "Tiffany", "lastName" => "Davis", "age" => 32, "phone" => "(479) 555-0103"],
    ["firstName" => "Ethan", "lastName" => "Miller", "age" => 28, "phone" => "(479) 555-0104"],
    ["firstName" => "Olivia", "lastName" => "Anderson", "age" => 36, "phone" => "(479) 555-0105"],
    ["firstName" => "Noah", "lastName" => "Wilson", "age" => 45, "phone" => "(479) 555-0106"],
    ["firstName" => "Sophia", "lastName" => "Martinez", "age" => 29, "phone" => "(479) 555-0107"],
    ["firstName" => "Liam", "lastName" => "Thompson", "age" => 52, "phone" => "(479) 555-0108"],
    ["firstName" => "Emma", "lastName" => "Carter", "age" => 33, "phone" => "(479) 555-0109"],
    ["firstName" => "Mason", "lastName" => "Robinson", "age" => 38, "phone" => "(479) 555-0110"],
    ["firstName" => "Isabella", "lastName" => "Moore", "age" => 26, "phone" => "(479) 555-0111"],
    ["firstName" => "James", "lastName" => "Jackson", "age" => 47, "phone" => "(479) 555-0112"]
];

/**
 * Escape output before placing it in HTML.
 *
 * @param mixed $value Value that will be displayed.
 * @return string Safely escaped text.
 */
function escapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

/**
 * Remove nonnumeric characters so phone numbers can be compared consistently.
 *
 * @param string $phone Phone number to normalize.
 * @return string Digits-only phone number.
 */
function normalizePhone($phone)
{
    return preg_replace("/\D/", "", $phone);
}

// Read the filter and sorting selections from the query string.
$allowedFields = ["all", "firstName", "lastName", "age", "phone"];
$allowedSortFields = ["firstName", "lastName", "age", "phone"];
$searchField = isset($_GET["field"]) ? $_GET["field"] : "all";
$searchTerm = isset($_GET["query"]) ? trim($_GET["query"]) : "";
$sortField = isset($_GET["sort"]) ? $_GET["sort"] : "lastName";

// Prevent unexpected field names from being used in array access.
if (!in_array($searchField, $allowedFields, true)) {
    $searchField = "all";
}

if (!in_array($sortField, $allowedSortFields, true)) {
    $sortField = "lastName";
}

// Begin with all records, then filter them only when a search term is present.
$displayedCustomers = $customers;

if ($searchTerm !== "") {
    $displayedCustomers = array_filter($customers, function ($customer) use ($searchField, $searchTerm) {
        if ($searchField === "age") {
            return (string) $customer["age"] === $searchTerm;
        }

        if ($searchField === "phone") {
            return strpos(normalizePhone($customer["phone"]), normalizePhone($searchTerm)) !== false;
        }

        if ($searchField === "all") {
            $customerText = implode(" ", [
                $customer["firstName"],
                $customer["lastName"],
                $customer["age"],
                $customer["phone"]
            ]);

            return stripos($customerText, $searchTerm) !== false;
        }

        return stripos((string) $customer[$searchField], $searchTerm) !== false;
    });
}

// Sort the displayed records according to the field selected by the user.
usort($displayedCustomers, function ($firstCustomer, $secondCustomer) use ($sortField) {
    if ($sortField === "age") {
        return $firstCustomer["age"] <=> $secondCustomer["age"];
    }

    return strcasecmp($firstCustomer[$sortField], $secondCustomer[$sortField]);
});

// Demonstration 1: array_filter() finds several records by age.
$ageMatches = array_filter($customers, function ($customer) {
    return $customer["age"] >= 35;
});

// Demonstration 2: array_filter() finds several records by first name.
$nameMatches = array_filter($customers, function ($customer) {
    return stripos($customer["firstName"], "o") !== false;
});

// Demonstration 3: array_column() and array_search() find one exact phone record.
$phoneNumbers = array_column($customers, "phone");
$phoneIndex = array_search("(479) 555-0105", $phoneNumbers, true);
$phoneMatch = $phoneIndex !== false ? $customers[$phoneIndex] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jordan's Customer Directory</title>
    <style>
        :root {
            --navy: #17324d;
            --blue: #2878b5;
            --light-blue: #eaf4fb;
            --border: #d6e0e8;
            --text: #23313f;
            --muted: #607080;
            --white: #ffffff;
            --success: #19734b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            background: #f3f6f8;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
        }

        header {
            padding: 34px 24px;
            color: var(--white);
            background: linear-gradient(135deg, var(--navy), var(--blue));
        }

        header div,
        main {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
        }

        h1 {
            margin: 0 0 6px;
            font-size: clamp(1.9rem, 4vw, 2.7rem);
        }

        header p {
            margin: 0;
            color: #dcecf8;
        }

        main {
            padding: 28px 0 48px;
        }

        section {
            margin-bottom: 24px;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 6px 22px rgba(23, 50, 77, 0.07);
        }

        h2 {
            margin: 0 0 6px;
            color: var(--navy);
        }

        .section-description {
            margin: 0 0 18px;
            color: var(--muted);
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr auto auto;
            gap: 12px;
            align-items: end;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: var(--navy);
            font-size: 0.9rem;
            font-weight: bold;
        }

        input,
        select,
        button,
        .reset-button {
            width: 100%;
            min-height: 42px;
            padding: 9px 11px;
            border: 1px solid #aebdca;
            border-radius: 7px;
            font: inherit;
        }

        button,
        .reset-button {
            border-color: var(--blue);
            color: var(--white);
            background: var(--blue);
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
        }

        .reset-button {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            background: var(--white);
        }

        .result-summary {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 18px 0 10px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 11px 13px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        th {
            color: var(--white);
            background: var(--navy);
        }

        tbody tr:nth-child(even) {
            background: #f7fafc;
        }

        tbody tr:hover {
            background: var(--light-blue);
        }

        .method-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .method-card {
            padding: 18px;
            border: 1px solid var(--border);
            border-top: 4px solid var(--blue);
            border-radius: 10px;
            background: #fbfdff;
        }

        .method-card h3 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 1.05rem;
        }

        .method-name {
            margin: 0 0 12px;
            color: var(--success);
            font-family: Consolas, "Courier New", monospace;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .customer-list {
            margin: 0;
            padding-left: 19px;
        }

        .customer-list li {
            margin-bottom: 8px;
        }

        .empty-message {
            padding: 22px;
            color: var(--muted);
            text-align: center;
        }

        footer {
            padding: 18px;
            color: #dcecf8;
            background: var(--navy);
            text-align: center;
        }

        @media (max-width: 850px) {
            form,
            .method-grid {
                grid-template-columns: 1fr;
            }

            .result-summary {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Customer Directory</h1>
            <p>CSD440 Module 5.2 | Indexed and Associative Arrays</p>
        </div>
    </header>

    <main>
        <section>
            <h2>Find Customer Records</h2>
            <p class="section-description">
                Search the customer array by a selected data field and sort the matching records.
            </p>

            <form method="get" action="JordanCustomers.php">
                <div>
                    <label for="field">Search field</label>
                    <select id="field" name="field">
                        <option value="all" <?php echo $searchField === "all" ? "selected" : ""; ?>>All fields</option>
                        <option value="firstName" <?php echo $searchField === "firstName" ? "selected" : ""; ?>>First name</option>
                        <option value="lastName" <?php echo $searchField === "lastName" ? "selected" : ""; ?>>Last name</option>
                        <option value="age" <?php echo $searchField === "age" ? "selected" : ""; ?>>Age</option>
                        <option value="phone" <?php echo $searchField === "phone" ? "selected" : ""; ?>>Phone number</option>
                    </select>
                </div>

                <div>
                    <label for="query">Search value</label>
                    <input
                        id="query"
                        name="query"
                        type="text"
                        value="<?php echo escapeHtml($searchTerm); ?>"
                        placeholder="Example: Moore, 36, or 0105"
                    >
                </div>

                <div>
                    <label for="sort">Sort results by</label>
                    <select id="sort" name="sort">
                        <option value="firstName" <?php echo $sortField === "firstName" ? "selected" : ""; ?>>First name</option>
                        <option value="lastName" <?php echo $sortField === "lastName" ? "selected" : ""; ?>>Last name</option>
                        <option value="age" <?php echo $sortField === "age" ? "selected" : ""; ?>>Age</option>
                        <option value="phone" <?php echo $sortField === "phone" ? "selected" : ""; ?>>Phone number</option>
                    </select>
                </div>

                <button type="submit">Search</button>
                <a class="reset-button" href="JordanCustomers.php">Reset</a>
            </form>

            <div class="result-summary">
                <span>
                    <?php echo count($displayedCustomers); ?> customer record(s) displayed
                </span>
                <span>Sorted by <?php echo escapeHtml($sortField); ?></span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Age</th>
                            <th>Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($displayedCustomers) === 0) { ?>
                            <tr>
                                <td class="empty-message" colspan="4">No matching customers were found.</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($displayedCustomers as $customer) { ?>
                                <tr>
                                    <td><?php echo escapeHtml($customer["firstName"]); ?></td>
                                    <td><?php echo escapeHtml($customer["lastName"]); ?></td>
                                    <td><?php echo escapeHtml($customer["age"]); ?></td>
                                    <td><?php echo escapeHtml($customer["phone"]); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>Array Method Demonstrations</h2>
            <p class="section-description">
                These examples find and display customer records using different data fields.
            </p>

            <div class="method-grid">
                <article class="method-card">
                    <h3>Age: 35 and Older</h3>
                    <p class="method-name">array_filter()</p>
                    <ul class="customer-list">
                        <?php foreach ($ageMatches as $customer) { ?>
                            <li>
                                <?php echo escapeHtml($customer["firstName"] . " " . $customer["lastName"]); ?>,
                                age <?php echo escapeHtml($customer["age"]); ?> -
                                <?php echo escapeHtml($customer["phone"]); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </article>

                <article class="method-card">
                    <h3>First Name Contains "o"</h3>
                    <p class="method-name">array_filter()</p>
                    <ul class="customer-list">
                        <?php foreach ($nameMatches as $customer) { ?>
                            <li>
                                <?php echo escapeHtml($customer["firstName"] . " " . $customer["lastName"]); ?>,
                                age <?php echo escapeHtml($customer["age"]); ?> -
                                <?php echo escapeHtml($customer["phone"]); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </article>

                <article class="method-card">
                    <h3>Exact Phone Lookup</h3>
                    <p class="method-name">array_column() + array_search()</p>
                    <?php if ($phoneMatch !== null) { ?>
                        <p>
                            <strong><?php echo escapeHtml($phoneMatch["firstName"] . " " . $phoneMatch["lastName"]); ?></strong><br>
                            Age: <?php echo escapeHtml($phoneMatch["age"]); ?><br>
                            Phone: <?php echo escapeHtml($phoneMatch["phone"]); ?>
                        </p>
                    <?php } else { ?>
                        <p>No exact phone match was found.</p>
                    <?php } ?>
                </article>
            </div>
        </section>
    </main>

    <footer>
        Jordan Dardar | CSD440 Server-Side Scripting | Module 5.2
    </footer>
</body>
</html>
