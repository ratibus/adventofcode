<?php

// Not solved by myself, implemented in PHP from https://www.youtube.com/watch?v=YKpViLcTp64

$inputFile = __DIR__ . '/input_test_2.txt';
$inputFile = __DIR__ . '/input.txt';

$steps = [];
$Xs = $Ys = $Zs = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($type, $coords) = explode(' ', $line);
    $step = ['type' => $type === 'on'];
    list($x, $y, $z) = explode(',', $coords);
    list($step['xMin'], $step['xMax']) = explode('..', substr($x, 2));
    list($step['yMin'], $step['yMax']) = explode('..', substr($y, 2));
    list($step['zMin'], $step['zMax']) = explode('..', substr($z, 2));
    $step['xMax']++;
    $step['yMax']++;
    $step['zMax']++;
    $Xs[$step['xMin']] = true; $Xs[$step['xMax']] = true;
    $Ys[$step['yMin']] = true; $Ys[$step['yMax']] = true;
    $Zs[$step['zMin']] = true; $Zs[$step['zMax']] = true;
    $steps[] = $step;
}
$Xs = array_keys($Xs); sort($Xs); $XIndex = array_flip($Xs);
$Ys = array_keys($Ys); sort($Ys); $YIndex = array_flip($Ys);
$Zs = array_keys($Zs); sort($Zs); $ZIndex = array_flip($Zs);

$metaCubesLit = [];
foreach ($steps as $stepIndex => $step) {
    for ($x = $XIndex[$step['xMin']]; $x < $XIndex[$step['xMax']]; $x++) {
        for ($y = $YIndex[$step['yMin']]; $y < $YIndex[$step['yMax']]; $y++) {
            for ($z = $ZIndex[$step['zMin']]; $z < $ZIndex[$step['zMax']]; $z++) {
                if ($step['type']) {
                    $metaCubesLit[$x][$y][$z] = true;
                } else {;
                    unset($metaCubesLit[$x][$y][$z]);
                }
            }
        }
    }
}

$nbCubesLit = 0;
foreach ($metaCubesLit as $x => $xData) {
    foreach ($xData as $y => $yData) {
        foreach ($yData as $z => $true) {
            $nbCubesLit += ($Xs[$x + 1] - $Xs[$x]) * ($Ys[$y + 1] - $Ys[$y]) * ($Zs[$z + 1] - $Zs[$z]);
        }
    }
}
var_dump($nbCubesLit);
