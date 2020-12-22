<?php

// Solved in 20 minutes
$nbChars = 0;
$nbEvalChars = 0;
foreach (file(__DIR__.'/'.$argv[1], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
    $nbChars += strlen($line);

    $string = substr($line, 1, -1);
    $string = str_replace(['\\\\', '\\"'], ['\\', '"'], $string);
    $string = preg_replace_callback('/(\\\x[\da-f]{2})/', function ($matches) { return hex2bin(substr($matches[0], -2)); }, $string);
    $nbEvalChars += strlen($string);
}

var_dump($nbChars - $nbEvalChars);