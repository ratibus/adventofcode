<?php

// Solved in 1 hour

$inputFile = __DIR__ . '/input_test0.txt';
$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$algoLine = array_shift($lines);
$algo = str_split($algoLine);

$image = [];
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $lit) {
        $image[$y][$x] = $lit;
    }
}

for ($i = 0; $i < 2; $i++) {

    $image = addBorder($image, 10);

    $newImage = [];
    foreach ($image as $y => $row) {
        foreach ($row as $x => $lit) {

            $pixel = '';
            foreach ([-1, 0, 1] as $dy) {
                foreach ([-1, 0, 1] as $dx) {
                    $pixel .= $image[$y+$dy][$x+$dx] ?? '.';
                }
            }

            $pixelBin = str_replace(['.', '#'], ['0', '1'], $pixel);
            $algoIndex = base_convert($pixelBin, 2, 10);
            $algoValue = $algo[$algoIndex];

            $newImage[$y][$x] = $algoValue;
        }
    }
    $image = $newImage;

    if ($i % 2 === 1) {
        $image = cutBorder($image, 17);
    }
}

var_dump(countLit($image));

function addBorder($image, $borderSize) {
    $imageSize = count($image);

    $newImage = [];
    for ($y = 0; $y < $imageSize+2*$borderSize; $y++) {
        for ($x = 0; $x < $imageSize+2*$borderSize; $x++) {
            $newImage[$y][$x] = $image[$y-$borderSize][$x-$borderSize] ?? '.';
        }
    }
    return $newImage;
}

function cutBorder($image, $borderSize) {
    $imageSize = count($image);
    $newImage = [];

    for ($y = $borderSize; $y < $imageSize-$borderSize; $y++) {
        for ($x = $borderSize; $x < $imageSize-$borderSize; $x++) {
            $newImage[$y-$borderSize][$x-$borderSize] = $image[$y][$x];
        }
    }
    return $newImage;
}

function countLit($image) {
    $count = 0;
    foreach ($image as $row) {
        foreach ($row as $lit) {
            if ($lit === '#') {
                $count++;
            }
        }
    }
    return $count;
}
