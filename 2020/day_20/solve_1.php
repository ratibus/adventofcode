<?php

// Solved in 52 minutes
$tiles = [];

$tileId = null;
$buffer = [];
foreach (file(__DIR__.'/'.$argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {

    if (strpos($line, 'Tile') === 0) {
        if (count($buffer)) {
            $tiles[$tileId] = $buffer;
            $buffer = [];
        }

        list(,$tileId) = explode(' ', $line);
        $tileId = (int)$tileId;
    } else {
        $buffer[] = str_split($line);
    }
}
if(count($buffer)) {
    $tiles[$tileId] = $buffer;
    $buffer = [];
}

$borders = getBorders($tiles);

$ans = 1;
foreach ($tiles as $tileId => $tile) {
    $nbUniqueBorder = 0;
    foreach ($borders as $border => $borderTiles) {
        if (isset($borderTiles[$tileId]) && count($borderTiles)===1) {
            $nbUniqueBorder++;
        }
    }
    if ($nbUniqueBorder === 4) {
        $ans *= $tileId;
    }
}
var_dump($ans);

function getBorders($tiles) {
    $borders = [];

    foreach ($tiles as $tileId => $tile) {
        $possibleBorders = [
            implode('', $tile[0]),
            implode('', $tile[count($tile)-1]),
        ];
        $firstCol = [];
        $lastCol = [];
        foreach ($tile as $rowIndex => $row) {
            $firstCol[] = $row[0];
            $lastCol[] = $row[count($row)-1];
        }
        $possibleBorders[] = implode('', $firstCol);
        $possibleBorders[] = implode('', $lastCol);

        foreach ($possibleBorders as $possibleBorder) {
            $possibleBorders[] = strrev($possibleBorder);
        }

        foreach ($possibleBorders as $possibleBorder) {
            $borders[$possibleBorder][$tileId] = $tileId;
        }
    }

    return $borders;
}