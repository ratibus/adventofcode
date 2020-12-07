<?php

$inputFile = __DIR__ . '/input.txt';

$treeLocations = getTreeLocations($inputFile);

$slopes = [
    ['right' => 1, 'down' => 1],
    ['right' => 3, 'down' => 1],
    ['right' => 5, 'down' => 1],
    ['right' => 7, 'down' => 1],
    ['right' => 1, 'down' => 2],
];

$treesProduct = 1;

foreach ($slopes as $slope) {
    $nbTreesFound = 0;
    foreach ($treeLocations as $lineIndex => $lineTreeLocation) {
        if ($lineIndex === 0) continue;
        if ($lineIndex % $slope['down'] !== 0) continue;

        $intersectionIndex = ($slope['right'] * (int)($lineIndex/$slope['down'])) % $lineTreeLocation['pattern_length'];

        if (isset($lineTreeLocation['tree_positions'][$intersectionIndex])) {
            $nbTreesFound++;
        }
    }

    printf("Slope (%d / %d), trees: %d\n", $slope['right'], $slope['down'], $nbTreesFound);

    $treesProduct *= $nbTreesFound;
}
var_dump($treesProduct);

function getTreeLocations($inputFile) {

    $treeLocations = [];
    foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $lineIndex => $line) {

        $lineLength = strlen($line);

        $lineTreeLocations = [];
        for ($i = 0; $i < $lineLength; $i++) {
            if (substr($line, $i, 1) === '#') {
                $lineTreeLocations[$i] = $i;
            }
        }

        $treeLocations[$lineIndex] = [
            'pattern_length' => $lineLength,
            'tree_positions' => $lineTreeLocations,
        ];
    }
    return $treeLocations;
}