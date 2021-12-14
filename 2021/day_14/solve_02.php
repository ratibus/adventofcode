<?php

// Solved in 1 hour

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$template = [];
$templatePairs = [];
$pairs = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    if ($lineIndex == 0) {
        $template = str_split($line);

        for ($i = 0; $i < count($template) - 1; $i++) {
            $pair = $template[$i].$template[$i+1];
            if (!isset($templatePairs[$pair])) {
                $templatePairs[$pair] = 0;
            }
            $templatePairs[$pair]++;
        }

    } else {
        list($pair, $insertion) = explode(' -> ', $line);
        $pairs[$pair] = $insertion;
    }
}

for ($step = 1; $step <= 40; $step++) {

    $newTemplatePairs = [];
    foreach ($templatePairs as $templatePair => $nb) {

        $newPairs = [
            substr($templatePair, 0, 1).$pairs[$templatePair],
            $pairs[$templatePair].substr($templatePair, -1),
        ];

        foreach ($newPairs as $newPair) {
            $newTemplatePairs[$newPair] = ($newTemplatePairs[$newPair] ?? 0) + $nb;
        }
    }
    $templatePairs = $newTemplatePairs;
}

$frequencies = [];
foreach ($templatePairs as $templatePair => $nb) {
    foreach (str_split($templatePair) as $char) {
        $frequencies[$char] = ($frequencies[$char] ?? 0) + $nb/2;
    }
}

var_dump(ceil(max($frequencies)) - ceil(min($frequencies)));

