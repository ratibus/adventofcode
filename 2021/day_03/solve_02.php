<?php

// Solved in 31 minutes

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$oxygenRatings = $lines;
$co2Ratings = $lines;

$numberLength = strlen($lines[0]);

// oxygen
for ($i = 0; $i < $numberLength; $i++) {

    // stats pass
    $stats = [0, 0];
    foreach ($oxygenRatings as $oxygenRating) {
        $bits = str_split($oxygenRating);
        $stats[$bits[$i]]++;
    }

    $mostCommonBit = $stats[0] > $stats[1] ? 0 : 1;

    // filter pass
    foreach ($oxygenRatings as $oxygenRatingKey => $oxygenRating) {
        $bits = str_split($oxygenRating);
        if (!(($stats[0] != $stats[1] && $bits[$i] == $mostCommonBit) || ($stats[0] == $stats[1] && $bits[$i] == 1))) {
            unset($oxygenRatings[$oxygenRatingKey]);
        }
    }
    if (count($oxygenRatings) == 1) {
        break;
    }
}

// co2
for ($i = 0; $i < $numberLength; $i++) {

    // stats pass
    $stats = [0, 0];
    foreach ($co2Ratings as $co2Rating) {
        $bits = str_split($co2Rating);
        $stats[$bits[$i]]++;
    }

    $leastCommonBit = $stats[0] < $stats[1] ? 0 : 1;

    // filter pass
    foreach ($co2Ratings as $co2RatingKey => $co2Rating) {
        $bits = str_split($co2Rating);
        if (!(($stats[0] != $stats[1] && $bits[$i] == $leastCommonBit) || ($stats[0] == $stats[1] && $bits[$i] == 0))) {
            unset($co2Ratings[$co2RatingKey]);
        }
    }
    if (count($co2Ratings) == 1) {
        break;
    }

}

var_dump(bindec(array_values($oxygenRatings)[0]) * bindec(array_values($co2Ratings)[0]));
