<?php

// Solved in 16 minutes

$playersPositions = [4, 8]; // example
$playersPositions = [4, 6]; // input

$playersScores = [0, 0];

$die = 1;
$dieRolls = 0;
while (true) {
    foreach ($playersPositions as $playerIndex => $playerPosition) {
        $move = 0;
        for ($i = 0; $i < 3; $i++) {
            $dieRolls++;
            $move += $die;
            $die++;
        }
        $playerPosition += $move;
        $playerPosition = ($playerPosition - 1) % 10 + 1;

        $playersScores[$playerIndex] += $playerPosition;

        if ($playersScores[$playerIndex] >= 1000) {
            var_dump($dieRolls * $playersScores[1 - $playerIndex]);
            exit;
        }
        $playersPositions[$playerIndex] = $playerPosition;
    }
}
