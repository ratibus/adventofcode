<?php

// Solved in 36 minutes

$inputFile = __DIR__ . '/input_test2.txt';
$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$grid = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $y => $line) {
    foreach (str_split($line) as $x => $level) {
        $grid[$y][$x] = $level;
    }
}

$gridSize = count($grid);

$nbSteps = 100;
$nbFlashes = 0;
for ($i = 0; $i < $nbSteps; $i++) {
    $cellsToFlash = [];
    for ($y = 0; $y < $gridSize; $y++) {
        for ($x = 0; $x < $gridSize; $x++) {
            $grid[$y][$x]++;

            if ($grid[$y][$x] > 9) {
                $cellsToFlash[$y][$x] = true;
            }
        }
    }

    $flashedCells = [];
    while (count2d($cellsToFlash)) {
        foreach ($cellsToFlash as $y => $cells) {
            foreach ($cells as $x => $value) {
                for ($dy = -1; $dy <= 1; $dy++) {
                    for ($dx = -1; $dx <= 1; $dx++) {
                        if (($dy == 0 && $dx == 0) || !isset($grid[$y+$dy][$x+$dx])) {
                            continue;
                        }
                        $grid[$y+$dy][$x+$dx]++;

                        if ($grid[$y+$dy][$x+$dx] > 9 && !isset($flashedCells[$y+$dy][$x+$dx])) {
                            $cellsToFlash[$y+$dy][$x+$dx] = true;
                        }
                    }
                }
                $flashedCells[$y][$x] = true;
                unset($cellsToFlash[$y][$x]);
            }
        }
    }

    for ($y = 0; $y < $gridSize; $y++) {
        for ($x = 0; $x < $gridSize; $x++) {
            if ($grid[$y][$x] > 9) {
                $grid[$y][$x] = 0;
                $nbFlashes++;
            }
        }
    }
}

var_dump($nbFlashes);

function count2d($data) {
    $nb = 0;
    foreach($data as $data2) {
        $nb += count($data2);
    }
    return $nb;
}
