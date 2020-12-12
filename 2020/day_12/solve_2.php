<?php

// Solved in 26 minutes
$lines = file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

$instructions = [];
foreach ($lines as $line) {
    $action = substr($line, 0, 1);
    $value = substr($line, 1);

    $instructions[] = [
        'action' => $action,
        'value' => $value,
    ];
}

$x = 0;
$y = 0;
$deltaX = 10;
$deltaY = 1;

//printf("x: %d, y: %d, dX: %d, dY: %d\n", $x, $y, $deltaX, $deltaY);
foreach ($instructions as $instruction) {
    $currentDeltaX = $deltaX;
    $currentDeltaY = $deltaY;
    switch ($instruction['action']) {
        case 'N':
            $deltaY += $instruction['value'];
            break;
        case 'S':
            $deltaY -= $instruction['value'];
            break;
        case 'E':
            $deltaX += $instruction['value'];
            break;
        case 'W':
            $deltaX -= $instruction['value'];
            break;
        case 'R':
            for ($i = 0; $i < $instruction['value']/90; $i++) {
                $tmp = $deltaX;
                $deltaX = $deltaY;
                $deltaY = -$tmp;
            }
            break;
        case 'L':
            for ($i = 0; $i < $instruction['value']/90; $i++) {
                $tmp = $deltaX;
                $deltaX = -$deltaY;
                $deltaY = $tmp;
            }
            break;
        case 'F':
            $x += $deltaX*$instruction['value'];
            $y += $deltaY*$instruction['value'];
            break;
    }
    //printf("x: %d, y: %d, dX: %d, dY: %d\n", $x, $y, $deltaX, $deltaY);
}
var_dump(abs($x)+abs($y));