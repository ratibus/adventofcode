<?php

// Solved in 14 minutes
$inputFile = __DIR__.'/input.txt';

$boardingPasses = getBoardingPasses($inputFile);

$seats = [];
foreach ($boardingPasses as $boardingPass) {
    $seats[] = $boardingPass['seat'];
}

var_dump(max($seats));


function getBoardingPasses($inputFile) {

    $boardingPasses = [];

    foreach (file($inputFile, FILE_IGNORE_NEW_LINES) as $line) {
        $line = trim($line);

        $rowStr = substr($line, 0, 7);
        $rowBin = strtr($rowStr, ['B' => 1, 'F' => 0]);
        $row = bindec($rowBin);

        $columnStr = substr($line, -3);
        $columnBin = strtr($columnStr, ['R' => 1, 'L' => 0]);
        $column = bindec($columnBin);

        $boardingPasses[] = [
            'boarding_pass' => $line,
            'row' => $row,
            'column' => $column,
            'seat' => 8 * $row + $column,
        ];
    }

    return $boardingPasses;
}

function debug($v) {
    print_r($v);
}
