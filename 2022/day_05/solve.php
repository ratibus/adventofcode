<?php

// Part 1 solved in 31'
// Part 2 solved in 5'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$nbStacks = ceil(strlen($lines[0]) / 4);

$stacks = array_fill(0, $nbStacks, []);
$moves = [];

foreach ($lines as $lineIndex => $line) {
    if (substr($line, 0, 1) === '[') { // stack definition
        for ($stackIndex = 0; $stackIndex < $nbStacks; $stackIndex++) {
            $crate = trim(strtr(substr($line, $stackIndex * 4, 4), '[]', '  '));
            if ($crate !== '') {
                $stacks[$stackIndex][] = $crate;
            }
        }
    } elseif (substr($line, 0, 1) === 'm') { // move definition
        list(,$nbMoves,,$start,,$end) = explode(' ', $line);
        $moves[] = ['nb' => $nbMoves, 'start' => $start - 1, 'end' => $end - 1];
    }
}

// Part 1
$newStacks = moveCrates($stacks, $moves, false);
var_dump(implode('', getStacksTops($newStacks)));

// Part 2
$newStacks = moveCrates($stacks, $moves, true);
var_dump(implode('', getStacksTops($newStacks)));

function moveCrates($stacks, $moves, $keepOrder) {
    foreach ($moves as $move) {
        $movedCrates = [];
        for ($moveIndex = 0; $moveIndex < $move['nb']; $moveIndex++) {
            $movedCrates[] = array_shift($stacks[$move['start']]);
        }
        if (!$keepOrder) {
            $movedCrates = array_reverse($movedCrates);
        }
        array_unshift($stacks[$move['end']], ...$movedCrates);
    }
    return $stacks;
}

function getStacksTops($stacks) {
    $tops = [];
    foreach ($stacks as $stack) {
        $tops[] = $stack[0];
    }
    return $tops;
}
