<?php

// Solved in 2 minutes
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

            if (!isset($grid[$x][$y])) {
                $grid[$x][$y] = 0;
            }

            if ($action === 'toggle') {
                $grid[$x][$y] += 2;
            } elseif ($action === 'off') {
                $grid[$x][$y]--;
                if ($grid[$x][$y] < 0) {
                    $grid[$x][$y] = 0;
                }
            } elseif ($action === 'on') {
                $grid[$x][$y]++;
            }
        }
    }
}

$ans = 0;
foreach ($grid as $x => $xInfos) {
    foreach ($xInfos as $y => $state) {
        $ans+=$state;
    }
}

var_dump($ans);