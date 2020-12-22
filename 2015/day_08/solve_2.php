<?php

// Solved in 6 minutes
$nbChars = 0;
$nbEncodedChars = 0;
foreach (file(__DIR__.'/'.$argv[1], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
    $nbChars += strlen($line);

    $string = $line;
    $string = str_replace(['\\'], ['\\\\'], $string);
    $string = str_replace(['"'], ['\\"'], $string);
    $string = '"'.$string.'"';
    $nbEncodedChars += strlen($string);
}

var_dump($nbEncodedChars - $nbChars);