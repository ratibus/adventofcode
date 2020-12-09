<?php

// Solved in 16 minutes
$inputFile = __DIR__.'/input_test.txt';

$numbers = getNumbers($inputFile);
debug($numbers);

$invalidNumber = findInvalidNumber($numbers, 5); // 5 in the test file input, 25 in the real input file
var_dump($invalidNumber);

function findInvalidNumber($numbers, $maskSize) {

    $invalidNumber = null;
    for ($offset = $maskSize; $offset < count($numbers); $offset++) {
        $numberToCheck = $numbers[$offset];
        $mask = array_slice($numbers, $offset - $maskSize, $maskSize);
        debug("Offset: ".$offset);
        debug($mask);
        debug($numberToCheck);
        $isValid = checkNumber($mask, $numberToCheck);

        if (!$isValid) {
            $invalidNumber = $numberToCheck;
            break;
        }
    }
    return $invalidNumber;
}

function checkNumber($numbers, $numberToCheck) {
    debug("numberToCheck: ".$numberToCheck);
    for($i = 0; $i < count($numbers); $i++) {
        for($j = 0; $j < count($numbers); $j++) {
            if ($i === $j) continue;
            if ($numbers[$i] + $numbers[$j] == $numberToCheck) {
                return true;
            }
        }
    }
    return false;
}

function getNumbers($inputFile) {
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
