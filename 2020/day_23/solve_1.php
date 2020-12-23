<?php

// Solved in 51 minutes
$input = '389125467'; // test
$input = '253149867';

$nbCups = strlen($input);
$cups = str_split($input);
$currentIndex = 0;
for ($round = 0; $round < 100; $round++) {

    $currentCup = $cups[$currentIndex];

    // pick 3 cups from the $cups starting from $currentCup
    $pickUpCups = [];
    for ($i = 0; $i < 3; $i++) {
        $cupIndex = ($currentIndex + $i + 1) % $nbCups;
        $pickUpCups[] = $cups[$cupIndex];
        unset($cups[$cupIndex]);
    }

    // find destination index for the 3 cups
    $destinationCup = $currentCup-1;
    while (true) {
        foreach (array_values($cups) as $ci => $cv) {
            if ($cv == $destinationCup) {
                $cups = array_merge(array_slice($cups, 0, $ci + 1), $pickUpCups, array_slice($cups, $ci + 1));

                foreach ($cups as $nci => $ncv) {
                    if ($ncv == $currentCup) {
                        $currentIndex = ($nci + 1) % $nbCups;
                        break;
                    }
                }
                break 2;
            }
        }
        // if we reach here the $destinationCup is in pickUp cups
        $destinationCup--;
        if ($destinationCup < 1) {
            $destinationCup = 9;
        }
    }
}

// Find cup 1
foreach ($cups as $ci => $cv) {
    if ($cv == 1) {
        var_dump(implode('', array_merge(array_slice($cups, $ci + 1), array_slice($cups, 0, $ci))));
        break;
    }
}