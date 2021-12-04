<?php

// Solved in 37 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$numbers = [];
$boards = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    if ($lineIndex === 0) {
        $numbers = explode(',', $line);
        continue;
    }

    $boardIndex = floor(($lineIndex - 1) / 5);
    $boardRowIndex = ($lineIndex - 1) % 5;

    $boardNumbers = array_values(array_filter(array_map('trim', explode(' ', $line)), function($a) {
        return $a !== '';
    }));
    $boards[$boardIndex][$boardRowIndex] = $boardNumbers;
}

$boardsUnmarkedSum = array_fill_keys(array_keys($boards), 0);
foreach ($boards as $boardIndex => $board) {
    foreach ($board as $boardRowIndex => $boardRow) {
        $boardsUnmarkedSum[$boardIndex] += array_sum($boardRow);
    }
}
foreach ($numbers as $number) {
    foreach ($boards as $boardIndex => $board) {
        foreach ($board as $boardRowIndex => $boardRow) {
            foreach ($boardRow as $boardColumnIndex => $value) {
                if ($value == $number) {
                    $boardsUnmarkedSum[$boardIndex] -= $number;
                    $boards[$boardIndex][$boardRowIndex][$boardColumnIndex] = null;
                }
            }
        }

        for ($i = 0; $i < 5; $i++) {
            $nbHorizontalNulls = 0;
            $nbVerticalNulls = 0;
            for ($j = 0; $j < 5; $j++) {
                if ($boards[$boardIndex][$i][$j] === null) {
                    $nbHorizontalNulls++;
                }
                if ($boards[$boardIndex][$j][$i] === null) {
                    $nbVerticalNulls++;
                }
            }
            if ($nbHorizontalNulls === 5) {
                printf("Horizontal win. Score: %d\n", $number * $boardsUnmarkedSum[$boardIndex]);
                break 3;
            }
            if ($nbVerticalNulls === 5) {
                printf("Vertical win. Score: %d\n", $number * $boardsUnmarkedSum[$boardIndex]);
                break 3;
            }
        }

    }
}
