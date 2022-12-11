<?php

// Part 1 solved in 38'
// Part 2 not solved :(

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$currentMonkey = null;
$monkeysConfigs = [];
$monkeysItems = [];
foreach ($lines as $line) {
    if (strpos($line, 'Monkey') === 0) {
        list(,$currentMonkey) = explode(' ', rtrim($line, ':'));
        continue;
    }
    if (strpos($line, 'Starting items') !== false) {
        list(,$items) = explode(':', $line);
        $monkeysItems[$currentMonkey] = explode(', ', trim($items));
    }
    if (strpos($line, 'Operation') !== false) {
        list(,$monkeysConfigs[$currentMonkey]['operation']) = explode('= ', $line);
    }
    if (strpos($line, 'Test') !== false) {
        list(,$monkeysConfigs[$currentMonkey]['test']) = explode(' divisible by ', $line);
    }
    if (strpos($line, 'If true') !== false) {
        list(,$monkeysConfigs[$currentMonkey]['test_true']) = explode(' throw to monkey ', $line);
    }
    if (strpos($line, 'If false') !== false) {
        list(,$monkeysConfigs[$currentMonkey]['test_false']) = explode(' throw to monkey ', $line);
    }
}

function getScore($monkeysConfigs, $monkeysItems, $nbRounds, $levelReduction) {
    $lcm = 1;
    foreach ($monkeysConfigs as $monkeyConfig) {
        $lcm *= $monkeyConfig['test']; // every test number is a prime number in our data
    }

    $inspectedCounts = array_fill(0, count($monkeysConfigs), 0);
    for ($round = 1; $round <= $nbRounds; $round++) {
        foreach ($monkeysConfigs as $monkeyIndex => $monkeyConfig) {

            $inspectedCounts[$monkeyIndex] += count($monkeysItems[$monkeyIndex]);

            foreach ($monkeysItems[$monkeyIndex] as $itemIndex => $item) {
                $new = computeOperation($monkeyConfig['operation'], $item);
                if ($levelReduction) {
                    $new = floor($new / 3);
                } else {
                    $new %= $lcm;
                }

                if ($new % $monkeyConfig['test'] === 0) {
                    $monkeysItems[$monkeyConfig['test_true']][] = $new;
                } else {
                    $monkeysItems[$monkeyConfig['test_false']][] = $new;
                }
                unset($monkeysItems[$monkeyIndex][$itemIndex]);
            }
        }
    }
    rsort($inspectedCounts);
    return $inspectedCounts[0] * $inspectedCounts[1];
}

// Part 1
var_dump(getScore($monkeysConfigs, $monkeysItems, 20, true));

// Part 2
var_dump(getScore($monkeysConfigs, $monkeysItems, 10000, false));

function computeOperation($operation, $old) {
    list($n1, $op, $n2) = explode(' ', $operation);

    if ($n1 === 'old') {
        $n1 = $old;
    }
    if ($n2 === 'old') {
        $n2 = $old;
    }

    if ($op === '+') {
        return $n1 + $n2;
    }
    if ($op === '*') {
        return $n1 * $n2;
    }
}
