<?php

class ArithmeticProgression {
    public static function generateAP($start, $finish, $difference) {
        $result = array();
        for ($i = $start; $i <= $finish; $i += $difference) {
            $result[] = $i;
        }
        return $result;
    }
}

class CollatzCalculator {
    public static function collatz($n) {
        $maxValue = $n;
        $iterations = 0;
        $sequence = [];

        while ($n != 1) {
            $sequence[] = $n;
            if ($n % 2 == 0) {
                $n /= 2;
            } else {
                $n = 3 * $n + 1;
            }
            $maxValue = max($maxValue, $n);
            $iterations++;
        }
        $sequence[] = 1;

        return array('maxValue' => $maxValue, 'iterations' => $iterations, 'sequence' => $sequence);
    }

    public static function calculateRange($start, $finish) {
        $results = array();

        for ($i = $start; $i <= $finish; $i++) {
            $result = self::collatz($i);
            $results[] = array('number' => $i, 'maxValue' => $result['maxValue'], 'iterations' => $result['iterations'], 'sequence' => $result['sequence']);
        }

        return $results;
    }
}

// HTML form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['arithmetic_progression'])) {
        $start = $_POST['start'];
        $finish = $_POST['finish'];
        $difference = $_POST['difference'];

        $apSequence = ArithmeticProgression::generateAP($start, $finish, $difference);

        echo "<h2>Arithmetic Progression:</h2>";
        echo "<table class='result-table'>";
        echo "<tr><th>Number</th></tr>";
        foreach ($apSequence as $number) {
            echo "<tr><td>$number</td></tr>";
        }
        echo "</table>";
    } elseif (isset($_POST['submit'])) {
        $start = $_POST['start'];
        $finish = $_POST['finish'];

        if (!empty($_POST['single_number'])) {
            $singleNumber = $_POST['single_number'];
            $result = CollatzCalculator::collatz($singleNumber);

            echo "<h2>Single Number Collatz Sequence for $singleNumber:</h2>";
            echo "<table class='result-table'>";
            echo "<tr><th>Sequence</th><td>" . implode(' -> ', $result['sequence']) . "</td></tr>";
            echo "<tr><th>Max value</th><td>" . $result['maxValue'] . "</td></tr>";
            echo "<tr><th>Iterations</th><td>" . $result['iterations'] . "</td></tr>";
            echo "</table>";
        }

        $rangeResults = CollatzCalculator::calculateRange($start, $finish);

        $minIterations = PHP_INT_MAX;
        $maxIterations = PHP_INT_MIN;
        $minIterationsNumber = null;
        $maxIterationsNumber = null;

        foreach ($rangeResults as $result) {
            if ($result['iterations'] < $minIterations) {
                $minIterations = $result['iterations'];
                $minIterationsNumber = $result;
            }
            if ($result['iterations'] > $maxIterations) {
                $maxIterations = $result['iterations'];
                $maxIterationsNumber = $result;
            }
        }

        echo "<h2>Numbers with Max and Min Iterations:</h2>";
        echo "<p>Start: $start</p>";
        echo "<p>Finish: $finish</p>";

        echo "<h3>Max Iterations:</h3>";
        echo "<table class='result-table'>";
        echo "<tr><th>Max value</th><td>" . $maxIterationsNumber['maxValue'] . "</td></tr>";
        echo "<tr><th>Iterations</th><td>" . $maxIterationsNumber['iterations'] . "</td></tr>";
        echo "</table>";

        echo "<h3>Min Iterations:</h3>";
        echo "<table class='result-table'>";
        echo "<tr><th>Max value</th><td>" . $minIterationsNumber['maxValue'] . "</td></tr>";
        echo "<tr><th>Iterations</th><td>" . $minIterationsNumber['iterations'] . "</td></tr>";
        echo "</table>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Collatz Conjecture Calculator</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            width: calc(100% - 24px);
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .result-table th, .result-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .result-table th {
            background-color: #f2f2f2;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Calculate Arithmetic Progression</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="start">Start:</label>
        <input type="text" id="start" name="start"><br>
        <label for="finish">Finish:</label>
        <input type="text" id="finish" name="finish"><br>
        <label for="difference">Difference:</label>
        <input type="text" id="difference" name="difference"><br>
        <input type="submit" name="arithmetic_progression" value="Generate AP">
    </form>

    <h2>Calculate Collatz Conjecture for a Range of Numbers</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="single_number">Test with a single number:</label>
        <input type="text" id="single_number" name="single_number"><br>
        <label for="start">Start:</label>
        <input type="text" id="start" name="start"><br>
        <label for="finish">Finish:</label>
        <input type="text" id="finish" name="finish"><br>
        <input type="submit" name="submit" value="Calculate">
    </form>
</div>

</body>
</html>
