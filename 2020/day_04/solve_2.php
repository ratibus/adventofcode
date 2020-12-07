<?php

// Solved in 15 minutes
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

    $isValid = isPassportValid($fields);

    if ($isValid) {
        $nbValidPassports++;
    }
}

var_dump($nbValidPassports);

function isPassportValid($fields) {
    unset($fields['cid']);
    ksort($fields);

    $listFields = implode(array_keys($fields));

    if ($listFields !== 'byrecleyrhclhgtiyrpid') {
        return false;
    }

    /**
     * byr (Birth Year) - four digits; at least 1920 and at most 2002.
     * iyr (Issue Year) - four digits; at least 2010 and at most 2020.
     * eyr (Expiration Year) - four digits; at least 2020 and at most 2030.
     * hgt (Height) - a number followed by either cm or in:
     *   If cm, the number must be at least 150 and at most 193.
     *   If in, the number must be at least 59 and at most 76.
     * hcl (Hair Color) - a # followed by exactly six characters 0-9 or a-f.
     * ecl (Eye Color) - exactly one of: amb blu brn gry grn hzl oth.
     * pid (Passport ID) - a nine-digit number, including leading zeroes.
     */

    if ($fields['byr'] < 1920 || $fields['byr'] > 2002) {
        return false;
    }
    if ($fields['iyr'] < 2010 || $fields['iyr'] > 2020) {
        return false;
    }
    if ($fields['eyr'] < 2020 || $fields['eyr'] > 2030) {
        return false;
    }
    $heightUnit = substr($fields['hgt'], -2);
    if ($heightUnit !== 'cm' && $heightUnit !== 'in') {
        return false;
    }
    $height = substr($fields['hgt'], 0, strlen($fields['hgt'])-2);
    if ($heightUnit === 'cm' && ($height < 150 || $height > 193)) {
        return false;
    }
    if ($heightUnit === 'in' && ($height < 59 || $height > 76)) {
        return false;
    }
    if (!preg_match('/^#[0-9a-f]{6}$/', $fields['hcl'])) {
        return false;
    }
    if (!in_array($fields['ecl'], ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'], true)) {
        return false;
    }
    if (!preg_match('/^\d{9}$/', $fields['pid'])) {
        return false;
    }

    return true;
}

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
