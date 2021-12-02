<?php

// Solved in 3 minutes

$inputFile = __DIR__.'/input.txt';

$position = 0;
$depth = 0;
$aim = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($instruction, $value) = explode(' ', $line);

    if ($instruction === 'forward') {
        $position += $value;
        $depth += $aim * $value;
    } elseif ($instruction === 'up') {
        $aim -= $value;
    } elseif ($instruction === 'down') {
        $aim += $value;
    } else {
        die($line);
    }
}
printf("position: %d\n", $position);
printf("depth: %d\n", $depth);

var_dump($position * $depth);