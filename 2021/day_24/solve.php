<?php

/*
Le code se compose de 14 blocs de 18 lignes identiques (seul a, b et c changent) :
 1: inp w
 2: mul x 0
 3: add x z   (on va appeler z1 la valeur initiale de z)
 4: mod x 26    x = z1 % 26
 5: div z a     z = z1 / a
 6: add x b  => x = (z1 % 26) + b
 7: eql x w  w = x => x = 1 sinon x = 0
 8: eql x 0  si x = 0, x = 1 sinon x = 0 équivalent à si x != w, x = 1 sinon x = 0
 9: mul y 0
10: add y 25
11: mul y x
12: add y 1  y = 25x + 1 (sachant que x = 0 ou 1)
13: mul z y  z = z*(25x +1)
14: mul y 0
15: add y w  y = w
16: add y c  y = w + c
17: mul y x  y = x*(w + c)
18: add z y  z = z*(25x +1) + x*(w + c)

Dans les données, a vaut soit 1, soit 26.
Quand a = 1 alors b >= 10, on a donc toujours x != w à la ligne 7 du coup x = 1 à la ligne 8 et donc z = 26 * z1 + w + c
(z1 représentant la valeur de z au début du bloc).
Vu que c est compris entre 1 et 13 et que w est compris entre 1 et 9, w + c varie entre 2 et 22, donc < 26.

Quand a = 26, alors b <= 0.
x vaut z1 % 26 à la ligne 4 donc vaut la valeur du w + c précédent.
On souhaite dans ces cas-là que x soit égal à 0 à la fin pour que z soit égal à z1 / 26.
Pour que x soit égal à 0, il faut que w = x (cf les lignes avant la ligne 8) que donc on doit avoir w2 = w1 + c1 + b2
(w1 et c1 étant les valeurs de w et c la précédente fois où a valait 1 et qui n'a pas déjà été "dépilée" par division).

Avec les données qu'on a ça donne :
w4 = w3 + c3 + b4
w5 = w2 + c2 + b5
w8 = w7 + c7 + b8
w9 = w6 + c6 + b9
w11 = w10 + c10 + b11
w12 = w1 + c1 + b12
w13 = w0 + c0 + b13

En remplaçant avec les valeurs de c et b respectives ça donne :
w4 = w3 + 10 - 11 = w3 - 1
w5 = w2 + 8 - 13 = w2 - 5
w8 = w7 + 5 - 3 = w7 + 3
w9 = w6 + 13 - 6 = w6 + 7
w11 = w10 + 2 + 0 = w10 + 2
w12 = w1 + 13 - 15 = w1 - 2
w13 = w0 + 8 - 4 = w0 + 4

Soit :
w4  = w3 - 1
w5  = w2 - 5
w8  = w7 + 3
w9  = w6 + 7
w11 = w10 + 2
w12 = w1 - 2
w13 = w0 + 4

Pour le nombre le + grand (pour la partie 1), on maximise les valeurs possibles en ayant comme contrainte que tous les
chiffres sont entre 1 et 9 (le 0 est interdit) :
w0 : 5
w1 : 9
w2 : 9
w3 : 9
w4 : 8
w5 : 4
w6 : 2
w7 : 6
w8 : 9
w9 : 9
w10 : 7
w11 : 9
w12 : 7
w13 : 9
Soit : 59998426997979

Pour le nombre le + petit (pour la partie 2), on minimise les valeurs possibles :
w0 : 1
w1 : 3
w2 : 6
w3 : 2
w4 : 1
w5 : 1
w6 : 1
w7 : 1
w8 : 4
w9 : 8
w10 : 1
w11 : 3
w12 : 1
w13 : 5
Soit : 13621111481315
*/

$code = file_get_contents(__DIR__.'/input.txt');
$codeLines = explode("\n", $code);

// Partie 1
$z = runCode($codeLines, str_split(59998426997979));
var_dump(59998426997979);

// Partie 2
$z = runCode($codeLines, str_split(13621111481315));
var_dump(13621111481315);

function runCode($instructions, $inputs) {
    $w = $x = $y = $z = 0;
    foreach ($instructions as $instruction) {

        $instructionParts = explode(' ', $instruction);

        if (isset($instructionParts[2])) {
            if (preg_match('/^-?\d+$/', $instructionParts[2])) {
                $right = $instructionParts[2];
            } else {
                $right = ${$instructionParts[2]};
            }
        }

        if ($instructionParts[0] === 'inp') {
            $input = array_shift($inputs);
            ${$instructionParts[1]} = $input;
        } elseif ($instructionParts[0] === 'add') {
            ${$instructionParts[1]} += $right;
        } elseif ($instructionParts[0] === 'mul') {
            ${$instructionParts[1]} *= $right;
        } elseif ($instructionParts[0] === 'div') {
            ${$instructionParts[1]} = floor(${$instructionParts[1]} / $right);
        } elseif ($instructionParts[0] === 'mod') {
            ${$instructionParts[1]} = ${$instructionParts[1]} % $right;
        } elseif ($instructionParts[0] === 'eql') {
            ${$instructionParts[1]} = ${$instructionParts[1]} == $right ? 1 : 0;
        } else {
            printf("Unknown instruction %d\n", $instructionParts[0]);
        }
    }
    return $z;
}
