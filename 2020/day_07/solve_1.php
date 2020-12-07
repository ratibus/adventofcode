<?php

// Solved in 38 minutes
$inputFile = __DIR__.'/input.txt';

$bagsTree = getBagsTree($inputFile);
debug($bagsTree['inverted']);

$parentColors = [];
findParentColors($bagsTree['inverted'], 'shiny gold', $parentColors);
debug($parentColors);

var_dump(count($parentColors));

function findParentColors($tree, $color, &$parentColors) {
    if (!isset($tree[$color])) {
        return $color;
    }

    debug($color);
    debug($tree[$color]);
    foreach ($tree[$color] as $parentColor) {
        $parentColors[$parentColor] = $parentColor;
        findParentColors($tree, $parentColor, $parentColors);
    }
}

function getBagsTree($inputFile) {

    $bagsTree = [];

    foreach (file($inputFile, FILE_IGNORE_NEW_LINES) as $line) {
        $line = trim($line);

        list($root, $leafs) = explode(' bags contain ', $line);

        if ($leafs === 'no other bags.') {
            $bagsTree['normal'][$root] = [];
        } else {
            $rawLeafs = explode(', ', $leafs);

            foreach ($rawLeafs as $rawLeaf) {
                $leafParts = explode(' ', $rawLeaf);
                $number = $leafParts[0];
                $color = $leafParts[1].' '.$leafParts[2];
                $leaf = [
                    'color' => $color,
                    'number' => $number,
                ];

                $bagsTree['normal'][$root][] = $leaf;
                $bagsTree['inverted'][$color][$root] = $root;
            }
        }
    }

    return $bagsTree;
}


function debug($v) {
    return;
    if (is_array($v)) {
        print_r($v);
    } else {
        var_dump($v);
    }
}
