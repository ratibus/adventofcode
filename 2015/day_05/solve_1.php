<?php

// Solved in 9 minutes
$nbNice = 0;

foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $string) {
    preg_match_all('/[aeiou]/', $string, $matches);
    $nbVowels = count($matches[0] ?? []);
    if ($nbVowels < 3) continue;

    $lastChar = null;
    $consecutiveLetters = false;
    foreach (str_split($string) as $char) {
        if ($lastChar !== null && $char === $lastChar) {
            $consecutiveLetters = true;
            break;
        }
        $lastChar = $char;
    }
    if (!$consecutiveLetters) continue;

    $forbiddenFound = false;
    foreach (['ab', 'cd', 'pq', 'xy'] as $forbiddenString) {
        if (strpos($string, $forbiddenString) !== false) {
            $forbiddenFound = true;
            break;
        }
    }
    if ($forbiddenFound) continue;

    $nbNice++;
}

var_dump($nbNice);
