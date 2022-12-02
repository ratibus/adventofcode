<?php

// Part 1 solved in 12'
// Part 2 solved in 6'

$inputFile = __DIR__.'/input.txt';

$rounds = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$scoring1 = [
    'A X' => 1 + 3,
    'A Y' => 2 + 6,
    'A Z' => 3 + 0,
    'B X' => 1 + 0,
    'B Y' => 2 + 3,
    'B Z' => 3 + 6,
    'C X' => 1 + 6,
    'C Y' => 2 + 0,
    'C Z' => 3 + 3,
];

$scoring2 = [
    'A X' => 3 + 0,
    'A Y' => 1 + 3,
    'A Z' => 2 + 6,
    'B X' => 1 + 0,
    'B Y' => 2 + 3,
    'B Z' => 3 + 6,
    'C X' => 2 + 0,
    'C Y' => 3 + 3,
    'C Z' => 1 + 6,
];

// Part 1
$score = 0;
foreach ($rounds as $round) {
    $score += $scoring1[$round];
}
var_dump($score);

// Part 2 (same with another mapping)
$score = 0;
foreach ($rounds as $round) {
    $score += $scoring2[$round];
}
var_dump($score);