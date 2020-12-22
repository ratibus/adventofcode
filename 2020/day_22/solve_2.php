<?php

// Solved in about 1 hour
$cards = [];
$playerName = null;
foreach (file(__DIR__.'/'.$argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (strpos($line, 'Player') === 0) {
        $playerName = substr($line, 0, -1);
        continue;
    }
    $cards[$playerName][] = (int)$line;
}

function solveCombat($cards1, $cards2) {

    $seenGames = [];
    while (count($cards1) && count($cards2)) {
        $key = md5(sprintf("%s|%s", implode(',', $cards1), implode(',', $cards2)));
        if (isset($seenGames[$key])) {
            return [[1], []]; // Win from player 1 (cards do not matter)
        }
        $seenGames[$key] = true;

        $c1 = array_shift($cards1);
        $c2 = array_shift($cards2);

        $p1Wins = false;
        if (count($cards1) >= $c1 && count($cards2) >= $c2) { // Sub-game trigger
            list($subCards1) = solveCombat(array_slice($cards1, 0, $c1), array_slice($cards2, 0, $c2));

            if (count($subCards1)) {
                $p1Wins = true;
            }
        } elseif ($c1 > $c2) {
            $p1Wins = true;
        }

        if ($p1Wins) {
            $cards1[] = $c1;
            $cards1[] = $c2;
        } else {
            $cards2[] = $c2;
            $cards2[] = $c1;
        }
    }

    return [$cards1, $cards2];
}

list($cards1, $cards2) = solveCombat($cards["Player 1"], $cards["Player 2"]);

$winnerCards = count($cards1) ? $cards1 : $cards2;

$ans = 0;
$coeff = 0;
foreach (array_reverse($winnerCards) as $card) {
    $coeff++;
    $ans += $coeff*$card;
}

var_dump($ans);
