<?php

// Part 1 solved in 15'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$cubes = [];
$minX = $minY = $minZ = PHP_INT_MAX;
$maxX = $maxY = $maxZ = -PHP_INT_MAX;
$nbCubes = 0;
foreach ($lines as $line) {
    list($x, $y, $z) = explode(',', $line);
    $cubes[$x][$y][$z] = true;
    $minX = min($minX, $x);
    $minY = min($minY, $y);
    $minZ = min($minZ, $z);
    $maxX = max($maxX, $x);
    $maxY = max($maxY, $y);
    $maxZ = max($maxZ, $z);
    $nbCubes++;
}

// Part 1
var_dump(findExternalSurface($cubes));

// Part 2 flood fill
$explored = [];
$startPoint = [$maxX+1, $maxY+1, $maxZ+1];
explore($startPoint, $cubes, $explored, [$minX-1, $maxX+1, $minY-1, $maxY+1, $minZ-1, $maxZ+1]);

$insideAirCubes = [];
$outsideCubes = $cubes;
for ($x = $minX; $x <= $maxX; $x++) {
    for ($y = $minY; $y <= $maxY; $y++) {
        for ($z = $minZ; $z <= $maxZ; $z++) {
            if (isset($explored[$x][$y][$z])) {
                continue;
            }
            $insideAirCubes[$x][$y][$z] = true;

            if (isset($cubes[$x][$y][$z])) {
                unset($outsideCubes[$x][$y][$z]); // We have to exclude cubes trapped inside a bubble
            }
        }
    }
}

var_dump(findExternalSurface($outsideCubes) - findExternalSurface($insideAirCubes));

function explore($cube, $cubes, &$explored, $boundaries) {

    list($x, $y, $z) = $cube;

    foreach ([[-1, 0, 0], [1, 0, 0], [0, -1, 0], [0, 1, 0], [0, 0, -1], [0, 0, 1]] as [$deltaX, $deltaY, $deltaZ]) {
        if (isset($explored[$x + $deltaX][$y + $deltaY][$z + $deltaZ])) {
            continue; // already explored
        }
        if (isset($cubes[$x + $deltaX][$y + $deltaY][$z + $deltaZ])) {
            $explored[$x + $deltaX][$y + $deltaY][$z + $deltaZ] = true;
            continue; // occupied position
        }
        if ($x + $deltaX< $boundaries[0] || $x + $deltaX > $boundaries[1]) {
            continue; // out of X boundaries
        }
        if ($y + $deltaY < $boundaries[2] || $y + $deltaY > $boundaries[3]) {
            continue; // out of Y boundaries
        }
        if ($z + $deltaZ < $boundaries[4] || $z + $deltaZ > $boundaries[5]) {
            continue; // out of Z boundaries
        }
        $explored[$x + $deltaX][$y + $deltaY][$z + $deltaZ] = true;
        explore([$x + $deltaX, $y + $deltaY, $z + $deltaZ], $cubes, $explored, $boundaries);
    }
}

function findExternalSurface($cubes) {
    $surface = 0;
    foreach ($cubes as $x => $cubesX) {
        foreach ($cubesX as $y => $cubesY) {
            foreach ($cubesY as $z => $true) {
                $cubeSurface = 6;
                foreach ([[1, 0, 0], [-1, 0, 0], [0, 1, 0], [0, -1, 0], [0, 0, 1], [0, 0, -1]] as [$deltaX, $deltaY, $deltaZ]) {
                    if (isset($cubes[$x + $deltaX][$y + $deltaY][$z + $deltaZ])) {
                        $cubeSurface--;
                    }
                }
                $surface += $cubeSurface;
            }
        }
    }

    return $surface;
}