<?php

// Solved in 4 minutes
$totalWrap = 0;
foreach (file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $package) {
    $dimensions = explode('x', $package);
    list($l, $w, $h) = $dimensions;
    sort($dimensions);

    $wrap = 2*$l*$w + 2*$l*$h + 2*$h*$w + $dimensions[0]*$dimensions[1];
    $totalWrap += $wrap;
}

var_dump($totalWrap);