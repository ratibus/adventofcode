<?php

// Solved in 10 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$illegalCharsScore = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$openChars = ['(', '[', '{', '<'];
$closeChars = array_keys($illegalCharsScore);
$charsPairsOpenToClose = array_combine($openChars, $closeChars);

$score = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {

    $openedChars = [];
    foreach (str_split($line) as $char) {
        if (isset($charsPairsOpenToClose[$char])) { // open char
            $openedChars[] = $char;
        } else { // close char
            $lastOpenChar = array_pop($openedChars);
            if ($charsPairsOpenToClose[$lastOpenChar] != $char) {
                $score += $illegalCharsScore[$char];
                break;
            }
        }
    }
}

var_dump($score);