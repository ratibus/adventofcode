<?php

// Solved in 4'20

$inputFile = __DIR__.'/input.txt';

$lastValue = null;
$nbIncreases = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if ($lastValue && $line > $lastValue) {
        $nbIncreases++;
    }
    $lastValue = $line;
}

var_dump($nbIncreases);