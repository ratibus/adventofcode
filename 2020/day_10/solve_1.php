<?php

// Solved in 18 minutes
$inputFile = __DIR__.'/input.txt';

$ratings = getRawRatings($inputFile);
debug($ratings);

$chargingOutletRating = 0;
$builtInRating = max($ratings) + 3;

$differences = getDifferences(array_merge($ratings, [$chargingOutletRating, $builtInRating]));
debug($differences);
var_dump($differences[1] * $differences[3]);

function getDifferences($ratings) {

    $differences = [];
    sort($ratings);

    foreach ($ratings as $rating) {
        debug("Rating : ".$rating);
        foreach ($ratings as $rating2) {
            $difference = $rating2 - $rating;
            if ($difference > 0 && $difference <= 3) {
                debug("Adapter found: ".$rating2.", difference: ".$difference);
                if (!isset($differences[$difference])) {
                    $differences[$difference] = 0;
                }
                $differences[$difference]++;
                break;
            }
        }
    }

    return $differences;
}

function getRawRatings($inputFile) {
    return file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}


function debug($v) {
    return;
    if (is_array($v)) {
        print_r($v);
    } else {
        var_dump($v);
    }
}
