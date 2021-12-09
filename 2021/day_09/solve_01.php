<?php

// Solved in 6 minutes

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
        $lowPoints[] = $value;
    }
}

var_dump(array_sum($lowPoints) + count($lowPoints));