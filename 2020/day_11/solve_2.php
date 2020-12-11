<?php

// Solved in 26 minutes
$inputFile = __DIR__.'/input.txt';

$layout = getLayout($inputFile);
//printLayout($layout);

$iterationIndex = 0;
$lastNbOccupiedSeats = null;
while (true) {
    debug("Iteration ".$iterationIndex);
    $iterationIndex++;
    $newLayout = getNewLayout($layout);
    //printLayout($newLayout);
    $nbOccupiedSeats = countOccupiedSeats($newLayout);
    debug(sprintf("%d occupied seats", $nbOccupiedSeats));
    $layout = $newLayout;

    if ($nbOccupiedSeats === $lastNbOccupiedSeats) break;
    $lastNbOccupiedSeats = $nbOccupiedSeats;
}
var_dump($iterationIndex);
var_dump($lastNbOccupiedSeats);


function printLayout($layout) {
    foreach ($layout as $y => $yInfos) {
        printf("%s\n", implode('', $yInfos));
    }
}

function getNewLayout($layout) {
    $newLayout = [];
    foreach ($layout as $y => $yInfos) {
        foreach ($yInfos as $x => $type) {
            $nbOccupiedSeats = getNbOccupiedSeats($layout, $x, $y);

            if ($type == 'L' && $nbOccupiedSeats == 0) {
                $newType = '#'; // occupied
            } elseif ($type == '#' && $nbOccupiedSeats >= 5) {
                $newType = 'L'; // occupied
            } else {
                $newType = $type;
            }
            $newLayout[$y][$x] = $newType;
        }
    }
    return $newLayout;
}

function countOccupiedSeats($layout) {
    $nb = 0;
    foreach ($layout as $y => $yInfos) {
        foreach ($yInfos as $x => $type) {
            if ($type === '#') {
                $nb++;
            }
        }
    }

    return $nb;
}

function getLayout($inputFile) {
    $layout = [];
    foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $y => $line) {
        foreach (str_split($line) as $x => $type) {
            $layout[$y][$x] = $type;
        }
    }
    return $layout;
}

function getNbOccupiedSeats($layout, $x, $y) {
    $nb = 0;
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, 1, 0);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, -1, 0);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, 0, 1);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, 0, -1);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, 1, 1);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, 1, -1);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, -1, 1);
    $nb += getNbOccupiedSeatsShift($layout, $x, $y, -1, -1);

    debug(sprintf('getNbOccupiedSeats %d %d => %d', $y, $x, $nb));
    return $nb;
}

function getNbOccupiedSeatsShift($layout, $x, $y, $shiftX, $shiftY) {
    $nb = 0;
    $iteration = 0;
    while (true) {
        $iteration++;
        if(!isset($layout[$y+$shiftY*$iteration][$x+$shiftX*$iteration])
            || $layout[$y+$shiftY*$iteration][$x+$shiftX*$iteration] === 'L') break;

        if($layout[$y+$shiftY*$iteration][$x+$shiftX*$iteration] === '#') {
            $nb++;
            break;
        }
    }
    return $nb;
}


function debug($v) {
    return;
    if (is_array($v)) {
        print_r($v);
    } else {
        var_dump($v);
    }
}
