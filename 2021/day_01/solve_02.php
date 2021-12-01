<?php

// Solved in 10'30

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$values = [];
for ($i = 0; $i < count($lines); $i++) {
    if (!isset($lines[$i+2])) continue;
    $values[] = $lines[$i] + $lines[$i+1] + $lines[$i+2];
}

$lastValue = null;
$nbIncreases = 0;
foreach ($values as $value) {
    if ($lastValue && $value > $lastValue) {
        $nbIncreases++;
    }
    $lastValue = $value;
}

var_dump($nbIncreases);