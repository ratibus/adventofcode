<?php

// Solved in 15 minutes
$lines = file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$departTime = (int)$lines[0];

$buses = array_filter(explode(',', $lines[1]), function ($v) {
    return $v !== 'x';
});

printf("Valid buses: %s\n", implode(',', $buses));

$nextDeparts = [];
$minBus = [];
foreach ($buses as $bus) {
    $nextDepart = ceil($departTime / $bus) * $bus;
    printf("Bus %d, next depart: %d\n", $bus, $nextDepart);
    $nextDeparts[$bus] = $nextDepart;

    if (!count($minBus) || $minBus["nextDepart"] > $nextDepart) {
        $minBus = ['bus' => $bus, 'nextDepart' => $nextDepart];
    }
}

var_dump($minBus['bus'] * ($minBus['nextDepart'] - $departTime));


