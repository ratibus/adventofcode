<?php

// Solved in 48 minutes
$instructions = [];
foreach (file(__DIR__.'/'.$argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {

    if (preg_match('/^(\w+) -> (\w+)/', $line, $matches)) {
        $instructions[$matches[2]] = ['type' => 'input', 'src' => $matches[1]];
    } elseif (strpos($line, 'NOT ') === 0) {
        $infos = explode(' ', $line);
        $instructions[$infos[3]] = ['type' => 'NOT', 'src' => $infos[1]];
    } else {
        $infos = explode(' ', $line);
        if (strpos($infos[1], 'SHIFT') !== false) {
            $instructions[$infos[4]] = ['type' => $infos[1], 'value' => $infos[2], 'src' => $infos[0]];
        } else {
            $instructions[$infos[4]] = ['type' => $infos[1], 'src' => [$infos[0], $infos[2]]];
        }
    }
}

function compute($graph, $node, &$cache) {

    if (isset($cache[$node])) {
        return $cache[$node];
    }

    if (preg_match('/^\d+$/', $node)) {
        $cache[$node] = (int)$node;
        return (int)$node;
    }

    if ($graph[$node]['type'] === 'input') {
        $value = compute($graph, $graph[$node]['src'], $cache);
    } elseif ($graph[$node]['type'] === 'NOT') {
        $value = ~ compute($graph, $graph[$node]['src'], $cache);
    } elseif ($graph[$node]['type'] === 'AND') {
        $value = compute($graph, $graph[$node]['src'][0], $cache) & compute($graph, $graph[$node]['src'][1], $cache);
    } elseif ($graph[$node]['type'] === 'OR') {
        $value = compute($graph, $graph[$node]['src'][0], $cache) | compute($graph, $graph[$node]['src'][1], $cache);
    } elseif ($graph[$node]['type'] === 'LSHIFT') {
        $value = compute($graph, $graph[$node]['src'], $cache) << $graph[$node]['value'];
    } elseif ($graph[$node]['type'] === 'RSHIFT') {
        $value = compute($graph, $graph[$node]['src'], $cache) >> $graph[$node]['value'];
    }

    $cache[$node] = $value;
    return $value;
}

$cache = [];
var_dump(compute($instructions, 'a', $cache));