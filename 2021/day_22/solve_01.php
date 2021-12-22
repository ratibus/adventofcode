<?php

// Solved in 15 minutes

$inputFile = __DIR__ . '/input_test_1.txt';
$inputFile = __DIR__ . '/input.txt';

$steps = [];
$xMin = $yMin = $zMin = PHP_INT_MAX;
$xMax = $yMax = $zMax = PHP_INT_MIN;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($type, $coords) = explode(' ', $line);
    $step = ['type' => $type === 'on'];
    list($x, $y, $z) = explode(',', $coords);
    list($step['xMin'], $step['xMax']) = explode('..', substr($x, 2));
    list($step['yMin'], $step['yMax']) = explode('..', substr($y, 2));
    list($step['zMin'], $step['zMax']) = explode('..', substr($z, 2));

    if (
        $step['xMin'] < -50 || $step['xMax'] > 50
        || $step['yMin'] < -50 || $step['yMax'] > 50
        || $step['zMin'] < -50 || $step['zMax'] > 50
    ) {
        continue;
    }
    $steps[] = $step;
}

$cubesLit = [];

foreach ($steps as $step) {
    for ($x = $step['xMin']; $x <= $step['xMax']; $x++) {
        for ($y = $step['yMin']; $y <= $step['yMax']; $y++) {
            for ($z = $step['zMin']; $z <= $step['zMax']; $z++) {
                $coords = implode('|', [$x, $y, $z]);

                if ($step['type']) {
                    $cubesLit[$coords] = true;
                } else {
                    unset($cubesLit[$coords]);
                }
            }
        }
    }
}

var_dump(count($cubesLit));