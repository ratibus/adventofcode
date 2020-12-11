<?php

// Solved in 4 minutes
$chars = file_get_contents(__DIR__.'/input.txt');

$grid = [];
$x1 = 0;
$y1 = 0;
$x2 = 0;
$y2 = 0;
$grid['0|0'] = true;
foreach (str_split($chars) as $charIndex => $char) {
    if ($charIndex % 2 == 0) {
        if ($char === '<') {
            $x1--;
        } elseif($char === '^') {
            $y1++;
        } elseif($char === '>') {
            $x1++;
        } elseif($char === 'v') {
            $y1--;
        }
        $grid[$x1.'|'.$y1] = true;
    } else {
        if ($char === '<') {
            $x2--;
        } elseif($char === '^') {
            $y2++;
        } elseif($char === '>') {
            $x2++;
        } elseif($char === 'v') {
            $y2--;
        }
        $grid[$x2.'|'.$y2] = true;
    }

}

printf("Solution: %d\n", count($grid));