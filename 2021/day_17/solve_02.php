<?php

// Solved in 3 minutes

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$data = file_get_contents($inputFile);
list(,, $x, $y) = explode(' ', str_replace(',', '', $data));

list(,$x) = explode('=', $x);
list(,$y) = explode('=', $y);

list($xMin, $xMax) = explode('..', $x);
list($yMin, $yMax) = explode('..', $y);

$nbHits = 0;

// ugly brute force
for ($vx = 1; $vx < $xMax+1; $vx++) {
    for ($vy = $yMin; $vy < 500; $vy++) {

        $x = 0;
        $y = 0;

        $velocity = [$vx, $vy];

        while (true) {

            $x += $velocity[0];
            $y += $velocity[1];

            $velocity[0] = max(0, $velocity[0]-1);
            $velocity[1]--;

            if ($x <= $xMax && $x >= $xMin && $y <= $yMax && $y >= $yMin) { // in target
                $nbHits++;
                break;
            }

            if ($x > $xMax || $y < $yMin) { // target missed
                break;
            }
        }
    }
}

var_dump($nbHits);
