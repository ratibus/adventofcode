<?php

// Solved in 26 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$data = file_get_contents($inputFile);
list(,, $x, $y) = explode(' ', str_replace(',', '', $data));

list(,$x) = explode('=', $x);
list(,$y) = explode('=', $y);

list($xMin, $xMax) = explode('..', $x);
list($yMin, $yMax) = explode('..', $y);

$globalHighestY = 0;

// ugly brute force
for ($vx = 1; $vx < $xMax+1; $vx++) {
    for ($vy = 1; $vy < 500; $vy++) {

        $x = 0;
        $y = 0;

        $velocity = [$vx, $vy];

        $highestY = 0;
        while (true) {

            $x += $velocity[0];
            $y += $velocity[1];

            $highestY = max($highestY, $y);

            $velocity[0] = max(0, $velocity[0]-1);
            $velocity[1]--;

            if ($x <= $xMax && $x >= $xMin && $y <= $yMax && $y >= $yMin) { // in target
                $globalHighestY = max($globalHighestY, $highestY);
                break;
            }

            if ($x > $xMax || $y < $yMin) { // target missed
                break;
            }
        }
    }
}

var_dump($globalHighestY);
