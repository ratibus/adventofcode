<?php

// Part 1 solved in 45'
// Part 1 solved in 13'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$grid = [];

$maxY = -PHP_INT_MAX;
foreach ($lines as $line) {
    $points = array_map(function ($e) { return array_map('intval', explode(',', $e)); }, explode(" -> ", $line));

    for ($i = 1; $i < count($points); $i++) {
        foreach (range(min($points[$i][1], $points[$i-1][1]), max($points[$i][1], $points[$i-1][1])) as $y) {
            foreach (range(min($points[$i][0], $points[$i-1][0]), max($points[$i][0], $points[$i-1][0])) as $x) {
                $grid[$y][$x] = '#';
            }
            $maxY = max($maxY, $y);
        }
    }
}

// Part 1
var_dump(getNbRestedSand($grid, $maxY, false));

// Part 2
var_dump(getNbRestedSand($grid, $maxY, true));

function getNbRestedSand ($grid, $maxY, $hasFloor) {
    $deltas = [[0, 1], [-1, 1], [1, 1]];
    $nbSandBlocked = 0;

    while (true) { // Pour sand
        $sandX = 500;
        $sandY = 0;

        while (true) {

            $stopped = true;
            foreach ($deltas as [$dX, $dY]) {
                if (isset($grid[$sandY + $dY][$sandX + $dX])) {
                    continue;
                }
                if ($hasFloor && $sandY + $dY === $maxY + 2) {
                    continue; // Blocked by the floor
                }
                $sandY = $sandY + $dY;
                $sandX = $sandX + $dX;
                $stopped = false;
                break;
            }

            if ($stopped) {
                $grid[$sandY][$sandX] = 'o';
                $nbSandBlocked++;

                if ($sandX === 500 && $sandY === 0) {
                    break 2; // Blocked at the start
                }
                break;
            }

            if (!$hasFloor && $sandY === $maxY) {
                break 2;
            }
        }
    }
    return $nbSandBlocked;
}
