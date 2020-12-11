<?php

// Not solved after 2 hours, read solutions on Reddit and HFR
$inputFile = __DIR__.'/input.txt';

$ratings = getRawRatings($inputFile);
//debug($ratings);

$chargingOutletRating = 0;
$builtInRating = max($ratings) + 3;

$tree = getRatingTree(array_merge($ratings, [$chargingOutletRating, $builtInRating]));
//debug($tree);

$cache = [];
var_dump(nbPaths($tree, 0, $cache));

// PHP port of Python solution (_num_routes function) : https://www.reddit.com/r/adventofcode/comments/ka8z8x/2020_day_10_solutions/gf9pyev/
// run in about 100ms (vs about 10 days of computation with my findPath solution below)
function nbPaths($tree, $node, &$cache) {
    if (isset($cache[$node])) {
        return $cache[$node];
    }

    if (!isset($tree[$node])) {
        return 1;
    }
    $nbPaths = 0;
    foreach ($tree[$node] as $childNode) {
        $nbPaths += nbPaths($tree, $childNode, $cache);
    }
    $cache[$node] = $nbPaths;
    return $nbPaths;
}


/* Way too slow :(
$nbPaths = 0;
findPath($tree, 0, $nbPaths);
var_dump($nbPaths);

function findPath(&$tree, $startingNode, &$nbPaths) {
    if (!isset($tree[$startingNode])) {
        $nbPaths++;
        if ($nbPaths % 1000000 === 0) debug("Path end ".$nbPaths);
        return true;
    }

    foreach ($tree[$startingNode] as $childNode) {
        //debug(sprintf("Path %d to %d", $startingNode, $childNode));
        findPath($tree, $childNode, $nbPaths);
    }
}
*/

function getRatingTree($ratings) {

    $tree = [];

    sort($ratings);

    foreach ($ratings as $rating) {
        //debug("Rating : ".$rating);
        foreach ($ratings as $rating2) {
            $difference = $rating2 - $rating;
            if ($difference > 0 && $difference <= 3) {
                //debug("Adapter connection found: ".$rating2.", difference: ".$difference);
                $tree[$rating][$rating2] = $rating2;
            }
        }
    }

    return $tree;
}


function getRawRatings($inputFile) {
    return file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}


function debug($v) {
    //return;
    if (is_array($v)) {
        print_r($v);
    } else {
        var_dump($v);
    }
}
