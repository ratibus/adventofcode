<?php

// Solved in 12 minutes
$cards = [];

$playerName = null;
foreach (file(__DIR__.'/'.$argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (strpos($line, 'Player') === 0) {
        $playerName = substr($line, 0, -1);
        continue;
    }

    $cards[$playerName][] = (int)$line;
}

while (count($cards["Player 1"]) && count($cards["Player 2"])) {
    $p1 = array_shift($cards["Player 1"]);
    $p2 = array_shift($cards["Player 2"]);

    if ($p1 > $p2) {
        $cards["Player 1"][] = $p1;
        $cards["Player 1"][] = $p2;
    } else {
        $cards["Player 2"][] = $p2;
        $cards["Player 2"][] = $p1;
    }
}

$winnerCards = count($cards["Player 1"]) ? $cards["Player 1"] : $cards["Player 2"];

$ans = 0;
$coeff = 0;
foreach (array_reverse($winnerCards) as $card) {
    $coeff++;
    $ans += $coeff*$card;
}

var_dump($ans);

