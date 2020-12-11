<?php

//Solved in 20 seconds
$secret = file_get_contents(__DIR__.'/input.txt');

$i = 0;

while(true) {
    $i++;
    $md5 = md5($secret.$i);
    //var_dump($md5);
    $prefix = substr($md5, 0, 6);
    //var_dump($prefix);

    if ($prefix === '000000') break;
}

var_dump($i);