<?php
/**
 * File: JordanMyInteger.php
 * Name: Jordan Dardar
 * Course: CSD440 Server-Side Scripting
 * Assignment: Module 6.2 Programming Assignment
 * Date: August 30, 2026
 * Purpose: Define and test a class that stores an integer and determines
 * whether integer values are even, odd, or prime.
 * Source: Original code written by Jordan Dardar for this assignment.
 */

/**
 * Store one integer and provide methods for testing integer values.
 */
class JordanMyInteger
{
    private int $integer;

    /**
     * Set the object's initial integer when it is created.
     *
     * @param int $integer Initial integer value.
     */
    public function __construct(int $integer)
    {
        $this->integer = $integer;
    }

    /**
     * Determine whether the supplied integer is even.
     *
     * @param int $number Integer to test.
     * @return bool True when the integer is even.
     */
    public function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }

    /**
     * Determine whether the supplied integer is odd.
     *
     * @param int $number Integer to test.
     * @return bool True when the integer is odd.
     */
    public function isOdd(int $number): bool
    {
        return $number % 2 !== 0;
    }

    /**
     * Determine whether the integer stored in this object is prime.
     *
     * @return bool True when the stored integer is prime.
     */
    public function isPrime(): bool
    {
        if ($this->integer <= 1) {
            return false;
        }

        if ($this->integer === 2) {
            return true;
        }

        if ($this->integer % 2 === 0) {
            return false;
        }

        for ($divisor = 3; $divisor * $divisor <= $this->integer; $divisor += 2) {
            if ($this->integer % $divisor === 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return the integer currently stored in this object.
     *
     * @return int Stored integer value.
     */
    public function getInteger(): int
    {
        return $this->integer;
    }

    /**
     * Replace the integer currently stored in this object.
     *
     * @param int $integer New integer value.
     * @return void
     */
    public function setInteger(int $integer): void
    {
        $this->integer = $integer;
    }
}

/**
 * Convert a Boolean result into readable output.
 *
 * @param bool $value Boolean result to display.
 * @return string Yes when true or No when false.
 */
function displayBoolean(bool $value): string
{
    return $value ? "Yes" : "No";
}

/**
 * Build one complete set of method results for an object.
 *
 * @param string $objectName Label for the object being tested.
 * @param JordanMyInteger $integerObject Object whose methods will be tested.
 * @return array<string, int|string> Results for the output table.
 */
function buildTestResult(string $objectName, JordanMyInteger $integerObject): array
{
    $storedInteger = $integerObject->getInteger();

    return [
        "objectName" => $objectName,
        "integer" => $storedInteger,
        "isEven" => displayBoolean($integerObject->isEven($storedInteger)),
        "isOdd" => displayBoolean($integerObject->isOdd($storedInteger)),
        "isPrime" => displayBoolean($integerObject->isPrime())
    ];
}

// Create two instances and test the constructor, getter, and number methods.
$firstInteger = new JordanMyInteger(17);
$secondInteger = new JordanMyInteger(24);

$constructorResults = [
    buildTestResult("First object", $firstInteger),
    buildTestResult("Second object", $secondInteger)
];

// Test both setters, then retest the getters and number methods.
$firstInteger->setInteger(20);
$secondInteger->setInteger(29);

$setterResults = [
    buildTestResult("First object", $firstInteger),
    buildTestResult("Second object", $secondInteger)
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JordanMyInteger Class Test</title>
    <style>
        :root {
            --navy: #17324d;
            --blue: #2878b5;
            --green: #18794e;
            --light-blue: #eaf4fb;
            --border: #d5e0e8;
            --text: #23313f;
            --muted: #607080;
            --white: #ffffff;
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
            padding: 40px 24px;
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
            font-size: clamp(2rem, 5vw, 3rem);
        }

        header p {
            margin: 0;
            color: #dcecf8;
            font-size: 1.08rem;
        }

        main {
            padding: 30px 0 48px;
        }

        section {
            margin-bottom: 24px;
            padding: 25px;
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

        .requirement-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .requirement-card {
            padding: 17px;
            border: 1px solid var(--border);
            border-left: 5px solid var(--blue);
            border-radius: 9px;
            background: #fbfdff;
        }

        .requirement-card strong {
            display: block;
            margin-bottom: 4px;
            color: var(--navy);
        }

        .method-name {
            color: var(--green);
            font-family: Consolas, "Courier New", monospace;
            font-size: 0.94rem;
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
            padding: 13px 15px;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        th:first-child,
        td:first-child {
            text-align: left;
        }

        th {
            color: var(--white);
            background: var(--navy);
        }

        tbody tr:nth-child(even) {
            background: #f7fafc;
        }

        .yes {
            color: var(--green);
            font-weight: bold;
        }

        .no {
            color: #9b2c2c;
            font-weight: bold;
        }

        .test-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .test-card {
            padding: 20px;
            border: 1px solid var(--border);
            border-top: 4px solid var(--blue);
            border-radius: 10px;
            background: var(--light-blue);
        }

        .test-card h3 {
            margin: 0 0 10px;
            color: var(--navy);
        }

        .test-card p {
            margin: 5px 0;
        }

        footer {
            padding: 19px;
            color: #dcecf8;
            background: var(--navy);
            text-align: center;
        }

        @media (max-width: 760px) {
            .requirement-grid,
            .test-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>JordanMyInteger Class Test</h1>
            <p>CSD440 Module 6.2 | PHP Objects and Methods</p>
        </div>
    </header>

    <main>
        <section>
            <h2>Class Requirements</h2>
            <p class="section-description">
                The class stores one integer and provides methods for accessing, changing, and testing integer values.
            </p>

            <div class="requirement-grid">
                <article class="requirement-card">
                    <strong>Stored Value</strong>
                    <span class="method-name">__construct(), getInteger(), setInteger()</span>
                </article>
                <article class="requirement-card">
                    <strong>Even or Odd</strong>
                    <span class="method-name">isEven(int), isOdd(int)</span>
                </article>
                <article class="requirement-card">
                    <strong>Prime Number</strong>
                    <span class="method-name">isPrime()</span>
                </article>
            </div>
        </section>

        <section>
            <h2>Initial Constructor Tests</h2>
            <p class="section-description">
                Two instances are created with different integers. Each object's getter and number-testing methods are called.
            </p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Instance</th>
                            <th>getInteger()</th>
                            <th>isEven(int)</th>
                            <th>isOdd(int)</th>
                            <th>isPrime()</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($constructorResults as $result) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result["objectName"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo $result["integer"]; ?></td>
                                <td class="<?php echo strtolower($result["isEven"]); ?>"><?php echo $result["isEven"]; ?></td>
                                <td class="<?php echo strtolower($result["isOdd"]); ?>"><?php echo $result["isOdd"]; ?></td>
                                <td class="<?php echo strtolower($result["isPrime"]); ?>"><?php echo $result["isPrime"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>Setter and Retest Results</h2>
            <p class="section-description">
                The setter changes the first object from 17 to 20 and the second object from 24 to 29 before all methods are tested again.
            </p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Instance</th>
                            <th>getInteger()</th>
                            <th>isEven(int)</th>
                            <th>isOdd(int)</th>
                            <th>isPrime()</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($setterResults as $result) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result["objectName"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo $result["integer"]; ?></td>
                                <td class="<?php echo strtolower($result["isEven"]); ?>"><?php echo $result["isEven"]; ?></td>
                                <td class="<?php echo strtolower($result["isOdd"]); ?>"><?php echo $result["isOdd"]; ?></td>
                                <td class="<?php echo strtolower($result["isPrime"]); ?>"><?php echo $result["isPrime"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2>Method Verification</h2>
            <div class="test-summary">
                <article class="test-card">
                    <h3>First Object</h3>
                    <p>Constructor value: <strong>17</strong></p>
                    <p>Setter value: <strong>20</strong></p>
                    <p>Expected: 17 is odd and prime; 20 is even and not prime.</p>
                </article>

                <article class="test-card">
                    <h3>Second Object</h3>
                    <p>Constructor value: <strong>24</strong></p>
                    <p>Setter value: <strong>29</strong></p>
                    <p>Expected: 24 is even and not prime; 29 is odd and prime.</p>
                </article>
            </div>
        </section>
    </main>

    <footer>
        Jordan Dardar | CSD440 Server-Side Scripting | Module 6.2
    </footer>
</body>
</html>
