<?php

// Part 1 solved in 76'
// Part 2 solved in 5'

$inputFile = __DIR__.'/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$currentPath = null;
$files= [];
$dirs = [];
foreach ($lines as $line) {
    if (substr($line, 0, 1) === '$') {
        if (substr($line, 0, 5) === '$ cd ') {
            $cd = substr($line, 5);
            if ($cd === '/') {
                $currentPath = '/';
            } elseif ($cd === '..') {
                $currentPath = dirname($currentPath);
                if ($currentPath !== '/') {
                    $currentPath .= '/';
                }
            } else {
                $currentPath .= $cd.'/';
            }
            $dirs[$currentPath] = $currentPath;
        }
    } else {
        list($type, $name) = explode(' ', $line);
        if ($type !== 'dir') {
            $files[$currentPath][$currentPath.$name] = $type;
        }
    }
}

// Compute dir total sizes
$dirSizes = [];
foreach ($dirs as $dir) {
    $dirSize = 0;
    foreach ($files as $dir2 => $dirFiles) {
        if (strpos($dir2, $dir) !== 0) {
            continue;
        }
        $dirSize += array_sum($dirFiles);
    }
    $dirSizes[$dir] = $dirSize;
}

// Part 1
$part1 = 0;
foreach ($dirSizes as $dir => $size) {
    if ($size <= 100000) {
        $part1 += $size;
    }
}
var_dump($part1);

// Part 2
$totalUsed = $dirSizes['/'];
$freeSize = 70000000 - $totalUsed;
$requiredClean = 30000000 - $freeSize;

$part2Dirs = [];
foreach ($dirSizes as $dir => $size) {
    if ($size >= $requiredClean) {
        $part2Dirs[$dir] = $size;
    }
}
sort($part2Dirs);
var_dump($part2Dirs[0]);
