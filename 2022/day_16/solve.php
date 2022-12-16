<?php

$inputFile = __DIR__.'/input.txt';

$content = file_get_contents($inputFile);

preg_match_all('/Valve (.*) has flow rate=(.*); tunnel.? lead.? to valve.? (.*)/', $content, $matches, PREG_SET_ORDER);

$valves = [];
$edges = [];
$usefulValves = [];
foreach ($matches as $match) {
    list(, $valve, $flowrate, $destinations) = $match;
    $valves[$valve] = (int)$flowrate;

    if ($valves[$valve] > 0) {
        $usefulValves[$valve] = $valve;
    }
    foreach (explode(', ', $destinations) as $destination) {
        $edges[$valve][$destination] = $destination;
    }
}

$distances = [];
$valvesToCompute = array_merge(['AA'], $usefulValves);
foreach ($valvesToCompute as $usefulValf1) {
    foreach ($valvesToCompute as $usefulValf2) {
        if ($usefulValf1 === $usefulValf2) {
            continue;
        }
        $distances[$usefulValf1][$usefulValf2] = bfs($edges, $usefulValf1, $usefulValf2);
    }
}

// Part 1
$maxOutput = 0;
explore('AA', $valves, $distances, 30, [], $usefulValves);
var_dump($maxOutput);

function explore($node, $valves, $distances, $timeRemaining, $openedValves, $usefulValves) {

    global $maxOutput;

    // We open the valve if useful
    if ($valves[$node] > 0 && !isset($openedValves[$node])) {
        $timeRemaining--;
        $openedValves[$node] = $timeRemaining;
    }

    $neighbours = !isset($distances[$node]) || count($usefulValves) === count($openedValves) ? [] : $distances[$node];
    foreach ($neighbours as $neighbour => $distance) {
        if ($timeRemaining < $distance || isset($openedValves[$neighbour]) || $neighbour === 'AA') {
            continue;
        }
        explore($neighbour, $valves, $distances, $timeRemaining - $distance, $openedValves, $usefulValves);
    }

    $totalFlow = 0;
    foreach ($openedValves as $openedValf => $duration) {
        $totalFlow += $duration * $valves[$openedValf];
    }
    $maxOutput = max($maxOutput, $totalFlow);
}

function bfs($edges, $start, $end) {

    $explored = [$start => true];
    $queue = [[$start, 0]];
    while (count($queue)) {
        $node = array_shift($queue);

        if ($node[0] === $end) {
            return $node[1];
        }

        foreach ($edges[$node[0]] as $neighbour) {
            if (isset($explored[$neighbour])) {
                continue;
            }
            $queue[] = [$neighbour, $node[1]+1];
            $explored[$neighbour] = true;
        }
    }

    return null;
}