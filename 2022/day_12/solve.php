<?php

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$grid = [];
$start = $end = null;
foreach ($lines as $rowIndex => $row) {

    if (($startIndex = strpos($row, 'S')) !== false) {
        $start = [$rowIndex, $startIndex];
    }
    if (($endIndex = strpos($row, 'E')) !== false) {
        $end = [$rowIndex, $endIndex];
    }

    $row = strtr($row, 'SE', 'az');
    $grid[] = array_map('ord', str_split($row));
}

// Part 1
var_dump(bfs($grid, $start, $end));

// Part 2
$part2 = PHP_INT_MAX;
foreach ($grid as $rowIndex => $row) {
    foreach ($row as $colIndex => $col) {
        if ($col === ord('a')) {
            $bfs = bfs($grid, [$rowIndex, $colIndex], $end);
            if ($bfs === null) {
                continue;
            }
            $part2 = min($bfs, $part2);
        }
    }
}
var_dump($part2);

function bfs($grid, $start, $end) {

    $explored = [];
    $queue = [];
    $deltas = [[0, 1], [0, -1], [1, 0], [-1, 0]];

    $queue[] = [$start[0], $start[1], 0];
    $explored[$start[0].'|'.$start[1]] = true;
    while (count($queue)) {
        $node = array_shift($queue);

        if ($node[0] === $end[0] && $node[1] === $end[1]) {
            return $node[2];
        }

        foreach ($deltas as $delta) {
            $newY = $node[0] + $delta[0];
            $newX = $node[1] + $delta[1];
            if (!isset($grid[$newY][$newX])) {
                continue;
            }
            if (isset($explored[$newY.'|'.$newX])) {
                continue;
            }
            if ($grid[$newY][$newX] - $grid[$node[0]][$node[1]] > 1) {
                continue;
            }
            $queue[] = [$newY, $newX, $node[2]+1];
            $explored[$newY.'|'.$newX] = true;
        }
    }

    return null;
}