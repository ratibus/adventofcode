<?php

// Solved in 2 minutes
$totalRibbon = 0;
foreach (file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $package) {
    $dimensions = explode('x', $package);
    list($l, $w, $h) = $dimensions;
    sort($dimensions);

    $totalRibbon += 2* ($dimensions[0]+$dimensions[1]) + $l*$w*$h;
}

var_dump($totalRibbon);