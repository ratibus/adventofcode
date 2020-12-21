<?php

// Worked on it for many hours but I worked \o/
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

$seaMonster = [];
foreach (file(__DIR__.'/sea_monster.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {
    foreach (str_split($line) as $charCol => $char) {
        if ($char !== '#') {
            continue;
        }
        $seaMonster[$charCol][$lineIndex] = true;
    }
}

$puzzle = arrangeTiles($tiles); // Puzzle solving \o/
$puzzle = sortPuzzle($puzzle);
$image = getImage($puzzle);

$nbHashesInImage = count_chars(getImageAsString($image), 1)[35]; // # is 35 in ASCII
$nbHashesSeaMonster = count_chars(file_get_contents(__DIR__.'/sea_monster.txt'), 1)[35]; // # is 35 in ASCII

for ($i = 0; $i < 8; $i++) {
    if ($i === 4) {
        $image = flipTile($image);
    }

    if ($i > 0) {
        $image = rotateTile($image);
    }
    $nbSeaMonsters = findSeaMonster($image, $seaMonster);

    if ($nbSeaMonsters > 0) {
        break;
    }
}

printf("%s sea monsters found, beware!!!\n", $nbSeaMonsters);

var_dump($nbHashesInImage - $nbHashesSeaMonster * $nbSeaMonsters);

function findSeaMonster($image, $seaMonster) {

    $nbSeaMonsters = 0;
    foreach ($image as $x => $xInfos) {
        foreach ($xInfos as $y => $char) {
            // We start finding the sea monster from this position
            $seaMonsterFound = true;
            foreach ($seaMonster as $smX => $smXInfos) {
                foreach (array_keys($smXInfos) as $smY) {
                    if (!isset($image[$x+$smX][$y+$smY]) || $image[$x+$smX][$y+$smY] !== '#') {
                        $seaMonsterFound = false;
                        break 2;
                    }
                }
            }

            if ($seaMonsterFound) {
                $nbSeaMonsters++;
            }
        }
    }
    return $nbSeaMonsters;
}

function getImageAsString($image) {
    $str = '';
    foreach ($image as $x => $xInfos) {
        $str .= sprintf("%s\n", implode('', $xInfos));
    }
    return $str;
}

function getImage($puzzle) {
    $image = [];

    foreach ($puzzle as $x => $xInfos) {
        $imageY = 0;
        foreach ($xInfos as $y => $tileInfos) {
            foreach ($tileInfos['data'] as $tileRowIndex => $tileRow) {
                if ($tileRowIndex === 0 || $tileRowIndex === count($tileInfos['data'])-1) {
                    continue; // We strip top and bottom border
                }
                array_pop($tileRow);
                array_shift($tileRow);
                // No border left at this point
                $imageY++;

                if (!isset($image[$imageY])) {
                    $image[$imageY] = [];
                }
                foreach ($tileRow as $char) {
                    $image[$imageY][] = $char;
                }
            }
        }
    }

    return $image;
}

function sortPuzzle($puzzle) {
    $newPuzzle = [];

    $xRange = array_keys($puzzle);
    sort($xRange);
    foreach ($xRange as $x) {
        $yRange = array_keys($puzzle[$x]);
        sort($yRange);

        foreach ($yRange as $y) {
            $newPuzzle[$x][$y] = $puzzle[$x][$y];
        }
    }

    return $newPuzzle;
}

function arrangeTiles($tiles) {

    $workTiles = $tiles;
    $stack = [];
    while (true) {
        $externalTiles = getExternalTiles($workTiles);

        $nbExternalTiles = count($externalTiles);
        $nbWorkTiles = count($workTiles);

        foreach ($externalTiles as $tileId) {
            unset($workTiles[$tileId]);
        }

        $stack[] = $externalTiles;

        if ($nbWorkTiles === $nbExternalTiles) {
            break;
        }
    }

    $puzzle = [];

    $insideTiles = array_pop($stack);

    $cursorX = 0;
    $cursorY = 0;
    while (count($insideTiles)) {

        if (!count($puzzle)) {
            $tile = array_pop($insideTiles);
            $puzzle[0][0] = ['id' => $tile, 'data' => $tiles[$tileId]];
            continue;
        }

        $srcTile = $puzzle[$cursorX][$cursorY];
        $srcBorders = getActualBorders($srcTile['data']);

        foreach ($insideTiles as $insideTileId) {

            $insideTile = $tiles[$insideTileId];
            for ($i = 0; $i < 8; $i++) {
                if ($i === 4) {
                    $insideTile = flipTile($insideTile);
                }

                if ($i > 0) {
                    $insideTile = rotateTile($insideTile);
                }
                $insideTileBorders = getActualBorders($insideTile);

                $validPositions = [[0, 2], [2, 0], [1, 3], [3, 1]];

                foreach ($validPositions as $validPosition) {
                    $srcBorder = $srcBorders[$validPosition[0]];
                    $insideTileBorder = $insideTileBorders[$validPosition[1]];

                    if ($srcBorder !== $insideTileBorder) {
                        continue;
                    }

                    if ($validPosition[0] === 0) {
                        $cursorY--;
                    } elseif($validPosition[0] === 1) {
                        $cursorX++;
                    } elseif($validPosition[0] === 2) {
                        $cursorY++;
                    } elseif($validPosition[0] === 3) {
                        $cursorX--;
                    }

                    $puzzle[$cursorX][$cursorY] = ['id' => $insideTileId, 'data' => $insideTile];
                    unset($insideTiles[$insideTileId]);
                    break 3;
                }
            }
        }
    }

    while (count($stack)) {

        $newTiles = array_pop($stack);

        $newTilesFound = [];

        $minX = $minY = PHP_INT_MAX;
        $maxX = $maxY = PHP_INT_MIN;
        $puzzleColIndexMin = min(array_keys($puzzle));
        $puzzleColIndexMax = max(array_keys($puzzle));
        foreach ($puzzle as $puzzleColIndex => $puzzleCol) {
            $puzzleRowIndexMin = min(array_keys($puzzleCol));
            $puzzleRowIndexMax = max(array_keys($puzzleCol));
            foreach ($puzzleCol as $puzzleRowIndex => $puzzleCell) {

                if ($puzzleRowIndex !== $puzzleRowIndexMin && $puzzleRowIndex !== $puzzleRowIndexMax
                    && $puzzleColIndex !== $puzzleColIndexMin && $puzzleColIndex !== $puzzleColIndexMax) {
                    continue; // Only outside tiles are interesting here
                }

                $srcBorders = getActualBorders($puzzleCell['data']);

                $validPositions = [];
                if ($puzzleRowIndex === $puzzleRowIndexMin) {
                    $validPositions[] = [0, 2];
                }
                if ($puzzleRowIndex === $puzzleRowIndexMax) {
                    $validPositions[] = [2, 0];
                }
                if ($puzzleColIndex === $puzzleColIndexMin) {
                    $validPositions[] = [3, 1];
                }
                if ($puzzleColIndex === $puzzleColIndexMax) {
                    $validPositions[] = [1, 3];
                }

                foreach ($newTiles as $newTileId) {
                    if (isset($newTilesFound[$newTileId])) {
                        continue; // Tile already found
                    }

                    $externalTile = $tiles[$newTileId];
                    for ($i = 0; $i < 8; $i++) {
                        if ($i === 4) {
                            $externalTile = flipTile($externalTile);
                        }
                        if ($i > 0) {
                            $externalTile = rotateTile($externalTile);
                        }
                        $externalTileBorders = getActualBorders($externalTile);

                        foreach ($validPositions as $validPosition) {
                            $srcBorder = $srcBorders[$validPosition[0]];
                            $externalTileBorder = $externalTileBorders[$validPosition[1]];

                            if ($srcBorder !== $externalTileBorder) {
                                continue;
                            }

                            $puzzleX = $puzzleColIndex;
                            $puzzleY = $puzzleRowIndex;
                            if ($validPosition[0] === 0) {
                                $puzzleY--;
                            } elseif($validPosition[0] === 1) {
                                $puzzleX++;
                            } elseif($validPosition[0] === 2) {
                                $puzzleY++;
                            } elseif($validPosition[0] === 3) {
                                $puzzleX--;
                            }

                            $minX = min($minX, $puzzleX);
                            $minY = min($minY, $puzzleY);
                            $maxX = max($maxX, $puzzleX);
                            $maxY = max($maxY, $puzzleY);

                            $puzzle[$puzzleX][$puzzleY] = ['id' => $newTileId, 'data' => $externalTile];
                            $newTilesFound[$newTileId] = $newTileId;
                            unset($newTiles[$newTileId]);
                            break 2;
                        }
                    }
                }
            }
        }

        $corners = $newTiles;

        // Corners coordinates (X, Y): (minX, minY), (maxX, minY), (minX, maxY), (maxX, maxY)
        $cornersBordersToMatch = [
            [1 => getActualBorders($puzzle[$minX+1][$minY]['data'])[3], 2 => getActualBorders($puzzle[$minX][$minY+1]['data'])[0]],
            [3 => getActualBorders($puzzle[$maxX-1][$minY]['data'])[1], 2 => getActualBorders($puzzle[$maxX][$minY+1]['data'])[0]],
            [3 => getActualBorders($puzzle[$maxX-1][$maxY]['data'])[1], 0 => getActualBorders($puzzle[$maxX][$maxY-1]['data'])[2]],
            [1 => getActualBorders($puzzle[$minX+1][$maxY]['data'])[3], 0 => getActualBorders($puzzle[$minX][$maxY-1]['data'])[2]],
        ];
        $foundCorners = [];
        foreach ($cornersBordersToMatch as $bordersToMatchIndex => $bordersToMatch) {
            foreach ($corners as $corner) {
                if (isset($foundCorners[$corner])) continue; // Corner already found

                $cornerTile = $tiles[$corner];
                for ($i = 0; $i < 8; $i++) {
                    if ($i === 4) {
                        $cornerTile = flipTile($cornerTile);
                    }
                    if ($i > 0) {
                        $cornerTile = rotateTile($cornerTile);
                    }
                    $cornerTileBorders = getActualBorders($cornerTile);

                    $cornerFound = true;
                    foreach ($bordersToMatch as $borderSide => $borderToMatch) {
                        if ($cornerTileBorders[$borderSide] !== $borderToMatch) {
                            $cornerFound = false;
                            break;
                        }
                    }

                    if (!$cornerFound) {
                        continue;
                    }

                    if ($bordersToMatchIndex === 0) {
                        $puzzle[$minX][$minY] = ['id' => $corner, 'data' => $cornerTile];
                    } elseif($bordersToMatchIndex === 1) {
                        $puzzle[$maxX][$minY] = ['id' => $corner, 'data' => $cornerTile];
                    } elseif($bordersToMatchIndex === 2) {
                        $puzzle[$maxX][$maxY] = ['id' => $corner, 'data' => $cornerTile];
                    } elseif($bordersToMatchIndex === 3) {
                        $puzzle[$minX][$maxY] = ['id' => $corner, 'data' => $cornerTile];
                    }
                    $foundCorners[$corner] = $corner;
                }
            }
        }
    }

    return $puzzle;
}

function getExternalTiles($tiles) {

    $borders = getBorders($tiles);

    $externalTiles = [];
    foreach ($tiles as $tileId => $tile) {
        $nbUniqueBorder = 0;
        foreach ($borders as $border => $borderTiles) {
            if (isset($borderTiles[$tileId]) && count($borderTiles)===1) {
                $nbUniqueBorder++;
            }
        }
        if ($nbUniqueBorder !== 0) {
            $externalTiles[$tileId] = $tileId;
        }
    }
    return $externalTiles;
}

function getBorders($tiles, $tileIds = []) {
    $borders = [];

    foreach ($tiles as $tileId => $tile) {
        if (count($tileIds) && !isset($tileIds[$tileId])) continue;

        $possibleBorders = getActualBorders($tile);

        foreach ($possibleBorders as $possibleBorder) {
            $possibleBorders[] = strrev($possibleBorder); // Avoid rotating
        }

        foreach ($possibleBorders as $possibleBorder) {
            $borders[$possibleBorder][$tileId] = $tileId;
        }
    }

    return $borders;
}

function getActualBorders($tile) {

    $firstCol = [];
    $lastCol = [];
    foreach ($tile as $rowIndex => $row) {
        $firstCol[] = $row[0];
        $lastCol[] = $row[count($row)-1];
    }

    $borders = [
        implode('', $tile[0]),
        implode('', $lastCol),
        implode('', $tile[count($tile)-1]),
        implode('', $firstCol),
    ];

    return $borders;
}

function rotateTile($tile) { // Clockwise
    $newTile = [];

    foreach ($tile as $rowIndex => $row) {
        foreach ($row as $colIndex => $col) {
            $newTile[$colIndex][count($tile)-1-$rowIndex] = $col;
        }
    }

    foreach ($newTile as $rowIndex => $row) {
        ksort($row);
        $newTile[$rowIndex] = $row;
    }

    return $newTile;
}

function flipTile($tile) { // Vertical symetry
    $newTile = [];

    foreach ($tile as $rowIndex => $row) {
        foreach ($row as $colIndex => $col) {
            $newTile[$rowIndex][count($tile)-1-$colIndex] = $col;
        }
    }

    foreach ($newTile as $rowIndex => $row) {
        ksort($row);
        $newTile[$rowIndex] = $row;
    }

    return $newTile;
}
