<?php

// Part 1 solved in 50'
// Part 2 solved in at least 1 hour :)

$inputFile = __DIR__.'/input.txt';

$content = file_get_contents($inputFile);

preg_match_all('/Sensor at x=(.*), y=(.*): closest beacon is at x=(.*), y=(.*)/', $content, $matches, PREG_SET_ORDER);

$sensors = [];
foreach ($matches as $match) {
    $match = array_map("intval", $match);
    list(, $sensorX, $sensorY, $beaconX, $beaconY) = $match;
    $sensors[] = [$sensorX, $sensorY, $beaconX, $beaconY];
}

// Part 1
$horizontalIntervals = getHorizontalOccupiedIntervals($sensors, 2000000, -PHP_INT_MAX, PHP_INT_MAX);
var_dump(findIntervalsUnionLength($horizontalIntervals));

// Part 2
$xTargetMin = 0; $xTargetMax = 4000000;
$yTargetMin = 0; $yTargetMax = 4000000;

for ($yTarget = $yTargetMin; $yTarget <= $yTargetMax; $yTarget++) {

    $horizontalIntervals = getHorizontalOccupiedIntervals($sensors, $yTarget, $xTargetMin, $xTargetMax);

    if (findIntervalsUnionLength($horizontalIntervals) !== $xTargetMax - $xTargetMin) {
        $foundY = $yTarget;

        for ($x = $xTargetMin; $x <= $xTargetMax; $x++) {

            $occupied = false;
            foreach ($horizontalIntervals as $horizontalInterval) {
                if ($x >= $horizontalInterval[0] && $x <= $horizontalInterval[1]) {
                    $occupied = true;
                    break;
                }
            }

            if (!$occupied) {
                $foundX = $x;
                break;
            }
        }

        $part2 = gmp_add($foundY, gmp_mul($foundX, 4000000));
        var_dump(gmp_strval($part2));
        break;
    }
}

function getHorizontalOccupiedIntervals($sensors, $yTarget, $xTargetMin, $xTargetMax) {

    $horizontalIntervals = [];
    foreach ($sensors as $sensorCoord => $sensor) {
        list($sensorX, $sensorY, $beaconX, $beaconY) = $sensor;

        $distance = abs($sensorX - $beaconX) + abs($sensorY - $beaconY);

        if ($sensorY + $distance < $yTarget || $sensorY - $distance > $yTarget) {
            continue;
        }

        $deltaY = abs($yTarget - $sensorY);
        $startX = $sensorX - $distance + $deltaY;
        $endX = $sensorX + $distance - $deltaY;

        if ($endX < $xTargetMin || $startX > $xTargetMax) {
            continue;
        }
        $startX = max($xTargetMin, $startX);
        $endX = min($xTargetMax, $endX);

        $horizontalIntervals[] = [$startX, $endX];
    }
    return $horizontalIntervals;
}

function sortIntervals($intervals) {

    usort($intervals, function ($a, $b) {
        if ($a[0] < $b[0]) {
            return -1;
        } elseif ($a[0] >  $b[0]) {
            return 1;
        } else {
            if ($a[1] < $b[1]) {
                return -1;
            } elseif ($a[1] >  $b[1]) {
                return 1;
            } else {
                return 0;
            }
        }
    });

    return $intervals;
}


function findIntervalsUnionLength($intervals) {
    $intervals = sortIntervals($intervals);

    // From https://stackoverflow.com/a/27232746
    list($a, $b) = current($intervals);
    $length = $b - $a;

    while(list($c, $d) = next($intervals)) {
        $length += $d - $c - max(0, min($d,$b)-$c);
        if($c >= $b) {
            $a = $c;
        }
        $b = max($b,$d);
    }
    return $length;

}