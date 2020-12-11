<?php

// Solved in 3 minutes
$chars = file_get_contents(__DIR__.'/input.txt');

$level = 0;
foreach (str_split($chars) as $char) {
    if ($char === '(') {
        $level++;
    } elseif($char === ')') {
        $level--;
    }
}

printf("Solution: %d\n", $level);