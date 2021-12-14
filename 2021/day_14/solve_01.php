<?php

// Solved in 15 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$template = [];
$pairs = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    if ($lineIndex == 0) {
        $template = str_split($line);

    } else {
        list($pair, $insertion) = explode(' -> ', $line);
        $pairs[$pair] = $insertion;
    }
}

for ($step = 1; $step <= 10; $step++) {

    $newTemplate = [];
    for ($i = 0; $i < count($template) - 1; $i++) {
        $newTemplate[] = $template[$i];
        $newTemplate[] = $pairs[$template[$i].$template[$i+1]];
    }
    $newTemplate[] = $template[count($template) - 1];
    $template = $newTemplate;
}

$frequencies = [];
foreach ($template as $char) {
    if (!isset($frequencies[$char])) {
        $frequencies[$char] = 0;
    }
    $frequencies[$char]++;
}

var_dump(max($frequencies) - min($frequencies));

