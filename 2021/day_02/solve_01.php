<?php

// Solved in 4 minutes

$inputFile = __DIR__.'/input.txt';

$position = 0;
$depth = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($instruction, $value) = explode(' ', $line);

    if ($instruction === 'forward') {
        $position += $value;
    } elseif ($instruction === 'up') {
        $depth -= $value;
    } elseif ($instruction === 'down') {
        $depth += $value;
    } else {
        die($line);
    }
}
printf("position: %d\n", $position);
printf("depth: %d\n", $depth);

var_dump($position * $depth);