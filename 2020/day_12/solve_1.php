<?php

// Solved in 21 minutes
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
$directions = [0 => 'E', 90 => 'S', 180 => 'W', 270 => 'N'];
$currentDirection = 0;

foreach ($instructions as $instruction) {
    //print_r($instruction);
    switch ($instruction['action']) {
        case 'N':
            $y += $instruction['value'];
            break;
        case 'S':
            $y -= $instruction['value'];
            break;
        case 'E':
            $x += $instruction['value'];
            break;
        case 'W':
            $x -= $instruction['value'];
            break;
        case 'R':
            $currentDirection += $instruction['value'];
            $currentDirection = ($currentDirection + 360) % 360;
            break;
        case 'L':
            $currentDirection -= $instruction['value'];
            $currentDirection = ($currentDirection + 360) % 360;
            break;
        case 'F':
            $direction = $directions[$currentDirection];
            if ($direction === 'N') {
                $y += $instruction['value'];
            } elseif ($direction === 'S') {
                $y -= $instruction['value'];
            } elseif ($direction === 'E') {
                $x += $instruction['value'];
            } elseif ($direction === 'W') {
                $x -= $instruction['value'];
            }
            break;
    }
    //printf("x: %d, y: %d, direction: %s\n", $x, $y, $currentDirection);
}

var_dump(abs($x)+abs($y));
