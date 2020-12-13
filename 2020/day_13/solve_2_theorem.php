<?php

/**
 * Ressources :
 * https://fr.wikipedia.org/wiki/Th%C3%A9or%C3%A8me_des_restes_chinois
 * https://www.youtube.com/watch?v=zIFehsBHB8o
 */
$lines = file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$solution = findTimestamp($lines[1]);
var_dump($solution);

function findTimestamp($rawBuses) {

    $buses = [];
    foreach (explode(',', $rawBuses) as $bIndex => $b) {
        if ($b !== 'x') {
            $buses[$bIndex] = $b;
        }
    }

    /**
     * On cherche t qui résout le système suivant :
     *     t ≡ - $bIndex mod $b
     * Pour l'ensemble des clés $bIndex et des valeurs $b du tableau $buses
     * On constate dans le jeu de données que tous les nombres communiqués sont premiers ce qui simplifie la résolution
     */
    $N = 1;
    foreach ($buses as $bus) {
        $N *= $bus;
    }

    $sum = 0;
    foreach ($buses as $bIndex => $bus) {
        $n = $N / $bus;

        for ($x = 0; $x < $bus; $x++) {
            if (($x * $n) % $bus === 1) {
                break;
            }
        }
        //printf("N: %d, b_i: %d, n_i: %d, x_i: %d, b_i*n_i*x_i: %d\n", $N, $bIndex, $n, $x, $bIndex * $n * $x);
        $sum += - $bIndex * $n * $x;
    }

    while ($sum < 0) {
        $sum += $N;
    }

    return $sum % $N;
}
