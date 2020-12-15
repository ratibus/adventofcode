<?php

// Solved in 8 minutes
$numbers = explode(',', $argv[1] ?? '');

$number = whichNumber($numbers, 30000000);
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

                // The only difference with whichNumber function in part 1, to avoid the array to get too big
                $lastSeen[$lastNumber] = [$lastTwoOccurrences[1]];
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