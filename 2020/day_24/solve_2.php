<?php

// Solved in 16 minutes
$lines = file(__DIR__.'/'.$argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$instructions = [];
foreach ($lines as $line) {
    $chars = str_split($line);

    $steps = [];
    for ($i = 0; $i < count($chars); $i++) {
        $step = $chars[$i];
        if ($chars[$i] === 's' || $chars[$i] === 'n') {
            $step .= $chars[$i + 1];
            $i++;
        }
        $steps[] = $step;
    }
    $instructions[] = $steps;
}

$blacks = [];
$nbBlacks = 0;
foreach ($instructions as $instruction) {
    $x = $y = 0;
    foreach ($instruction as $step) {
        if ($step === 'e') {
            $x += 2;
        } elseif ($step === 'w') {
            $x -= 2;
        } elseif ($step === 'ne') {
            $x++;
            $y++;
        } elseif ($step === 'nw') {
            $x--;
            $y++;
        } elseif ($step === 'se') {
            $x++;
            $y--;
        } elseif ($step === 'sw') {
            $x--;
            $y--;
        }
    }

    if (isset($blacks[$x][$y])) {
        unset($blacks[$x][$y]);
        $nbBlacks--;
    } else {
        $blacks[$x][$y] = true;
        $nbBlacks++;
    }
}

$deltas = [[2, 0], [-2, 0], [1, 1], [-1, 1], [1, -1], [-1, -1]];
for ($day = 1; $day <= 100; $day++) {

    $newBlacks = [];
    $whiteNeighbors = [];
    $nbNewBlacks = 0;
    foreach ($blacks as $x => $xBlacks) {
        foreach ($xBlacks as $y => $true) {
            $nbBlackNeighbors = 0;
            foreach ($deltas as $delta) {
                if (isset($blacks[$x+$delta[0]][$y+$delta[1]])) {
                    $nbBlackNeighbors++;
                } else {
                    $whiteNeighbors[$x+$delta[0]][$y+$delta[1]] = true;
                }
            }
            if ($nbBlackNeighbors === 1 || $nbBlackNeighbors === 2) {
                $newBlacks[$x][$y] = true;
                $nbNewBlacks++;
            }
        }
    }

    foreach ($whiteNeighbors as $x => $xWhite) {
        foreach ($xWhite as $y => $true) {
            $nbBlackNeighbors = 0;
            foreach ($deltas as $delta) {
                if (isset($blacks[$x+$delta[0]][$y+$delta[1]])) {
                    $nbBlackNeighbors++;
                }
            }
            if ($nbBlackNeighbors === 2) {
                $newBlacks[$x][$y] = true;
                $nbNewBlacks++;
            }
        }
    }

    $blacks = $newBlacks;
    printf("Day %d: %d\n", $day, $nbNewBlacks);
}