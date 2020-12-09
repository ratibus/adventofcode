<?php

// Solved in 10 minutes
$inputFile = __DIR__.'/input.txt';

$numbers = getNumbers($inputFile);
debug($numbers);

$invalidNumber = findInvalidNumber($numbers, 25); // 5 in the test file input, 25 in the real input file
debug("invalidNumber: ".$invalidNumber);

$range = findRange($numbers, $invalidNumber);
debug($range);

var_dump(min($range) + max($range));

function findRange($numbers, $numberToFind) {
    debug('$numberToFind: '.$numberToFind);
    for($i = 0; $i < count($numbers); $i++) {
        $sum = 0;
        for($j = $i; $j < count($numbers); $j++) {
            $sum += $numbers[$j];
            debug (sprintf("i: %d, j: %d, sum: %d", $i, $j, $sum));
            if ($sum > $numberToFind) break;
            if ($sum == $numberToFind) {
                return array_slice($numbers, $i, $j - $i + 1);
            }
        }
    }
    return null;
}


function findInvalidNumber($numbers, $maskSize) {

    $invalidNumber = null;
    for ($offset = $maskSize; $offset < count($numbers); $offset++) {
        $numberToCheck = $numbers[$offset];
        $mask = array_slice($numbers, $offset - $maskSize, $maskSize);
        $isValid = checkNumber($mask, $numberToCheck);

        if (!$isValid) {
            $invalidNumber = $numberToCheck;
            break;
        }
    }
    return $invalidNumber;
}

function checkNumber($numbers, $numberToCheck) {
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
