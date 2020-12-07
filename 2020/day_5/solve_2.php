<?php

// Solved in 4 minutes
$inputFile = __DIR__.'/input.txt';

$boardingPasses = getBoardingPasses($inputFile);

$seats = [];
foreach ($boardingPasses as $boardingPass) {
    $seats[$boardingPass['seat']] = $boardingPass['seat'];
}
asort($seats);

for ($i = 12; $i < 858; $i++) {
    if (!isset($seats[$i])) {
        printf("Seat %d available\n", $i);
    }
}

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
