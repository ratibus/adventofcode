<?php

// Part 1 solved in 4'
// Part 2 solved in 2'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$nbFullOverlaps = 0;
$nbPartialOverlaps = 0;
foreach ($lines as $line) {
    list($assignment1, $assignment2) = explode(',', $line);
    list($min1, $max1) = explode('-', $assignment1);
    list($min2, $max2) = explode('-', $assignment2);

    if (($min1 >= $min2 && $max1 <= $max2) || ($min2 >= $min1 && $max2 <= $max1)) {
        $nbFullOverlaps++;
    }

    if ($min1 <= $max2 && $max1 >= $min2) {
        $nbPartialOverlaps++;
    }
}

// Part 1
var_dump($nbFullOverlaps);

// Part 2
var_dump($nbPartialOverlaps);
