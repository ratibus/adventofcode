<?php

// Solved in 40 minutes

// Context key : position of player 1 | score of player 1 | position of player 2 | score of player 2
$playersContexts = ['4|0|8|0' => 1]; // example
$playersContexts = ['4|0|6|0' => 1]; // input

$dieFrequencies = [];
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        for ($k = 1; $k <= 3; $k++) {
            $score = $i+$j+$k;
            $dieFrequencies[$score] = ($dieFrequencies[$score] ?? 0) + 1;
        }
    }
}

$nbWins = [0, 0];
while (count($playersContexts)) {

    $newPlayersContexts = [];
    foreach ($playersContexts as $context => $nb) {
        list($pos1, $score1, $pos2, $score2) = explode('|', $context);

        foreach ($dieFrequencies as $dieScore1 => $nb1) { // Loop for player 1

            $newPos1 = $pos1 + $dieScore1;
            $newPos1 = ($newPos1 - 1) % 10 + 1;
            $newScore1 = $score1 + $newPos1;

            if ($newScore1 >= 21) {
                $nbWins[0] += $nb * $nb1;
                continue;
            }

            foreach ($dieFrequencies as $dieScore2 => $nb2) { // Loop for player 2
                $newPos2 = $pos2 + $dieScore2;
                $newPos2 = ($newPos2 - 1) % 10 + 1;
                $newScore2 = $score2 + $newPos2;

                if ($newScore2 >= 21) {
                    $nbWins[1] += $nb * $nb1 * $nb2;
                    continue;
                }

                $newContext = implode('|', [$newPos1, $newScore1, $newPos2, $newScore2]);
                $newPlayersContexts[$newContext] = ($newPlayersContexts[$newContext] ?? 0) + $nb * $nb1 * $nb2;
            }
        }
    }
    $playersContexts = $newPlayersContexts;
}
var_dump(max($nbWins));