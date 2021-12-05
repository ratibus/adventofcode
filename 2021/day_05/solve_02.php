<?php

// Solved in 45 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    list($point1, $point2) = explode(' -> ', $line);
    list($x1, $y1) = explode(',', $point1);
    list($x2, $y2) = explode(',', $point2);

    /* uncomment this block for part 1
    if ($x1 != $x2 && $y1 != $y2) {
        continue;
    }
    /**/

    $lines[] = [
        'start' => [$x1, $y1],
        'end' => [$x2, $y2],
    ];
}

$coverPoints = [];
foreach ($lines as $lineIndex => $line) {

    $distance = max(abs($line['start'][0] - $line['end'][0]), abs($line['start'][1] - $line['end'][1]));

    for ($i = 0; $i <= $distance; $i++) {

        if ($line['start'][0] == $line['end'][0]) {
            $x = $line['start'][0];
        } elseif ($line['start'][0] < $line['end'][0]) {
            $x = $line['start'][0] + $i;
        } else {
            $x = $line['start'][0] - $i;
        }

        if ($line['start'][1] == $line['end'][1]) {
            $y = $line['start'][1];
        } elseif ($line['start'][1] < $line['end'][1]) {
            $y = $line['start'][1] + $i;
        } else {
            $y = $line['start'][1] - $i;
        }

        $coverPoints[$x][$y][$lineIndex] = true;
    }
}

$dangerousPoints = 0;
foreach ($coverPoints as $x => $xData) {
    foreach ($xData as $y => $linesOverlaps) {
        if (count($linesOverlaps) >= 2) {
            $dangerousPoints++;
        }
    }
}

var_dump($dangerousPoints);