<?php

// Solved in 6 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$folds = [];
$grid = [];
$gridSizeX = 0;
$gridSizeY = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $y => $line) {

    if (strpos($line, 'fold') === 0) {
        list(,,$fold) = explode(' ', $line);
        list($foldAxe, $foldCoord) = explode('=', $fold);
        $folds[] = ['axe' => $foldAxe, 'coord' => $foldCoord];
    } else {
        list($x, $y) = explode(',', $line);
        $grid[$y][$x] = true;

        $gridSizeX = max($x, $gridSizeX);
        $gridSizeY = max($y, $gridSizeY);
    }
}
$gridSizeX++;
$gridSizeY++;

foreach ($folds as $fold) {

    $newGrid = [];

    if ($fold['axe'] === 'y') {

        for ($y = 0; $y < $gridSizeY; $y++) {
            if ($y == $fold['coord']) {
                continue; // skip line on fold axe
            }

            for ($x = 0; $x < $gridSizeX; $x++) {

                if (!isset($grid[$y][$x])) {
                    continue;
                }
                $newY = $y < $fold['coord'] ? $y : $fold['coord'] - 1 - ($y - $fold['coord'] - 1);

                if ($newY < 0) {
                    continue;
                }

                $newGrid[$newY][$x] = true;
            }
        }
        $gridSizeY = $fold['coord'];

    } else {

        for ($y = 0; $y < $gridSizeY; $y++) {
            for ($x = 0; $x < $gridSizeX; $x++) {

                if ($x == $fold['coord']) {
                    continue; // skip column on fold axe
                }
                if (!isset($grid[$y][$x])) {
                    continue;
                }
                $newX = $x < $fold['coord'] ? $x : $fold['coord'] - 1 - ($x - $fold['coord'] - 1);

                if ($newX < 0) {
                    continue;
                }

                $newGrid[$y][$newX] = true;
            }
        }
        $gridSizeX = $fold['coord'];
    }
    $grid = $newGrid;
}

displayGrid($grid, $gridSizeX, $gridSizeY);

function displayGrid($grid, $gridSizeX, $gridSizeY) {
    echo "\n";
    for ($y = 0; $y < $gridSizeY; $y++) {
        for ($x = 0; $x < $gridSizeX; $x++) {
            echo isset($grid[$y][$x]) ? '#' : '.';
        }
        echo "\n";
    }
    echo "\n";
}