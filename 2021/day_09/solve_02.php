<?php

// Solved in 1 hour

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$grid = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    foreach (str_split($line) as $x => $value) {
        $grid[$x][$lineIndex] = $value;
    }
}

$lowPoints = [];
foreach ($grid as $x => $points) {
    foreach ($points as $y => $value) {
        if (isset($grid[$x-1][$y]) && $value >= $grid[$x-1][$y]) {
            continue;
        }
        if (isset($grid[$x+1][$y]) && $value >= $grid[$x+1][$y]) {
            continue;
        }
        if (isset($grid[$x][$y-1]) && $value >= $grid[$x][$y-1]) {
            continue;
        }
        if (isset($grid[$x][$y+1]) && $value >= $grid[$x][$y+1]) {
            continue;
        }
        $lowPoints[] = ['x' => $x, 'y' => $y, 'value' => $value];
    }
}

$bassins = [];
foreach ($lowPoints as $lowPointIndex => $lowPoint) {
    $bassins[$lowPointIndex] = getBassinPoints($grid, $lowPoint);
}

// Sort bassin by descending size
usort($bassins, function ($a, $b) {
    return count($b) <=> count($a);
});

// Keep the 3 largest
$largestBassins = array_splice($bassins, 0, 3);

// Multiply the points count in those 3 bassins
$totalSize = 1;
foreach ($largestBassins as $bassin) {
    $totalSize *= count($bassin);
}

var_dump($totalSize);

function getBassinPoints($grid, $lowPoint) {

    // Heavily inspired from https://www.tutorialspoint.com/data_structures_algorithms/depth_first_traversal_in_c.htm

    $bassinPoints = [$lowPoint['x'].','.$lowPoint['y'] => $lowPoint];

    $stack = [$lowPoint];

    while (count($stack)) {

        $point = $stack[count($stack)-1];
        extract($point);

        foreach ([[$x-1, $y], [$x+1, $y], [$x, $y-1], [$x, $y+1]] as list($x2, $y2)) {
            if (isset($grid[$x2][$y2]) && $grid[$x2][$y2] != 9 && !isset($bassinPoints[$x2.','.$y2])) {
                $bassinPoints[$x2.','.$y2] = ['x' => $x2, 'y' => $y2, 'value' => $grid[$x2][$y2]];
                $stack[] = $bassinPoints[$x2.','.$y2];
                continue 2;
            }
        }

        array_pop($stack);
    }

    return $bassinPoints;
}