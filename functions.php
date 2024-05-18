<?php
function calculate3xPlus1($n) {
    $iterations = 0;
    $maxValue = $n;
    
    while ($n != 1) {
        $iterations++;
        if ($n % 2 == 0) {
            $n = $n / 2;
        } else {
            $n = 3 * $n + 1;
        }
        if ($n > $maxValue) {
            $maxValue = $n;
        }
    }
    
    return ['iterations' => $iterations, 'maxValue' => $maxValue];
}

function calculateSingle($n) {
    return calculate3xPlus1($n);
}

function calculateRange($start, $end) {
    $results = [];

    for ($i = $start; $i <= $end; $i++) {
        $result = calculate3xPlus1($i);
        $results[$i] = $result;
    }

    return $results;
}

function formatResults($results) {
    $maxIterations = 0;
    $minIterations = PHP_INT_MAX;
    $maxNumber = 0;
    $minNumber = 0;
    $maxValue = 0;
    $minValue = 0;
    $formattedResults = [];

    foreach ($results as $number => $result) {
        $formattedResults[] = [
            'number' => $number,
            'iterations' => $result['iterations'],
            'maxValue' => $result['maxValue']
        ];

        if ($result['iterations'] > $maxIterations) {
            $maxIterations = $result['iterations'];
            $maxNumber = $number;
            $maxValue = $result['maxValue'];
        }
        if ($result['iterations'] < $minIterations) {
            $minIterations = $result['iterations'];
            $minNumber = $number;
            $minValue = $result['maxValue'];
        }
    }

    return [
        'formattedResults' => $formattedResults,
        'max' => [
            'number' => $maxNumber,
            'iterations' => $maxIterations,
            'maxValue' => $maxValue
        ],
        'min' => [
            'number' => $minNumber,
            'iterations' => $minIterations,
            'maxValue' => $minValue
        ]
    ];
}
?>
