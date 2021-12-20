<?php

// Solved in few minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$numbers = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$maxMagnitude = 0;
foreach ($numbers as $numberIndex1 => $number1) {
    foreach ($numbers as $numberIndex2 => $number2) {
        if ($numberIndex1 === $numberIndex2) {
            continue;
        }
        $number = add($number1, $number2);
        $number = reduce($number);
        $maxMagnitude = max($maxMagnitude, magnitude($number));
    }
}
var_dump($maxMagnitude);

function reduce($number) {
    while (true) {
        $newNumber1 = explod($number);
        if ($newNumber1 !== $number) {
            $number = $newNumber1;
            continue;
        }
        $newNumber2 = split($newNumber1);
        if ($newNumber2 !== $newNumber1) {
            $number = $newNumber2;
            continue;
        }
        break;
    }
    return $number;
}

function add($n1, $n2) {
    return sprintf('[%s,%s]', $n1, $n2);
}

function explod($number) {
    $nb = preg_match_all('/\[\d+,\d+\]/', $number, $matches, PREG_OFFSET_CAPTURE);
    if (!$nb) {
        return $number;
    }

    foreach ($matches[0] as list($pair, $offset)) {
        $charsCounts = count_chars(substr($number, 0, $offset), 1);
        $depth = ($charsCounts[91] ?? 0) - ($charsCounts[93] ?? 0); // 91 is [ and 93 is ] is ASCII
        if ($depth < 4) { // not a valid pair
            continue;
        }

        list($left, $right) = explode(',', trim($pair, '[]'));

        $numberLeftPart = substr($number, 0, $offset);
        $numberRightPart = substr($number, $offset + strlen($pair));

        // Add left to the left part (the trick is to reverse the string)
        $numberLeftPart = strrev(preg_replace_callback('/\d+/', function($matches) use ($left) {
            return strrev($left+strrev($matches[0]));
        }, strrev($numberLeftPart), 1));

        // Add right to the right part
        $numberRightPart = preg_replace_callback('/\d+/', function($matches) use ($right) {
            return $right+$matches[0];
        }, $numberRightPart, 1);

        return sprintf('%s0%s', $numberLeftPart, $numberRightPart); // parts glueing and pair replaced by 0
    }

    return $number;
}

function magnitude($number) {
    do {
        $number = preg_replace_callback('/\[\d+,\d+\]/', function($matches) {
            list($left, $right) = explode(',', trim($matches[0], '[]'));
            return 3*$left + 2*$right;
        }, $number, -1, $count);
    } while ($count > 0);
    return $number;
}

function split($number) {
    return preg_replace_callback('/\d{2}/', function($matches) {
        $left = floor($matches[0]/2);
        $right = $matches[0] - $left;
        return add($left, $right);
    }, $number, 1);
}