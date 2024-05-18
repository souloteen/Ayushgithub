<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3x + 1 Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            color: #007bff;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="number"] {
            width: 100px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Calculate 3x + 1</h1>
    <form method="post" action="">
        <label for="number">Single Number:</label>
        <input type="number" id="number" name="number">
        <br><br>
        <label for="start">Start of Range:</label>
        <input type="number" id="start" name="start">
        <label for="end">End of Range:</label>
        <input type="number" id="end" name="end">
        <br><br>
        <input type="submit" value="Calculate">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once 'functions.php'; // Including the functions file
        
        if (isset($_POST['number']) && !empty($_POST['number'])) {
            $number = intval($_POST['number']);
            if ($number > 0) {
                $result = calculateSingle($number);
                echo "<h2>Single Number Result</h2>";
                echo "<p>Number: $number (Iterations: {$result['iterations']}, Highest Value: {$result['maxValue']})</p>";
            } else {
                echo "<p>Please enter a valid positive number.</p>";
            }
        }

        if (isset($_POST['start']) && isset($_POST['end']) && !empty($_POST['start']) && !empty($_POST['end'])) {
            $start = intval($_POST['start']);
            $end = intval($_POST['end']);

            if ($start > 0 && $end > 0 && $end >= $start) {
                $results = calculateRange($start, $end);
                $formattedResults = formatResults($results);
                
                echo "<h2>Results</h2>";
                echo "<table>";
                echo "<tr><th>Number</th><th>Iterations</th><th>Highest Value</th></tr>";
                foreach ($formattedResults['formattedResults'] as $res) {
                    echo "<tr><td>{$res['number']}</td><td>{$res['iterations']}</td><td>{$res['maxValue']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Please enter valid positive numbers with end greater than or equal to start.</p>";
            }
        }
    }
    ?>
</body>
</html>
