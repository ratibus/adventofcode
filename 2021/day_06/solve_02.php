<?php

// Solved in 30 minutes
// Quite ugly: I sliced the 256 days in two 128 days periods :)

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = [];
$fishes = explode(',', file_get_contents($inputFile));

$nbFishes = 0;
$fishesByAge = [];
foreach (aggregateByAge($fishes) as $initialAge => $nb) {
    $fishes = getFishesAfterPeriod(128, [$initialAge]);
    $nbFishes += $nb * count($fishes);

    foreach ($fishes as $fish) {
        if (!isset($fishesByAge[$fish])) {
            $fishesByAge[$fish] = 0;
        }
        $fishesByAge[$fish] += $nb;
    }
}

$nbFishes = 0;
foreach ($fishesByAge as $initialAge => $nb) {
    $fishes = getFishesAfterPeriod(128, [$initialAge]);
    $nbFishes += $nb * count($fishes);
}
var_dump($nbFishes);


function getFishesAfterPeriod($nbDays, $fishes) {
    for ($day = 1; $day <= $nbDays; $day++) {
        foreach ($fishes as $fishIndex => $fish) {
            if ($fish === 0) {
                $fishes[$fishIndex] = 7;
                $fishes[] = 8;
            }
            $fishes[$fishIndex]--;
        }
    }
    return $fishes;
}

function aggregateByAge($fishes) {
    $fishesByAge = [];
    foreach ($fishes as $fish) {
        if (!isset($fishesByAge[$fish])) {
            $fishesByAge[$fish] = 0;
        }
        $fishesByAge[$fish]++;
    }
    return $fishesByAge;
}