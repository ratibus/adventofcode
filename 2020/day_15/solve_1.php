<?php

// Solved in 19 minutes
$numbers = explode(',', $argv[1] ?? '');

$number = whichNumber($numbers, 2020);
var_dump($number);

function whichNumber($numbers, $at) {

    $lastSeen = [];
    $lastNumber = null;
    for ($i = 0; $i < $at; $i++) {

        if ($i < count($numbers)) {
            $number = $numbers[$i];
        } elseif (isset($lastSeen[$lastNumber])) {
            if (count($lastSeen[$lastNumber]) > 1) {
                $lastTwoOccurrences = array_slice($lastSeen[$lastNumber], -2, 2);
                $number = $lastTwoOccurrences[1] - $lastTwoOccurrences[0];
            } else {
                $number = 0;
            }
        } else {
            $number = 0;
        }
        $lastSeen[$number][] = $i;
        $lastNumber = $number;
        //printf("Turn %s: number %d\n", $i, $number);
    }
    return $number;
}