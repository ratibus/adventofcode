<?php

// Solved in 13 minutes
$inputFile = __DIR__.'/input.txt';

$passports = getRawPassports($inputFile);

debug($passports);

$nbValidPassports = 0;
foreach ($passports as $passport) {
    $rawFields = explode(' ', $passport);

    $fields = [];
    foreach ($rawFields as $rawField) {
        list($key, $value) = explode(':', $rawField);
        $fields[$key] = $value;
    }
    ksort($fields);

    $listFields = implode(array_keys($fields));

    if ($listFields === 'byrcidecleyrhclhgtiyrpid' || $listFields === 'byrecleyrhclhgtiyrpid') {
        $nbValidPassports++;
    }

    debug($fields);
}

var_dump($nbValidPassports);


function getRawPassports($inputFile) {

    $passports = [];

    $passport = '';
    foreach (file($inputFile, FILE_IGNORE_NEW_LINES) as $line) {
        if (strlen($line) == 0) {
            $passports[] = trim($passport);
            $passport = '';
            continue;
        }

        $passport .= ' '.$line;
    }
    $passports[] = trim($passport);

    return $passports;
}


function debug($v) {
    print_r($v);
}
