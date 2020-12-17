<?php

// Solved in 7 minutes (copy/paste from solve_1.php + add W dimension everywhere :D)
$grid = [];
foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    foreach (str_split($line) as $index => $state) {
        $grid[0][0][$lineIndex][$index] = $state === '#';
    }
}

for ($i = 0; $i < 6; $i++) {
    $grid = updateState($grid);
    $nbActivesCubes = countTotalActiveCubes($grid);
    printf("Iteration %d, %d active cubes\n", $i+1, $nbActivesCubes);
}

function updateState($grid) {
    $newGrid = $grid;

    $minMax = getGridMinMax($grid);

    foreach (range($minMax['minZ']-1, $minMax['maxZ']+1) as $z) {
        foreach (range($minMax['minW']-1, $minMax['maxW']+1) as $w) {
            foreach (range($minMax['minY']-1, $minMax['maxY']+1) as $y) {
                foreach (range($minMax['minX'] - 1, $minMax['maxX'] + 1) as $x) {
                    $nbActives = countActive($grid, $z, $w, $y, $x);

                    $currentState = $grid[$z][$w][$y][$x] ?? false;

                    if ($currentState) {
                        if (($nbActives === 2 || $nbActives === 3)) {
                            $newState = true;
                        } else {
                            $newState = false;
                        }
                    } elseif ($nbActives === 3) {
                        $newState = true;
                    } else {
                        $newState = $currentState;
                    }
                    $newGrid[$z][$w][$y][$x] = $newState;
                }
            }
        }
    }

    return $newGrid;
}

function getGridMinMax($grid) {
    $minZ = $maxZ = $minW = $maxW = $minY = $maxY = $minX = $maxX = 0;
    foreach ($grid as $z => $zInfos) {
        $minZ = min($minZ, $z);
        $maxZ = max($maxZ, $z);
        foreach ($zInfos as $w => $wInfos) {
            $minW = min($minW, $w);
            $maxW = max($maxW, $w);
            foreach ($wInfos as $y => $yInfos) {
                $minY = min($minY, $y);
                $maxY = max($maxY, $y);
                foreach ($yInfos as $x => $state) {
                    $minX = min($minX, $x);
                    $maxX = max($maxX, $x);
                }
            }
        }
    }

    return [
        'minZ' => $minZ, 'maxZ' => $maxZ, 'minW' => $minW, 'maxW' => $maxW,
        'minY' => $minY, 'maxY' => $maxY, 'minX' => $minX, 'maxX' => $maxX,
    ];
}

function countTotalActiveCubes($grid) {
    $nbActives = 0;
    foreach ($grid as $z => $zInfos) {
        foreach ($zInfos as $w => $wInfos) {
            foreach ($wInfos as $y => $yInfos) {
                foreach ($yInfos as $x => $state) {
                    if ($grid[$z][$w][$y][$x]) {
                        $nbActives++;
                    }
                }
            }
        }
    }
    return $nbActives;
}

function countActive($grid, $z, $w, $y, $x) {
    $delta = [-1, 0, 1];

    $nbActives = 0;
    foreach ($delta as $deltaZ) {
        foreach ($delta as $deltaW) {
            foreach ($delta as $deltaY) {
                foreach ($delta as $deltaX) {
                    if ($deltaZ === 0 && $deltaW === 0 && $deltaY === 0 && $deltaX === 0) continue;

                    if (isset($grid[$z + $deltaZ][$w + $deltaW][$y + $deltaY][$x + $deltaX])
                        && $grid[$z + $deltaZ][$w + $deltaW][$y + $deltaY][$x + $deltaX]) {

                        $nbActives++;
                    }
                }
            }
        }
    }

    return $nbActives;
}