<?php

// Solved in 10 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$closeCharsScore = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

$openChars = ['(', '[', '{', '<'];
$closeChars = array_keys($closeCharsScore);
$charsPairsOpenToClose = array_combine($openChars, $closeChars);

$scores = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {

    $openedChars = [];
    foreach (str_split($line) as $char) {
        if (isset($charsPairsOpenToClose[$char])) { // open char
            $openedChars[] = $char;
        } else { // close char
            $lastOpenChar = array_pop($openedChars);
            if ($charsPairsOpenToClose[$lastOpenChar] != $char) { // corrupted line
                continue 2; // skip to next line
            }
        }
    }

    $score = 0;
    foreach (array_reverse($openedChars) as $openedChar) {
        $score *= 5;
        $score += $closeCharsScore[$charsPairsOpenToClose[$openedChar]];
    }
    $scores[] = $score;
}
sort($scores);

var_dump($scores[floor(count($scores)/2)]);
