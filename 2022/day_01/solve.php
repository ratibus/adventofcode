<?php

// Part 1 solved in 3'
// Part 2 solved in 1'30

$inputFile = __DIR__.'/input.txt';

$content = file_get_contents($inputFile);

$elfves = explode("\n\n", $content);

$cals = [];
foreach ($elfves as $elf) {
    $cals[] = array_sum(explode("\n", $elf));
}

// Part 1 answer
var_dump(max($cals));

// Part 2 answer
rsort($cals);
var_dump($cals[0]+$cals[1]+$cals[2]);

