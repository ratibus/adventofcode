<?php

// Solved in 5 minutes
$chars = file_get_contents(__DIR__.'/input.txt');

$grid = [];
$x = 0;
$y = 0;
$grid[$x.'|'.$y] = true;
foreach (str_split($chars) as $char) {
    if ($char === '<') {
        $x--;
    } elseif($char === '^') {
        $y++;
    } elseif($char === '>') {
        $x++;
    } elseif($char === 'v') {
        $y--;
    }
    $grid[$x.'|'.$y] = true;
}

printf("Solution: %d\n", count($grid));