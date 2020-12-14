<?php

// Solved in 24 minutes
$mem = [];
foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $action = substr($line, 0, 3);
    if ($action === 'mas') {
        list(,$mask) = explode(' = ', $line);
    } elseif ($action === 'mem') {
        if (preg_match('/^mem\[(\d+)\] = (\d+)$/', $line, $matches)) {
            $address = $matches[1];
            $value = $matches[2];
        } else {
            printf("bad memory instruction: %s\n", $line);
        }

        $addresses = getAddresses($mask, $address);
        foreach ($addresses as $address) {
            $mem[$address] = $value;
        }
    } else {
        printf("bad action: %s\n", $line);
    }
}

var_dump(array_sum($mem));

function getAddresses($mask, $value) {
    $valueBinStr = str_pad(decbin($value), 36, '0', STR_PAD_LEFT);

    $newValueStr = '';
    for ($i = 0; $i < 36; $i++) {
        $valueBitStr = substr($valueBinStr, $i, 1);
        $maskBitStr = substr($mask, $i, 1);

        if ($maskBitStr === 'X') {
            $newValueBitStr = 'X';
        } elseif ($maskBitStr === '0') {
            $newValueBitStr = $valueBitStr;
        } elseif ($maskBitStr === '1') {
            $newValueBitStr = '1';
        }
        $newValueStr .= $newValueBitStr;
    }

    return getPossibleAddresses($newValueStr);
}

function getPossibleAddresses($mask) {
    if (strpos($mask, 'X')===false) {
        return [bindec($mask)];
    }
    $addresses = [];

    $Xpositions = [];
    foreach (str_split($mask) as $charIndex => $char) {
        if ($char === 'X') {
            $Xpositions[] = $charIndex;
        }
    }

    for ($i = 0; $i < pow(2, count($Xpositions)); $i++) {
        $binI = str_pad(decbin($i), count($Xpositions), '0', STR_PAD_LEFT);
        $maskChars = str_split($mask);
        foreach ($Xpositions as $XIndex => $Xposition) {
            $maskChars[$Xposition] = substr($binI, $XIndex, 1);
        }
        $address = implode('', $maskChars);
        $addresses[] = bindec($address);
    }

    return $addresses;
}