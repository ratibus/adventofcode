<?php

// Solved in 26 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input_test3.txt';
$inputFile = __DIR__ . '/input_test2.txt';
$inputFile = __DIR__ . '/input.txt';

$edges = [];
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $y => $line) {
    list($n1, $n2) = explode('-', $line);

    $edges[$n1][$n2] = $n2;

    if ($n1 !== 'start' && $n2 !== 'end') {
        $edges[$n2][$n1] = $n1;
    }
}

$paths = [];

$paths = [['start']];
while (true) {

    $newPaths = [];
    foreach ($paths as $path) {
        $lastNode = $path[count($path)-1];
        if ($lastNode === 'end' || !isset($edges[$lastNode])) {
            $newPaths[] = $path;
            continue;
        }

        foreach ($edges[$lastNode] as $neighbour) {
            if ($neighbour === strtolower($neighbour) && !isValidNeighbour($neighbour, $path)) { // small cave
                continue;
            }

            $newPaths[] = array_merge($path, [$neighbour]);
        }
    }

    if (count($paths) === count($newPaths)) {
        break; // no new path added
    }
    $paths = $newPaths;
}

var_dump(count($paths));

function isValidNeighbour($newNode, $path) {

    $smallCavesFrequencies = [];
    foreach ($path as $node) {
        if ($node !== strtolower($node)) { // big cave
            continue;
        }
        if (!isset($smallCavesFrequencies[$node])) {
            $smallCavesFrequencies[$node] = 0;
        }
        $smallCavesFrequencies[$node]++;
    }

    if (!isset($smallCavesFrequencies[$newNode])) {
        return true;
    }

    if ($newNode === 'start' || $newNode === 'end') {
        return false;
    }

    return array_sum($smallCavesFrequencies) === count($smallCavesFrequencies);
}