<?php

// Solved in 7 minutes

$inputFile = __DIR__.'/input.txt';

$bitsStats = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $bits = str_split($line);

    foreach ($bits as $position => $bit) {
        if (!isset($bitsStats[$position][$bit])) {
            $bitsStats[$position][$bit] = 0;
        }
        $bitsStats[$position][$bit]++;
    }
}

$gammaRate = '';
$epsilonRate = '';

foreach ($bitsStats as $position => $stats) {
    $gammaRate .= $stats[0] > $stats[1] ? '0' : '1';
    $epsilonRate .= $stats[0] > $stats[1] ? '1' : '0';
}

var_dump($gammaRate, $epsilonRate, bindec($gammaRate) * bindec($epsilonRate));