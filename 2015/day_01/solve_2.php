<?php

// Solved in 1 minute
$chars = file_get_contents(__DIR__.'/input.txt');

$level = 0;
foreach (str_split($chars) as $position => $char) {
    if ($char === '(') {
        $level++;
    } elseif($char === ')') {
        $level--;
    }

    if ($level < 0) {
        break;
    }
}

printf("Solution: %d\n", $position+1);