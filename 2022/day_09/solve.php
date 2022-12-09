<?php

// Part 1 solved in 33'
// Part 2 solved in 9'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$moves = [];
foreach ($lines as $line) {
    list($dir, $size) = explode(' ', $line);
    $moves[] = ['dir' => $dir, 'size' => (int)$size];
}

function getVisitedSpots($moves, $nbFollowingKnots) {
    $dirOffsets = [
        'R' => [1, 0],
        'L' => [-1, 0],
        'U' => [0, 1],
        'D' => [0, -1],
    ];

    $positionH = [0, 0];
    $visitedSpots = ['0|0' => true];
    $positionFollowingKnots = array_fill(0, $nbFollowingKnots, [0, 0]);
    foreach ($moves as $move) {
        for ($step = 0; $step < $move['size']; $step++) {
            $positionH[0] += $dirOffsets[$move['dir']][0];
            $positionH[1] += $dirOffsets[$move['dir']][1];

            $relativeHead = $positionH;
            for ($i = 0; $i < $nbFollowingKnots; $i++) {
                $horizontalDelta = $relativeHead[0] - $positionFollowingKnots[$i][0];
                $verticalDelta = $relativeHead[1] - $positionFollowingKnots[$i][1];
                $globalDistance = max(abs($horizontalDelta), abs($verticalDelta));
                if ($globalDistance > 1) {
                    $positionFollowingKnots[$i][0] += min(1, abs($horizontalDelta)) * sign($horizontalDelta);
                    $positionFollowingKnots[$i][1] += min(1, abs($verticalDelta)) * sign($verticalDelta);
                }
                $relativeHead = $positionFollowingKnots[$i];
            }

            $visitedSpots[$relativeHead[0].'|'.$relativeHead[1]] = true;
        }
    }

    return $visitedSpots;
}

function sign($n) { // https://stackoverflow.com/a/20460461
    return ($n > 0) - ($n < 0);
}

// Part 1
var_dump(count(getVisitedSpots($moves, 1)));

// Part 2
var_dump(count(getVisitedSpots($moves, 9)));
