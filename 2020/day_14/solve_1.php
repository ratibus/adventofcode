<?php

// Solved in 25 minutes
$mem = [];
foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $action = substr($line, 0, 3);
    if ($action === 'mas') {
        list(,$mask) = explode(' = ', $line);
    } elseif ($action === 'mem') {
        if (preg_match('/^mem\[(\d+)\] = (\d+)$/', $line, $matches)) {
            $slot = $matches[1];
            $value = $matches[2];
        } else {
            printf("bad memory instruction: %s\n", $line);
        }

        $maskedValue = applyMask($mask, $value);
        $mem[$slot] = $maskedValue;
    } else {
        printf("bad action: %s\n", $line);
    }
}

var_dump(array_sum($mem));

function applyMask($mask, $value) {
    $valueBinStr = str_pad(decbin($value), 36, '0', STR_PAD_LEFT);

    $newValueStr = '';
    for ($i = 0; $i < 36; $i++) {
        $valueBitStr = substr($valueBinStr, $i, 1);
        $maskBitStr = substr($mask, $i, 1);

        if ($maskBitStr === 'X') {
            $newValueBitStr = $valueBitStr;
        } else {
            $newValueBitStr = $maskBitStr;
        }
        $newValueStr .= $newValueBitStr;
    }

    return bindec($newValueStr);
}
