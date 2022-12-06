<?php

// Part 1 solved in 8'
// Part 2 solved in 1'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$chars = str_split($lines[0]);

// Part 1
var_dump(findFirstPosition($chars, 4));

// Part 2
var_dump(findFirstPosition($chars, 14));

function findFirstPosition($chars, $length)
{
    for ($offset = $length; $offset < count($chars); $offset++) {

        $packet = array_slice($chars, $offset - $length, $length);

        if (count(array_unique($packet)) === $length) {
            return $offset;
        }
    }
}