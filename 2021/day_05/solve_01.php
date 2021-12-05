<?php

// Solved in 23 minutes with this slow solution
// See solve_02.php for much faster solution which works for both part 1 and part 2 :)

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = [];
$minX = null;
$minY = null;
$maxX = null;
$maxY = null;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    list($point1, $point2) = explode(' -> ', $line);
    list($x1, $y1) = explode(',', $point1);
    list($x2, $y2) = explode(',', $point2);

    $minX = null === $minX ? min($x1, $x2) : min($x1, $x2, $minX);
    $minY = null === $minY ? min($y1, $y2) : min($y1, $y2, $minY);
    $maxX = null === $maxX ? max($x1, $x2) : max($x1, $x2, $maxX);
    $maxY = null === $maxY ? max($y1, $y2) : max($y1, $y2, $maxY);

    if ($x1 != $x2 && $y1 != $y2) {
        continue;
    }

    $lines[] = [
        'start' => [$x1, $y1],
        'end' => [$x2, $y2],
    ];
}

$coverPoints = [];
for ($x = $minX; $x <= $maxX; $x++) {
    for ($y = $minY; $y <= $maxY; $y++) {
        foreach ($lines as $lineIndex => $line) {
            // match horizontal line
            if ($y == $line['start'][1] && $x <= max($line['start'][0], $line['end'][0]) && $x >= min($line['start'][0], $line['end'][0])) {
                $coverPoints[$x][$y][$lineIndex] = true;
            }
            // match vertical line
            if ($x == $line['start'][0] && $y <= max($line['start'][1], $line['end'][1]) && $y >= min($line['start'][1], $line['end'][1])) {
                $coverPoints[$x][$y][$lineIndex] = true;
            }
        }
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
