<?php

// Part 1 solved in 15'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$cubes = [];
foreach ($lines as $line) {
    $cubes[] = explode(',', $line);
}

$surface = 0;
foreach ($cubes as $cubeIndex => [$cubeX, $cubeY, $cubeZ]) {

    $cubeSurface = 6;
    foreach ($cubes as $cubeIndex2 => [$cubeX2, $cubeY2, $cubeZ2]) {
        if ($cubeIndex === $cubeIndex2) {
            continue;
        }
        $distanceX = abs($cubeX2 - $cubeX);
        $distanceY = abs($cubeY2 - $cubeY);
        $distanceZ = abs($cubeZ2 - $cubeZ);

        if ($distanceX + $distanceY + $distanceZ === 1) { // 2 dimensions identical => touching cubes
            $cubeSurface--;
        }
    }
    $surface += $cubeSurface;
}

// Part 1
var_dump($surface);