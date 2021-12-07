<?php

// Solved in 6 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$positions = explode(',', file_get_contents($inputFile));

$fuels = [];
for ($i = min($positions); $i <= max($positions); $i++) {
    $fuel = 0;
    foreach ($positions as $position) {
        // Gauss formula for consecutive numbers
        $fuel += (abs($position - $i) / 2)*(1 + abs($position - $i));
    }
    $fuels[$i] = $fuel;
}

var_dump(min($fuels));