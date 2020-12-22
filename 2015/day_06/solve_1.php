<?php

// Solved in 10 minutes
$grid = [];
foreach (file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
    $infos = explode(' ', $line);

    if (count($infos) === 4) { // toggle
        $action = 'toggle';
        $from = explode(',', $infos[1]);
        $to = explode(',', $infos[3]);
    } else { // turn on/off
        $action = $infos[1];
        $from = explode(',', $infos[2]);
        $to = explode(',', $infos[4]);
    }

    for ($x = $from[0]; $x <= $to[0]; $x++) {
        for ($y = $from[1]; $y <= $to[1]; $y++) {
            if ($action === 'toggle') {
                if (isset($grid[$x][$y])) {
                    unset($grid[$x][$y]);
                } else {
                    $grid[$x][$y] = true;
                }
            } elseif ($action === 'off') {
                unset($grid[$x][$y]);
            } elseif ($action === 'on') {
                $grid[$x][$y] = true;
            }
        }
    }
}

$ans = 0;
foreach ($grid as $x => $xInfos) {
    foreach ($xInfos as $y => $state) {
        $ans++;
    }
}

var_dump($ans);