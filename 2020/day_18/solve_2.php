<?php

// Solved in 13 minutes
$lines = file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

/*
// Test operations
$lines = [
    '1 + 2 * 3 + 4 * 5 + 6', // 231
    '1 + (2 * 3) + (4 * (5 + 6))', // 51
    '5 + (8 * 3 + 9 + 3 * 4 * 3)', // 1445
    '5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))', // 669060
    '((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2', // 23340
];
*/

$ans = 0;
foreach ($lines as $line) {
    $line = str_replace(' ', '', $line);

    $workLine = protectAddition($line);
    while (strpos($workLine, '(') !== false) {
        $buffer = '';
        foreach (str_split($workLine) as $char) {
            if ($char === '(') {
                $buffer = '(';
            } elseif($char === ')') {
                $buffer .= ')';
                $workLine = protectAddition(str_replace($buffer, solve_operation($buffer), $workLine));
                break;
            } else {
                $buffer .= $char;
            }
        }
    }
    $ans += solve_operation($workLine);
}

var_dump($ans);

function protectAddition($line) {
    return preg_replace('/(\d+)\+(\d+)/', '($1+$2)', $line);
}

function solve_operation ($operation) {
    $ans = 0;
    $operation = strtr($operation, ['(' => '', ')' => '']);

    $operator = null;
    $number = '';
    foreach (str_split($operation) as $char) {
        if ($char === '+' || $char === '*') {
            if ($operator === '+') {
                $ans += (int)$number;
            } elseif($operator === '*') {
                $ans *= (int)$number;
            } else {
                $ans = (int)$number;
            }
            $operator = $char;
            $number = '';
        } else { //digit
            $number .= $char;
        }
    }

    // Last operation
    if ($operator === '+') {
        $ans += (int)$number;
    } elseif($operator === '*') {
        $ans *= (int)$number;
    } else {
        $ans = (int)$number;
    }

    return $ans;
}