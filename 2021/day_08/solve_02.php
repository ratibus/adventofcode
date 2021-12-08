<?php

// Solved in 56 minutes

// 7 segments display naming scheme:
//
//  aaaa
// b    c
// b    c
//  dddd
// e    f
// e    f
//  gggg

// 0 => 6 segments
// 1 => 2 segments => unique
// 2 => 5 segments
// 3 => 5 segments
// 4 => 4 segments => unique
// 5 => 5 segments
// 6 => 6 segments
// 7 => 3 segments => unique
// 8 => 7 segments => unique
// 9 => 6 segments

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

$lines = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$segmentsToDigit = [
    'abcefg' => 0,
    'cf' => 1,
    'acdeg' => 2,
    'acdfg' => 3,
    'bcdf' => 4,
    'abdfg' => 5,
    'abdefg' => 6,
    'acf' => 7,
    'abcdefg' => 8,
    'abcdfg' => 9,
];

$total = 0;
foreach ($lines as $lineIndex => $line) {
    list ($digits, $outputValues) = explode(' | ', $line);
    $digits = explode(' ', $digits);
    $outputValues = explode(' ', $outputValues);

    $digitsToInputString = [];
    foreach ($digits as $digit) {
        if (strlen($digit) === 2) {
            $digitsToInputString[1] = $digit;
        } elseif (strlen($digit) === 4) {
            $digitsToInputString[4] = $digit;
        } elseif (strlen($digit) === 3) {
            $digitsToInputString[7] = $digit;
        } elseif (strlen($digit) === 7) {
            $digitsToInputString[8] = $digit;
        }
    }

    $charsByOccurences = array_fill_keys(str_split('abcdefg'), 0);
    foreach ($digits as $digit) {
        foreach (str_split($digit) as $char) {
            $charsByOccurences[$char]++;
        }
    }
    $occurencesByChars = array_fill_keys([4,6,7,8,9], '');
    foreach ($charsByOccurences as $char => $nb) {
        $occurencesByChars[$nb] .= $char;
    }

    $segments = [
        'e' => $occurencesByChars[4], // The "e" segment is the only segment present 4 times among the 10 digits
        'f' => $occurencesByChars[9], // The "f" segment is the only segment present 9 times among the 10 digits
        'b' => $occurencesByChars[6], // The "b" segment is the only segment present 6 times among the 10 digits
    ];

    // digit "1" is displayed with "cf" segments. We just identified "f" segment, so "c" segment is easy to find.
    $segments['c'] = str_replace($occurencesByChars[9], '', $digitsToInputString[1]);

    // "a" and "c" segments are the only segments with 8 usages. We just found "c" segment, so "a" segment is easy to find.
    $segments['a'] = str_replace($segments['c'], '', $occurencesByChars[8]);

    // digit "1" is displayed with "bcdf" segments. We found "bcf" segments, so "b" is easy to find
    $segments['d'] = str_replace([$segments['b'], $segments['c'], $segments['f']] , '', $digitsToInputString[4]);

    // "g" segment is the remaining segment
    $segments['g'] = str_replace($segments, '', 'abcdefg');

    $translationMap = array_flip($segments);
    $outputValue = '';
    foreach ($outputValues as $outputValueDigit) {
        // Translate letters to segment "standard" letters with the translationMap
        $standardOutputValue = strtr($outputValueDigit, $translationMap);

        // Sort letters
        $chars = str_split($standardOutputValue);
        sort($chars);
        $sortedStandardOutputValue = implode('', $chars);

        // Find the right matching digit
        $digit = $segmentsToDigit[$sortedStandardOutputValue];
        $outputValue .= $digit;
    }
    $total += intval($outputValue);
}
var_dump($total);
