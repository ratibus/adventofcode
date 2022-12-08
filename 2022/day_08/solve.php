<?php

// Part 1 solved in 41'
// Part 2 solved in 40'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$gridWidth = strlen($lines[0]);
$gridHeight = count($lines);

$grid = [];
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $treeSize) {
        $grid[$y][$x] = $treeSize;
    }
}

// Part 1
$visibleTrees = [];

// Horizontal scans
for ($y = 0; $y < $gridHeight; $y++) {

    // Scan from the left
    $currentLevel = -1;
    for ($x = 0; $x < $gridWidth; $x++) {
        if ($grid[$y][$x] <= $currentLevel) {
            continue;
        }
        $visibleTrees[$x.'|'.$y] = true;
        $currentLevel = max($currentLevel, $grid[$y][$x]);
    }

    // Scan from the right
    $currentLevel = -1;
    for ($x = $gridWidth - 1; $x >= 0; $x--) {
        if ($grid[$y][$x] <= $currentLevel) {
            continue;
        }
        $visibleTrees[$x.'|'.$y] = true;
        $currentLevel = max($currentLevel, $grid[$y][$x]);
    }

}

// Vertical scans
for ($x = 0; $x < $gridWidth; $x++) {

    // Scan from the top
    $currentLevel = -1;
    for ($y = 0; $y < $gridHeight; $y++) {
        if ($grid[$y][$x] <= $currentLevel) {
            continue;
        }
        $visibleTrees[$x.'|'.$y] = true;
        $currentLevel = max($currentLevel, $grid[$y][$x]);
    }

    // Scan from the bottom
    $currentLevel = -1;
    for ($y = $gridHeight - 1; $y >= 0; $y--) {
        if ($grid[$y][$x] <= $currentLevel) {
            continue;
        }
        $visibleTrees[$x.'|'.$y] = true;
        $currentLevel = max($currentLevel, $grid[$y][$x]);
    }
}

var_dump(count($visibleTrees));

// Part 2
$maxGridScore = 0;
for ($y = 0; $y < $gridHeight; $y++) {
    for ($x = 0; $x < $gridWidth; $x++) {

        $scores = ['up' => 0, 'left' => 0, 'right' => 0, 'down' => 0];

        for ($x2 = $x - 1; $x2 >= 0; $x2--) {
            $scores['left']++;
            if ($grid[$y][$x2] >= $grid[$y][$x]) {
                break;
            }
        }

        for ($x2 = $x + 1; $x2 < $gridWidth; $x2++) {
            $scores['right']++;
            if ($grid[$y][$x2] >= $grid[$y][$x]) {
                break;
            }
        }

        for ($y2 = $y - 1; $y2 >= 0; $y2--) {
            $scores['up']++;
            if ($grid[$y2][$x] >= $grid[$y][$x]) {
                break;
            }
        }

        for ($y2 = $y + 1; $y2 < $gridHeight; $y2++) {
            $scores['down']++;
            if ($grid[$y2][$x] >= $grid[$y][$x]) {
                break;
            }
        }

        $maxGridScore = max($maxGridScore, $scores['up'] * $scores['down'] * $scores['left'] * $scores['right']);
    }
}

var_dump($maxGridScore);