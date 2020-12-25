<?php

// Solved in 22 minutes
$publicKeys = [5764801, 17807724]; // test data
$publicKeys = [17773298, 15530095];

$subjectNumber = 7;
$loopSizes = [];
foreach ($publicKeys as $publicKey) {
    $loopSize = 0;
    $value = 1;
    while (true) {
        $loopSize++;

        $value *= $subjectNumber;
        $value = $value % 20201227;

        if ($value === $publicKey) {
            printf("Public key: %s, loop size: %d\n", $publicKey, $loopSize);
            $loopSizes[$publicKey] = $loopSize;
            break;
        }
    }
}

$subjectNumber = $publicKeys[0];
$value = 1;
for ($i = 1; $i <= $loopSizes[$publicKeys[1]]; $i++) {
    $value *= $subjectNumber;
    $value = $value % 20201227;
}
var_dump($value);
