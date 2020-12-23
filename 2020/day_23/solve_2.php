<?php

// Not solved by my own (code from part 1 was too slow)
// Linked list approach borrowed from https://github.com/fdouw/aoc20/blob/master/day23 and other online sources

$input = '389125467'; // test
$input = '253149867';

$highestCup = 1000000;
$numbers = array_merge(str_split($input), range(10, $highestCup));
$nbCups = count($numbers);

// build of circular list
$cups = new SplFixedArray($nbCups+1); // Much faster than standard array (2 sec vs 3.3 sec)
foreach ($numbers as $numberIndex => $number) {
    $cups[$number] = (int)$numbers[($numberIndex+1)%$nbCups]; // modulo connects the last one to the first one
}

$currentCup = $numbers[0];
for ($round = 0; $round < 10000000; $round++) {

    $next = $cups[$currentCup];
    $nextNext = $cups[$next];
    $nextNextNext = $cups[$nextNext];

    // we make the current link 3 hops in one assignment (3 nodes are orphan but still in the array)
    $cups[$currentCup] = $cups[$nextNextNext];

    // find destination cup for the 3 cups
    $destinationCup = $currentCup-1;
    if ($destinationCup < 1) {
        $destinationCup = $highestCup;
    }
    while ($destinationCup === $next || $destinationCup === $nextNext || $destinationCup === $nextNextNext) {
        $destinationCup--;
        if ($destinationCup < 1) {
            $destinationCup = $highestCup;
        }
    }

    // we insert the 3 orphan nodes to the right place
    $oldDestinationNext = $cups[$destinationCup];
    $cups[$destinationCup] = $next; // $next is still "connected" to $nextNext and $nextNext to $nextNextNext
    $cups[$nextNextNext] = $oldDestinationNext;

    // the current cup is the next one
    $currentCup = $cups[$currentCup];
}

$nb1 = $cups[1];
$nb2 = $cups[$nb1];
var_dump($nb1, $nb2);
var_dump($nb1 * $nb2);