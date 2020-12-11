<?php

// Solved in 36 minutes, dummy mistakes in getNbOccupiedSeats computation...
$inputFile = __DIR__.'/input.txt';

$layout = getLayout($inputFile);
//debug($layout);

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

    //if ($iterationIndex == 2) break;
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
            } elseif ($type == '#' && $nbOccupiedSeats >= 4) {
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
    for ($i = $x - 1; $i <= $x + 1; $i++) {
        for ($j = $y - 1; $j <= $y + 1; $j++) {
            if (($i !== $x || $j !== $y) && isset($layout[$j][$i]) && $layout[$j][$i] === '#') {
                $nb++;
            }
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
