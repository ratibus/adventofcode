<?php

$inputFile = __DIR__.'/input.txt';

$nbGoodPasswords = 0;
foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    list($lengths, $letter, $password) = explode(' ', $line);
    $letter = substr($letter, 0, 1);

    list($min, $max) = explode('-', $lengths);

    preg_match_all('/'.$letter.'/', $password, $matches);

    $nbLettersFound = count($matches[0] ?? []);

    if ($nbLettersFound >= $min && $nbLettersFound <= $max) {
        $nbGoodPasswords++;
    }
}
var_dump($nbGoodPasswords);