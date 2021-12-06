<?php

// Solved in 10 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = [];
$fishes = explode(',', file_get_contents($inputFile));

$nbDays = 80;

for ($day = 1; $day <= $nbDays; $day++) {
    foreach ($fishes as $fishIndex => $fish) {
        if ($fish === 0) {
            $fishes[$fishIndex] = 7;
            $fishes[] = 8;
        }
        $fishes[$fishIndex]--;
    }
}

var_dump(count($fishes));