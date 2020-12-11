<?php

//Solved in 4 minutes
$secret = file_get_contents(__DIR__.'/input.txt');

$i = 0;

while(true) {
    $i++;
    $md5 = md5($secret.$i);
    //var_dump($md5);
    $prefix = substr($md5, 0, 5);
    //var_dump($prefix);

    if ($prefix === '00000') break;
}

var_dump($i);