<?php

// Solved in 15 minutes
$nbNice = 0;

foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $string) {

    $chars = str_split($string);
    $foundMatchingPair = false;
    foreach ($chars as $charIndex => $char) {
        if (!isset($chars[$charIndex+1])) break;
        $pair = $char.$chars[$charIndex+1];

        for ($shift = $charIndex + 2; $shift < count($chars); $shift++) {
            if (!isset($chars[$shift+1])) break;
            $matchingPair = $chars[$shift].$chars[$shift+1];
            if ($pair === $matchingPair) {
                $foundMatchingPair = true;
                break 2;
            }
        }
    }

    if (!$foundMatchingPair) continue;

    $repeatedLetters = false;
    foreach ($chars as $charIndex => $char) {
        if (!isset($chars[$charIndex+2])) break;

        if ($char === $chars[$charIndex+2]) {
            $repeatedLetters = true;
            break;
        }
    }
    if (!$repeatedLetters) continue;

    $nbNice++;
}

var_dump($nbNice);
