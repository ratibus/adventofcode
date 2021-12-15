<?php

// Solved in 58 minutes

require_once (__DIR__.'/vendor/autoload.php');

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$map = [];

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$originalGridSize = count($lines);
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $cost) {
       for ($dx = 0; $dx < 5; $dx++) {
            for ($dy = 0; $dy < 5; $dy++) {
                $map[$y+$originalGridSize*$dy][$x+$originalGridSize*$dx] = ($cost + $dx + $dy - 1) % 9 + 1;
            }
        }
    }
}

$grid = new BlackScorp\Astar\Grid($map);
$astar = new BlackScorp\Astar\Astar($grid);
$nodes = $astar->search($grid->getPoint(0,0),$grid->getPoint(count($map)-1,count($map)-1));

$cost = 0;
foreach($nodes as $node){
    $cost += $map[$node->getY()][$node->getX()];
}
$cost -= $map[$nodes[0]->getY()][$nodes[0]->getX()];
var_dump($cost);