<?php

$inputFile = __DIR__.'/input.txt';

$content = file_get_contents($inputFile);

$jets = str_split($content);

$maxHeight = 0; // Floor

$rockGrid = [];

$rocksSequence = [
    [[0, 0], [1, 0], [2, 0], [3, 0]],
    [[1, 0], [0, 1], [1, 1], [2, 1], [1, 2]],
    [[0, 0], [1, 0], [2, 0], [2, 1], [2, 2]],
    [[0, 0], [0, 1], [0, 2], [0, 3]],
    [[0, 0], [1, 0], [0, 1], [1, 1]],
];

$nbRocksToFall = 2022;
$step = 0;
for ($rockIndex = 0; $rockIndex < $nbRocksToFall; $rockIndex++) {
    $rockToFall = $rocksSequence[$rockIndex % count($rocksSequence)];

    $height = $maxHeight + 3;
    $deltaX = 2;
    while (true) { // Jet push + fall
        $push = $jets[$step % count($jets)];

        if ($push === '>') {
            $tempDeltaX = 1;
        } else {
            $tempDeltaX = -1;
        }
        $step++;

        // We simulate the move and try to find collision
        $collide = false;
        foreach ($rockToFall as [$rockX, $rockY]) {
            if (isset($rockGrid[$rockY + $height][$rockX + $deltaX + $tempDeltaX])) { // Collision to rocks
                $collide = true;
                break;
            }
            if ($rockX + $deltaX + $tempDeltaX === -1 || $rockX + $deltaX + $tempDeltaX === 7) { // Collision to walls
                $collide = true;
                break;
            }
        }

        if (!$collide) {
            $deltaX += $tempDeltaX;
        }

        // We try to fall
        $collide = false;
        foreach ($rockToFall as [$rockX, $rockY]) {
            if (isset($rockGrid[$rockY + $height - 1][$rockX + $deltaX])) { // Collision to rocks
                $collide = true;
                break;
            }
            if ($rockY + $height - 1 === -1) { // Collision to floor
                $collide = true;
                break;
            }
        }

        if (!$collide) {
            $height--;
        } else { // Rock is blocked
            foreach ($rockToFall as [$rockX, $rockY]) {
                $rockGrid[$rockY + $height][$rockX + $deltaX] = '#';
                $maxHeight = max($maxHeight, $rockY + $height + 1);
            }
            break;
        }
    }
}

// Part 1
var_dump($maxHeight);
