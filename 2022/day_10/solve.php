<?php

// Part 1 solved in 12'
// Part 2 solved in 20'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$cycles = []; // Register values at the end of each cycle
$register = 1;
$crt = ['#'];
foreach ($lines as $line) {
    if ($line === 'noop') {
        $cycles[] = $register;
        $crt[] = abs(count($cycles)%40 - $register) > 1 ? '.' : '#';
    } else {
        list(,$addValue) = explode(' ', $line);

        $cycles[] = $register;
        $crt[] = abs(count($cycles)%40 - $register) > 1 ? '.' : '#';

        $register += $addValue;
        $cycles[] = $register;
        $crt[] = abs(count($cycles)%40 - $register) > 1 ? '.' : '#';
    }
}

// Part 1
$part1 = 0;
foreach ([20, 60, 100, 140, 180, 220] as $index) {
    $strength = $index * $cycles[$index - 2];
    $part1 += $strength;
}

var_dump($part1);

// Part 2
displayCrt(array_slice($crt, 0, 240));

function displayCrt($crt) {
    foreach (array_chunk($crt, 40) as $line) {
        echo implode('', $line), "\n";
    }
}
