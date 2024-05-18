<!DOCTYPE html>
<html>
<head>
    <title>Collatz Conjecture Calculator</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e0f7fa;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #00796b;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #b2dfdb;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #00796b;
        }

        input[type="text"], input[type="submit"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #00796b;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #004d40;
        }

        .bar-graph {
            margin-top: 20px;
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
        }

        .bar {
            width: 20px;
            background-color: #00796b;
            margin-right: 5px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            color: #fff;
            font-size: 12px;
            position: relative;
        }

        .bar .frequency {
            position: absolute;
            bottom: 0;
            transform: rotate(0);
            writing-mode: horizontal-tb;
            text-orientation: mixed;
        }
    </style>
</head>
<body>

<div class="container">
    <?php

    class CollatzCalculator {
        private function collatz($n) {
            $maxValue = $n;
            $iterations = 0;

            while ($n != 1) {
                if ($n % 2 == 0) {
                    $n /= 2;
                } else {
                    $n = 3 * $n + 1;
                }
                $maxValue = max($maxValue, $n);
                $iterations++;
            }

            return array('maxValue' => $maxValue, 'iterations' => $iterations);
        }

        public function calculateSingleNumber($singleNumber) {
            $result = $this->collatz($singleNumber);

            echo "<h2>Collatz Sequence for $singleNumber:</h2>\n";
            echo "<table>\n";
            echo "<tr><th>Collatz sequence</th><td>";
            $n = $singleNumber;
            $sequence = [];
            while ($n != 1) {
                $sequence[] = $n;
                if ($n % 2 == 0) {
                    $n /= 2;
                } else {
                    $n = 3 * $n + 1;
                }
            }
            $sequence[] = 1;
            echo implode(' -> ', $sequence) . "</td></tr>\n";
            echo "<tr><th>Max value</th><td>" . $result['maxValue'] . "</td></tr>\n";
            echo "<tr><th>Iterations</th><td>" . $result['iterations'] . "</td></tr>\n";
            echo "</table>\n";
        }

        protected function calculateRange($start, $finish) {
            $results = array();

            for ($i = $start; $i <= $finish; $i++) {
                $result = $this->collatz($i);
                $results[] = array('number' => $i, 'maxValue' => $result['maxValue'], 'iterations' => $result['iterations']);
            }

            return $results;
        }

        public function calculateStatistics($start, $finish) {
            $rangeResults = $this->calculateRange($start, $finish);

            $histogram = array();
            foreach ($rangeResults as $result) {
                $iterations = $result['iterations'];
                if (!isset($histogram[$iterations])) {
                    $histogram[$iterations] = 1;
                } else {
                    $histogram[$iterations]++;
                }
            }

            return $histogram;
        }
    }

    class CollatzStatisticsCalculator extends CollatzCalculator {
        public function calculateHistogram($start, $finish) {
            $histogram = $this->calculateStatistics($start, $finish);

            echo "<h2>Statistics (Histogram) for Collatz Conjecture Iterations:</h2>\n";
            echo "<table>\n";
            echo "<tr><th>Iterations</th><th>Frequency</th></tr>\n";
            foreach ($histogram as $iterations => $frequency) {
                echo "<tr><td>$iterations</td><td>$frequency</td></tr>\n";
            }
            echo "</table>\n";

            echo '<h3>Graphical Representation:</h3>';
            echo '<div class="bar-graph">';
            foreach ($histogram as $iterations => $frequency) {
                echo '<div class="bar" style="height: ' . ($frequency * 20) . 'px;">';
                echo '<div class="frequency">' . $frequency . '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $start = $_POST['start'];
        $finish = $_POST['finish'];

        $statisticsCalculator = new CollatzStatisticsCalculator();

        $statisticsCalculator->calculateHistogram($start, $finish);
    }

    ?>

    <h2>Calculate Collatz Conjecture Statistics</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="start">Start:</label>
        <input type="text" id="start" name="start"><br>
        <label for="finish">Finish:</label>
        <input type="text" id="finish" name="finish"><br>
        <input type="submit" name="submit" value="Calculate">
    </form>
</div>

</body>
</html>
