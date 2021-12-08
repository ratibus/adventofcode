<?php

// Solved in 13 minutes (8 minutes reading instructions :o)

// 0 => 6 segments
// 1 => 2 segments => unique
// 2 => 5 segments
// 3 => 5 segments
// 4 => 4 segments => unique
// 5 => 5 segments
// 6 => 6 segments
// 7 => 3 segments => unique
// 8 => 7 segments => unique
// 9 => 6 segments

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$nbEasyDigits = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    list (, $outputValues) = explode(' | ', $line);
    $outputValues = explode(' ', $outputValues);

    foreach ($outputValues as $outputValue) {
        if (in_array(strlen($outputValue), [2, 3, 4, 7])) {
            $nbEasyDigits++;
        }
    }
}

var_dump($nbEasyDigits);