<?php

// Part 1 solved in 9'
// Part 2 solved in 5'

$inputFile = __DIR__.'/input.txt';

$racks = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$letters = array_merge(range('a', 'z'), range('A', 'Z'));
$scores = array_combine($letters, range(1, 52));

// Part 1
$score = 0;
foreach ($racks as $rack) {

    $chars = str_split($rack);
    list($sack1, $sack2) = array_chunk($chars, count($chars)/2);

    $intersect = array_unique(array_intersect($sack1, $sack2));

    foreach ($intersect as $letter) {
        $score += $scores[$letter];
    }
}
var_dump($score);

// Part 2
$score = 0;
foreach (array_chunk($racks, 3) as $rackGroup) {

    $intersect = array_unique(array_intersect(str_split($rackGroup[0]), str_split($rackGroup[1]), str_split($rackGroup[2])));

    foreach ($intersect as $letter) {
        $score += $scores[$letter];
    }
}
var_dump($score);
