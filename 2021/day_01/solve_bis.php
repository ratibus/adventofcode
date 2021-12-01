<?php

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$windowSize = 1; // part 1
$windowSize = 3; // part 2
$nbIncreases = 0;
for ($i = $windowSize; $i < count($lines); $i++) {
    if ($lines[$i] > $lines[$i-$windowSize]) {
        $nbIncreases++;
    }
}

var_dump($nbIncreases);