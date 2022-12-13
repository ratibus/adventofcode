<?php

// Part 1 solved in 42'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$packets = array_map('json_decode', $lines);

// Part 1
$pairs = array_chunk($packets, 2);

$part1 = 0;
foreach ($pairs as $pairIndex => [$elm1, $elm2]) {
    if (compare($elm1, $elm2)) {
        $part1 += $pairIndex + 1;
    }
}
var_dump($part1);

// Part 2
$packets[] = [[2]];
$packets[] = [[6]];

usort($packets, 'compare');
$packets = array_reverse($packets);

var_dump((array_search([[2]], $packets) + 1) * (array_search([[6]], $packets) + 1));

function compare($v1, $v2) {

    if (is_int($v1) && is_int($v2)) {
        if ($v1 < $v2) {
            return true;
        }
        if ($v1 > $v2) {
            return false;
        }
        return null;
    }

    if (is_array($v1) && is_array($v2)) {
        foreach ($v1 as $v11Index => $v11) {

            if (!isset($v2[$v11Index])) {
                return false;
            }

            $sub = compare($v11, $v2[$v11Index]);
            if ($sub !== null) {
                return $sub;
            }
        }

        if (count($v1) < count($v2)) {
            return true;
        }
        return null;
    }

    if (is_int($v1)) {
        return compare([$v1], $v2);
    }
    if (is_int($v2)) {
        return compare($v1, [$v2]);
    }
}