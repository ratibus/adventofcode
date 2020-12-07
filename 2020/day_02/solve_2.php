<?php

$inputFile = __DIR__.'/input.txt';

$nbGoodPasswords = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($positions, $letter, $password) = explode(' ', $line);
    $letter = substr($letter, 0, 1);

    list($position1, $position2) = explode('-', $positions);

    $nbLettersFound = 0;
    if (substr($password, $position1-1, 1)==$letter) {
        $nbLettersFound++;
    }
    if (substr($password, $position2-1, 1)==$letter) {
        $nbLettersFound++;
    }

    if ($nbLettersFound == 1) {
        $nbGoodPasswords++;
    }
}
var_dump($nbGoodPasswords);