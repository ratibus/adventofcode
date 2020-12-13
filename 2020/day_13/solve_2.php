<?php

// Solved in 30 minutes for examples but too slow for real input file :/
$lines = file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

//test data
$values = [
    '7,13,x,x,59,x,31,19' => 1068781,
    '17,x,13,19' => 3417,
    '67,7,x,59,61' => 1261476,
    '67,x,7,59,61' => 779210,
    '67,7,59,61' => 754018,
    '1789,37,47,1889' => 1202161486,
];

foreach ($values as $line => $expectedSolution) {
    $solution = findTimestamp($line);
    if ($solution != $expectedSolution) {
        printf("Line %s failed (expected %d, got %d)\n", $line, $expectedSolution, $solution);
    } else {
        printf("Line %s succeeded\n", $line);
    }
}


/**
 * Too slow for real input data
 */
//$solution = findTimestamp($lines[1]);
//var_dump($solution);

function findTimestamp ($rawBuses) {

    $buses = [];
    foreach (explode(',', $rawBuses) as $bIndex => $b) {
        if ($b !== 'x') {
            $buses[$bIndex] = $b;
        }
    }

    $departTime = 0;
    $failedTime = null;
    $iteration = 0;
    while (true) {
        $iteration++;

        if (null !== $failedTime) {
            $departTime = (intval($failedTime / $buses[0]) + 1) * $buses[0];
        }
        $foundSequence = true;
        $newAttempt = $departTime;
        //printf("New attempt at time: %d\n", $newAttempt);
        foreach ($buses as $busIndex => $bus) {
            if ($busIndex === 0) continue;

            $nextDepart = ceil($departTime / $bus) * $bus;

            if ($nextDepart - $departTime != $busIndex) {
                $foundSequence = false;
                $failedTime = $newAttempt;
                //printf("Bus %d failed at %d\n", $busIndex, $failedTime);
                break;
            }
        }

        if ($foundSequence) break;
    }

    return $newAttempt;
}
