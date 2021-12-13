<?php

// Solved in 6 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';
$inputFile = __DIR__ . '/input_big.txt';

$folds = [];
$grid = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $y => $line) {

    if (strpos($line, 'fold') === 0) {
        list(,,$fold) = explode(' ', $line);
        list($foldAxis, $foldCoord) = explode('=', $fold);
        $folds[] = ['axis' => $foldAxis, 'coord' => $foldCoord];
    } else {
        list($x, $y) = explode(',', $line);
        $grid[$y][$x] = $x;
    }
}

foreach ($folds as $fold) {
    $newGrid = [];

    foreach ($grid as $y => $row) {
        foreach ($row as $x) {
            if ($fold['axis'] === 'y') {
                $newY = $y < $fold['coord'] ? $y : 2 * $fold['coord'] - $y;
                $newGrid[$newY][$x] = $x;
            } else {
                $newX = $x < $fold['coord'] ? $x : 2 * $fold['coord'] - $x;
                $newGrid[$y][$newX] = $newX;
            }
        }
    }
    $grid = $newGrid;
}

displayGrid($grid);

function displayGrid($grid) {

    $maxY = max(array_keys($grid));
    $maxX = 0;
    foreach ($grid as $row) {
        foreach ($row as $x => $true) {
            $maxX = max($maxX, $x);
        }
    }
    echo "\n";
    for ($y = 0; $y <= $maxY; $y++) {
        for ($x = 0; $x <= $maxX; $x++) {
            echo isset($grid[$y][$x]) ? '#' : '.';
        }
        echo "\n";
    }
    echo "\n";
}