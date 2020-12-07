<?php

// Solved in 1h09
$inputFile = __DIR__.'/input.txt';

$bagsTree = getBagsTree($inputFile);
debug($bagsTree);

$nbBags = findNbChildrenBags($bagsTree['normal'], 'shiny gold');

var_dump($nbBags);

function findNbChildrenBags($tree, $color) {
    debug($color);
    debug($tree[$color]);
    if (!count($tree[$color])) {
        return 0;
    }

    $nbBags = 0;
    foreach ($tree[$color] as $childColor) {
        $childrenNbBags = findNbChildrenBags($tree, $childColor['color']);

        $nbBags += $childColor['number'] * ($childrenNbBags + 1);
        debug("New bags : ".$childrenNbBags);
        debug("childColor['number'] : ".$childColor['number']);
    }
    debug($nbBags);
    return $nbBags;
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

                $bagsTree['normal'][$root][$color] = $leaf;
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
